<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Currency_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $country_id		list by country
	 * @return array result array, maybe null
	 */
	public function get_list() {
		return array('CAD' => 'CAD', 'USD' => 'USD');
	}
}