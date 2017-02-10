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
		elseif (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager())
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

				$fields = "concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id";
				$this->data['cases'] = $this->common_model->select($record = "list", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array());
			}
			else if($this->input->get("filter") == 'policy')
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
        	$this->template->write('title', SITE_TITLE.' - View Edit Emergency Assistance Case', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/index', $this->data);
	        $this->template->render();        
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
			//validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', '');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
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

				// insert values to database
				$record_id = $this->common_model->save("case", $data);

				// update case no(7 length) to table
				$case_no = str_pad($record_id, 7, 0, STR_PAD_LEFT); 
				$this->common_model->update("case", array("case_no"=>$case_no), array("id"=>$record_id));

				// load upload class
				$config['upload_path'] = './assets/uploads/intake_forms/';
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
						$files = $_FILES['files_'.$i];
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
						@mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

						// move all files to that directory
						if(!empty($file_names))
							foreach ($file_names as $fname)
							{
								copy("./assets/uploads/intake_forms/$fname", "./assets/uploads/intake_forms/$intake_form_id/$fname");
								unlink("./assets/uploads/intake_forms/$fname");
							}
					}
				}

				// settings for my task section for eac
				if($array['assign_to'])
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

				// send success message
				$this->session->set_flashdata('success', "Case successfully created");

				// redirect them to the login page
				redirect('emergency_assistance', 'refresh');
			}
			else
			{	
				// verify case details
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = case.created_by',
					'type' => 'LEFT'
					);
				$case_details = $this->common_model->select($record = 'first', $typecast = 'array', $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('case.id'=>$id), $joins);
				$this->data['case_details'] = $case_details;
				
				// load dropdowns data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Follow Up EAC--");
				$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->common_model->field_val($field_name, $case_details), $group = "casemamager", $empty = "--Select Case Manager--");
				$this->data['reasons'] = $this->common_model->getreasons($field_name = "reason", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['relations'] = $this->common_model->getrelations($field_name = "relations", $selected = $this->common_model->field_val($field_name, $case_details));

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
		else if (!$this->ion_auth->is_admin() and !$this->ion_auth->is_casemamager())
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
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('priority', 'Priority', 'required');
			if($this->input->get("ref") == 'manage')
				$this->form_validation->set_rules('reserve_amount', 'Create Reservers', 'number');

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
				if($case_details['assign_to'] <> $array['assign_to'] and !$case_details['assign_to'])
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
				redirect('emergency_assistance', 'refresh');
			}
			else
			{	
				$this->data['case_details'] = $case_details;
				if(empty($case_details))
				{
					// send error message
					$this->session->set_flashdata('error', "Something went wrong, please try after some time.");

					// redirect them to the list page
					redirect('emergency_assistance', 'refresh');
				}

				// load dropdowns data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "", $key= "short_code", $value = "name");
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Follow Up EAC--");
				$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->common_model->field_val($field_name, $case_details), $group = "casemamager", $empty = "--Select Case Manager--");
				$this->data['reasons'] = $this->common_model->getreasons($field_name = "reason", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['relations'] = $this->common_model->getrelations($field_name = "relations", $selected = $this->common_model->field_val($field_name, $case_details));

				// get intake forms
				$joins = [];
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = intake_form.created_by',
					'type' => 'LEFT'
					);
				$this->data['intake_forms'] = $this->common_model->select($record = "list", $typecast = "array", $table = "intake_form", $fields = "intake_form.id, intake_form.notes, intake_form.docs, intake_form.created, concat_ws(' ', u1.first_name, u1.last_name) as created_by, u1.id as user_id", $conditions = array('intake_form.case_id'=>$id), $joins);

				// pass case id to server
				$this->data['case_id'] = $id;
				$this->data['ref'] = $this->input->get("ref");

				// pass template data if page referred from case management page
				if($this->data['ref'] <> 'manage')
				{
					// get all documents for sending email/print.
					$fields = "id, name, description";
					$conditions = "type = 'case'";
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
						$additional_conditions = " and users.parent_id = '$case_manager' and  schedule.schedule = '$value'";
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
				$conditions['case.case_no'] = $this->input->get("case_no");
			if($this->input->get("policy_no")) 
				$conditions['case.policy_no'] = $this->input->get("policy_no");
			if($this->input->get("created_from")) 
				$conditions['case.created >= '] = $this->input->get("created_from");
			if($this->input->get("created_to")) 
				$conditions['case.created <= '] = $this->input->get("created_to");
			if($this->input->get("insured_firstname")) 
				$conditions['case.insured_firstname like'] = "%".$this->input->get("insured_firstname")."%";
			if($this->input->get("insured_lastname")) 
				$conditions['case.insured_lastname like'] = "%".$this->input->get("insured_lastname")."%";
			if($this->input->get("assign_to")) 
				$conditions['case.assign_to'] = $this->input->get("assign_to");
			if($this->input->get("priority")) 
				$conditions['case.priority'] = $this->input->get("priority");
			if($this->input->get("status")) 
				$conditions['case.status'] = $this->input->get("status");
			if($this->input->get("assigned_status") ==  'assigned') 
				$conditions['case.assign_to != '] = '0';
			if($this->input->get("assigned_status") ==  'unassigned') 
				$conditions['case.assign_to'] = '0';
			if($this->input->get("case_manager")) 
				$conditions['case.case_manager'] = $this->input->get("case_manager");

			$fields = "case.insured_address, concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name, case.insured_lastname, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id, case.status, case.policy_info";
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
				$additional_conditions = " and users.parent_id = '$case_manager' and  schedule.schedule = '$value'";
            	$this->data['employees_'.$key] = $this->common_model->shift_users($field_name = "assign_to", $selected = $this->input->get($field_name), $group = "eacmanager", $empty = "--Select Employee--", $additional_conditions);
			}

			// get all case managers list			
			$additional_conditions = "";
        	$this->data['casemanagers'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--", $additional_conditions);

			// get all documents for sending email/print.
			$fields = "id, name, description";
			$conditions = "type = 'case'";
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
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');

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
	public function view_policy()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
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
			$this->form_validation->set_rules('name', "Name", 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('postcode', 'Postcode', 'required');
			$this->form_validation->set_rules('discount', 'Discount', 'required');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
			$this->form_validation->set_rules('phone_no', 'Phone No', 'required');
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

	// redirect if needed, otherwise display the search provider page
	public function search_provider()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{	
			// get all url params
			$params = $this->input->get();
			$address = trim(implode(" ", array_values($params)));

			$fields = "*";
			$having = "";

			// if address is not empty
			if($address)
			{
				// get cordinates
				$cordinates = $this->lat_lng_finder($address);

				$fields = "*, (
					    3959 * acos (
					      cos ( radians(".$cordinates['lat'].") )
					      * cos( radians( lat ) )
					      * cos( radians( lng ) - radians(".$cordinates['lng'].") )
					      + sin ( radians(".$cordinates['lat'].") )
					      * sin( radians( lat ) )
					    )
					  ) AS distance";
			  	$having = "distance < " . NEAREST_PROVIDERS_RANGE;
		  	}
			$order_by = array(
				'field' => 'discount',
				'order' => 'desc'
				);
			// get all providers list
			$records = $this->common_model->select($record = "list", $typecast = "array", $table = "provider", $fields, $conditions = "", $joins = array(), $order_by, $group_by = array(), $having);
			$this->data['records'] = $records;

			// get countries list
			$this->data['countries'] = $this->common_model->getcountries($field_name = "country", $selected = $this->input->get("country"));

			// get province list
			$this->data['provinces'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->input->get("province"));

			// load view data
        	$this->template->write('title', SITE_TITLE.' - Search Provider', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/search_provider', $this->data);
	        $this->template->render();        
		}
	}

	// lat lng generator
	public function lat_lng_finder($address = "")
	{

		// Get lat and long by address         
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = @$output->results[0]->geometry->location->lat?$output->results[0]->geometry->location->lat:0;
        $longitude = @$output->results[0]->geometry->location->lng?$output->results[0]->geometry->location->lng:0;
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
				$config['upload_path'] = './assets/uploads/intake_forms/';
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
				@mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

				// move all files to that directory
				if(!empty($file_names))
					foreach ($file_names as $fname)
					{
						copy("./assets/uploads/intake_forms/$fname", "./assets/uploads/intake_forms/$intake_form_id/$fname");
						unlink("./assets/uploads/intake_forms/$fname");
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
		force_download('./assets/uploads/intake_forms/' . $id . '/' . urldecode($file), NULL);
	}

	// browse intake form files
	public function file($file, $id) 
	{

		// We'll be outputting a PDF
		header('Content-type: application/pdf');

		// The PDF source is in original.pdf
		readfile('./assets/uploads/intake_forms/' . $id . '/' . urldecode($file));
	}	

	// delete intake form here for ajax request
	public function deleteform($form_id) 
	{

		// load files library to delete file
		$this->load->helper('file');

		// delete all files of itake form
		delete_files("./assets/uploads/intake_forms/$form_id/", FALSE);
		rmdir("./assets/uploads/intake_forms/$form_id");

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
					if(time() < strtotime($year."-".$month."-".$i))
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
			$fields = "shift, id";
			$conditions = "users.parent_id = '".$this->ion_auth->user()->row()->id."'";
			$users = $this->common_model->select($record = "list", $typecast = "array", $table = "users", $fields, $conditions);
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
							if(time() < strtotime($year."-".$month."-".$i))
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
		$conditions[] = "users.parent_id = '$case_manager'";
		$conditions[] = "users_groups.group_id = '2'";
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
		// only accessible for case managers
		if (!$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager())
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
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "emc", $this->data['emc'], $group = array("'eacmanager'"), $empty = "--Select Employee--", $additional_conditions = " and users.parent_id='".$this->ion_auth->user()->row()->id."'", $user_code = "EAC");
			
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
		if (!$this->ion_auth->is_casemamager() and !$this->ion_auth->is_eacmanager())
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
				$conditions = "schedule.date like '%$year-$month%' and u1.parent_id = '$case_manager'";
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
			$conditions = "users.parent_id = '".$this->ion_auth->user()->row()->id."'";
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
					'user_type'=>'eac'
					);
				// insert values to database
				$this->common_model->save("mytask", $task_data);
			}
		}

		$this->session->set_flashdata('success', "Follow up case successfully.");

		echo TRUE;

	}

	//mark inactive cases for ajax request
	public function mark_inactive() 
	{
		$cases = $this->input->post("cases");	
		$cases = explode(",", $cases);

		// mark deactivate process
		foreach ($cases as $key => $value) 
		{
			$this->common_model->update("case", array("status"=>'D'), array("id"=>$value));
		}
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
	    $filepath =  "./assets/temp/".$filename;
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
		@mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

		// move all files to that directory
		copy("./assets/temp/$filename", "./assets/uploads/intake_forms/$intake_form_id/$filename");
		unlink("./assets/temp/$filename");

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
		$this->email->attach("assets/uploads/intake_forms/$intake_form_id/$filename");
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

		$result = curl_exec($curl);

		curl_close($curl);

		// pass policies data to view
		echo $result;
		die;

	}


}
