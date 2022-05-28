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
	const STATUS_Exceptional='Exceptional';
	const STATUS_Applied='Eclaim';
	
	/**
	 * Generate claim no if there is none
	 * 
	 * @param int $id
	 * @return string
	 */
	public function generate_claim_no($id) {
		return "C".str_pad($id, 7, 0, STR_PAD_LEFT);
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
//				'Closed' => self::STATUS_Closed,
//				'Recovered' => self::STATUS_Recovered,
				'Appealed' => self::STATUS_Appealed,
//				'Exceptional' => self::STATUS_Exceptional,
				'Eclaim' => self::STATUS_Applied,
		);
		
		if (empty($need_empty)) unset($arr[0]);
		return $arr;
	}
	
	/**
	 * Get Agent ids
	 * 
	 * @return array
	 */
	public function get_agents_list($need_empty=0) {
		return $this->db->query("SELECT DISTINCT agent_id FROM claim ORDER BY agent_id")->result_array();
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
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EXAMINER))) {
			$products = $this->ion_auth->get_users_products();
		}
		
		$where = '';
		
		if (!empty($post["eclaim_sls"])) {
			if ($post["eclaim_sls"] == 1) {
				$where .= ' claim.eclaim_no=\'\'';
			} else {
				$where .= ' claim.eclaim_no!=\'\'';
			}
		}

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
		
		if (!empty($post["claim_examiner"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.assign_to='". (int) $post["claim_examiner"] . "'";
		}

		if (!empty($post["firstname"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.insured_first_name like ". $this->db->escape("%" . $post["firstname"] . "%");
		}

		if (!empty($post["lastname"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.insured_last_name like ". $this->db->escape("%" . $post["lastname"] . "%");
		}
		
		if (!empty($post["created_from"])) {
			if ($where) $where .= ' AND'; 
			$where .= " claim.created >= " . $this->db->escape($post["created_from"]);
		}
		
		if (!empty($post["created_to"])) {
			$created_to = trim($post["created_to"]);
			if (strlen($created_to) == 10) {
				$created_to .= " 23:59:59";
			}
			if ($where) $where .= ' AND'; 
			$where .= " claim.created <= " . $this->db->escape($created_to);
		}
		
		if (!$where) {
			return array();
		}
		
		$sql  = "SELECT u1.email, concat_ws(' ', u1.first_name, u1.last_name) as claim_examiner, claim.id, claim.policy_no, claim.eclaim_no, claim.claim_no, claim.insured_first_name, claim.insured_last_name, claim.gender, claim.dob, claim.created, claim.diagnosis, claim.status, sum(expenses_claimed.amount_claimed) as amount_claimed FROM claim";
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
	public function search($data, $count=-1, $limit=-1, $sortby=array(), $force=FALSE) {
		$products = FALSE;
		if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EXAMINER))) {
			if (!$force && $this->ion_auth->get_user_id()) {
				$products = $this->ion_auth->get_users_products();
			}
		}
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->where($data);
		foreach ($sortby as $key => $val) {
			$this->db->order_by($key, $val);
		}
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
		return $this->db->get('claim')->result_array();
	}

	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as linenumber")->row()->linenumber;
	}
	
	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		foreach ($data as $key => $val) {
			$data[$key] = trim($val);
		}
		if (!empty($data['id'])) {
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
		$this->db->select_sum('amt_exceptional', 'exceptional');
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

	public function payee_format_array($array) {
		$rarr = array();
		foreach ($array as $val) {
			$key = $val['payment_type'];
			if ($key == 'cheque') {
				$key = $key . " : " . $val['payee_name'] . " : " . $val['address'] . " : " . $val['city'] . " : " . $val['province'] . " : " . $val['country'] . " : " . $val['postcode'] . " : " . $val['type'];
			} else {
				$key = $key . " : " . $val['payee_name'] . " : " . $val['bank'];
			}
			$rarr[$key] = $val;
		}
		return $rarr;
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
		if (!empty($data['id'])) {
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
			if (empty($data['created'])) {
				$data['created'] = date('Y-m-d H:i:s');
			}
			$this->db->insert('payees', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('payees', $id, $data, $sql);
			return $id;
		}
	}
	
	public function get_expenses_provider_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('expenses_provider')->row_array();
	}
	
	public function delete_provider_by_id($id) {
		$this->db->where('id', $id);
		$this->db->delete('expenses_provider');
	}
	
	public function expenses_provider_search($array) {
		$this->db->where($array);
		return $this->db->get('expenses_provider')->result_array();
	}
	
	/**
	 * Save or Update a provider
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function expenses_provider_save($data) {
		if (!empty($data['id'])) {
			// Update
			$id = $data['id'];
			$cur = $this->get_expenses_provider_by_id($id);
			unset($data['id']);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('expenses_provider', $data);
				$this->active_model->log_update('expenses_provider', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			// insert
			$this->db->insert('expenses_provider', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('expenses_provider', $id, $data, $sql);
			return $id;
		}
	}

	public function get_sla_report($product_short, $start_dt, $end_dt, $is_eclaim) {
		if (strlen($start_dt) == 10) {
			$start_dt .= " 00:00:00";
		}
		if (strlen($end_dt) == 10) {
			$end_dt .= " 23:59:59";
		}
		if ($is_eclaim == 2) {
			$sql  = "SELECT c.status, DATEDIFF(c.created,ec.created) as eclaim_tf_days, DATEDIFF(CURDATE(),c.created) as pending_days, DATEDIFF(c.last_update,c.created) as close_days, (SELECT SUM(e.amount_claimed) FROM expenses_claimed e WHERE e.claim_id=c.id) as amount FROM claim c";
			$sql .= " JOIN eclaim ec ON (c.eclaim_no=ec.eclaim_no)";
		} else {
			$sql  = "SELECT c.status, 0 as eclaim_tf_days, DATEDIFF(CURDATE(),c.created) as pending_days, DATEDIFF(c.last_update,c.created) as close_days, (SELECT SUM(e.amount_claimed) FROM expenses_claimed e WHERE e.claim_id=c.id) as amount FROM claim c";
		}
		$sql .= " WHERE c.created>=".$this->db->escape($start_dt)." AND c.created<=".$this->db->escape($end_dt);
		if (!empty($product_short)) {
			$sql .= " AND c.product_short=".$this->db->escape($product_short);
		}
		if ($is_eclaim == 2) {
			$sql .= " AND c.eclaim_no!=''";
		} else if ($is_eclaim == 1) {
			$sql .= " AND c.eclaim_no=''";
		}

		return $this->db->query($sql)->result_array();
	}

	public function get_sla_examiner_report($examiner_id, $product_short, $start_dt, $end_dt, $is_eclaim) {
		if (strlen($start_dt) == 10) {
			$start_dt .= " 00:00:00";
		}
		if (strlen($end_dt) == 10) {
			$end_dt .= " 23:59:59";
		}
		if ($is_eclaim == 2) {
			$sql  = "SELECT c.status, DATEDIFF(c.created,ec.created) as eclaim_tf_days, DATEDIFF(CURDATE(),c.created) as pending_days, DATEDIFF(c.last_update,c.created) as close_days, (SELECT SUM(e.amount_claimed) FROM expenses_claimed e WHERE e.claim_id=c.id) as amount, (SELECT SUM(e.amt_payable) FROM expenses_claimed e WHERE e.claim_id=c.id AND (e.status='Paid' OR e.status='Received')) as paid_avg FROM claim c";
			$sql .= " JOIN eclaim ec ON (c.eclaim_no=ec.eclaim_no)";
		} else {
			$sql  = "SELECT c.status, 0 as eclaim_tf_days, DATEDIFF(CURDATE(),c.created) as pending_days, DATEDIFF(c.last_update,c.created) as close_days, (SELECT SUM(e.amount_claimed) FROM expenses_claimed e WHERE e.claim_id=c.id) as amount, (SELECT SUM(e.amt_payable) FROM expenses_claimed e WHERE e.claim_id=c.id AND (e.status='Paid' OR e.status='Received')) as paid_avg FROM claim c";
		}
		$sql .= " WHERE c.created>=".$this->db->escape($start_dt)." AND c.created<=".$this->db->escape($end_dt);
		if (!empty($examiner_id)) {
			$sql .= " AND c.assign_to='".(int)$examiner_id."'";
		}
		if (!empty($product_short)) {
			$sql .= " AND c.product_short=".$this->db->escape($product_short);
		}
		if ($is_eclaim == 2) {
			$sql .= " AND c.eclaim_no!=''";
		} else if ($is_eclaim == 1) {
			$sql .= " AND c.eclaim_no=''";
		}

		return $this->db->query($sql)->result_array();
	}


  public function claim_report3($get) {
    // expense has status 'Approved','Declined','Paid','Pending','Received' and 'Duplicated'
    $sql  = "SELECT c.*, DATEDIFF(c.last_update,c.created) AS opendays, p.up_insuer, ";
    $sql .= " e3.coverage_code, e3.date_of_service, e3.finalize_date, e3.status AS e_status, e3.amount_claimed, e3.amt_payable, ";
    $sql .= " (SELECT SUM(e1.amount_claimed) FROM expenses_claimed e1 WHERE e1.claim_id=c.id AND e1.status IN ('Approved','Declined','Paid','Pending','Received')) AS claimed_amount, ";
    $sql .= " (SELECT SUM(e2.amt_payable) FROM expenses_claimed e2 WHERE e2.claim_id=c.id AND e2.status IN ('Approved','Paid')) AS paied_amount ";
    $sql .= " FROM claim c ";
    $sql .= " JOIN product p ON (c.product_short=p.product_short)";
    $sql .= " JOIN expenses_claimed e3 ON (e3.claim_id=c.id)";
    if (!empty($get["start_dt"]) && !empty($get["end_dt"])) {
      // Use start date and end date
      $sql .= " WHERE c.created>=".$this->db->escape($get["start_dt"]." 00:00:00")." AND c.created<=".$this->db->escape($get["end_dt"]." 23:59:59");
    } else if (!empty($get["year"])) {
      // User year
      $sql .= " WHERE c.created>=".$this->db->escape($get["year"]."-01-01 00:00:00")." AND c.created<=".$this->db->escape($get["year"]."-12-31 23:59:59");
    } else {
      // Use today
      $sql .= " WHERE 1=1";
    }

    if (!empty($get["finalized_start_dt"])) {
      $sql .= " AND e3.finalize_date>=".$this->db->escape($get["finalized_start_dt"]);
    }
    if (!empty($get["finalized_end_dt"])) {
      $sql .= " AND e3.finalize_date<=".$this->db->escape($get["finalized_end_dt"]);
    }

    if (!empty($get["status2"])) {
      $sql .= " AND c.status2=".$this->db->escape($get["status2"]);
    }

    if (!empty($get["products"])) {
      $pstr = "";
      foreach ($get["products"] as $prod) {
        $pstr .= $this->db->escape($prod).",";
      }
      if ($pstr) {
        $pstr = substr($pstr, 0, -1);
        $sql .= " AND c.product_short IN (".$pstr.")";
      }
    }

    if (!empty($get["up_insuer"])) {
      $sql .= " AND p.up_insuer=".$this->db->escape($get["up_insuer"]);
    }

		return $this->db->query($sql)->result_array();
  }

  public function claim_report4($get) {
    // expense has status 'Approved','Declined','Paid','Pending','Received' and 'Duplicated'
    $sql  = "SELECT c.*, DATEDIFF(c.last_update,c.created) AS opendays, p.up_insuer, ";
    $sql .= " (SELECT SUM(e1.amount_claimed) FROM expenses_claimed e1 WHERE e1.claim_id=c.id AND e1.status IN ('Approved','Declined','Paid','Pending','Received')) AS claimed_amount, ";
    $sql .= " (SELECT SUM(e2.amt_payable) FROM expenses_claimed e2 WHERE e2.claim_id=c.id AND e2.status IN ('Approved','Paid')) AS paied_amount ";
    $sql .= " FROM claim c ";
    $sql .= " JOIN product p ON (c.product_short=p.product_short)";
    if (!empty($get["start_dt"]) && !empty($get["end_dt"])) {
      // Use start date and end date
      $sql .= " WHERE c.created>=".$this->db->escape($get["start_dt"]." 00:00:00")." AND c.created<=".$this->db->escape($get["end_dt"]." 23:59:59");
    } else if (!empty($get["year"])) {
      // User year
      $sql .= " WHERE c.created>=".$this->db->escape($get["year"]."-01-01 00:00:00")." AND c.created<=".$this->db->escape($get["year"]."-12-31 23:59:59");
    } else {
      // Use today
      $sql .= " WHERE 1=1";
    }

    if (!empty($get["status2"])) {
      $sql .= " AND c.status2=".$this->db->escape($get["status2"]);
    }

    if (!empty($get["products"])) {
      $pstr = "";
      foreach ($get["products"] as $prod) {
        $pstr .= $this->db->escape($prod).",";
      }
      if ($pstr) {
        $pstr = substr($pstr, 0, -1);
        $sql .= " AND c.product_short IN (".$pstr.")";
      }
    }

    if (!empty($get["up_insuer"])) {
      $sql .= " AND p.up_insuer=".$this->db->escape($get["up_insuer"]);
    }

		return $this->db->query($sql)->result_array();
  }
}
