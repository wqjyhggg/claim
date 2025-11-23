<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Jack
 */
class Emergency_assistance extends CI_Controller {
	private $limit = 10;
	private $notes_dealy = 900;	// seconds
	
	public function __construct() {
		parent::__construct();
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the emergency assistance page
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_EAC, Users_model::GROUP_CLAIMER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('country_model');
			$this->load->model('province_model');
			
			// initialize variables
			$this->data['cases'] = [];
			$this->data['policies'] = [];
			$this->data['manager_id'] = $this->input->get("manager_id");
			
			// search case filter
			if ($this->input->get("filter") == 'case') {
				$this->load->model('case_model');
				$this->data['cases'] = $this->case_model->post_search($this->input->get());
			} else if ($this->input->get("filter") == 'policy') {
				// prepare post data array
				$this->data['params'] = $this->input->get();
				
				$this->load->model('api_model');
				$this->load->model('claim_model');
				
				$this->data['policies'] = $this->api_model->get_policy($this->data['params']);
				$this->data['status'] = $this->api_model->status_list;
				
				foreach ( $this->data['policies'] as $k => $pl ) {
					if ($this->claim_model->search(array('policy_no' => $pl['policy']))) {
						$this->data['policies'][$k]['has_claim'] = 1;
					} else {
						$this->data['policies'][$k]['has_claim'] = 0;
					}
				}
			}
			
			// send case manager and eac managers list
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1), 100);
			// send countries and province list
			$this->data['country'] = $this->country_model->get_list(TRUE);
			$this->data['province'] = $this->province_model->get_list_by_country_short('CA');
			
			$this->data['policy_status'] = $this->common_model->get_policy_status($field_name = "status_id", $selected = $this->input->get($field_name));
			$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->get($field_name));

			// render view data
			$this->template->write('title', SITE_TITLE . ' - View Edit Emergency Assistance Case', TRUE);
			$this->template->write_view('content', 'emergency_assistance/index', $this->data);
			$this->template->render();
		}
	}
	
	// custom name validation
	function alpha_dash_space($fullname) {
		if (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	function positive_number($num) {
		if ($num >= 0) {
			return TRUE;
		}
		$this->form_validation->set_message('positive_number', 'The %s field is mandatory');
		return FALSE;
	}
	
	// redirect if needed, otherwise display the create case page
	public function create_case($id = 0) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			if ($this->input->post('product_short') && !$this->users_model->verify_users_product($this->input->post('product_short'))) {
				show_error("Sorry, you don't have permission to create this product's case.");
			}
				
			$this->load->model('case_model');
			$this->load->model('api_model');
			$this->load->model('intakeform_model');
			$this->load->model('currency_model');
			$this->load->model('country_model');
			$this->load->model('province_model');
			$this->load->model('reasons_model');
			$this->load->model('relations_model');
			$this->load->model('mytask_model');
				
			// validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', '');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('last_name', 'Last Name', 'callback_alpha_dash_space');
			$this->form_validation->set_rules('phone_number', 'Phone', 'required|trim|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('post_code', 'Postal Code', 'required|trim|max_length[15]|min_length[4]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('relations', 'Relations', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('incident_date', 'Incident Date', 'required');
			
			$this->form_validation->set_rules('insured_firstname', 'Insured First Name', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			
			$this->form_validation->set_rules('reserve_amount', 'Reserve Amount', 'numeric|required|callback_positive_number');
			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				foreach ( $array as $key => $value ) {
					// code...
					if (!strpos($key, "otes_") && $key != "no_of_form") {
						$data[$key] = $value;
					}
						
					// for check third party recovery
					if ($key == 'third_party_recovery') {
						$data[$key] = $value ? $value : "N";
					}
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->get_user_id();
				if (empty($data['case_manager'])) {
					$data['case_manager'] = $this->mytask_model->get_auto_assign_manager_id();
				
				}
				if (empty($data['assign_to'])) {
					$data['assign_to'] = $data['case_manager'];
				}
				$data['init_manager'] = $data['case_manager'];
				
				$this->load->model('master_model');
				$data['id'] = $this->master_model->get_id('case'); // Get new id
				$data['case_no'] = $case_no = $this->case_model->generate_case_no($data['id']);

        $policy_info_arr = $this->api_model->get_policy(array('policy' => $data['policy_no']));

				if (empty($policy_info_arr)) {
					return show_error('Unknown policy for this Claim' . $data['policy_no'] . '.');
				}
        $data['sum_insured'] = $policy_info_arr[0]['sum_insured'];
				
				// insert values to database
				$record_id = $this->case_model->save($data);
				
				$record_id = $data['id'];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				// $config['max_size'] = '*';
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				
				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];
				if ($no_of_form) {
					// add intake form batch
					for($i = 1; $i <= $no_of_form; $i++) {
						// initialize file names array
						$file_names = [];
						
						// upload files to server
						$files = @$_FILES['files_' . $i];
						if (!empty($files)) {
							foreach ( $files['name'] as $key => $value ) {
								if ($files['name'][$key]) {
									$_FILES['userfile']['name'] = $files['name'][$key];
									$_FILES['userfile']['type'] = $files['type'][$key];
									$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
									$_FILES['userfile']['error'] = $files['error'][$key];
									$_FILES['userfile']['size'] = $files['size'][$key];
									
									$field_name = 'userfile';
									
									// upload file to server
									$this->upload->do_upload();
									$file_data = $this->upload->data();
									$file_names[] = $file_data['file_name'];
								}
							}
						}
						
						// generate data array
						$data_intake = array(
								'case_id' => $record_id,
								'created_by' => $this->ion_auth->get_user_id(),
								'notes' => $array['notes_' . $i],
								'phonefile' => $array['phonefile_' . $i],
								'created' => date("Y-m-d H:i:s"),
								'docs' => implode(",", $file_names) 
						);
						
						// save values to database
						$intake_form_id = $this->intakeform_model->save($record_id, $array['notes_' . $i], implode(",", $file_names), $array['phonefile_' . $i]);
						
						// create directory to identify intake files
						@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
						
						// move all files to that directory
						
						if (!empty($file_names)) {
							foreach ( $file_names as $fname ) {
								copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "intake_forms/$fname");
							}
						}
					}
				}
				$new_case = $this->case_model->get_by_id($record_id);

				if ($new_case['case_manager']) {
					$new_task = array();
					$new_task['user_id'] = $new_case['case_manager'];
					$new_task['item_id'] = $new_case['id'];
					$new_task['task_no'] = $new_case['case_no'];
					$new_task['category'] = Mytask_model::CATEGORY_ASSISTANCE;
					$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
					$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
					$new_task['type'] = Mytask_model::TASK_TYPE_CASE;
					$new_task['priority'] = $new_case['priority'];
					$new_task['created_by'] = $this->ion_auth->get_user_id();
					$new_task['created'] = date("Y-m-d H:i:s");
					$new_task['user_type'] = Mytask_model::USER_TYPE_MANAGER;
					$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
					$new_task['notes'] = "New Case Assign";
								
					$this->mytask_model->save($new_task);
				}
				
				/*
				if ($new_case['assign_to'] && ($new_case['assign_to'] != $new_case['case_manager'])) {
					$new_task = array();
					$new_task['user_id'] = $new_case['assign_to'];
					$new_task['item_id'] = $new_case['id'];
					$new_task['task_no'] = $new_case['case_no'];
					$new_task['category'] = Mytask_model::CATEGORY_ASSISTANCE;
					$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
					$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
					$new_task['type'] = Mytask_model::TASK_TYPE_CASE;
					$new_task['priority'] = $new_case['priority'];
					$new_task['created_by'] = $this->ion_auth->get_user_id();
					$new_task['created'] = date("Y-m-d H:i:s");
					$new_task['user_type'] = Mytask_model::USER_TYPE_EAC;
					$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
					$new_task['notes'] = "New Case Assign";
								
					$this->mytask_model->save($new_task);
				}
				*/

				// send success message
				$this->session->set_flashdata('success', "Case successfully created");
				
				// redirect them to the login page
				redirect('emergency_assistance/edit_case/'.$record_id, 'refresh');
			} else {
				$case_details = array();
				$case_details['policy_no'] = '';
				$case_details['totaldays'] = '';
				$case_details['agent_id'] = '';
				$case_details['product_short'] = '';
				$case_details['insured_firstname'] = '';
				$case_details['insured_lastname'] = '';
				$case_details['dob'] = '';
				$case_details['gender'] = 'male';
				$case_details['departure_date'] = '';
				$case_details['created_by'] = '';
				$case_details['street_no'] = '';
				$case_details['street_name'] = '';
				$case_details['suite_number'] = '';
				$case_details['city'] = '';
				$case_details['province'] = 'ON';
				$case_details['post_code'] = '';
				$case_details['assign_to'] = '';
				$case_details['reason'] = '';
				$case_details['first_name'] = '';
				$case_details['last_name'] = '';
				$case_details['phone_number'] = '';
				$case_details['email'] = '';
				$case_details['place_of_call'] = '';
				$case_details['incident_date'] = '';
				$case_details['relations'] = '';
				$case_details['addmission_date'] = '';
				$case_details['discharge_date'] = '';
				$case_details['room_number'] = '';
				$case_details['account_number'] = '';
				$case_details['hospital_charge'] = '';
				$case_details['doctor_first_name'] = '';
				$case_details['doctor_last_name'] = '';
				$case_details['doctor_address'] = '';
				$case_details['doctor_city'] = '';
				$case_details['doctor_post_code'] = '';
				$case_details['doctor_phone'] = '';
				$case_details['outpatient_provider'] = '';
				$case_details['outpatient_federal_tax'] = '';
				$case_details['outpatient_facility'] = '';
				$case_details['outpatient_physician'] = '';
				$case_details['outpatient_address1'] = '';
				$case_details['outpatient_address2'] = '';
				$case_details['outpatient_city'] = '';
				$case_details['outpatient_post_code'] = '';
				$case_details['outpatient_phone'] = '';
				$case_details['outpatient_fax'] = '';
				$case_details['diagnosis'] = '';
				$case_details['treatment'] = '';
				$case_details['third_party_recovery'] = '';
				$case_details['medical_notes'] = '';
				$case_details['case_manager'] = '';
				$case_details['priority'] = '';
				$case_details['reserve_amount'] = '-1';
				
				$this->data['policy'] = array();
				$this->data['show_expiry'] = 0;
				if (empty($case_details['policy_no'])) {
					$policy = $this->input->get('policy');
					if (!empty($policy)) {
						if ($policies = $this->api_model->get_policy(array('policy' => $policy))) {
							$this->data['policy'] = $policies[0];
							$case_details['policy_no'] = $this->data['policy']['policy'];
							$case_details['product_short'] = $this->data['policy']['product_short'];
							$case_details['street_no'] = $this->data['policy']['street_number'];
							$case_details['street_name'] = $this->data['policy']['street_name'];
							$case_details['suite_number'] = $this->data['policy']['suite_number'];
							$case_details['city'] = $this->data['policy']['city'];
							$case_details['province'] = $this->data['policy']['province2'];
							$case_details['country2'] = $this->data['case_details']['country2'] = $this->data['policy']['country2'];
							$case_details['country'] = $this->data['case_details']['country'] = $this->data['policy']['country2'];
							$case_details['province'] = $this->data['case_details']['province'] = $this->data['policy']['province2'];
							$case_details['post_code'] = $this->data['case_details']['post_code'] = $this->data['policy']['postcode'];
							if (!$this->users_model->verify_users_product($case_details['product_short'])) {
								show_error("Sorry, you don't have permission to create this product's case.");
							}
							$case_details['insured_firstname'] = $this->input->get('firstname');
							$case_details['insured_lastname'] = $this->input->get('lastname');
							$case_details['dob'] = $this->input->get('birthday');
							$case_details['gender'] = ($this->input->get('gender')=='F') ? 'female' : 'male';
						}
					} else {
						$case_details['country2'] = $this->data['case_details']['country2'] = 'CA';
						$case_details['country'] = $this->data['case_details']['country2'] = 'CA';
						$case_details['province'] = $this->data['case_details']['province'] = 'ON';
					}
				} else {
					if ($policies = $this->api_model->get_policy(array('policy' => $case_details['policy_no']))) {
						$this->data['policy'] = $policies[0];
						if (!$this->users_model->verify_users_product($this->data['policy']['product_short'])) {
							show_error("Sorry, you don't have permission to create this product's case.");
						}
					}
					$case_details['country2'] = $this->data['case_details']['country2'] = 'CA';
					$case_details['country'] = $this->data['case_details']['country2'] = 'CA';
					$case_details['province'] = $this->data['case_details']['province'] = 'ON';
				}
        if ($this->data['policy']) {
          $expiretm = strtotime($this->data['policy']["expiry_date"]);
          if ($expiretm > time()) {
            $this->data['show_expiry'] = 1;
          }
        }
				
				// load dropdowns data
				$this->data['country'] = $this->data['country2'] = $this->country_model->get_list(TRUE);
				$this->data['provinces'] = $this->province_model->get_list_by_country_short(isset($case_details['country']) ? $case_details['country'] : 'CA');
				
				// Load model if needs
				
				$vdata = array();
				$vdata['name'] = 'inpatient_currency';
				$vdata['options'] = $this->currency_model->get_list();
				$vdata['selected'] = 'CAD';
				$this->data['inpatient_currency'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'doctor_country';
				$vdata['options'] = $this->country_model->get_list(1);
				$vdata['selected'] = 'CA';
				$vdata['loadurl'] = base_url('utility/province/doctor_province/');
				$vdata['depended'] = 'doctor_province';
				$this->data['doctor_country'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'doctor_province';
				$vdata['options'] = $this->province_model->get_list_by_country_short('CA');
				$vdata['selected'] = 'ON';
				$vdata['loadurl'] = '';
				$this->data['doctor_province'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'outpatient_country';
				$vdata['options'] = $this->country_model->get_list(1);
				$vdata['selected'] = 'CA';
				$vdata['loadurl'] = base_url('utility/province/outpatient_province/');
				$vdata['depended'] = 'outpatient_province';
				$this->data['outpatient_country'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'outpatient_province';
				$vdata['options'] = $this->province_model->get_list_by_country_short('CA');
				$vdata['selected'] = 'ON';
				$vdata['loadurl'] = '';
				$this->data['outpatient_province'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
				
				$this->data['reasons'] = $this->reasons_model->get_list2();
				$this->data['relationships'] = $this->relations_model->get_list();
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name), FALSE, FALSE); // XXXXXXXXXXXXXXXXXXXx
				
				$post = $this->input->post();
				if (is_array($post) && (sizeof($post) > 1)) {
					$case_details = array_merge($case_details, $post);
				}
				$this->data['case_details'] = $case_details;
				$this->data['priorities'] = $this->mytask_model->get_priorities();
				$this->data['phone_list_url'] = base_url('phone/search');
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Case', TRUE);
				$this->template->write_view('content', 'emergency_assistance/create_case', $this->data);
				$this->template->render();
			}
		}
	}
	
  public function export_case_info($case_id) {
    $this->load->model('api_model');
    $this->load->model('case_model');
    $this->load->model('product_model');

    $case = $this->case_model->get_by_id($case_id);
    if (empty($case)) {
      return show_error('Unknown Case.');
    }
    $product_name = $this->product_model->get_full_name($case["product_short"]);
    if (empty($product_name)) {
      $product_name = $case["product_short"];
    }
    $policy_info_arr = $this->api_model->get_policy(array('policy' => $case['policy_no']));
    if (empty($policy_info_arr)) {
      return show_error('Unknown policy for this case, ' . $case['policy_no'] . '.');
    }
    $policy = $policy_info_arr;
    if (empty($policy)) {
      return show_error('Unknown policy ' . $case['policy_no'] . '.');
    }
    $plan = $policy[0];
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="case_'.$case_id.'.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ["Claimant/Insured's Name", $case["first_name"] . " " . $case["last_name"]]);
    fputcsv($output, ["Date of Birth/Age/Sex", $case["dob"] . "/" . (intval(substr($plan["apply_date"], 0, 4)) - intval(substr($case["dob"], 0, 4))) . "/" . ucfirst($case["gender"])]);
    fputcsv($output, ["Case Number", $case["case_no"]]);
    fputcsv($output, ["Other Claims (related or unrelated)", "No"]);
    fputcsv($output, ["Policy Number", $case["policy_no"]]);
    fputcsv($output, ["Product", $product_name]);
    fputcsv($output, ["Plan Type", empty($plan["isfamilyplan"])?"Individual":"Family"]);
    fputcsv($output, ["Date of Application/Issue (if applicable)", $case["init_reserve_tm"]]);
    fputcsv($output, ["Coverage Period", $plan["effective_date"] . " to " . $plan["expiry_date"]]);
    fputcsv($output, ["Travel Dates", $plan["arrival_date"]]);
    fputcsv($output, ["Travel Destination", $case["city"] . " " . $case["province"]]);
    fputcsv($output, ["Date of Loss", $case["incident_date"]]);
    fputcsv($output, ["Reserve Amount", $case["reserve_amount"]]);
    $YesArr = ["JES", "JESP", "JFGD", "JFOS", "JFP", "JFPL", "TCS", "BHS"];
    $NoArr = ["JFS", "JFSL"];
    $TOPArr = ["TOP", "TOPN"];
    if (in_array($plan["product_short"], $YesArr)) {
      fputcsv($output, ["Pre-existing Condition Period", "Yes"]);
    } else if (in_array($plan["product_short"], $NoArr)) {
      fputcsv($output, ["Pre-existing Condition Period", "No"]);
    } else if (in_array($plan["product_short"], $TOPArr)) {
      fputcsv($output, ["Pre-existing Condition Period", ($plan["stable_condition"] == 1)?"Including":(($plan["stable_condition"] == 2)?"Excludes":" ")]);
    } else {
      fputcsv($output, ["Pre-existing Condition Period", ($plan["stable_condition"] == 1)?"Yes":(($plan["stable_condition"] == 2)?"No":" ")]);
    }
    fclose($output);
    exit();
	}

	// redirect if needed, otherwise display the edit case page
	public function edit_case($id = 0) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('intakeform_model');
			$this->load->model('mytask_model');
			$this->load->model('case_model');
			
			$case_details = $this->case_model->get_by_id($id);
			if ($case_details && $case_details['case_manager']) {
				$case_manager = $this->users_model->get_by_id($case_details['case_manager']);
				if ($case_manager) {
					$case_details['case_manager_name'] = $case_manager['first_name'] . " " . $case_manager['last_name'];
					$case_details['case_manager_email'] = $case_manager['email'];
				}
			}
			
			// validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', '');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('last_name', 'Last Name', 'callback_alpha_dash_space');
			$this->form_validation->set_rules('phone_number', 'Phone', 'required|trim|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('relations', 'Relations', 'required');
			$this->form_validation->set_rules('post_code', 'Postal Code', 'required|trim|max_length[9]|min_length[5]');
			$this->form_validation->set_rules('incident_date', 'Incident Date', 'required');
			
			$this->form_validation->set_rules('insured_firstname', 'Insured First Name', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			
			$this->form_validation->set_rules('priority', 'Priority', 'required');
			
			$this->form_validation->set_rules('reserve_amount', 'Reserve Amount', 'numeric|required|callback_positive_number');
			
			if ($this->form_validation->run() == TRUE) {
				if ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) {
					return show_error('Sorry, you don\'t have any permission to edit.');
				}
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				foreach ( $array as $key => $value ) {
					// code...
					$data[$key] = $value;
					
					// for check third party recovery
					if ($key == 'third_party_recovery') {
						$data[$key] = $value ? $value : "N";
					}
				}
				
				$data['id'] = $id;
				// insert values to database

				$this->case_model->save($data);
				
				$new_case = $this->case_model->get_by_id($id);
				
				if ($new_case != $case_details) {
					$notes = '';
					foreach ($new_case as $key => $val) {
						if (($val != $case_details[$key]) && !empty($val) && !empty($case_details[$key]) && ($key !== 'last_update')){
							$notes .= $key . "[" . $case_details[$key] . "][" . $val . "]; ";
						}
					}
					if ($notes) {
						$this->intakeform_model->save($id, $notes, '', '', 0, Mytask_model::TASK_TYPE_CASE_CHANGE);
					}
				}
				
				if ($new_case['case_manager'] && ($case_details['case_manager'] != $new_case['case_manager'])) {
					$tasks = $this->mytask_model->search(array('item_id' => $new_case['id'], 'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE, 'user_type' => Mytask_model::USER_TYPE_MANAGER));
					$new_task = array();
					if ($tasks) {
						// Change manager
						$new_task['id'] = $tasks[0]['id'];
						$new_task['user_id'] = $new_case['case_manager'];
						$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
						$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
						$new_task['priority'] = $new_case['priority'];
						$new_task['status'] = Mytask_model::STATUS_REASSIGNED;
						$new_task['finished'] = 0;
						$new_task['notes'] = "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $tasks[0]['notes'];
					} else {
						// Assign manager
						$new_task['user_id'] = $new_case['case_manager'];
						$new_task['item_id'] = $new_case['id'];
						$new_task['task_no'] = $new_case['case_no'];;
						$new_task['category'] = Mytask_model::CATEGORY_ASSISTANCE;
						$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
						$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
						$new_task['type'] = Mytask_model::TASK_TYPE_CASE;
						$new_task['priority'] = $new_case['priority'];
						$new_task['created_by'] = $this->ion_auth->get_user_id();
						$new_task['created'] = date("Y-m-d H:i:s");
						$new_task['user_type'] = Mytask_model::USER_TYPE_MANAGER;
						$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
						$new_task['notes'] = "New Assign";
					}
					$this->mytask_model->save($new_task);
				}

				if ($new_case['assign_to'] && ($case_details['assign_to'] != $new_case['assign_to'])) {
					$tasks = $this->mytask_model->search(array('item_id' => $new_case['id'], 'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE, 'user_type' => Mytask_model::USER_TYPE_EAC));
					// assign eac
					$new_task = array();
					if ($tasks) {
						// Change EAC
						$new_task['id'] = $tasks[0]['id'];
						$new_task['user_id'] = $new_case['assign_to'];
						$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
						$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
						$new_task['priority'] = $new_case['priority'];
						$new_task['status'] = Mytask_model::STATUS_REASSIGNED;
						$new_task['finished'] = 0;
						$new_task['notes'] = "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $tasks[0]['notes'];
					} else {
						$new_task['user_id'] = $new_case['assign_to'];
						$new_task['item_id'] = $new_case['id'];
						$new_task['task_no'] = $new_case['case_no'];;
						$new_task['category'] = Mytask_model::CATEGORY_ASSISTANCE;
						$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
						$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
						$new_task['type'] = Mytask_model::TASK_TYPE_CASE;
						$new_task['priority'] = $new_case['priority'];
						$new_task['created_by'] = $this->ion_auth->get_user_id();
						$new_task['created'] = date("Y-m-d H:i:s");
						$new_task['user_type'] = Mytask_model::USER_TYPE_EAC;
						$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
						$new_task['notes'] = "New Assign";
					}
					$taks_id = $this->mytask_model->save($new_task);
				}
				// send success message
				$this->session->set_flashdata('success', "Case successfully updated");
				
				// redirect them to the login page
				redirect('emergency_assistance/edit_case/'.$id, 'refresh');
			} else {
//				echo validation_errors(); //XXXXXXXXXXXXXXXX
//				die("X2"); //XXXXXXXXXXXXXXXXXXX
				
				$this->data['case_details'] = $case_details;
				if (empty($case_details)) {
					// send error message
					$this->session->set_flashdata('error', "Something went wrong, please try after some time.");
					
					// redirect them to the list page
					redirect('emergency_assistance', 'refresh');
				}
				
				$this->load->model('api_model');
				$this->load->model('country_model');
				$this->load->model('province_model');
				$this->load->model('currency_model');
				$this->load->model('reasons_model');
				$this->load->model('relations_model');
				$this->load->model('Intakeform_model');
				$this->load->model('template_model');
				$this->load->model('schedule_model');
				$this->load->model('product_model');
				
				$this->data['policy'] = array();
				$this->data['hasclaim'] = array();
				
				if (empty($case_details)) {
					$policy = $this->input->get('policy');
					if (!empty($policy)) {
						if ($policies = $this->api_model->get_policy(array(
								'policy' => $policy 
						))) {
							$this->data['policy'] = $policies[0];
							$this->data['case_details']['street_no'] = $this->data['policy']['street_number'];
							$this->data['case_details']['street_name'] = $this->data['policy']['street_name'];
							$this->data['case_details']['suite_number'] = $this->data['policy']['suite_number'];
							$this->data['case_details']['province'] = $this->data['policy']['province2'];
							$case_details['country2'] = $this->data['case_details']['country2'] = $this->data['policy']['country2'];
							$case_details['country'] = $this->data['case_details']['country'] = $this->data['policy']['country2'];
							$case_details['province'] = $this->data['case_details']['province'] = $this->data['policy']['province2'];
							$this->data['case_details']['post_code'] = $this->data['policy']['postcode'];
						}
					}
				} else {
					$this->load->model('claim_model');
					if ($policies = $this->api_model->get_policy(array(
							'policy' => $case_details['policy_no'] 
					))) {
						$this->data['policy'] = $policies[0];
					}
					$this->data['hasclaim'] = $this->claim_model->get_by_id($case_details['id']);
				}
				if ($this->data['policy'] && isset($this->data['policy']['effective_date'])) {
					$this->data['customer_ages'] = round((strtotime($this->data['policy']['effective_date']) - strtotime($this->data['case_details']["dob"])) / (3600*24*365.25));
				} else {
					$this->data['customer_ages'] = -1;
				}
				
				$this->data['assign_to_name'] = '-';
				$this->data['assign_to_email'] = 'N / A';
				if ($users = $this->users_model->search(array('id' => $case_details['assign_to']))) {
					$this->data['assign_to_name'] = $users[0]['first_name'] . " " . $users[0]['last_name'];
					$this->data['assign_to_email'] = $users[0]['email'];
				}
				$this->data['created_email'] = '-'; 
				if ($users = $this->users_model->search(array('id' => $case_details['created_by']))) {
					$this->data['created_email'] = $users[0]['email'];
				}
				
				// load dropdowns data
				$this->data['country'] = $this->country_model->get_list(TRUE);
				$this->data['country2'] = $this->country_model->get_list(FALSE);
				$this->data['provinces'] = $this->province_model->get_list_by_country_short(isset($case_details['country']) ? $case_details['country'] : 'CA');
				
				// Load model if needs
				$vdata = array();
				$vdata['name'] = 'inpatient_currency';
				$vdata['options'] = $this->currency_model->get_list();
				$vdata['selected'] = $case_details['inpatient_currency'];
				$this->data['inpatient_currency'] = $this->load->view('template/selection', $vdata, TRUE);
				
				if (empty($case_details['doctor_country']))
					$case_details['doctor_country'] = 'CA';
				$vdata = array();
				$vdata['name'] = 'doctor_country';
				$vdata['options'] = $this->country_model->get_list(1);
				$vdata['selected'] = $case_details['doctor_country'];
				$vdata['loadurl'] = base_url('utility/province/doctor_province/');
				$vdata['depended'] = 'doctor_province';
				$this->data['doctor_country'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'doctor_province';
				$vdata['options'] = $this->province_model->get_list_by_country_short($case_details['doctor_country']);
				$vdata['selected'] = $case_details['doctor_province'];
				$vdata['loadurl'] = '';
				$this->data['doctor_province'] = $this->load->view('template/selection', $vdata, TRUE);
				
				if (empty($case_details['outpatient_country']))
					$case_details['outpatient_country'] = 'CA';
				$vdata = array();
				$vdata['name'] = 'outpatient_country';
				$vdata['options'] = $this->country_model->get_list(1);
				$vdata['selected'] = $case_details['outpatient_country'];
				$vdata['loadurl'] = base_url('utility/province/outpatient_province/');
				$vdata['depended'] = 'outpatient_province';
				$this->data['outpatient_country'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$vdata = array();
				$vdata['name'] = 'outpatient_province';
				$vdata['options'] = $this->province_model->get_list_by_country_short($case_details['doctor_country']);
				$vdata['selected'] = $case_details['outpatient_province'];
				$vdata['loadurl'] = '';
				$this->data['outpatient_province'] = $this->load->view('template/selection', $vdata, TRUE);
				
				$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
				$this->data['seacs'] = $this->schedule_model->get_eacs();
				
				$this->load->model('reasons_model');
				$this->load->model('relations_model');
				
				$this->data['reasons'] = $this->reasons_model->get_list2();
				$this->data['relationships'] = $this->relations_model->get_list();
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name), FALSE, FALSE);
				$this->data['product_full_name'] = $this->product_model->get_full_name(empty($this->data['policy']['product_short'])?'':$this->data['policy']['product_short']);

				// get intake forms
				$this->data['intake_forms'] = $this->intakeform_model->get_list_by_case_id($id);
				
				// pass case id to server
				$this->data['case_id'] = $id;
				$this->data['ref'] = $this->input->get("ref");
				
				$this->data['priorities'] = $this->mytask_model->get_priorities();
				
				$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CASE));
				$this->data['phone_list_url'] = base_url('phone/search');
				$this->data['note_delay'] = $this->notes_dealy;
				$this->data['my_user_id'] = $this->ion_auth->get_user_id();
				$this->data['note_update_url'] = base_url('emergency_assistance/updatenotes');
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Edit Case', TRUE);
				$this->template->write_view('content', 'emergency_assistance/edit_case', $this->data);
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the case management page
	public function case_management() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('case_model');
			$this->load->model('api_model');
			$this->load->model('country_model');
			$this->load->model('province_model');
			$this->load->model('currency_model');
			$this->load->model('reasons_model');
			$this->load->model('relations_model');
			$this->load->model('Intakeform_model');
			$this->load->model('template_model');
			$this->load->model('product_model');
			$this->load->model('mytask_model');
			$this->load->model('html_model');
				
			// initialize variables
			$this->data['cases'] = [];
			$this->data['policies'] = [];
			
			// ---search case filter---
			// get all providers list
			$order_by = array(
					'field' => 'id',
					'order' => 'desc' 
			);
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			// prepare conditions
			$conditions = array();
			if ($this->input->get("case_no")) {
				$conditions['case.case_no'] = trim($this->input->get("case_no"));
			}
			if ($this->input->get("policy_no")) {
				$conditions['case.policy_no'] = trim($this->input->get("policy_no"));
			}
			if ($this->input->get("created_from")) {
				$conditions['case.created >= '] = trim($this->input->get("created_from"));
			}
			if ($this->input->get("created_to")) {
				$conditions['case.created <= '] = trim($this->input->get("created_to"));
			}
			if ($this->input->get("insured_firstname")) {
				$conditions['case.insured_firstname like'] = "%" . trim($this->input->get("insured_firstname")) . "%";
			}
			if ($this->input->get("insured_lastname")) {
				$conditions['case.insured_lastname like'] = "%" . trim($this->input->get("insured_lastname")) . "%";
			}
			if ($this->input->get("assign_to")) {
				$conditions['case.assign_to'] = trim($this->input->get("assign_to"));
			}
			if ($this->input->get("priority")) {
				$conditions['case.priority'] = trim($this->input->get("priority"));
			}
			if ($this->input->get("status")) {
				$conditions['case.status'] = trim($this->input->get("status"));
			}
			if ($this->input->get("assigned_status") == 'assigned') {
				$conditions['case.assign_to != '] = '0';
			} else if ($this->input->get("assigned_status") == 'unassigned') {
				$conditions['case.assign_to'] = '0';
			}
			if ($this->input->get("case_manager")) {
				$conditions['case.case_manager'] = trim($this->input->get("case_manager"));
			}
			
			$sorting = array();
			$sortingstr = '';
			if (!empty($conditions)) {
				$sortingstr = '&'.http_build_query($conditions);
			}
			if ($this->input->get("created_sort")) {
				$sorting['case.created'] = trim($this->input->get("created_sort"));
				$this->data['created_sort_url'] = base_url('emergency_assistance/case_management') . "?created_sort=" . (($sorting['case.created'] == 'ASC') ? "DESC" : "ASC") . $sortingstr;
			} else {
				$this->data['created_sort_url'] = base_url('emergency_assistance/case_management') . "?created_sort=ASC" . $sortingstr;
			}
			if ($this->input->get("last_update_sort")) {
				$sorting['case.last_update'] = trim($this->input->get("last_update_sort"));
				$this->data['last_update_sort_url'] = base_url('emergency_assistance/case_management') . "?last_update_sort=" . (($sorting['case.last_update'] == 'ASC') ? "DESC" : "ASC") . $sortingstr;
			} else {
				$this->data['last_update_sort_url'] = base_url('emergency_assistance/case_management') . "?last_update_sort=ASC" . $sortingstr;
			}
			if ($this->input->get("priority_sort")) {
				$sorting['case.priority'] = trim($this->input->get("priority_sort"));
				$this->data['priority_sort_url'] = base_url('emergency_assistance/case_management') . "?priority_sort=" . (($sorting['case.priority'] == 'ASC') ? "DESC" : "ASC") . $sortingstr;
			} else {
				$this->data['priority_sort_url'] = base_url('emergency_assistance/case_management') . "?priority_sort=ASC" . $sortingstr;
			}

			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			$cases = $this->case_model->search($conditions, $limit, $offset, $sorting);
			$total = $this->case_model->last_rows();
					
			if ($cases) {
				foreach ($cases as $key => $case) {
					$case_manager = '';
					if ($case['case_manager']) {
						$case_manager = $this->users_model->get_by_id($case['case_manager']);
					}
					if ($case_manager) {
						$cases[$key]['case_manager_name'] = $case_manager['email'];
					} else {
						$cases[$key]['case_manager_name'] = 'N/A';
					}
					/*
					$assign_to = '';
					if ($case['assign_to']) {
						$assign_to = $this->users_model->get_by_id($case['assign_to']);
					}
					if ($assign_to) {
						$cases[$key]['assign_to_name'] = $assign_to['email'];
					} else {
						$cases[$key]['assign_to_name'] = 'N/A';
					}
					*/
					$initiator = '';
					if ($case['init_manager']) {
						$initiator = $this->users_model->get_by_id($case['init_manager']);
					}
					if ($initiator) {
						$cases[$key]['initiator'] = $initiator['email'];
					} else {
						$cases[$key]['initiator'] = 'N/A';
					}
				}
			}
			$this->data['cases'] = $cases;
			
			// pagination start here
			$config['base_url'] = site_url('emergency_assistance/case_management');
			$config['per_page'] = $limit;
			$config['first_url'] = $config['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0) $config['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$config['total_rows'] = $total;
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data['pagination'] = $this->pagination->create_links(); // create pagination links
			// pagination end here
			                                                               
			// get login user id
			$this->data['case_manager'] = $case_manager = $this->ion_auth->get_user_id();
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
			$this->data['priorities'] = $this->mytask_model->get_priorities();

			// timing shifts array
			$shifts = array(
					'8am-2pm' => array(
							strtotime("8am"),
							strtotime("2pm") 
					),
					'2pm-8pm' => array(
							strtotime("2pm"),
							strtotime("8pm") 
					),
					'8pm-8am' => array(
							strtotime("8pm"),
							strtotime("11:59pm"),
							strtotime("8am") 
					) 
			);
			
			// rearrange shifts according to system current time
			if (time() >= $shifts['8am-2pm'][0] && time() < $shifts['8am-2pm'][1]) {
				$this->data['employee_shift'] = [
						'8am-2pm',
						'2pm-8pm',
						'8pm-8am' 
				];
			}
			if (time() >= $shifts['2pm-8pm'][0] && time() < $shifts['2pm-8pm'][1]) {
				$this->data['employee_shift'] = [
						'2pm-8pm',
						'8pm-8am',
						'8am-2pm' 
				];
			}
			if ((time() >= $shifts['8pm-8am'][0] and time() <= $shifts['8pm-8am'][1]) or (time() < $shifts['8pm-8am'][2])) {
				$this->data['employee_shift'] = [
						'8pm-8am',
						'8am-2pm',
						'2pm-8pm' 
				];
			}
			
			/*
			// select emc users
			foreach ( $this->data['employee_shift'] as $key => $value ) {
				$additional_conditions = " and schedule.schedule = '$value' and users.active = '1' ";
				$this->data['employees_' . $key] = $this->common_model->shift_users($field_name = "assign_to", $selected = $this->input->get($field_name), $group = "eacmanager", $empty = "--Select Employee--", $additional_conditions);
			}
			*/
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
			// get all case managers list
			$additional_conditions = " and users.active = '1'";
			//XXXXXXXXXXXXXXX $this->data['casemanagers'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--", $additional_conditions);
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
				
			//$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);
			$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CASE));
			$this->data['case_status'] = $this->case_model->get_status_list();
			
			// get province list
			$this->data['province'] = $this->province_model->get_list_by_country_short('CA');
			
			// get products list
			$this->data['products'] = $this->product_model->get_list(TRUE);
			$this->data['html_model'] = $this->html_model;
			
			// render view data
			$this->template->write('title', SITE_TITLE . ' - Case Management', TRUE);
			$this->template->write_view('content', 'emergency_assistance/case_management', $this->data);
			$this->template->render();
		}
	}
	
	// reload all docs email/print
	public function reload_docs() {
		$this->load->model('template_model');
		$this->load->model('province_model');
		$this->load->model('word_comments_model');
		
		// get all documents for sending email/print.
		$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CASE));
		$this->data['province2'] = $this->province_model->get_list_by_country_short('CA');
		$this->data['word_templates'] = $this->data['word_templates'] = $this->word_comments_model->search(array());
		
		$data = array('reload_docs' => $this->parser->parse("claim/reload_docs", $this->data, TRUE));
		echo json_encode($data);
	}
	
	// redirect if needed, otherwise display the create policy page
	public function create_policy($id = 0) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			// validate form input
			$this->form_validation->set_rules('institution_phone', 'School Phone', 'required|trim|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('phone1', 'Phone1', 'required|trim|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('phone2', 'Phone2', 'trim|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'required|trim|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required|alpha_numeric');
			
			$this->form_validation->set_rules('product', 'Select Product', 'required');
			$this->form_validation->set_rules('agent', 'Agent No', 'required');
			$this->form_validation->set_rules('apply_date', 'Apply Date', 'required');
			$this->form_validation->set_rules('arrival_date', 'Arrival Date', 'required');
			$this->form_validation->set_rules('effective_date', 'Effective Date', 'required');
			$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
			$this->form_validation->set_rules('institution_phone', 'School Phone', 'required');
			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('birthday', 'Birth Date', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('street_number', 'Street Number', 'required');
			
			$this->form_validation->set_rules('street_number', 'Street Number', 'required');
			$this->form_validation->set_rules('street_name', 'Street Name', 'required');
			$this->form_validation->set_rules('suite_number', 'Suite Number', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('postcode', 'Postcode', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('phone1', 'Phone 1', 'required');
			
			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				// print_r($array); die;
				foreach ( $array as $key => $value ) {
					// code...
					if ($key != "submit")
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->get_user_id();
				
				// insert values to database
				$record_id = $this->common_model->save("policies", $data);
				
				// send success message
				$this->session->set_flashdata('success', "Policy successfully created");
				
				// redirect them to the login page
				redirect('emergency_assistance', 'refresh');
			} else {
				
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name));
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name));
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Policy', TRUE);
				$this->template->write_view('content', 'emergency_assistance/create_policy', $this->data);
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the view policy page
	public function view_policy($policy = '') {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (empty($policy)) {
			return show_error('Sorry, Unknown policy.');
		} else {
			$this->data['create_claim_url'] = base_url('claim/create_claim');
			$this->data['create_case_url'] = base_url('emergency_assistance/create_case');
			
			$this->load->model('api_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			$this->load->model('policy_model');
				
			$policies = $this->api_model->get_policy(array('policy' => $policy));
			$this->data['policy_local_note'] = '';
      $this->data['show_expiry'] = 0;
			if ($policies) {
				$this->data['policy'] = $policies[0];
				$para = array();
				$para['policy'] = $policies[0]['policy'];
				$para['firstname'] = $policies[0]['firstname'];
				$para['lastname'] = $policies[0]['lastname'];
				$para['birthday'] = $policies[0]['birthday'];
				$para['gender'] = $policies[0]['gender'];
				$this->data['create_claim_url'] .= "?" . http_build_query($para);
				$this->data['create_case_url'] .= "?" . http_build_query($para);
				if (!empty($this->data['policy']['family'])) {
					foreach ( $this->data['policy']['family'] as $key => $val ) {
						$para = array(
								'policy' => $policies[0]['policy'] 
						);
						$para['firstname'] = $val['firstname'];
						$para['lastname'] = $val['lastname'];
						$para['birthday'] = $val['birthday'];
						$para['gender'] = $val['gender'];
						$this->data['policy']['family'][$key]['create_claim_url'] = base_url('claim/create_claim') . "?" . http_build_query($para);
						$this->data['policy']['family'][$key]['create_case_url'] = base_url('emergency_assistance/create_case') . "?" . http_build_query($para);
					}
				}
        $expiretm = strtotime($policies[0]['policy']["expiry_date"]);
        if ($expiretm > time()) {
          $this->data['show_expiry'] = 1;
        }
				if ($pn = $this->policy_model->get_by_no($policies[0]['policy'])) {
					$this->data['policy_local_note'] = $pn['note'];
				}
			}
			$this->data['policy_status'] = $this->api_model->status_list;
			$this->data['cases'] = $this->case_model->search(array('policy_no' => $this->data['policy']['policy']));
			foreach ($this->data['cases'] as $k => $v) {
				$u = $this->users_model->get_by_id($v['assign_to']);
				if ($u) $this->data['cases'][$k]['assign_to_email'] = $u['email'];
				else    $this->data['cases'][$k]['assign_to_email'] = '';
				$u = $this->users_model->get_by_id($v['case_manager']);
				if ($u) $this->data['cases'][$k]['case_manager_email'] = $u['email'];
				else    $this->data['cases'][$k]['case_manager_email'] = '';
			}
			$this->data['claims'] = $this->claim_model->search(array('policy_no' => $this->data['policy']['policy']));
			//echo "<pre>"; print_r($this->data['claims']); die("XX"); //XXXXXXXXXXXXXXXX
			foreach ($this->data['claims'] as $k => $v) {
				$u = $this->users_model->get_by_id($v['assign_to']);
				if ($u) $this->data['claims'][$k]['assign_to_email'] = $u['email'];
				else    $this->data['claims'][$k]['assign_to_email'] = '';
			}
				
			// get countries list
			$this->data['countries'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->input->get("country2"), $key = "short_code", $value = "name");
			
			// get province list
			$this->data['provinces'] = $this->common_model->getprovinces($field_name = "province2", $selected = $this->input->get("province2"), $key = "short_code", $value = "name");
			$this->template->write('title', SITE_TITLE . ' - View Policy', TRUE);
			$this->template->write_view('content', 'emergency_assistance/view_policy', $this->data);
			$this->template->render();
		}
	}
	
	// redirect if needed, otherwise display the create provider page
	public function create_provider() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			
			// validate form input
			$this->form_validation->set_rules('name', "Name", 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('postcode', 'Postcode', 'required');
			$this->form_validation->set_rules('discount', 'Discount', 'required|numeric');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
			$this->form_validation->set_rules('phone_no', 'Phone', 'required|trim|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('ppo_codes', 'PPO Codes', 'required');
			$this->form_validation->set_rules('services', 'Services', 'required');
			$this->form_validation->set_rules('priority', 'Priority', 'required');
			
			if ($this->form_validation->run() == TRUE) {
				// get lat lng from address
				$cordinates = $this->lat_lng_finder($this->input->post("address") . ", " . $this->input->post("postcode"));
				
				// prepare data array
				$data = array(
						'name' => $this->input->post("name"),
						'address' => $this->input->post("address"),
						'postcode' => $this->input->post("postcode"),
						'discount' => $this->input->post("discount"),
						'contact_person' => $this->input->post("contact_person"),
						'phone_no' => $this->input->post("phone_no"),
						'email' => $this->input->post("email"),
						'ppo_codes' => $this->input->post("ppo_codes"),
						'services' => $this->input->post("services"),
						'priority' => $this->input->post("priority"),
						'lat' => $cordinates['lat'],
						'lng' => $cordinates['lng'] 
				);
				// insert values to database
				$this->common_model->save("provider", $data);
				
				// send success message
				$this->session->set_flashdata('success', "Provider successfully added");
				
				// redirect them to the login page
				redirect('emergency_assistance/create_provider', 'refresh');
			} else {
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Provider', TRUE);
				$this->template->write_view('content', 'emergency_assistance/create_provider', $this->data);
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the create provider page
	public function provider_batch_upload() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('provider_model');
			
			// validate form input
			$this->form_validation->set_rules('csv_file', "CSV File", 'required');
			if ($this->form_validation->run() == TRUE) {
				$this->load->library('csvimport');
				$config['upload_path'] = UPLOADPATH;
				$config['allowed_types'] = 'csv';
				$config['max_size'] = '5000';
				
				$this->load->library('upload', $config);
				
				// If upload failed, display error
				if (!$this->upload->do_upload('csv')) {
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect('emergency_assistance/provider_batch_upload', 'refresh');
				} else {
					$file_data = $this->upload->data();
					$file_path = UPLOADPATH . $file_data['file_name'];
					
					if ($this->csvimport->get_array($file_path)) {
						$csv_array = $this->csvimport->get_array($file_path);
						
						foreach ( $csv_array as $row ) {
							$cordinates = $this->common_model->lat_lng_finder($row["Address"] . ", " . $row["Postcode"]);
							
							// prepare data array
							$data = array(
									'name' => $row["Name"],
									'address' => $row["Address"],
									'postcode' => $row["Postcode"],
									'discount' => $row["Discount"],
									'contact_person' => $row["Contact Person"],
									'phone_no' => $row["Phone No"],
									'email' => $row["Email"],
									'ppo_codes' => $row["PPO Codes"],
									'services' => $row["Services"],
									'priority' => $row["Priority"],
									'lat' => $cordinates['lat'],
									'lng' => $cordinates['lng'] 
							);
							// insert values to database
							$this->provider_model->save($data);
						}
						
						// send success message
						$this->session->set_flashdata('success', "Providers successfully added");
						redirect('emergency_assistance/provider_batch_upload', 'refresh');
					} else {
						// send success message
						$this->session->set_flashdata('error', "Something went wrong, please try after some time.");
						
						// redirect them to the login page
						redirect('emergency_assistance/provider_batch_upload', 'refresh');
					}
				}
			} else {
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Provider Batch Upload', TRUE);
				$this->template->write_view('content', 'emergency_assistance/provider_batch_upload', $this->data);
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the search provider page
	public function search_provider() {
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else {
			// get all url params
			$lat = $this->input->get('lat');
			$lng = $this->input->get('lng');
			$address = $this->input->get('address');
			if (empty($lat) && empty($lng)) {
				// No latitude and longitude, try to get from address
				if (empty($address)) {
					// No address input, try to combine other address together
					$address = $this->input->get('street_no') . " ";
					$address .= $this->input->get('street_name') . " ";
					$address .= $this->input->get('city') . " ";
					$address = trim($address);
					if (!empty($address)) {
						$address .= " ";
						$address .= $this->input->get('province') . " ";
						$address .= $this->input->get('country') . " ";
					}
					$address .= $this->input->get('post_code') . " ";
					$address = trim($address);
				}
				if (empty($address)) {
					$lat = 43.653226;
					$lng = -79.3831843;
				} else {
					$cordinates = $this->lat_lng_finder($address);
					$lat = $cordinates['lat'];
					$lng = $cordinates['lng'];
				}
			}
			
			$this->data['lat'] = $lat;
			$this->data['lng'] = $lng;
			$this->data['address'] = $address;
			$this->data['records'] = array();
			if (!empty($lat) || !empty($lng)) {
				$this->load->model('provider_model');
				$this->data['records'] = $this->provider_model->get_list($lat, $lng);
			}
			
			// load view data
			$this->template->write('title', SITE_TITLE . ' - Search Provider', TRUE);
			$this->template->write_view('content', 'emergency_assistance/search_provider', $this->data);
			$this->template->render();
		}
	}
	
	// lat lng generator
	public function lat_lng_finder($address = "") {
		// Get lat and long by address
		$prepAddr = str_replace(' ', '+', $address);
		$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
		$output = json_decode($geocode);
		$latitude = isset($output->results[0]->geometry->location->lat) ? (float)$output->results[0]->geometry->location->lat : 43.653226;
		$longitude = isset($output->results[0]->geometry->location->lng) ? (float)$output->results[0]->geometry->location->lng : -79.3831843;
		return array(
				'lat' => $latitude,
				'lng' => $longitude 
		);
	}
	
	// redirect if needed, otherwise display the create intake page
	public function create_intakeform() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('intake_notes', 'Intake Notes', 'required');
			
			if ($this->form_validation->run() == TRUE) {
				// get app post params
				$array = $this->input->post();
				$phonefile = $this->input->post('phonefile') ? $this->input->post('phonefile') : '';
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				
				// initialize file names array
				$file_names = [];
				
				// upload files to server
				$files = @$_FILES['files'];
				if (!empty($files)) {
					foreach ( $files['name'] as $key => $value ) {
						if ($files['name'][$key]) {
							$_FILES['userfile']['name'] = $files['name'][$key];
							$_FILES['userfile']['type'] = $files['type'][$key];
							$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
							$_FILES['userfile']['error'] = $files['error'][$key];
							$_FILES['userfile']['size'] = $files['size'][$key];
							
							// codeigniter default file name to upload
							$field_name = 'userfile';
							
							// upload file to server
							$this->upload->do_upload();
							$file_data = $this->upload->data();
							$file_names[] = $file_data['file_name'];
						}
					}
				}
				
				$this->load->model('intakeform_model');
				$intake_form_id = $this->intakeform_model->save($array['case_id'], $array['intake_notes'], implode(",", $file_names), $phonefile);
				
				// create directory to identify intake files
				@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
				
				// move all files to that directory
				if (!empty($file_names)) {
					foreach ( $file_names as $fname ) {
						copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
						unlink(UPLOADFULLPATH . "intake_forms/$fname");
					}
				}
				
				// send success message
				$this->session->set_flashdata('success', "Intake form successfully added");
				
				// redirect them to the login page
				redirect('emergency_assistance/edit_case/' . $array['case_id'], 'refresh');
			} else {
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Note', TRUE);
				$this->template->write_view('content', 'emergency_assistance/create_intakeform');
				$this->template->render();
			}
		}
	}
	
	// download intake form files
	public function download($file, $id) {
		$this->load->helper("download");
		force_download(UPLOADFULLPATH . 'intake_forms/' . $id . '/' . urldecode($file), NULL);
	}
	
	// from here download sample file for provider batch upload
	public function sample_file($file, $id) {
		$this->load->helper("download");
		force_download('./assets/img/provider_csv_sample.csv', NULL);
	}
	
	// browse intake form files
	public function file($file, $id) {
		
		// We'll be outputting a PDF
		header('Content-type: application/pdf');
		
		// The PDF source is in original.pdf
		readfile(UPLOADFULLPATH . 'intake_forms/' . $id . '/' . urldecode($file));
	}
	
	public function removedocfile($id, $file) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('intakeform_model');
			$file = urldecode($file);
			$intakeform = $this->intakeform_model->get_by_id($id);
			if ($intakeform) {
				$delay = time() - strtotime($intakeform['created']);
				if ($delay <= $this->notes_dealy) {
					$files = $intakeform['docs'] ? explode(",", $intakeform['docs']) : array();
					foreach ($files as $key => $fn) {
						if ($fn == $file) {
							unlink(UPLOADFULLPATH . 'intake_forms/' . $id . '/' . $file);
							unset($files[$key]);
						}
					}
					$intakeform['docs'] = join(",", $files);
					$this->intakeform_model->update($intakeform);
				} else {
					$this->session->set_flashdata('error', "You must update in ".$this->notes_dealy." seconds.");
				}
				echo "OK";
			}
		}
		echo "Fail";
	}
	
	public function removephonefile($id) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('intakeform_model');

			$intakeform = $this->intakeform_model->get_by_id($id);
			if ($intakeform) {
				$delay = time() - strtotime($intakeform['created']);
				if ($delay <= $this->notes_dealy) {
					$intakeform['phonefile'] = '';
					$this->intakeform_model->update($intakeform);
					echo "OK";
				} else {
					$this->session->set_flashdata('error', "You must update in ".$this->notes_dealy." seconds.");
				}
			}
		}
		echo "Fail";
	}
	
	public function updatenotes($id) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('intakeform_model');
			$intakeform = $this->intakeform_model->get_by_id($id);
			if ($intakeform) {
				$delay = time() - strtotime($intakeform['created']);
				if ($delay <= $this->notes_dealy) {
					$intakeform['notes'] = $this->input->post("new_note");
					$this->intakeform_model->update($intakeform);
				} else {
					$this->session->set_flashdata('error', "You must update in ".$this->notes_dealy." seconds.");
				}
				redirect('emergency_assistance/edit_case/'.$intakeform['case_id']);
			}
		}
		redirect('emergency_assistance');
	}
	
	public function update_policy_note() {
		if (!$this->ion_auth->logged_in()) {
			header('HTTP/1.0 403 Forbidden');
			echo "1";
		}
		$policy_no = $this->input->post("policy_no");
		$note_txt = $this->input->post("note_txt");
		$this->load->model('policy_model');
		$this->policy_model->save($policy_no, $note_txt);
		echo "0";
	}

	// delete intake form here for ajax request
	public function deleteform($form_id) {
		
		// load files library to delete file
		$this->load->helper('file');
		
		// delete all files of itake form
		delete_files(UPLOADFULLPATH . "intake_forms/$form_id/", FALSE);
		rmdir(UPLOADFULLPATH . "intake_forms/$form_id");
		
		// delete intake form
		$this->common_model->delete('intake_form', array(
				'id' => $form_id 
		));
		
		echo TRUE;
	}
	
	// Auto schedule process here for ajax request
	public function auto_schedule($eac, $year, $month) {
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		
		$this->load->model('schedule_model');
		if ($eac) {
			// get all eac
			$eacs = $this->users_model->search(array('id' => $eac, 'groups' => Users_model::GROUP_EAC, 'active' => 1), 100);
		} else {
			// get all eac's list
			$eacs = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
		}

		$dataStrArr = $this->schedule_model->get_shift_options();
		$manager_id = $this->ion_auth->get_user_id();
		
		foreach ($eacs as $rc) {
			$shift = $rc['shift'];
			if ($hours = $this->schedule_model->get_shift_long($shift)) {
				$this->schedule_model->clear_schedule_by_month($year, $month, $rc['id']);
				$shour = $this->schedule_model->get_shift_shour($shift);
				for($i = 1; $i <= date('t', strtotime($year . "-" . $month)); $i++) {
					$data = array(
							'schedule' => $dataStrArr[$shift],
							'employee_id' => $rc['id'],
							'date' => $year . "-" . $month . "-" . $i,
							'created_by' => $manager_id, 
							'start_tm' => $year . "-" . $month . "-" . $i . " " . $shour . ":00:00", 
							'shour' => $shour,
							'hours' => $hours 
					);
					$this->schedule_model->save($data);
				}
			}
		}
		echo TRUE;
	}
	
	// search users for ajax request
	public function search_users($year, $month, $emc, $date, $type, $day) {
		$this->load->model('schedule_model');
		$this->data['users'] = $this->schedule_model->get_day_schedule($year, $month, $date, $emc);
		$this->data['status'] = $this->schedule_model->get_shift_options(TRUE);
		/*
		// prepare date
		$date = $year . "-" . $month . "-" . $date;
		
		// table settings goes here
		$table = "users";
		$fields = "users.first_name, users.last_name, users.email, users.active, users.id, (select schedule.schedule from schedule where schedule.employee_id = users.id and schedule.date = '$date') as schedule";
		$group_by = array(
				"users_groups.user_id" 
		);
		
		// get login user id (case manager id)
		$case_manager = $this->ion_auth->get_user_id();
		
		// prepare conditions
		$conditions[] = "users_groups.group_id = '2' and users.active = '1'";
		if ($this->input->post("last_name"))
			$conditions[] = "users.last_name like '%" . $this->input->post("last_name") . "%'";
		if ($this->input->post("first_name"))
			$conditions[] = "users.first_name like '%" . $this->input->post("first_name") . "%'";
		if ($this->input->post("email"))
			$conditions[] = "users.email like '%" . $this->input->post("email") . "%'";
		$conditions = implode(" and ", $conditions);
		$conditions .= " and IF(schedule.date = '$date',  schedule.date = '$date', users.id > '0')";
		
		// check records if related to specific emc
		if ($emc)
			$conditions .= " and users.id = '$emc'";
		$group_by = array(
				"users_groups.user_id" 
		);
		$joins[] = array(
				'table' => 'users_groups',
				'on' => 'users_groups.user_id = users.id',
				'type' => 'LEFT' 
		);
		$joins[] = array(
				'table' => 'schedule',
				'on' => 'schedule.employee_id = users.id',
				'type' => 'LEFT' 
		);
		$order_by = array(
				'field' => 'id',
				'order' => 'desc' 
		);
		
		// if sorting enabled
		if ($this->input->get("field"))
			$order_by = array(
					'field' => $this->input->get("field"),
					'order' => $this->input->get("order") 
			);
			
			// get result
		$this->data['users'] = $this->common_model->select($record = "list", $typecast = "array", $table, $fields, $conditions, $joins, $order_by, $group_by);
		*/
		$this->data['date'] = $date;
		$this->data['type'] = $type;
		$this->data['emc'] = $emc;
		
		// render view file
		$this->load->view("emergency_assistance/search_users", $this->data);
	}
	
	// save schedule here from ajax request
	public function save_schedule($year, $month, $date, $type, $day) {
		$this->load->model('schedule_model');
		
		// prepare date
		$datestr = $year . "-" . $month . "-" . $date;
		
		// select post request
		$employee_id = $this->input->post("employee_id");
		$sphone = $this->input->post("sphone");
		$shift = $this->input->post("schedule");
		$manager_id = $this->ion_auth->get_user_id();
		
		// check user select day(monday) or date(0000-00-00)
		if ($type == 'day') {
			$this->schedule_model->clear_schedule_by_month($year, $month, $employee_id);
			if ($hours = $this->schedule_model->get_shift_long($shift)) {
				$shour = $this->schedule_model->get_shift_shour($shift);
				for($i = 1; $i <= date('t', strtotime($year . "-" . $month)); $i++) {
					$data = array(
							'schedule' => $$shift,
							'employee_id' => $employee_id,
							'date' => $year . "-" . $month . "-" . $i,
							'created_by' => $manager_id, 
							'start_tm' => $year . "-" . $month . "-" . $i . " " . $shour . ":00:00", 
							'shour' => $shour,
							'hours' => $hours 
					);
					if ($sphone) $data['sphone'] = $sphone;
 					$this->schedule_model->save($data);
				}
			}
		} else {
			$this->schedule_model->clear_schedule_by_day($year, $month, $date, $employee_id);
			if ($hours = $this->schedule_model->get_shift_long($shift)) {
				$shour = $this->schedule_model->get_shift_shour($shift);
				$data = array(
						'schedule' => $shift,
						'employee_id' => $employee_id,
						'date' => $datestr,
						'created_by' => $manager_id, 
						'start_tm' => $datestr . " " . $shour . ":00:00", 
						'shour' => $shour,
						'hours' => $hours 
				);
				if ($sphone) $data['sphone'] = $sphone;
				$this->schedule_model->save($data);
			}
		}
		echo TRUE;
	}
	
	// redirect if needed, otherwise display the schedule page
	public function schedule($emc = 0, $year = "", $month = "") {
		// check date and time
		if (!$year) {
			$year = date("Y");
			$month = date('m');
		}
		$year = intval($year);
		$month = str_pad(intval($month), 2, 0, STR_PAD_LEFT);
		
		// only accessible for case managers
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EAC, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('country_model');
			
			// get user type if exists
			$this->data['emc'] = $this->input->get('emc') ? $this->input->get('emc') : $emc;
			if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER))) {
				$this->data['emc'] = $this->ion_auth->get_user_id();
			}
					
			// get schedule calendar
			$this->data['calendar'] = $this->schedule_calendar($this->data['emc'], $year, $month, "return");
					
			// pass month and year to calender page
			$this->data['year'] = $year;
			$this->data['month'] = $month;
			
			// get countries list
			$this->data['countries'] = $this->country_model->get_list(FALSE);
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
			$this->data['upload_url'] = base_url("emergency_assistance/uploadschedule");
			/*
			$this->data['countries'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->input->get("country2"), $key = "short_code", $value = "name");
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "emc", $this->data['emc'], $group = array(
					"'eacmanager'" 
			), $empty = "--Select Employee--", $additional_conditions = " and users.active = '1'", $user_code = "EAC");
			*/

			$this->template->write('title', SITE_TITLE . ' - Employee Schedule', TRUE);
			$this->template->write_view('content', 'emergency_assistance/schedule', $this->data);
			$this->template->render();
		}
	}

	/**
	 * schedule calendar for ajax request and in schedule page
	 *
	 * @param $year String
	 * @param $month array
	 * @param $type return
	 *        	- for return data/output - echo response for ajax complete
	 * @param $emc int
	 *        	- show events and calender for specific emc user
	 */
	public function uploadschedule() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('schedule_model');
			
			$uf = array_shift($_FILES);
			$name = $uf['name'];
			$type = $uf['type'];
			$tmp_name = $uf['tmp_name'];
			$size = $uf['size'];
			$fileinfo = pathinfo($name);
			if (!empty($uf['error'])) {
				$this->session->set_flashdata('error', "Something went wrong, please check your file.");
			} else if (!in_array($fileinfo ['extension'], array(/*'xlsx',*/'csv'))) {
				$this->session->set_flashdata('error', "Unknown file type, must be csv.");
			} else {
				if (($handle = fopen($tmp_name, "r")) !== FALSE) {
					$i = 0;
					while (($data = fgetcsv($handle, 10000)) !== FALSE) {
						$user_id = $data[0];
						if ($user_id == 'user_id') {
							// first title line
							continue;
						}
						$i++;
						$user = $this->users_model->get_by_id($user_id);
						if (!$user || (strpos($user['groups'], Users_model::GROUP_EAC) <= 0)) {
							$this->session->set_flashdata('error', "File data error at line " . $i . ", user isn't EAC.");
							redirect('emergency_assistance/schedule', 'refresh');
						}
						$dt = trim($data[1]);
						$tmStr = trim($data[2]);
						$sphone = ''; // trim($data[3]);
						if (($tmStr == Schedule_model::SHIFT_8AM_STR) || ($tmStr == Schedule_model::SHIFT_2PM_STR) || ($tmStr == Schedule_model::SHIFT_8PM_STR)) {
							$shour = $this->schedule_model->get_shift_shour($tmStr);
							$para = array();
							$para['employee_id'] = (int)$user_id;
							$para['schedule'] = $tmStr;
							$para['date'] = $dt;
							if ($rr = $this->schedule_model->search($para)) {
								// there is same data already existed
								continue;
							}
							$para['sphone'] = $sphone;
							$para['created_by'] = $this->ion_auth->get_user_id();
							$para['start_tm'] = $dt . " " . $shour . ":00:00";
							$para['shour'] = $shour;
							$para['hours'] = $this->schedule_model->get_shift_long($tmStr);
							$this->schedule_model->save($para);
						} else {
							$this->session->set_flashdata('error', "File data error at line " . $i . ".");
							redirect('emergency_assistance/schedule', 'refresh');
						}
					}
					fclose($handle);
				} else {
					$this->session->set_flashdata('error', "Can't opne upload file.");
				}
				$this->session->set_flashdata('success', "File data update successed");
			}
		}
		redirect('emergency_assistance/schedule', 'refresh');
	}
	
	/**
	 * schedule calendar for ajax request and in schedule page
	 *
	 * @param $year String        	
	 * @param $month array        	
	 * @param $type return
	 *        	- for return data/output - echo response for ajax complete
	 * @param $emc int
	 *        	- show events and calender for specific emc user
	 */
	public function schedule_calendar($emc = 0, $year = "", $month = "", $type = "return") {
		// check date and time
		if (!$year) {
			$year = date("Y");
			$month = date('m');
		}
		// only accessible for case managers
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EAC))) {
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else if (empty($emc) && (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER)))) {
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('schedule_model');
			
			// get login user id (case manager id)
			$case_manager = $this->ion_auth->get_user_id();
			
			$eacArr = $this->schedule_model->get_schedule($year, $month, $emc);
			$content = [];
			if (!empty($eacArr)) {
				$day = 1;
				$prepare_list = "";
				foreach ( $eacArr as $value ) {
					if ($day != $value['day']) {
						$content[$day] = "<ul>$prepare_list</ul>";
						$day = $value['day'];
						$prepare_list = "";
					}
					$prepare_list .= "<li>".$value['schedule']." ".$value['email']."</li>";
				}
				if ($prepare_list) {
					$content[$day] = "<ul>$prepare_list</ul>";
				}
			}
			/*
			// get all schedules added by this case manager and show all to calender
			$para = array();
			$para['year'] = $year;
			$para['month'] = $month;
			$order_by = array(
					'field' => 'schedule.id',
					'order' => 'desc' 
			);
			
			$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = schedule.employee_id',
					'type' => 'LEFT' 
			);
			// prepare conditions
			//if ($this->ion_auth->is_casemamager())
				$conditions = "schedule.date like '%$year-$month%'";
			//else
			//	$conditions = "schedule.date like '%$year-$month%' and u1.id = '$case_manager'";
				
				// if calender for specific employee
			if ($emc)
				$conditions .= " and u1.id = '$emc'";
			$group_by = array(
					"schedule.date" 
			);
			
			$fields = "DATE_FORMAT(schedule.date, '%d') as date,  ";
			
			// check calendar for on or all emc users
			if ($emc)
				$fields .= "GROUP_CONCAT(schedule.schedule ORDER BY  schedule.id ASC SEPARATOR '|') as data";
			else
				$fields .= "GROUP_CONCAT(concat_ws('-', concat_ws('', 'EAC', LPAD(u1.id, 4, 0)), schedule.schedule) ORDER BY  schedule.id ASC SEPARATOR '|') as data";
			
			$this->data['schedules'] = $this->common_model->select($record = "list", $typecast = "array", $table = "schedule", $fields, $conditions, $joins, $order_by, $group_by);
			$content = [];
			if (!empty($this->data['schedules'])) {
				foreach ( $this->data['schedules'] as $key => $value ) {
					$schedule_data = explode("|", $value['data']);
					$prepare_list = "";
					foreach ( $schedule_data as $d )
						$prepare_list .= "<li>$d</li>";
					$content[intval($value['date'])] = "<ul>$prepare_list</ul>";
				}
				print_r($content); die("XX"); //XXXXXXXXXXXXX
			}
			*/
			$config = [];
			$config['template'] = '
				    {table_open}<table class="calendar">{/table_open}

   					{heading_previous_cell}<th><a href="{previous_url}"><button type="button" class="btn"><i class="fa fa-chevron-left"></i> Prev</button></a></th>{/heading_previous_cell}
				    {heading_title_cell}<th colspan="{colspan}"><center><h3>{heading}</h3></center></th>{/heading_title_cell}				    
   					{heading_next_cell}<th><a href="{next_url}"><button type="button" class="btn pull-right"><i class="fa fa-chevron-right"></i> Next</button></a></th>{/heading_next_cell}

				    {week_day_cell}<th class="day_header" data-toggle="modal" data-target="#model_window"><h4>{week_day}</h4></th>{/week_day_cell}

        			{cal_cell_start}<td data-toggle="modal" data-target="#model_window">{/cal_cell_start}
				    {cal_cell_content}<span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
				    {cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>{content}</div>{/cal_cell_content_today}
				    {cal_cell_no_content}<span class="day_listing" data-toggle="modal" data-target="#create_intake_form"  >{day}</span>&nbsp;{/cal_cell_no_content}
				    {cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
				    {cal_cell_end}</td>{/cal_cell_end}

				';
			$config['show_next_prev'] = TRUE;
			$config['day_type'] = 'long';
			$config['next_prev_url'] = base_url("emergency_assistance/schedule/$emc/");
			$this->load->library('calendar', $config);
			if ($type == 'return')
				return $this->calendar->generate($year, $month, $content);
			else
				echo $this->calendar->generate($year, $month, $content);
		}
	}
	
	// assign case manager manually or automatically for ajax request
	public function assign_cases($type = "automatic") {
		$cases = $this->input->post("cases");
		$cases = explode(",", $cases);
		
		$this->load->model('case_model');
		$this->load->model('mytask_model');
		
		if ($type == "manually") {
			$employee_id = $this->input->post("employee_id");
			
			// asigning process
			foreach ( $cases as $key => $value ) {
				$data = array("case_manager" => $employee_id, "id" => $value);
				$this->case_model->save($data);
				
				$case_details = $this->case_model->get_by_id($value);

				// check task, if already exists
				$task_details = $this->mytask_model->search(array('item_id' => $value,  'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE, 'user_type' => Mytask_model::USER_TYPE_MANAGER));
				
				if (!empty($task_details)) {
					$task = array_shift($task_details);
					$data_task = array(
							'id' => $task['id'],
							'user_id' => $employee_id,
							'due_date' => $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400),
							'due_time' => $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400),
							'priority' => $case_details['priority'],
							'finished' => 0,
							'status' => Mytask_model::STATUS_REASSIGNED,
							'notes' => "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'],
					);
					$this->mytask_model->save($data);
				} else {
					// create new task here
					$task_data = array(
							'user_id' => $employee_id,
							'item_id' => $value,
							'task_no' => $case_details['case_no'],
							'category' => Mytask_model::CATEGORY_ASSISTANCE,
							'type' => Mytask_model::TASK_TYPE_CASE,
							'due_date' => $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400),
							'due_time' => $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400),
							'priority' => $case_details['priority'],
							'created_by' => $this->ion_auth->get_user_id(),
							'created' => date("Y-m-d H:i:s"),
							'user_type' => Mytask_model::USER_TYPE_MANAGER
					);
					// insert values to database
					$this->mytask_model->save("mytask", $task_data);
				}
			}
		} else if ($type == 'automatic') {
			// assign cases with emc which have minimum cases one by one ascending order
			// asigning process
			foreach ( $cases as $key => $value ) {
				$employee_id = $this->mytask_model->get_auto_assign_manager_id();
				if (empty($employee_id)) {
					echo "0";
					return;
				}
				
				$data = array("case_manager" => $employee_id, "id" => $value);
				$this->case_model->save($data);
			
				$case_details = $this->case_model->get_by_id($value);
				
				// check task, if already exists
				$task_details = $this->mytask_model->search(array('item_id' => $value,  'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE, 'user_type' => Mytask_model::USER_TYPE_MANAGER));
				
				if (!empty($task_details)) {
					$task = array_shift($task_details);
					$data_task = array(
							'id' => $task['id'],
							'user_id' => $employee_id,
							'due_date' => $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400),
							'due_time' => $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400),
							'priority' => $case_details['priority'],
							'finished' => 0,
							'status' => Mytask_model::STATUS_REASSIGNED,
							'notes' => "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'],
					);
					$this->mytask_model->save($data);
						
					// Finish all task if there is
					foreach ($task_details as $task) {
						$data_task = array('finished' => '1', 'status' => Mytask_model::STATUS_CANCELLED, 'id' => $task['id']);
					}
				} else {
					// create new task here
					$task_data = array(
							'user_id' => $employee_id,
							'item_id' => $value,
							'task_no' => $case_details['case_no'],
							'category' => Mytask_model::CATEGORY_ASSISTANCE,
							'type' => Mytask_model::TASK_TYPE_CASE,
							'due_date' => $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400),
							'due_time' => $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400),
							'priority' => $case_details['priority'],
							'created_by' => $this->ion_auth->get_user_id(),
							'created' => date("Y-m-d H:i:s"),
							'user_type' => Mytask_model::USER_TYPE_MANAGER
					);
					// insert values to database
					$this->mytask_model->save("mytask", $task_data);
				}
			}
		}
		
		echo TRUE;
	}
	
	// follow up cases only for ajax request
	public function follow_up_cases() {
		$cases = $this->input->post("cases");
		$notes = $this->input->post("notes");
		$cases = explode(",", $cases);
		$employee_id = $this->input->post("employee_id");
		
		$this->load->model('mytask_model');
		$this->load->model('intakeform_model');
		$this->load->model('case_model');
		// follow up process
		foreach ( $cases as $key => $value ) {
			// save values to intake database
			$iid = $this->intakeform_model->save($value, $notes, '', '', $employee_id);
					
			// save record in intake form as notes
			$this->case_model->save(array("assign_to" => $employee_id, "id" => $value));

			$case_details = $this->case_model->get_by_id($value);

			$tasks = $this->mytask_model->search(array('item_id' => $value, 'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE, 'user_type' => Mytask_model::USER_TYPE_EAC));
			// assign eac
			$new_task = array();
			if ($tasks) {
				// Change EAC
				$new_task['id'] = $tasks[0]['id'];
				$new_task['user_id'] = $employee_id;
				$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
				$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
				$new_task['priority'] = $case_details['priority'];
				$new_task['status'] = Mytask_model::STATUS_REASSIGNED;
				$new_task['finished'] = 0;
				$new_task['notes'] = "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $tasks[0]['notes'];
			} else {
				$new_task['user_id'] = $employee_id;
				$new_task['item_id'] = $value;
				$new_task['task_no'] = $case_details['case_no'];;
				$new_task['category'] = Mytask_model::CATEGORY_ASSISTANCE;
				$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
				$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
				$new_task['type'] = Mytask_model::TASK_TYPE_CASE;
				$new_task['priority'] = $case_details['priority'];
				$new_task['created_by'] = $this->ion_auth->get_user_id();
				$new_task['created'] = date("Y-m-d H:i:s");
				$new_task['user_type'] = Mytask_model::USER_TYPE_EAC;
				$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
				$new_task['notes'] = "New Assign";
			}
			$taks_id = $this->mytask_model->save($new_task);
		}
		
		$this->session->set_flashdata('success', "Follow up case successfully.");
		
		echo TRUE;
	}
	
	// mark inactive cases for ajax request
	public function updatestatus($status = 'D') {
		$cases = $this->input->post("cases");
		$cases = explode(",", $cases);
		
		$this->load->model('mytask_model');
		$this->load->model('intakeform_model');
		$this->load->model('case_model');
		
		$employee_id = $this->ion_auth->get_user_id();
		
		// mark deactivate process
		foreach($cases as $key => $value) {
			// save values to intake database
			if ($status == 'D') {
				$iid = $this->intakeform_model->save($value, "Deactivate By user id " . $employee_id, '', '', $employee_id, Mytask_model::TASK_TYPE_CASE_CHANGE);
			} else {
				$iid = $this->intakeform_model->save($value, "Closed By user id " . $employee_id, '', '', $employee_id, Mytask_model::TASK_TYPE_CASE_CHANGE);
			}

			// save record in intake form as notes
			$this->case_model->save(array("status" => $status, "id" => $value));

			$case_details = $this->case_model->get_by_id($value);

			$tasks = $this->mytask_model->search(array('item_id' => $value, 'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE));
			foreach($tasks as $task) {
				if ($status == 'D') {
					$task['notes'] = "Deactivate By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'];
				} else {
					$task['notes'] = "Closed By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'];
					$task['finished'] = 1;
				}
				$task['status'] = Mytask_model::STATUS_COMPLETED;
				$taks_id = $this->mytask_model->save($task);
			}
		}
		if ($status == 'D') {
			$this->session->set_flashdata('success', "Cases Deactivate successfully.");
		} else {
			$this->session->set_flashdata('success', "Cases Closed successfully.");
		}

		echo TRUE;
	}
	
	// mark inactive case for ajax request
	public function update_case_status($status = 'D') {
		$cases = $this->input->post("cases");

		$this->load->model('mytask_model');
		$this->load->model('intakeform_model');
		$this->load->model('case_model');
		
		$employee_id = $this->ion_auth->get_user_id();

		if ($status == 'A') {
			$iid = $this->intakeform_model->save($cases, "Active By user id " . $employee_id, '', '', $employee_id, Mytask_model::TASK_TYPE_CASE_CHANGE);
		} else {
			$iid = $this->intakeform_model->save($cases, "Deactivate By user id " . $employee_id, '', '', $employee_id, Mytask_model::TASK_TYPE_CASE_CHANGE);
		}
		
		// save record in intake form as notes
		$this->case_model->save(array("status" => $status, "id" => $cases));
		
		$case_details = $this->case_model->get_by_id($cases);
		
		$tasks = $this->mytask_model->search(array('item_id' => $cases, 'category' => Mytask_model::CATEGORY_ASSISTANCE, 'type' => Mytask_model::TASK_TYPE_CASE));
		foreach($tasks as $task) {
			if ($status == 'A') {
				$task['notes'] = "Active By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'];
				$task['finished'] = 0;
			} else {
				$task['notes'] = "Deactivate By :" . $this->ion_auth->get_user_id() . "; " . $task['notes'];
				$task['finished'] = 1;
			}
			$task['status'] = Mytask_model::STATUS_COMPLETED;
			$taks_id = $this->mytask_model->save($task);
		}
		
		if ($status == 'A') {
			$this->session->set_flashdata('success', "Case Active successfully.");
		} else {
			$this->session->set_flashdata('success', "Case Deactivate successfully.");
		}
		
		echo TRUE;
	}
	
	// send email template for ajax request
	public function send_print_email() {
		// get all requested params
		$email = $this->input->post("email");
		$street_no = $this->input->post("street_no");
		$street_name = $this->input->post("street_name");
		$city = $this->input->post("city");
		$province = $this->input->post("province");
		$template = $this->input->post("template");
		$doc = $this->input->post("doc");
		$case_id = $this->input->post("case_id");
		
		// create pdf from template using DOM PDF
		require_once './assets/dompdf/dompdf_config.inc.php';
		$dompdf = new DOMPDF();
		$dompdf->load_html($template);
		$dompdf->render();
		$output = $dompdf->output();
		$filename = trim($doc) . rand(999, 999999) . '.pdf';
		$filepath = UPLOADFULLPATH . "temp/" . $filename;
		file_put_contents($filepath, $output);
		
		// generate data array
		$intake_notes = array(
				"Email: " . $email,
				"Street No: " . $street_no,
				"Street Name: " . $street_name,
				"City: " . $city,
				"Province: " . $province 
		);
		$data_intake = array(
				'case_id' => $case_id,
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => implode(", ", $intake_notes),
				'created' => date("Y-m-d H:i:s"),
				'docs' => $filename 
		);
		
		// save values to database
		$intake_form_id = $this->common_model->save("intake_form", $data_intake);
		
		// create directory to identify intake files
		@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
		
		// move all files to that directory
		copy(UPLOADFULLPATH . "temp/$filename", UPLOADFULLPATH . "intake_forms/$intake_form_id/$filename");
		unlink(UPLOADFULLPATH . "temp/$filename");
		
		// send success message
		$this->session->set_flashdata('success', "Email successfully sent.");
		
		// send email notification to provider email address
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from(FROM_EMAIL, SITE_TITLE);
		$this->email->to($email);
		
		$this->email->subject("Received $doc");
		$this->email->message($data_intake['notes']);
		$this->email->attach(UPLOADFULLPATH . "intake_forms/$intake_form_id/$filename");
		$this->email->send();
		echo TRUE;
	}
	
	// redirect if needed, otherwise display the claim page
	public function claim() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			// initialize variables
			$this->data['cases'] = [];
			$this->data['policies'] = [];
			
			// search case filter
			if ($this->input->get("filter") == 'case') {
				// get all providers list
				$order_by = array(
						'field' => 'id',
						'order' => 'desc' 
				);
				
				$joins[] = array(
						'table' => 'users u1',
						'on' => 'u1.id = case.assign_to',
						'type' => 'LEFT' 
				);
				$joins[] = array(
						'table' => 'users u2',
						'on' => 'u2.id = case.case_manager',
						'type' => 'LEFT' 
				);
				
				// prepare conditions
				$conditions = [];
				if ($this->input->get("case_no"))
					$conditions['case.case_no'] = $this->input->get("case_no");
				if ($this->input->get("policy_no"))
					$conditions['case.policy_no'] = $this->input->get("policy_no");
				if ($this->input->get("client_user_name"))
					$conditions['concat_ws(" ", case.insured_firstname, case.insured_lastname) like'] = "%" . $this->input->get("client_user_name") . "%";
				if ($this->input->get("created"))
					$conditions['case.created like'] = "%" . $this->input->get("created") . "%";
				if ($this->input->get("assign_to"))
					$conditions['case.assign_to'] = $this->input->get("assign_to");
				if ($this->input->get("case_manager"))
					$conditions['case.case_manager'] = $this->input->get("case_manager");
				
				$fields = "concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, IF(case.dob='1970-01-01', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id";
				$this->data['cases'] = $this->common_model->select($record = "list", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array());
			} else if ($this->input->get("filter") == 'policy') {
				
				// prepare post data array
				$this->data['params'] = $this->input->get();
				$this->data['params']['key'] = API_KEY;
				
				foreach ( $this->data['params'] as $k => $v ) {
					$this->data['params'][$k] = trim($v);
				}
				// search policy code here
				$url = API_URL . "search";
				$curl = curl_init();
				
				// Post Data
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data['params']);
				
				// Optional Authentication:
				if (API_USER and API_PASSWORD) {
					curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					curl_setopt($curl, CURLOPT_USERPWD, API_USER . ":" . API_PASSWORD);
				}
				
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
				curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
				curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
				curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
				
				$result = curl_exec($curl);
				$result = json_decode($result, TRUE);
				
				// pass policies data to view
				$this->data['policies'] = @$result['plan_list'];
				$this->data['status'] = @$result['status_list'];
				
				curl_close($curl);
			}
			
			// send case manager and eac managers list
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = $this->input->get($field_name), $group = array(
					"'eacmanager'",
					"'casemamager'" 
			), $empty = "--Assign To--");
			$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--");
			
			// send countries and province list
			$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['policy_status'] = $this->common_model->get_policy_status($field_name = "status_id", $selected = $this->input->get($field_name));
			$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->get($field_name));
			
			// render view data
			$this->template->write('title', SITE_TITLE . ' - Claim', TRUE);
			$this->template->write_view('content', 'emergency_assistance/claim', $this->data);
			$this->template->render();
		}
	}
	
	// get policy information from jfinsurance database
	function get_policy_info() {
		// prepare post data array
		$this->data['params'] = $this->input->get();
		$this->data['params']['key'] = API_KEY;
		
		// search policy code here
		$url = API_URL . "search";
		$curl = curl_init();
		
		// Post Data
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data['params']);
		
		// Optional Authentication:
		if (API_USER and API_PASSWORD) {
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, API_USER . ":" . API_PASSWORD);
		}
		
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		
		$result = curl_exec($curl);
		if ($result) {
			curl_close($curl);
			echo $result;
		} else {
			echo curl_error($curl);
			curl_close($curl);
			echo json_encode(array(
					"error" => "Access Server Error" 
			));
		}
		die();
	}
	
	// get provinces list from country name
	function get_provinces($type = 'return', $country_name = '', $selected = '') {
		// get country id from name
		$country_name = urldecode($country_name);
		$this->load->model('province_model');
		
		if (empty($country_name)) $country_name = "CA";
		
		$provinces = $this->province_model->get_list_by_country_short($country_name);
		$html  = "<select name=\"province\" class=\"form-control\">\n";
		foreach ($provinces as $short => $name) {
			$selected = '';
			if ($selected == $short) $selected = "selected";
			$html .= "<option value=\"".$short."\" ".$selected.">".$name."</option>\n";
		}
		$html .= "</select>\n";
		
		if ($type == 'return')
			return $html;
		else
			echo $html;
	}
	
	// to clear schedule for eac users
	function clear_schedule() {
		$date = $this->input->post('selected_date');
		$selected_week = $this->input->post('selected_week');
		$selected_month = $this->input->post('selected_month');
		
		$employee_id = $this->input->get('employee_id');
		
		if ($date) {
			$conditions = array(
					'date' => $date 
			);
		}
		if ($selected_week) {
			$dates = explode(' to ', $selected_week);
			$conditions = array();
			$conditions['date >= '] = $dates[0];
			$conditions['date <= '] = $dates[1];
		}
		if ($selected_month) {
			$conditions = array(
					'date like ' => "%$selected_month%" 
			);
		}
		if ($employee_id) {
			$conditions['employee_id'] = $employee_id;
		}
		
		if (isset($conditions)) {
			$this->common_model->delete('schedule', $conditions);
		}
		echo TRUE;
	}
}
