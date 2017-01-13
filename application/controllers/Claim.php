<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Claim extends CI_Controller {

	private $limit = 10;

	public function __construct()
	{
		parent::__construct();

		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}

	
	// redirect if needed, otherwise display the claim page
	public function index()
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

			// search claim filter
			if($this->input->get("filter") == 'claim') 
			{
				// get all providers list
				$order_by = array(
					'field'=>'id',
					'order'=>'desc'
					);

				$joins = [];

				// prepare conditions
				$conditions = [];
				if($this->input->get("claim_no_claim")) 
					$conditions['claim.claim_no'] = $this->input->get("claim_no_claim");
				if($this->input->get("policy_claim")) 
					$conditions['claim.policy_no'] = $this->input->get("policy_claim");
				if($this->input->get("created")) 
					$conditions['claim.created like'] = "%".$this->input->get("created")."%";
				if($this->input->get("firstname_claim")) 
					$conditions['claim.insured_first_name like'] = "%".$this->input->get("firstname_claim")."%";
				if($this->input->get("lastname_claim")) 
					$conditions['claim.insured_last_name like'] = "%".$this->input->get("lastname_claim")."%";

				if($this->input->get("claim_date_from")) 
					$conditions['claim.claim_date >= '] = $this->input->get("claim_date_from");
				if($this->input->get("claim_date_to")) 
					$conditions['claim.claim_date <= '] = $this->input->get("claim_date_to");

				$fields = "claim.id, claim.policy_no, claim.claim_no, claim.insured_first_name, claim.insured_last_name, claim.gender, claim.dob, claim.claim_date, claim.status";
				$this->data['claims'] = $this->common_model->select($record = "list", $typecast = "array", $table = "claim", $fields, $conditions, $joins, $order_by, $group_by = array());
			}
			else if($this->input->get("filter") == 'case') 
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
	        $this->template->write_view('content', 'claim/index', $this->data);
	        $this->template->render();        
		}
	}


	// redirect if needed, otherwise display the create claim page
	public function create_claim()
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
				foreach ($array as $key => $value) 
				{
					# code...
					if($key <> "filter" && $key <> "same_policy")
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->user()->row()->id;

				// insert values to database
				$record_id = $this->common_model->save("claim", $data);

				// update case no(7 length) to table
				$this->common_model->update("claim", array("claim_no"=>str_pad($record_id, 7, 0, STR_PAD_LEFT)), array("id"=>$record_id));

				// send success message
				$this->session->set_flashdata('success', "Claim successfully created");

				// redirect them to the login page
				redirect('claim', 'refresh');
			}
			else
			{	
				
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name));	
				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "");
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name));

				// get all documents for sending email/print.
				$fields = "id, name, description";
				$conditions = "type = 'claim'";
				$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Create Claim', TRUE);
		        $this->template->write_view('content', 'claim/create_claim', $this->data);
		        $this->template->render();  
	        }      
		}
	}



	// redirect if needed, otherwise display the edit case page
	public function detail_claim($id = 0)
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

				// send success message
				$this->session->set_flashdata('success', "Case successfully updated");

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
				$joins[] = array(
					'table' => 'users u2',
					'on' => 'u2.id = case.case_manager',
					'type' => 'LEFT'
					);
				$case_details = $this->common_model->select($record = "first", $typecast = "array", $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by, concat_ws(' ', case.insured_firstname, case.insured_lastname) as insured_name,  concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name", $conditions = array('case.id'=>$id), $joins);
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
				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "");
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Assign To--");
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
				$this->data['intake_forms'] = $this->common_model->select($record = "list", $typecast = "array", $table = "intake_form", $fields = "intake_form.id, intake_form.notes, intake_form.docs, intake_form.created, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('intake_form.case_id'=>$id), $joins);

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


	function import_files(){
		set_time_limit(0);
		ini_set('max_execution_time', -1);
		$txt_file    = file_get_contents('icd10cm_codes_2017 (3).txt');
		$rows        = explode("\n", $txt_file);
		foreach($rows as $row => $data)
		{
		    //get row data
			$info = [];
		    $info['code']         = substr($data, 0,8);
		    $info['description']  = substr($data, 8,strlen($data));
		    $this->common_model->save("diagnosis", $info);
		}
	}

	// for autocomplete search
	public function search_diagnosis($field)
	{
		$query = $this->input->get("query");

		// get search query
		$table = "diagnosis"; 
		$group_by = array("users_groups.user_id");
		$fields = "diagnosis.$field as `value`, diagnosis.id as `data`"; 
		$conditions = "diagnosis.$field like '%$query%' ";
		$results = $this->common_model->select($record = "list", $typecast = "object", $table, $fields, $conditions);

		// return result in json format
		$results = array('suggestions'=>$results);
		echo json_encode($results);
	}


}
