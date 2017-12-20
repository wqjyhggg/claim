<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Intakeform_model extends CI_Model {
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('intake_form')->row_array();
	}
	
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
	public function save($case_id, $notes, $docs, $phonefile='', $followup=0, $type='CASE') {
		$data = array(
				'case_id' => $case_id,
				'created_by' => $this->ion_auth->get_user_id(),
				'notes' => $notes,
				'phonefile' => $phonefile,
				'type' => $type,
				'created' => date("Y-m-d H:i:s"),
				'docs' => $docs
		);
		if (!empty($followup)) {
			$data['followup'] = $followup;
		}
		
		// insert
		$this->db->insert('intake_form', $data);
		
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('intake_form', $id, $data, $sql);
		return $id;
	}

	public function update($data) {
			if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$cur = $this->get_by_id($id);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('intake_form', $data);
				$this->active_model->log_update('intake_form', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			// insert
			$this->db->insert('intake_form', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('intake_form', $id, $data, $sql);
			return $id;
		}
	}
	
	public function get_list_by_case_id($id, $type='CASE') {
		$sql = "SELECT i.*, u.email as username, u2.email as followup FROM intake_form i LEFT JOIN users u ON (i.created_by=u.id) LEFT JOIN users u2 ON (i.followup=u2.id) WHERE i.case_id='" . (int)$id . "' AND i.type=" . $this->db->escape($type);
		
		return $this->db->query($sql)->result_array();
	}
}