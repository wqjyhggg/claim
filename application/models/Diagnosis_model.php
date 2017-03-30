<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Diagnosis_model extends CI_Model {
	/**
	 * Return a list of searched data
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search_description($q) {
		if (strlen($q) < 2) return array();
		
		$this->db->select('description as name');
		$this->db->like('description', $q);
		$this->db->limit(10);
		return $this->db->get('diagnosis')->result_array();
	}
}