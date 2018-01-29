<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Master_model extends CI_Model {
	const TYPE_CLAIM='claim';
	const TYPE_CASE='case';
	/**
	 * Get case and claim master id
	 *
	 * @para string	$name	who required ID
	 * @return int	new ID
	 */
	public function get_id($name) {
		$data = array('name' => $name);
		$this->db->insert('case_claim_master', $data);
		return $this->db->insert_id();
	}

	public function get_number_str($id) {
		$no = str_pad($id, 7, 0, STR_PAD_LEFT);
		return $no;
	}
}
