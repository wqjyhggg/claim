<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exceptionals extends CI_Controller {
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
			$this->load->model('claim_model');
			$this->load->model('expenses_model');
			$this->load->model('product_model');
			$this->load->model('mytask_model');
			$this->load->model('case_model');
				
			// if sorting enabled
			$para = array();
			$para['status'] = $this->input->get('status');
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
			$para['status'] = $this->input->get('status');
			if ($this->input->get('start_dt')) {
				$para['start_dt'] = $this->input->get('start_dt');
			} else {
				$para['start_dt'] = date("Y-m-d", time() - (365 * 86400));
			}
			if ($this->input->get('end_dt')) {
				$para['end_dt'] = $this->input->get('end_dt');
			} else {
				$para['end_dt'] = date("Y-m-d", time() - (365 * 86400));
			}

			$this->data['agents'] = $this->claim_model->get_agents_list();
			$this->data['products'] = $this->product_model->get_list();
			$this->data['statuses'] = $this->claim_model->get_claim_status_list();
				
			$this->data['records'] = $this->expenses_model->get_report($para, "e.amt_exceptional");
			
			$this->data['export_url'] = site_url('report/exceptionals/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Claim List', TRUE);
			$this->template->write_view('content', 'report/exceptionals', $this->data);
			$this->template->render();
		}
	}

	public function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('claim_model');
			$this->load->model('expenses_model');
			$this->load->model('product_model');
			$this->load->model('mytask_model');
			$this->load->model('case_model');
				
			// if sorting enabled
			$para = array();
			$para['status'] = $this->input->get('status');
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
			$para['status'] = $this->input->get('status');
			if ($this->input->get('start_dt')) {
				$para['start_dt'] = $this->input->get('start_dt');
			} else {
				$para['start_dt'] = date("Y-m-d", time() - (365 * 86400));
			}
			if ($this->input->get('end_dt')) {
				$para['end_dt'] = $this->input->get('end_dt');
			} else {
				$para['end_dt'] = date("Y-m-d", time() - (365 * 86400));
			}

			$records = $this->expenses_model->get_report($para, "e.amt_exceptional");
			
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			$title = '';
			if (!empty($para['scope'])) $title .= $para['agent_id']." Only; ";
			if ($para['scope'] == 'Claim') {
				if (!empty($para['status'])) $title .= "Claim Status:".$para['status']."; ";
			}
			if (!empty($para['product_short'])) $title .= "Product:".$para['product_short']."; ";
			if (!empty($para['agent_id'])) $title .= "Policy Agent ID:".$para['agent_id']."; ";
			$title .= "Date Period : ".$para['start_dt']." - ".$para['end_dt']."; ";

			fputcsv($output, array($title));
			fputcsv($output, array(''));

			fputcsv($output, array(
									'Claim No.',
									'Invoice',
									'Provider Name',
									'Policy',
									'Client Last Name',
									'Client First Name',
									'Days',
									'Entered Date',
									'Date of Service',
									'Pay Date',
									'Invoice Status',
									'Billed Amount',
									'Paid Amount',
									'Cross Pending',
									'Recovery'
					));

			$t_amount_billed = $t_amt_payable = $t_recovery_amt = $t_reserve_amount = 0;
			foreach ($records as $key => $value) { 
				$t_amount_billed += $value['amount_billed']; $t_amt_payable += $value['amt_payable']; $t_recovery_amt += $value['recovery_amt']; $t_reserve_amount += $value['reserve_amount'];
				fputcsv($output, array(
									$value['claim_no'],
									$value['invoice'],
									$value['provider_name'],
									$value['policy_no'],
									$value['last_name'],
									$value['first_name'],
									$value['totaldays'],
									substr($value['created'], 0, 10),
									$value['date_of_service'],
									$value['pay_date'],
									$value['status'],
									sprintf("%0.2f", $value['amount_billed']),
									sprintf("%0.2f", $value['amt_payable']),
									sprintf("%0.2f", $value['reserve_amount']),
									sprintf("%0.2f", $value['recovery_amt'])
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
									'',
									'',
									'',
									'',
									sprintf("%0.2f", $t_amount_billed),
									sprintf("%0.2f", $t_amt_payable),
									sprintf("%0.2f", $t_reserve_amount),
									sprintf("%0.2f", $t_recovery_amt)
					));
		}
	}
}
