<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Provider_model extends CI_Model {
	public function get_by_id($id) {
		$this->db->where('id', $id);
		$this->db->get('provider')->row_array();
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
			
			if ($rc = $this->get_by_id($id)) {
				$this->db->where('id', $id);
				$this->db->update('provider', $data);
				$this->active_model->log_update('provider', $id, $rc, $data, $this->db->last_query());
				return $id;
			}
		} else {
			// insert
			$this->db->insert('provider', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('provider', $id, $data, $sql);
			return $id;
		}
	}
	
	public function get_list($lat, $lng) {
		$sql  = "SELECT *, (3959 * acos(cos(radians(" . (float)$lat . " )) * 
										cos(radians(lat)) * 
										cos(radians(lng) - radians(" . (float)$lng . ")) + 
										sin(radians(" . (float)$lat . " )) * sin(radians(lat)))) AS distance";
		$sql .= " FROM `provider` HAVING `distance` < " . NEAREST_PROVIDERS_RANGE . "  ORDER BY `distance` DESC LIMIT 10";
		return $this->db->query($sql)->result_array();
	}
}