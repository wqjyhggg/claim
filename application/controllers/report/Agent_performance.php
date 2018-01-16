<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agent_performance extends CI_Controller {
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

			$this->data['user_list'] = $this->phone_model->get_phone_user_list();
			$this->data['queue_list'] = $this->phone_model->get_queue_list();

			$records = array();
			if ($rts = $this->phone_model->agent_performance($para)) {
				$arr = array(
						'in_calls' => 0,
						'in_avg_talk' => 0,
						'in_total_talk' => 0,
						'in_avg_pause' => 0,
						'in_total_pause' => 0,
						'in_avg_waiting' => 0,
						'out_calls' => 0,
						'out_avg_talk' => 0,
						'out_total_talk' => 0,
				);
				
				if (empty($para['user_id'])) {
					foreach ($this->data['user_list'] as $u) {
						if (empty($u['id'])) continue;
						$records[$u['id']]['data'] = $arr;
						$records[$u['id']]['user'] = $u;
					}
				} else {
					$records[$para['user_id']]['data'] = $arr;
					$records[$u['id']]['user'] = $this->users_model->get_by_id($para['user_id']);
				}
				
				foreach ($rts['acw'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['total_pause'] = $rc['total_pause'];
				}
				
				foreach ($rts['callout'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['out_calls'] = $rc['calls'];
					$records[$rc['user_id']]['data']['out_avg_talk'] = $rc['avg_talk'];
					$records[$rc['user_id']]['data']['out_total_talk'] = $rc['total_talk'];
				}
					
				foreach ($rts['answer'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['in_calls'] = $rc['calls'];
					$records[$rc['user_id']]['data']['in_avg_talk'] = $rc['avg_talk'];
					$records[$rc['user_id']]['data']['in_total_talk'] = $rc['total_talk'];
					$records[$rc['user_id']]['data']['in_avg_waiting'] = $rc['avg_waiting'];
				}
				
				foreach ($records as $user_id => $arr) {
					$records[$user_id]['data']['avg_pause'] = (empty($arr['data']['in_calls']) || empty($arr['data']['total_pause'])) ? 0 : $arr['data']['total_pause'] / $arr['data']['in_calls'];
				}
			}
			$this->data['records'] = $records;
				
			$this->data['export_url'] = site_url('report/agent_performance/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Phone Report', TRUE);
			$this->template->write_view('content', 'report/agent_performance', $this->data);
			$this->template->render();
		}
	}

	public function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('phone_model');
				
					$para = array();
			$para['user_id'] = $this->input->get('user_id');
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

			$this->data['user_list'] = $this->phone_model->get_phone_user_list();
			$this->data['queue_list'] = $this->phone_model->get_queue_list();

			$records = array();
			if ($rts = $this->phone_model->agent_performance($para)) {
				$arr = array(
						'in_calls' => 0,
						'in_avg_talk' => 0,
						'in_total_talk' => 0,
						'in_avg_pause' => 0,
						'in_total_pause' => 0,
						'in_avg_waiting' => 0,
						'out_calls' => 0,
						'out_avg_talk' => 0,
						'out_total_talk' => 0,
				);
				
				if (empty($para['user_id'])) {
					foreach ($this->data['user_list'] as $u) {
						if (empty($u['id'])) continue;
						$records[$u['id']]['data'] = $arr;
						$records[$u['id']]['user'] = $u;
					}
				} else {
					$records[$para['user_id']]['data'] = $arr;
					$records[$u['id']]['user'] = $this->users_model->get_by_id($para['user_id']);
				}
				
				foreach ($rts['acw'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['total_pause'] = $rc['total_pause'];
				}
				
				foreach ($rts['callout'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['out_calls'] = $rc['calls'];
					$records[$rc['user_id']]['data']['out_avg_talk'] = $rc['avg_talk'];
					$records[$rc['user_id']]['data']['out_total_talk'] = $rc['total_talk'];
				}
					
				foreach ($rts['answer'] as $rc) {
					if (empty($rc['user_id'])) continue;
					$records[$rc['user_id']]['data']['in_calls'] = $rc['calls'];
					$records[$rc['user_id']]['data']['in_avg_talk'] = $rc['avg_talk'];
					$records[$rc['user_id']]['data']['in_total_talk'] = $rc['total_talk'];
					$records[$rc['user_id']]['data']['in_avg_waiting'] = $rc['avg_waiting'];
				}
				
				foreach ($records as $user_id => $arr) {
					$records[$user_id]['data']['avg_pause'] = (empty($arr['data']['in_calls']) || empty($arr['data']['total_pause'])) ? 0 : $arr['data']['total_pause'] / $arr['data']['in_calls'];
				}
			}
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Agent_performance.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			// output the column headings
			fputcsv($output, array('Queue :', $this->input->get('queue')));
			fputcsv($output, array('Date Range :', $this->input->get('start_dt') . " - " . $this->input->get('end_dt')));
			fputcsv($output, array(''));
			
			$t_in_calls = $t_in_total_talk = $t_total_pause = $t_in_total_waiting = $t_out_calls = $t_out_total_talk = 0;
			foreach($records as $key => $value ) { 
				$t_in_calls += $value['data']['in_calls'];
				$t_in_total_talk += $value['data']['in_total_talk'];
				$t_total_pause += $value['data']['total_pause'];
				$t_in_total_waiting += $value['data']['in_calls'] * $value['data']['in_avg_waiting'];
				$t_out_calls += $value['data']['out_calls'];
				$t_out_total_talk += $value['data']['out_total_talk'];
				fputcsv($output, array('Email','Ints','Avg Talk','Total Talk','Avg ACW','Total ACW','Avg Speed Ans','Outs','Out Avg Talk','Out Total Talk'));
				fputcsv($output, array(
						$value['user']['email'],
						$value['data']['in_calls'],
						$this->phone_model->second_to_time($value['data']['in_avg_talk']),
						$this->phone_model->second_to_time($value['data']['in_total_talk']),
						$this->phone_model->second_to_time($value['data']['avg_pause']),
						$this->phone_model->second_to_time($value['data']['total_pause']),
						$this->phone_model->second_to_time($value['data']['in_avg_waiting']),
						$value['data']['out_calls'],
						$this->phone_model->second_to_time($value['data']['out_avg_talk']),
						$this->phone_model->second_to_time($value['data']['out_total_talk'])));
				fputcsv($output, array(''));
			}
			fputcsv($output, array('','Ints','Avg Talk','Total Talk','Avg ACW','Total ACW','Avg Speed Ans','Outs','Out Avg Talk','Out Total Talk'));
			fputcsv($output, array(
					'Total',
					$t_in_calls,
					empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_in_total_talk/$t_in_calls),
					$this->phone_model->second_to_time($t_in_total_talk),
					empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_total_pause/$t_in_calls),
					$this->phone_model->second_to_time($t_total_pause),
					empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_in_total_waiting/$t_in_calls),
					$t_out_calls,
					empty($t_out_calls) ? '0' : $this->phone_model->second_to_time($t_out_total_talk/$t_out_calls),
					$this->phone_model->second_to_time($t_out_total_talk)));
		}
	}
}
