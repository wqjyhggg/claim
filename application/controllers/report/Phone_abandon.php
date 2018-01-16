<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phone_abandon extends CI_Controller {
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
			if ($rts = $this->phone_model->phone_abandon($para)) {
				$tmidxs = $this->phone_model->get_time_index('day', $para['start_dt'], $para['end_dt']);
				foreach ($tmidxs as $tmstr) {
					$records[$tmstr] = array(
						'calls' => 0,
						'answers' => 0,
						'abandons' => 0,
						'less10' => 0,
						'less20' => 0,
						'less30' => 0,
						'less40' => 0,
						'less50' => 0,
						'avg_abandon' => 0,
						'avg_answer' => 0,
						'total_abandon' => 0,
						'total_answer' => 0,
					);
				}
				
				foreach ($rts as $rc) {
					$records[$rc['dt']]['calls'] = $rc['calls'];
					$records[$rc['dt']]['answers'] = $rc['answers'];
					$records[$rc['dt']]['abandons'] = $rc['abandons'];
					$records[$rc['dt']]['less10'] = $rc['less10'];
					$records[$rc['dt']]['less20'] = $rc['less20'];
					$records[$rc['dt']]['less30'] = $rc['less30'];
					$records[$rc['dt']]['less40'] = $rc['less40'];
					$records[$rc['dt']]['less50'] = $rc['less50'];
					$records[$rc['dt']]['avg_abandon'] = empty($rc['abandons']) ? 0 : $rc['total_abandons'] / $rc['abandons'];
					$records[$rc['dt']]['avg_answer'] = empty($rc['answers']) ? 0 : $rc['total_answer'] / $rc['answers'];
					$records[$rc['dt']]['total_abandon'] = $rc['total_abandons'];
					$records[$rc['dt']]['total_answer'] = $rc['total_answer'];
				}
			}
			$this->data['records'] = $records;
				
			$this->data['export_url'] = site_url('report/phone_abandon/export');
			if (count($this->input->get()) > 0)	$this->data['export_url'] .= '?' . http_build_query($this->input->get(), '', "&");

			$this->template->write('title', SITE_TITLE . ' - Phone Report', TRUE);
			$this->template->write_view('content', 'report/phone_abandon', $this->data);
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
			if ($rts = $this->phone_model->phone_abandon($para)) {
				$tmidxs = $this->phone_model->get_time_index('day', $para['start_dt'], $para['end_dt']);
				foreach ($tmidxs as $tmstr) {
					$records[$tmstr] = array(
						'calls' => 0,
						'answers' => 0,
						'abandons' => 0,
						'less10' => 0,
						'less20' => 0,
						'less30' => 0,
						'less40' => 0,
						'less50' => 0,
						'avg_abandon' => 0,
						'avg_answer' => 0,
						'total_abandon' => 0,
						'total_answer' => 0,
					);
				}
				
				foreach ($rts as $rc) {
					$records[$rc['dt']]['calls'] = $rc['calls'];
					$records[$rc['dt']]['answers'] = $rc['answers'];
					$records[$rc['dt']]['abandons'] = $rc['abandons'];
					$records[$rc['dt']]['less10'] = $rc['less10'];
					$records[$rc['dt']]['less20'] = $rc['less20'];
					$records[$rc['dt']]['less30'] = $rc['less30'];
					$records[$rc['dt']]['less40'] = $rc['less40'];
					$records[$rc['dt']]['less50'] = $rc['less50'];
					$records[$rc['dt']]['avg_abandon'] = empty($rc['abandons']) ? 0 : $rc['total_abandons'] / $rc['abandons'];
					$records[$rc['dt']]['avg_answer'] = empty($rc['answers']) ? 0 : $rc['total_answer'] / $rc['answers'];
					$records[$rc['dt']]['total_abandon'] = $rc['total_abandons'];
					$records[$rc['dt']]['total_answer'] = $rc['total_answer'];
				}
			}
			
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=Phone_abandon.csv');
				
			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			// output the column headings
			fputcsv($output, array('Queue :', $this->input->get('queue')));
			fputcsv($output, array('Date Range :', $this->input->get('start_dt') . " - " . $this->input->get('end_dt')));
			fputcsv($output, array(''));
			
			fputcsv($output, array('Date','Ints Offerred','Ints Answered','Ints Aband','< 10s','< 20s','< 30s','< 40s','< 50s','Aband Rate','Ave Aband Time','Ave Speed Ans'));
			$t_calls = $t_answers = $t_abandons = $t_less10 = $t_less20 = $t_less30 = $t_less40 = $t_less50 = $t_total_abandon = $t_total_answer = 0;
			foreach($records as $key => $value ) { 
				$t_calls += $value['calls'];
				$t_answers += $value['answers'];
				$t_abandons += $value['abandons'];
				$t_less10 += $value['less10'];
				$t_less20 += $value['less20'];
				$t_less30 += $value['less30'];
				$t_less40 += $value['less40'];
				$t_less50 += $value['less50'];
				$t_total_abandon += $value['total_abandon'];
				$t_total_answer += $value['total_answer'];
				fputcsv($output, array($key,
						$value['calls'],
						$value['answers'],
						$value['abandons'],
						empty($value['calls']) ? '0%' : number_format($value['less10'] * 100 / $value['calls'], 2) . "%",
						empty($value['calls']) ? '0%' : number_format($value['less20'] * 100 / $value['calls'], 2) . "%",
						empty($value['calls']) ? '0%' : number_format($value['less30'] * 100 / $value['calls'], 2) . "%",
						empty($value['calls']) ? '0%' : number_format($value['less40'] * 100 / $value['calls'], 2) . "%",
						empty($value['calls']) ? '0%' : number_format($value['less50'] * 100 / $value['calls'], 2) . "%",
						empty($value['calls']) ? '0%' : number_format($value['abandons'] * 100 / $value['calls'], 2) . "%",
						$this->phone_model->second_to_time($value['avg_abandon']),
						$this->phone_model->second_to_time($value['avg_answer'])));
			}
			fputcsv($output, array(''));
			fputcsv($output, array(
					'Total',
					$t_calls,
					$t_answers,
					$t_abandons,
					empty($t_calls) ? '0%' : number_format($t_less10 * 100 / $t_calls, 2) . "%",
					empty($t_calls) ? '0%' : number_format($t_less20 * 100 / $t_calls, 2) . "%",
					empty($t_calls) ? '0%' : number_format($t_less30 * 100 / $t_calls, 2) . "%",
					empty($t_calls) ? '0%' : number_format($t_less40 * 100 / $t_calls, 2) . "%",
					empty($t_calls) ? '0%' : number_format($t_less50 * 100 / $t_calls, 2) . "%",
					empty($t_calls) ? '0%' : number_format($t_abandons * 100 / $t_calls, 2) . "%",
					empty($t_abandons) ? 0 : $this->phone_model->second_to_time($t_total_abandon/$t_abandons),
					empty($t_answers) ? 0 : $this->phone_model->second_to_time($t_total_answer/$t_answers)));
		}
	}
}
