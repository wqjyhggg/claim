<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Product_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_list($flag=FALSE) {
		$this->db->where('calculate', 1);
		$this->db->order_by('full_name', 'ASC');
		$rt = $this->db->get('product')->result_array();
		$rArr = array();
		if ($flag) {
			$rArr[0] = '-- Select Product--';
		}
		foreach ($rt as $rc) {
			$rArr[$rc['product_short']] = $rc['full_name'];
			//$rArr[$rc['product_short']] = $rc['product_short'];
		}
		return $rArr;
	}
	
	public function get_all() {
		$this->db->where('calculate', 1);
		$this->db->order_by('full_name', 'ASC');
		$rt = $this->db->get('product')->result_array();
    return $rt;
	}
	
	public function get_full_name($product_short) {
		$this->db->where('product_short', $product_short);
		if ($rt = $this->db->get('product')->row_array()) {
			return ($rt['full_name']);
		}
		return '';
	}

	public function get_up_insuer() {
		$this->db->select('DISTINCT up_insuer', false);
		if ($rt = $this->db->get('product')->result_array()) {
      $arr = array();
      foreach ($rt as $rc) {
        $arr[] = $rc['up_insuer'];
      }
			return $arr;
		}
		return [];
	}
}