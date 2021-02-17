<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_sla extends CI_Controller {
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
			$this->load->model('eclaim_model');
			$this->load->model('claim_model');
			$this->load->model('case_model');
			$this->load->model('product_model');

      $this->data['reports'] = array();
      $this->data['product_short'] = $this->input->get('product_short');
      $this->data['is_eclaim'] = $this->input->get('is_eclaim');
      $this->data['start_dt'] = ($this->input->get('start_dt'))?$this->input->get('start_dt'):date("Y-m-d");
      $this->data['end_dt'] = ($this->input->get('end_dt'))?$this->input->get('end_dt'):date("Y-m-d");
      $this->data['is_examiner'] = $this->input->get('is_examiner');
      $this->data['examiner_id'] = $this->input->get('examiner_id');
      $this->data['examiners'] = $this->users_model->search(array('groups' => Users_model::GROUP_EXAMINER, 'active' => 1), 100);
      if ($this->input->get('submit')) {
        if ($this->data['is_examiner']) {
          foreach ($this->data['examiners'] as $exam) {
            if (!empty($this->data['examiner_id']) && ($this->data['examiner_id'] != $exam['id'])) {
              continue;
            }
            $rp = array('id' => $exam['id'], 
                        'email' => $exam['email'],  // Examiner
                        'count' => 0,               // Total Number of Claims
                        'open' => 0,                // Number of Open Claims
                        'closed' => 0,              // Number of Closed Claims
                        'total_open' => 0,          // Value of Open Claims
                        'total_closed' => 0,        // Value of Closed Claims
                        'eclaim_tf_days' => 0,      // Eclaim  Avg. Transfer Time
                        'pending_days' => 0,        // Open Claims Pending Time
                        'close_days' => 0,          // Closed Claims Avg. Close Time
                        'paid_avg' => 0,            // Avg. Paid Claim Amount
                        );
            $rt = $this->claim_model->get_sla_examiner_report($exam['id'], $this->data['product_short'], $this->data['start_dt'], $this->data['end_dt'], $this->data['is_eclaim']);
            if ($rt) {
              foreach ($rt as $rc) {
                $rp['count']++;
                if (($rc['status'] == 'Processed') || ($rc['status'] == 'Paid')) {
                  $rp['closed']++;
                  $rp['total_closed'] += (float)$rc['amount'];
                } else {
                  $rp['open']++;
                  $rp['total_open'] += (float)$rc['amount'];
                }
                if ($this->data['is_eclaim']) {
                  $rp['eclaim_tf_days'] += (int)$rc['eclaim_tf_days'];
                }
                $rp['pending_days'] += (int)$rc['pending_days'];
                $rp['close_days'] += (int)$rc['close_days'];
                $rp['paid_avg'] += (int)$rc['paid_avg'];
              }
              if ($this->data['is_eclaim']) {
                $rp['eclaim_tf_days'] = number_format($rp['eclaim_tf_days'] / $rp['count'], 2);
              }
              if ($rp['open'] > 0) {
                $rp['pending_days'] = number_format($rp['pending_days'] / $rp['open'], 2);
              } else {
                $rp['pending_days'] = "N/A";
              }
              if ($rp['closed'] > 0) {
                $rp['close_days'] = number_format($rp['close_days'] / $rp['closed'], 2);
                $rp['paid_avg'] = number_format($rp['paid_avg'] / $rp['closed'], 2);
              } else {
                $rp['close_days'] = "N/A";
                $rp['paid_avg'] = "N/A";
              }
            }
            $this->data['reports'][] = $rp;
          }
        } else {
          $arr = array(
            0 => array('low' => 0, 'height' => 250),
            1 => array('low' => 250, 'height' => 500),
            2 => array('low' => 500, 'height' => 1000),
            3 => array('low' => 1000, 'height' => 3000),
            4 => array('low' => 3000, 'height' => 5000),
            5 => array('low' => 5000, 'height' => 10000),
            6 => array('low' => 10000, 'height' => 25000),
            7 => array('low' => 25000, 'height' => 50000),
            8 => array('low' => 50000, 'height' => 75000),
            9 => array('low' => 75000, 'height' => 100000),
            10 => array('low' => 100000, 'height' => 1000000000),
          );
          foreach ($arr as $key => $tm) {
            $this->data['reports'][$key] = array(
              'key' => $tm['low']."-".(($tm['height'] > 100000)?"-":$tm['height']), // Claim Amount
              'count' => 0,           // Total Number of Claims
              'open' => 0,            // Number of Open Claims
              'closed' => 0,          // Number of Closed Claims
              'total_open' => 0,      // Value of Open Claims
              'total_closed' => 0,    // Value of Closed Claims
              'eclaim_tf_days' => 0,  // Eclaim  Avg. Transfer Time
              'pending_days' => 0,    // Open Claims Pending Time
              'close_days' => 0,      // Closed Claims Avg. Close Time
              );
          }
          $rt = $this->claim_model->get_sla_report($this->data['product_short'], $this->data['start_dt'], $this->data['end_dt'], $this->data['is_eclaim']);
          if ($rt) {
            foreach ($rt as $rc) {
              if ((float)$rc['amount'] <= 0) continue;
              foreach ($arr as $key => $tm) {
                if ((float)$rc['amount'] <= $tm['height']) {
                  $this->data['reports'][$key]['count']++;
                  if (($rc['status'] == 'Processed') || ($rc['status'] == 'Paid')) {
                    $this->data['reports'][$key]['closed']++;
                    $this->data['reports'][$key]['total_closed'] += (float)$rc['amount'];
                    $this->data['reports'][$key]['close_days'] += (int)$rc['close_days'];
                  } else {
                    $this->data['reports'][$key]['open']++;
                    $this->data['reports'][$key]['total_open'] += (float)$rc['amount'];
                    $this->data['reports'][$key]['pending_days'] += (int)$rc['pending_days'];
                  }
                  if ($this->data['is_eclaim']) {
                    $this->data['reports'][$key]['eclaim_tf_days'] += (int)$rc['eclaim_tf_days'];
                  }
                  break;                    
                }
              }
            }
            foreach ($arr as $key => $tm) {
              if ($this->data['reports'][$key]['count'] > 0) {
                $this->data['reports'][$key]['eclaim_tf_days'] = number_format($this->data['reports'][$key]['eclaim_tf_days'] / $this->data['reports'][$key]['count'], 2);
              } else {
                $this->data['reports'][$key]['eclaim_tf_days'] = "N/A";
              }
              if ($this->data['reports'][$key]['open'] > 0) {
                $this->data['reports'][$key]['pending_days'] = number_format($this->data['reports'][$key]['pending_days'] / $this->data['reports'][$key]['open'], 2);
              } else {
                $this->data['reports'][$key]['pending_days'] = "N/A";
              }
              if ($this->data['reports'][$key]['closed'] > 0) {
                $this->data['reports'][$key]['close_days'] = number_format($this->data['reports'][$key]['close_days'] / $this->data['reports'][$key]['closed'], 2);
              } else {
                $this->data['reports'][$key]['close_days'] = "N/A";
              }
            }
          }
        }
			}
      $this->data['products'] = $this->product_model->get_list();

      $this->data['iscsv'] = $this->input->get('iscsv')?1:0;

      $this->data['export_url'] = site_url('report/claim_sla')."?iscsv=1&submit=1";
      $this->data['export_url'] .= "&product_short=".urlencode($this->input->get('product_short'));
      $this->data['export_url'] .= "&is_eclaim=".urlencode($this->input->get('is_eclaim'));
      $this->data['export_url'] .= "&start_dt=".urlencode($this->input->get('start_dt'));
      $this->data['export_url'] .= "&end_dt=".urlencode($this->input->get('end_dt'));
      $this->data['export_url'] .= "&is_examiner=".urlencode($this->input->get('is_examiner'));
      $this->data['export_url'] .= "&examiner_id=".urlencode($this->input->get('examiner_id'));
      $this->data['current_url'] = site_url('report/claim_sla');
      if ($this->data['iscsv']) {
        $filename = "sla_".$this->input->get('start_dt')."_".$this->input->get('end_dt');
        if (!empty($this->data['is_examiner'] == 1)) {
          $filename .= "examiner";
        }
        header('Content-Disposition: attachment;filename="'.$filename.'.csv";');
        header('Content-Type: application/csv; charset=UTF-8');
        $fp = fopen("php://output", "w");
        if (!empty($this->data['is_examiner'] == 1)) {
          fputcsv($fp, array( 'Examiner',
                              'Total Number of Claims',
                              'Number of Open Claims',
                              'Number of Closed Claims',
                              'Value of Open Claims',
                              'Value of Closed Claims',
                              'Eclaim Avg. Transfer Time',
                              'Open Claims Pending Time',
                              'Closed Claims Avg. Close Time',
                              'Avg. Paid Claim Amount',
                            ));
          if (!empty($this->data['reports'])) {
            foreach ($this->data['reports'] as $value) {
              fputcsv($fp, array($value['email'],$value['count'],$value['open'],$value['closed'],$value['total_open'],$value['total_closed'],$value['eclaim_tf_days'],$value['pending_days'],$value['close_days'],$value['paid_avg']));
            }
          }
        } else {
          fputcsv($fp, array( 'Claim Amount',
                              'Total Number of Claims',
                              'Number of Open Claims',
                              'Number of Closed Claims',
                              'Value of Open Claims',
                              'Value of Closed Claims',
                              'Eclaim Avg. Transfer Time',
                              'Open Claims Pending Time',
                              'Closed Claims Avg. Close Time',
                            ));
          if (!empty($this->data['reports'])) {
            foreach ($this->data['reports'] as $value) {
              fputcsv($fp, array($value['key'],$value['count'],$value['open'],$value['closed'],$value['total_open'],$value['total_closed'],$value['eclaim_tf_days'],$value['pending_days'],$value['close_days']));
            }
          }
        }
      } else {
        $this->template->write_view('content', 'report/claim_sla', $this->data);
        $this->template->render();
      }
		}
	}
}
