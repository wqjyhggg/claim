<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phone_report extends CI_Controller {
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
			$this->load->model('phone_model');
				
			// if sorting enabled
			$para = array();
			$para['queue'] = $this->input->get('queue');
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

			$this->data['queue_list'] = $this->phone_model->get_queue_list();
				
			$arr = array();
			if ($records = $this->phone_model->phone_report($para)) {
				$tmidxs = $this->phone_model->get_time_index('day', $para['start_dt'], $para['end_dt']);
				foreach ($tmidxs as $tmstr) {
					$arr[$tmstr] = array(
						'answers' => 0,
						'avg_talk' => 0,
						'total_talk' => 0,
						'avg_pause' => 0,
						'total_pause' => 0,
						'abandoned' => 0,
						'avg_abandoned' => 0,
						'percent_abandoned' => 0,
						'max_waiting' => 0,
						'avg_waiting' => 0,
					);
				}
				
				foreach ($records['in'] as $rc) {
					$arr[$rc['dt']]['answers'] = $rc['answers'];
				}
			
				foreach ($records['acw'] as $rc) {
					$arr[$rc['dt']]['total_pause'] = $rc['total_pause'];
				}
						
				foreach ($records['abandoned'] as $rc) {
					$arr[$rc['dt']]['abandoned'] = $rc['abandoned'];
					$arr[$rc['dt']]['avg_abandoned'] = $this->phone_model->second_to_time($rc['avg_abandoned']);
				}
									
				foreach ($records['answer'] as $rc) {
					$arr[$rc['dt']]['max_waiting'] = $rc['max_waiting'];
					$arr[$rc['dt']]['avg_waiting'] = $this->phone_model->second_to_time($rc['avg_waiting']);
					$arr[$rc['dt']]['avg_talk'] = $this->phone_model->second_to_time($rc['avg_talk']);
					$arr[$rc['dt']]['total_talk'] = $this->phone_model->second_to_time($rc['total_talk']);
				}
				
				foreach ($arr as $key => $rc) {
					$arr[$key]['avg_pause'] = empty($rc['answers']) ? 0 : $this->phone_model->second_to_time($rc['total_pause'] / $rc['answers']);
					$arr[$key]['percent_abandoned'] = empty($rc['answers']) ? 0 : number_format($rc['abandoned'] * 100 / $rc['answers'], 2);
					$arr[$key]['total_pause'] = $this->phone_model->second_to_time($arr[$key]['total_pause']);
				}
			}
			$this->data['records'] = $arr;

			$this->data['export_url'] = site_url('report/phone_report/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Phone Report', TRUE);
			$this->template->write_view('content', 'report/phone_report', $this->data);
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
			$para = array();
			$para['queue'] = $this->input->get('queue');
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

			$this->data['queue_list'] = $this->phone_model->get_queue_list();
				
			$arr = array();
			if ($records = $this->phone_model->phone_report($para)) {
				$tmidxs = $this->phone_model->get_time_index('day', $para['start_dt'], $para['end_dt']);
				foreach ($tmidxs as $tmstr) {
					$arr[$tmstr] = array(
						'answers' => 0,
						'avg_talk' => 0,
						'total_talk' => 0,
						'avg_pause' => 0,
						'total_pause' => 0,
						'abandoned' => 0,
						'avg_abandoned' => 0,
						'percent_abandoned' => 0,
						'max_waiting' => 0,
						'avg_waiting' => 0,
					);
				}
				
				foreach ($records['in'] as $rc) {
					$arr[$rc['dt']]['answers'] = $rc['answers'];
				}
			
				foreach ($records['acw'] as $rc) {
					$arr[$rc['dt']]['total_pause'] = $rc['total_pause'];
				}
						
				foreach ($records['abandoned'] as $rc) {
					$arr[$rc['dt']]['abandoned'] = $rc['abandoned'];
					$arr[$rc['dt']]['avg_abandoned'] = $this->phone_model->second_to_time($rc['avg_abandoned']);
				}
									
				foreach ($records['answer'] as $rc) {
					$arr[$rc['dt']]['max_waiting'] = $rc['max_waiting'];
					$arr[$rc['dt']]['avg_waiting'] = $this->phone_model->second_to_time($rc['avg_waiting']);
					$arr[$rc['dt']]['avg_talk'] = $this->phone_model->second_to_time($rc['avg_talk']);
					$arr[$rc['dt']]['total_talk'] = $this->phone_model->second_to_time($rc['total_talk']);
				}
				
				foreach ($arr as $key => $rc) {
					$arr[$key]['avg_pause'] = empty($rc['answers']) ? 0 : $this->phone_model->second_to_time($rc['total_pause'] / $rc['answers']);
					$arr[$key]['percent_abandoned'] = empty($rc['answers']) ? 0 : number_format($rc['abandoned'] * 100 / $rc['answers'], 2);
					$arr[$key]['total_pause'] = $this->phone_model->second_to_time($arr[$key]['total_pause']);
				}
			}
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Claim_summary.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');
				
			// output the column headings

			fputcsv($output, array('Queue :', $this->input->get('queue')));
			fputcsv($output, array('Date Range :', $this->input->get('start_dt') . " - " . $this->input->get('end_dt')));

			fputcsv($output, array(
				'',
				'Ints Ans',
				'Avg Talk',
				'Total Talk',
				'Avg ACW',
				'Total ACW',
				'Ints Abns',
				'Avg Abns',
				'% Aband',
				'Max Wait Ans',
				'Avg Speed Ans',
			));

			foreach ($arr as $key => $value) { 
				fputcsv($output, array(
					$key,
					$value['answers'],
					$value['avg_talk'],
					$value['total_talk'],
					$value['avg_pause'],
					$value['total_pause'],
					$value['abandoned'],
					$value['avg_abandoned'],
					$value['percent_abandoned'],
					$value['max_waiting'],
					$value['avg_waiting'],
				));
			}
		}
	}
}
