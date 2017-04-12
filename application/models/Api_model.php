<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * This model hold 2 parts major functions 
 * first parts get information from policy system
 * second parts is the interface for API authorize
 * 
 * @author jackw
 *
 */

class Api_model extends CI_Model {
	public $status_list;
	public $success;
	public $errormsg;
	
	/**
	 * Return a list of policy status
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_policy($data) {
		foreach ($data as $k => $v) {
			$data[$k] = trim($v);
		}
		
		// prepare post data
		$data ['key'] = API_KEY;
		$post_data = http_build_query ( $data );
		
		// get list of policy status here
		$url = API_URL . "search";
		$curl = curl_init ();
		
		// Post Data
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post_data );
		
		// Optional Authentication:
		if (API_USER and API_PASSWORD) {
			curl_setopt ( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt ( $curl, CURLOPT_USERPWD, API_USER . ":" . API_PASSWORD );
		}
		
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt ( $curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		curl_setopt ( $curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		
		$result = curl_exec ( $curl );
		
		curl_close ( $curl );
		$rt = json_decode ( $result, TRUE );
		$this->status_list = isset($rt['status_list']) ? $rt['status_list'] : array();
		$this->success = isset($rt['success']) ? $rt['success'] : 'Failed to Connect';
		$this->errormsg = isset($rt['errormsg']) ? $rt['errormsg'] : '';
		if (isset ( $rt ['success'] ) && isset ( $rt ['plan_list'] )) {
			$this->status_list = $rt ['status_list'];
			$rArr = $rt ['plan_list'];
			foreach ($rArr as $k => $v) {
				$rArr[$k]['status'] = $this->status_list[$v['status_id']]['name'];
			}
			return $rArr;
		}
		return array ();
	}
	
	/**
	 * Return a list of products which policy system have
	 * 
	 * @return array 	production list
	 */
	public function get_products() {
		// get products from jf api
		$url =  API_URL."products";
		$curl = curl_init();

		// Post TYPE REQUEST
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array('key'=>API_KEY));
		
		// Optional Authentication:
		if(API_USER and API_PASSWORD) {
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		
		$result = curl_exec($curl);
		$result = json_decode($result, TRUE);
        curl_close($curl);

		if (!empty($result['success']) && ($result['success'] == 'OK')) {
			return $result['plan'];
		}
		return array();
	}
	
	/**
	 * Gerenate
	 *
	 * @param string $ap_id        	
	 * @return string
	 */
	function get_token($ap_id) {
		return md5 ( $ap_id . rand ( 100000, 999999 ) );
	}
	
	/**
	 *
	 * @param array $para        	
	 * @return void
	 */
	function update($para) {
		$data = array ();
		if (isset ( $para ['ap_id'] ))	$data ['ap_id'] = $this->db->escape ( $para ['ap_id'] );
		if (isset ( $para ['token'] ))	$data ['token'] = $this->db->escape ( $para ['token'] );
		if (isset ( $para ['policy'] ))	$data ['policy'] = $this->db->escape ( $para ['policy'] );
		if (isset ( $para ['ip'] ))		$data ['ip'] = $this->db->escape ( $para ['ip'] );
		
		if (empty ( $data ))
			return; // There is not data
		$data1 = $data;
		if (empty ( $data1 ))
			return; // There is not data
		
		unset ( $data1 ['ap_id'] );
		if (isset ( $para ['last_tm'] ))
			$data1 ['last_tm'] = $this->db->escape ( $para ['last_tm'] );
		$updatestr = "";
		foreach ( $data1 as $k => $v )
			$updatestr .= $k . "=" . $v . ",";
		$updatestr = substr ( $updatestr, 0, - 1 );
		
		$sql = "INSERT INTO api_login (" . join ( ",", array_keys ( $data ) ) . ") values (" . join ( ",", array_values ( $data ) ) . ") ON DUPLICATE KEY UPDATE " . $updatestr;
		$this->db->query ( $sql );
	}
	
	/**
	 *
	 * @param array $para        	
	 * @return void
	 */
	function check($para) {
		if (! isset ( $para ['ap_id'] ))
			return array ();
		if (! isset ( $para ['token'] ))
			return array ();
		
		$this->db->where ( 'ap_id', $para ['ap_id'] );
		$this->db->where ( 'token', $para ['token'] );
		
		return $this->db->get ( 'api_login' )->row_array ();
	}
	
	/**
	 *
	 * @param array $para        	
	 * @return void
	 */
	function check_last($para) {
		$rt = $this->check ( $para );
		if ($rt) {
			unset ( $para ['token'] );
			$this->update ( $para );
		}
		return $rt;
	}
}