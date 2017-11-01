<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Province_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $country_id		list by country
	 * @return array result array, maybe null
	 */
	public function get_list($country_id) {
		$this->db->where('country_id', $country_id);
		$this->db->order_by('name');
		$rt = $this->db->get('province')->result_array();
		$rArr = array('' => '-- Selecet Province --');
		foreach ($rt as $rc) {
			$rArr[$rc['short_code']] = $rc['name'];
		}
		return $rArr;
	}

	/**
	 * Get country list
	 * 
	 * @param string $country_short		country short name
	 * @return array result array, maybe null
	 */
	public function get_list_by_country_short($country_short) {
		$this->load->model('country_model');
		$cid = $this->country_model->get_id_by_short($country_short);
		$rArr = array();
		if ($cid) {
			return $this->get_list($cid);
		}
		return $rArr;
	}

}