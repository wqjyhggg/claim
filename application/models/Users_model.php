<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Users_model extends CI_Model {
	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('users')->result_array();
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
			$this->db->update('users', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('users', $data);
			return $this->db->insert_id();
		}
	}
}