<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Provider_model extends CI_Model {
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
			$this->db->update('provider', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('provider', $data);
			return $this->db->insert_id();
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