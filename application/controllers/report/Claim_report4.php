<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

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
			$this->load->model('province_model');
      
      $this->data['provinces'] = $this->province_model->get_list(1); // Canada only

      $get = $this->input->get();
      $this->data['records'] = array();
      if ($get) {
        $this->data['records'] = $this->claim_model->claim_report4($get);
      }

      if (isset($get["iscsv"])) {
        if (0) {
          $filename = "report4_".$this->input->get('start_dt')."_".$this->input->get('end_dt');
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
                empty($value['up_insuer'])?"":$value['up_insuer'],
                $value['product_short'],
                $value['insured_first_name'],
                $value['insured_last_name'],
                $value['policy_no'],
                number_format($value['sum_insured'], 2),
                empty($value['effective_date'])?"":$value['effective_date'],
                empty($value['province'])?"":$value['province'],
                $value['claim_no'],
                empty($value['package'])?"":$value['package'],
                $value['date_symptoms'],
                empty($value['status2'])?"":$value['status2'],
                empty($value['status'])?"":$value['status'],
                substr($value['created'], 0, 10),
                substr($value['last_update'], 0, 10),
                empty($value['opendays'])?"":$value['opendays'],
                empty($value['denied_reason'])?"":$value['denied_reason'],
                empty($value['notes'])?"":$value['notes'],
                number_format($value['claimed_amount'], 2),
                number_format($value['reserve_amount'], 2),
                number_format($diminishing, 2),
                number_format($value['paied_amount'], 2),
                number_format($incurred, 2),
              ));
            }
          }
        } else {
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
          $objPHPExcel->setActiveSheetIndex(0);
          $sheet = $objPHPExcel->getActiveSheet();
          $sheet->setTitle('Sheet1');
          $sheet->setCellValue('A1', 'Insurer');
          $sheet->setCellValue('B1', 'Product');
          $sheet->setCellValue('C1', 'Last Name');
          $sheet->setCellValue('D1', 'First Name');
          $sheet->setCellValue('E1', 'Policy Number');
          $sheet->setCellValue('F1', 'Sum Insured');
          $sheet->setCellValue('G1', 'Policy Start Date');
          $sheet->setCellValue('H1', 'Province');
          $sheet->setCellValue('I1', 'Claim number');
          $sheet->setCellValue('J1', 'Claim type');
          $sheet->setCellValue('K1', 'Claim Loss Date');
          $sheet->setCellValue('L1', 'Claim Status');
          $sheet->setCellValue('M1', 'Process Status');
          $sheet->setCellValue('N1', 'Created Date');
          $sheet->setCellValue('O1', 'Closed Date');
          $sheet->setCellValue('P1', 'Days Opened');
          $sheet->setCellValue('Q1', 'Claim Denied Reason');
          $sheet->setCellValue('R1', 'Other Reasons');
          $sheet->setCellValue('S1', 'Total Claimed Amount');
          $sheet->setCellValue('T1', 'Reserve');
          $sheet->setCellValue('U1', 'Diminishing Reserve');
          $sheet->setCellValue('V1', 'Total Amount Paid');
          $sheet->setCellValue('W1', 'Incurred');

          if (!empty($this->data['records'])) {
            $row = 2;
            foreach ($this->data['records'] as $value) {
              // $policy = json_decode($value["policy_info"], true);
              $diminishing = 0;
              if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
                $diminishing = $value['reserve_amount'] - $value['claimed_amount'];
              }
              $incurred = $diminishing + $value['paied_amount'];
              $province = empty($value['province'])?"":$value['province'];
              if (!empty($this->data['provinces'][$province])) {
                $province = $this->data['provinces'][$province];
              }
              $province = ucfirst(strtolower($province));
  
              $sheet->setCellValue('A'.$row, empty($value['up_insuer'])?"":$value['up_insuer']);
              $sheet->setCellValue('B'.$row, $value['product_short']);
              $sheet->setCellValue('C'.$row, $value['insured_first_name']);
              $sheet->setCellValue('D'.$row, $value['insured_last_name']);
              $sheet->setCellValue('E'.$row, $value['policy_no']);
              $sheet->setCellValue('F'.$row, number_format($value['sum_insured'], 2));
              $sheet->setCellValue('G'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['effective_date'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('H'.$row, $province);
              $sheet->setCellValue('I'.$row, $value['claim_no']);
              $sheet->setCellValue('J'.$row, empty($value['package'])?"":$value['package']);
              $sheet->setCellValue('K'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['date_symptoms'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('L'.$row, empty($value['status2'])?"":$value['status2']);
              $sheet->setCellValue('M'.$row, empty($value['status'])?"":$value['status']);
              $sheet->setCellValue('N'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['created'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('N'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('P'.$row, empty($value['opendays'])?"":$value['opendays']);
              $sheet->setCellValue('Q'.$row, empty($value['denied_reason'])?"":$value['denied_reason']);
              $sheet->setCellValue('R'.$row, empty($value['notes'])?"":$value['notes']);
              $sheet->setCellValue('S'.$row, number_format($value['claimed_amount'], 2));
              $sheet->setCellValue('T'.$row, number_format($value['reserve_amount'], 2));
              $sheet->setCellValue('U'.$row, number_format($diminishing, 2));
              $sheet->setCellValue('V'.$row, number_format($value['paied_amount'], 2));
              $sheet->setCellValue('W'.$row, number_format($incurred, 2));
              $row++;
            }
          }
          $objPHPExcel->setActiveSheetIndex(0);
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $filename = "report4_".$this->input->get('start_dt')."_".$this->input->get('end_dt').".xlsx";
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
          $objWriter->save('php://output');
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
