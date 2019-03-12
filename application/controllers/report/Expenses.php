<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller {
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
				
			// if sorting enabled
			$para = array();
			$para['status_group'] = $this->input->get('status_group');
			$para['product_short'] = $this->input->get('product_short');
			/*
			 * Paid => Paid, Declined
			 * Unpaid => Received, Approved, Pending
			 * Duplicated not included
			 */
			//$para['agent_id'] = $this->input->get('agent_id');
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
				
			$this->data['records'] = $this->expenses_model->expense_report($para);
			
			$this->data['export_url'] = site_url('report/expenses/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Claim Summary Report', TRUE);
			$this->template->write_view('content', 'report/expenses', $this->data);
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
				
			// if sorting enabled
			$para = array();
			$para['status_group'] = $this->input->get('status_group');
			$para['product_short'] = $this->input->get('product_short');
			$para['start_dt'] = $this->input->get('start_dt');
			$para['end_dt'] = $this->input->get('end_dt');

			$records = $this->expenses_model->expense_report($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Claim_summary.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			$title = '';
			if (!empty($para['product_short'])) $title .= "Product:".$para['product_short']."; ";
			if (!empty($para['agent_id'])) $title .= "Policy Agent ID:".$para['agent_id']."; ";
			$title .= "Date Period : ".$para['start_dt']." - ".$para['end_dt']."; ";

			fputcsv($output, array($title));
			fputcsv($output, array(''));

			fputcsv($output, array(
							'Claim Item Number',
							'Claim Number',
							'Claim Type',
							'Status',
							'Policy Number',
							'Product',
							'Policy Date',
							'Agent ID ',
							'Coverage Code',
							'Entered Date',
							'Incident Date',
							'Incident Country ',
							'Payment Date/ Void Date',
							'Payee Name',
							'Payee Address',
							'Payee Country',
							'Payee Province',
							'Payee Type',
							'Provider Name',
							'Provider Address ',
							'Provider Country',
							'Provider Province',
							'Payment Method',
							'Cheque Number',
							'Total Claim Amount',
							'Discount Amount',
							'Denied Amount',
							'Deductible Amount',
							'Net Claim Paid amount',
							'Payment Currency',
							'Invoice Currency ',
							'Network Fees',
							'Network Provider',
							'Recovery Amount',
							'Void amount',
							'Void Reason ',
							'Deny Reason',
					));

			foreach ($records as $key => $value) { 
				fputcsv($output, array(
						$value['claim_item_no'],
						$value['claim_no'],
						$value['claim']['exinfo_type'],
						$value['status'],
						$value['claim']['policy_no'],
						$value['claim']['product_short'],
						$value['claim']['apply_date'],
						$value['claim']['agent_id'],
						$value['coverage_code'],
						$value['created'],
						$value['claim']['date_symptoms'],
						'N/A', /* echo $value['claim']['country_symptoms']; /*Incident Country XXXXXXXXXXXXXXXXXXXXX no input place */
						$value['pay_date'],
						($value['payeearr'] ? $value['payeearr']['payee_name'] : ''),
						($value['payeearr'] ? $value['payeearr']['address'] : ''),
						($value['payeearr'] ? $value['payeearr']['country'] : ''),
						($value['payeearr'] ? $value['payeearr']['province'] : ''),
						($value['third_party_payee'] ? 'Business' : 'Private'),

						isset($value['provider']['name']) ? $value['provider']['name'] : '',
						isset($value['provider']['address']) ? $value['provider']['address'] : '',
						isset($value['provider']['country']) ? $value['provider']['country'] : '',
						isset($value['provider']['province']) ? $value['provider']['province'] : '',
						($value['payeearr'] ? $value['payeearr']['payment_type'] : ''),
						$value['cheque'],

						sprintf("%0.2f", $value['amount_claimed']),
						sprintf("%0.2f", 0),
						sprintf("%0.2f", $value['amount_claimed'] - $value['amt_payable']),
						sprintf("%0.2f", $value['amt_deductible']),
						sprintf("%0.2f", $value['amt_payable']),
						'CAD',
						$value['currency'],
						sprintf("%0.2f", ($value['provider_type'] ? $value['provider']['network_fee'] : 0)),
						isset($value['provider']['name']) ? $value['provider']['name'] : '',
						sprintf("%0.2f", $value['recovery_amt']),
						($value['status'] != Expenses_model::EXPENSE_STATUS_Duplicated) ? "0.00" : sprintf("%0.2f", $value['amount_claimed']),
						$value['reason'],
						$value['reason_other'],
				));
			}
			fputcsv($output, array(''));
		}
	}
}
