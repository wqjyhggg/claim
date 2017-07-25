<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Users_model extends CI_Model {
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
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('users')->result_array();
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
		$this->db->where('user_id', $user_id);
		$this->db->order_by('product_short', 'ASC');
		return $this->db->get('user_product')->result_array();
	}
	
	public function get_users_groups($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->order_by('group_id', 'ASC');
		return $this->db->get('users_groups')->result_array();
	}
	
	public function set_users_products($user_id, $products) {
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_product');
		foreach ($products as $product_short) {
			$data = array('user_id' => $user_id, 'product_short' => $product_short);
			$this->db->insert('user_product', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('user_product', $id, $data, $sql);
		}
	}
	
	public function set_users_groups($user_id, $groups) {
		$this->db->where('user_id', $user_id);
		$this->db->delete('users_groups');
		foreach ($groups as $group_id) {
			$data = array('user_id' => $user_id, 'group_id' => $group_id);
			$this->db->insert('users_groups', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('users_groups', $id, $data, $sql);
		}
	}
}