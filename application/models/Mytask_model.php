<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Mytask_model extends CI_Model {
	const TASK_TYPE_CASE='CASE';
	const TASK_TYPE_CLAIM='CLAIM';

	const CATEGORY_ASSISTANCE='Assistance';
	const CATEGORY_CLAIMS='Claims';
	
	const USER_TYPE_EAC='CASE';
	const USER_TYPE_CLIAMEXAM='claimexaminer';
	
	const PRIORITY_NORMAL='Normal';
	const PRIORITY_HIGH='High';
	
	/**
	 * Return a list of mytask
	 *
	 * @param integer $id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('mytake')->row_array();
	}
	
	/**
	 * Return a list of mytask
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
	 * Return a list of mytask
	 *
	 * @param integer $id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_priorities() {
		return array(self::PRIORITY_NORMAL, self::PRIORITY_HIGH);
	}
	
	/**
	 * Save or Update a mytask
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
	
	/**
	 * Update a mytask
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function update($updatedata, $conditions) {
		$this->db->set($updatedata);
		$this->db->where($conditions);
		$this->db->update('mytask');
		$data = array();
		
		$this->active_model->log_update_more('mytask', 'Updated', $conditions, $this->db->last_query());
	}
}