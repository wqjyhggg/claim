<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Mytask_model extends CI_Model {
	/**
	 * Return a list of mytake
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('mytake')->result_array();
	}

	/**
	 * Save or Update a mytake
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$rc = $this->db->get('mytask', array('id' => $id))->row_array();
			if ($rc) {
				$this->db->where('id', $id);
				$this->db->update('mytask', $data);
				$this->active_model->log_update('mytask', $id, $rc, $data, $this->db->last_query());
				return $id;
			}
			return 0; // unknown id
		} else {
			// insert
			$this->db->insert('mytask', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('mytask', $id, $data, $sql);
			return $id;
		}
	}
}