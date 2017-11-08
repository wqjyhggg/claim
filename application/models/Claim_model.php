<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Claim_model extends CI_Model {
	const STATUS_Processing='Processing';
	const STATUS_Pending='Pending';
	const STATUS_Processed='Processed';
	const STATUS_Paid='Paid';
	const STATUS_Closed='Closed';
	const STATUS_Recovered='Recovered';
	const STATUS_Appealed='Appealed';
	const STATUS_Exempted='Exempted';
	
	/**
	 * Generate claim no if there is none
	 * 
	 * @param int $id
	 * @return string
	 */
	public function generate_claim_no($id) {
		return str_pad($id, 7, 0, STR_PAD_LEFT);
	}
	
	/**
	 * Get Claim status
	 * 
	 * @param int $need_empty	
	 * @return array
	 */
	public function get_claim_status_list($need_empty=0) {
		$arr = array(
				0	=> '-- Claim Status --',
				'Processing' => self::STATUS_Processing,
				'Pending' => self::STATUS_Pending,
				'Processed' => self::STATUS_Processed,
				'Paid' => self::STATUS_Paid,
				'Closed' => self::STATUS_Closed,
				'Recovered' => self::STATUS_Recovered,
				'Appealed' => self::STATUS_Appealed,
				'Exempted' => self::STATUS_Exempted,
		);
		
		if (empty($need_empty)) unset($arr[0]);
		return $arr;
	}
	
	/**
	 * Return a Claim Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
		}
		$this->db->where('id', $id);
		if ($products !== FALSE) {
			if (empty($products)) {
				return array();
			}
			$this->db->where_in('product_short', $products);
		}
		return $this->db->get('claim')->row_array();
	}

	/**
	 * Return a list of policy status
	 *
	 * @param array $data	  	search parameter
	 * @param array $policies	policy list
	 * @return array result array, maybe null
	 */
	public function post_search($post, $policies) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
		}
		
		$where = '';
		
		if (!empty($post["claim_no"])) {
			$where .= ' claim.claim_no=' . $this->db->escape($post["claim_no"]);
		}
		
		if (!empty($post["status"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.status=" . $this->db->escape($post["status"]);
		}
		
		if ($products && (sizeof($products) > 0)) {
			if ($where) $where .= ' AND';
			$where .= " `claim`.product_short IN ('" . join("','", $products) . "')";
		}
		
		if (!empty($policies)) {
			$pArr = array();
			foreach ($policies as $po) {
				$pArr[] = $this->db->escape($po['policy']);
			}
			if ($where) $where .= ' AND'; 
			$where .= " claim.policy_no IN (" . join(",", $pArr) . ")";
		}
		
		if (!empty($post["firstname"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.insured_first_name like ". $this->db->escape("%" . $post["firstname"] . "%");
		}

		if (!empty($post["lastname"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.insured_last_name like ". $this->db->escape("%" . $post["lastname"] . "%");
		}
		
		if (!empty($post["claim_date_from"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.claim_date >= " . $this->db->escape($post["claim_date_from"]);
		}
			
		if (!empty($post["claim_date_to"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.claim_date <= " . $this->db->escape($post["claim_date_to"]);
		}
		
		if (!$where) {
			return array();
		}
		
		$sql  = "SELECT u1.email, concat_ws(' ', u1.first_name, u1.last_name) as claim_examiner, claim.id, claim.policy_no, claim.claim_no, claim.insured_first_name, claim.insured_last_name, claim.gender, claim.dob, claim.claim_date, claim.status, sum(expenses_claimed.amount_claimed) as amount_claimed FROM claim";
		$sql .= " LEFT JOIN users u1 ON u1.id = claim.assign_to";
		$sql .= " LEFT JOIN expenses_claimed ON claim.id = expenses_claimed.claim_id";
		$sql .= " WHERE ". $where;
		$sql .= " GROUP BY claim.id";
		$sql .= " ORDER BY claim.id DESC";
	
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Return a list of Claim
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
			$products = $this->ion_auth->get_users_products();
		}
		$this->db->where($data);
		if ($products !== FALSE) {
			if (empty($products)) {
				return array();
			}
			$this->db->where_in('product_short', $products);
		}
		return $this->db->get('claim')->result_array();
	}

	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['id'])) {
			$id = $data['id'];
			if ($cur = $this->get_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('claim', $data);
				$this->active_model->log_update('claim', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		}

		if (empty($data['id'])) {
			// insert
			$this->load->model('master_model');
			$data['id'] = $this->master_model->get_id('claim');
		}
		
		$this->db->insert('claim', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('claim', $id, $data, $sql);
		return $id;
	}


	/**
	 * Return a summary of a Claim
	 *
	 * @param int $claim_id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function expenses_summary($claim_id) {
		$this->db->select_sum('amount_billed', 'billed');
		$this->db->select_sum('amount_client_paid', 'client_paid');
		$this->db->select_sum('amount_claimed', 'claimed');
		$this->db->select_sum('amt_deductible', 'deductible');
		$this->db->select_sum('amt_received', 'received');
		$this->db->select_sum('amt_payable', 'payable');
		$this->db->select_sum('amt_exempt', 'exempt');
		$this->db->where('claim_id', $claim_id);
		return $this->db->get('expenses_claimed')->row_array();
	}

	public function get_payee_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('payees')->row_array();
	}

	public function payee_search($array) {
		$this->db->where($array);
		return $this->db->get('payees')->result_array();
	}

	public function payee_remove_by_claim_id($claim_id) {
		$this->db->query("DELETE FROM payees WHERE claim_id='" . (int)$claim_id . "'");
	}

	/**
	 * Save or Update a payees
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function payees_save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			$cur = $this->get_payee_by_id($id);
			unset($data['id']);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('payees', $data);
				$this->active_model->log_update('payees', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			// insert
			$this->db->insert('payees', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('payees', $id, $data, $sql);
			return $id;
		}
	}
}