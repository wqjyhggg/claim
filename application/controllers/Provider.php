<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Jack
 */
class Provider extends CI_Controller {
	private $limit = 15;
	private $notes_dealy = 900;	// seconds
	
	public function __construct() {
		parent::__construct();
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the emergency assistance page
	public function index() {
		return $this->records();
	}
	
	// redirect if needed, otherwise display the emergency assistance page
	public function records() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('provider_model');
			
			$get = $this->input->get();
			$offset = $this->uri->segment(3);

			$this->data['providers'] = $this->provider_model->search($this->input->get(), $this->limit, $offset);
			
			$config['total_rows'] = $this->provider_model->last_rows();
			$config['base_url'] = base_url('provider/records');
			$config['per_page'] = $this->limit;
			$config['first_url'] = $config['base_url'] . '?' . http_build_query($this->input->get());
			if (count($get) > 0) $config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write_view('content', 'provider/records', $this->data);
			$this->template->render();
		}
	}
	
	// custom name validation
	function alpha_dash_space($fullname) {
		if (!preg_match('/^[0-9a-zA-Z\s]+$/', $fullname)) {
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
	
	public function add() {
		return $this->form(0);
	}
	
	public function edit($id = 0) {
		return $this->form($id);
	}
	
	// redirect if needed, otherwise display the create case page
	public function form($id = 0) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('provider_model');
				
			// validate form input
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('payeename', 'Payeename', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('province', 'Province', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('postcode', 'postcode', 'required|callback_alpha_dash_space');
			$this->form_validation->set_rules('discount', 'Discount', 'callback_positive_number');
			$this->form_validation->set_rules('network_fee', 'Network Fee', 'callback_positive_number');
			$this->form_validation->set_rules('contact_person', 'Contact Person', '');
			$this->form_validation->set_rules('phone_no', 'Phone Number', '');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			$this->form_validation->set_rules('ppo_codes', 'PPO Codes', '');
			$this->form_validation->set_rules('services', 'Services', '');
			$this->form_validation->set_rules('lat', 'Latitude', '');
			$this->form_validation->set_rules('lng', 'Longtitude', '');
			$this->form_validation->set_rules('priority', 'Priority', 'callback_positive_number');

			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$data = $this->input->post();
				
				// insert values to database
				$record_id = $this->provider_model->save($data);

				// send success message
				$this->session->set_flashdata('success', "Case successfully created");
				
				// redirect them to the login page
				redirect('provider/records/', 'refresh');
			}
			if (!empty($this->input->get('id'))) {
				$id = (int)$this->input->get('id');
			} else if (!empty($this->input->post('id'))) {
				$id = (int)$this->input->post('id');
			}
					
			if ($id) {
				$provider = $this->provider_model->get_by_id($id);
			}

			if (empty($provider)) {
				$provider['id'] = 0;
				$provider['name'] = '';
				$provider['payeename'] = '';
				$provider['status'] = Provider_model::ACTIVE;
				$provider['address'] = '';
				$provider['city'] = '';
				$provider['province'] = '';
				$provider['country'] = '';
				$provider['postcode'] = '';
				$provider['discount'] = 0;
				$provider['network_fee'] = 0;
				$provider['contact_person'] = '';
				$provider['phone_no'] = '';
				$provider['email'] = '';
				$provider['ppo_codes'] = '';
				$provider['services'] = '';
				$provider['lat'] = 43.8441723;		// JF
				$provider['lng'] = -79.3857005;
				$provider['priority'] = 0;
			}
			
			if ($this->input->post()) {
				$provider['id'] = $this->input->post('id');
				$provider['name'] = $this->input->post('name');
				$provider['payeename'] = $this->input->post('payeename');
				$provider['status'] = $this->input->post('status');
				$provider['address'] = $this->input->post('address');
				$provider['city'] = $this->input->post('city');
				$provider['province'] = $this->input->post('province');
				$provider['country'] = $this->input->post('country');
				$provider['postcode'] = $this->input->post('postcode');
				$provider['discount'] = $this->input->post('discount');
				$provider['network_fee'] = $this->input->post('network_fee');
				$provider['contact_person'] = $this->input->post('contact_person');
				$provider['phone_no'] = $this->input->post('phone_no');
				$provider['email'] = $this->input->post('email');
				$provider['ppo_codes'] = $this->input->post('ppo_codes');
				$provider['services'] = $this->input->post('services');
				$provider['lat'] = $this->input->post('lat');
				$provider['lng'] = $this->input->post('lng');
				$provider['priority'] = $this->input->post('priority');
			}
			
			$this->data['provider'] = $provider;

			// load view data
			$this->template->write_view('content', 'provider/form', $this->data);
			$this->template->render();
		}
	}
}
