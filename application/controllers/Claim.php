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
	        $this->template->write_view('content', 'claim/index', $this->data);
	        $this->template->render();        
		}
	}


	// redirect if needed, otherwise display the create claim page
	public function create_claim($id = 0)
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
	        	$this->template->write('title', SITE_TITLE.' - Create Claim', TRUE);
		        $this->template->write_view('content', 'claim/create_claim', $this->data);
		        $this->template->render();  
	        }      
		}
	}

}
