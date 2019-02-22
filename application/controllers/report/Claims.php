<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claims extends CI_Controller {
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
			$para['scope'] = $this->input->get('scope');
			$para['status'] = $this->input->get('status');
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
			$para['claim_date_type'] = $this->input->get('claim_date_type');
			if ($para['scope'] == 'Claim') {
				$para['status'] = $this->input->get('status');
			}
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
			if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
				$this->data['products'] = $this->product_model->get_list();
			} else {
				$products = $this->ion_auth->get_users_products();
				$this->data['products'] = array();
				foreach ($products as $pn) $this->data['products'][$pn] = $pn;
			}

			$this->data['statuses'] = $this->claim_model->get_claim_status_list();
				
			$cases = array();
			$claims = array();
			$this->data['records'] = array();
			if ($para['scope'] != 'Case') {
				$this->data['records'] = $this->expenses_model->get_report($para, '', FALSE);
			}
			if ($para['scope'] != 'Claim') {
				$cases = $this->case_model->get_report($para, FALSE);
				if ($cases) {
					$this->data['records'] = array_merge($this->data['records'], $cases);
				}
			}
			$this->data['export_url'] = site_url('report/claims/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Claim List', TRUE);
			$this->template->write_view('content', 'report/claims', $this->data);
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
			$para['scope'] = $this->input->get('scope');
			$para['status'] = $this->input->get('status');
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
			$para['claim_date_type'] = $this->input->get('claim_date_type');
			if ($para['scope'] == 'Claim') {
				$para['status'] = $this->input->get('status');
			}
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

			$cases = array();
			$claims = array();
			$records = array();
			if ($para['scope'] != 'Case') {
				$records = $this->expenses_model->get_report($para, '', FALSE);
			}
			if ($para['scope'] != 'Claim') {
				$cases = $this->case_model->get_report($para, FALSE);
				if ($cases) {
					$records = array_merge($records, $cases);
				}
			}
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Case_CLaim_Report.csv');
				
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
									'Birth Day',
									'Gender',
									'Days',
									'Address',
									'City',
									'Province',
									'Postal Code',
									'AgentID',
									'Diagnosis',
									'Coverage Code',
									'Deductible',
									'Entered Date',
									'Date of Service',
									'Pay Date',
									'Invoice Status',
									'Gross Pending',
									'Reserve Amount',
									'Claimed Amount',
									'Paid Amount',
									'Recovery',
									'Description of Service',
									'Pay to Name',
									'Decline Reason',
									'Claim Status',
			));

			$t_amount_claimed = $t_amt_payable = $t_recovery_amt = $t_reserve_amount = 0;
			foreach ($records as $key => $value) { 
				$t_amount_claimed += $value['amount_claimed']; $t_amt_payable += $value['amt_payable']; $t_recovery_amt += $value['recovery_amt']; $t_reserve_amount += $value['reserve_amount'];
				fputcsv($output, array(
									$value['claim_no'],
									$value['invoice'],
									$value['provider_name'],
									$value['policy_no'],
									$value['last_name'],
									$value['first_name'],
									$value['birth_day'],
									$value['gender'],
									$value['totaldays'],
									$value['street_address'],
									$value['city'],
									$value['province'],
									$value['post_code'],
									$value['agent_id'],
									$value['diagnosis'],
									isset($value['coverage_code']) ? $value['coverage_code'] : '',
									isset($value['amt_deductible']) ? $value['amt_deductible'] : 0,
									substr($value['created'], 0, 10),
									$value['date_of_service'],
									isset($value['finalize_date']) ? $value['finalize_date'] : '',
									$value['status'],
									sprintf("%0.2f", (isset($value['reserve_amount']) ? $value['reserve_amount'] : 0)),
									sprintf("%0.2f", (isset($value['reserve_amount']) ? $value['reserve_amount'] : 0)),
									sprintf("%0.2f", (isset($value['amount_claimed']) ? $value['amount_claimed'] : 0)),
									sprintf("%0.2f", $value['amt_payable']),
									sprintf("%0.2f", $value['recovery_amt']),
									isset($value['service_description']) ? $value['service_description'] : '',
									isset($value['pay_to']) ? $value['pay_to'] : '',
									empty($value['reason']) ? '' : $value['reason'],
									$value['status2'],
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
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									sprintf("%0.2f", $t_reserve_amount),
									'',
									sprintf("%0.2f", $t_amount_claimed),
									sprintf("%0.2f", $t_amt_payable),
									sprintf("%0.2f", $t_recovery_amt)
					));
		}
	}
}
