<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phonestatus extends CI_Controller {
	// set private properties here
	private $phone_numbers = array('101','102','103','104','105','106','107','108','109');
	
	public function __construct() {
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the products list
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
			/*
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
			*/
		} else {
			$this->load->model('phone_model');
			$data = array('status' => array());
			foreach ($this->phone_numbers as $nm) {
				$data['status'][$nm] = $this->phone_model->get_current_status($nm);
			}
			
			$data['Chinese'] = $this->phone_model->get_queue_count('Chinese');
			$data['English'] = $this->phone_model->get_queue_count('English');
			$this->load->view('report/phonestatus', $data);
		}
	}
	
	public function status() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
			/*
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
			*/
		} else {
			$this->load->model('phone_model');
			$data = array('status' => array());
			foreach ($this->phone_numbers as $nm) {
				$data['status'][$nm] = $this->phone_model->get_current_status($nm);
			}
			
			$data['Chinese'] = $this->phone_model->get_queue_count('Chinese');
			$data['English'] = $this->phone_model->get_queue_count('English');
			$this->load->view('report/phonestatus_table', $data);
		}
	}
}
