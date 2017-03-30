<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Case_model extends CI_Model {
	/**
	 * Generate case no if there is none
	 * 
	 * @param unknown $id
	 */
	public function generate_case_no($id) {
		return str_pad($id, 7, 0, STR_PAD_LEFT);
	}
	
	/**
	 * Return a list of policy status
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('case')->result_array();
	}

	/**
	 * Save or Update a case
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			
			$this->db->where('id', $id);
			$this->db->update('case', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('case', $data);
			return $this->db->insert_id();
		}
	}
}