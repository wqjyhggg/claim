<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Emergency_assistance extends CI_Controller {

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
		else
		{
			// initialize variables
			$this->data['cases'] = []; 
			$this->data['policies'] = [];

			// search case filter
			if($this->input->get("filter") == 'case') {
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
					$conditions['case.insured_name like'] = "%".$this->input->get("client_user_name")."%";
				if($this->input->get("created")) 
					$conditions['case.created like'] = "%".$this->input->get("created")."%";
				if($this->input->get("assign_to")) 
					$conditions['case.assign_to'] = $this->input->get("assign_to");
				if($this->input->get("case_manager")) 
					$conditions['case.case_manager'] = $this->input->get("case_manager");

				$fields = "concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, case.case_no, DATE_FORMAT(case.created, '%Y-%m-%d') as created, case.province, case.reason, case.policy_no, case.insured_name, IF(case.dob='0000-00-00', 'N/A', DATE_FORMAT(case.dob, '%Y-%m-%d')) as dob, case.assign_to, case.case_manager, case.priority, case.id";
				$this->data['cases'] = $this->common_model->select($record = "list", $typecast = "array", $table = "case", $fields, $conditions, $joins, $order_by, $group_by = array());
			}

			// send case manager and eac managers list
			$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = $this->input->get($field_name), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Assign To--");
			$this->data['casemamager'] = $this->common_model->getrusers($field_name = "case_manager", $selected = $this->input->get($field_name), $group = "casemamager", $empty = "--Select Case Manager--");

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
			$this->form_validation->set_rules('assign_to', 'Assign To', 'required');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if ($this->form_validation->run() == true)
			{
				// echo "<pre>";
				// print_r($_FILES);
				// print_r($_POST); die;
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
				$this->common_model->update("case", array("case_no"=>str_pad($record_id, 7, 0, STR_PAD_LEFT)), array("id"=>$record_id));

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
						mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

						// move all files to that directory
						if(!empty($file_names))
							foreach ($file_names as $fname)
							{
								copy("./assets/uploads/intake_forms/$fname", "./assets/uploads/intake_forms/$intake_form_id/$fname");
								unlink("./assets/uploads/intake_forms/$fname");
							}
					}
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
				$case_details = $this->common_model->select($record = "first", $typecast = "array", $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('case.id'=>$id), $joins);
				$this->data['case_details'] = $case_details;
				
				// load dropdowns data
				$this->data['country'] = $this->common_model->getcountries($field_name = "country", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['country2'] = $this->common_model->getcountries($field_name = "country2", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['province'] = $this->common_model->getprovinces($field_name = "province", $selected = $this->common_model->field_val($field_name, $case_details));
				$this->data['eacmanagers'] = $this->common_model->getrusers($field_name = "assign_to", $selected = ($this->common_model->field_val($field_name, $case_details)), $group = array("'eacmanager'", "'casemamager'"), $empty = "--Assign To--");
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
		else
		{
			//validate form input
			$this->form_validation->set_rules('assign_to', 'Assign To', 'required');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('case_manager', 'Case Manager', 'required');
			$this->form_validation->set_rules('priority', 'Priority', 'required');

			if ($this->form_validation->run() == true)
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
				$case_details = $this->common_model->select($record = "first", $typecast = "array", $table = "case", $fields = "`case`.*, concat_ws(' ', u1.first_name, u1.last_name) as created_by", $conditions = array('case.id'=>$id), $joins);
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

				// load view data
	        	$this->template->write('title', SITE_TITLE.' - Edit Case', TRUE);
		        $this->template->write_view('content', 'emergency_assistance/edit_case', $this->data);
		        $this->template->render();  
	        }      
		}
	}

	// redirect if needed, otherwise display the create policy page
	public function create_policy()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
        	$this->template->write('title', SITE_TITLE.' - Create Case', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/create_policy');
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

			if ($this->form_validation->run() == true)
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

			// get all providers list
			$records = $this->common_model->select($record = "list", $typecast = "array", $table = "provider", $fields, $conditions = "", $joins = array(), $order_by = array(), $group_by = array(), $having);
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

			if ($this->form_validation->run() == true)
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
				$files = $_FILES['files'];
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
				mkdir('./assets/uploads/intake_forms/'.$intake_form_id, 0777);

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
	public function download($file, $id) {
		$this->load->helper("download");
		force_download('./assets/uploads/intake_forms/' . $id . '/' . $file, NULL);
	}

	// delete intake form here for ajax request
	public function deleteform($form_id) {

		// load files library to delete file
		$this->load->helper('file');

		// delete all files of itake form
		delete_files("./assets/uploads/intake_forms/$form_id/", FALSE);
		rmdir("./assets/uploads/intake_forms/$form_id");

		// delete intake form
		$this->common_model->delete('intake_form', array('id' => $form_id));

		echo TRUE;

	}
}
