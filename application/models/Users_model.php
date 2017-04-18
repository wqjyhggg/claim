<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Users_model extends CI_Model {
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
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			
			$this->db->where('id', $id);
			$this->db->update('users', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('users', $data);
			return $this->db->insert_id();
		}
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
}