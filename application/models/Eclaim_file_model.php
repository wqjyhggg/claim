<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Eclaim_file_model extends CI_Model {
	/**
	 * Return a Claim Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('eclaim_file')->row_array();
	}

	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (!empty($data['id'])) {
			$id = $data['id'];
			if ($cur = $this->get_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('eclaim_file', $data);
				$this->active_model->log_update('eclaim_file', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		}

		$this->db->insert('eclaim_file', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('eclaim_file', $id, $data, $sql);
		return $id;
	}
}
