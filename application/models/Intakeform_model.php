<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Intakeform_model extends CI_Model {
	/**
	 * Return a list of mytake
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('intake_form')->result_array();
	}

	/**
	 * Save or Update a mytake
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($case_id, $notes, $docs) {
		$data = array(
				'case_id' => $case_id,
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => $notes,
				'created' => date("Y-m-d H:i:s"),
				'docs' => $docs
		);
		
		// insert
		$this->db->insert('intake_form', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('mytask', $id, $data, $sql);
		return $id;
	}
}