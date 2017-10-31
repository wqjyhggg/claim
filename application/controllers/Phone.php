<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Bhawani
 */
class Phone extends CI_Controller {
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		echo "OK";
	}
	
	public function search() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		// if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_EAC)))
		$this->load->model('phone_model');
		
		if ($this->input->post()) {
			$date = $this->input->post('dt');
		} else {
			$date = date("Y-m-d");
		}
		
		$req = '/api/cdr/'.$date;
		$data = array();
		$rt = $this->phone_model->sendRequest($req, $data, 'GET');
		
		$data['call_list'] = json_decode($rt, true);
		// echo "<pre>"; print_r($data['call_list']); die("XX"); //XXXXXXXXXXXXXXXXXXXXXX
		$data['date'] = $date;
		$data['action_url'] = base_url('phone/search');
		
		// render view data
		$this->template->write('title', SITE_TITLE . ' - Call list', TRUE);
		$this->template->write_view('content', 'phone/list', $data);
		$this->template->render();
	}
	
	public function hangup() {
		$arr = array();
		$arr['get'] = var_export($_GET, TRUE);
		$arr['post'] = var_export($_POST, TRUE);
		$json = file_get_contents("php://input");
		$arr['json'] = json_decode($json, TRUE);
		
		$this->load->model('phone_model');
		$this->phone_model->save(array('data' => json_encode($arr)));
	}
	
	public function sub() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		// if (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_EAC)))
		$this->load->model('phone_model');
		
		if ($this->input->post()) {
			$date = $this->input->post('dt');
		} else {
			$date = date("Y-m-d");
		}
		
		$req = '/api/subscriptions';
		$data = array('url' => base_url('phone/hangup'), 'event' => 'Hangup');
		$rt = $this->phone_model->sendRequest($req, $data);
		
		$data['data_list'] = json_decode($rt, true);
		echo "<pre>"; print_r($rt); die("XX"); //XXXXXXXXXXXXXXXXXXXXXX
		$data['date'] = $date;
		$data['action_url'] = base_url('phone/search');
		
		// render view data
		$this->template->write('title', SITE_TITLE . ' - Call list', TRUE);
		$this->template->write_view('content', 'phone/list', $data);
		$this->template->render();
	}
}
