<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Jack
 */
class Utility extends CI_Controller {
	public function index() {
		$rdata = array('status' => 'OK', 'message' => 'Success');
		header('Content-Type: application/json');
		echo json_encode($rdata);
	}

	public function currency($name) {
		$data = array();
		$this->load->model('currency_model');
		
		$data['name'] = $name;
		$data['options'] = $this->currency_model->get_list();
		$data['selected'] = '';
		
		$this->load->view('template/selection', $data);
	}
	
	public function province($name='', $country="CA") {
		if (!$this->ion_auth->logged_in() || empty($name)) exit;
		
		$this->load->model('country_model');
		$this->load->model('province_model');

		$cid = $this->country_model->get_id_by_short($country);
		if ($cid) {
			$data['name'] = $name;
			$data['options'] = $this->province_model->get_list($cid);
			$data['selected'] = '';
			$this->load->view('template/selection', $data);
		} else {
			die("Unknown Country");
		}
	}
	
	public function country($name='') {
		if (!$this->ion_auth->logged_in() || empty($name)) exit;
		
		$this->load->model('country_model');

		$data['name'] = $name;
		$data['options'] = $this->country_model->get_list(1);
		$data['selected'] = '';
		$this->load->view('template/selection', $data);
	}
}
