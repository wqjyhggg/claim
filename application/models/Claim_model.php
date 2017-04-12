<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Claim_model extends CI_Model {
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
				0	=> '-- Status --',
				'Processing' => 'Processing',
				'Pending' => 'Pending',
				'Processed' => 'Processed',
				'Paid' => 'Paid',
				'Closed' => 'Closed',
				'Recovered' => 'Recovered',
				'Appealed' => 'Appealed',
				'Exempted' => 'Exempted',
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
	public function get_claim_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('claim')->row_array();
	}

	/**
	 * Return a list of Claim
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
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
			if ($this->get_claim_by_id($id)) {
				// Update
				unset($data['id']);
				
				$this->db->where('id', $id);
				$this->db->update('claim', $data);
				return $id;
			}
		}
		
		// insert
		$this->load->model('master_model');
		$data['id'] = $this->master_model->get_id('claim');
		
		$this->db->insert('claim', $data);
		return $this->db->insert_id();
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
		$this->db->select_sum('amt_deductable', 'deductable');
		$this->db->select_sum('amt_received', 'received');
		$this->db->select_sum('amt_payable', 'payable');
		$this->db->select_sum('amt_exempt', 'exempt');
		$this->db->where('claim_id', $claim_id);
		return $this->db->get('expenses_claimed')->row_array();
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
			unset($data['id']);
			
			$this->db->where('id', $id);
			$this->db->update('payees', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('payees', $data);
			return $this->db->insert_id();
		}
	}
}