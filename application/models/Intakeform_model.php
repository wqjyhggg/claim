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
	public function save($case_id, $notes, $docs, $phonefile='') {
		$data = array(
				'case_id' => $case_id,
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => $notes,
				'phonefile' => $phonefile,
				'created' => date("Y-m-d H:i:s"),
				'docs' => $docs
		);
		
		// insert
		$this->db->insert('intake_form', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('intake_form', $id, $data, $sql);
		return $id;
	}
	
	public function get_list_by_case_id($id, $type='CASE') {
		$sql = "SELECT i.*, CONCAT_WS(' ', u.first_name, u.last_name) as username FROM intake_form i LEFT JOIN users u ON (i.created_by=u.id) WHERE i.case_id='" . (int)$id . "' AND i.type=" . $this->db->escape($type);
		
		return $this->db->query($sql)->result_array();
	}
}