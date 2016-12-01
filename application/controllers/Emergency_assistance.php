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
        	$this->template->write('title', SITE_TITLE.' - View Edit Emergency Assistance Case', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/index');
	        $this->template->render();        
		}
	}

	// redirect if needed, otherwise display the create case page
	public function create_case()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
        	$this->template->write('title', SITE_TITLE.' - Create Case', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/create_case');
	        $this->template->render();        
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

			// get cordinates
			$cordinates = $this->lat_lng_finder($address);

			$fields = "*";
			$having = "";

			// if address is not empty
			if($address)
			{
				$fields = "*, (
					    3959 * acos (
					      cos ( radians(".$cordinates['lat'].") )
					      * cos( radians( lat ) )
					      * cos( radians( lng ) - radians(".$cordinates['lng'].") )
					      + sin ( radians(".$cordinates['lat'].") )
					      * sin( radians( lat ) )
					    )
					  ) AS distance";
			  	$having = "distance < ".NEAREST_PROVIDERS_RANGE;
		  	}

			// get all providers list
			$records = $this->common_model->select($record = "list", $typecast = "array", $table = "provider", $fields, $conditions = "", $joins = array(), $order_by = array(), $group_by = array(), $having);
			$this->data['records'] = $records;

			// get countries list
			$this->data['countries'] = $this->getcountries($field_name = "country", $selected = $this->input->get("country"));

			// get province list
			$this->data['provinces'] = $this->getprovinces($field_name = "province", $selected = $this->input->get("province"));

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
        	$this->template->write('title', SITE_TITLE.' - Create IntakeForm', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/create_intakeform');
	        $this->template->render();        
		}
	}

	// get all countries list
	public function getcountries($field_name, $selected)
	{
		$record = $this->common_model->get_ref($table = "country", $key= "name", $value = "name", $dropdown=true, $empty = "Please Select");
		return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
	}

	// get all province list
	public function getprovinces($field_name, $selected)
	{
		$record = $this->common_model->get_ref($table = "province", $key= "name", $value = "name", $dropdown=true, $empty = "Please Select");		
		return form_dropdown($field_name, $record, $selected, array("class"=>'form-control'));
	}

}
