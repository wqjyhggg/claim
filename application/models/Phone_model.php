<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author jackw
 *        
 */
class Phone_model extends CI_Model {
	/* test 
	const PHONE_KEY = '6bd7053312e9927c61ff57dd8202ba6c';
	const PHONE_URL = 'http://portal.aurat.genvoice.net';
	/* JF */
	const PHONE_KEY = 'a72e4f38c69af9ae20c95e9067099044';
	const PHONE_URL = 'http://api.jfgroup.genvoice.net';
	/**/
	
	const S3_BUCKET = "jfphone";
	const S3_VERSION = "latest";
	const S3_REGION = "us-east-1";
	const S3_KEY = 'AKIAJ7FQ5V6JIR23XSPA';
	const S3_SECRET = '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';

	const PHONE_OPT_LOGIN = 'Login';
	const PHONE_OPT_LOGOUT = 'Logout';
	const PHONE_OPT_BREAK = 'Break';
	const PHONE_OPT_PAUSE = 'ACW';
	
	const PHONE_STATUS_OFFLINE = 'Offline';
	const PHONE_STATUS_ONLINE = 'Online';
	const PHONE_STATUS_RING = 'Ring';
	const PHONE_STATUS_TALKING = 'Talking';
	
	public $portt = 8080;
	const SERVER_STR = 'phoneQ';
	
	private $phone_numbers = array('101','102','103','104','105','106','107','108','109');
	
	public function sendRequest($req, $data, $method = "POST") {
		$http_header = array (
				'x-app-key:' . self::PHONE_KEY ,
				'content-type: application/json'
		);
		$url = self::PHONE_URL . $req;
		$postdata = json_encode($data);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if ($method == 'POST') {
			curl_setopt($curl, CURLOPT_POST, true);
		} else if ($method == 'DELETE') {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		} else if ($method == 'PUT') {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		if ($method != 'GET') {
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		}
		
		$response = curl_exec($curl);
		// print_r(curl_getinfo($curl));
		curl_close($curl);
		return $response;
	}

	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('phone_call')->row_array();
	}

	public function agent_logout($agent) {
		// Force finish unlogout user
		$this->db->set('etm', 'NOW()', FALSE);
		$this->db->set('slength', 'TIME_TO_SEC(TIMEDIFF(NOW(), stm))', FALSE);
		$this->db->set('active', self::PHONE_OPT_LOGOUT);
		$this->db->where('agent', $agent);
		$this->db->where('active', self::PHONE_OPT_LOGIN);
		$this->db->update('phone_action');
	}

	public function insert_action($agent, $status) {
		$this->agent_logout($agent);
		
		$data['agent'] = $agent;
		$data['active'] = $status;
		$data['user_id'] = $this->ion_auth->get_user_id();
		$this->db->insert('phone_action', $data);
	}

	public function update_action($agent, $status) {
		// Force finish unlogout user
		$this->db->set('etm', 'NOW()', FALSE);
		$this->db->set('slength', 'TIME_TO_SEC(TIMEDIFF(NOW(), stm))', FALSE);
		$this->db->set('active', $status);
		$this->db->where('agent', $agent);
		$this->db->where('user_id', $this->ion_auth->get_user_id());
		$this->db->where('active', self::PHONE_OPT_LOGIN);
		$this->db->update('phone_action');
	}

	public function get_active_user_id($agent) {
		$sql = "SELECT * FROM phone_action WHERE agent=" . $this->db->escape($agent) . " AND active='".self::PHONE_OPT_LOGIN."' ORDER BY phone_action_id DESC LIMIT 1";
		if ($rt = $this->db->query($sql)->row_array()) {
			return $rt['user_id'];
		}
		return 0;
	}

	public function set_phone_login($phoneid, $status) {
		$req = "/api/agent/".$phoneid."/status";
		$para = array('login' => $status);
		$rt = $this->sendRequest($req, $para, 'PUT');
		$data = json_decode($rt, true);
	}

	public function do_phone_opt($status) {
		$phoneid = $this->users_model->get_user_phoneid();
		if ($phoneid) {
			switch ($status) {
				case self::PHONE_OPT_LOGIN:
					$this->insert_action($phoneid, $status);
					$this->set_phone_login($phoneid, true);
					return 'OK';
					break;
				case self::PHONE_OPT_BREAK:
				case self::PHONE_OPT_LOGOUT:
				case self::PHONE_OPT_PAUSE:
					$this->update_action($phoneid, $status);
					$this->set_phone_login($phoneid, false);
					return 'OK';
					break;
			}
		}
		return "NO";
	}
	
	
	public function get_phone_login($phoneid) {
		$phoneid = $this->users_model->get_user_phoneid();
		$req = "/api/agent/".$phoneid."/status";
		
		$para = array();
		$rt = $this->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);

		if (isset($data['logged_in'])) {
			// Phone is in queue, check and close if last login agent is different
			$sql = "SELECT * FROM phone_action WHERE agent=" . $this->db->escape($phoneid) . " AND active='".self::PHONE_OPT_LOGIN."' AND user_id!='".(int)$this->ion_auth->get_user_id()."'";
			$rt = $this->db->query($sql)->row_array();
			if ($rt) {
				// There is someone login already, so show user isn't login 
				return false;
			}
			
			return $data['logged_in'];
		}
		return false;
	}

	public function get_current_queue($phoneid) {
		//$sql = "SELECT * FROM phone_ring WHERE agent=".$this->db->escape($phoneid)." AND TIME_TO_SEC(TIMEDIFF(now(), event_tm))<120 ORDER BY event_tm DESC limit 1";
		$sql = "SELECT * FROM phone_ring WHERE agent=".$this->db->escape($phoneid)." ORDER BY event_tm DESC limit 1";
		if ($rc = $this->db->query($sql)->row_array()) {
			$phone_id = $rc['phone_id'];
			$sql = "SELECT * FROM phone_ring WHERE phone_id=".$this->db->escape($phone_id)." ORDER BY event_tm DESC limit 1";
			if ($rc1 = $this->db->query($sql)->row_array()) {
				if ($rc1['agent'] == $rc['agent']) {
					$sql = "SELECT * FROM phone_records WHERE phone_id=".$this->db->escape($phone_id)." AND newcall>hangup ORDER BY newcall DESC limit 1";
					if ($rc2 = $this->db->query($sql)->row_array()) {
						return $rc['queue'];
					}
				}
			}
		}
		return '';
	}

	public function get_current_status($phoneid) {
		$req = "/api/agent/".$phoneid."/status";
		
		$para = array();
		$rt = $this->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);
		
		$result = array('status' => self::PHONE_STATUS_OFFLINE, 'queue' => '');

		if (!empty($data['logged_in'])) {
			$result['status'] = self::PHONE_STATUS_ONLINE;
			$sql = "SELECT * FROM phone_records WHERE agent=".$this->db->escape($phoneid)." AND hangup<answer AND newcall<answer ORDER BY newcall DESC limit 1";
			if ($rc = $this->db->query($sql)->row_array()) {
				$result['status'] = self::PHONE_STATUS_TALKING;
				$result['queue'] = $rc['queue'];
			} else {
				//$sql = "SELECT * FROM phone_ring WHERE agent=".$this->db->escape($phoneid)." AND TIME_TO_SEC(TIMEDIFF(now(), event_tm))<120 ORDER BY event_tm DESC limit 1";
				$sql = "SELECT * FROM phone_ring WHERE agent=".$this->db->escape($phoneid)." ORDER BY event_tm DESC limit 1";
				if ($rc = $this->db->query($sql)->row_array()) {
					$phone_id = $rc['phone_id'];
					$sql = "SELECT * FROM phone_ring WHERE phone_id=".$this->db->escape($phone_id)." ORDER BY event_tm DESC limit 1";
					if ($rc1 = $this->db->query($sql)->row_array()) {
						if ($rc1['agent'] == $rc['agent']) {
							$sql = "SELECT * FROM phone_records WHERE phone_id=".$this->db->escape($phone_id)." AND newcall>answer AND newcall>hangup ORDER BY newcall DESC limit 1";
							if ($rc2 = $this->db->query($sql)->row_array()) {
								$result['status'] = self::PHONE_STATUS_RING;
								$result['queue'] = $rc['queue'];
							}
						}
					}
				}
			}
		}
		return $result;
	}

	public function get_queue_count($qname) {
		$sql = "SELECT COUNT(*) as cnt FROM phone_ring WHERE TIME_TO_SEC(TIMEDIFF(now(), event_tm))<='5' AND queue=".$this->db->escape($qname);
		if ($rc = $this->db->query($sql)->row_array()) {
			return $rc['cnt'];
		}
		return 0;
	}
	
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$cur = $this->get_by_id($id);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('phone_call', $data);
				$this->active_model->log_update('phone_call', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			// insert
			$this->db->insert('phone_call', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('phone_call', $id, $data, $sql);
			return $id;
		}
	}

	public function save_callback_ringing($data, $isdebug=FALSE) {
		/* {
		    "account": "demo",
		    "agent": "rcp1",
		    "caller_id_name": "Demo",
		    "caller_id_number": "16471230000",
		    "destination_number": "16471234567",
		    "event": "Ringing",
		    "event_time": "2017-03-23T21:50:20Z",
		    "id": "c6537a05-71ea-4572-8bb1-790518268fdf",
		    "queue": "receptionists",
		    "start_time": "2017-03-23T21:50:21Z"
		} */
		if (!$isdebug) {
			$this->save(array('data' => $data));
		}
		$para = array();
		$json = json_decode($data, true);
		if (empty($json['id']) || ($json["direction"] != "inbound")) return NULL;

		$para['id'] = $json['id'];
		if (empty($json['event']) || ($json['event'] != 'Ringing')) return NULL;
		
		$event_time = $json['event_time'];
		if (is_numeric($event_time)) {
			$tm = $event_time / 1000;
		} else {
			$tm = strtotime($event_time);
		}
		$user_id = 0;
		if (!empty($json['agent'])) {
			$user_id = $this->get_active_user_id($json['agent']);
		}
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$sql = "SELECT * FROM phone_ring WHERE phone_id=".$this->db->escape($json['id'])." ORDER BY event_tm DESC LIMIT 1";
		$lastRing = $this->db->query($sql)->row_array();
		$sql = "INSERT into phone_ring (phone_id, caller_id_number, agent, queue, user_id, event_tm) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape($json['agent']).", ".$this->db->escape($json['queue']).", '".(int)$user_id."', ".$this->db->escape(date("Y-m-d H:i:s", $tm)).")";
		$this->db->query($sql);
		// $id = $this->db->insert_id();
		if ($lastRing) {
			$this->sendRingQueue($lastRing['agent'], '-'); // Remove last phone Quese display
		}
		$this->sendRingQueue($json['agent'], $json['queue']); // phone Quese display
		return TRUE;
	}

	public function save_callback_enterqueue($data, $isdebug=FALSE) {
		/* {
		    "account": "demo",
		    "caller_id_name": "Demo",
		    "caller_id_number": "16471230000",
		    "destination_number": "16471234567",
		    "event": "EnterQueue",
		    "event_time": "2017-03-23T21:47:07Z",
		    "id": "4b847e58-2324-4f1c-8385-754769c46b1c",
		    "queue": "receptionists",
		    "start_time": "2017-03-23T21:47:07Z"
		} */
		if (!$isdebug) {
			$this->save(array('data' => $data));
		}
		$para = array();
		$json = json_decode($data, true);
		if (empty($json['id'])) return NULL;
		$para['id'] = $json['id'];
		if (empty($json['event']) || ($json['event'] != 'EnterQueue')) return NULL;
		
		$event_time = $json['event_time'];
		if (is_numeric($event_time)) {
			$tm = $event_time / 1000;
		} else {
			$tm = strtotime($event_time);
		}
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$sql = "INSERT into phone_records (phone_id, direction, caller_id_number, queue, event_tm) values (".$this->db->escape($json['id']).", ".$this->db->escape('inbound').", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape($json['queue']).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE queue=".$this->db->escape($json['queue']).", event_tm=".$this->db->escape(date("Y-m-d H:i:s", $tm));
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function save_callback_newcall($data, $isdebug=FALSE) {
		/* {
			"account":"aurat",
			"caller_id_name":"4167106618",
			"caller_id_number":"4167106618",
			"destination_number":"19054756656",
			"direction":"inbound",
			"event":"NewCall",
			"event_time":1511205004437,
			"fs_node":"fs4.internal",
			"id":"33340e2e-a4da-4f59-85e4-55e3f4b0f66c",
			"start_time":1511205004437}
		} */
		if (!$isdebug) {
			$this->save(array('data' => $data));
		}
		$para = array();
		$json = json_decode($data, true);
		if (empty($json['id'])) return NULL;
		$para['id'] = $json['id'];
		if (empty($json['event']) || ($json['event'] != 'NewCall')) return NULL;
		
		$event_time = $json['event_time'];
		if (is_numeric($event_time)) {
			$tm = $event_time / 1000;
		} else {
			$tm = strtotime($event_time);
		}
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$sql = "INSERT into phone_records (phone_id, direction, caller_id_number, newcall) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['direction']).", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE newcall=".$this->db->escape(date("Y-m-d H:i:s", $tm));
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function save_callback_answer($data, $isdebug=FALSE) {
		/* {
			"account":"aurat",
			"agent":"test1",
			"caller_id_name":"4167106618",
			"caller_id_number":"4167106618",
			"destination_number":"19054756656",
			"direction":"inbound",
			"event":"Answer",
			"event_time":"2017-11-20T19:10:36Z",
			"id":"33340e2e-a4da-4f59-85e4-55e3f4b0f66c",
			"queue":"jf",
			"start_time":"2017-11-20T19:10:04Z"
		} */
		if (!$isdebug) {
			$this->save(array('data' => $data));
		}
		$para = array();
		$json = json_decode($data, true);
		if (empty($json['id'])) return NULL;
		$para['id'] = $json['id'];
		if (empty($json['event']) || ($json['event'] != 'Answer')) return NULL;
		
		$event_time = $json['event_time'];
		if (is_numeric($event_time)) {
			$tm = $event_time / 1000;
		} else {
			$tm = strtotime($event_time);
		}
		$user_id = 0;
		if (!empty($json['agent'])) {
			$user_id = $this->get_active_user_id($json['agent']);
		}
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$sql = "INSERT into phone_records (phone_id, direction, agent, user_id, caller_id_number, newcall, answer) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['direction']).", ".$this->db->escape($json['agent']).", '".(int)$user_id."', ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($json['start_time']))).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE answer=".$this->db->escape(date("Y-m-d H:i:s", $tm)).", user_id='".(int)$user_id."', agent=".$this->db->escape($json['agent']);
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function save_callback_hangup($data, $isdebug=FALSE) {
		/* {
			"account":"aurat",
			"agent":"test1",
			"caller_id_name":"4167106618",
			"caller_id_number":"4167106618",
			"destination_number":"19054756656",
			"direction":"inbound",
			"end_time":"2017-11-20T19:10:47Z",
			"event":"Hangup",
			"event_time":"2017-11-20T19:10:47Z",
			"id":"33340e2e-a4da-4f59-85e4-55e3f4b0f66c",
			"queue":"jf",
			"start_time":"2017-11-20T19:10:04Z"
		} */
		if (!$isdebug) {
			$this->save(array('data' => $data));
		}
		$para = array();
		$json = json_decode($data, true);
		if (empty($json['id'])) return NULL;
		$para['id'] = $json['id'];
		if (empty($json['event']) || ($json['event'] != 'Hangup')) return NULL;
		
		$event_time = $json['event_time'];
		if (is_numeric($event_time)) {
			$tm = $event_time / 1000;
		} else {
			$tm = strtotime($event_time);
		}
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$id = isset($json['id']) ? $json['id'] : '';
		$direction = isset($json['direction']) ? $json['direction'] : '';
		$agent = isset($json['agent']) ? $json['agent'] : '';
		$caller_id_number = isset($json['caller_id_number']) ? $json['caller_id_number'] : '';
		$start_time = isset($json['start_time']) ? $json['start_time'] : '';
		$user_id = 0;
		if (!empty($json['agent'])) {
			$user_id = $this->get_active_user_id($json['agent']);
		}
		
		$sql = "INSERT into phone_records (phone_id, direction, agent, user_id, caller_id_number, newcall, answer, hangup) values (".$this->db->escape($id).", ".$this->db->escape($direction).", ".$this->db->escape($agent).", '".(int)$user_id."', ".$this->db->escape($caller_id_number).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($start_time))).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($start_time))).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE hangup=".$this->db->escape(date("Y-m-d H:i:s", $tm)).", user_id='".(int)$user_id."', agent=".$this->db->escape($agent);
		$this->db->query($sql);
		return $this->db->insert_id();
	}
	
	public function getmyurl() {
		$name = $this->ion_auth->get_user_info('phone');
		if ($name) {
			$sql = "SELECT * FROM phone_records WHERE agent=".$this->db->escape($name)." ORDER BY hangup DESC LIMIT 1";
			$rc = $this->db->query($sql)->row_array();
			
			if ($rc) {
				$reqArr = array('/api/cdr/'.date("Y-m-d"), '/api/cdr/'.date("Y-m-d", time() - 86400));
				$data = array();
				foreach ($reqArr as $req) {
					$rt = $this->phone_model->sendRequest($req, $data, 'GET');
				
					$list = json_decode($rt, true);
					if ($list) {
						foreach ($list['rows'] as $row) {
							if (isset($row['recording_url']) && (strpos($row['recording_url'], $rc['phone_id']) > 0)) {
								$rc['url'] = $row['recording_url'];
								return $rc;
							}
						}
					}
				}
			}
		}
		return array();
	}
	
	public function get_working_number() {
		return $this->phone_numbers;
	}
	
	public function get_today_list() {
		$phonenumber = $this->ion_auth->get_user_info('phone');
		
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) {
			if ( ! $phonenumber ) {
				return array();
			}
			$this->db->where('agent', $phonenumber);
		} else {
			$this->db->where_in('agent', $this->phone_numbers);
			$this->db->where('TIME_TO_SEC(TIMEDIFF(now(), newcall))<', 3600*24);
		}
//		$this->db->where_in('queue', array('English','Chinese'));
		$this->db->order_by('newcall', 'DESC');
		
		$rc = $this->db->get('phone_records')->result_array();

		$rarr = array();
		if ($rc) {
			$reqArr = array('/api/cdr/'.date("Y-m-d"), '/api/cdr/'.date("Y-m-d", time() - 86400));
			$data = array();
			foreach ($reqArr as $req) {
				$rt = $this->phone_model->sendRequest($req, $data, 'GET');
			
				$list = json_decode($rt, true);
				if ($list) {
					foreach ($list['rows'] as $key => $row) {
						foreach ($rc as $phonekey => $phonert) {
							if (isset($row['recording_url']) && (strpos($row['recording_url'], $phonert['phone_id']) > 0)) {
								$row['agent'] = $phonert['agent'];
								$row['queue'] = $phonert['queue'];
								$rarr[] = $row;
								unset($rc[$phonekey]);
								break;
							}
						}
					}
				}
			}
		}
		return $rarr;
	}
	
	public function search($data, $limit=-1, $offset=-1) {
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->where($data);
		if ($offset > 0) {
			$this->db->limit($limit, $offset);
		} else if ($limit > 0) {
			$this->db->limit($limit);
		}
		return $this->db->get('phone_records')->result_array();
	}
	
	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as rows")->row()->rows;
	}
	
	private function connect_s3() {
		return new Aws\S3\S3Client(array (
				'version' => self::S3_VERSION,
				'region' => self::S3_REGION,
				'credentials' => array (
						'key' => self::S3_KEY,
						'secret' => self::S3_SECRET
				)
		));
	}
	
	public function update_file_url($url, $newurl) {
		$this->db->where(array('phonefile' => $url));
		$total = 0;
		if ($rt = $this->db->get('intake_form')->result_array()) {
			foreach ($rt as $rc) {
				$this->db->set('phonefile', $newurl);
				$this->db->where('id', $rc['id']);
				$this->db->update('ntake_form');
				$total++;
			}
		}
		return $total;
	}
	
	public function save_s3_file($url, $key) {
		$s3 = $this->connect_s3();
		
		try{
			$data = file_get_contents($url);
			
			$result = $s3->putObject([
					'Bucket'     => self::S3_BUCKET,
					'Key'        => $key,
					'Body'       => $data,
			]);
			
			return true;

		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
			return false;
		}
	}

	public function get_s3_file($key) {
		$s3 = $this->connect_s3();
		
		try{
			return ($s3->getObject([
					'Bucket'     => self::S3_BUCKET,
					'Key'        => $key,
			]));
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
			return false;
		}
	}
	
	public function get_queue_list() {
		$sql = "SELECT DISTINCT queue FROM phone_records ORDER by queue ASC";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_time_index($type, $start_dt, $end_dt) {
		$s_tm = strtotime($start_dt);
		$e_tm = strtotime($end_dt);
		if ($s_tm > $e_tm) {
			return array();
		}
		
		$st = new DateTime($start_dt);
		$et = new DateTime($end_dt);
		switch ($type) {
			case 'month': $interval = new DateInterval('P1M'); $dtformat="Y-m"; break;
			case 'day': $interval = new DateInterval('P1D'); $dtformat="Y-m-d"; break;
			default: return array();
		}
		
		$rt = array();
		while ($st <= $et) {
			$rt[] = $st->format($dtformat);
			$st->add($interval);
		}
		return $rt;
	}
	
	public function phone_report($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}
		
		$ans = array();
		$start_tm = $data['start_dt']." 00:00:00";
		$end_tm = $data['end_dt']." 23:59:59";
		
		$sql = "SELECT LEFT(newcall, 10) as dt, COUNT(*) as answers FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY dt";
		$ans['in'] = $this->db->query($sql)->result_array();
		
		$sql = "SELECT LEFT(stm, 10) as dt, SUM(slength) as total_pause FROM phone_action WHERE active='".self::PHONE_OPT_PAUSE."' AND stm>=".$this->db->escape($start_tm)." AND stm<=".$this->db->escape($end_tm)." GROUP BY dt";
		$ans['acw'] = $this->db->query($sql)->result_array();
		
		$sql = "SELECT LEFT(newcall, 10) as dt, COUNT(*) as abandoned, AVG(TIME_TO_SEC(TIMEDIFF(hangup, newcall))) as avg_abandoned FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND answer<newcall AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY dt";
		$ans['abandoned'] = $this->db->query($sql)->result_array();
		
		$sql = "SELECT LEFT(newcall, 10) as dt, MAX(TIMEDIFF(answer, newcall)) as max_waiting, AVG(TIME_TO_SEC(TIMEDIFF(answer, newcall))) as avg_waiting, AVG(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as avg_talk, SUM(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as total_talk FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND answer>newcall AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY dt";
		$ans['answer'] = $this->db->query($sql)->result_array();
		
		return $ans;
	}
	
	public function agent_performance($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}

		$usersql = '';
		if (!empty($data['user_id'])) {
			$usersql = " AND user_id='" . (int)$data['user_id'] . "'";
		}
		$ans = array();
		$start_tm = $data['start_dt']." 00:00:00";
		$end_tm = $data['end_dt']." 23:59:59";
		
		$sql = "SELECT user_id, SUM(slength) as total_pause FROM phone_action WHERE active='".self::PHONE_OPT_PAUSE."'".$usersql." AND stm>=".$this->db->escape($start_tm)." AND stm<=".$this->db->escape($end_tm)." GROUP BY user_id";
		$ans['acw'] = $this->db->query($sql)->result_array();
		
		$sql = "SELECT user_id, COUNT(*) as calls, AVG(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as avg_talk, SUM(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as total_talk, AVG(TIME_TO_SEC(TIMEDIFF(answer, newcall))) as avg_waiting FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND answer>newcall".$usersql." AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY user_id";
		$ans['answer'] = $this->db->query($sql)->result_array();
		
		$sql = "SELECT user_id, COUNT(*) as calls, AVG(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as avg_talk, SUM(TIME_TO_SEC(TIMEDIFF(hangup, answer))) as total_talk FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='outbound' AND answer>newcall".$usersql." AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY user_id";
		$ans['callout'] = $this->db->query($sql)->result_array();
		
		return $ans;
	}
	
	public function phone_abandon($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}
		
		$ans = array();
		$start_tm = $data['start_dt']." 00:00:00";
		$end_tm = $data['end_dt']." 23:59:59";
		
		$sql = "SELECT LEFT(newcall, 10) as dt, COUNT(*) as calls,
				SUM(case when answer>newcall then 1 else 0 end) as answers,
				SUM(case when answer<newcall then 1 else 0 end) as abandons,
				SUM(case when ((answer<newcall) and (TIME_TO_SEC(TIMEDIFF(hangup, newcall)) < 10))  then 1 else 0 end) as less10,
				SUM(case when ((answer<newcall) and (TIME_TO_SEC(TIMEDIFF(hangup, newcall)) < 20))  then 1 else 0 end) as less20,
				SUM(case when ((answer<newcall) and (TIME_TO_SEC(TIMEDIFF(hangup, newcall)) < 30))  then 1 else 0 end) as less30,
				SUM(case when ((answer<newcall) and (TIME_TO_SEC(TIMEDIFF(hangup, newcall)) < 40))  then 1 else 0 end) as less40,
				SUM(case when ((answer<newcall) and (TIME_TO_SEC(TIMEDIFF(hangup, newcall)) < 50))  then 1 else 0 end) as less50,
				SUM(case when answer>newcall then TIME_TO_SEC(TIMEDIFF(answer, newcall)) else 0 end) as total_answer,
				SUM(case when answer<newcall then TIME_TO_SEC(TIMEDIFF(hangup, newcall)) else 0 end) as total_abandons
				FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY dt";
		return $this->db->query($sql)->result_array();
	}
	
	public function phone_response($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}
		
		$ans = array();
		$start_tm = $data['start_dt']." 00:00:00";
		$end_tm = $data['end_dt']." 23:59:59";
		
		$sql = "SELECT LEFT(newcall, 10) as dt, COUNT(*) as calls,
				SUM(case when answer>newcall then 1 else 0 end) as answers,
				SUM(case when answer<newcall then 1 else 0 end) as abandons,
				SUM(case when ((answer>newcall) and (TIME_TO_SEC(TIMEDIFF(answer, newcall)) < 10))  then 1 else 0 end) as less10,
				SUM(case when ((answer>newcall) and (TIME_TO_SEC(TIMEDIFF(answer, newcall)) < 20))  then 1 else 0 end) as less20,
				SUM(case when ((answer>newcall) and (TIME_TO_SEC(TIMEDIFF(answer, newcall)) < 30))  then 1 else 0 end) as less30,
				SUM(case when ((answer>newcall) and (TIME_TO_SEC(TIMEDIFF(answer, newcall)) < 40))  then 1 else 0 end) as less40,
				SUM(case when ((answer>newcall) and (TIME_TO_SEC(TIMEDIFF(answer, newcall)) < 50))  then 1 else 0 end) as less50,
				SUM(case when answer>newcall then TIME_TO_SEC(TIMEDIFF(answer, newcall)) else 0 end) as total_answer
				FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND newcall>=".$this->db->escape($start_tm)." AND newcall<=".$this->db->escape($end_tm)." GROUP BY dt";
		return $this->db->query($sql)->result_array();
	}
	
	public function second_to_time($seconds) {
		$str = '';
		$hours = (int) ($seconds / 3600);
		$minutes = (int) (($seconds % 3600) / 60);
		$seconds = (int) ($seconds % 60);
		return $hours . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
	}
	
	public function get_phone_user_list() {
		$sql = "SELECT * FROM users WHERE id IN (SELECT DISTINCT user_id FROM phone_agent)";
		return $this->db->query($sql)->result_array();
	}
	
	public function agent_activity($data) {
		if (empty($data['start_dt']) || empty($data['end_dt'])) {
			return array();
		}

		$sql = "SELECT SUM(pa.pause) as pause, SUM(pa.break) as break, SUM(pa.incall) as incall, SUM(pa.outcall) as outcall, SUM(pa.waiting) as waiting, u.* FROM phone_agent pa JOIN users u ON (pa.user_id=u.id) WHERE";
		if (!empty($data['user_id'])) {
			$sql .= " pa.user_id='".(int)$data['user_id']."' AND";
		}
		$sql .= " dt>=".$this->db->escape($data['start_dt'])." AND dt<=".$this->db->escape($data['end_dt'])." GROUP BY pa.user_id ORDER BY pa.user_id";
		return $this->db->query($sql)->result_array();
	}
	
	public function phone_waiting($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}
		
		$st = new DateTime($data['start_dt'] . " 00:00:00");
		$et = new DateTime($data['end_dt'] . " 23:59:59");
		
		if ($st > $et) {
			return array();
		}
		
		$interval = new DateInterval('PT30M');
		
		$rt = array();
		while ($st <= $et) {
			$key = $st->format("Y-m-d H:i");
			$stm = $st->format("Y-m-d H:i:s");
			$st->add($interval);
			$etm = $st->format("Y-m-d H:i:s");
			
			$sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(answer, newcall))) as waiting FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND answer>newcall AND newcall>=".$this->db->escape($stm)." AND newcall<".$this->db->escape($etm);
					
			$rt[$key] = 0;
			if ($rc = $this->db->query($sql)->row_array()) {
				$rt[$key] = (int)$rc['waiting'];
			}
		}
		return $rt;
	}
	
	public function phone_queue($data) {
		if (empty($data['start_dt']) || empty($data['end_dt']) || empty($data['queue'])) {
			return array();
		}
		
		$st = new DateTime($data['start_dt'] . " 00:00:00");
		$et = new DateTime($data['end_dt'] . " 23:59:59");
		
		if ($st > $et) {
			return array();
		}
		
		$interval = new DateInterval('PT30M');
		
		$rt = array();
		while ($st <= $et) {
			$key = $st->format("Y-m-d H:i");
			$stm = $st->format("Y-m-d H:i:s");
			$st->add($interval);
			$etm = $st->format("Y-m-d H:i:s");
			
			$sql = "SELECT count(*) as cnt FROM phone_records WHERE queue=".$this->db->escape($data['queue'])." AND direction='inbound' AND answer>newcall AND newcall>=".$this->db->escape($stm)." AND newcall<".$this->db->escape($etm);

			$rt[$key] = 0;
			if ($rc = $this->db->query($sql)->row_array()) {
				$rt[$key] = (int)$rc['cnt'];
			}
		}
		return $rt;
	}
	
	public function testsocket() {
		$errno = $errstr = '';
		
		$fp = @fsockopen('127.0.0.1', $this->portt, $errno, $errstr, 1);
		if (! $fp) {
			return false;
		} else {
			fclose($fp);
			return true;
		}
	}
	
	public function sendRingQueue($phonenumber, $queue) {
		$fp = @fsockopen('127.0.0.1', $this->portt, $errno, $errstr, 1);
		if (! $fp) {
			return false;
		}
		
		$out = "GET /" . self::SERVER_STR . "/" . $phonenumber . "/" . $queue . " HTTP/1.1\r\n";
		$out .= "Host: 127.0.0.1\r\n\r\n";
		
		fwrite($fp, $out);
		fclose($fp);
	}
}
