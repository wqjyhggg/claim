<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Groups_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_list($flag=FALSE) {
		$this->db->order_by('description', 'ASC');
		$rt = $this->db->get('`groups`')->result_array();
		$rArr = array();
		if ($flag) {
			$rArr[0] = '-- Select Group--';
		}
		foreach ($rt as $rc) {
			$rArr[$rc['id']] = $rc['description'];
		}
		return $rArr;
	}
}
