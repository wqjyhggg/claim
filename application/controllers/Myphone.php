<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Jack
 */
class Myphone extends CI_Controller {
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		// if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_EAC)))
		$this->load->model('phone_model');
		$phoneid = $this->users_model->get_user_phoneid();
		$res ['login'] = 'NO';
		if ($phoneid) {
			$this->load->model('phone_model');
			$r = $this->phone_model->get_phone_login($phoneid);
			$res ['r'] = $r;
			if ($r === 'unknown') {
				$res ['login'] = 'Unknown';
			} else if (empty($r)) {
				$res ['login'] = 'NO';
			} else {
				$res ['login'] = 'OK';
				$res ['phone'] = $phoneid;
			}
		}

		header('Content-Type: application/json');
		die(json_encode($res));
	}
	
	public function login($phone_number='') {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		$this->load->model('phone_model');
		$phoneArr = $this->phone_model->get_working_number();
		if (in_array($phone_number, $phoneArr)) {
			$res['status'] = $this->phone_model->do_phone_opt(Phone_model::PHONE_OPT_LOGIN);
			$this->users_model->set_user_phone($phone_number);
			$res['phone'] = $phone_number;
		} else {
			$res['status'] = "NO";
			$res['message'] = "Unknow phone number";
		}
		
		header('Content-Type: application/json');
		die(json_encode($res));
	}
	
	public function logout() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		$this->load->model('phone_model');
		$res ['status'] = $this->phone_model->do_phone_opt(Phone_model::PHONE_OPT_LOGOUT);
		
		header('Content-Type: application/json');
		die(json_encode($res));
	}
	
	public function breaktm() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		$this->load->model('phone_model');
		$res ['status'] = $this->phone_model->do_phone_opt(Phone_model::PHONE_OPT_BREAK);
		
		header('Content-Type: application/json');
		die(json_encode($res));
	}
	
	public function waiting() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		$this->load->model('phone_model');
		$res ['status'] = $this->phone_model->do_phone_opt(Phone_model::PHONE_OPT_PAUSE);
		
		header('Content-Type: application/json');
		die(json_encode($res));
	}
	
	public function queue() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		$this->load->model('phone_model');
		$phoneid = $this->users_model->get_user_phoneid();
		$res ['queue'] = $this->phone_model->get_current_queue($phoneid);
		$res ['status'] = 'OK';
		$user = $this->users_model->get_by_id($this->ion_auth->get_user_id());
		$res ['phone'] = $user['phone'];
		
		header('Content-Type: application/json');
		die(json_encode($res));
	}
}
