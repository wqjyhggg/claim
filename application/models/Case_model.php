<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Case_model extends CI_Model {
	const STATUS_CLOSED="C";
	const STATUS_DEACTIVE="D";
	const STATUS_ACTIVE="A";
	
	public function get_status_list() {
		return array(
				self::STATUS_CLOSED => 'Closed',
				self::STATUS_DEACTIVE => 'Deactive',
				self::STATUS_ACTIVE => 'Active'
		);
	}
	
	/**
	 * Generate case no if there is none
	 * 
	 * @param unknown $id
	 */
	public function generate_case_no($id) {
		return "C".str_pad($id, 7, 0, STR_PAD_LEFT);
	}
	
	/**
	 * Return a record by id
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))) {
			$products = $this->ion_auth->get_users_products();
		}
		
		$this->db->where('id', $id);
		if ($products !== FALSE) {
			if (empty($products)) {
				return array();
			}
			$this->db->where_in('product_short', $products);
		}
		return $this->db->get('case')->row_array();
	}

	/**
	 * Return a record by case_no
	 *
	 * @param string $case_no
	 * @return array result array, maybe null
	 */
	public function get_id_by_case_no($case_no) {
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
			if (empty($products)) {
				return array();
			}
			$this->db->where_in('product_short', $products);
		}
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
		$where = "1 = 1";
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
			if ($products && (sizeof($products) > 0)) {
				$where .= " AND `case`.product_short IN ('" . join("','", $products) . "')";
			} else {
				return array();
			}
		}
		
		if (!empty($post["case_no"])) {
			$where .= ' AND `case`.case_no=' . $this->db->escape($post["case_no"]);
		}

		if (!empty($post["claim_no"])) {
			$where .= ' AND `case`.claim_no=' . $this->db->escape($post["claim_no"]);
		}

		if (!empty($post["policy_no"])) {
			$where .= ' AND `case`.policy_no=' . $this->db->escape($post["policy_no"]);
		}
		
		if (!empty($policies)) {
			$pArr = array();
			foreach ($policies as $po) {
				$pArr[] = $this->db->escape($po['policy']);
			}
			$where .= " AND `case`.policy_no IN (" . join(",", $pArr) . ")";
		}
		
		if (!empty($post['client_user_name'])) {
			$where .= " AND (`case`.insured_firstname like ". $this->db->escape("%" . $post["client_user_name"] . "%") . " OR `case`.insured_lastname like ". $this->db->escape("%" . $post["client_user_name"] . "%") . ")";
		}
		
		if (!empty($post['created'])) {
			$where .= " AND LEFT(`case`.created, 10)=". $this->db->escape($post["created"]);
		}
		
		if (!empty($post['manager_id'])) {
			$where .= " AND `case`.case_manager=". $this->db->escape($post["manager_id"]);
		}
		
		if (!empty($post["firstname"])) {
			$where .= " AND `case`.insured_firstname like ". $this->db->escape("%" . $post["firstname"] . "%");
		}

		if (!empty($post["lastname"])) {
			$where .= " AND `case`.insured_lastname like ". $this->db->escape("%" . $post["lastname"] . "%");
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
		
		$sql  = "SELECT u2.email as manager_email, concat_ws(' ', u2.first_name, u2.last_name) as case_manager_name, u1.email as assign_to_email, concat_ws(' ', u1.first_name, u1.last_name) as assign_to_name, `case`.case_no, DATE_FORMAT(`case`.created, '%Y-%m-%d') as created, `case`.province, `case`.reason, `case`.policy_no, concat_ws(' ', `case`.insured_firstname, `case`.insured_lastname) as insured_name, IF(`case`.dob='1970-01-01', 'N/A', DATE_FORMAT(`case`.dob, '%Y-%m-%d')) as dob, `case`.assign_to, `case`.case_manager, `case`.priority, `case`.id, `case`.last_update FROM `case`";
		$sql .= " LEFT JOIN users u1 ON u1.id = `case`.assign_to";
		$sql .= " LEFT JOIN users u2 ON u2.id = `case`.case_manager";
		if ($where) $sql .= " WHERE ". $where;
		$sql .= " ORDER BY `case`.id DESC";
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as linenumber")->row()->linenumber;
	}
	
	/**
	 * Get Agent ids
	 * 
	 * @return array
	 */
	public function get_assign_to_list($need_empty=0) {
		return $this->db->query("SELECT id, username, email, first_name, last_name FROM users WHERE id in (SELECT DISTINCT assign_to FROM `case`) ORDER BY id")->result_array();
	}

	/**
	 * Return a list of policy status
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data, $count=-1, $limit=-1, $sortby=array()) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
		}
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->where($data);
		$this->db->order_by("FIELD(case.priority, 'Critical', 'High', 'Medium', 'Low')", NULL);
		$this->db->order_by("case.created", "ASC");
		$this->db->order_by("case.last_update", "DESC");
		// foreach ($sortby as $key => $val) {
		// 	$this->db->order_by($key, $val);
		// }
		if ($products !== FALSE) {
			if (empty($products)) {
				return array();
			}
			$this->db->where_in('product_short', $products);
		}
		if ($count >= 0) {
			if ($limit < 0) {
				$this->db->limit($count);
			} else {
				$this->db->limit($count, $limit);
			}
		}
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
		if (isset($indata['suite_number'])) $data['suite_number'] = $indata['suite_number'];
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
		if (isset($indata['manager_summary'])) $data['manager_summary'] = $indata['manager_summary'];
		if (isset($indata['place_of_call'])) $data['place_of_call'] = $indata['place_of_call'];
		if (isset($indata['incident_date'])) $data['incident_date'] = $indata['incident_date'];
		if (isset($indata['relations'])) $data['relations'] = $indata['relations'];
		if (isset($indata['diagnosis'])) $data['diagnosis'] = $indata['diagnosis'];
		if (isset($indata['treatment'])) $data['treatment'] = $indata['treatment'];
		$data['third_party_recovery'] = 'N';
		if (isset($indata['third_party_recovery'])) $data['third_party_recovery'] = $indata['third_party_recovery'];
		if (isset($indata['medical_notes'])) $data['medical_notes'] = $indata['medical_notes'];
		if (isset($indata['policy_no'])) $data['policy_no'] = $indata['policy_no'];
		if (isset($indata['product_short'])) $data['product_short'] = $indata['product_short'];
		if (isset($indata['totaldays'])) $data['totaldays'] = $indata['totaldays'];
		if (isset($indata['agent_id'])) $data['agent_id'] = $indata['agent_id'];
		if (isset($indata['policy_info'])) $data['policy_info'] = $indata['policy_info'];
		if (isset($indata['departure_date'])) $data['departure_date'] = $indata['departure_date'];
		if (isset($indata['insured_firstname'])) $data['insured_firstname'] = $indata['insured_firstname'];
		if (isset($indata['insured_lastname'])) $data['insured_lastname'] = $indata['insured_lastname'];
		if (isset($indata['insured_address'])) $data['insured_address'] = $indata['insured_address'];
		if (isset($indata['dob'])) $data['dob'] = $indata['dob'];
		if (isset($indata['gender'])) $data['gender'] = $indata['gender'];
		if (isset($indata['case_manager'])) $data['case_manager'] = $indata['case_manager'];
		if (isset($indata['init_manager'])) $data['init_manager'] = $indata['init_manager'];
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
				if (isset($data['reserve_amount']) && ($data['reserve_amount'] != $cur['reserve_amount'])) {
					$data['reserve_update_tm'] = date("Y-m-d H:i:s");
				}
				
				$this->db->where('id', $id);
				$this->db->update('case', $data);
				$this->active_model->log_update('case', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		} else {
			// insert
			$this->load->model('master_model');
			$data['id'] = $this->master_model->get_id('case');
		}
		$data['init_reserve_tm'] = date("Y-m-d H:i:s");
		$data['reserve_update_tm'] = date("Y-m-d H:i:s");
		$data['init_reserve_amount'] = $data['reserve_amount'];
		$this->db->insert('case', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('case', $id, $data, $sql);
		return $id;
	}
	
	public function get_reserve_report($data) {
		$this->load->model('Expenses_model');
		$where = array();
		if (!empty($data['created_from'])) $where[] = "init_reserve_tm >= " . $this->db->escape($data['created_from']);
		if (!empty($data['created_to'])) $where[] = "init_reserve_tm <= " . $this->db->escape($data['created_to']);
		if (!empty($data['last_update_from'])) $where[] = "reserve_update_tm >= " . $this->db->escape($data['last_update_from']);
		if (!empty($data['last_update_to'])) $where[] = "reserve_update_tm <= " . $this->db->escape($data['last_update_to']);
		
		if (empty($where)) return array(); // No data
		
		$sql = "SELECT id, case_no, claim_no, init_reserve_amount, reserve_amount, init_reserve_tm, reserve_update_tm FROM `case` WHERE " . join(" AND ", $where) . "ORDER BY id";
		$rt = $this->db->query($sql)->result_array();
		if ($rt) {
			foreach ($rt as $k => $v) {
				$rt[$k]['paied_amount'] = 0;
				$rt[$k]['approved_amount'] = 0;
				if (!empty($v['claim_no'])) {
					$sql = "SELECT SUM(amt_payable) AS amt, status FROM expenses_claimed WHERE claim_id='" . (int)$v['id'] . "' AND status IN (" . $this->db->escape(Expenses_model::EXPENSE_STATUS_Approved) . "," . $this->db->escape(Expenses_model::EXPENSE_STATUS_Paid) . ") GROUP BY status";
					$rt_amt = $this->db->query($sql)->result_array();
					if ($rt_amt) {
						foreach ($rt_amt as $amt) {
							if ($amt['status'] == Expenses_model::EXPENSE_STATUS_Approved) {
								$rt[$k]['approved_amount'] = $amt['amt'];
							} else if ($amt['status'] == Expenses_model::EXPENSE_STATUS_Paid) {
								$rt[$k]['paied_amount'] = $amt['amt'];
							}
						}
					}
				}
			}
		}
		return $rt;
	}
	
	public function get_report($data, $monthly=TRUE) {
		if (empty($data['start_dt']) || empty($data['end_dt'])) {
			return array();
		}
		$s_tm = strtotime($data['start_dt']);
		$e_tm = strtotime($data['end_dt']);
		if ($s_tm > $e_tm) {
			return array();
		}

		$st = new DateTime($data['start_dt']);
		$et = new DateTime($data['end_dt']);
		$interval = new DateInterval('P1M');
		
		if ($monthly) {
			$ststr = $st->format("Y-m-01 00:00:00");
			$edstr = $et->format("Y-m-t 23:59:59");
		} else {
			$ststr = $st->format("Y-m-d 00:00:00");
			$edstr = $et->format("Y-m-d 23:59:59");
		}
		
		$sql  = "SELECT c.case_no as claim_no, '' as invoice, '' as provider_name, c.sum_insured, c.diagnosis, c.insured_firstname as first_name, c.insured_lastname as last_name, c.dob as birth_day, '' as gender, c.policy_no, LEFT(c.created, 10) as date_of_service, c.totaldays, '' as finalize_date, 'P' as status, '-' as status2, c.created, IF(DATEDIFF(NOW(),c.last_update)>90,0,c.reserve_amount) as amount_claimed, 0 as amt_payable, IF(DATEDIFF(NOW(),c.last_update)>90,0,c.reserve_amount) as reserve_amount, 0 as recovery_amt, c.street_name as street_address, c.city, c.province, c.post_code, c.agent_id, c.assign_to, p.up_insuer  FROM `case` c";
		$sql .= " INNER JOIN product p ON (p.product_short=c.product_short)";
		$sql .= " WHERE c.status='".self::STATUS_ACTIVE."' AND c.claim_no='' AND c.created>='".$ststr."' AND c.created<='".$edstr."'";
		if (!empty($data['product_short'])) {
			$sql .= " AND c.product_short=".$this->db->escape($data['product_short']);
		}
		if (!empty($data['assign_to'])) {
			$sql .= " AND c.assign_to=".intval($data['assign_to']);
		}
		if (!empty($data['products']) && is_array($data['products'])) {
      $pStr = "'".join("','", $data['products'])."'";
			$sql .= " AND c.product_short IN (".$pStr.")";
		}
    $curinvoice_status = isset($data['invoice_status']) ? $data['invoice_status'] : array();
		if (empty($curinvoice_status) || !is_array($curinvoice_status) || !in_array('P',$curinvoice_status)) {
      // All Case is belong to P
			return array();
		}
		if (!empty($data['agent_id'])) {
			$sql .= " AND agent_id='". (int)$data['agent_id']."'";
		}
    if (!empty($data['up_insuer'])) {
			$sql .= " AND p.up_insuer='". $data['up_insuer']."'";
		}
		$sql .= " ORDER BY claim_no";
		return $this->db->query($sql)->result_array();
	}

	public function case_sum_report($firstname, $lastname, $dob) {
		$sql = "SELECT case_no, policy_no, CONCAT(street_no, ' ', street_name, ' ', city, ', ', province, ' ', country, ' ', post_code) as address, SUM(reserve_amount) as amount FROM `case` WHERE LOWER(insured_firstname)=".$this->db->escape($firstname)." AND LOWER(insured_lastname)=".$this->db->escape($lastname)." AND dob=".$this->db->escape($dob)." AND claim_no='' GROUP BY case_no";
		$rt = $this->db->query($sql)->result_array();
		return $rt;
	}
}
