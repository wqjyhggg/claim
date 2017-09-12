<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Relations_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_list() {
		$this->db->order_by('name');
		$rt = $this->db->get('relations')->result_array();
		$rArr = array();
		foreach ($rt as $rc) {
			$rArr[$rc['id']] = $rc['name'];
		}
		return $rArr;
	}

	/**
	 * Get country id
	 * 
	 * @param int $short_code		short_code
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		$rt = $this->db->get('relations')->row_array();
		return $rt;
	}
}