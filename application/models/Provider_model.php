<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Provider_model extends CI_Model {
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
			$this->db->update('provider', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('provider', $data);
			return $this->db->insert_id();
		}
	}
}