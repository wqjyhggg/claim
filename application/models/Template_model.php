<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Template_model extends CI_Model {
	const TEMPLATE_CASE="Case";
	const TEMPLATE_CLAIM="Claim";
	
	/**
	 * Return a list of mytake
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('template')->result_array();
	}

	/**
	 * Save or Update a mytake
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($id, $name, $desc, $type) {
		$typeArr = array("EAC", 'Claim', 'Case');
		
		if (!in_array($type, $typeArr)) return 0;
	
		$data = array(
				'name' => $name,
				'description' => $desc,
				'type' => $type
		);
		if ($id) {
			$this->db->set('id', $id);
			$this->db->update('intake_form', $data);
			$sql = $this->db->last_query();
			$this->active_model->log_new('template', $id, $data, $sql);
		} else {
			// insert
			$this->db->insert('intake_form', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('template', $id, $data, $sql);
			return $id;
		}
	}
}