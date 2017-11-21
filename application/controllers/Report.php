<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Report extends CI_Controller {
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
		} else if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->template->write('title', SITE_TITLE . ' - Reports', TRUE);
			$this->template->write_view('content', 'report/lists', $this->data);
			$this->template->render();
		}
	}

	// redirect if needed, otherwise display the products list
	public function cases() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			// get my tasks here
			$this->load->model('mytask_model');
			$this->load->model('claim_model');
			$this->load->model('case_model');

			// if sorting enabled
			$para = array(
					'finished' => (int)$this->session->userdata('finished'),
					'field' => $this->input->get("field"),
					'order' => $this->input->get("order")
			);

			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['finished'] = (int)$this->session->userdata('finished');
			$this->data['finish_url'] = base_url('auth/setfinish');
			
			$this->data['records'] = $this->mytask_model->get_mytask($para, $limit, $offset);
			$config['total_rows'] = $this->mytask_model->last_rows();
			
			foreach ($this->data['records'] as $key => $rc) {
				if ($rc['type'] == 'CASE') {
					$case = $this->case_model->get_by_id($rc['item_id']);
					$this->data['records'][$key]['insured_name'] = $case['insured_firstname'] . " " . $case['insured_lastname'];
				} else {
					$claim = $this->claim_model->get_by_id($rc['item_id']);
					$this->data['records'][$key]['insured_name'] = $claim['insured_first_name'] . " " . $claim['insured_last_name'];
				}
				$ctuser = $this->users_model->get_by_id($rc['created_by']);
				$this->data['records'][$key]['created_email'] = $ctuser['email'];
				$user = $this->users_model->get_by_id($rc['user_id']);
				$this->data['records'][$key]['assign_name'] = $user['email'];
			}
			
			$config['base_url'] = site_url('auth/mytasks');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - My Tasks', TRUE);
			$this->template->write_view('content', 'auth/mytasks', $this->data);
			$this->template->render();
		}
	}
}
