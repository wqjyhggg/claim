<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agent_activity extends CI_Controller {
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
			$para['user_id'] = $this->input->get('user_id');
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

			$this->data['user_list'] = $this->phone_model->get_phone_user_list();

			$this->data['records'] = $this->phone_model->agent_activity($para);

			$this->data['export_url'] = site_url('report/agnet_activity/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Phone Report', TRUE);
			$this->template->write_view('content', 'report/agent_activity', $this->data);
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
			$para['user_id'] = $this->input->get('user_id');
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

			$records = $this->phone_model->agent_activity($para);
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Claim_summary.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings

			foreach ($arr as $key => $value) { 
				fputcsv($output, array('Email :', $value['email']));
				fputcsv($output, array('Name :', $value['first_name'] . " " . $value['last_name']));
				fputcsv($output, array('Date Range :', $this->input->get('start_dt') . " - " . $this->input->get('end_dt')));
				fputcsv($output, array('ACW (pause) :', $this->phone_model->second_to_time($value['pause'])));
				fputcsv($output, array('Break :', $this->phone_model->second_to_time($value['break'])));
				fputcsv($output, array('Answer Call :', $this->phone_model->second_to_time($value['incall'])));
				fputcsv($output, array('Call Out :', $this->phone_model->second_to_time($value['outcall'])));
				fputcsv($output, array('Available (waiting for call) :', $this->phone_model->second_to_time($value['waiting'])));
				fputcsv($output, array('Tital time :', $this->phone_model->second_to_time($value['pause'] + $value['break'] + $value['incall'] + $value['outcall'] + $value['waiting'])));
			}
		}
	}
}
