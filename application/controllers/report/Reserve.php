<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reserve extends CI_Controller {
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
				
			// if sorting enabled
			$this->data['created_from'] = $this->input->get('created_from');
			$this->data['created_to'] = $this->input->get('created_to');
			$this->data['last_update_from'] = $this->input->get('last_update_from');
			$this->data['last_update_to'] = $this->input->get('last_update_to');

			$this->data['records'] = $this->case_model->get_reserve_report($this->data);

			$this->data['export_url'] = site_url('report/reserve/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Claim List', TRUE);
			$this->template->write_view('content', 'report/reserve', $this->data);
			$this->template->render();
		}
	}

	public function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('case_model');
				
			$this->data['created_from'] = $this->input->get('created_from');
			$this->data['created_to'] = $this->input->get('created_to');
			$this->data['last_update_from'] = $this->input->get('last_update_from');
			$this->data['last_update_to'] = $this->input->get('last_update_to');

			$records = $this->case_model->get_reserve_report($this->data);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=ReserveReport.csv');
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
			fputcsv($output, array(
									'Case / Claim No.',
									'InitialReserveAmount',
									'TotalReserveAmount',
									'CurrentReserveAmount',
									'NetReserveAmount',
									'ReserveCurrencyCode',
									'ReserveCreateDate',
									'ReserveLastUpdateDate'
					));
			foreach ($records as $key => $value) { 
				fputcsv($output, array(
						$value['case_no'],
						sprintf("%0.2f", $value['init_reserve_amount']),
						sprintf("%0.2f", $value['reserve_amount']),
						sprintf("%0.2f", $value['reserve_amount'] - $value['paied_amount']),
						sprintf("%0.2f", $value['reserve_amount'] - $value['approved_amount']),
						'CAD',
						$value['init_reserve_tm'],
						$value['reserve_update_tm']
				));
			}
		}
	}
}
