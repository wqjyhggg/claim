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
	/**/
	/* JF  
	const PHONE_KEY = 'a72e4f38c69af9ae20c95e9067099044';
	const PHONE_URL = 'http://api.jfgroup.genvoice.net';
	*/
	
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
		curl_close($curl);
		return $response;
	}

	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('phone_call')->row_array();
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
		$sql = "INSERT into phone_records (phone_id, direction, agent, caller_id_number, newcall, answer, hangup) values (".$this->db->escape($json['id']).", ".$this->db->escape($json['direction']).", ".$this->db->escape($json['agent']).", ".$this->db->escape($json['caller_id_number']).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($json['start_time']))).", ".$this->db->escape(date("Y-m-d H:i:s", strtotime($json['start_time']))).", ".$this->db->escape(date("Y-m-d H:i:s", $tm)).") ON DUPLICATE KEY UPDATE hangup=".$this->db->escape(date("Y-m-d H:i:s", $tm)).", agent=".$this->db->escape($json['agent']);
		$this->db->query($sql);
		return $this->db->insert_id();
	}
	
	public function getmyurl() {
		$name = $this->ion_auth->get_user_info('first_name');
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
							if (strpos($row['recording_url'], $rc['phone_id']) > 0) {
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
}