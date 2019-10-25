<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cron extends CI_Controller {
	public $error;
	public $s3;
	
	private function valid() {
		$this->error = '';
		
		if ((php_sapi_name() === 'cli')) {
			return TRUE;
		}
		show_error("ERROR", 404);
	}
	
	public function index() {
		if ($this->valid()) {
			die("OK\n");
		} else {
			die($this->error . "\n");
		}
	}
	
	/*
	 * Daily job to save phone file
	 * 5 3 * * * (/usr/bin/php /var/claim/index.php cron save_to_s3) >> /home/ubuntu/s3.log 2>&1
	 */
	private function do_save_to_s3($date, $page) {
		$req = '/api/cdr/'.$date."?items=100&currentpage=".$page;
		$data = array();

		$rt = $this->phone_model->sendRequest($req, $data, 'GET');
		$cnt = 0;
		$calls = json_decode($rt, true);
		foreach ($calls['rows'] as $call) {
			$cnt++;
			if (!isset($call['recording_url'])) continue;
			$file = pathinfo($call['recording_url']);
			$filename = $file['basename'];
			$phone_id = $file['filename'];
			if ( ! $this->phone_model->phone_existed($phone_id)) {
				if ($this->phone_model->save_s3_file($call['recording_url'], $date."/".$filename)) {
					$para = array('phone_id' => $phone_id, 'src' => $call['recording_url'], 'dst' => $date."/".$filename);
					$this->phone_model->phone_cron_save($para);
					echo "Save file : " . $date. "/" . $filename . "\n";
					// Update local file name if is has
					if ($this->phone_model->update_file_url($call['recording_url'], base_url("phone/file/".$date."/".$filename))) {
						echo "Update database : " . base_url("phone/file/".$date."/".$filename) . "\n";
					}
				}
			}
		}
		return $cnt;
	}
	
	public function save_to_s3() {
		$this->valid();
		
		$this->load->model('phone_model');
	
		$today = date("Y-m-d");
		if ($last = $this->phone_model->get_last_cron()) {
			$dt = $last['dt'];
			$page = $last['page'];
		} else {
			$dt = $today;
			$page = 1;
		}
		do {
			$cnt = $this->do_save_to_s3($dt, $page);
			$page++;
		} while ($cnt == 100);
		if ($today != $dt) {
			$dt = $today;
			$page = 1;
			do {
				$cnt = $this->do_save_to_s3($dt, $page);
				$page++;
			} while ($cnt == 100);
		}
		$this->phone_model->set_last_cron($dt, $page - 1);
		
		// do saved file update again
		$this->phone_model->update_unupdated_url();
	}

	/*
	 * Hourly job to calculate stuff active
	 * 50 7,13,19 * * * (/usr/bin/php /var/claim/index.php cron schudule_phone) >> /home/ubuntu/s3.log 2>&1
	 */
	public function schudule_phone() {
		$this->valid();
		
		$day = date("Y-m-d");
		$hour = date("G") + 1;
		$sql = "SELECT * FROM schedule WHERE `date`='".$day."' AND shour='".$hour."'";
		$rt = $this->db->query($sql)->result_array();
		foreach ($rt as $rc) {
			// Unset same phone number
			$this->db->set('phone','');
			$this->db->where('phone',$rc['sphone']);
			$this->db->update('users');
			
			$this->db->set('phone',$rc['sphone']);
			$this->db->where('user_id',$rc['employee_id']);
			$this->db->update('users');
		}
	}

	private function get_phone_times($user_id, $day, $stm, $etm) {
		$sql = "SELECT direction, SUM(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as total FROM phone_records WHERE  user_id='".(int)$user_id."' AND answer>newcall AND newcall>=".$this->db->escape($stm)." AND newcall<=".$this->db->escape($etm)." GROUP BY direction";
		$rt = $this->db->query($sql)->result_array();
		$incall = 0;
		$outcall = 0;
		foreach ($rt as $rc) {
			if ($rc['direction'] == 'inbound') {
				$incall += $rc['total'];
			} else {
				$outcall += $rc['total'];
			}
		}
		$waiting = strtotime($etm) - strtotime($stm) + 1 - $incall - $outcall;
		$sql = "INSERT INTO phone_agent (user_id, dt, waiting, incall, outcall) VALUES ('".(int)$user_id."','".$day."','".(int)$waiting."','".(int)$incall."','".(int)$outcall."') ON DUPLICATE KEY UPDATE waiting=waiting+'".(int)$waiting."',incall=incall+'".(int)$incall."',outcall=outcall+'".(int)$outcall."'";
		$this->db->query($sql);
	}
	/*
	 * Hourly job to calculate stuff active
	 * 0 * * * * (/usr/bin/php /var/claim/index.php cron phone_agent) >> /home/ubuntu/s3.log 2>&1
	 */
	public function phone_agent() {
		$this->valid();
		$this->load->model('phone_model');
		
		$sql = "SELECT distinct user_id FROM phone_action WHERE processed=0";
		$users = $this->db->query($sql)->result_array();
		foreach ($users as $user_id) {
			$last_act = Phone_model::PHONE_OPT_LOGOUT;
			$last_tm = 0;
			$sql = "SELECT * FROM phone_action WHERE processed=1 AND user_id='".(int)$user_id."' ORDER BY phone_action_id DESC LIMIT 1";
			if ($last = $this->db->query($sql)->row_array()) {
				$last_act = $last['active'];
				$last_tm = $last['etm'];
			}
			
			$sql = "SELECT * FROM phone_action WHERE processed=0 AND user_id='".(int)$user_id."' ORDER BY phone_action_id ASC";
			$actions = $this->db->query($sql)->result_array();
			foreach ($actions as $act) {
				if ($act['active'] == Phone_model::PHONE_OPT_LOGIN) {
					// Not finished action, skip this user;
					$this->db->query("UPDATE phone_action SET processed=1 WHERE phone_action_id=".(int)$act['phone_action_id']);
					continue;
				}
				$lday = substr($last_tm, 0, 10);
				$sday = substr($act['stm'], 0, 10);
				if ($last_act != Phone_model::PHONE_OPT_LOGOUT) {
					if ($lday != $sday) {
						$seconds = (int)strtotime($lday." 23:59:59") - (int)strtotime($last_tm) + 1;
						if ($last_act == Phone_model::PHONE_OPT_PAUSE) {
							$sql = "INSERT INTO phone_agent (user_id, dt, pause) VALUES ('".(int)$user_id."','".$lday."','".(int)$seconds."') ON DUPLICATE KEY UPDATE pause=pause+'".(int)$seconds."'";
						} else if ($last_act == Phone_model::PHONE_OPT_BREAK) {
							$sql = "INSERT INTO phone_agent (user_id, dt, `break`) VALUES ('".(int)$user_id."','".$lday."','".(int)$seconds."') ON DUPLICATE KEY UPDATE `break`=`break`+'".(int)$seconds."'";
						}
						$this->db->query($sql);
						$last_tm = $sday." 00:00:00";
					}
					$seconds = (int)strtotime($act['stm']) - (int)strtotime($last_tm) + 1;
					if ($last_act == Phone_model::PHONE_OPT_PAUSE) {
						$sql = "INSERT INTO phone_agent (user_id, dt, pause) VALUES ('".(int)$user_id."','".$sday."','".(int)$seconds."') ON DUPLICATE KEY UPDATE pause=pause+'".(int)$seconds."'";
					} else if ($last_act == Phone_model::PHONE_OPT_BREAK) {
						$sql = "INSERT INTO phone_agent (user_id, dt, `break`) VALUES ('".(int)$user_id."','".$sday."','".(int)$seconds."') ON DUPLICATE KEY UPDATE `break`=`break`+'".(int)$seconds."'";
					}
					$this->db->query($sql);
				}
				$eday = substr($act['etm'], 0, 10);
				if ($sday == $eday) {
					$data = $this->get_phone_times($user_id, $sday, $act['stm'], $act['etm']);
				} else {
					$stm = $act['stm'];
					$etm = $sday . " 23:59:59";
					$data = $this->get_phone_times($user_id, $sday, $act['stm'], $sday . " 23:59:59");
					$data = $this->get_phone_times($user_id, $sday, $eday . " 00:00:00", $act['etm']);
				}
				$last_act = $act['active'];
				$last_tm = $act['etm'];
				$this->db->query("UPDATE phone_action SET processed=1 WHERE phone_action_id=".(int)$act['phone_action_id']);
			}
		}
	}
	
	const FTP_HOST="72.142.65.148";	// filetransfer.allianz-assistance.ca
	const FTP_PORT=22;
	const FTP_USER='JFInsurance';
	const FTP_PASS='jk5edQbl@vc';
	
	private function ftp($src, $dst) {
		$this->valid();
		$conn = ssh2_connect(self::FTP_HOST, self::FTP_PORT);
		if (!$conn) {
			echo "Can't open connect to ". self::FTP_HOST . " prot " . self::FTP_PORT . " at time " .date('Ymd His') . "\n";
			return FALSE;
		}
		$login_result = ssh2_auth_password($conn, self::FTP_USER, self::FTP_PASS);
	
		if (!$login_result) {
			echo "can't login at time " .date('Ymd His') . "\n";
			return FALSE;
		} else {
			echo "connected ";
			$resSFTP = ssh2_sftp($conn);
			$resFile = fopen("ssh2.sftp://".intval($resSFTP)."/".$dst, 'w');
			$srcFile = fopen($src, 'r');
			$writtenBytes = stream_copy_to_stream($srcFile, $resFile);
			echo " and send file: ".$dst." with ".$writtenBytes." bytes data at time " .date('Ymd His') . "\n";
			fclose($resFile);
			fclose($srcFile);
			//ssh2_exec($conn, 'exit');
			unset($conn);
		}
		return TRUE;
	}
	
	public function sftpupload() {
		$this->valid();
		set_time_limit(0);
		$this->load->model ( 'claim_model' );
		$this->load->model ( 'expenses_model' );

		$outdir = '/tmp/';
		$pattern = "/^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,}))(.*)$/";
	
		$para['start_dt'] = date('Y-m-01', strtotime('last month'));
		$para['end_dt'] = date('Y-m-t', strtotime('last month'));
		$filepre = date('Ym', strtotime('last month'));
		$para['product_short_group'] = array('OPL', 'JFC', 'REF');

		//$status_groups = array("Paid" => "Paid_Declined", "Unpaid" => "Received_Approved_Pending");
		$status_groups = array("Paid" => "Paid_Declined", "Unpaid" => "Pending");
		
		if (1) {
			foreach ($status_groups as $status_group => $filename) {
				$para['status_group'] = $status_group;
				// $para['product_short'] = $product;
				if ($status_group == 'Unpaid') {
					$para['start_dt'] = "2019-01-21";
				} else {
					$para['start_dt'] = date('Y-m-01', strtotime('last month'));
				}
				
				$records = $this->expenses_model->expense_report($para);
				//$uploadFilename = $filepre . "_" . $product . "_" . $filename . '.xlsx';
				//$uploadFilename = $filepre . "_" . $product . "_" . $filename . '.csv';
				$uploadFilename = $filepre . "_" . $filename . '.csv';
				$outfile = $outdir . $uploadFilename;
				
				$output = fopen($outfile, 'w');
				
				fputcsv($output, array(
						'Claim Item ID',
						'Claim Number',
						'Claim Type',
						'Status',
						'Policy Number',
						'Product',
						'Policy Date',
						'Agent ID ',
						'Coverage Code',
						'Entered Date',
						'Incident Date',
						'Incident Country ',
						'Payment Date/ Void Date',
						'Payee Name',
						'Payee Address',
						'Payee Country',
						'Payee Province',
						'Payee Type',
						'Provider Name',
						'Provider Address ',
						'Provider Country',
						'Provider Province',
						'Payment Method',
						'Cheque Number',
						'Total Claim Amount',
						'Discount Amount',
						'Denied Amount',
						'Deductible Amount',
						'Net Claim Paid amount',
						'Payment Currency',
						'Invoice Currency ',
						'Network Fees',
						'Network Provider',
						'Recovery Amount',
						'Void amount',
						'Void Reason ',
						'Deny Reason',
				));
				
				foreach ($records as $key => $value) {
					$paytype = 'cheque';
					if ($value['payeearr']) {
						$paytype = $value['payeearr']['payment_type'];
					} else {
						$payarr = preg_split("/:/", $value['pay_to']);
						if (is_array($payarr)) {
							$paytype = trim($payarr[0]);
						}
					}
					if ($value['status'] != 'Paid') {
						$paytype = '';
						$value['finalize_date'] = '';
						$amount_denide = '';
						$amt_payable = '';
					} else {
						$amount_denide = sprintf("%0.2f", $value['amount_claimed'] - $value['amt_payable']);
						$amt_payable = sprintf("%0.2f", $value['amt_payable']);
					}
					//$tarr = preg_split("/_/", $value['claim_item_no']);
					//if (is_array($tarr) && isset($tarr[1])) {
					//	$claim_item_no = $tarr[0].str_pad($tarr[1], 2, "0", STR_PAD_LEFT);
					//} else {
					//	$claim_item_no = $value['claim_item_no'];
					//}
				
					fputcsv($output, array(
							$value['id'],
							$value['claim_no'],
							$value['claim']['exinfo_type'],
							$value['status'],
							$value['claim']['policy_no'],
							$value['claim']['product_short'],
							$value['claim']['apply_date'],
							$value['claim']['agent_id'],
							$value['coverage_code'],
							substr($value['created'], 0, 10),
							$value['date_of_service'],
							'N/A', /* echo $value['claim']['country_symptoms']; /*Incident Country XXXXXXXXXXXXXXXXXXXXX no input place */
							$value['finalize_date'],
							($value['payeearr'] ? $value['payeearr']['payee_name'] : ''),
							($value['payeearr'] ? $value['payeearr']['address'] : ''),
							($value['payeearr'] ? $value['payeearr']['country'] : ''),
							($value['payeearr'] ? $value['payeearr']['province'] : ''),
							($value['third_party_payee'] ? 'Business' : 'Private'),
				
							isset($value['provider']['name']) ? $value['provider']['name'] : '',
							isset($value['provider']['address']) ? $value['provider']['address'] : '',
							isset($value['provider']['country']) ? $value['provider']['country'] : '',
							isset($value['provider']['province']) ? $value['provider']['province'] : '',
							$paytype,
							$value['cheque'],
				
							sprintf("%0.2f", $value['amount_claimed']),
							sprintf("%0.2f", 0),
							$amount_denide,
							sprintf("%0.2f", $value['amt_deductible']),
							$amt_payable,
							'CAD',
							empty($value['currency']) ? 'CAD' : $value['currency'],
							sprintf("%0.2f", ($value['provider_type'] ? $value['provider']['network_fee'] : 0)),
							isset($value['provider']['name']) ? $value['provider']['name'] : '',
							sprintf("%0.2f", $value['recovery_amt']),
							($value['status'] != Expenses_model::EXPENSE_STATUS_Duplicated) ? "0.00" : sprintf("%0.2f", $value['amount_claimed']),
							$value['reason'],
							$value['reason_other'],
					));
				}
				fputcsv($output, array(''));
				fclose($output);
				
				/*
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
				
				// Set document properties
				$objPHPExcel->getProperties()->setCreator("AuroraTech Inc.")
							->setLastModifiedBy("Jack Wu")
							->setTitle("Office Document")
							->setSubject("Office Document")
							->setDescription("Generated using PHP classes.")
							->setKeywords("php")
							->setCategory("result file");
				$objPHPExcel->setActiveSheetIndex(0);
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setTitle('Sheet1');
				$sheet->setCellValue('A1', 'Claim Item Number');
				$sheet->setCellValue('B1', 'Claim Number');
				$sheet->setCellValue('C1', 'Claim Type');
				$sheet->setCellValue('D1', 'Status');
				$sheet->setCellValue('E1', 'Policy Number');
				$sheet->setCellValue('F1', 'Policy Number');
				$sheet->setCellValue('G1', 'Policy Date');
				$sheet->setCellValue('H1', 'Agent ID');
				$sheet->setCellValue('I1', 'Coverage Code');
				$sheet->setCellValue('J1', 'Entered Date');
				$sheet->setCellValue('K1', 'Incident Date');
				$sheet->setCellValue('L1', 'Incident Country');
				$sheet->setCellValue('M1', 'Payment Date/ Void Date');
				$sheet->setCellValue('N1', 'Payee Name');
				$sheet->setCellValue('O1', 'Payee Address');
				$sheet->setCellValue('P1', 'Payee Country');
				$sheet->setCellValue('Q1', 'Payee Province');
				$sheet->setCellValue('R1', 'Payee Type');
				$sheet->setCellValue('S1', 'Provider Name');
				$sheet->setCellValue('T1', 'Provider Address');
				$sheet->setCellValue('U1', 'Provider Country');
				$sheet->setCellValue('V1', 'Provider Province');
				$sheet->setCellValue('W1', 'Payment Method');
				$sheet->setCellValue('X1', 'Cheque Number');
				$sheet->setCellValue('Y1', 'Total Claim Amount');
				$sheet->setCellValue('Z1', 'Discount Amount');
				$sheet->setCellValue('AA1', 'Denied Amount');
				$sheet->setCellValue('AB1', 'Deductible Amount');
				$sheet->setCellValue('AC1', 'Net Claim Paid amount');
				$sheet->setCellValue('AD1', 'Payment Currency');
				$sheet->setCellValue('AE1', 'Invoice Currency');
				$sheet->setCellValue('AF1', 'Network Fees');
				$sheet->setCellValue('AG1', 'Network Provider');
				$sheet->setCellValue('AH1', 'Recovery Amount');
				$sheet->setCellValue('AI1', 'Void amount');
				$sheet->setCellValue('AJ1', 'Void Reason');
				$sheet->setCellValue('AK1', 'Deny Reason');
				
				$row = 2;
				foreach ($records as $value) {
					$paytype = 'cheque';
					if ($value['payeearr']) {
						$paytype = $value['payeearr']['payment_type'];
					} else {
						$payarr = preg_split("/:/", $value['pay_to']);
						if (is_array($payarr)) {
							$paytype = trim($payarr[0]);
						}
					}
					if ($value['status'] != 'Paid') $paytype = '';
					$tarr = preg_split("/_/", $value['claim_item_no']);
					if (is_array($tarr) && isset($tarr[1])) {
						$claim_item_no = $tarr[0].str_pad($tarr[1], 2, "0", STR_PAD_LEFT);
					} else {
						$claim_item_no = $value['claim_item_no'];
					}
					$sheet->setCellValue('A'.$row, $claim_item_no);
					$sheet->setCellValue('B'.$row, $value['claim_no']);
					$sheet->setCellValue('C'.$row, $value['claim']['exinfo_type']);
					$sheet->setCellValue('D'.$row, $value['status']);
					$sheet->setCellValue('E'.$row, $value['claim']['policy_no']);
					$sheet->setCellValue('F'.$row, $value['claim']['product_short']);
					$sheet->setCellValue('G'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime($value['claim']['apply_date'] . ' 00:00:00 UTC')));
					$sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode('yyyy-d-m');
					$sheet->setCellValue('H'.$row, $value['claim']['agent_id']);
					$sheet->setCellValue('I'.$row, $value['coverage_code']);
					$sheet->setCellValue('J'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime($value['created'] . ' UTC')));
					$sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode('yyyy-d-m');
					$sheet->setCellValue('K'.$row, $value['date_of_service']);
					$sheet->setCellValue('L'.$row, 'N/A');
					$sheet->setCellValue('M'.$row, PHPExcel_Shared_Date::PHPToExcel(strtotime($value['finalize_date'] . ' UTC')));
					$sheet->getStyle('M'.$row)->getNumberFormat()->setFormatCode('yyyy-d-m');
					$sheet->setCellValue('N'.$row, ($value['payeearr'] ? $value['payeearr']['payee_name'] : ''));
					$sheet->setCellValue('O'.$row, ($value['payeearr'] ? $value['payeearr']['address'] : ''));
					$sheet->setCellValue('P'.$row, ($value['payeearr'] ? $value['payeearr']['country'] : ''));
					$sheet->setCellValue('Q'.$row, ($value['payeearr'] ? $value['payeearr']['province'] : ''));
					$sheet->setCellValue('R'.$row, ($value['third_party_payee'] ? 'Business' : 'Private'));
					$sheet->setCellValue('S'.$row, isset($value['provider']['name']) ? $value['provider']['name'] : '');
					$sheet->setCellValue('T'.$row, isset($value['provider']['address']) ? $value['provider']['address'] : '');
					$sheet->setCellValue('U'.$row, isset($value['provider']['country']) ? $value['provider']['country'] : '');
					$sheet->setCellValue('V'.$row, isset($value['provider']['province']) ? $value['provider']['province'] : '');
					$sheet->setCellValue('W'.$row, $paytype);
					$sheet->setCellValue('X'.$row, $value['cheque']);
					$sheet->setCellValue('Y'.$row, sprintf("%0.2f", $value['amount_claimed']));
					$sheet->setCellValue('Z'.$row, sprintf("%0.2f", 0));
					$sheet->setCellValue('AA'.$row, sprintf("%0.2f", $value['amount_claimed'] - $value['amt_payable']));
					$sheet->setCellValue('AB'.$row, sprintf("%0.2f", $value['amt_deductible']));
					$sheet->setCellValue('AC'.$row, sprintf("%0.2f", $value['amt_payable']));
					$sheet->setCellValue('AD'.$row, 'CAD');
					$sheet->setCellValue('AE'.$row, empty($value['currency']) ? 'CAD' : $value['currency']);
					$sheet->setCellValue('AF'.$row, sprintf("%0.2f", ($value['provider_type'] ? $value['provider']['network_fee'] : 0)));
					$sheet->setCellValue('AG'.$row, isset($value['provider']['name']) ? $value['provider']['name'] : '');
					$sheet->setCellValue('AH'.$row, sprintf("%0.2f", $value['recovery_amt']));
					$sheet->setCellValue('AI'.$row, ($value['status'] != Expenses_model::EXPENSE_STATUS_Duplicated) ? "0.00" : sprintf("%0.2f", $value['amount_claimed']));
					$sheet->setCellValue('AJ'.$row, $value['reason']);
					$sheet->setCellValue('AK'.$row, $value['reason_other']);
					$row++;
				}
				
				$objPHPExcel->setActiveSheetIndex(0);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($outfile);
				*/
				echo "Save to : " . $outfile . "\n";
				$uploaded = FALSE;
				for ($i = 0; $i < 5; $i++) {
					$uploaded = $this->ftp($outfile, $uploadFilename);
					if ($uploaded) {
						// unlink($outfile);
						break;
					}
					sleep(60); // wait 1 minute too retry
				}
				if (!$uploaded) {
					$this->load->model("mymail_model");
					$this->mymail_model->send_mymail('wqjyhggg@gmail.com', 'JF upload error', "File: " . $outfile);
					$this->mymail_model->send_mymail('cosmo@jfgroup.ca', 'JF upload error', "File: " . $outfile, array($outfile));
				}
			}
		}
	}
	
	public function test() {
		$this->valid();
		$this->load->model('phone_model');
		
		$req = "/api/sms/send/16479532665/14167106618";
		$para = array('text' => 'test 他们');
		$rt = $this->phone_model->sendRequest($req, $para);
		$data = json_decode($rt, true);
		print_r($data); //XXXXXXXXXXX
	}
}
