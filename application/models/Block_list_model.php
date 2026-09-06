<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Block_list_model extends CI_Model {
	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as linenumber")->row()->linenumber;
	}

	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data, $limit=30, $offset=0) {
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM block_list";
		
		$where = array();
		if (!empty($data["block_list_id"])) {
			$where[] = "block_list_id = '" . (int)$data["block_list_id"] . "'";
		}
		if (!empty($data["status"])) {
			$where[] = "status = '" . (int)$data["status"] . "'";
		}
		if (!empty($data["firstname"])) {
			$where[] = "firstname LIKE " . $this->db->escape('%'.trim($data["firstname"]).'%');
		}
		if (!empty($data["lastname"])) {
			$where[] = "lastname LIKE " . $this->db->escape('%'.trim($data["lastname"]).'%');
		}
		if (!empty($data["first_name"])) {
			$where[] = "first_name LIKE " . $this->db->escape('%'.trim($data["first_name"]).'%');
		}
		if (!empty($data["birthday"])) {
			$where[] = "`birthday= " . $this->db->escape($data["birthday"]);
		}
		
		if (!empty($where)) {
			$sql .= " WHERE " .join(" AND ", $where); 
		}

		$array = array('id', 'status', 'last_name', 'first_name', 'birthday');
		if (isset($data["field"]) && in_array($data["field"], $array)) {
			$sql .= " ORDER BY " . $data["field"];
		} else {
			$sql .= " ORDER BY block_list_id";
		}
		if (isset($data["order"]) && ($data["order"] == 'desc')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		$sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/**
	 * Save or Update a record
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['block_list_id'])) {
			// Update
			$block_list_id = $data['block_list_id'];
			$cur = $this->get_by_id($block_list_id);
			unset($data['block_list_id']);
			if ($cur) {
				$this->db->where('block_list_id', $block_list_id);
				$this->db->update('block_list', $data);
				$this->active_model->log_update('block_list', $block_list_id, $cur, $data, $this->db->last_query());
				return $block_list_id;
			}
		} else {
			// insert
			$this->db->insert('block_list', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('block_list', $id, $data, $sql);
			return $id;
		}
	}

	/**
	 * Get User by ID
	 *
	 * @param int $id
	 * @return array
	 */
	public function get_by_id($id) {
		$this->db->where('block_list_id', $id);
		return $this->db->get('block_list')->row_array();
	}
	
	public function check_list_name($firstname, $lastname, $birthday) {
		$this->db->where('firstname', $firstname);
		$this->db->where('lastname', $lastname);
		$this->db->where('birthday', $birthday);
		return $this->db->get('block_list')->row_array();
	}
	
	public function get_user_status($firstname, $lastname, $birthday) {
    $rt = ["inblock" => 0, "claim_amount" => 0, "case_amount" => 0];
    if ($u = $this->check_list_name($firstname, $lastname, $birthday)) {
      $rt["inblock"] = 1;
    }

    $sql = "SELECT SUM(e.amount_claimed) as amount FROM claim c JOIN expenses_claimed e ON (c.id=e.claim_id) WHERE LOWER(c.insured_first_name)=".$this->db->escape($firstname)." AND LOWER(c.insured_last_name)=".$this->db->escape($lastname)." AND c.dob=".$this->db->escape($birthday);
    if ($row = $this->db->query($sql)->row_array()) {
      $rt["claim_amount"] = floatval($row["amount"]);
    }

    $sql = "SELECT SUM(reserve_amount) as amount FROM `case` WHERE LOWER(insured_firstname)=".$this->db->escape($firstname)." AND LOWER(insured_lastname)=".$this->db->escape($lastname)." AND dob=".$this->db->escape($birthday)." AND claim_no=''";
    if ($row = $this->db->query($sql)->row_array()) {
      $rt["case_amount"] = floatval($row["amount"]);
    }

    return $rt;
  }
}
