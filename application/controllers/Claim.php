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
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = claim.assign_to',
					'type' => 'LEFT'
					);

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

				$fields = "concat_ws(' ', u1.first_name, u1.last_name) as claim_examiner, claim.id, claim.policy_no, claim.claim_no, claim.insured_first_name, claim.insured_last_name, claim.gender, claim.dob, claim.claim_date, claim.status";
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

			// get claim examiners
			$this->data['claim_examiner'] = $this->common_model->getrusers($field_name = "assign_user", "", $group = array("'claimexaminer'"), $empty = "--Select Claim Examiner--", $additional_conditions = "");

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
			$this->form_validation->set_rules('insured_first_name', 'Insured First Name', 'required');
			$this->form_validation->set_rules('personal_id', 'Personal ID', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('school_name', 'School Name', 'required');
			$this->form_validation->set_rules('group_id', 'Group ID', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				// prepare post data array
				$data = [];
				$array = $this->input->post();

				foreach ($array as $key => $value) 
				{
					# code...
					if($key <> "Examine" && $key <> "filter" && $key <> "same_policy"  && $key <> "Save" && $key <> "files_multi" && $key <> "payees" && $key <> "files" && $key <> "expenses_climed" && !strpos($key, "otes_") && !strpos($key, "iles_") && $key <> "no_of_form" && !strpos($key, "ile_pdf"))
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->user()->row()->id;

				// upload claim pdf files to server
				$files = @$_FILES['files_multi'];
				$file_names = [];

				// load upload class
				$config['upload_path'] = './assets/uploads/claim_files/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);

				// initialize upload config
				$this->upload->initialize($config);
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
							
							// upload file to server
							$this->upload->do_upload();
							$file_data = $this->upload->data();
							$file_names[] = $file_data['file_name'];
						}
					}
				}
				$data['files'] = implode(",", $file_names);

				// insert values to database
				$record_id = $this->common_model->save("claim", $data);

				// create directory to copy/shift files
				@mkdir('./assets/uploads/claim_files/'.$record_id, 0777);

				// move all files to that directory
				if(!empty($file_names))
					foreach ($file_names as $fname)
					{
						copy("./assets/uploads/claim_files/$fname", "./assets/uploads/claim_files/$record_id/$fname");
						unlink("./assets/uploads/claim_files/$fname");
					}

				// insert payee information
				if(!empty($array['payees']))
				{
					foreach($array['payees']['bank'] as $key => $val)	
					{
						$payee_data = array(
							'claim_id'=>$record_id,
							'bank'=>$val,
							'payee_name'=>$array['payees']['payee_name'][$key],
							'account_cheque'=>$array['payees']['account_cheque'][$key],
							'payment'=>$array['payees']['payment'][$key],
							'payee_currency'=>$array['payees']['payee_currency'][$key],
							'payee_currency_rate'=>$array['payees']['payee_currency_rate'][$key],
							'created'=>date('Y-m-d H:i:s')
							);
						$this->common_model->save("payees", $payee_data);
					}
				}

				// insert expenses_climed data
				if(!empty($array['expenses_climed']))
				{
					foreach($array['expenses_climed']['invoice'] as $key => $val)	
					{
						$payee_data = array(
							'claim_id'=>$record_id,
							'invoice'=>$val,
							'provider_name'=>$array['expenses_climed']['provider_name'][$key],
							'referencing_physician'=>$array['expenses_climed']['referencing_physician'][$key],
							'coverage_code'=>$array['expenses_climed']['coverage_code'][$key],
							'diagnosis'=>$array['expenses_climed']['diagnosis'][$key],
							'service_description'=>$array['expenses_climed']['service_description'][$key],
							'date_of_service'=>$array['expenses_climed']['date_of_service'][$key],
							'amount_billed'=>$array['expenses_climed']['amount_billed'][$key],
							'amount_client_paid'=>$array['expenses_climed']['amount_client_paid'][$key],
							'currency'=>$array['expenses_climed']['currency'][$key],
							'currency_rate'=>$array['expenses_climed']['currency_rate'][$key],
							'payee'=>$array['expenses_climed']['payee'][$key],
							'comment'=>$array['expenses_climed']['comment'][$key],
							'created'=>date('Y-m-d H:i:s')
							);
						$this->common_model->save("expenses_climed", $payee_data);
					}
				}

				// insert intake notes
				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];

				// load upload class
				$config['upload_path'] = './assets/uploads/intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);

				// initialize upload config
				$this->upload->initialize($config);
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
							'docs' => implode(",", $file_names),
							'type'=>'CLAIM'
							);

						// if file is getting from email/print function
						if(@$array['file_pdf_'.$i])
						{
							$data_intake['docs'] = $array['file_pdf_'.$i];
						}

						// save values to database
						$intake_form_id = $this->common_model->save("intake_form", $data_intake);

						// create directory to identify intake files
						@mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

						// if file is getting from email/print function
						if(@$array['file_pdf_'.$i])
						{
							$fname = $array['file_pdf_'.$i];
							copy("./assets/temp/$fname", "./assets/uploads/intake_forms/$intake_form_id/$fname");
							unlink("./assets/temp/$fname");
						}
						// move all files to that directory
						if(!empty($file_names))
							foreach ($file_names as $fname)
							{
								copy("./assets/uploads/intake_forms/$fname", "./assets/uploads/intake_forms/$intake_form_id/$fname");
								unlink("./assets/uploads/intake_forms/$fname");
							}
					}
				}

				// update case no(7 length) to table
				$this->common_model->update("claim", array("claim_no"=>str_pad($record_id, 7, 0, STR_PAD_LEFT)), array("id"=>$record_id));


				// send success message
				$this->session->set_flashdata('success', "Claim successfully created");

				if($this->input->post('Examine') == 'Examine')
					// redirect them to the examine claim page
					redirect("claim/examine_claim/$record_id", 'refresh');
				else
					// redirect them to the claim page
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
				$this->data['payees'] = $this->common_model->get_payees($field_name = "expenses_climed[payee][]", $selected = $this->input->post($field_name));

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
	public function examine_claim($id)
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
					if($key <> "Examine" && $key <> "filter" && $key <> "same_policy"  && $key <> "Save" && $key <> "files_multi" && $key <> "payees" && $key <> "files" && $key <> "expenses_climed" && !strpos($key, "otes_") && !strpos($key, "iles_") && $key <> "no_of_form" && !strpos($key, "ile_pdf"))
						$data[$key] = $value;
				}
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_by'] = $this->ion_auth->user()->row()->id;

				// upload claim pdf files to server
				$files = @$_FILES['files_multi'];
				$file_names = [];

				// load upload class
				$config['upload_path'] = './assets/uploads/claim_files/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);

				// initialize upload config
				$this->upload->initialize($config);
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
							
							// upload file to server
							$this->upload->do_upload();
							$file_data = $this->upload->data();
							$file_names[] = $file_data['file_name'];
						}
					}
				}

				// insert values to database
				$this->common_model->update("claim", $data, array('id'=>$id));
				$record_id = $id;

				// move all files to that directory
				if(!empty($file_names))
					foreach ($file_names as $fname)
					{
						copy("./assets/uploads/claim_files/$fname", "./assets/uploads/claim_files/$record_id/$fname");
						unlink("./assets/uploads/claim_files/$fname");
					}

				// insert payee information
				if(!empty($array['payees']))
				{	
					// remove old payees
					$this->common_model->delete('payees', array('claim_id' => $record_id));

					foreach($array['payees']['bank'] as $key => $val)	
					{
						$payee_data = array(
							'claim_id'=>$record_id,
							'bank'=>$val,
							'payee_name'=>$array['payees']['payee_name'][$key],
							'account_cheque'=>$array['payees']['account_cheque'][$key],
							'payment'=>$array['payees']['payment'][$key],
							'payee_currency'=>$array['payees']['payee_currency'][$key],
							'payee_currency_rate'=>$array['payees']['payee_currency_rate'][$key],
							'created'=>date('Y-m-d H:i:s')
							);
						$this->common_model->save("payees", $payee_data);
					}
				}

				// insert expenses_climed data
				// if(!empty($array['expenses_climed']))
				// {
				// 	foreach($array['expenses_climed']['invoice'] as $key => $val)	
				// 	{
				// 		$payee_data = array(
				// 			'claim_id'=>$record_id,
				// 			'invoice'=>$val,
				// 			'provider_name'=>$array['expenses_climed']['provider_name'][$key],
				// 			'referencing_physician'=>$array['expenses_climed']['referencing_physician'][$key],
				// 			'coverage_code'=>$array['expenses_climed']['coverage_code'][$key],
				// 			'diagnosis'=>$array['expenses_climed']['diagnosis'][$key],
				// 			'service_description'=>$array['expenses_climed']['service_description'][$key],
				// 			'date_of_service'=>$array['expenses_climed']['date_of_service'][$key],
				// 			'amount_billed'=>$array['expenses_climed']['amount_billed'][$key],
				// 			'amount_client_paid'=>$array['expenses_climed']['amount_client_paid'][$key],
				// 			'currency'=>$array['expenses_climed']['currency'][$key],
				// 			'currency_rate'=>$array['expenses_climed']['currency_rate'][$key],
				// 			'payee'=>$array['expenses_climed']['payee'][$key],
				// 			'comment'=>$array['expenses_climed']['comment'][$key],
				// 			'created'=>date('Y-m-d H:i:s')
				// 			);
				// 		$this->common_model->save("expenses_climed", $payee_data);
				// 	}
				// }

				// insert intake notes
				// insert intake forms if exists
				$no_of_form = $array['no_of_form'];

				// load upload class
				$config['upload_path'] = './assets/uploads/intake_forms/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = FALSE;
				$this->load->library('upload', $config);

				// initialize upload config
				$this->upload->initialize($config);
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
							'docs' => implode(",", $file_names),
							'type'=>'CLAIM'
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

				// update case no(7 length) to table
				$this->common_model->update("claim", array("claim_no"=>str_pad($record_id, 7, 0, STR_PAD_LEFT)), array("id"=>$record_id));

				// send success message
				$this->session->set_flashdata('success', "Claim successfully updated");

				// redirect them to the login page
				redirect('claim', 'refresh');
			}
			else
			{	

				// get claim details
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = claim.created_by',
					'type' => 'LEFT'
					);
				$this->data['claim_details'] = $this->common_model->select($record = "first", $typecast = "array", $table = "claim", $fields = "`claim`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('claim.id'=>$id), $joins);

				// get expenses climed items list
				$this->data['expenses'] = $this->common_model->select($record = "list", $typecast = "array", $table = "expenses_climed", $fields = "`expenses_climed`.*", $conditions = array('expenses_climed.claim_id'=>$id));

				// get claim history
				$fields = "expenses_climed.claim_no, expenses_climed.case_no,expenses_climed.claim_date,sum(expenses_climed.amount_claimed) as amount_claimed,sum(expenses_climed.amount_client_paid) as amount_client_paid,expenses_climed.currency,expenses_climed.pay_to";
				$this->data['claim_history'] = $this->common_model->select($record = "list", $typecast = "array", $table = "expenses_climed", $fields, $conditions = array('expenses_climed.claim_id'=>$id), $joins = array(), $order_by = array(), $group_by = array('expenses_climed.id'));
				
				// load dropdowns- countries, province, products data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name));	
				$this->data['province2'] = $this->common_model->getprovinces($field_name = "province_email", $selected = "");
				$this->data['products'] = $this->common_model->get_products($field_name = "product_short", $selected = $this->input->post($field_name));
				$this->data['payees'] = $this->common_model->get_payees($field_name = "expenses_climed[payee][]", $selected = $this->input->post($field_name));

				// get all documents for sending email/print.
				$fields = "id, name, description";
				$conditions = "type = 'claim'";
				$this->data['docs'] = $this->common_model->select($record = "list", $typecast = "array", $table = "template", $fields, $conditions);

				// get all payees infomation
				$fields = "*";
				$conditions = "claim_id = '$id'";
				$this->data['payees'] = $this->common_model->select($record = "list", $typecast = "array", $table = "payees", $fields, $conditions);

				// get intake forms
				$joins = [];
				$joins[] = array(
					'table' => 'users u1',
					'on' => 'u1.id = intake_form.created_by',
					'type' => 'LEFT'
					);
				$this->data['intake_forms'] = $this->common_model->select($record = "list", $typecast = "array", $table = "intake_form", $fields = "intake_form.id, intake_form.notes, intake_form.docs, intake_form.created, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('intake_form.case_id'=>$id, 'type'=>'CLAIM'), $joins);

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Examine Claim', TRUE);
		        $this->template->write_view('content', 'claim/examine_claim', $this->data);
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

	// download claim files
	public function download($file, $id) 
	{
		$this->load->helper("download");
		force_download('./assets/uploads/claim_files/' . $id . '/' . urldecode($file), NULL);
	}

	// browse claim files
	public function file($file, $id) 
	{

		// We'll be outputting a PDF
		header('Content-type: application/pdf');

		// The PDF source is in original.pdf
		readfile('./assets/uploads/claim_files/' . $id . '/' . urldecode($file));
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
		$results = $this->common_model->select($record = "list", $typecast = "object", $table, $fields, $conditions, $joins = array(), $order_by = array(), $group_by = array(), $having = "" , $limit = 8);

		// return result in json format
		$results = array('suggestions'=>$results);
		echo json_encode($results);
	}

	// for ajax request
	public function save_item(){

		// generate data array
		$data = $this->input->post();
		unset($data['id']);
		unset($data['Save']);

		// update values to database
		$this->common_model->update("expenses_climed", $data, array('id'=>$this->input->post('id')));
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
			'created_by' => $this->ion_auth->user()->row()->id,
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
		$this->email->attach("./assets/temp/$filename");
		$this->email->send();
		echo json_encode(array("data_intake"=>implode(", ", $intake_notes), 'file'=>"./assets/temp/$filename", 'file_name'=>$filename));
	}

	//send email template from examine claim page
	public function send_print_email_claim() 
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
			'docs' => $filename,
			'type'=>'CLAIM'
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

	// assign claim examinner manually for ajax request
	public function assign_claim($type = "automatic") 
	{
		$claim = $this->input->post("claim");	
		$claim = explode(",", $claim);		
		$employee_id = $this->input->post("employee_id");

		// asigning process
		foreach ($claim as $key => $value) 
		{
			$this->common_model->update("claim", array("assign_to"=>$employee_id), array("id"=>$value));
		}

		// send success message
		$this->session->set_flashdata('success', "Claim asssigned successfully");

		echo TRUE;

	}


}
