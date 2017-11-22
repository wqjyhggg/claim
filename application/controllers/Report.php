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

	public function cases_export() {
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

			$statuses = $this->case_model->get_status_list();
			$records = $this->case_model->search($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=cases.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
					'Case No.',
					'Claim No.',
					'Priority',
					'Status',
					'Created By',
					'Created DateTime',
					'Product',
					'Policy',
					'Manager',
					'Last Update'
			));

			foreach ($records as $key => $value) { 
				$ctuser = $this->users_model->get_by_id($value['created_by']);
				$user = $this->users_model->get_by_id($value['case_manager']);
				fputcsv($output, array(
					$value['case_no'],
					$value['claim_no'],
					$value['priority'],
					$statuses[$value['status']],
					$ctuser['email'],
					$value['created'],
					$value['product_short'],
					$value['policy_no'],
					$user['email'],
					$value['last_update']
				));
			}
		}
	}

	// redirect if needed, otherwise display the products list
	public function claims() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('assign_to')) $para['assign_to'] = $this->input->get('assign_to');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			if ($this->input->get('priority')) $para['priority'] = $this->input->get('priority');
			if ($this->input->get('status')) $para['status'] = $this->input->get('status');

			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_CLAIMER, 'active' => 1));
			$this->data['priorities'] = $this->mytask_model->get_priorities();
			$this->data['statuses'] = $this->claim_model->get_claim_status_list();
			$this->data['export_url'] = site_url('report/claims_export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['records'] = $this->claim_model->search($para, $limit, $offset);
			$config['total_rows'] = $this->claim_model->last_rows();
			
			foreach ($this->data['records'] as $key => $claim) {
				$ctuser = $this->users_model->get_by_id($claim['created_by']);
				$this->data['records'][$key]['created_email'] = $ctuser['email'];
				$user = $this->users_model->get_by_id($claim['assign_to']);
				$this->data['records'][$key]['manager_email'] = $user['email'];
			}
			
			$config['base_url'] = site_url('reports/claims');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - claim Reports', TRUE);
			$this->template->write_view('content', 'report/claims', $this->data);
			$this->template->render();
		}
	}

	public function claims_export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('assign_to')) $para['assign_to'] = $this->input->get('assign_to');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			if ($this->input->get('priority')) $para['priority'] = $this->input->get('priority');
			if ($this->input->get('status')) $para['status'] = $this->input->get('status');

			$statuses = $this->claim_model->get_claim_status_list();
			$records = $this->claim_model->search($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=claims.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
					'Case No.',
					'Claim No.',
					'Status',
					'Created By',
					'Created DateTime',
					'Product',
					'Policy',
					'Manager',
					'Last Update'
			));

			foreach ($records as $key => $value) { 
				$ctuser = $this->users_model->get_by_id($value['created_by']);
				$user = $this->users_model->get_by_id($value['assign_to']);
				fputcsv($output, array(
					$value['case_no'],
					$value['claim_no'],
					$statuses[$value['status']],
					$ctuser['email'],
					$value['created'],
					$value['product_short'],
					$value['policy_no'],
					$user['email'],
					$value['last_update']
				));
			}
		}
	}


	// redirect if needed, otherwise display the products list
	public function receivables() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('expenses_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('created_from')) $para['created >='] = $this->input->get('created_from');
			if ($this->input->get('created_to')) $para['created <='] = $this->input->get('created_to');
			if ($this->input->get('last_update_from')) $para['last_update >='] = $this->input->get('last_update_from');
			if ($this->input->get('last_update_to')) $para['last_update <='] = $this->input->get('last_update_to');
			if ($this->input->get('status')) $para['status'] = $this->input->get('status');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
				
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_CLAIMER, 'active' => 1));
			$this->data['priorities'] = $this->mytask_model->get_priorities();
			$this->data['statuses'] = $this->expenses_model->get_status();
			$this->data['export_url'] = site_url('report/receivables_export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['records'] = $this->expenses_model->report($para, $limit, $offset);
			$config['total_rows'] = $this->expenses_model->last_rows();
			
			foreach ($this->data['records'] as $key => $claim) {
				$ctuser = $this->users_model->get_by_id($claim['created_by']);
				$this->data['records'][$key]['created_email'] = $ctuser['email'];
			}
			
			$config['base_url'] = site_url('reports/receivables');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - claim Reports', TRUE);
			$this->template->write_view('content', 'report/receivables', $this->data);
			$this->template->render();
		}
	}

	public function receivables_export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('expenses_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('created_from')) $para['created >='] = $this->input->get('created_from');
			if ($this->input->get('created_to')) $para['created <='] = $this->input->get('created_to');
			if ($this->input->get('last_update_from')) $para['last_update >='] = $this->input->get('last_update_from');
			if ($this->input->get('last_update_to')) $para['last_update <='] = $this->input->get('last_update_to');
			if ($this->input->get('status')) $para['status'] = $this->input->get('status');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			
			$statuses = $this->expenses_model->get_status();
			$records = $this->expenses_model->report($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=receivable.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
					'Claim No.',
					'Itim No.',
					'Status',
					'Updated',
					'Created',
					'Created By',
					'Coverage Code',
					'Payable',
					'Received',
					'Receivable'
			));

			$t_received = 0;
			$t_paid = 0;
			foreach ($records as $key => $value) { 
				$t_received += $value['amt_received'];
				$t_paid += $value['amt_payable'];
				$ctuser = $this->users_model->get_by_id($value['created_by']);
				fputcsv($output, array(
					$value['claim_no'],
					$value['claim_item_no'],
					$statuses[$value['status']],
					$value['last_update'],
					substr($value['created'], 0, 10),
					$ctuser['email'],
					$value['coverage_code'],
					$value['amt_payable'],
					$value['amt_received'],
					$value['amt_payable'] - $value['amt_received']
				));
			}
			fputcsv($output, array(
				'Total',
				'',
				'',
				'',
				'',
				'',
				'',
				$t_paid,
				$t_received,
				$t_paid - $t_received
			));
		}
	}

	// redirect if needed, otherwise display the products list
	public function payables() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('expenses_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('created_from')) $para['created >='] = $this->input->get('created_from');
			if ($this->input->get('created_to')) $para['created <='] = $this->input->get('created_to');
			if ($this->input->get('last_update_from')) $para['last_update >='] = $this->input->get('last_update_from');
			if ($this->input->get('last_update_to')) $para['last_update <='] = $this->input->get('last_update_to');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			$para['status'] = Expenses_model::EXPENSE_STATUS_Approved;
				
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1));
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_CLAIMER, 'active' => 1));
			$this->data['priorities'] = $this->mytask_model->get_priorities();
			$this->data['statuses'] = $this->expenses_model->get_status();
			$this->data['export_url'] = site_url('report/payables_export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['records'] = $this->expenses_model->report($para, $limit, $offset);
			$config['total_rows'] = $this->expenses_model->last_rows();
			
			foreach ($this->data['records'] as $key => $claim) {
				$ctuser = $this->users_model->get_by_id($claim['created_by']);
				$this->data['records'][$key]['created_email'] = $ctuser['email'];
			}
			
			$config['base_url'] = site_url('reports/payables');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - claim Reports', TRUE);
			$this->template->write_view('content', 'report/payable', $this->data);
			$this->template->render();
		}
	}

	public function payables_export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('expenses_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('created_from')) $para['created >='] = $this->input->get('created_from');
			if ($this->input->get('created_to')) $para['created <='] = $this->input->get('created_to');
			if ($this->input->get('last_update_from')) $para['last_update >='] = $this->input->get('last_update_from');
			if ($this->input->get('last_update_to')) $para['last_update <='] = $this->input->get('last_update_to');
			if ($this->input->get('created_by')) $para['created_by'] = $this->input->get('created_by');
			$para['status'] = Expenses_model::EXPENSE_STATUS_Approved;
			
			$statuses = $this->expenses_model->get_status();
			$records = $this->expenses_model->report($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=payable.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
					'Claim No.',
					'Itim No.',
					'Status',
					'Updated',
					'Created',
					'Created By',
					'Coverage Code',
					'Payable',
			));

			$t_received = 0;
			$t_paid = 0;
			foreach ($records as $key => $value) { 
				$t_paid += $value['amt_payable'];
				$ctuser = $this->users_model->get_by_id($value['created_by']);
				fputcsv($output, array(
					$value['claim_no'],
					$value['claim_item_no'],
					$statuses[$value['status']],
					$value['last_update'],
					substr($value['created'], 0, 10),
					$ctuser['email'],
					$value['coverage_code'],
					$value['amt_payable'],
				));
			}
			fputcsv($output, array(
				'Total',
				'',
				'',
				'',
				'',
				'',
				'',
				$t_paid
			));
		}
	}

	// redirect if needed, otherwise display the products list
	public function agents() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('phone_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('newcall_from')) $para['newcall >='] = $this->input->get('created_from');
			if ($this->input->get('newcall_to')) $para['newcall <='] = $this->input->get('created_to');
			if ($this->input->get('agent')) {
				if ($agent = $this->users_model->get_by_id($this->input->get('agent'))) {
					$para['agent'] = $agent['first_name'];
				}
			}
				
			$this->data['managers'] = $this->users_model->search(array('groups' => Users_model::GROUP_MANAGER, 'active' => 1));
			$this->data['eacs'] = $this->users_model->search(array('groups' => Users_model::GROUP_EAC, 'active' => 1));
			$this->data['export_url'] = site_url('report/agents_export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			
			$this->data['records'] = $this->phone_model->search($para, $limit, $offset);
			$config['total_rows'] = $this->phone_model->last_rows();

			foreach ($this->data['records'] as $key => $value) {
				$ctuser = $this->users_model->get_by_fname($value['agent']);
				$this->data['records'][$key]['email'] = $ctuser['email'];
			}

			$config['base_url'] = site_url('reports/payables');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - claim Reports', TRUE);
			$this->template->write_view('content', 'report/agent', $this->data);
			$this->template->render();
		}
	}

	public function agents_export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('phone_model');
			$this->load->model('mytask_model');
				
			// if sorting enabled
			$para = array();
			if ($this->input->get('newcall_from')) $para['newcall >='] = $this->input->get('created_from');
			if ($this->input->get('newcall_to')) $para['newcall <='] = $this->input->get('created_to');
			if ($this->input->get('agent')) {
				if ($agent = $this->users_model->get_by_id($this->input->get('agent'))) {
					$para['agent'] = $agent['first_name'];
				}
			}
			
			$records = $this->phone_model->search($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=claims.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
					'Agent',
					'Email',
					'New Call',
					'Answer',
					'Hangup',
					'Direction',
					'Caller',
			));

			$t_received = 0;
			$t_paid = 0;
			foreach ($records as $key => $value) { 
				$ctuser = $this->users_model->get_by_fname($value['agent']);
				fputcsv($output, array(
					$value['agent'],
					$ctuser['email'],
					$value['newcall'],
					$value['answer'],
					$value['hangup'],
					$value['direction'],
					$value['caller_id_number'],
				));
			}
		}
	}
}
