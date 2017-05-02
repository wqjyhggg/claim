<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * @author jackw
 *
 */

class Active_model extends CI_Model {
	private $data;
	
	private function init_log($type, $data, $query) {
		$this->data = array();
		$this->data['user_id'] = $this->ion_auth->get_user_id();
		$this->data['claim_id'] = isset($data['claim_id']) ? $data['claim_id'] : 0;
		$this->data['case_id'] = isset($data['case_id']) ? $data['case_id'] : 0;
		$this->data['plan_id'] = isset($data['plan_id']) ? $data['plan_id'] : 0;
		if (($type == 'claim') && isset($data['id'])) $this->data['claim_id'] =  $data['id'];
		if (($type == 'case') && isset($data['id'])) $this->data['case_id'] =  $data['id'];
		if (($type == 'plan') && isset($data['id'])) $this->data['plan_id'] =  $data['id'];
		$this->data['type'] = $type;
		$this->data['log'] = '';
		$this->data['query'] = $query;
	}
	
	/**
	 * Log create record
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function log_new($type, $id, $data, $query) {
		$this->init_log($type, $data, $query);
		$this->data['log'] = "Set (" . $id . "): " . join(", ", $data);
		$this->db->insert('active', $this->data);
	}
	
	/**
	 * Log change record
	 * 
	 * @return array 	production list
	 */
	public function log_update($type, $id, $olddata, $data, $query) {
		$this->init_log($type, $data, $query);
		$log = '';
		foreach ($data as $key => $val) {
			if ($olddata[$key] != $val) {
				$log .= $val . "[" . $olddata[$key] . "]";
			}
		}
		if ($log) {
			$this->data['log'] = "Change (" . $id . "): " . $log;
			$this->db->insert('active', $this->data);
		}
	}
}