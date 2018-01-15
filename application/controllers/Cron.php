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
	public function save_to_s3() {
		$this->valid();
		
		$this->load->model('phone_model');
	
		$date = date("Y-m-d", time() - 43200);
		$req = '/api/cdr/'.$date;
		$data = array();
		$rt = $this->phone_model->sendRequest($req, $data, 'GET');
		
		$calls = json_decode($rt, true);
		foreach ($calls['rows'] as $call) {
			if (!isset($call['recording_url'])) continue;
			$filename = basename($call['recording_url']);
			if ($this->phone_model->save_s3_file($call['recording_url'], $date."/".$filename)) {
				echo "Save file : " . $date. "/" . $filename . "\n";
				// Update local file name if is has
				if ($this->phone_model->update_file_url($call['recording_url'], base_url("phone/file/".$date."/".$filename))) {
					echo "Update database : " . base_url("phone/file/".$date."/".$filename) . "\n";
				}
			}
		}
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
}
