<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Case_model extends CI_Model {
	const CASE_PRIORITY_HIGH="High";
	const CASE_PRIORITY_NORMAL="Normal";
	
	/**
	 * Generate case no if there is none
	 * 
	 * @param unknown $id
	 */
	public function get_priorities() {
		return array(
				self::CASE_PRIORITY_NORMAL,
				self::CASE_PRIORITY_HIGH
		);
	}
	
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
	 * Return a record by case_no
	 *
	 * @param string $case_no
	 * @return array result array, maybe null
	 */
	public function get_id_by_case_no($case_no) {
		$this->db->where('case_no', $case_no);
		return $this->db->get('case')->row_array();
	}

	/**
	 * Return a list of policy status
	 *
	 * @param array $data	  	search parameter
	 * @param array $policies	policy list
	 * @return array result array, maybe null
	 */
	public function post_search($post, $policies=array()) {
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
		
		$sql  = "SELECT concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, `case`.case_no, DATE_FORMAT(`case`.created, '%Y-%m-%d') as created, `case`.province, `case`.reason, `case`.policy_no, concat_ws(' ', `case`.insured_firstname, `case`.insured_lastname) as insured_name, IF(`case`.dob='0000-00-00', 'N/A', DATE_FORMAT(`case`.dob, '%Y-%m-%d')) as dob, `case`.assign_to, `case`.case_manager, `case`.priority, `case`.id, `case`.last_update FROM `case`";
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
	public function save($indata) {
		if (isset($indata['id'])) $data['id'] = $indata['id'];
		if (isset($indata['case_no'])) $data['case_no'] = $indata['case_no'];
		if (isset($indata['claim_no'])) $data['claim_no'] = $indata['claim_no'];
		if (isset($indata['created_by'])) $data['created_by'] = $indata['created_by'];
		if (isset($indata['street_no'])) $data['street_no'] = $indata['street_no'];
		if (isset($indata['street_name'])) $data['street_name'] = $indata['street_name'];
		if (isset($indata['city'])) $data['city'] = $indata['city'];
		if (isset($indata['province'])) $data['province'] = $indata['province'];
		if (isset($indata['country'])) $data['country'] = $indata['country'];
		if (isset($indata['country2'])) $data['country2'] = $indata['country2'];
		if (isset($indata['post_code'])) $data['post_code'] = $indata['post_code'];
		if (isset($indata['assign_to'])) $data['assign_to'] = $indata['assign_to'];
		if (isset($indata['reason'])) $data['reason'] = $indata['reason'];
		if (isset($indata['first_name'])) $data['first_name'] = $indata['first_name'];
		if (isset($indata['last_name'])) $data['last_name'] = $indata['last_name'];
		if (isset($indata['phone_number'])) $data['phone_number'] = $indata['phone_number'];
		if (isset($indata['email'])) $data['email'] = $indata['email'];
		if (isset($indata['place_of_call'])) $data['place_of_call'] = $indata['place_of_call'];
		if (isset($indata['incident_date'])) $data['incident_date'] = $indata['incident_date'];
		if (isset($indata['relations'])) $data['relations'] = $indata['relations'];
		if (isset($indata['diagnosis'])) $data['diagnosis'] = $indata['diagnosis'];
		if (isset($indata['treatment'])) $data['treatment'] = $indata['treatment'];
		if (isset($indata['third_party_recovery'])) $data['third_party_recovery'] = $indata['third_party_recovery'];
		if (isset($indata['medical_notes'])) $data['medical_notes'] = $indata['medical_notes'];
		if (isset($indata['policy_no'])) $data['policy_no'] = $indata['policy_no'];
		if (isset($indata['policy_info'])) $data['policy_info'] = $indata['policy_info'];
		if (isset($indata['insured_firstname'])) $data['insured_firstname'] = $indata['insured_firstname'];
		if (isset($indata['insured_lastname'])) $data['insured_lastname'] = $indata['insured_lastname'];
		if (isset($indata['insured_address'])) $data['insured_address'] = $indata['insured_address'];
		if (isset($indata['dob'])) $data['dob'] = $indata['dob'];
		if (isset($indata['case_manager'])) $data['case_manager'] = $indata['case_manager'];
		if (isset($indata['reserve_amount'])) $data['reserve_amount'] = $indata['reserve_amount'];
		if (isset($indata['priority'])) $data['priority'] = $indata['priority'];
		if (isset($indata['status'])) $data['status'] = $indata['status'];
		if (isset($indata['created'])) $data['created'] = $indata['created'];
		if (isset($indata['doctor_first_name'])) $data['doctor_first_name'] = $indata['doctor_first_name'];
		if (isset($indata['doctor_last_name'])) $data['doctor_last_name'] = $indata['doctor_last_name'];
		if (isset($indata['doctor_country'])) $data['doctor_country'] = $indata['doctor_country'];
		if (isset($indata['doctor_province'])) $data['doctor_province'] = $indata['doctor_province'];
		if (isset($indata['doctor_address'])) $data['doctor_address'] = $indata['doctor_address'];
		if (isset($indata['doctor_city'])) $data['doctor_city'] = $indata['doctor_city'];
		if (isset($indata['doctor_post_code'])) $data['doctor_post_code'] = $indata['doctor_post_code'];
		if (isset($indata['doctor_phone'])) $data['doctor_phone'] = $indata['doctor_phone'];
		if (isset($indata['outpatient_provider'])) $data['outpatient_provider'] = $indata['outpatient_provider'];
		if (isset($indata['outpatient_federal_tax'])) $data['outpatient_federal_tax'] = $indata['outpatient_federal_tax'];
		if (isset($indata['outpatient_facility'])) $data['outpatient_facility'] = $indata['outpatient_facility'];
		if (isset($indata['outpatient_physician'])) $data['outpatient_physician'] = $indata['outpatient_physician'];
		if (isset($indata['outpatient_address1'])) $data['outpatient_address1'] = $indata['outpatient_address1'];
		if (isset($indata['outpatient_address2'])) $data['outpatient_address2'] = $indata['outpatient_address2'];
		if (isset($indata['outpatient_city'])) $data['outpatient_city'] = $indata['outpatient_city'];
		if (isset($indata['outpatient_province'])) $data['outpatient_province'] = $indata['outpatient_province'];
		if (isset($indata['outpatient_country'])) $data['outpatient_country'] = $indata['outpatient_country'];
		if (isset($indata['outpatient_post_code'])) $data['outpatient_post_code'] = $indata['outpatient_post_code'];
		if (isset($indata['outpatient_phone'])) $data['outpatient_phone'] = $indata['outpatient_phone'];
		if (isset($indata['outpatient_fax'])) $data['outpatient_fax'] = $indata['outpatient_fax'];
		if (isset($indata['addmission_date'])) $data['addmission_date'] = $indata['addmission_date'];
		if (isset($indata['discharge_date'])) $data['discharge_date'] = $indata['discharge_date'];
		if (isset($indata['room_number'])) $data['room_number'] = $indata['room_number'];
		if (isset($indata['account_number'])) $data['account_number'] = $indata['account_number'];
		if (isset($indata['hospital_charge'])) $data['hospital_charge'] = $indata['hospital_charge'];
		if (isset($indata['inpatient_currency'])) $data['inpatient_currency'] = $indata['inpatient_currency'];
		if (isset($indata['last_update'])) $data['last_update'] = $indata['last_update'];
		
		if (isset($data['id'])) {
			$id = $data['id'];
			if ($cur = $this->get_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('case', $data);
				$this->active_model->log_update('case', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			unset($data['id']);
		}

		// insert
		$this->load->model('master_model');
		$data['id'] = $this->master_model->get_id('case');
		
		$this->db->insert('case', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('case', $id, $data, $sql);
		return $id;
	}
}