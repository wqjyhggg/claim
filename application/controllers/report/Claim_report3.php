<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_report3 extends CI_Controller {
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
        $this->data['records'] = $this->claim_model->claim_report3($get);
      }

      if (isset($get["iscsv"])) {
        if (1) {
          $filename = 'claim_report3_' . date('Ymd_His') . '.csv';
          if (ob_get_level() > 0) {
            ob_end_clean();
          }
          // HTTP headers for browser download
          header('Content-Type: text/csv; charset=UTF-8');
          header('Content-Disposition: attachment; filename="' . $filename . '"');
          header('Pragma: no-cache');
          header('Expires: 0');
          header('Cache-Control: no-store, no-cache, must-revalidate');
          // Output directly to the browser
          $fp = fopen('php://output', 'w');
          if ($fp === false) {
            show_error('Cannot generate CSV file.');
            return;
          }

          // UTF-8 BOM for Excel compatibility
          fwrite($fp, "\xEF\xBB\xBF");

          // CSV header
          $headers = array(
            'Insurer',
            'Product',
            'Apply Date',
            'Policy Start date',
            'Policy End date',
            'Last Name',
            'First Name',
            'Policy Number',
            'Province',
            'Claim number',
            'Claim Start Date',
            'Claim Close Date',
            'Claim Status',
            'Process Status',
            'Sum Insured',
            'Total Claimed Amount',
            'Claim Reserved Amount',
            'Claim Diminishing Reserved Amount',
            'Total Amount Paid for Claim',
            'Benefit',
            'Claim Item Loss Date',
            'Claim item Finalized Date',
            'Claim Item Status',
            'Claimed Amount for Item',
            'Amount Paid for item'
          );
          fputcsv($fp, $headers);

          if (!empty($this->data['records'])) {
            foreach ($this->data['records'] as $value) {
              $diminishing = 0;
              if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
                $diminishing = $value['reserve_amount'] - $value['paied_amount'];
              }
              $province = empty($value['province']) ? '' : $value['province'];
              if (!empty($this->data['provinces'][$province])) {
                $province = $this->data['provinces'][$province];
              }
              $province = ucfirst(strtolower($province));
              $apply_date = empty($value['apply_date']) ? '' : substr($value['apply_date'], 0, 10);
              $effective_date = empty($value['effective_date']) ? '' : substr($value['effective_date'], 0, 10);
              $expiry_date = empty($value['expiry_date']) ? '' : substr($value['expiry_date'], 0, 10);
              $created = empty($value['created']) ? '' : substr($value['created'], 0, 10);
              $last_update = empty($value['last_update']) ? '' : substr($value['last_update'], 0, 10);
              $date_of_service = empty($value['date_of_service']) ? '' : substr($value['date_of_service'], 0, 10);
              $finalize_date = empty($value['finalize_date']) ? '' : substr($value['finalize_date'], 0, 10);

              $row = array(
                  empty($value['up_insuer']) ? '' : $value['up_insuer'],
                  $value['product_short'],
                  $apply_date,
                  $effective_date,
                  $expiry_date,
                  $value['insured_last_name'],
                  $value['insured_first_name'],
                  $value['policy_no'],
                  $province,
                  $value['claim_no'],
                  $created,
                  $last_update,
                  empty($value['status2']) ? '' : $value['status2'],
                  empty($value['status']) ? '' : $value['status'],
                  number_format($value['sum_insured'], 2, '.', ''),
                  number_format($value['claimed_amount'], 2, '.', ''),
                  number_format($value['reserve_amount'], 2, '.', ''),
                  number_format($diminishing, 2, '.', ''),
                  number_format($value['paied_amount'], 2, '.', ''),
                  empty($value['coverage_code']) ? '' : $value['coverage_code'],
                  $date_of_service,
                  $finalize_date,
                  empty($value['e_status']) ? '' : $value['e_status'],
                  number_format($value['amount_claimed'], 2, '.', ''),
                  number_format($value['amt_payable'], 2, '.', '')
              );
              fputcsv($fp, $row);
            }
          }
          fclose($fp);
          exit;
        } else {
          $objPHPExcel = new PHPExcel();
          $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
          $objPHPExcel->setActiveSheetIndex(0);
          $sheet = $objPHPExcel->getActiveSheet();
          $sheet->setTitle('Sheet1');
          $sheet->setCellValue('A1', 'Insurer');
          $sheet->setCellValue('B1', 'Product');
          $sheet->setCellValue('C1', 'Apply Date');
          $sheet->setCellValue('D1', 'Policy Start date');
          $sheet->setCellValue('E1', 'Policy End date');
          $sheet->setCellValue('F1', 'Last Name');
          $sheet->setCellValue('G1', 'First Name');
          $sheet->setCellValue('H1', 'Policy Number');
          $sheet->setCellValue('I1', 'Province');
          $sheet->setCellValue('J1', 'Claim number');
          $sheet->setCellValue('K1', 'Claim Start Date');
          $sheet->setCellValue('L1', 'Claim Close Date');
          $sheet->setCellValue('M1', 'Claim Status');
          $sheet->setCellValue('N1', 'Process Status');
          $sheet->setCellValue('O1', 'Sum Insured');
          $sheet->setCellValue('P1', 'Total Claimed Amount');
          $sheet->setCellValue('Q1', 'Claim Reserved Amount');
          $sheet->setCellValue('R1', 'Claim Diminishing Reserved Amount');
          $sheet->setCellValue('S1', 'Total Amount Paid for Claim');
          $sheet->setCellValue('T1', 'Benefit');
          $sheet->setCellValue('U1', 'Claim Item Loss Date');
          $sheet->setCellValue('V1', 'Claim item Finalized Date');
          $sheet->setCellValue('W1', 'Claim Item Status');
          $sheet->setCellValue('X1', 'Claimed Amount for Item');
          $sheet->setCellValue('Y1', 'Amount Paid for item');
          if (!empty($this->data['records'])) {
            $row = 2;
            foreach ($this->data['records'] as $value) {
              // $policy = json_decode($value["policy_info"], true);
              $diminishing = 0;
              if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
                $diminishing = $value['reserve_amount'] - $value['paied_amount'];
              }
              $incurred = $diminishing + $value['paied_amount'];
              $province = empty($value['province'])?"":$value['province'];
              if (!empty($this->data['provinces'][$province])) {
                $province = $this->data['provinces'][$province];
              }
              $province = ucfirst(strtolower($province));
              $sheet->setCellValue('A'.$row, empty($value['up_insuer'])?"":$value['up_insuer']);
              $sheet->setCellValue('B'.$row, $value['product_short']);
              $sheet->setCellValue('C'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['apply_date'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('D'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['effective_date'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('E'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['expiry_date'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('F'.$row, $value['insured_last_name']);
              $sheet->setCellValue('G'.$row, $value['insured_first_name']);
              $sheet->setCellValue('H'.$row, $value['policy_no']);
              $sheet->setCellValue('I'.$row, $province);
              $sheet->setCellValue('J'.$row, $value['claim_no']);
              $sheet->setCellValue('K'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['created'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('L'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['last_update'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('M'.$row, empty($value['status2'])?"":$value['status2']);
              $sheet->setCellValue('N'.$row, empty($value['status'])?"":$value['status']);
              $sheet->setCellValue('O'.$row, number_format($value['sum_insured'], 2));
              $sheet->setCellValue('P'.$row, number_format($value['claimed_amount'], 2));
              $sheet->setCellValue('Q'.$row, number_format($value['reserve_amount'], 2));
              $sheet->setCellValue('R'.$row, number_format($diminishing, 2));
              $sheet->setCellValue('S'.$row, number_format($value['paied_amount'], 2));
              $sheet->setCellValue('T'.$row, empty($value['coverage_code'])?"":$value['coverage_code']);
              $sheet->setCellValue('U'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['date_of_service'], 0, 10) . ' 00:00:00 EST')));
              $sheet->getStyle('U'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
              $sheet->setCellValue('V'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['finalize_date'], 0, 10) . ' 00:00:00 EST')));
              $sheet->setCellValue('W'.$row, empty($value['e_status'])?"":$value['e_status']);
              $sheet->setCellValue('X'.$row, number_format($value['amount_claimed'], 2));
              $sheet->setCellValue('Y'.$row, number_format($value['amt_payable'], 2));
              $row++;
            }
          }
          $objPHPExcel->setActiveSheetIndex(0);
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $filename = "report3_".date("Ymd_his").".xlsx";
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
          $this->data['yearlist'][$thisyear - $i] = $thisyear - $i;
        }
  
        $get["iscsv"] = 1;
        $this->data['export_url'] = site_url('report/claim_report3')."?".http_build_query($get);
        $this->data['current_url'] = site_url('report/claim_report3');

        $this->template->write_view('content', 'report/claim_report3', $this->data);
        $this->template->render();
      }
		}
	}
	
	// redirect if needed, otherwise display the products list
	public function report() {
    if ((php_sapi_name() !== 'cli')) {
      show_404();
		} else {
			$this->load->model('product_model');
			$this->load->model('claim_model');
			$this->load->model('province_model');
      
      $this->data['provinces'] = $this->province_model->get_list(1); // Canada only

      $get = array(
        "finalized_start_dt" => "2022-04-01",
        "finalized_end_dt" => "2024-09-30",
        "start_dt" => "",
        "end_dt" => "",
        "year" => "", // 2004
        "status2" => "",  // Open Reopen Closed Denied
        "up_insuer" => "Old Republic Insurance Company", // Berkley Canada, Allianz Global Assistance, Old Republic Insurance Company, United Health Care (UHC), N / A
      );
      $this->data['records'] = $this->claim_model->claim_report3($get);
      if (!empty($this->data['records'])) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle('Sheet1');
        $sheet->setCellValue('A1', 'Insurer');
        $sheet->setCellValue('B1', 'Product');
        $sheet->setCellValue('C1', 'Apply Date');
        $sheet->setCellValue('D1', 'Policy Start date');
        $sheet->setCellValue('E1', 'Policy End date');
        $sheet->setCellValue('F1', 'Last Name');
        $sheet->setCellValue('G1', 'First Name');
        $sheet->setCellValue('H1', 'Policy Number');
        $sheet->setCellValue('I1', 'Province');
        $sheet->setCellValue('J1', 'Claim number');
        $sheet->setCellValue('K1', 'Claim Start Date');
        $sheet->setCellValue('L1', 'Claim Close Date');
        $sheet->setCellValue('M1', 'Claim Status');
        $sheet->setCellValue('N1', 'Process Status');
        $sheet->setCellValue('O1', 'Sum Insured');
        $sheet->setCellValue('P1', 'Total Claimed Amount');
        $sheet->setCellValue('Q1', 'Claim Reserved Amount');
        $sheet->setCellValue('R1', 'Claim Diminishing Reserved Amount');
        $sheet->setCellValue('S1', 'Total Amount Paid for Claim');
        $sheet->setCellValue('T1', 'Benefit');
        $sheet->setCellValue('U1', 'Claim Item Loss Date');
        $sheet->setCellValue('V1', 'Claim item Finalized Date');
        $sheet->setCellValue('W1', 'Claim Item Status');
        $sheet->setCellValue('X1', 'Claimed Amount for Item');
        $sheet->setCellValue('Y1', 'Amount Paid for item');
        $row = 2;
        foreach ($this->data['records'] as $value) {
          // $policy = json_decode($value["policy_info"], true);
          $diminishing = 0;
          if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
            $diminishing = $value['reserve_amount'] - $value['paied_amount'];
          }
          $incurred = $diminishing + $value['paied_amount'];
          $province = empty($value['province'])?"":$value['province'];
          if (!empty($this->data['provinces'][$province])) {
            $province = $this->data['provinces'][$province];
          }
          $province = ucfirst(strtolower($province));
          $sheet->setCellValue('A'.$row, empty($value['up_insuer'])?"":$value['up_insuer']);
          $sheet->setCellValue('B'.$row, $value['product_short']);
          $sheet->setCellValue('C'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['apply_date'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('D'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['effective_date'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('E'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['expiry_date'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('F'.$row, $value['insured_last_name']);
          $sheet->setCellValue('G'.$row, $value['insured_first_name']);
          $sheet->setCellValue('H'.$row, $value['policy_no']);
          $sheet->setCellValue('I'.$row, $province);
          $sheet->setCellValue('J'.$row, $value['claim_no']);
          $sheet->setCellValue('K'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['created'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('L'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['last_update'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('M'.$row, empty($value['status2'])?"":$value['status2']);
          $sheet->setCellValue('N'.$row, empty($value['status'])?"":$value['status']);
          $sheet->setCellValue('O'.$row, number_format($value['sum_insured'], 2));
          $sheet->setCellValue('P'.$row, number_format($value['claimed_amount'], 2));
          $sheet->setCellValue('Q'.$row, number_format($value['reserve_amount'], 2));
          $sheet->setCellValue('R'.$row, number_format($diminishing, 2));
          $sheet->setCellValue('S'.$row, number_format($value['paied_amount'], 2));
          $sheet->setCellValue('T'.$row, empty($value['coverage_code'])?"":$value['coverage_code']);
          $sheet->setCellValue('U'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['date_of_service'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('U'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('V'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($value['finalize_date'], 0, 10) . ' 00:00:00 EST')));
          $sheet->getStyle('V'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
          $sheet->setCellValue('W'.$row, empty($value['e_status'])?"":$value['e_status']);
          $sheet->setCellValue('X'.$row, number_format($value['amount_claimed'], 2));
          $sheet->setCellValue('Y'.$row, number_format($value['amt_payable'], 2));
          $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filename = "/tmp/report3_".date("Ymd_his").".xlsx";
        $objWriter->save($filename);
        echo "Save to file: ".$filename."\n";
      } else {
        echo "No Data Record\n";
      }
		}
	}

  public function localexport() {
    $this->load->model('claim_model');
		$this->load->model('province_model');

    $get = [
      "finalized_start_dt" => "2026-10-01",
      "finalized_end_dt" => "2026-10-01",
      "start_dt" => "2026-10-01",
      "end_dt" => "2026-10-01",
      "year" => "2026",
      "status2" => "Reopen",
      "up_insuer" => "JES Up Insuer Company Inc.",
      "products" => ["JES","JFR"],
      "submit" => 1,
    ];
    $get = array();
    if (empty($get)) {
        die("Ignore");
    }
    $this->data['provinces'] = $this->province_model->get_list(1);
    $this->data['records'] = $this->claim_model->claim_report3($get);

    // Save to a local CSV file
    $filename = FCPATH . 'application/logs/local.csv';

    $fp = fopen($filename, 'w');

    if ($fp === false) {
        show_error('Cannot create local.csv file.');
        return;
    }

    // Add UTF-8 BOM for Excel compatibility
    fwrite($fp, "\xEF\xBB\xBF");

    // CSV header
    $headers = array(
        'Insurer',
        'Product',
        'Apply Date',
        'Policy Start date',
        'Policy End date',
        'Last Name',
        'First Name',
        'Policy Number',
        'Province',
        'Claim number',
        'Claim Start Date',
        'Claim Close Date',
        'Claim Status',
        'Process Status',
        'Sum Insured',
        'Total Claimed Amount',
        'Claim Reserved Amount',
        'Claim Diminishing Reserved Amount',
        'Total Amount Paid for Claim',
        'Benefit',
        'Claim Item Loss Date',
        'Claim item Finalized Date',
        'Claim Item Status',
        'Claimed Amount for Item',
        'Amount Paid for item'
    );

    fputcsv($fp, $headers);
    if (!empty($this->data['records'])) {
      foreach ($this->data['records'] as $value) {
        $diminishing = 0;
        if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) {
          $diminishing = $value['reserve_amount'] - $value['paied_amount'];
        }
        $province = empty($value['province']) ? '' : $value['province'];
        if (!empty($this->data['provinces'][$province])) {
          $province = $this->data['provinces'][$province];
        }
        $province = ucfirst(strtolower($province));
        $apply_date = empty($value['apply_date']) ? '' : substr($value['apply_date'], 0, 10);
        $effective_date = empty($value['effective_date']) ? '' : substr($value['effective_date'], 0, 10);
        $expiry_date = empty($value['expiry_date']) ? '' : substr($value['expiry_date'], 0, 10);
        $created = empty($value['created']) ? '' : substr($value['created'], 0, 10);
        $last_update = empty($value['last_update']) ? '' : substr($value['last_update'], 0, 10);
        $date_of_service = empty($value['date_of_service']) ? '' : substr($value['date_of_service'], 0, 10);
        $finalize_date = empty($value['finalize_date']) ? '' : substr($value['finalize_date'], 0, 10);
        $row = array(
          empty($value['up_insuer']) ? '' : $value['up_insuer'],
          $value['product_short'],
          $apply_date,
          $effective_date,
          $expiry_date,
          $value['insured_last_name'],
          $value['insured_first_name'],
          $value['policy_no'],
          $province,
          $value['claim_no'],
          $created,
          $last_update,
          empty($value['status2']) ? '' : $value['status2'],
          empty($value['status']) ? '' : $value['status'],
          number_format($value['sum_insured'], 2, '.', ''),
          number_format($value['claimed_amount'], 2, '.', ''),
          number_format($value['reserve_amount'], 2, '.', ''),
          number_format($diminishing, 2, '.', ''),
          number_format($value['paied_amount'], 2, '.', ''),
          empty($value['coverage_code']) ? '' : $value['coverage_code'],
          $date_of_service,
          $finalize_date,
          empty($value['e_status']) ? '' : $value['e_status'],
          number_format($value['amount_claimed'], 2, '.', ''),
          number_format($value['amt_payable'], 2, '.', '')
        );
        fputcsv($fp, $row);
      }
      fclose($fp);
      echo 'CSV file saved successfully: ' . $filename;
    }
  }
}
