<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author jackw
 *        
 */
class Phone_model extends CI_Model {
	/* test */
	const PHONE_KEY = '6bd7053312e9927c61ff57dd8202ba6c';
	const PHONE_URL = 'http://portal.aurat.genvoice.net';
	/* JF 
	const PHONE_KEY = 'a72e4f38c69af9ae20c95e9067099044';
	const PHONE_URL = 'http://api.jfgroup.genvoice.net';
	/**/
	
	const S3_BUCKET = "jfphone";
	const S3_VERSION = "latest";
	const S3_REGION = "us-east-1";
	const S3_KEY = 'AKIAJ7FQ5V6JIR23XSPA';
	const S3_SECRET = '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';
	
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

	public function set_phone_login($phoneid, $status) {
		$req = "/api/agent/".$phoneid."/status";
		$para = array('login' => $status);
		$rt = $this->sendRequest($req, $para, 'PUT');
		$data = json_decode($rt, true);
	}

	public function get_phone_login($phoneid) {
		$req = "/api/agent/".$phoneid."/status";
		$para = array('login' => $status);
		$rt = $this->sendRequest($req, $para, 'PUT');
		$data = json_decode($rt, true);
		if (isset($data['logged_in'])) {
			return $data['logged_in'];
		}
		return false;
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

	public function save_callback_ringing($data) {
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
		$this->save(array('data' => $data));
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
		$sql = "INSERT into phone_ring (phone_id, caller_id_number, agent, event_tm) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape($json['agent']).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).")";
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function save_callback_enterqueue($data) {
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
		$this->save(array('data' => $data));
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

	public function save_callback_newcall($data) {
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
		$this->save(array('data' => $data));
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

	public function save_callback_answer($data) {
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
		$this->save(array('data' => $data));
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
		$para['event_time'] = date('Y-m-d H:i:s', $tm);
		$sql = "INSERT into phone_records (phone_id, direction, agent, caller_id_number, newcall, answer) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['direction']).", ".$this->db->escape($json['agent']).", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($json['start_time']))).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE answer=".$this->db->escape(date("Y-m-d H:i:s", $tm)).", agent=".$this->db->escape($json['agent']);
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function save_callback_hangup($data) {
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
		$this->save(array('data' => $data));
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

		$sql = "INSERT into phone_records (phone_id, direction, agent, caller_id_number, newcall, answer, hangup) values (".$this->db->escape($id).", ".$this->db->escape($direction).", ".$this->db->escape($agent).", ".$this->db->escape($caller_id_number).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($start_time))).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($start_time))).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE hangup=".$this->db->escape(date("Y-m-d H:i:s", $tm)).", agent=".$this->db->escape($agent);
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
}
