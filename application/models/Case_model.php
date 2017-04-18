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
	 * Return a record by id
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('case')->row_array();
	}

	/**
	 * Return a list of policy status
	 *
	 * @param array $data	  	search parameter
	 * @param array $policies	policy list
	 * @return array result array, maybe null
	 */
	public function post_search($post, $policies) {
		$where = "`case`.status = 'A'";
		
		if (!empty($post["case_no"])) {
			$where .= ' AND `case`.case_no=' . $this->db->escape($post["case_no"]);
		}
		
		if (!empty($policies)) {
			$pArr = array();
			foreach ($policies as $po) {
				$pArr[] = $this->db->escape($po['policy']);
			}
			$where .= " AND `case`.policy_no IN (" . join(",", $pArr) . ")";
		}
		
		if (!empty($post["firstname"])) {
			$where .= " AND `case`.insured_first_name like ". $this->db->escape("%" . $post["firstname"] . "%");
		}

		if (!empty($post["lastname"])) {
			$where .= " AND `case`.insured_last_name like ". $this->db->escape("%" . $post["lastname"] . "%");
		}

		if (!empty($post["assign_to"])) {
			$where .= " AND `case`.assign_to = ". $this->db->escape($post["assign_to"]);
		}
		
		if (!empty($post["case_manager"])) {
			$where .= " AND `case`.case_manager = ". $this->db->escape($post["case_manager"]);
		}
		
		if ($where == "`case`.status = 'A'") {
			return array();
		}
		
		$sql  = "SELECT concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, `case`.case_no, DATE_FORMAT(`case`.created, '%Y-%m-%d') as created, `case`.province, `case`.reason, `case`.policy_no, concat_ws(' ', `case`.insured_firstname, `case`.insured_lastname) as insured_name, IF(`case`.dob='0000-00-00', 'N/A', DATE_FORMAT(`case`.dob, '%Y-%m-%d')) as dob, `case`.assign_to, `case`.case_manager, `case`.priority, `case`.id FROM `case`";
		$sql .= " LEFT JOIN users u1 ON u1.id = `case`.assign_to";
		$sql .= " LEFT JOIN users u2 ON u2.id = `case`.case_manager";
		if ($where) $sql .= " WHERE ". $where;
		$sql .= " ORDER BY `case`.id DESC";
	
		return $this->db->query($sql)->result_array();
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
			$id = $data['id'];
			if ($this->get_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('case', $data);
				return $id;
			}
		}

		// insert
		$this->load->model('master_model');
		$data['id'] = $this->master_model->get_id('case');
		
		$this->db->insert('case', $data);
		return $this->db->insert_id();
	}
}