<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Policy_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_by_no($policy_no) {
		$this->db->where('policy_no', $policy_no);
		$rt = $this->db->get('policies')->row_array();
		return $rt;
	}
	
	public function save($policy_no, $note) {
		$p = $this->get_by_no($policy_no);
		if ($p) {
			$this->db->where('policy_no', $policy_no);
			$this->db->update('policies', array('note'=>$note));
		} else {
			// insert
			$this->db->insert('policies', array('policy_no'=>$policy_no,'note'=>$note));
		}
	}
}
