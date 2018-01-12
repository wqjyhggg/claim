<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_summary extends CI_Controller {
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
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
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
				
			$this->data['records'] = $this->expenses_model->summary($para);
			
			$this->data['export_url'] = site_url('report/claim_summary/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Claim Summary', TRUE);
			$this->template->write_view('content', 'report/claim_summary', $this->data);
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
			$para['product_short'] = $this->input->get('product_short');
			$para['agent_id'] = $this->input->get('agent_id');
			$para['start_dt'] = $this->input->get('start_dt');
			$para['end_dt'] = $this->input->get('end_dt');

			$records = $this->expenses_model->summary($para);
			
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
					'Month',
					'Writen Premium',
					'Earned Premium',
					'Billed Amount',
					'Paid Amount',
					'Recovery Amount',
			));

			$t_writen = $t_earned = $t_billed = $t_paid = $t_recovery = 0;
			foreach ($records as $key => $value) { 
				$t_writen += $value['writen']; $t_earned += $value['earned']; $t_billed += $value['billed']; $t_paid += $value['paid']; $t_recovery += $value['recovery'];
				fputcsv($output, array(
					$key,
					sprintf("%0.2f", $value['writen']),
					sprintf("%0.2f", $value['earned']),
					sprintf("%0.2f", $value['billed']),
					sprintf("%0.2f", $value['paid']),
					sprintf("%0.2f", $value['recovery'])
				));
			}
			fputcsv($output, array(
				'Total',
				sprintf("%0.2f", $t_writen),
				sprintf("%0.2f", $t_earned),
				sprintf("%0.2f", $t_billed),
				sprintf("%0.2f", $t_paid),
				sprintf("%0.2f", $t_recovery)
			));
		}
	}
}
