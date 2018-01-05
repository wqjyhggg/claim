<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Cases extends CI_Controller {
	// set private properties here
	private $limit = 17; // no of records per page
	
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
		} else {
			$this->load->model('case_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('case_manager')) $para['case_manager'] = $this->input->get('case_manager');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			if ($this->input->get('priority')) $para['priority'] = $this->input->get('priority');
			if ($this->input->get('status')) $para['status'] = $this->input->get('status');

			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
			$this->data['priorities'] = $this->mytask_model->get_priorities();
			$this->data['statuses'] = $this->case_model->get_status_list();
			$this->data['export_url'] = site_url('report/cases_export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['records'] = $this->case_model->search($para, $limit, $offset);
			$config['total_rows'] = $this->case_model->last_rows();
			
			foreach ($this->data['records'] as $key => $case) {
				$ctuser = $this->users_model->get_by_id($case['created_by']);
				$this->data['records'][$key]['created_email'] = $ctuser['email'];
				$user = $this->users_model->get_by_id($case['case_manager']);
				$this->data['records'][$key]['manager_email'] = $user['email'];
			}
			
			$config['base_url'] = site_url('reports/cases');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - Case Reports', TRUE);
			$this->template->write_view('content', 'report/cases', $this->data);
			$this->template->render();
		}
	}
}
