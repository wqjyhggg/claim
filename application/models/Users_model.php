<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Users_model extends CI_Model {
	const GROUP_ADMIN='Admin';
	const GROUP_EAC='EAC';
	const GROUP_MANAGER='Case Manager';
	const GROUP_EXAMINER='Examiner';
	const GROUP_ACCOUNTANT='Accountant';
	const GROUP_INSURER='Upper Insurer';
	
	public function get_groups() {
		return array(
				self::GROUP_ADMIN,
				self::GROUP_EAC,
				self::GROUP_MANAGER,
				self::GROUP_EXAMINER,
				self::GROUP_ACCOUNTANT,
				self::GROUP_INSURER,
		);
	}
	
	/**
	 * Return a shift options
	 *
	 * @return array result array, maybe null
	 */
	public function get_shift_options($flag=FALSE) {
		$rt = array(
				0 => '-- Select Shift--',
				'8am-2pm' => '8am-2pm',
				'2pm-8pm' => '2pm-8pm',
				'8pm-8am' => '8pm-8am');
		if (!$flag) {
			unset($rt[0]);
		}				
		return $rt;
	}

	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as rows")->row()->rows;
	}

	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data, $limit=30, $offset=0) {
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users";
		
		$where = array();
		if (isset($data["active"])) {
			$where[] = "active = '" . (int)$data["active"] . "'";
		}
		if (!empty($data["email"])) {
			$where[] = "email LIKE " . $this->db->escape('%'.trim($data["email"]).'%');
		}
		if (!empty($data["last_name"])) {
			$where[] = "last_name LIKE " . $this->db->escape('%'.trim($data["last_name"]).'%');
		}
		if (!empty($data["first_name"])) {
			$where[] = "first_name LIKE " . $this->db->escape('%'.trim($data["first_name"]).'%');
		}
		if (!empty($data["groups"])) {
			$where[] = "groups LIKE " . $this->db->escape('%'.$data["groups"].'%');
		}
		
		if (!empty($where)) {
			$sql .= " WHERE " .join(" AND ", $where); 
		}

		$array = array('id', 'email', 'last_name', 'last_name', 'first_name', 'active');
		if (isset($data["field"]) && in_array($data["field"], $array)) {
			$sql .= " ORDER BY " . $data["field"];
		} else {
			$sql .= " ORDER BY id";
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
	 * Save or Update a case
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['password'])) {
			$data['password'] = $this->ion_auth_model->hash_password($data['password']);
		}
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			$cur = $this->get_by_id($id);
			unset($data['id']);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('users', $data);
				$this->active_model->log_update('users', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		} else {
			// insert
			$this->db->insert('users', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('users', $id, $data, $sql);
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
		$this->db->where('id', $id);
		return $this->db->get('users')->row_array();
	}
	
	/**
	 * Get User by ID
	 *
	 * @param int $id
	 * @return array
	 */
	public function get_by_email($email) {
		$this->db->where('email', $email);
		$this->db->where('active', 1);
		return $this->db->get('users')->row_array();
	}
	
	/**
	 * Get User List by type
	 *
	 * @param string $type     	parameter
	 * @return array			
	 */
	public function get_user_by_type($type) {
		$this->db->select('users.id');
		$this->db->select("concat_ws(' ', users.first_name, users.last_name) as name");
		$this->db->select("users.username");
		$this->db->from('users');
		$this->db->join('users_groups', 'users.id=users_groups.user_id');
		$this->db->join('groups', 'groups.id=users_groups.group_id');
		$this->db->where('groups.name', $type);
		$this->db->order_by('users.id', 'ASC');
		$this->db->distinct();
		
		$users = array();
		$ul = $this->db->get()->result_array();
		foreach ($ul as $u) {
			$users[$u['id']] = $u['username'];
		}
		return $users;
	}
	
	public function get_users_products($user_id) {
		$this->db->where('id', $user_id);
		$user = $this->db->get('users')->row_array();
		if ($user) {
			return json_decode($user['products']);
		} else {
			return array();
		}
	}
	
	public function get_users_groups($user_id) {
		$this->db->where('id', $user_id);
		$user = $this->db->get('users')->row_array();
		if ($user && !empty($user['groups'])) {
			return json_decode($user['groups']);
		} else {
			return array();
		}
	}
}