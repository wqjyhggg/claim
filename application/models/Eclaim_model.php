<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Eclaim_model extends CI_Model {
	/**
	 * Return a Claim Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('eclaim')->row_array();
	}

	// /**
	//  * Return a list of Claim
	//  *
	//  * @param array $data
	//  *        	search parameter
	//  * @return array result array, maybe null
	//  */
	// public function search($data, $count=-1, $limit=-1, $sortby=array()) {
	// 	$products = FALSE;
	// 	if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT, Users_model::GROUP_EXAMINER))) {
	// 		if ($this->ion_auth->get_user_id()) {
	// 			$products = $this->ion_auth->get_users_products();
	// 		}
	// 	}
	// 	$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
	// 	$this->db->where($data);
	// 	foreach ($sortby as $key => $val) {
	// 		$this->db->order_by($key, $val);
	// 	}
	// 	if ($products !== FALSE) {
	// 		if (empty($products)) {
	// 			return array();
	// 		}
	// 		$this->db->where_in('product_short', $products);
	// 	}
	// 	if ($count >= 0) {
	// 		if ($limit < 0) {
	// 			$this->db->limit($count);
	// 		} else {
	// 			$this->db->limit($count, $limit);
	// 		}
	// 	}
	// 	return $this->db->get('claim')->result_array();
	// }

	// public function last_rows() {
	// 	return $this->db->query("SELECT FOUND_ROWS() as rows")->row()->rows;
	// }
	
	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
        if (!empty($data['imgfile'])) {
            $data['imgfile'] = json_encode($data['imgfile']);
        }
        if (!empty($data['expenses_claimed_service_description'])) {
            $data['expenses_claimed_service_description'] = json_encode($data['expenses_claimed_service_description']);
        }
        if (!empty($data['expenses_claimed_provider_name'])) {
            $data['expenses_claimed_provider_name'] = json_encode($data['expenses_claimed_provider_name']);
        }
        if (!empty($data['expenses_claimed_referencing_physician'])) {
            $data['expenses_claimed_referencing_physician'] = json_encode($data['expenses_claimed_referencing_physician']);
        }
        if (!empty($data['expenses_claimed_date_of_service'])) {
            $data['expenses_claimed_date_of_service'] = json_encode($data['expenses_claimed_date_of_service']);
        }
        if (!empty($data['expenses_claimed_amount_client_paid_org'])) {
            $data['expenses_claimed_amount_client_paid_org'] = json_encode($data['expenses_claimed_amount_client_paid_org']);
        }
        if (!empty($data['expenses_claimed_amount_claimed_org'])) {
            $data['expenses_claimed_amount_claimed_org'] = json_encode($data['expenses_claimed_amount_claimed_org']);
        }
		if (!empty($data['id'])) {
			$id = $data['id'];
			if ($cur = $this->get_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('eclaim', $data);
				$this->active_model->log_update('eclaim', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		}

		$this->db->insert('eclaim', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('eclaim', $id, $data, $sql);
		return $id;
	}
}
