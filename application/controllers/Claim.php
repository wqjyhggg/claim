<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 */
class Claim extends CI_Controller {
	private $limit = 10;
	
	public function __construct() {
		parent::__construct();
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the claim page
	public function index() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('api_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			$this->load->model('users_model');
			
			$post = $this->input->post();
			if (empty($post)) $post = $this->input->get();
			$this->data['policies'] = $this->api_model->get_policy($post);
			
			$products = FALSE;
			if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
				$products = $this->ion_auth->get_users_products();

				if (empty($products)) {
					return show_error('Sorry, Unknown products.');
				}
				foreach ($this->data['policies'] as $key => $val) {
					if (!in_array($val['product_short'], $products)) {
						unset($this->data['policies'][$key]);
					}
				}
			}
			

			// pass policies data to view
			$this->data['policies_error'] = $this->api_model->errormsg;
			if ($this->data['policies_error'] == 'Empty query condition') $this->data['policies_error'] = ''; 
			$this->data['policies_success'] = $this->api_model->success;
			$this->data['policy_status'] = $this->api_model->status_list;
			// echo "<pre>"; print_r($this->input->post()); print_r($this->data['policy_status']); die("XX"); //XXXXXXXXXXXx
			if ($this->input->post_get('case_no') || $this->input->post_get('claim_no')) {
				$this->data['cases'] = $this->case_model->post_search($this->input->post(), $this->data['policies']);
			} else {
				$this->data['cases'] = array();
			}
			
			$post = $this->input->post();
			if (empty($post)) {
				$post = $this->input->get();
			}
			$this->data['claims'] = $this->claim_model->post_search($post, $this->data['policies']);
			$this->data['claim_status'] = $this->claim_model->get_claim_status_list(1);
			
			// send case manager and eac managers list
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
			$this->data['mamagers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
			$this->data['examiners'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
			
			$this->data['products'] = $this->api_model->get_indexed_products();

			$this->data['is_insurer'] = ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER)) ? 1 : 0);

			// get claim examiners
			$this->data['claim_examiner'] = ''; // $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1)); $this->common_model->getrusers($field_name = "assign_user", "", $group = array("'claimexaminer'"), $empty = "--Select Claim Examiner--", $additional_conditions = " and active = '1'");
			                                    
			// render view data
			$this->template->write('title', SITE_TITLE . ' - Claim', TRUE);
			$this->template->write_view('content', 'claim/index', $this->data);
			$this->template->render();
		}
	}

	public function delete_expenses_provider() {
		$json = array("status" => 0, "message" => 'Sorry, you don\'t have any permission to access this function.');
		if ($this->ion_auth->logged_in()) {
			$post = $this->input->post();
			if (!empty($post['expenses_provider_id'])) {
				$data = array(
						'id' => $post['expenses_provider_id'],
						'status' => 0,
				);
				$id = $this->claim_model->expenses_provider_save($data);
				$json = array("status" => 1);
			}
		}
	}

	public function update_expenses_provider() {
		if ($this->ion_auth->logged_in()) {
			// validate input
			$post = $this->input->post();
			if (empty($post['address']) || empty($post['city']) || empty($post['province']) || empty($post['country']) || empty($post['postcode'])) {
				$json = array("status" => 0, "message" => 'Missing parameter.');
			} else {
				// insert item provider information
				$data = array(
						'claim_id' => $post['claim_id'],
						'address' => $post['address'],
						'city' => $post['city'],
						'province' => $post['province'],
						'country' => $post['country'],
						'postcode' => $post['postcode']
				);
				$id = $this->claim_model->expenses_provider_save($data);
				if ($id) {
					array("status" => 1, "id" => $id);
				} else {
					array("status" => 0, "message" => 'Sorry, something wrong. Please try it again');
				}
			}
		} else {
			$json = array("status" => 0, "message" => 'Sorry, you don\'t have any permission to access this function.');
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}
	
	// redirect if needed, otherwise display the create claim page
	public function create_claim() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			// validate form input
			$this->form_validation->set_rules('diagnosis', 'Diagnosis ', 'required');
			$this->form_validation->set_rules('date_symptoms', 'Date symptoms or injury first appeared ', 'required');
			$this->form_validation->set_rules('insured_first_name', 'Insured First Name ', 'required');
			$this->form_validation->set_rules('insured_last_name', 'Insured Last Name ', 'required');
			$this->form_validation->set_rules('guardian_name', 'Guardian Name ', '');
			$this->form_validation->set_rules('city', 'city ', '');
			$this->form_validation->set_rules('province', 'province ', 'alpha');
			$this->form_validation->set_rules('full_name', 'full name ', '');
			$this->form_validation->set_rules('employee_name', 'employee name ', '');
			$this->form_validation->set_rules('city_town', 'city town ', '');
			
			//$this->form_validation->set_rules('employee_telephone', 'employee telephone ', 'numeric');
			$this->form_validation->set_rules('amount_billed_org', 'amount billed ', 'numeric');
			$this->form_validation->set_rules('account_cheque', 'account no ', 'numeric');
			$this->form_validation->set_rules('amount_client_paid_org', 'amount client paid ', 'numeric');
			$this->form_validation->set_rules('physician_name_canada', 'physician name canada ', '');
			$this->form_validation->set_rules('physician_city', 'physician city ', '');
			$this->form_validation->set_rules('payee_name', 'payee name ', '');
			$this->form_validation->set_rules('bank', 'bank name ', '');
			$this->form_validation->set_rules('physician_city_canada', 'physician city canada ', '');
			//$this->form_validation->set_rules('guardian_phone', 'Guardian Phone ', 'numeric');
			//$this->form_validation->set_rules('telephone', 'Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone', 'Physician Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone_canada', 'physician alt telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone_canada', 'physician telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone', 'physician alt telephone ', 'numeric');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			
			// $this->form_validation->set_rules('school_name', 'School Name', 'required');
			
			$this->form_validation->set_rules('contact_first_name', 'First Name', '');
			$this->form_validation->set_rules('contact_last_name', 'Last Name', '');
			$this->form_validation->set_rules('contact_email', 'Email', 'valid_email');
			//$this->form_validation->set_rules('contact_phone', 'physician alt telephone ', 'numeric');
			
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('case_no', 'Case No', 'alpha_numeric_spaces');
			
			$this->load->model('master_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
			$this->load->model('expenses_model');
			$this->load->model('provider_model');

			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data =[ ];
				$array = $this->input->post();
				
				foreach ( $array as $key => $value ) {
					// code...
					if ($key != "Examine" && $key != "filter" && $key != "same_policy" && $key != "Save" && $key != "files_multi" && $key != "payees" && $key != "eprovider" && $key != "files" && $key != "expenses_claimed" && ! strpos($key, "otes_") && ! strpos($key, "iles_") && $key != "no_of_form" && ! strpos($key, "ile_pdf") && ! strpos($key, "ayment_type"))
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->get_user_id();
				
				// set default status processing
				if (! $data['status'])
					$data['status'] = Claim_model::STATUS_Processing;
					
					// upload claim pdf files to server
				$files = @$_FILES['files_multi'];
				$file_names =[ ];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'claim_files/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if (! empty($files)) {
					foreach ( $files['name'] as $key => $value ) {
						if ($files['name'][$key]) {
							$_FILES['userfile']['name'] = $files['name'][$key];
							$_FILES['userfile']['type'] = $files['type'][$key];
							$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
							$_FILES['userfile']['error'] = $files['error'][$key];
							$_FILES['userfile']['size'] = $files['size'][$key];
							
							// upload file to server
							$this->upload->do_upload();
							$file_data = $this->upload->data();
							$file_names[] = $file_data['file_name'];
						}
					}
				}
				$data['files'] = implode(",", $file_names);
				
				$data['id'] = 0;
				if (! empty($case_no = $this->input->post('case_no'))) {
					$case = $this->case_model->get_id_by_case_no($case_no); // Get case
					if ($case) {
						$data['id'] = $case['id'];
						$data['claim_no'] = $claim_no = $data['case_no'];
					}
				}
				if (empty($data['id'])) {
					$data['id'] = $this->master_model->get_id('claim'); // Get new id
					$data['claim_no'] = $claim_no = $this->claim_model->generate_claim_no($data['id']);
				}
				// insert values to database
				$record_id = $this->claim_model->save($data);
				$record_id = $data['id'];
				
				// create directory to copy/shift files
				@mkdir(UPLOADFULLPATH . 'claim_files/' . $record_id, 0777);
				
				// move all files to that directory
				if (! empty($file_names))
					foreach ( $file_names as $fname ) {
						copy(UPLOADFULLPATH . "claim_files/$fname", UPLOADFULLPATH . "claim_files/$record_id/$fname");
						unlink(UPLOADFULLPATH . "claim_files/$fname");
					}
					
				// insert payee information
				if (! empty($array['payees'])) {
					foreach ( $array['payees']['id'] as $key => $val ) {
						$payee_data = array(
								'id' => $val,
								'claim_id' => $record_id 
						);
						$this->claim_model->payees_save($payee_data);
					}
				}
				// update eprovider claim id
				if (! empty($array['eprovider'])) {
					foreach ( $array['eprovider']['id'] as $key => $val ) {
						$epdata = array(
								'id' => $val,
								'claim_id' => $record_id
						);
						$this->claim_model->expenses_provider_save($epdata);
					}
				}
				if (! empty($data['case_no'])) {
					$this->common_model->update("case", array(
							"claim_no" => $claim_no 
					), array(
							"case_no" => $data['case_no'] 
					));
				}
				
				// insert expenses_claimed data
				if (! empty($array['expenses_claimed'])) {
					$i = 0;
					foreach ( $array['expenses_claimed']['invoice'] as $key => $val ) {
						$i ++;
						$payee_data = array(
								'claim_id' => $record_id,
								'cellular' => $array['cellular'],
								'invoice' => $val,
								'claim_no' => $claim_no,
								'claim_item_no' => $claim_no . '_' . $i,
								'case_no' => $array['case_no'],
								'provider_type' => $array['expenses_claimed']['provider_type'][$key],
								'expenses_provider_id' => $array['expenses_claimed']['expenses_provider_id'][$key],
								'provider_name' => $array['expenses_claimed']['provider_name'][$key],
								'referencing_physician' => $array['expenses_claimed']['referencing_physician'][$key],
								'coverage_code' => $array['expenses_claimed']['coverage_code'][$key],
								'diagnosis' => '', // $array['expenses_claimed']['diagnosis'][$key],
								'service_description' => $array['expenses_claimed']['service_description'][$key],
								'date_of_service' => $array['expenses_claimed']['date_of_service'][$key],
								'amount_billed_org' => $array['expenses_claimed']['amount_billed_org'][$key],
								'amount_billed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_billed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'amount_client_paid_org' => $array['expenses_claimed']['amount_client_paid_org'][$key],
								'amount_client_paid' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_client_paid_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'amount_claimed_org' => $array['expenses_claimed']['amount_claimed_org'][$key],
								'amount_claimed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_claimed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'payee' => $array['expenses_claimed']['payee'][$key],
								'pay_to' => $array['expenses_claimed']['pay_to'][$key],
								'third_party_payee' => $array['expenses_claimed']['third_party_payee'][$key],
								'comment' => '', // $array['expenses_claimed']['comment'][$key],
								'status' => Expenses_model::EXPENSE_STATUS_Received,
								'created_by' => $this->ion_auth->get_user_id(),
								'finalize_date' => date('Y-m-d'),
								'created' => date('Y-m-d H:i:s') 
						);
						$this->common_model->save("expenses_claimed", $payee_data);
						// Need to update claim id when first time create
						$payee_data = array(
								'claim_id' => $record_id,
								'id' => $array['expenses_claimed']['expenses_provider_id'][$key]
						);
						$this->claim_model->expenses_provider_save($payee_data);
					}
				}
				
				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if ($no_of_form) {
					// add intake form batch
					for($i = 1; $i <= $no_of_form; $i ++) {
						// initialize file names array
						$file_names =[ ];
						
						// upload files to server
						$files = @$_FILES['files_' . $i];
						if (! empty($files)) {
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
								'created' => date("Y-m-d H:i:s"),
								'docs' => implode(",", $file_names),
								'type' => 'CLAIM' 
						);
						
						// if file is getting from email/print function
						if (@$array['file_pdf_' . $i]) {
							$data_intake['docs'] = $array['file_pdf_' . $i];
						}
						
						// save values to database
						$intake_form_id = $this->common_model->save("intake_form", $data_intake);
						
						// create directory to identify intake files
						@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
						
						// if file is getting from email/print function
						if (@$array['file_pdf_' . $i]) {
							$fname = $array['file_pdf_' . $i];
							copy(UPLOADFULLPATH . "temp/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
							unlink(UPLOADFULLPATH . "temp/$fname");
						}
						// move all files to that directory
						if (! empty($file_names))
							foreach ( $file_names as $fname ) {
								copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "intake_forms/$fname");
							}
					}
				}
				
				$assign_to = $array = $this->input->post('assign_to');
				if (empty($assign_to)) {
					$assign_to = $this->mytask_model->get_auto_assign_examiner_id();
				}
				
				// settings for my task section for case manager
				$task_data = array(
						'user_id' => $assign_to,
						'item_id' => $record_id,
						'task_no' => $claim_no,
						'category' => Mytask_model::CATEGORY_CLAIMS,
						'type' => Mytask_model::TASK_TYPE_CLAIM,
						'due_date' => date("Y-m-d", time() + 86400),
						'due_time' => date("H:i:s", time() + 86400),
						'priority' => Mytask_model::PRIORITY_LOW,
						'status' => Mytask_model::STATUS_ASSIGNED,
						'created_by' => $this->ion_auth->get_user_id(),
						'created' => date('Y-m-d H:i:s'),
						'user_type' => Mytask_model::USER_TYPE_EXAM
				);
				// insert values to database
				$this->mytask_model->save($task_data);
				
				// send success message
				$this->session->set_flashdata('success', "Claim successfully created");
				
				if ($this->input->post('Examine') == 'Examine')
					// redirect them to the examine claim page
					redirect("claim/examine_claim/$record_id");
				else
					// redirect them to the claim page
					redirect("claim/claim_detail/$record_id");
			} else {
				$this->load->model('api_model');
				$this->load->model('country_model');
				$this->load->model('province_model');
				$this->load->model('template_model');
				$this->load->model('product_model');
				$this->load->model('word_comments_model');
				
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->country_model->get_list(TRUE);
				$this->data['country2'] = $this->country_model->get_list(FALSE);
				$this->data['province'] = $this->province_model->get_list_by_country_short($this->input->post('country') ? $this->input->post('country') : 'CA');
				$this->data['province2'] = $this->province_model->get_list_by_country_short($this->input->post('country2') ? $this->input->post('country2') : 'CA');
				$this->data['products'] = $this->product_model->get_list();
				$this->data['expenses_list'] = $this->expenses_model->get_coverage_code();
				$this->data['currencies'] = $this->expenses_model->get_currencies();
				$this->data['bprovider_list'] = $this->provider_model->search(array("status" => Provider_model::ACTIVE));
				$this->data['eprovider_list'] = array();
				$this->data['payees_list'] = array();
				if ($arr = $this->input->post('eprovider')) {
					foreach ($arr['id'] as $key => $val) {
						$this->data['eprovider_list'][$key]['id'] = $val; // id
						$this->data['eprovider_list'][$key]['name'] = $arr['name'][$key];
						$this->data['eprovider_list'][$key]['address'] = $arr['address'][$key];
						$this->data['eprovider_list'][$key]['city'] = $arr['city'][$key];
						$this->data['eprovider_list'][$key]['province'] = $arr['province'][$key];
						$this->data['eprovider_list'][$key]['country'] = $arr['country'][$key];
						$this->data['eprovider_list'][$key]['postcode'] = $arr['postcode'][$key];
					}
				}
				if ($arr = $this->input->post('payees')) {
					foreach ($arr['id'] as $key => $val) {
						$this->data['payees_list'][$key]['id'] = $val; // id
						$this->data['payees_list'][$key]['payment_type'] = $arr['payment_type'][$key];
						$this->data['payees_list'][$key]['payee_name'] = $arr['payee_name'][$key];
						$this->data['payees_list'][$key]['bank'] = $arr['bank'][$key];
						$this->data['payees_list'][$key]['account_cheque'] = $arr['account_cheque'][$key];
						$this->data['payees_list'][$key]['address'] = $arr['address'][$key];
						$this->data['payees_list'][$key]['city'] = $arr['city'][$key];
						$this->data['payees_list'][$key]['province'] = $arr['province'][$key];
						$this->data['payees_list'][$key]['country'] = $arr['country'][$key];
						$this->data['payees_list'][$key]['postcode'] = $arr['postcode'][$key];
					}
				}
				
				$policy = $this->input->get('policy');
				$this->data['policy'] = array();
				if (!empty($policy)) {
					if ($policies = $this->api_model->get_policy(array('policy' => $policy))) {
						$this->data['policy'] = $policies[0];
					}
				}
				$case_no = $this->input->get('case_no');
				if (!empty($case_no)) {
					$this->data["case_no"] = $case_no;
				}
				$product_short = $this->input->get('product_short');
				if (!empty($product_short)) {
					$this->data["product_short"] = $product_short;
				}
				
				$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CLAIM));
				$this->data['status_list'] = $this->claim_model->get_claim_status_list(TRUE);
				
				$this->data['examiners'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
				
				// get all word documents
				$fields = "id, title, content";
				// $this->data['word_templates'] = $this->word_comments_model->search(array()); // $this->common_model->select($record = "list", $typecast = "array", $table = "word_comments", $fields);
				$this->data['word_templates'] = $this->data['word_templates'] = $this->word_comments_model->search(array());
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Claim', TRUE);
				$this->template->write_view('content', 'claim/create_claim', $this->data);
				$this->template->render();
			}
		}
	}

	// redirect if needed, otherwise display the create claim page
	public function create_other($formtype='') {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			// validate form input
			if (($formtype != "top_baggage") && ($formtype != "top_trip")) {
				$this->form_validation->set_rules('diagnosis', 'Diagnosis ', 'required');
				$this->form_validation->set_rules('date_symptoms', 'Date symptoms or injury first appeared ', 'required');
			}
			$this->form_validation->set_rules('insured_first_name', 'Insured First Name ', 'required');
			$this->form_validation->set_rules('insured_last_name', 'Insured Last Name ', 'required');
			$this->form_validation->set_rules('guardian_name', 'Guardian Name ', '');
			$this->form_validation->set_rules('city', 'city ', '');
			$this->form_validation->set_rules('province', 'province ', 'alpha');
			$this->form_validation->set_rules('full_name', 'full name ', '');
			$this->form_validation->set_rules('employee_name', 'employee name ', '');
			$this->form_validation->set_rules('city_town', 'city town ', '');
			//$this->form_validation->set_rules('employee_telephone', 'employee telephone ', 'numeric');
			$this->form_validation->set_rules('amount_billed', 'amount billed ', 'numeric');
			$this->form_validation->set_rules('account_cheque', 'account no ', 'numeric');
			$this->form_validation->set_rules('amount_client_paid', 'amount client paid ', 'numeric');
			$this->form_validation->set_rules('physician_name_canada', 'physician name canada ', '');
			$this->form_validation->set_rules('physician_city', 'physician city ', '');
			$this->form_validation->set_rules('payee_name', 'payee name ', '');
			$this->form_validation->set_rules('bank', 'bank name ', '');
			$this->form_validation->set_rules('physician_city_canada', 'physician city canada ', '');
			//$this->form_validation->set_rules('guardian_phone', 'Guardian Phone ', 'numeric');
			//$this->form_validation->set_rules('telephone', 'Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone', 'Physician Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone_canada', 'physician alt telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone_canada', 'physician telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone', 'physician alt telephone ', 'numeric');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
				
			$this->form_validation->set_rules('contact_first_name', 'First Name', '');
			$this->form_validation->set_rules('contact_last_name', 'Last Name', '');
			$this->form_validation->set_rules('contact_email', 'Email', 'valid_email');
			//$this->form_validation->set_rules('contact_phone', 'physician alt telephone ', 'numeric');
				
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('case_no', 'Case No', 'alpha_numeric_spaces');
				
			$this->load->model('master_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
			$this->load->model('expenses_model');
			$this->load->model('provider_model');

			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data =[ ];
				$array = $this->input->post();
	
				foreach ( $array as $key => $value ) {
					// code...
					if ($key != "exinfo" && $key != "Examine" && $key != "filter" && $key != "same_policy" && $key != "Save" && $key != "files_multi" && $key != "payees" && $key != "eprovider" && $key != "files" && $key != "expenses_claimed" && ! strpos($key, "otes_") && ! strpos($key, "iles_") && $key != "no_of_form" && ! strpos($key, "ile_pdf") && ! strpos($key, "ayment_type")) {
						$data[$key] = $value;
					} else if ($key == "exinfo") {
						$data["exinfo"] = json_encode($value);
						$data['exinfo_type'] = $formtype;
					}
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->get_user_id();
	
				// set default status processing
				if (! $data['status'])
					$data['status'] = Claim_model::STATUS_Processing;
						
					// upload claim pdf files to server
					$files = @$_FILES['files_multi'];
					$file_names =[ ];
	
					// load upload class
					$config['upload_path'] = UPLOADFULLPATH . 'claim_files/';
					$config['allowed_types'] = '*';
					$config['overwrite'] = FALSE;
					$this->load->library('upload', $config);
	
					// initialize upload config
					$this->upload->initialize($config);
					if (! empty($files)) {
						foreach ( $files['name'] as $key => $value ) {
							if ($files['name'][$key]) {
								$_FILES['userfile']['name'] = $files['name'][$key];
								$_FILES['userfile']['type'] = $files['type'][$key];
								$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
								$_FILES['userfile']['error'] = $files['error'][$key];
								$_FILES['userfile']['size'] = $files['size'][$key];
									
								// upload file to server
								$this->upload->do_upload();
								$file_data = $this->upload->data();
								$file_names[] = $file_data['file_name'];
							}
						}
					}
					$data['files'] = implode(",", $file_names);
	
					$data['id'] = 0;
					if (! empty($case_no = $this->input->post('case_no'))) {
						$case = $this->case_model->get_id_by_case_no($case_no); // Get case
						if ($case) {
							$data['id'] = $case['id'];
							$data['claim_no'] = $claim_no = $data['case_no'];
						}
					}
					if (empty($data['id'])) {
						$data['id'] = $this->master_model->get_id('claim'); // Get new id
						$data['claim_no'] = $claim_no = $this->claim_model->generate_claim_no($data['id']);
					}
					// insert values to database
					$record_id = $this->claim_model->save($data);
					$record_id = $data['id'];
	
					// create directory to copy/shift files
					@mkdir(UPLOADFULLPATH . 'claim_files/' . $record_id, 0777);
	
					// move all files to that directory
					if (! empty($file_names))
						foreach ( $file_names as $fname ) {
							copy(UPLOADFULLPATH . "claim_files/$fname", UPLOADFULLPATH . "claim_files/$record_id/$fname");
							unlink(UPLOADFULLPATH . "claim_files/$fname");
						}
						
					// insert payee information
					if (! empty($array['payees'])) {
						foreach ( $array['payees']['id'] as $key => $val ) {
							$payee_data = array(
									'id' => $val,
									'claim_id' => $record_id
							);
							$this->claim_model->payees_save($payee_data);
						}
					}
					// update eprovider claim id
					if (! empty($array['eprovider'])) {
						foreach ( $array['eprovider']['id'] as $key => $val ) {
							$epdata = array(
									'id' => $val,
									'claim_id' => $record_id
							);
							$this->claim_model->expenses_provider_save($epdata);
						}
					}
					if (! empty($data['case_no'])) {
						$this->common_model->update("case", array(
								"claim_no" => $claim_no
						), array(
								"case_no" => $data['case_no']
						));
					}
	
					// insert expenses_claimed data
					if (! empty($array['expenses_claimed'])) {
						$i = 0;
						foreach ( $array['expenses_claimed']['invoice'] as $key => $val ) {
							$i ++;
							$payee_data = array(
									'claim_id' => $record_id,
									'cellular' => $array['cellular'],
									'invoice' => $val,
									'claim_no' => $claim_no,
									'claim_item_no' => $claim_no . '_' . $i,
									'case_no' => $array['case_no'],
									'provider_name' => $array['expenses_claimed']['provider_name'][$key],
									'provider_type' => isset($array['expenses_claimed']['provider_type'][$key]) ? $array['expenses_claimed']['provider_type'][$key] : '',
									'expenses_provider_id' => isset($array['expenses_claimed']['expenses_provider_id'][$key]) ? $array['expenses_claimed']['expenses_provider_id'][$key] : 0,
									'referencing_physician' => $array['expenses_claimed']['referencing_physician'][$key],
									'coverage_code' => $array['expenses_claimed']['coverage_code'][$key],
									'diagnosis' => '', // $array['expenses_claimed']['diagnosis'][$key],
									'service_description' => $array['expenses_claimed']['service_description'][$key],
									'date_of_service' => $array['expenses_claimed']['date_of_service'][$key],
									'amount_billed_org' => $array['expenses_claimed']['amount_billed_org'][$key],
									'amount_billed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_billed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
									'amount_client_paid_org' => $array['expenses_claimed']['amount_client_paid_org'][$key],
									'amount_client_paid' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_client_paid_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
									'amount_claimed_org' => $array['expenses_claimed']['amount_claimed_org'][$key],
									'amount_claimed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_claimed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
									'payee' => $array['expenses_claimed']['payee'][$key],
									'pay_to' => $array['expenses_claimed']['pay_to'][$key],
									'third_party_payee' => $array['expenses_claimed']['third_party_payee'][$key],
									'comment' => '', // $array['expenses_claimed']['comment'][$key],
									'status' => Expenses_model::EXPENSE_STATUS_Received,
									'created_by' => $this->ion_auth->get_user_id(),
									'finalize_date' => date('Y-m-d'),
									'created' => date('Y-m-d H:i:s')
							);
							$this->common_model->save("expenses_claimed", $payee_data);
							// Need to update claim id when first time create
							$payee_data = array(
									'claim_id' => $record_id,
									'id' => $array['expenses_claimed']['expenses_provider_id'][$key]
							);
							$this->claim_model->expenses_provider_save($payee_data);
						}
					}
	
					// insert intake forms if exists
					$no_of_form = $array['no_of_form'];
	
					// load upload class
					$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
					$config['allowed_types'] = '*';
					$config['overwrite'] = FALSE;
					$this->load->library('upload', $config);
	
					// initialize upload config
					$this->upload->initialize($config);
					if ($no_of_form) {
						// add intake form batch
						for($i = 1; $i <= $no_of_form; $i ++) {
							// initialize file names array
							$file_names =[ ];
	
							// upload files to server
							$files = @$_FILES['files_' . $i];
							if (! empty($files)) {
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
									'created' => date("Y-m-d H:i:s"),
									'docs' => implode(",", $file_names),
									'type' => 'CLAIM'
							);
	
							// if file is getting from email/print function
							if (@$array['file_pdf_' . $i]) {
								$data_intake['docs'] = $array['file_pdf_' . $i];
							}
	
							// save values to database
							$intake_form_id = $this->common_model->save("intake_form", $data_intake);
	
							// create directory to identify intake files
							@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
	
							// if file is getting from email/print function
							if (@$array['file_pdf_' . $i]) {
								$fname = $array['file_pdf_' . $i];
								copy(UPLOADFULLPATH . "temp/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "temp/$fname");
							}
							// move all files to that directory
							if (! empty($file_names))
								foreach ( $file_names as $fname ) {
									copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
									unlink(UPLOADFULLPATH . "intake_forms/$fname");
								}
						}
					}
	
					$assign_to = $array = $this->input->post('assign_to');
					if (empty($assign_to)) {
						$assign_to = $this->mytask_model->get_auto_assign_examiner_id();
					}
	
					// settings for my task section for case manager
					$task_data = array(
							'user_id' => $assign_to,
							'item_id' => $record_id,
							'task_no' => $claim_no,
							'category' => Mytask_model::CATEGORY_CLAIMS,
							'type' => Mytask_model::TASK_TYPE_CLAIM,
							'due_date' => date("Y-m-d", time() + 86400),
							'due_time' => date("H:i:s", time() + 86400),
							'priority' => Mytask_model::PRIORITY_LOW,
							'status' => Mytask_model::STATUS_ASSIGNED,
							'created_by' => $this->ion_auth->get_user_id(),
							'created' => date('Y-m-d H:i:s'),
							'user_type' => Mytask_model::USER_TYPE_EXAM
					);
					// insert values to database
					$this->mytask_model->save($task_data);
	
					// send success message
					$this->session->set_flashdata('success', "Claim successfully created");
	
					if ($this->input->post('Examine') == 'Examine') {
						// redirect them to the examine claim page
						redirect("claim/examine_claim/$record_id");
					} else {
						// redirect them to the claim page
						redirect("claim/claim_detail/$record_id");
					}
			} else {
				$this->load->model('api_model');
				$this->load->model('country_model');
				$this->load->model('province_model');
				$this->load->model('template_model');
				$this->load->model('product_model');
				$this->load->model('word_comments_model');
	
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->country_model->get_list(TRUE);
				$this->data['country2'] = $this->country_model->get_list(FALSE);
				$this->data['province'] = $this->province_model->get_list_by_country_short($this->input->post('country') ? $this->input->post('country') : 'CA');
				$this->data['province2'] = $this->province_model->get_list_by_country_short($this->input->post('country2') ? $this->input->post('country2') : 'CA');
				$this->data['products'] = $this->product_model->get_list();
				$this->data['expenses_list'] = $this->expenses_model->get_coverage_code();
				$this->data['currencies'] = $this->expenses_model->get_currencies();
				$this->data['bprovider_list'] = $this->provider_model->search(array("status" => Provider_model::ACTIVE));
				$this->data['eprovider_list'] = array();
				$this->data['payees_list'] = array();
				if ($arr = $this->input->post('eprovider')) {
					foreach ($arr['id'] as $key => $val) {
						$this->data['eprovider_list'][$key]['id'] = $val; // id
						$this->data['eprovider_list'][$key]['name'] = $arr['name'][$key];
						$this->data['eprovider_list'][$key]['address'] = $arr['address'][$key];
						$this->data['eprovider_list'][$key]['city'] = $arr['city'][$key];
						$this->data['eprovider_list'][$key]['province'] = $arr['province'][$key];
						$this->data['eprovider_list'][$key]['country'] = $arr['country'][$key];
						$this->data['eprovider_list'][$key]['postcode'] = $arr['postcode'][$key];
					}
				}
				if ($arr = $this->input->post('payees')) {
					foreach ($arr['id'] as $key => $val) {
						$this->data['payees_list'][$key]['id'] = $val; // id
						$this->data['payees_list'][$key]['payment_type'] = $arr['payment_type'][$key];
						$this->data['payees_list'][$key]['payee_name'] = $arr['payee_name'][$key];
						$this->data['payees_list'][$key]['bank'] = $arr['bank'][$key];
						$this->data['payees_list'][$key]['account_cheque'] = $arr['account_cheque'][$key];
						$this->data['payees_list'][$key]['address'] = $arr['address'][$key];
						$this->data['payees_list'][$key]['city'] = $arr['city'][$key];
						$this->data['payees_list'][$key]['province'] = $arr['province'][$key];
						$this->data['payees_list'][$key]['country'] = $arr['country'][$key];
						$this->data['payees_list'][$key]['postcode'] = $arr['postcode'][$key];
					}
				}
				
				$policy = $this->input->get('policy');
				if (empty($policy)) {
					$policy = $this->input->post('policy_no');
				}
				$this->data['policy'] = array();
				if (!empty($policy)) {
					if ($policies = $this->api_model->get_policy(array('policy' => $policy))) {
						$this->data['policy'] = $policies[0];
					}
				}
				if ($this->input->post('exinfo')) {
					$data["exinfo"] = $this->input->post('exinfo');
				}
				$case_no = $this->input->get('case_no');
				if (!empty($case_no)) {
					$this->data["case_no"] = $case_no;
				}
				$product_short = $this->input->get('product_short');
				if (!empty($product_short)) {
					$this->data["product_short"] = $product_short;
				}
				
				$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CLAIM));
				$this->data['status_list'] = $this->claim_model->get_claim_status_list(TRUE);
	
				$this->data['examiners'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
	
				$this->data['getpara'] = '';
				if ($this->input->get()) {
					$this->data['getpara'] = '?' . http_build_query($this->input->get());
				}
				$this->data['word_templates'] = $this->data['word_templates'] = $this->word_comments_model->search(array());
	
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Create Claim', TRUE);
				switch ($formtype) {
					case "top_baggage":
						$this->template->write_view('content', 'claim/create_top_baggage', $this->data);
						break;
					case "top_medical":
						$this->template->write_view('content', 'claim/create_top_medical', $this->data);
						break;
					case "top_trip":
						$this->template->write_view('content', 'claim/create_top_trip', $this->data);
						break;
					default:
						$this->template->write_view('content', 'claim/create_other', $this->data);
						break;
				}
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the edit case page
	public function examine_claim($id = 0) {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_INSURER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else if (empty($id)) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, Unknown Claim Record.');
		} else {
			$this->load->model('api_model');
			$this->load->model('country_model');
			$this->load->model('province_model');
			$this->load->model('template_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			$this->load->model('product_model');
			$this->load->model('expenses_model');
			$this->load->model('intakeform_model');
			$this->load->model('word_comments_model');
			$this->load->model('reasons_model');
			$this->load->model('provider_model');

			$claim = $this->claim_model->get_by_id($id);
			if (empty($claim)) {
				return show_error('Sorry, Unknown Claim Record ID.');
			}
			if (!empty($claim['exinfo'])) {
				$this->data['exinfo'] = json_decode($claim['exinfo'], true);
			}
			// get claim details
			$claim['assign_to_name'] = "";
			$claim['assign_to_email'] = "";
			if ($claim && $claim['assign_to']) {
				$assign_to = $this->users_model->get_by_id($claim['assign_to']);
				if ($assign_to) {
					$claim['assign_to_name'] = $assign_to['first_name'] . " " . $assign_to['last_name'];
					$claim['assign_to_email'] = $assign_to['email'];
				}
			}
			$this->data['claim_details'] = $claim;

			$this->data['id'] = $id;
			$this->data['item_payee_name'] = '';
			$this->data['item_payee_addr1'] = '';
			$this->data['item_payee_addr2'] = '';
			$this->data['item_payee_postcode'] = '';
	
			// validate form input
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			
			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data =[ ];
				$array = $this->input->post();
				
				foreach ( $array as $key => $value ) {
					// code...
					if ($key != "Examine" && $key != "filter" && $key != "same_policy" && $key != "Save" && $key != "files_multi" && $key != "payees" && $key != "eprovider" && $key != "files" && $key != "expenses_claimed" && ! strpos($key, "otes_") && ! strpos($key, "iles_") && $key != "no_of_form" && ! strpos($key, "ile_pdf"))
						$data[$key] = $value;
				}
				
				// upload claim pdf files to server
				$files = @$_FILES['files_multi'];
				$file_names =[ ];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH;
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if (! empty($files)) {
					foreach ( $files['name'] as $key => $value ) {
						if ($files['name'][$key]) {
							$_FILES['userfile']['name'] = $files['name'][$key];
							$_FILES['userfile']['type'] = $files['type'][$key];
							$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
							$_FILES['userfile']['error'] = $files['error'][$key];
							$_FILES['userfile']['size'] = $files['size'][$key];
							
							// upload file to server
							$this->upload->do_upload();
							$file_data = $this->upload->data();
							$file_names[] = $file_data['file_name'];
						}
					}
				}
				
				// get old files
				$old_files = $this->data['claim_details']['files'];
				
				$data['files'] = ($old_files ? $old_files . "," : "") . implode(",", $file_names);
				$data['id'] = $id;
				
				$record_id = $this->claim_model->save($data);
				
				// create folder if not exists
				@mkdir(UPLOADFULLPATH . 'claim_files/' . $record_id, 0777);
				
				// move all files to that directory
				if (! empty($file_names)) {
					$dstdir = UPLOADFULLPATH . $record_id . DIRECTORY_SEPARATOR;
					if (! is_dir($dstdir)) {
						if (! mkdir($dstdir)) {
							return show_error('Can not create directory, ' . $dstdir . ', Please contact system admin. ');
						}
					}
					foreach ( $file_names as $fname ) {
						rename(UPLOADFULLPATH . $fname, $dstdir . $fname);
					}
				}
				
				// insert payee information
				if (! empty($array['payees'])) {
					$this->claim_model->payee_remove_by_claim_id($record_id);
					
					foreach ( $array['payees']['bank'] as $key => $val ) {
						$payee_data = array(
								'payment_type' => $array['payment_type_' . $key],
								'claim_id' => $record_id,
								'bank' => $val,
								'payee_name' => $array['payees']['payee_name'][$key],
								'address' => $array['payees']['address'][$key],
								'city' => $array['payees']['city'][$key],
								'province' => $array['payees']['province'][$key],
								'country' => $array['payees']['country'][$key],
								'postcode' => $array['payees']['postcode'][$key],
								'type' => isset($array['payees']['type'][$key]) ? $array['payees']['type'][$key] : '',
								'account_cheque' => $array['payees']['account_cheque'][$key],
								'created' => date('Y-m-d H:i:s') 
						);
						$this->claim_model->payees_save($payee_data);
					}
				}
				
				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if ($no_of_form) {
					// add intake form batch
					for($i = 1; $i <= $no_of_form; $i ++) {
						// initialize file names array
						$file_names =[ ];
						
						// upload files to server
						$files = $_FILES['files_' . $i];
						if (! empty($files)) {
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
								'created' => date("Y-m-d H:i:s"),
								'docs' => implode(",", $file_names),
								'type' => 'CLAIM' 
						);
						
						// save values to database
						$intake_form_id = $this->common_model->save("intake_form", $data_intake);
						
						// create directory to identify intake files
						@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
						
						// move all files to that directory
						if (! empty($file_names))
							foreach ( $file_names as $fname ) {
								copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "intake_forms/$fname");
							}
					}
				}
				
				// send success message
				$this->session->set_flashdata('success', "Claim successfully updated");
				
				// redirect them to the login page
				redirect('claim');
			} else {
				$this->data['claim'] = $claim;
				$this->data['claim_files'] = array();
				if (! empty($claim['files'])) {
					$flist = explode(',', $claim['files']);
					foreach ( $flist as $fn ) {
						if (empty($fn)) continue;
						$this->data['claim_files'][$fn] = base_url('assets/uploads/claim_files/' . $claim['id'] . "/" . $fn);
					}
				}
				
				$policy_info_arr = $this->api_model->get_policy(array('policy' => $claim['policy_no']));

				if (empty($policy_info_arr)) {
					return show_error('Unknown policy for this Claim' . $claim['policy_no'] . '.');
				}
				$this->data['policy'] = $policy_info_arr[0];
				$this->data['policy_status'] = array(
						0 => 'Unknown',
						1 => 'Quote',
						2 => 'Sold',
						3 => 'Paid',
						4 => 'Claimed',
						5 => 'Cancel',
						6 => 'Refund',
						7 => 'Changed',
				);
				// get expenses climed items list
				$this->data['items'] = $this->expenses_model->search(array('claim_id' => $claim['id']), 0, 0, array('date_of_service' => 'ASC'));
				$this->data['payinfo'] = $this->expenses_model->get_policy_payinfo($claim['policy_no']);
				
				foreach ($this->data['items'] as $ikey => $ival) {
					if ($ival['provider_type']) {
						// bussiness
						$iadd = $this->provider_model->get_by_id($ival['expenses_provider_id']);
						$this->data['items'][$ikey]['item_provider_name'] = $iadd['payeename'];
						$this->data['items'][$ikey]['item_provider_addr1'] = $iadd['address'];
						$this->data['items'][$ikey]['item_provider_addr2'] = $iadd['city'] . " " . $iadd['province'];
						$this->data['items'][$ikey]['item_provider_postcode'] = $iadd['postcode'];
						if (empty($this->data['item_provider_name'])) {
							$this->data['item_provider_name'] = $iadd['payeename'];
							$this->data['item_provider_addr1'] = $iadd['address'];
							$this->data['item_provider_addr2'] = $iadd['city'] . " " . $iadd['province'];
							$this->data['item_provider_postcode'] = $iadd['postcode'];
						}
					} else {
						// private
						$iadd = $this->claim_model->get_expenses_provider_by_id($ival['expenses_provider_id']);
						$this->data['items'][$ikey]['item_provider_name'] = $iadd['name'];
						$this->data['items'][$ikey]['item_provider_addr1'] = $iadd['address'];
						$this->data['items'][$ikey]['item_provider_addr2'] = $iadd['city'] . " " . $iadd['province'];
						$this->data['items'][$ikey]['item_provider_postcode'] = $iadd['postcode'];
						if (empty($this->data['item_provider_name'])) {
							$this->data['item_provider_name'] = $iadd['name'];
							$this->data['item_provider_addr1'] = $iadd['address'];
							$this->data['item_provider_addr2'] = $iadd['city'] . " " . $iadd['province'];
							$this->data['item_provider_postcode'] = $iadd['postcode'];
						}
					}
					$this->data['item_payee_name'] = '';
					$this->data['item_payee_addr1'] = '';
					$this->data['item_payee_addr2'] = '';
					$this->data['item_payee_postcode'] = '';
					if ((int)$ival['third_party_payee'] && ($payee = $this->provider_model->get_by_id($ival['payee']))) {
						$this->data['items'][$ikey]['item_payee_name'] = $payee['payeename'];
						$this->data['items'][$ikey]['item_payee_addr1'] = $payee['address'];
						$this->data['items'][$ikey]['item_payee_addr2'] = $payee['city'] . " " . $payee['province'];
						$this->data['items'][$ikey]['item_payee_postcode'] = $payee['postcode'];
						if (empty($this->data['item_payee_name'])) {
							$this->data['item_payee_name'] = $payee['payeename'];
							$this->data['item_payee_addr1'] = $payee['address'];
							$this->data['item_payee_addr2'] = $payee['city'] . " " . $payee['province'];
							$this->data['item_payee_postcode'] = $payee['postcode'];
						}
					} else if (($payee = $this->claim_model->get_payee_by_id($ival['payee'])) && ($payee['payment_type'] == 'cheque')) {
						$this->data['items'][$ikey]['item_payee_name'] = $payee['payee_name'];
						$this->data['items'][$ikey]['item_payee_addr1'] = $payee['address'];
						$this->data['items'][$ikey]['item_payee_addr2'] = $payee['city'] . " " . $payee['province'];
						$this->data['items'][$ikey]['item_payee_postcode'] = $payee['postcode'];
						if (empty($this->data['item_payee_name'])) {
							$this->data['item_payee_name'] = $payee['payee_name'];
							$this->data['item_payee_addr1'] = $payee['address'];
							$this->data['item_payee_addr2'] = $payee['city'] . " " . $payee['province'];
							$this->data['item_payee_postcode'] = $payee['postcode'];
						}
					} else {
						$this->data['items'][$ikey]['item_payee_name'] = '';
						$this->data['items'][$ikey]['item_payee_addr1'] = '';
						$this->data['items'][$ikey]['item_payee_addr2'] = '';
						$this->data['items'][$ikey]['item_payee_postcode'] = '';
					}
				}
				
				// get claim items history
				$this->data['claim_history'] = $this->expenses_model->expenses_history($id);
				$history = array();
				$other_claims = $this->claim_model->search(array('policy_no' => $claim['policy_no']));
				$this->data['other_items'] = array();
				foreach ( $other_claims as $other ) {
					if ($other['id'] == $claim['id']) continue;
					$this->data['other_items'] = array_merge($this->data['other_items'], $this->expenses_model->search(array('claim_id' => $other['id'])));
				}
				
				$this->data['expenses'] = $this->expenses_model->search(array('claim_id' => $id));
				
				$this->data['claim_history'] = $this->expenses_model->expenses_history($id);
				
				// load dropdowns- countries, province, products data
				/*
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name));
				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "", $key = "short_code", $value = "name");
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name), FALSE, FALSE);
				$this->data['payees'] = $this->common_model->get_payees($field_name = "payee", $selected = $this->input->post($field_name), $key = 'id', $val = 'name');
				*/
				
				$this->data['country'] = $this->country_model->get_list(TRUE);
				$this->data['country2'] = $this->country_model->get_list(FALSE);
				$this->data['province'] = $this->province_model->get_list_by_country_short($this->input->post('country') ? $this->input->post('country') : 'CA');
				$this->data['province2'] = $this->province_model->get_list_by_country_short($this->input->post('country2') ? $this->input->post('country2') : 'CA');
				$this->data['products'] = $this->product_model->get_list();
				$this->data['payees'] = $this->claim_model->payee_search(array("claim_id" => $id));
				//$this->data['bprovider_list'] = $this->provider_model->search(array("status" => Provider_model::ACTIVE));
				//$this->data['eprovider_list'] = $this->claim_model->expenses_provider_search(array("claim_id" => $id, "status" => 1));
				$this->data['expenses_list'] = $this->expenses_model->get_coverage_code2();
				
				$this->data['reasons'] = $this->reasons_model->get_list();
				
				// get all documents for sending email/print.
				$this->data['docs'] = $this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CLAIM));
				
				// get all payees infomation
				$this->data['custom_payees'] = $this->data['payees'];
				
				// get intake forms
				$this->data['intake_forms'] = $this->intakeform_model->get_list_by_case_id($id, 'CLAIM');
				
				$this->data['case_details'] = $this->case_model->get_by_id($id);
				if ($this->data['case_details'] && $this->data['case_details']['assign_to']) {
					$assign_to = $this->users_model->get_by_id($this->data['case_details']['assign_to']);
					if ($assign_to) {
						$this->data['case_details']['assign_to_name'] = $assign_to['first_name'] . " " . $assign_to['last_name'];
						$this->data['case_details']['assign_to_email'] = $assign_to['email'];
					}
				} 
				if ($this->data['case_details'] && $this->data['case_details']['case_manager']) {
					$case_manager = $this->users_model->get_by_id($this->data['case_details']['case_manager']);
					if ($case_manager) {
						$this->data['case_details']['case_manager_name'] = $case_manager['first_name'] . " " . $case_manager['last_name'];
						$this->data['case_details']['case_manager_email'] = $case_manager['email'];
					}
				}
				
				$this->data['policy_info'] = $this->parser->parse("claim/policy_info", $this->data, TRUE);
				$this->data['product_full_name'] = $this->product_model->get_full_name($this->data['policy']['product_short']);
				$this->data['case_info'] = $this->parser->parse("claim/case_info", $this->data, TRUE);
				
				// get all word documents
				$this->data['word_templates'] = $this->word_comments_model->search(array()); // $this->common_model->select($record = "list", $typecast = "array", $table = "word_comments", $fields);
				
				// get status
				$this->data['examine_status'] = $this->expenses_model->get_status(1);
				$this->data['status_list'] = $this->claim_model->get_claim_status_list(1);

				$this->data['is_insurer'] = ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER)) ? 1 : 0);
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Examine Claim', TRUE);
				switch ($this->data['claim_details']['exinfo_type']) {
					case "top_baggage":
						$this->template->write_view('content', 'claim/examine_top_baggage', $this->data);
						break;
					case "top_medical":
						$this->template->write_view('content', 'claim/examine_top_medical', $this->data);
						break;
					case "top_trip":
						$this->template->write_view('content', 'claim/examine_top_trip', $this->data);
						break;
					default:
						$this->template->write_view('content', 'claim/examine_claim', $this->data);
						break;
				}
				$this->template->render();
			}
		}
	}
	
	// redirect if needed, otherwise display the edit case page
	public function claim_detail($id) {
		if (! $this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EAC, Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER))) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('api_model');
			$this->load->model('country_model');
			$this->load->model('province_model');
			$this->load->model('template_model');
			$this->load->model('claim_model');
			$this->load->model('product_model');
			$this->load->model('expenses_model');
			$this->load->model('intakeform_model');
			$this->load->model('word_comments_model');
			$this->load->model('provider_model');

			// get claim details
			$this->data['claim_details'] = $this->claim_model->get_by_id($id);
			if (!empty($this->data['claim_details']['exinfo'])) {
				$this->data['exinfo'] = json_decode($this->data['claim_details']['exinfo'], true);
			}
			if (empty($this->data['claim_details'])) {
				// send error message
				$this->session->set_flashdata('error', "Something went wrong, please try after some time.");
				
				// redirect them to the claim
				redirect('claim');
			}
			
			// get all expenses items
			$this->data['expenses_claimed'] = $this->expenses_model->search(array("claim_id" => $id));

			//$this->data['edit'] = ($this->data['claim_details']['status'] != Claim_model::STATUS_Paid) && ($this->data['claim_details']['status'] != Claim_model::STATUS_Closed); // Editable
			$this->data['edit'] = TRUE;
			if ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) {
				$this->data['edit'] = FALSE;
			}

			switch ($this->data['claim_details']['exinfo_type']) {
				case "top_baggage":
					break;
				case "top_medical":
					break;
				case "top_trip":
					break;
				default:
					$this->form_validation->set_rules('diagnosis', 'Diagnosis ', 'required');
					$this->form_validation->set_rules('date_symptoms', 'Date symptoms or injury first appeared ', 'required');
					break;
			}

			// validate form input
			$this->form_validation->set_rules('insured_first_name', 'Insured First Name', 'required');
			// $this->form_validation->set_rules('personal_id', 'Personal ID', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			//$this->form_validation->set_rules('case_no', 'Case No', 'is_unique[claim.case_no]');
			//$this->form_validation->set_rules('school_name', 'School Name', 'required');
			//$this->form_validation->set_rules('group_id', 'Group ID', 'required');
			
			$this->form_validation->set_rules('contact_first_name', 'First Name', '');
			$this->form_validation->set_rules('contact_last_name', 'Last Name', '');
			$this->form_validation->set_rules('contact_email', 'Email', 'valid_email');
			//$this->form_validation->set_rules('contact_phone', 'physician alt telephone ', 'numeric');
			
			if ($this->form_validation->run() == TRUE) {
				if ($this->ion_auth->in_group(Users_model::GROUP_INSURER)) {
					return show_error('Sorry, you don\'t have any permission to edit.');
				}
				// prepare post data array
				$data =[ ];
				$array = $this->input->post();
				foreach ( $array as $key => $value ) {
					// code...
					if ($key != "exinfo" && $key != "expenses_claimed" && $key != "Examine" && $key != "filter" && $key != "same_policy" && $key != "Save" && $key != "files_multi" && $key != "payees" && $key != "eprovider" && $key != "files" && $key != "expenses_claimed" && ! strpos($key, "otes_") && ! strpos($key, "iles_") && $key != "no_of_form" && ! strpos($key, "ile_pdf") && ! strpos($key, "ayment_type")) {
						$data[$key] = $value;
					} else if ($key == "exinfo") {
						$data["exinfo"] = json_encode($value);
					}
				}

				// upload claim pdf files to server
				$files = @$_FILES['files_multi'];
				$file_names =[ ];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'claim_files/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if (! empty($files)) {
					foreach ( $files['name'] as $key => $value ) {
						if ($files['name'][$key]) {
							$_FILES['userfile']['name'] = $files['name'][$key];
							$_FILES['userfile']['type'] = $files['type'][$key];
							$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
							$_FILES['userfile']['error'] = $files['error'][$key];
							$_FILES['userfile']['size'] = $files['size'][$key];
							
							// upload file to server
							if ($this->upload->do_upload()) {
								$file_data = $this->upload->data();
								$file_names[] = $file_data['file_name'];
							}
						}
					}
				}
				
				// get old files
				$old_files = $this->data['claim_details']['files'];
				
				if (empty($file_names)) {
					$data['files'] = ($old_files);
				} else {
					$data['files'] = ($old_files ? $old_files . "," : "") . implode(",", $file_names);
				}
					
				// insert values to database
				$data['id'] = $id;
				if (isset($data['assign_to'])) {
					if (empty($data['assign_to'])) {
						unset($data['assign_to']);
					} else {
						if ($this->data['claim_details']['assign_to'] != $data['assign_to']) {
							$this->load->model('mytask_model');
							$tasks = $this->mytask_model->search(array('item_id' => $id, 'category' => Mytask_model::CATEGORY_CLAIMS, 'type' => Mytask_model::TASK_TYPE_CLAIM, 'user_type' => Mytask_model::USER_TYPE_EXAM));
							$new_task = array();
							if ($tasks) {
								// Change manager
								$new_task['id'] = $tasks[0]['id'];
								$new_task['user_id'] = $data['assign_to'];
								$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
								$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
								$new_task['status'] = Mytask_model::STATUS_REASSIGNED;
								$new_task['finished'] = 0;
								$new_task['notes'] = "Reassign By :" . $this->ion_auth->get_user_id() . "; " . $tasks[0]['notes'];
							} else {
								// Assign manager
								$new_task['user_id'] = $data['assign_to'];
								$new_task['item_id'] = $id;
								$new_task['task_no'] = $this->data['claim_details']['claim_no'];;
								$new_task['category'] = Mytask_model::CATEGORY_CLAIMS;
								$new_task['due_date'] = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d", time() + 86400);
								$new_task['due_time'] = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s", time() + 86400);
								$new_task['type'] = Mytask_model::TASK_TYPE_CLAIM;
								$new_task['priority'] = Mytask_model::PRIORITY_MEDIUM;
								$new_task['created_by'] = $this->ion_auth->get_user_id();
								$new_task['created'] = date("Y-m-d H:i:s");
								$new_task['user_type'] = Mytask_model::USER_TYPE_EXAM;
								$new_task['status'] = Mytask_model::STATUS_ASSIGNED;
								$new_task['notes'] = "New Assign";
							}
							$this->mytask_model->save($new_task);
						}
					}
				}
				$record_id = $this->claim_model->save($data);
				
				// create folder if not exists
				@mkdir(UPLOADFULLPATH . 'claim_files/' . $record_id, 0777);
				
				// move all files to that directory
				if (! empty($file_names)) {
					foreach ( $file_names as $fname ) {
						copy(UPLOADFULLPATH . "claim_files/$fname", UPLOADFULLPATH . "claim_files/$record_id/$fname");
						unlink(UPLOADFULLPATH . "claim_files/$fname");
					}
				}

				// insert expenses_claimed data
				if (! empty($array['expenses_claimed'])) {
					$i = count($array['expenses_claimed']['provider_name']);
					foreach ( $array['expenses_claimed']['provider_name'] as $key => $val ) {
						$i ++;
						$item_data = array(
								'claim_id' => $record_id,
								'id' => $array['expenses_claimed']['id'][$key],
								'invoice' => $array['expenses_claimed']['invoice'][$key],
								'case_no' => $array['case_no'],
								'claim_no' => $this->data['claim_details']['claim_no'],
								'claim_item_no' => $this->data['claim_details']['claim_no'] . '_' . $i,
								'provider_name' => $array['expenses_claimed']['provider_name'][$key],
								'provider_type' => isset($array['expenses_claimed']['provider_type'][$key]) ? $array['expenses_claimed']['provider_type'][$key] : '',
								'expenses_provider_id' => isset($array['expenses_claimed']['expenses_provider_id'][$key]) ? $array['expenses_claimed']['expenses_provider_id'][$key] : 0,
								'referencing_physician' => $array['expenses_claimed']['referencing_physician'][$key],
								'coverage_code' => $array['expenses_claimed']['coverage_code'][$key],
								'diagnosis' => isset($array['expenses_claimed']['diagnosis'][$key]) ? $array['expenses_claimed']['diagnosis'][$key] : '',
								'service_description' => $array['expenses_claimed']['service_description'][$key],
								'date_of_service' => $array['expenses_claimed']['date_of_service'][$key],
								'amount_billed_org' => $array['expenses_claimed']['amount_billed_org'][$key],
								'amount_billed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_billed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'amount_client_paid_org' => $array['expenses_claimed']['amount_client_paid_org'][$key],
								'amount_client_paid' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_client_paid_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'amount_claimed_org' => $array['expenses_claimed']['amount_claimed_org'][$key],
								'amount_claimed' => $this->expenses_model->get_currency_exchange($array['expenses_claimed']['amount_claimed_org'][$key], $array['expenses_claimed']['currency'][$key], $array['expenses_claimed']['date_of_service'][$key]),
								'status' => $array['expenses_claimed']['status'][$key],
								'payee' => $array['expenses_claimed']['payee'][$key],
								'pay_to' => $array['expenses_claimed']['pay_to'][$key],
								'third_party_payee' => empty($array['expenses_claimed']['third_party_payee'][$key]) ? 0 : (int)$array['expenses_claimed']['third_party_payee'][$key],
								'currency' => $array['expenses_claimed']['currency'][$key],
								//'comment' => $array['expenses_claimed']['comment'][$key],
								'created_by' => $this->ion_auth->get_user_id(),
								'created' => date('Y-m-d H:i:s') 
						);
						
						if ($item_id = @$array['expenses_claimed']['id'][$key]) {
							unset($item_data['created']);
							unset($item_data['created_by']);
							$item_data['id'] = $item_id; 
						}

						$tmp_id = $this->expenses_model->save($item_data);
					}
				}
				
				// insert intake notes
				// insert intake forms if exists
				$no_of_form = @$array['no_of_form'];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);
				
				// initialize upload config
				$this->upload->initialize($config);
				if ($no_of_form) {
					// add intake form batch
					for($i = 1; $i <= $no_of_form; $i ++) {
						// initialize file names array
						$file_names =[ ];
						
						// upload files to server
						$files = $_FILES['files_' . $i];
						if (! empty($files)) {
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
								'created' => date("Y-m-d H:i:s"),
								'docs' => implode(",", $file_names),
								'type' => 'CLAIM' 
						);
						
						// save values to database
						$intake_form_id = $this->intakeform_model->save($data_intake);
						
						// create directory to identify intake files
						@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
						
						// move all files to that directory
						if (! empty($file_names)) {
							foreach ( $file_names as $fname ) {
								copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "intake_forms/$fname");
							}
						}
					}
				}
				
				// send success message
				$this->session->set_flashdata('success', "Claim successfully updated");
				// redirect them to the login page
				redirect('claim/claim_detail/' . $id);
			} else {
				// get claim history
				$this->data['claim_history'] = $this->expenses_model->expenses_history($id);

				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->country_model->get_list(TRUE);
				$this->data['country2'] = $this->country_model->get_list(FALSE);
				$this->data['province'] = $this->province_model->get_list_by_country_short($this->input->post('country') ? $this->input->post('country') : 'CA');
				$this->data['province2'] = $this->province_model->get_list_by_country_short($this->input->post('country2') ? $this->input->post('country2') : 'CA');
				$this->data['products'] = $this->product_model->get_list();
				$this->data['bprovider_list'] = $this->provider_model->search(array("status" => Provider_model::ACTIVE));
				$this->data['eprovider_list'] = $this->claim_model->expenses_provider_search(array("claim_id" => $id, "status" => 1));
				$this->data['payees_list'] = $this->claim_model->payee_search(array("claim_id" => $id));
				$this->data['expenses_list'] = $this->expenses_model->get_coverage_code();
				
				$this->data['status_list'] = $this->claim_model->get_claim_status_list(1);
				
				// get all documents for sending email/print.
				$this->data['docs'] = $this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CLAIM));
				
				/*
				if ($this->input->post('eprovider')) {
					$arr = $this->input->post('payees');
					foreach ( $arr['bank'] as $key => $val ) {
						$this->data['payees_list'][] = array(
								'id' => $arr['id'][$key],
								'name' => $arr['name'][$key],
								'account_cheque' => $arr['account_cheque'][$key],
								'address' => $arr['address'][$key],
								'province' => $arr['province'][$key],
								'country' => $arr['country'][$key],
								'postcode' => $arr['postcode'][$key],
						);
					}
				}
				// get all payees infomation
				if ($this->input->post('payees')) {
					$arr = $this->input->post('payees');
					foreach ( $arr['bank'] as $key => $val ) {
						$this->data['payees_list'][] = array(
								'id' => $arr['id'][$key],
								'payment_type' => $arr['payment_type'][$key],
								'bank' => $arr['bank'][$key],
								'payee_name' => $arr['payee_name'][$key],
								'account_cheque' => $arr['account_cheque'][$key],
								'address' => $arr['address'][$key],
								'province' => $arr['province'][$key],
								'country' => $arr['country'][$key],
								'postcode' => $arr['postcode'][$key],
						);
					}
				}
				*/

				if ($this->input->post('expenses_claimed')) {
					$this->data['expenses_claimed'] = array();
					$arr = $this->input->post('expenses_claimed');
					foreach ( $arr['invoice'] as $key => $val ) {
						$this->data['expenses_claimed'][] = array(
								'id' => $arr['id'][$key],
								'invoice' => $arr['invoice'][$key],
								'provider_name' => $arr['provider_name'][$key],
								'provider_type' => isset($arr['provider_type'][$key]) ? $arr['provider_type'][$key] : 0,
								'expenses_provider_id' => isset($arr['expenses_provider_id'][$key]) ? $arr['expenses_provider_id'][$key] : 0,
								'referencing_physician' => $arr['referencing_physician'][$key],
								'coverage_code' => $arr['coverage_code'][$key],
								'diagnosis' => '', // $arr['diagnosis'][$key],
								'service_description' => $arr['service_description'][$key],
								'date_of_service' => $arr['date_of_service'][$key],
								'amount_billed_org' => $arr['amount_billed_org'][$key],
								'amount_billed' => $this->expenses_model->get_currency_exchange($arr['amount_billed_org'][$key], $arr['currency'][$key], $arr['date_of_service'][$key]),
								'amount_client_paid_org' => $arr['amount_client_paid_org'][$key],
								'amount_client_paid' => $this->expenses_model->get_currency_exchange($arr['amount_client_paid_org'][$key], $arr['currency'][$key], $arr['date_of_service'][$key]),
								'amount_claimed_org' => $arr['amount_claimed_org'][$key],
								'amount_claimed' => $this->expenses_model->get_currency_exchange($arr['amount_claimed_org'][$key], $arr['currency'][$key], $arr['date_of_service'][$key]),
								'payee' => $arr['payee'][$key],
								'pay_to' => $arr['pay_to'][$key],
								'third_party_payee' => $arr['third_party_payee'][$key],
								'status' => $arr['status'][$key],
								'pay_to' => $arr['pay_to'][$key],
								'currency' => $arr['currency'][$key],
								'comment' => '' // $arr['comment'][$key]
						);
					}
				}
				
				// get intake forms
				$this->data['intake_forms'] = $this->intakeform_model->get_list_by_case_id($id, 'CLAIM');
				
				// get all word documents
				$this->data['word_templates'] = $this->word_comments_model->search(array());
				$this->data['currencies'] = $this->expenses_model->get_currencies();
				$this->data['examiner_email'] = '';
				if ($examiner = $this->users_model->get_by_id($this->data['claim_details']['assign_to'])) {
					$this->data['examiner_email'] = $examiner['email'];
				}
				$this->data['examiners'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
				
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Claim Details', TRUE);
				switch ($this->data['claim_details']['exinfo_type']) {
					case "top_baggage":
						$this->template->write_view('content', 'claim/claim_top_baggage', $this->data);
						break;
					case "top_medical":
						$this->template->write_view('content', 'claim/claim_top_medical', $this->data);
						break;
					case "top_trip":
						$this->template->write_view('content', 'claim/claim_top_trip', $this->data);
						break;
					default:
						$this->template->write_view('content', 'claim/claim_detail', $this->data);
						break;
				}
				$this->template->render();
			}
		}
	}
	
	// reload all docs email/print
	public function reload_docs() {
		$this->load->model('template_model');
		$this->load->model('province_model');
		$this->load->model('word_comments_model');
		
		// get all documents for sending email/print.
		$this->data['docs'] = $this->template_model->search(array('type' => Template_model::TEMPLATE_CLAIM));
		$this->data['province2'] = $this->province_model->get_list_by_country_short('CA');
		$this->data['word_templates'] = $this->data['word_templates'] = $this->word_comments_model->search(array());
		
		$data = array('reload_docs' => $this->parser->parse("claim/reload_docs", $this->data, TRUE));
		echo json_encode($data);
	}
	function import_files() {
		set_time_limit(0);
		ini_set('max_execution_time', - 1);
		$txt_file = file_get_contents('icd10cm_codes_2017 (3).txt');
		$rows = explode("\n", $txt_file);
		foreach ( $rows as $row => $data ) {
			// get row data
			$info =[ ];
			$info['code'] = substr($data, 0, 8);
			$info['description'] = substr($data, 8, strlen($data));
			$this->common_model->save("diagnosis", $info);
		}
	}
	
	// download claim files
	public function download($file, $id) {
		$this->load->helper("download");
		force_download(UPLOADFULLPATH . 'claim_files/' . $id . '/' . urldecode($file), NULL);
	}
	
	// Remove claim doc file here / Ajax request
	public function delete_doc($file, $id) {
		// remove doc file here
		$file = urldecode($file);
		
		// get claim docs
		$joins[] = array(
				'table' => 'users u1',
				'on' => 'u1.id = claim.created_by',
				'type' => 'LEFT' 
		);
		$this->data['claim_details'] = $this->common_model->select($record = "first", $typecast = "array", $table = "claim", $fields = "`claim`.files", $conditions = array(
				'claim.id' => $id 
		), $joins);
		
		// remove claim document
		@unlink(UPLOADFULLPATH . 'claim_files/' . $id . '/' . urldecode($file));
		
		// remove doc from db
		$files = array_diff(str_getcsv($this->data['claim_details']['files']), array(
				$file 
		));
		
		// update files to database
		$this->common_model->update('claim', array(
				'files' => implode(',', $files) 
		), array(
				'id' => $id 
		));
		
		echo TRUE;
	}
	
	// browse claim files
	public function file($file, $id) {
		$filename = UPLOADFULLPATH . 'claim_files/' . $id . '/' . urldecode($file);
		
		$fileinfo = pathinfo($filename);
		$mimeType = '';
		switch ($fileinfo['extension']) {
			case 'msg':
				$mimeType = 'application/vnd.ms-outlook';
				break;
			case 'pdf':
				$mimeType = 'application/pdf';
				break;
			case 'gif':
				$mimeType = 'application/gif';
				break;
			case 'png':
				$mimeType = 'application/png';
				break;
			case 'jpeg':
			case 'jpg':
				$mimeType = 'application/jpeg';
				break;
			default:
				die();
		}
		header('Content-type: ' . $mimeType);
		//header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Disposition: inline; filename="' . $file . '"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: no-cache');
		readfile($filename);
	}
	
	// for autocomplete search
	public function search_diagnosis($field) {
		$query = $this->input->get("query");
		
		// get search query
		$table = "diagnosis";
		$group_by = array(
				"users_groups.user_id" 
		);
		$fields = "diagnosis.$field as `value`, diagnosis.id as `data`";
		$conditions = "(diagnosis.$field like '%$query%'  OR diagnosis.code like '%$query%' )";
		$results = $this->common_model->select($record = "list", $typecast = "object", $table, $fields, $conditions, $joins = array(), $order_by = array(), $group_by = array(), $having = "", $limit = 8);
		
		// return result in json format
		$results = array(
				'suggestions' => $results 
		);
		echo json_encode($results);
	}
	
	// for ajax request
	public function save_item() {
		if (! $this->ion_auth->logged_in()) {
			die("0");
		}
		// generate data array
		$data = $this->input->post();
		// unset($data['id']);
		unset($data['Save']);
		unset($data['arrival_date']);
		unset($data['effective_date']);
		unset($data['expiry_date']);
		unset($data['existion_condition']);
		unset($data['arrival_date']);
		unset($data['policy_info']);
		unset($data['deny_reason']);
		unset($data['total_amount_payble']);
		if (empty($data['updated_by'])) $data['updated_by'] = $this->ion_auth->get_user_id();
		// update values to database
		$this->load->model('expenses_model');
		
		$this->expenses_model->save($data);
		echo TRUE;
	}

	public function saveintnotes($id) {
		if (! $this->ion_auth->logged_in()) {
			die("0");
		}
		$data['id'] = $id;
		$intnotes = $this->input->post('intnotes');
		if (empty($id) || empty($intnotes)) {
			die("No data");
		}
		$this->load->model('claim_model');
		$claim = $this->claim_model->get_by_id($id);
		if ($claim) {
			$arr = json_decode($claim['intnotes'], TRUE);
			$iarr = array('dt' => date("Y-m-d H:i"), "user" => $this->ion_auth->get_user_info('email'), 'notes' => $intnotes);
			if ($arr && is_array($arr) && (sizeof($arr) > 0)) {
				array_push($arr, $iarr);
			} else {
				$arr = array($iarr);
			}
			$array['intnotes'] = json_encode($intnotesArr); 
			$data['intnotes'] = json_encode($arr);
			$this->claim_model->save($data);
		}
	
		echo TRUE;
	}
	
	public function savenotes($id) {
		if (! $this->ion_auth->logged_in()) {
			die("0");
		}
		$data['id'] = $id;
		$data['notes'] = $this->input->post('notes');

		$this->load->model('claim_model');
	
		$this->claim_model->save($data);
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
				"Street No: " . $street_name,
				"City: " . $city,
				"Province: " . $province 
		);
		$data_intake = array(
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => implode(", ", $intake_notes),
				'created' => date("Y-m-d H:i:s"),
				'docs' => $filename 
		);
		
		// send email notification to provider email address
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from(FROM_EMAIL, SITE_TITLE);
		$this->email->to($email);
		
		$this->email->subject("Received $doc");
		$this->email->message($data_intake['notes']);
		$this->email->attach(UPLOADFULLPATH . "temp/$filename");
		$this->email->send();
		echo json_encode(array(
				"data_intake" => implode(", ", $intake_notes),
				'file' => UPLOADFULLPATH . "temp/$filename",
				'file_name' => $filename 
		));
	}
	
	// send email template from examine claim page
	public function send_print_email_claim() {
		// get all requested params
		$email = $this->input->post("email");
		$street_no = $this->input->post("street_no");
		$street_name = $this->input->post("street_name");
		$city = $this->input->post("city");
		$province = $this->input->post("province");
		$template = $this->input->post("template");
		$doc = $this->input->post("doc");
		$case_id = $this->input->post("case_id");
		$claim_item_id = $this->input->post("claim_item_id");
		$type = $this->input->post("type");
		
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
				"Street No: " . $street_name,
				"City: " . $city,
				"Province: " . $province 
		);
		$data_intake = array(
				'case_id' => $case_id,
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => implode(", ", $intake_notes),
				'created' => date("Y-m-d H:i:s"),
				'docs' => $filename,
				'type' => 'CLAIM' 
		);
		
		// save values to database
		$intake_form_id = $this->common_model->save("intake_form", $data_intake);
		
		// create directory to identify intake files
		@mkdir(UPLOADFULLPATH . 'intake_forms/' . $intake_form_id, 0777);
		
		// move all files to that directory
		copy(UPLOADFULLPATH . "temp/$filename", UPLOADFULLPATH . "intake_forms/$intake_form_id/$filename");
		unlink(UPLOADFULLPATH . "temp/$filename");
		
		// check if claim is deny
		if ($type == 'deny') {
			// deny cliam and close its details
			$this->common_model->update("claim", array(
					'status' => 'denied' 
			), array(
					"id" => $case_id 
			));
			
			// send success message
			$this->session->set_flashdata('success', "Claim denied successfully.");
		} else {
			// send success message
			$this->session->set_flashdata('success', "Email successfully sent.");
		}
		
		// send email notification to provider email address
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from(FROM_EMAIL, SITE_TITLE);
		$this->email->to($email);
		
		$this->email->subject("Received $doc");
		$this->email->message($data_intake['notes']);
		$this->email->attach(UPLOADFULLPATH . "intake_forms/$intake_form_id/$filename");
		// $this->email->send();
		echo TRUE;
	}
	
	// assign claim examinner manually for ajax request
	public function assign_claim($type = "automatic") {
		$claim = $this->input->post("claim");
		$claim = explode(",", $claim);
		$employee_id = $this->input->post("employee_id");
		if (! $this->ion_auth->logged_in()) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
		
			// asigning process
			foreach ( $claim as $key => $value ) {
				$cl = $this->claim_model->get_by_id($value);
				if ($cl) {
					$this->claim_model->save(array("assign_to" => $employee_id, "id" => $value));
					
					// check task, if already exists
					$task_details = $this->mytask_model->search(array('item_id' => $value, 'category' => Mytask_model::CATEGORY_CLAIMS, 'type' => Mytask_model::TASK_TYPE_CLAIM, 'user_type' => Mytask_model::USER_TYPE_EXAM));
					
					if (! empty($task_details)) {
						// update my task data
						$data_task = array('id' => $task_details[0]['id'], 'user_id' => $employee_id, 'status' => Mytask_model::STATUS_REASSIGNED, 'notes' => 'Reassign');
					} else {
						// get case details here
						$claim_details = $this->claim_model->get_by_id($value);
						
						// create new task here
						$data_task = array(
								'user_id' => $employee_id,
								'item_id' => $value,
								'task_no' => $claim_details['claim_no'],
								'category' => Mytask_model::CATEGORY_CLAIMS,
								'due_date' => date("Y-m-d", time() + 86400),
								'due_time' => date("H:i:s", time() + 86400),
								'type' => Mytask_model::TASK_TYPE_CLAIM,
								'priority' => Mytask_model::PRIORITY_LOW,
								'created_by' => $this->ion_auth->get_user_id(),
								'created' => date('Y-m-d H:i:s'),
								'user_type' => Mytask_model::USER_TYPE_EXAM
						);
					}
					$this->mytask_model->save($data_task);
				}
			}
			
			// send success message
			$this->session->set_flashdata('success', "Claim asssigned successfully");
			
			echo TRUE;
		}
	}
	
	// change status of claim - for ajax request
	public function status($type = "", $is_accepted = '') {
		if (! $this->ion_auth->logged_in()) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		$this->load->model('claim_model');
		if (empty($type)) {
			$type = Claim_model::STATUS_Processing;
		}
		$statusArr = $this->claim_model->get_claim_status_list();
		
		if (! array_key_exists($type, $statusArr))
			die("Unknown Status:[" . $type . "]");
		
		$claim_item_id = $this->input->post("claim_item_id");
		$claim_id = $this->input->post("claim_id");
		$reason = $this->input->post("reason");
		
		$data = array(
				"id" => $claim_id,
				'status' => $type 
		);
		
		if (! empty($is_accepted)) {
			$data['is_accepted'] = $is_accepted;
		}
		if (! empty($reason)) {
			$data['reason'] = $reason;
		}
		
		switch ($type) {
			case Claim_model::STATUS_Processing :
			case Claim_model::STATUS_Recovered :
			case Claim_model::STATUS_Appealed :
			default :
				$data['is_complete'] = 'N';
				break;
			case Claim_model::STATUS_Pending :
			case Claim_model::STATUS_Processed :
			case Claim_model::STATUS_Paid :
			case Claim_model::STATUS_Closed :
			case Claim_model::STATUS_Exceptional :
				$data['is_complete'] = 'Y';
				break;
		}
		$this->claim_model->save($data);
		// send success message
		$this->session->set_flashdata('success', "Claim successfully changed status to " . $type);
		
		echo TRUE;
	}
	
	public function status2($type = "") {
		if (! $this->ion_auth->logged_in()) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		$this->load->model('claim_model');
		
		$claim_id = $this->input->post("claim_id");
		
		$data = array(
				"id" => $claim_id,
				'status2' => $type 
		);
		
		$this->claim_model->save($data);
		// send success message
		$this->session->set_flashdata('success', "Claim successfully changed status to " . $type);
		
		echo TRUE;
	}
	
	// redirect if needed, otherwise display the my tasks list
	public function payments() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('expenses_model');
			$this->load->model('product_model');
			
			$limit = 10;
			$offset = $this->uri->segment(3);
			
			$this->data['export_para'] = '';
				
			$this->data['items'] = $this->expenses_model->payment_search($this->input->get(), $limit, $offset);
			$config['total_rows'] = $this->expenses_model->last_rows();
			$config['base_url'] = site_url('claim/payments');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0) {
				$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
				$this->data['export_para'] = $config ['suffix'];
			}

			$this->pagination->initialize($config); // initiaze pagination config

			$this->data['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->data['products'] = $this->product_model->get_list();

			$this->template->write('title', SITE_TITLE . ' - Payments', TRUE);
			$this->template->write_view('content', 'claim/payments', $this->data);
			$this->template->render();
		}
	}
	
	// for payment import
	public function import() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('expenses_model');
			
			$uf = array_shift ( $_FILES );
			$name = $uf ['name'];
			$type = $uf ['type'];
			$tmp_name = $uf ['tmp_name'];
			$size = $uf ['size'];
			$fileinfo = pathinfo ( $name );
			if (! empty ( $uf ['error'] )) {
				$this->session->set_flashdata('error', "Something went wrong, please check your file.");
			} else if (! in_array ( $fileinfo ['extension'], array (/*'xlsx',*/'csv') )) {
				$this->session->set_flashdata('error', "Unknown file type, must be csv.");
			} else {
				if (($handle = fopen($tmp_name, "r")) !== FALSE) {
					$keyArr = array();
					while (($data = fgetcsv($handle, 10000)) !== FALSE) {
						if (empty($keyArr)) {
							if (! in_array("id", $data)) {
								$this->session->set_flashdata('error', "Not have id column.");
								redirect('claim/payments', 'refresh');
							}
							$keyArr = $data;
							continue;
						}
						$para = array();
						foreach ($keyArr as $key => $name) {
							if (($name == 'claim_date') || ($name == 'date_of_service') || ($name == 'pay_date') || ($name == 'finalize_date')) {
								$para[$name] = date("Y-m-d", strtotime($data[$key]));
							} else if (($name == 'created') || ($name == 'last_update')) {
								$para[$name] = date("Y-m-d H:i:s", strtotime($data[$key]));
							} else {
								$para[$name] = $data[$key];
							}
						}
						if ($para) {
							$this->expenses_model->save($para);
						}
					}
					fclose($handle);
				} else {
					$this->session->set_flashdata('error', "Can't opne upload file.");
				}
				$this->session->set_flashdata('success', "File data update successed");
			}
		}
		redirect('claim/payments', 'refresh');
	}
	
	// for payment export
	public function export() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('expenses_model');
			
			$para = array('status' => Expenses_model::EXPENSE_STATUS_Approved);

			$items = $this->expenses_model->payment_search($this->input->get());
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=items.csv');
			
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
			
			// output the column headings
			fputcsv($output, array(
					'id', 
					'status', 
					'claim_id', 
					'claim_no', 
					'claim_item_no', 
					'policy_no', 
					'insured_first_name', 
					'insured_last_name', 
					'invoice', 
					'pay_to', 
					'cheque',
					'amount_claimed',
					'amt_deductible',
					'amt_received',
					'amt_payable',
					'amt_exceptional',
					'recovery_name',
					'recovery_amt',
					'created',
					'last_update'
			));
			
			foreach ($items as $item) {
				fputcsv($output, array(
						$item['id'],
						$item['status'],
						$item['claim_id'],
						$item['claim_no'],
						$item['claim_item_no'],
						$item['policy_no'],
						$item['insured_first_name'],
						$item['insured_last_name'],
						$item['invoice'],
						$item['pay_to'],
						$item['cheque'],
						$item['amount_claimed'],
						$item['amt_deductible'],
						$item['amt_received'],
						$item['amt_payable'],
						$item['amt_exceptional'],
						$item['recovery_name'],
						$item['recovery_amt'],
						$item['created'],
						$item['last_update']
				));
			}
		}
	}
	
	// for ajax request
	public function claim_items() {
		
		// generate data array
		$claim_id = $this->input->post('claim_id');
		$case_no = $this->input->post('case_no');
		
		// get expenses climed items list
		$this->data['expenses'] = $this->common_model->select($record = "list", $typecast = "array", $table = "expenses_claimed", $fields = "`expenses_claimed`.*", $conditions = array(
				'expenses_claimed.claim_id' => $claim_id
		));
		
		// get case info details if exists
		$joins[] = array(
				'table' => 'users u1',
				'on' => 'u1.id = case.created_by',
				'type' => 'LEFT' 
		);
		$joins[] = array(
				'table' => 'users u2',
				'on' => 'u2.id = case.case_manager',
				'type' => 'LEFT' 
		);
		$joins[] = array(
				'table' => 'users u3',
				'on' => 'u3.id = case.assign_to',
				'type' => 'LEFT' 
		);
		$this->data['case_details'] = $this->common_model->select($record = "first", $typecast = "array", $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name,  concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name,  concat_ws(' ', u3.first_name, u3.last_name) as assign_to_name", $conditions = array(
				'case.case_no' => $case_no 
		), $joins);
		
		// get policy info from claim page
		$this->data['claim_details'] = $this->common_model->select($record = "first", $typecast = "array", $table = "claim", $fields = "`claim`.policy_info, status", $conditions = array(
				'claim.id' => $claim_id 
		));
		
		$data = array(
				'claim_items' => $this->parser->parse("claim/claim_items", $this->data, TRUE),
				'policy_info' => $this->parser->parse("claim/policy_info", $this->data, TRUE),
				'case_info' => $this->parser->parse("claim/case_info", $this->data, TRUE),
				'status' => $this->data['claim_details']['status'] 
		);
		echo json_encode($data);
	}
	// for ajax request
	public function claim_payment_items() {
		
		// generate data array
		$claim_id = $this->input->post('claim_id');
		$case_no = $this->input->post('case_no');
		
		// get all claims which status accepted
		$conditions['expenses_claimed.amt_payable > '] = 0;
		$conditions['expenses_claimed.claim_id'] = $claim_id;
		$joins =[ ];
		$joins[] = array(
				'table' => 'claim',
				'on' => 'claim.id = expenses_claimed.claim_id',
				'type' => 'INNER' 
		);
		$fields = "expenses_claimed.id,expenses_claimed.status,expenses_claimed.claim_id,expenses_claimed.claim_item_no,expenses_claimed.claim_no,expenses_claimed.invoice,expenses_claimed.date_of_service,expenses_claimed.coverage_code,expenses_claimed.diagnosis,expenses_claimed.amt_payable,expenses_claimed.amt_deductible,expenses_claimed.amt_insured, expenses_claimed.case_no, expenses_claimed.claim_date, (expenses_claimed.amount_claimed) as amount_claimed, (expenses_claimed.amount_client_paid) as amount_client_paid, expenses_claimed.currency, expenses_claimed.pay_to";
		$this->data['claims'] = $this->common_model->select($record = "list", $typecast = "array", $table = "expenses_claimed", $fields, $conditions, $joins);
		
		$data = array(
				'claim_payment_items' => $this->parser->parse("claim/claim_payment_items", $this->data, TRUE) 
		);
		echo json_encode($data);
	}
	
	// for ajax request
	public function select_payees() {
		
		// generate data array
		$claim_id = $this->input->post('claim_id');
		$pay_to = $this->input->post('pay_to');
		
		// get claim details
		$this->data['claim_details'] = $this->common_model->select($record = "first", $typecast = "array", $table = "claim", $fields = "status, is_complete", $conditions = array(
				'claim.id' => $claim_id 
		));
		
		// get all payees infomation
		$fields = "*";
		$conditions = "claim_id = '$claim_id' and payee_name = '$pay_to'";
		$this->data['payees'] = $this->common_model->select($record = "list", $typecast = "array", $table = "payees", $fields, $conditions);
		
		$data = array(
				'payees' => $this->parser->parse("claim/select_payees", $this->data, TRUE),
				'status' => $this->data['claim_details']['status'],
				'is_complete' => $this->data['claim_details']['is_complete'] 
		);
		echo json_encode($data);
	}
	
	// for ajax request
	public function confirm_payment($items = "") {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			die('Need login');
		}
		
		$this->load->model('expenses_model');

		$itemArr = explode(",", $items);
		foreach ($itemArr as $item_id) {
			$item = $this->expenses_model->make_pay($item_id);
			echo ("make_pay: " . $item_id . "; ");
		}
		
		die("OK");
	}
	
	// for ajax request
	public function close_claim() {
		$this->load->model('claim_model');
		$this->load->model('case_model');
		
		// generate data array
		$claim_id = $this->input->post('claim_id');
		$claim_details = $this->claim_model->get_by_id($claim_id);
		if ($claim_details) {
			$this->claim_model->save(array('id' => $claim_details['id'], 'status' => Claim_model::STATUS_Closed));
			if ($claim_details['case_no']) {
				$case = $this->case_model->search(array('case_no' => $claim_details['case_no']));
				if ($case) {
					$this->case_model->save(array('id' => $case['id'], 'status' => Case_model::STATUS_CLOSED));
				}
			}
		}
		
		$this->session->set_flashdata('success', "Claim successfully closed");
		
		echo TRUE;
	}
	
	function update_payee() {
		$json = array("success" => 0, "id" => 0);
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EXAMINER, Users_model::GROUP_CLAIMER, Users_model::GROUP_MANAGER))) {
			$this->load->model('claim_model');
			$payee_data = array();
			$payee_data['id'] = $this->input->post('id');
			if (!empty($this->input->post('payment_type'))) {
				$payee_data['payment_type'] = $this->input->post('payment_type');
			}
			if (!empty($this->input->post('claim_id'))) {
				$payee_data['claim_id'] = $this->input->post('claim_id');
			}
			if (!empty($this->input->post('payee_name'))) {
				$payee_data['payee_name'] = $this->input->post('payee_name');
			}
			if (!empty($this->input->post('bank'))) {
				$payee_data['bank'] = $this->input->post('bank');
			}
			if (!empty($this->input->post('account_cheque'))) {
				$payee_data['account_cheque'] = $this->input->post('account_cheque');
			}
			if (!empty($this->input->post('address'))) {
				$payee_data['address'] = $this->input->post('address');
			}
			if (!empty($this->input->post('city'))) {
				$payee_data['city'] = $this->input->post('city');
			}
			if (!empty($this->input->post('province'))) {
				$payee_data['province'] = $this->input->post('province');
			}
			if (!empty($this->input->post('country'))) {
				$payee_data['country'] = $this->input->post('country');
			}
			if (!empty($this->input->post('postcode'))) {
				$payee_data['postcode'] = $this->input->post('postcode');
			}
			if (!empty($this->input->post('type'))) {
				$payee_data['type'] = $this->input->post('type');
			}
			$id = $this->claim_model->payees_save($payee_data);
			if ($id) {
				$json['id'] = $id;
				$json['success'] = 1;
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}
	
	// delete payee form here for ajax request
	public function delete_payee($payee_id) {
		// delete payee form
		$this->common_model->delete('payees', array(
				'id' => $payee_id 
		));
		
		echo TRUE;
	}
	
	// update eprovider form here for ajax request
	public function update_eprovider() {
		$json = array("success" => 0, "id" => 0);
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EXAMINER, Users_model::GROUP_CLAIMER, Users_model::GROUP_MANAGER))) {
			$this->load->model('claim_model');
			
			$data = array();
			$data['id'] = $this->input->post('id');
			if (!empty($this->input->post('claim_id'))) {
				$data['claim_id'] = $this->input->post('claim_id');
			}
			if (!empty($this->input->post('name'))) {
				$data['name'] = $this->input->post('name');
			}
			if (!empty($this->input->post('address'))) {
				$data['address'] = $this->input->post('address');
			}
			if (!empty($this->input->post('city'))) {
				$data['city'] = $this->input->post('city');
			}
			if (!empty($this->input->post('province'))) {
				$data['province'] = $this->input->post('province');
			}
			if (!empty($this->input->post('country'))) {
				$data['country'] = $this->input->post('country');
			}
			if (!empty($this->input->post('postcode'))) {
				$data['postcode'] = $this->input->post('postcode');
			}
			
			$id = $this->claim_model->expenses_provider_save($data);
			if ($id) {
				$json['id'] = $id;
				$json['success'] = 1;
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}
	
	// delete eprovider form here for ajax request
	public function delete_eprovider($id) {
		$json = array("success" => 0, "id" => 0);
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$this->load->model('claim_model');
			$data = array('id' => $id, 'status' => 0);
			$id = $this->claim_model->expenses_provider_save($data);
			if ($id) {
				$json['id'] = $id;
				$json['success'] = 1;
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}
	
	// delete claim item form here for ajax request
	public function delete_claim_item($id) {
		// delete claim item form
		$this->common_model->delete('expenses_claimed', array(
				'id' => $id 
		));
		
		echo TRUE;
	}
	
	// return list of role for current user
	function get_access_list() {
		$id = $this->ion_auth->get_user_id();
		
		$joins[] = array(
				'table' => 'groups',
				'on' => 'groups.id = users_groups.group_id',
				'type' => 'INNER' 
		);
		$roles = $this->common_model->select($record = "list", $typecast = "array", $table = "users_groups", $fields = "groups.name", $conditions = array(
				'users_groups.user_id' => $id 
		), $joins);
		
		$return = [ ];
		$return[] = "'claim'";
		// if(!empty($roles))
		// foreach ($roles as $key => $value) {
		// if($value['name'] == 'eacmanager')
		// $return[] = "'eac'";
		
		// else if($value['name'] == 'casemamager')
		// $return[] = "'case'";
		
		// else if($value['name'] == 'claimexaminer' OR $value['name'] == 'claimsmanager')
		// $return[] = "'claim'";
		
		// else
		// $return[] = "'".$value['name']."'";
		// }
		return $return;
	}
}
