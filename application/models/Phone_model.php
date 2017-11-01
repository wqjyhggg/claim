<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author jackw
 *        
 */
class Phone_model extends CI_Model {
	const PHONE_KEY = '6bd7053312e9927c61ff57dd8202ba6c';
	const PHONE_URL = 'http://portal.aurat.genvoice.net';
	
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
		} else if ($method == 'PUT') {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
}