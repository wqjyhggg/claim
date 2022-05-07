<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_report4 extends CI_Controller {
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
			$this->load->model('product_model');
			$this->load->model('claim_model');

      $get = $this->input->get();
      $this->data['records'] = array();
      if ($get) {
        $this->data['records'] = $this->claim_model->claim_report4($get);
      }

      if (isset($get["iscsv"])) {
        $filename = "report4_".$this->input->get('start_dt')."_".$this->input->get('end_dt');
        if (!empty($this->data['is_examiner'] == 1)) {
          $filename .= "examiner";
        }
        header('Content-Disposition: attachment;filename="'.$filename.'.csv";');
        header('Content-Type: application/csv; charset=UTF-8');
        $fp = fopen("php://output", "w");
        fputcsv($fp, array( 'Insurer',
                            'Product',
                            'Last Name',
                            'First Name',
                            'Policy Number',
                            'Sum Insured',
                            'Policy Start Date', // No "Policy Start Date"
                            'Province',
                            'Claim number',
                            'Claim type',
                            'Claim Loss Date',
                            'Claim Status',
                            'Process Status',
                            'Created Date',
                            'Closed Date',
                            'Days Opened',
                            'Claim Denied Reason',
                            'Other Reasons',
                            'Total Claimed Amount',
                            'Reserve',
                            'Diminishing Reserve',
                            'Total Amount Paid',
                            'Incurred',
                          ));
        if (!empty($this->data['records'])) {
          foreach ($this->data['records'] as $value) {
            // $policy = json_decode($value["policy_info"], true);
            $diminishing = 0;
            if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
              $diminishing = $value['reserve_amount'] - $value['claimed_amount'];
            }
            $incurred = $diminishing + $value['paied_amount'];
            fputcsv($fp, array(
              $value['up_insuer'],
              $value['product_short'],
              $value['insured_first_name'],
              $value['insured_last_name'],
              $value['policy_no'],
              number_format($value['sum_insured'], 2),
              $value['effective_date'],
              $value['province'],
              $value['claim_no'],
              $value['package'],
              $value['date_symptoms'],
              $value['status2'],
              $value['status'],
              substr($value['created'], 0, 10),
              substr($value['last_update'], 0, 10),
              $value['opendays'],
              $value['denied_reason'],
              $value['notes'],
              number_format($value['claimed_amount'], 2),
              number_format($value['reserve_amount'], 2),
              number_format($diminishing, 2),
              number_format($value['paied_amount'], 2),
              number_format($incurred, 2),
            ));
          }
        }
      } else {
        $allproducts = $this->product_model->get_all();
        $this->data['products'] = [];
        $this->data['up_insuer_list'] = [''=>'select insurer'];
        foreach ($allproducts as $prod) {
          $this->data['products'][$prod["product_short"]] = $prod["product_short"];
          if (empty($this->data['up_insuer_list'][$prod["up_insuer"]])) {
            $this->data['up_insuer_list'][$prod["up_insuer"]] = $prod["up_insuer"];
          }
        }
        $this->data['yearlist'] = array("" => "select Year");
        $thisyear = date("Y");
        for ($i = 0; $i < 5; $i++) {
          $this->data['yearlist'][] = $thisyear - $i;
        }
  
        $get["iscsv"] = 1;
        $this->data['export_url'] = site_url('report/claim_report4')."?".http_build_query($get);
        $this->data['current_url'] = site_url('report/claim_report4');

        $this->template->write_view('content', 'report/claim_report4', $this->data);
        $this->template->render();
      }
		}
	}
}
