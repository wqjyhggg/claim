<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phone_online extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('phone_model');
				
			// if sorting enabled
			$para = array();
			$para['agent'] = $this->input->get('agent');
			if ($this->input->get('start_dt')) {
				$para['start_dt'] = $this->input->get('start_dt');
			} else {
				$para['start_dt'] = date("Y-m-d");
			}
			if ($this->input->get('end_dt')) {
				$para['end_dt'] = $this->input->get('end_dt');
			} else {
				$para['end_dt'] = date("Y-m-d");
			}

			$this->data['phone_list'] = $this->phone_model->get_working_number();

			$this->data['records'] = $this->phone_model->phone_online_report($para);

			$this->data['export_url'] = site_url('report/phone_online/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

      $this->data["start_dt"] = $para['start_dt'];
      $this->data["end_dt"] = $para['end_dt'];

			$this->template->write('title', SITE_TITLE . ' - Phone Online Report', TRUE);
			$this->template->write_view('content', 'report/phone_online', $this->data);
			$this->template->render();
		}
	}

	public function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('phone_model');
				
			// if sorting enabled
			$para['agent'] = $this->input->get('agent');
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

			$records = $this->phone_model->phone_online_report($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Claim_summary.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings
      if ($para['agent']) {
        fputcsv($output, array('Phone :', $para['agent'], 'Date Range :', $para['start_dt'] . " - " . $para['end_dt']));
      } else {
        fputcsv($output, array('Date Range :', $para['start_dt'] . " - " . $para['end_dt']));
      }
      fputcsv($output, array('Phone Number', 'Start Time', 'End Time', 'Long'));

			foreach ($records as $value) { 
				fputcsv($output, $value);
			}
      exit;
		}
	}
}
