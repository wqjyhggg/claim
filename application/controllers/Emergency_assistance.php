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
        	$this->template->write('title', SITE_TITLE.' - Create Provider', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/create_provider');
	        $this->template->render();        
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
        	$this->template->write('title', SITE_TITLE.' - Search Provider', TRUE);
	        $this->template->write_view('content', 'emergency_assistance/search_provider');
	        $this->template->render();        
		}
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
}
