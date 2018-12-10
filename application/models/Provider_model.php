<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Provider_model extends CI_Model {
	const ACTIVE="Active";
	const DISABLE="Disable";
	
	private $last_count;
	
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('provider')->row_array();
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
	
	public function last_rows() {
		return $this->last_count;
	}
	
	public function search($para, $limit=0, $start=0) {
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM provider";
		
		$where = array();
		if (isset($para["id"])) {
			$where[] = "id = '" . (int)$para["id"] . "'";
		}
		if ((sizeof($where) > 0)) {
			$sql .= " WHERE " . join(" AND ", $where);
		}
		
		if (isset($para["field"])) {
			if (isset($para['order'])) {
				$sql .= " ORDER BY " . $this->db->escape_str($para["field"]) . " " . $this->db->escape_str($para["order"]);
			} else {
				$sql .= " ORDER BY " . $this->db->escape_str($para["field"]) . " ASC";
			}
		}
		
		if ($limit) {
			if ($start) {
				$sql .= " LIMIT " . (int)$start . ", " . (int)$limit;
			} else {
				$sql .= " LIMIT " . (int)$limit;
			}
		}
		$rt = $this->db->query($sql)->result_array();
		$query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$this->last_count = $query->row()->Count;
		return $rt;
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