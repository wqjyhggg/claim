<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Country_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_list($flag=FALSE) {
		if ($flag !== FALSE) {
			$this->db->where('active', $flag);
		}
		$this->db->order_by('order_by');
		$this->db->order_by('name');
		$rt = $this->db->get('country')->result_array();
		$rArr = array();
		foreach ($rt as $rc) {
			$rArr[$rc['short_code']] = $rc['name'];
		}
		return $rArr;
	}

	/**
	 * Get country id
	 * 
	 * @param int $short_code		short_code
	 * @return array result array, maybe null
	 */
	public function get_id_by_short($short_code) {
		$this->db->where('short_code', $short_code);
		$rt = $this->db->get('country')->row_array();
		if ($rt) {
			return $rt['id'];
		}
		return 0;
	}
}