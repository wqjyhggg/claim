<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Emergency_assistance extends CI_Controller {

	private $limit = 10;

	public function __construct()
	{
		parent::__construct();

		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}

	// redirect if needed, otherwise display the emergency assistance page
	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		else
		{
			// initialize variables
			$this->data['cases'] = []; 
			$this->data['policies'] = [];

			// search case filter
			if($this->input->get("filter") == 'case') 
			{
				// get all providers list
				$order_by = array(
					'field'=>'id',
					'order'=>'desc'
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
				if($this->input->get("case_no")) 
					$conditions['case.case_no'] = $this->input->get("case_no");
				if($this->input->get("policy_no")) 
					$conditions['case.policy_no'] = $this->input->get("policy_no");
				if($this->input->get("client_user_name")) 
					$conditions['concat_ws(" ", case.insured_firstname, case.insured_lastname) like'] = "%".$this->input->get("client_user_name")."%";
				if($this->input->get("created")) 
					$conditions['case.created like'] = "%".$this->input->get("created")."%";
				if($this->input->get("assign_to")) 
					$conditions['case.assign_to'] = $this->input->get("assign_to");
				if($this->input->get("case_manager")) 
					$conditions['case.case_manager'] = $this->input->get("case_manager");

				$fields = "last_update, concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id";
				$this->data['cases'] = $this->common_model->select($record = "list", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array());
			}
			else if($this->input->get("filter") == 'policy')
			{

				// prepare post data array
				$this->data['params'] = $this->input->get();
				
				$this->load->model('api_model');
				$this->load->model('claim_model');
				
				$this->data['policies'] = $this->api_model->get_policy($this->data['params']);
				$this->data['status'] = $this->api_model->status_list;
				
				foreach($this->data['policies'] as $k => $pl) {
					if ($this->claim_model->search(array('policy_no' => $pl['policy']))) {
						$this->data['policies'][$k]['has_claim'] = 1;
					} else {
						$this->data['policies'][$k]['has_claim'] = 0;
					}
				}
			}

			// send case manager and eac managers list
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = $this->input->get($field_name), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Assign To--");
			$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--");

			// send countries and province list
			$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['policy_status'] = $this->common_model->get_policy_status($field_name = "status_id", $selected = $this->input->get($field_name));
			$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->get($field_name));
				

			// render view data
        	$this->template->write('title', SITE_TITLE.' - View Edit Emergency Assistance Case', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/index', $this->data);
	        $this->template->render();        
		}
	}

	// custom name validation
	function alpha_dash_space($fullname)
	{
		if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) 
		{
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
			return FALSE;
		} 
		else 
		{
			return TRUE;
		}
	}

	// redirect if needed, otherwise display the create case page
	public function create_case($id = 0)
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->load->model('case_model');
			
			//validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', '');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('last_name', 'Last Name', 'callback_alpha_dash_space');
        	$this->form_validation->set_rules('phone_number', 'Phone', 'required|trim|numeric|min_length[9]|max_length[15]');
        	$this->form_validation->set_rules('post_code', 'Post Code', 'required|trim|max_length[9]|min_length[5]');
        	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('relations', 'Relations', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('incident_date', 'Incident Date', 'required');

			$this->form_validation->set_rules('insured_firstname', 'Insured First Name', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');

			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				foreach ($array as $key => $value) 
				{
					# code...
					if(!strpos($key, "otes_") && $key <> "no_of_form")
						$data[$key] = $value;

					// for check third party recovery
					if($key == 'third_party_recovery')
						$data[$key] = $value ? $value : "N";
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->user()->row()->id;
				
				$this->load->model('master_model');
				$data['id'] = $this->master_model->get_id('case'); // Get new id
				$data['case_no'] = $case_no = $this->case_model->generate_case_no($data['id']);

				// insert values to database
				$record_id = $this->common_model->save("case", $data);
				
				$record_id = $data['id'];
				
				// load upload class
				$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				// $config['max_size']     = '*';
				$this->load->library('upload', $config);

				// initialize upload config
				$this->upload->initialize($config);

				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];
				if($no_of_form)
				{
					// add intake form batch
					for($i = 1; $i <= $no_of_form; $i++)
					{
						// initialize file names array
						$file_names = [];

						// upload files to server
						$files = @$_FILES['files_'.$i];
						if(!empty($files))
						{	foreach ($files['name'] as $key => $value) 
							{	
								if($files['name'][$key])
								{
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
							'created_by' => $this->ion_auth->user()->row()->id,
							'notes' => $array['notes_'.$i],
							'created' => date("Y-m-d H:i:s"),
							'docs' => implode(",", $file_names)
							);

						// save values to database
						$intake_form_id = $this->common_model->save("intake_form", $data_intake);

						// create directory to identify intake files
						@mkdir(UPLOADFULLPATH . 'intake_forms/'.$intake_form_id, 0777);

						// move all files to that directory

						if(!empty($file_names))
							foreach ($file_names as $fname)
							{
								copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "intake_forms/$fname");
							}
					}
				}

				// settings for my task section for case manager
				if($array['case_manager'])
				{
					$task_data = array(
						'user_id'=>$array['case_manager'],
						'item_id'=>$record_id,
						'task_no'=>$case_no,
						'category'=>'Assistance',
						'type'=>'CASE',
						'priority'=>$array['priority'],
						'created_by'=>$this->ion_auth->user()->row()->id,
						'created'=>date('Y-m-d H:i:s'),
						'user_type'=>'casemanager'
						);
					// insert values to database
					$this->common_model->save("mytask", $task_data);
				}

				// settings for my task section for eac
				if($array['assign_to'] and $array['assign_to'] <> $array['case_manager'])
				{
					$task_data = array(
						'user_id'=>$array['assign_to'],
						'item_id'=>$record_id,
						'task_no'=>$case_no,
						'category'=>'Assistance',
						'type'=>'CASE',
						'priority'=>$array['priority'],
						'created_by'=>$this->ion_auth->user()->row()->id,
						'created'=>date('Y-m-d H:i:s'),
						'user_type'=>'eac'
						);
					// insert values to database
					$this->common_model->save("mytask", $task_data);
				}

				// send success message
				$this->session->set_flashdata('success', "Case successfully created");

				// redirect them to the login page
				redirect('emergency_assistance', 'refresh');
			}
			else
			{
				$this->load->model('api_model');
				$this->load->model('currency_model');
				$this->load->model('country_model');
				$this->load->model('province_model');
				
				$this->data['case_details'] = array();
				
				if (!empty($id)) {
					// verify case details
					$joins[] = array(
						'table' => 'users u1',
						'on' => 'u1.id = case.created_by',
						'type' => 'LEFT'
						);
					$case_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('case.id'=>$id), $joins);
					$this->data['case_details'] = $case_details;
				}
				
				$this->data['policy'] = array();
				if (empty($case_details)) {
					$policy = $this->input->get('policy');
					if (!empty($policy)) {
						if ($policies = $this->api_model->get_policy(array('policy' => $policy))) {
							$this->data['policy'] = $policies[0];
							$this->data['case_details']['street_no'] = $this->data['policy']['street_number'];
							$this->data['case_details']['street_name'] = $this->data['policy']['street_name'];
							$this->data['case_details']['city'] = $this->data['policy']['city'];
							$this->data['case_details']['province'] = $this->data['policy']['province2'];
							$case_details['country2'] = $this->data['case_details']['country2'] = $this->data['policy']['country2'];
							$case_details['country'] = $this->data['case_details']['country'] = $this->data['policy']['country2'];
							$case_details['province'] = $this->data['case_details']['province'] = $this->data['policy']['province2'];
							$this->data['case_details']['post_code'] = $this->data['policy']['postcode'];
						}
					} else {
						$case_details['country2'] = $this->data['case_details']['country2'] = 'CA';
						$case_details['country'] = $this->data['case_details']['country2'] = 'CA';
						$case_details['province'] = $this->data['case_details']['province'] = 'ON';
					}
				} else {
					if ($policies = $this->api_model->get_policy(array('policy' => $case_details['policy_no']))) {
						$this->data['policy'] = $policies[0];
					}
				}
				
				// load dropdowns data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name, $case_details));

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

				$additional_conditions = " and users.active = '1'";
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'"), $empty = "--Follow Up EAC--", $additional_conditions);

				$additional_conditions = " and users.active = '1'";
				$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->common_model->field_val($field_name, $case_details), $group = "casemamager", $empty = "--Select Case Manager--", $additional_conditions);

				$this->data['reasons'] = $this->common_model->getreasons($field_name = "reason", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['relations'] = $this->common_model->getrelations($field_name = "relations", $selected = $this->common_model->field_val($field_name, $case_details));		
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name), FALSE, FALSE);

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Create Case', TRUE);
		        $this->template->write_view('content', 'emergency_assistance/create_case', $this->data);
		        $this->template->render();  
	        }      
		}
	}

	// redirect if needed, otherwise display the edit case page
	public function edit_case($id = 0)
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager() and !$this->ion_auth->is_claimexaminer() and !$this->ion_auth->is_claimsmanager())
		{
			// redirect them to the home page because they must be an case manager or admin to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		else
		{
			// get case details
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
			$case_details = $this->common_model->select($record = "first", $typecast = "array", $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name,  concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, case.created_by as created_by_id", $conditions = array('case.id'=>$id), $joins);
			

			//validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', '');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('last_name', 'Last Name', 'callback_alpha_dash_space');
        	$this->form_validation->set_rules('phone_number', 'Phone', 'required|trim|numeric|min_length[9]|max_length[15]');
        	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('relations', 'Relations', 'required');
        	$this->form_validation->set_rules('post_code', 'Post Code', 'required|trim|max_length[9]|min_length[5]');
        	$this->form_validation->set_rules('incident_date', 'Incident Date', 'required');

			$this->form_validation->set_rules('insured_firstname', 'Insured First Name', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');

			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if($this->input->get("ref") == 'manage')
				$this->form_validation->set_rules('reserve_amount', 'Create Reservers', 'numeric|required');

			if ($this->form_validation->run() == TRUE)
			{
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				foreach ($array as $key => $value) 
				{
					# code...
					$data[$key] = $value;

					// for check third party recovery
					if($key == 'third_party_recovery')
						$data[$key] = $value ? $value : "N";
				}

				// insert values to database
				$this->common_model->update("case", $data, array('id'=>$id));

				// update my task section if there casemanager updated
				if($case_details['case_manager'] <> $array['case_manager'])
				{
					// update casemanager id
					$data_task = array(
						'priority'=>$array['priority'],
						'user_id'=>$array['case_manager']
						);
					$this->common_model->update("mytask", $data_task, array('item_id'=>$id, 'type'=>'CASE', 'user_id'=>$case_details['case_manager'], 'user_type'=>'casemanager'));
				}	

				// update my task section if there follow up updated
				if($case_details['assign_to'] <> $array['assign_to'] and $case_details['assign_to'])
				{
					// update followup id
					$data_task = array(
						'priority'=>$array['priority'],
						'user_id'=>$array['assign_to']
						);
					$this->common_model->update("mytask", $data_task, array('item_id'=>$id, 'type'=>'CASE', 'user_id'=>$case_details['assign_to'], 'user_type'=>'eac'));
				}

				// update my task section if there is new eac assigned
				if($case_details['assign_to'] <> $array['assign_to'] and !$case_details['assign_to'] and ($array['assign_to'] <> $array['case_manager']))
				{
					$task_data = array(
						'user_id'=>$array['assign_to'],
						'item_id'=>$id,
						'task_no'=>$case_details['case_no'],
						'category'=>'Assistance',
						'type'=>'CASE',
						'priority'=>$array['priority'],
						'created_by'=>$case_details['created_by_id'],
						'created'=>$case_details['created'],
						 'user_type'=>'eac'
						);
					// insert values to database
					$this->common_model->save("mytask", $task_data);
				}			

				// update priority to my task
				$data_task = array(
					'priority'=>$array['priority']
					);
				$this->common_model->update("mytask", $data_task, array('item_id'=>$id, 'type'=>'CASE'));

				// send success message
				$this->session->set_flashdata('success', "Case successfully updated");

				// redirect them to the login page
				if($this->input->get('ref') == 'manage')
					redirect('emergency_assistance/case_management', 'refresh');
				else
					redirect('emergency_assistance', 'refresh');
			}
			else
			{	
				$this->data['case_details'] = $case_details;
				if (empty($case_details)) {
					// send error message
					$this->session->set_flashdata('error', "Something went wrong, please try after some time.");

					// redirect them to the list page
					redirect('emergency_assistance', 'refresh');
				}
				$this->load->model('users_model');

				$this->load->model('api_model');
				$this->data['policy'] = array();
				if (empty($case_details)) {
					$policy = $this->input->get('policy');
					if (!empty($policy)) {
						if ($policies = $this->api_model->get_policy(array('policy' => $policy))) {
							$this->data['policy'] = $policies[0];
							$this->data['case_details']['street_no'] = $this->data['policy']['street_number'];
							$this->data['case_details']['street_name'] = $this->data['policy']['street_name'];
							$this->data['case_details']['province'] = $this->data['policy']['province2'];
							$case_details['country2'] = $this->data['case_details']['country2'] = $this->data['policy']['country2'];
							$case_details['country'] = $this->data['case_details']['country'] = $this->data['policy']['country2'];
							$case_details['province'] = $this->data['case_details']['province'] = $this->data['policy']['province2'];
							$this->data['case_details']['post_code'] = $this->data['policy']['postcode'];
						}
					}
				} else {
					if ($policies = $this->api_model->get_policy(array('policy' => $case_details['policy_no']))) {
						$this->data['policy'] = $policies[0];
					}
				}
				
				$this->data['assign_to_name'] = '-';
				if ($users = $this->users_model->search(array('id' => $case_details['assign_to']))) {
					$this->data['assign_to_name'] = $users[0]['first_name'] . " " . $users[0]['last_name'];
				}
				
				// load dropdowns data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province'] = $this->get_provinces($type = 'return', $case_details['country'], $case_details['province']);

				// Load model if needs
				$this->load->model('currency_model');
				$this->load->model('country_model');
				$this->load->model('province_model');
				
				$vdata = array();
				$vdata['name'] = 'inpatient_currency';
				$vdata['options'] = $this->currency_model->get_list();
				$vdata['selected'] = $case_details['inpatient_currency'];
				$this->data['inpatient_currency'] = $this->load->view('template/selection', $vdata, TRUE);
				
				if (empty($case_details['doctor_country'])) $case_details['doctor_country'] = 'CA';
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

				if (empty($case_details['outpatient_country'])) $case_details['outpatient_country'] = 'CA';
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

				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "", $key= "short_code", $value = "name");
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Follow Up EAC--");
				$additional_conditions = " and users.active = '1'";
				$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->common_model->field_val($field_name, $case_details), $group = "casemamager", $empty = "--Select Case Manager--", $additional_conditions);

				$this->data['reasons'] = $this->common_model->getreasons($field_name = "reason", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['relations'] = $this->common_model->getrelations($field_name = "relations", $selected = $this->common_model->field_val($field_name, $case_details));		
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name), FALSE, FALSE);

				// get intake forms
				$joins = [];
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = intake_form.created_by',
					'type' => 'LEFT'
					);
				$this->data['intake_forms'] = $this->common_model->select($record = "list", $typecast = "array", $table = "intake_form", $fields = "intake_form.id, intake_form.notes, intake_form.docs, intake_form.created, concat_ws(' ', u1.first_name, u1.last_name) as created_by, u1.id as user_id, u1.username as username", $conditions = array('intake_form.case_id'=>$id), $joins);

				// pass case id to server
				$this->data['case_id'] = $id;
				$this->data['ref'] = $this->input->get("ref");

				// pass template data if page referred from case management page
				if($this->data['ref'] <> 'manage')
				{
					// get all documents for sending email/print.
					$fields = "id, name, description";
					$access_types = $this->get_access_list('case');
					if($access_types)
						$conditions = "type in (".implode(', ', $access_types).")";
					else
						$conditions = "type in (0)";
					$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);
				}
				else
				{

					// get login user id
					$case_manager = $this->ion_auth->user()->row()->id;

					// timing shifts array
					$shifts = array(
						'8am-2pm'=>array(strtotime("8am"), strtotime("2pm")),
						'2pm-8pm'=>array(strtotime("2pm"), strtotime("8pm")),
						'8pm-8am'=>array(strtotime("8pm"), strtotime("11:59pm"), strtotime("8am"))
						); 

					// rearrange shifts according to system current time 
					if(time() >= $shifts['8am-2pm'][0] && time() < $shifts['8am-2pm'][1])
					{
						$this->data['employee_shift'] = ['8am-2pm', '2pm-8pm', '8pm-8am'];
					}
					if(time() >= $shifts['2pm-8pm'][0] && time() < $shifts['2pm-8pm'][1])
					{
						$this->data['employee_shift'] = ['2pm-8pm', '8pm-8am', '8am-2pm'];
					}
					if((time() >= $shifts['8pm-8am'][0] and time() <= $shifts['8pm-8am'][1]) OR (time() < $shifts['8pm-8am'][2]))
					{
						$this->data['employee_shift'] = ['8pm-8am', '8am-2pm', '2pm-8pm'];
					}

			        // select emc users
					foreach ($this->data['employee_shift'] as $key => $value) 
					{
						$additional_conditions = " and schedule.schedule = '$value' and users.active = '1' ";
			        	$this->data['employees_'.$key] = $this->common_model->shift_users($field_name = "assign_to_follow", $selected = $this->input->get($field_name), $group = "eacmanager", $empty = "--Select Employee--", $additional_conditions);
					}
				}

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Edit Case', TRUE);
		        $this->template->write_view('content', 'emergency_assistance/edit_case', $this->data);
		        $this->template->render();  
	        }      
		}
	}

	// redirect if needed, otherwise display the case management page
	public function case_management()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager())
		{
			// redirect them to the home page because they must be an case manager or admin to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		else
		{
			// initialize variables
			$this->data['cases'] = []; 
			$this->data['policies'] = [];

			// ---search case filter---
			// get all providers list
			$order_by = array(
				'field'=>'id',
				'order'=>'desc'
				);
			$limit = $this->limit; 
			$offset = $this->uri->segment(3);

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
			if($this->input->get("case_no")) 
				$conditions['case.case_no'] = trim($this->input->get("case_no"));
			if($this->input->get("policy_no")) 
				$conditions['case.policy_no'] = trim($this->input->get("policy_no"));
			if($this->input->get("created_from")) 
				$conditions['case.created >= '] = trim($this->input->get("created_from"));
			if($this->input->get("created_to")) 
				$conditions['case.created <= '] = trim($this->input->get("created_to"));
			if($this->input->get("insured_firstname")) 
				$conditions['case.insured_firstname like'] = "%".trim($this->input->get("insured_firstname"))."%";
			if($this->input->get("insured_lastname")) 
				$conditions['case.insured_lastname like'] = "%".trim($this->input->get("insured_lastname"))."%";
			if($this->input->get("assign_to")) 
				$conditions['case.assign_to'] = trim($this->input->get("assign_to"));
			if($this->input->get("priority")) 
				$conditions['case.priority'] = trim($this->input->get("priority"));
			if($this->input->get("status")) 
				$conditions['case.status'] = trim($this->input->get("status"));
			if($this->input->get("assigned_status") ==  'assigned') 
				$conditions['case.assign_to != '] = '0';
			if($this->input->get("assigned_status") ==  'unassigned') 
				$conditions['case.assign_to'] = '0';
			if($this->input->get("case_manager")) 
				$conditions['case.case_manager'] = trim($this->input->get("case_manager"));

			$fields = "case.insured_address, case.last_update, concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, case.insured_lastname, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id, case.status, case.policy_info";
			$results = $this->common_model->select($record = "paginate", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array(), $having = "", $limit, $offset);
			$this->data['cases'] = $results['records'];

			// pagination start here
			$config['base_url'] = site_url('emergency_assistance/case_management');
			$config['per_page'] = $limit;
			$config['first_url'] = $config['base_url'].'?'.http_build_query($this->input->get());
			if (count($this->input->get()) > 0)
				$config['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$config['total_rows'] = $results['rows'];
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data['pagination'] = $this->pagination->create_links(); # create pagination links
			// pagination end here

			// get login user id
			$this->data['case_manager'] = $case_manager = $this->ion_auth->user()->row()->id;

			// timing shifts array
			$shifts = array(
				'8am-2pm'=>array(strtotime("8am"), strtotime("2pm")),
				'2pm-8pm'=>array(strtotime("2pm"), strtotime("8pm")),
				'8pm-8am'=>array(strtotime("8pm"), strtotime("11:59pm"), strtotime("8am"))
				); 

			// rearrange shifts according to system current time 
			if(time() >= $shifts['8am-2pm'][0] && time() < $shifts['8am-2pm'][1])
			{
				$this->data['employee_shift'] = ['8am-2pm', '2pm-8pm', '8pm-8am'];
			}
			if(time() >= $shifts['2pm-8pm'][0] && time() < $shifts['2pm-8pm'][1])
			{
				$this->data['employee_shift'] = ['2pm-8pm', '8pm-8am', '8am-2pm'];
			}
			if((time() >= $shifts['8pm-8am'][0] and time() <= $shifts['8pm-8am'][1]) OR (time() < $shifts['8pm-8am'][2]))
			{
				$this->data['employee_shift'] = ['8pm-8am', '8am-2pm', '2pm-8pm'];
			}

            // select emc users
			foreach ($this->data['employee_shift'] as $key => $value) 
			{
				$additional_conditions = " and schedule.schedule = '$value' and users.active = '1' ";
            	$this->data['employees_'.$key] = $this->common_model->shift_users($field_name = "assign_to", $selected = $this->input->get($field_name), $group = "eacmanager", $empty = "--Select Employee--", $additional_conditions);
			}

			// get all case managers list			
			$additional_conditions = " and users.active = '1'";
        	$this->data['casemanagers'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--", $additional_conditions);

			// get all documents for sending email/print.
			$fields = "id, name, description";
			$access_types = $this->get_access_list('case');
			if($access_types)
				$conditions = "type in (".implode(', ', $access_types).")";
			else
				$conditions = "type in (0)";
			$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);
			
			// get province list
			$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->input->get("province"), $key= "short_code", $value = "name");

			// get products list
			$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->get($field_name), FALSE, FALSE);

			// render view data
        	$this->template->write('title', SITE_TITLE.' - Case Management', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/case_management', $this->data);
	        $this->template->render();        
		}
	}

	
	// reload all docs email/print
	public function reload_docs(){
		
		// get all documents for sending email/print.
		$fields = "id, name, description";
		$access_types = $this->get_access_list('case');
		if($access_types)
			$conditions = "type in (".implode(', ', $access_types).")";
		else
			$conditions = "type in (0)";
		$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);

		// get all word documents
		$fields = "id, title, content";
		$this->data['word_templates'] = $this->common_model->select($record = "list", $typecast = "array", $table = "word_comments", $fields);
		$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "", $key= "short_code", $value = "name");
		$data = array(
			'reload_docs'=>$this->parser->parse("claim/reload_docs", $this->data, TRUE),
			);
		echo json_encode($data);

	}


	// redirect if needed, otherwise display the create policy page
	public function create_policy($id = 0)
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			//validate form input
        	$this->form_validation->set_rules('institution_phone', 'School Phone', 'required|trim|numeric|min_length[9]|max_length[15]');
        	$this->form_validation->set_rules('phone1', 'Phone1', 'required|trim|numeric|min_length[9]|max_length[15]');
        	$this->form_validation->set_rules('phone2', 'Phone2', 'trim|numeric|min_length[9]|max_length[15]');
        	$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'required|trim|numeric|min_length[9]|max_length[15]');
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

			if ($this->form_validation->run() == TRUE)
			{
				// prepare post data array
				$data = [];
				$array = $this->input->post();
				// print_r($array); die;
				foreach ($array as $key => $value) 
				{
					# code...
					if($key <> "submit")
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->user()->row()->id;

				// insert values to database
				$record_id = $this->common_model->save("policies", $data);

				// send success message
				$this->session->set_flashdata('success', "Policy successfully created");

				// redirect them to the login page
				redirect('emergency_assistance', 'refresh');
			}
			else
			{	
				
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name));				
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name));

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Create Policy', TRUE);
		        $this->template->write_view('content', 'emergency_assistance/create_policy', $this->data);
		        $this->template->render();  
	        }      
		}
	}

	// redirect if needed, otherwise display the view policy page
	public function view_policy($policy='') {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (empty($policy)) {
			return show_error('Sorry, Unknown policy.');
		} else {
			$this->data['create_claim_url'] = base_url('claim/create_claim');
			$this->data['create_case_url'] = base_url('emergency_assistance/create_case');

			$this->load->model('api_model');
				
			$policies = $this->api_model->get_policy(array('policy' => $policy));
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
					foreach ($this->data['policy']['family'] as $key => $val) {
						$para = array('policy' => $policies[0]['policy']);
						$para['firstname'] = $val['firstname'];
						$para['lastname'] = $val['lastname'];
						$para['birthday'] = $val['birthday'];
						$para['gender'] = $val['gender'];
						$this->data['policy']['family'][$key]['create_claim_url'] = base_url('claim/create_claim') . "?" . http_build_query($para);
						$this->data['policy']['family'][$key]['create_case_url'] = base_url('emergency_assistance/create_case') . "?" . http_build_query($para);
					}
				}
			}
			
			// get countries list
			$this->data['countries'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->input->get("country2"), $key = "short_code", $value = "name");

			// get province list
			$this->data['provinces'] = $this->common_model->getprovinces($field_name = "province2", $selected = $this->input->get("province2"), $key = "short_code", $value = "name");
			$this->template->write('title', SITE_TITLE.' - View Policy', TRUE);
			$this->template->write_view('content', 'emergency_assistance/view_policy', $this->data);
			$this->template->render();        
		}
	}

	// redirect if needed, otherwise display the create provider page
	public function create_provider()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{

			//validate form input
			$this->form_validation->set_rules('name', "Name", 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('postcode', 'Postcode', 'required');
			$this->form_validation->set_rules('discount', 'Discount', 'required|numeric');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
        	$this->form_validation->set_rules('phone_no', 'Phone', 'required|trim|numeric|min_length[9]|max_length[15]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('ppo_codes', 'PPO Codes', 'required');
			$this->form_validation->set_rules('services', 'Services', 'required');
			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// get lat lng from address
				$cordinates = $this->lat_lng_finder($this->input->post("address").", ".$this->input->post("postcode"));

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
					'lat'=>$cordinates['lat'],
					'lng'=>$cordinates['lng'],
					);
				// insert values to database
				$this->common_model->save("provider", $data);

				// send success message
				$this->session->set_flashdata('success', "Provider successfully added");

				// redirect them to the login page
				redirect('emergency_assistance/create_provider', 'refresh');
			}
			else
			{				
				// load view data
				$this->template->write('title', SITE_TITLE.' - Create Provider', TRUE);
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
			
			//validate form input
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
					$file_path = UPLOADPATH.$file_data['file_name'];
					
					if ($this->csvimport->get_array($file_path)) {
						$csv_array = $this->csvimport->get_array($file_path);

						foreach ($csv_array as $row) {
							$cordinates = $this->common_model->lat_lng_finder($row["Address"].", ".$row["Postcode"]);

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
									'lat'=>$cordinates['lat'],
									'lng'=>$cordinates['lng'],
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
				$this->template->write('title', SITE_TITLE.' - Provider Batch Upload', TRUE);
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
					$address  = $this->input->get('street_no') . " "; 
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
        	$this->template->write('title', SITE_TITLE.' - Search Provider', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/search_provider', $this->data);
	        $this->template->render();        
		}
	}

	// lat lng generator
	public function lat_lng_finder($address = "") {
		// Get lat and long by address         
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = isset($output->results[0]->geometry->location->lat) ? (float)$output->results[0]->geometry->location->lat : 43.653226;
        $longitude = isset($output->results[0]->geometry->location->lng) ? (float)$output->results[0]->geometry->location->lng : -79.3831843;
        return array('lat'=>$latitude, 'lng'=>$longitude);
	}

	// redirect if needed, otherwise display the create intake page
	public function create_intakeform()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->form_validation->set_rules('intake_notes', 'Intake Notes', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// get app post params
				$array = $this->input->post();

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
				if(!empty($files))
				{	foreach ($files['name'] as $key => $value) 
					{	
						if($files['name'][$key])
						{
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
				
				// generate data array
				$data_intake = array(
					'case_id' => $array['case_id'],
					'created_by' => $this->ion_auth->user()->row()->id,
					'notes' => $array['intake_notes'],
					'created' => date("Y-m-d H:i:s"),
					'docs' => implode(",", $file_names)
					);

				// save values to database
				$intake_form_id = $this->common_model->save("intake_form", $data_intake);

				// create directory to identify intake files
				@mkdir(UPLOADFULLPATH . 'intake_forms/'.$intake_form_id, 0777);

				// move all files to that directory
				if(!empty($file_names))
					foreach ($file_names as $fname)
					{
						copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
						unlink(UPLOADFULLPATH . "intake_forms/$fname");
					}

				// send success message
				$this->session->set_flashdata('success', "Intake form successfully added");

				// redirect them to the login page
				redirect('emergency_assistance/edit_case/' . $array['case_id'], 'refresh');
			}
			else 
			{
				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Create IntakeForm', TRUE);
		        $this->template->write_view('content', 'emergency_assistance/create_intakeform');
		        $this->template->render();        
		    }
		}
	}

	// download intake form files
	public function download($file, $id) 
	{
		$this->load->helper("download");
		force_download(UPLOADFULLPATH . 'intake_forms/' . $id . '/' . urldecode($file), NULL);
	}

	// from here download sample file for provider batch upload 
	public function sample_file($file, $id) 
	{
		$this->load->helper("download");
		force_download('./assets/img/provider_csv_sample.csv', NULL);
	}

	// browse intake form files
	public function file($file, $id) 
	{

		// We'll be outputting a PDF
		header('Content-type: application/pdf');

		// The PDF source is in original.pdf
		readfile(UPLOADFULLPATH . 'intake_forms/' . $id . '/' . urldecode($file));
	}	

	// delete intake form here for ajax request
	public function deleteform($form_id) 
	{

		// load files library to delete file
		$this->load->helper('file');

		// delete all files of itake form
		delete_files(UPLOADFULLPATH . "intake_forms/$form_id/", FALSE);
		rmdir(UPLOADFULLPATH . "intake_forms/$form_id");

		// delete intake form
		$this->common_model->delete('intake_form', array('id' => $form_id));

		echo TRUE;

	}


	// Auto schedule process here for ajax request
	public function auto_schedule($emc, $year, $month) 
	{
		if($emc) 
		{
			// get employee details
			$conditions = array('users.id'=>$emc);
			$schedule_details = $this->common_model->select($record = "first", $typecast = "array", $table = "users", $fields = "shift", $conditions);
			if($schedule_details['shift'])
			{
				// auto schedule to this employee for this month
				for($i = 1; $i <= date('t', strtotime($year."-".$month)); $i++)
				{
					$data = array(
						'schedule'=>$schedule_details['shift'],
						'employee_id'=>$emc,
						'date'=>$year."-".$month."-".$i,
						'created'=>date("Y-m-d H:i:s")
						);
					if(strtotime(date('Y-m-d')) <= strtotime($year."-".$month."-".$i))
					{
						// delete schedule if already exists
						$this->common_model->delete('schedule', array('employee_id'=>$emc, 'date'=>$year."-".$month."-".$i));

						// insert schedule data
						$this->common_model->save("schedule", $data);
					}
				}

				echo TRUE;
			}
		} 
		else
		{
			// get all eac's list
			$joins = [];
			$fields = "users.shift, users.id";
			$joins[] = array(
				'table' => 'users_groups',
				'on' => 'users_groups.user_id = users.id',
				'type' => 'LEFT'
				);
			$conditions = "users_groups.group_id = '2' and users.active = '1'";
			$users = $this->common_model->select($record = "list", $typecast = "array", $table = "users", $fields, $conditions, $joins, array(), array("users_groups.user_id"));
			if(!empty($users))
			{
				foreach ($users as $schedule_details) 
				{
					if($schedule_details['shift'])
					{
						// auto schedule to this employee for this month
						for($i = 1; $i <= date('t', strtotime($year."-".$month)); $i++)
						{
							$data = array(
								'schedule'=>$schedule_details['shift'],
								'employee_id'=>$schedule_details['id'],
								'date'=>$year."-".$month."-".$i,
								'created'=>date("Y-m-d H:i:s")
								);
							if(strtotime(date('Y-m-d')) <= strtotime($year."-".$month."-".$i))
							{
								// delete schedule if already exists
								$this->common_model->delete('schedule', array('employee_id'=>$schedule_details['id'], 'date'=>$year."-".$month."-".$i));

								// insert schedule data
								$this->common_model->save("schedule", $data);
							}
						}
					}
				}
				echo TRUE;
			}
			else
				echo FALSE;
		}
	}

	// search users for ajax request
	public function search_users($year, $month, $emc, $date, $type, $day) 
	{

		// prepare date
		$date = $year."-".$month."-".$date;

		// table settings goes here
		$table = "users";
		$fields = "users.first_name, users.last_name, users.email, users.active, users.id, (select schedule.schedule from schedule where schedule.employee_id = users.id and schedule.date = '$date') as schedule"; 
		$group_by = array("users_groups.user_id");

		// get login user id (case manager id)
		$case_manager = $this->ion_auth->user()->row()->id;

		// prepare conditions
		$conditions[] = "users_groups.group_id = '2' and users.active = '1'";
		if($this->input->post("last_name")) 
			$conditions[] = "users.last_name like '%".$this->input->post("last_name")."%'";
		if($this->input->post("first_name")) 
			$conditions[] = "users.first_name like '%".$this->input->post("first_name")."%'";
		if($this->input->post("email")) 
			$conditions[] = "users.email like '%".$this->input->post("email")."%'";
		$conditions = implode(" and ", $conditions);
		$conditions .= " and IF(schedule.date = '$date',  schedule.date = '$date', users.id > '0')";

		// check records if related to specific emc
		if($emc)
			$conditions .= " and users.id = '$emc'";
		$group_by = array("users_groups.user_id");
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
		if($this->input->get("field")) 
			$order_by = array(
				'field' => $this->input->get("field"),
				'order' => $this->input->get("order")
				);

		// get result
		$this->data['users'] = $this->common_model->select($record = "list", $typecast = "array", $table, $fields, $conditions, $joins, $order_by, $group_by);
		$this->data['date'] = $date;
		$this->data['type'] = $type;
		$this->data['emc'] = $emc;

		// render view file
		$this->load->view("emergency_assistance/search_users", $this->data);
	}
	
	// save schedule here from ajax request
	public function save_schedule($year, $month, $date, $type, $day) 
	{

		// prepare date
		$date = $year."-".$month."-".$date;

		// select post  request
		$employee_id  =$this->input->post("employee_id");
		$schedule  =$this->input->post("schedule");

		// check user select day(monday) or date(0000-00-00)
		if($type == 'day')
		{
			// get all dates of month
			$dates = $this->common_model->getAllDaysInAMonth($year, ucfirst($month), $day);

			// used to add single quotes in save_schedule($year, $month, $date, $type, $day) function
			function add_quotes($str) 
			{
			    return sprintf("'%s'", $str);
			}

			// delete schedule for this week		
			$conditions = "schedule.date in(".implode(',', array_map('add_quotes', $dates)).") and employee_id = '$employee_id'";	
			$this->common_model->delete('schedule', $conditions);

			// add schedule for whole week 
			foreach($dates as $schedule_date)
			{
				// insert values to database
				$data = array(
					'schedule'=>$schedule,
					'employee_id'=>$employee_id,
					'date'=>$schedule_date,
					'created'=>date("Y-m-d H:i:s")
					);
				$this->common_model->save("schedule", $data);
			}

		}
		else
		{
			// check employee schedule if exist
			$conditions = array('schedule.employee_id'=>$employee_id, 'schedule.date'=>$date);
			$schedule_details = $this->common_model->select($record = "first", $typecast = "array", $table = "schedule", $fields = "id", $conditions);

			// insert schedule data
			if(empty($schedule_details))
			{
				// insert values to database
				$data = array(
					'schedule'=>$schedule,
					'employee_id'=>$employee_id,
					'date'=>$date,
					'created'=>date("Y-m-d H:i:s")
					);
				$this->common_model->save("schedule", $data);
			}
			else if(!$schedule)
			{
				// delete schedule request
				$this->common_model->delete('schedule', $conditions);

			} 
			else 
			{
				// update schedule data
				$this->common_model->update("schedule", array("schedule"=>$schedule), $conditions);

			}
		}
		echo TRUE;

	}

	// redirect if needed, otherwise display the schedule page
	public function schedule($emc = 0, $year = "", $month = "")
	{
		// check date and time
		if(!$year)
		{
			$year = date("Y"); 
			$month = date('m');
		}
		$year = intval($year); 
		$month = str_pad(intval($month), 2, 0, STR_PAD_LEFT);
		
		// only accessible for case managers
		if (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager())
		{
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		 else if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			// get user type if exists
			$this->data['emc'] = $this->input->get('emc')?$this->input->get('emc'):$emc;

			//get schedule calendar
			$this->data['calendar'] = $this->schedule_calendar($this->data['emc'], $year, $month, "return");

			// pass month and year to calender page
			$this->data['year'] = $year;
			$this->data['month'] = $month;

			// get countries list
			$this->data['countries'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->input->get("country2"), $key = "short_code", $value = "name");
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "emc", $this->data['emc'], $group = array("'eacmanager'"), $empty = "--Select Employee--", $additional_conditions = " and users.active = '1'", $user_code = "EAC");
			
        	$this->template->write('title', SITE_TITLE.(!$this->ion_auth->is_casemamager()?' - My Work Schedule':' - Employee Schedule'), TRUE);
	        $this->template->write_view('content', 'emergency_assistance/schedule', $this->data);
	        $this->template->render();        
		}
	}

	
    /**
     * schedule calendar for ajax request and in schedule page
     *
     * @param       $year String
     * @param       $month array
     * @param       $type return - for return data/output - echo response for ajax complete
     * @param       $emc int - show events and calender for specific emc user
    */
	public function schedule_calendar($emc = 0, $year = "", $month = "", $type = "return")
	{
		// check date and time
		if(!$year)
		{
			$year = date("Y"); 
			$month = date('m');
		}
		// only accessible for case managers
		if (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager())
		{
			// redirect them to the home page because they must be an case manager to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		}
		else
		{
			// get login user id (case manager id)
			$case_manager = $this->ion_auth->user()->row()->id;

			// get all schedules added by this case manager and show all to calender
			$order_by = array(
				'field'=>'schedule.id',
				'order'=>'desc'
				);


			$joins[] = array(
				'table' => 'users u1',
				'on' => 'u1.id = schedule.employee_id',
				'type' => 'LEFT'
				);
			// prepare conditions
			if($this->ion_auth->is_casemamager())
				$conditions = "schedule.date like '%$year-$month%'";
			else
				$conditions = "schedule.date like '%$year-$month%' and u1.id = '$case_manager'";

			// if calender for specific employee
			if($emc)
				$conditions .= " and u1.id = '$emc'";
			$group_by = array("schedule.date");

			$fields = "DATE_FORMAT(schedule.date, '%d') as date,  ";

			// check calendar for on or all emc users
			if($emc)
				$fields .= "GROUP_CONCAT(schedule.schedule ORDER BY  schedule.id ASC SEPARATOR '|') as data";
			else
				$fields .= "GROUP_CONCAT(concat_ws('-', concat_ws('', 'EAC', LPAD(u1.id, 4, 0)), schedule.schedule) ORDER BY  schedule.id ASC SEPARATOR '|') as data";

			$this->data['schedules'] = $this->common_model->select($record = "list", $typecast = "array", $table = "schedule", $fields, $conditions, $joins, $order_by, $group_by);

			$content = [];
			if(!empty($this->data['schedules']))
				foreach ($this->data['schedules'] as $key => $value) 
				{
					$schedule_data = explode("|", $value['data']);
					$prepare_list = "";
					foreach ($schedule_data as $d) 
						$prepare_list .= "<li>$d</li>";
					$content[intval($value['date'])] = "<ul>$prepare_list</ul>";
				}
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
			if($type == 'return')
				return $this->calendar->generate($year, $month, $content);       
			else
				echo $this->calendar->generate($year, $month, $content); 
		}
	}

	// assign case manager manually or automatically for ajax request
	public function assign_cases($type = "automatic") 
	{
		$cases = $this->input->post("cases");	
		$cases = explode(",", $cases);		
		if($type == "manually")
		{
			$employee_id = $this->input->post("employee_id");

			// asigning process
			foreach ($cases as $key => $value) 
			{
				$this->common_model->update("case", array("case_manager"=>$employee_id), array("id"=>$value));
				

				// check task, if already exists
				$task_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "mytask", $fields = "mytask.id", $conditions = array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'casemanager'));

				if(!empty($task_details))
				{
					// update casemanager id to task table
					$data_task = array(
						'user_id'=>$employee_id
						);
					$this->common_model->update("mytask", $data_task, array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'casemanager'));
				} 
				else 
				{
					// get case details here
					$case_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "case", $fields = "created_by, created, priority, case_no", $conditions = array('case.id'=>$value));

					// create new task here
					$task_data = array(
						'user_id'=>$employee_id,
						'item_id'=>$value,
						'task_no'=>$case_details['case_no'],
						'category'=>'Assistance',
						'type'=>'CASE',
						'priority'=>$case_details['priority'],
						'created_by'=>$case_details['created_by'],
						'created'=>$case_details['created'],
						'user_type'=>'casemanager'
						);
					// insert values to database
					$this->common_model->save("mytask", $task_data);
				}
			}
		}

		// assign cases with emc which have minimum cases one by one ascending order
		else if($type == 'automatic')
		{
			$fields = "count(case.id) as counter, users.id";
			$conditions = "";
			$joins[] = array(
				'table' => 'case',
				'on' => 'users.id = case.case_manager',
				'type' => 'LEFT'
				);
			$order_by = array(
					'field'=>'counter',
					'order'=>'asc'
				);
			$group_by = array(
				'users.id'
				);
			$users= $this->common_model->select($record = "first", $typecast = "array", $table = "users", $fields, $conditions, $joins, $order_by, $group_by, $having = "" );
			if(!empty($users))
				foreach ($cases as $key => $value) 
				{
					$this->common_model->update("case", array("assign_to"=>$users['id']), array("id"=>$value));

					// check task, if already exists
					$task_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "mytask", $fields = "mytask.id", $conditions = array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'eac'));

					if(!empty($task_details))
					{
						// update my task data
						$data_task = array(
							'user_id'=>$users['id']
							);
						$this->common_model->update("mytask", $data_task, array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'eac'));
					} 
					else 
					{
						// get case details here
						$case_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "case", $fields = "created_by, created, priority, case_no", $conditions = array('case.id'=>$value));

						// create new task here
						$task_data = array(
							'user_id'=>$users['id'],
							'item_id'=>$value,
							'task_no'=>$case_details['case_no'],
							'category'=>'Assistance',
							'type'=>'CASE',
							'priority'=>$case_details['priority'],
							'created_by'=>$case_details['created_by'],
							'created'=>$case_details['created'],
							'user_type'=>'eac'
							);
						// insert values to database
						$this->common_model->save("mytask", $task_data);
					}
				}			
		}

		echo TRUE;

	}

	//follow up cases only for ajax request
	public function follow_up_cases() 
	{
		$cases = $this->input->post("cases");
		$notes = $this->input->post("notes");	
		$cases = explode(",", $cases);
		$employee_id = $this->input->post("employee_id");

		// follow up process
		foreach ($cases as $key => $value) 
		{

			$data_intake = array(
				'case_id' => $value,
				'created_by' => $this->ion_auth->user()->row()->id,
				'notes' => $notes,
				'followup' => 1,
				'created' => date("Y-m-d H:i:s")
				);

			// save values to intake database
			$this->common_model->save("intake_form", $data_intake);

			// save record in intake form as notes
			$this->common_model->update("case", array("assign_to"=>$employee_id), array("id"=>$value));

			// check task, if already exists
			$task_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "mytask", $fields = "mytask.id", $conditions = array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'eac'));

			if(!empty($task_details))
			{
				// update my task data
				$data_task = array(
					'user_id'=>$employee_id
					);
				$this->common_model->update("mytask", $data_task, array('item_id'=>$value, 'type'=>'CASE', 'user_type'=>'eac'));
			} 
			else 
			{
				// get case details here
				$case_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "case", $fields = "created_by, created, priority, case_no, case_manager", $conditions = array('case.id'=>$value));

				if($case_details['case_manager'] <> $employee_id)
				{
					// create new task here
					$task_data = array(
						'user_id'=>$employee_id,
						'item_id'=>$value,
						'task_no'=>$case_details['case_no'],
						'category'=>'Assistance',
						'type'=>'CASE',
						'priority'=>$case_details['priority'],
						'created_by'=>$case_details['created_by'],
						'created'=>$case_details['created'],
						'user_type'=>'eac'
						);
					// insert values to database
					$this->common_model->save("mytask", $task_data);
				}
			}
		}

		$this->session->set_flashdata('success', "Follow up case successfully.");

		echo TRUE;

	}

	//mark inactive cases for ajax request
	public function updatestatus($status = 'D') 
	{
		$cases = $this->input->post("cases");	
		$cases = explode(",", $cases);

		// mark deactivate process
		foreach ($cases as $key => $value) 
		{
			$this->common_model->update("case", array("status"=>$status), array("id"=>$value));
		}
		if($status == 'D')
			$this->session->set_flashdata('success', "Cases inactive successfully.");
		else
			$this->session->set_flashdata('success', "Cases closed successfully.");

		echo TRUE;

	}

	//mark inactive case for ajax request
	public function update_case_status($status = 'D') 
	{
		$cases = $this->input->post("cases");	

		// mark deactivate process
		$this->common_model->update("case", array("status"=>$status), array("id"=>$cases));
		
		if($status == 'A')
			$this->session->set_flashdata('success', "Case active successfully.");
		else
			$this->session->set_flashdata('success', "Case inactive successfully.");

		echo TRUE;

	}

	//send email template for ajax request
	public function send_print_email() 
	{
		// get all requested params
		$email = $this->input->post("email");
		$street_no = $this->input->post("street_no");
		$street_name = $this->input->post("street_name");
		$city = $this->input->post("city");
		$province = $this->input->post("province");
		$template = $this->input->post("template");
		$doc = $this->input->post("doc");
		$case_id = $this->input->post("case_id");

		// create pdf from template	 using DOM PDF	
		require_once './assets/dompdf/dompdf_config.inc.php';		
	    $dompdf = new DOMPDF();
	    $dompdf->load_html($template);
	    $dompdf->render();
	    $output = $dompdf->output();
	    $filename = trim($doc).rand(999,999999).'.pdf';
	    $filepath =  UPLOADFULLPATH . "temp/".$filename;
	    file_put_contents($filepath, $output);

		// generate data array
		$intake_notes = array(
			"Email: ".$email,
			"Street No: ".$street_no,
			"Street No: ".$street_name,
			"City: ".$city,
			"Province: ".$province,
			);
		$data_intake = array(
			'case_id' => $case_id,
			'created_by' => $this->ion_auth->user()->row()->id,
			'notes' => implode(", ", $intake_notes),
			'created' => date("Y-m-d H:i:s"),
			'docs' => $filename
			);

		// save values to database
		$intake_form_id = $this->common_model->save("intake_form", $data_intake);

		// create directory to identify intake files
		@mkdir(UPLOADFULLPATH . 'intake_forms/'.$intake_form_id, 0777);

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
	public function claim()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			// initialize variables
			$this->data['cases'] = []; 
			$this->data['policies'] = [];

			// search case filter
			if($this->input->get("filter") == 'case') 
			{
				// get all providers list
				$order_by = array(
					'field'=>'id',
					'order'=>'desc'
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
				if($this->input->get("case_no")) 
					$conditions['case.case_no'] = $this->input->get("case_no");
				if($this->input->get("policy_no")) 
					$conditions['case.policy_no'] = $this->input->get("policy_no");
				if($this->input->get("client_user_name")) 
					$conditions['concat_ws(" ", case.insured_firstname, case.insured_lastname) like'] = "%".$this->input->get("client_user_name")."%";
				if($this->input->get("created")) 
					$conditions['case.created like'] = "%".$this->input->get("created")."%";
				if($this->input->get("assign_to")) 
					$conditions['case.assign_to'] = $this->input->get("assign_to");
				if($this->input->get("case_manager")) 
					$conditions['case.case_manager'] = $this->input->get("case_manager");

				$fields = "concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id";
				$this->data['cases'] = $this->common_model->select($record = "list", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array());
			}
			else if($this->input->get("filter") == 'policy')
			{

				// prepare post data array
				$this->data['params'] = $this->input->get();
				$this->data['params']['key'] = API_KEY;

				foreach ($this->data['params'] as $k => $v) {
					$this->data['params'][$k] = trim($v);
				}
				// search policy code here
				$url =  API_URL."search";
				$curl = curl_init();

				// Post Data 
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data['params']);

				// Optional Authentication:
				if(API_USER and API_PASSWORD)
				{
					curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					curl_setopt($curl, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
				}

				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
				curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
				curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
				
				$result = curl_exec($curl);
				$result = json_decode($result, TRUE);

				// pass policies data to view
				$this->data['policies']  = @$result['plan_list'];
				$this->data['status']  = @$result['status_list'];

				curl_close($curl);
			}

			// send case manager and eac managers list
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = $this->input->get($field_name), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Assign To--");
			$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--");

			// send countries and province list
			$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->input->get($field_name), $key = "short_code", $value = "name");
			$this->data['policy_status'] = $this->common_model->get_policy_status($field_name = "status_id", $selected = $this->input->get($field_name));
			$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->get($field_name));
				

			// render view data
        	$this->template->write('title', SITE_TITLE.' - Claim', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/claim', $this->data);
	        $this->template->render();        
		}
	}

	// get policy information from jfinsurance database
	function get_policy_info()
	{
		// prepare post data array
		$this->data['params'] = $this->input->get();
		$this->data['params']['key'] = API_KEY;
		
		// search policy code here
		$url =  API_URL."search";
		$curl = curl_init();

		// Post Data 
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data['params']);

		// Optional Authentication:
		if(API_USER and API_PASSWORD)
		{
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
		}

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

		$result = curl_exec($curl);
		if ($result) {
			curl_close($curl);
			echo $result;
		} else {
			echo curl_error($curl);
			curl_close($curl);
			echo json_encode(array("error" => "Access Server Error"));
		}
		die;
	}

	// get provinces list from country name
	function get_provinces($type = 'return', $country_name = '', $selected = '')
	{
		// get country id from name
		$country_name = urldecode($country_name);
		$country_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "country", $fields = "`country`.id", $conditions = array('country.short_code'=>$country_name));
		$country_id = @$country_details['id'];
		$conditions = "province.country_id = '$country_id'";

		if($type == 'return')
			return $this->common_model->getprovinces($field_name = "province", $selected, $key = "short_code", $value = "name", $conditions);
		else
			echo $this->common_model->getprovinces($field_name = "province", $selected, $key = "short_code", $value = "name", $conditions);
		
	}

	// return list of role for current user
	function get_access_list($type = '')
	{
		$id = $this->ion_auth->user()->row()->id;

		$joins[] = array(
			'table' => 'groups',
			'on' => 'groups.id = users_groups.group_id',
			'type' => 'INNER'
			);
		$roles = $this->common_model->select($record = "list", $typecast = "array", $table = "users_groups", $fields = "groups.name", $conditions = array('users_groups.user_id'=>$id), $joins);

		$return = [];
		if(!empty($roles))
			foreach ($roles as $key => $value) {
				if($type == 'case')
				{
					if($value['name'] == 'eacmanager')
						$return[] = "'emc'";

					else if($value['name'] == 'casemamager')
						$return[] = "'case'";

					else if($value['name'] == 'admin')
					{
						$return[] = "'emc'";
						$return[] = "'case'";
					}
				}
				else
				{
					if($value['name'] == 'claimexaminer')
						$return[] = "'claim'";

					else if($value['name'] == 'admin')
						$return[] = "'claim'";
				}				
			}
		return $return;

	}

	// to clear schedule for eac users
	function clear_schedule()
	{
		$date = $this->input->post('selected_date');
		$selected_week = $this->input->post('selected_week');
		$selected_month = $this->input->post('selected_month');

		$employee_id = $this->input->get('employee_id');

		if($date)
		{
			$conditions = array(
					'date'=>$date,
				);
		}
		if($selected_week)
		{
			$dates = explode(' to ', $selected_week);
			$conditions = array();
			$conditions['date >= '] = $dates[0];
			$conditions['date <= '] = $dates[1];
		}
		if($selected_month)
		{
			$conditions = array(
					'date like '=>"%$selected_month%",
				);
		}
		if($employee_id)
			$conditions['employee_id'] = $employee_id;

		$this->common_model->delete('schedule', $conditions);
		echo $this->db->last_query();
		echo TRUE;
	}
}
