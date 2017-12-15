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
	
	public function getfile() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$this->load->model('phone_model');
		$rdata = $this->phone_model->getmyurl();

		header('Content-Type: application/json');
		echo json_encode($rdata);
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
		echo "<pre>"; print_r($data['call_list']); die("XX");
		$data['date'] = $date;
		$data['action_url'] = base_url('phone/search');
		
		// render view data
		$this->template->write('title', SITE_TITLE . ' - Call list', TRUE);
		$this->template->write_view('content', 'phone/list', $data);
		$this->template->render();
	}
	
	public function hangup() {
		$json = file_get_contents("php://input");
		
		$this->load->model('phone_model');
		$this->phone_model->save_callback_hangup($json);
	}
	
	public function newcall() {
		$json = file_get_contents("php://input");
		
		$this->load->model('phone_model');
		$this->phone_model->save_callback_newcall($json);
	}
	
	public function answer() {
		$json = file_get_contents("php://input");
		
		$this->load->model('phone_model');
		$this->phone_model->save_callback_answer($json);
	}
	
	public function enterqueue() {
		$json = file_get_contents("php://input");
		
		$this->load->model('phone_model');
		$this->phone_model->save_callback_enterqueue($json);
	}
	
	public function ringing() {
		$json = file_get_contents("php://input");
		$json = '{"account":"aurat","agent":"test2","caller_id_name":"QINGJIAN WU","caller_id_number":"4167106618","destination_number":"19054756656","direction":"inbound","event":"Ringing","event_time":"2017-12-14T22:43:22Z","id":"d223c930-aefd-487a-a4ed-0864ecd5d8e9","queue":"jf","start_time":"2017-12-14T22:43:17Z"}';
		$this->load->model('phone_model');
		$this->phone_model->save_callback_ringing($json);
	}
	
	public function sub() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$this->load->model('phone_model');
		
		echo "<pre>";
		$req = '/api/subscriptions';
		$para = array();
		$rt = $this->phone_model->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);
		print_r($data);
		// Remove if there is any
		foreach ($data as $rc) {
			$req = '/api/subscription/'.$rc['id'];
			$para = array();
			$this->phone_model->sendRequest($req, $para, "DELETE");
		}
		
		$req = '/api/subscription';
		$para = array('url' => base_url('phone/hangup'), 'event' => 'Hangup');
		$rt = $this->phone_model->sendRequest($req, $para);
		print_r($rt); 

		$req = '/api/subscription';
		$para = array('url' => base_url('phone/newcall'), 'event' => 'NewCall');
		$rt = $this->phone_model->sendRequest($req, $para);
		print_r($rt);
		
		$req = '/api/subscription';
		$para = array('url' => base_url('phone/answer'), 'event' => 'Answer');
		$rt = $this->phone_model->sendRequest($req, $para);
		print_r($rt);

		$req = '/api/subscription';
		$para = array('url' => base_url('phone/enterqueue'), 'event' => 'EnterQueue');
		$rt = $this->phone_model->sendRequest($req, $para);
		print_r($rt); 

		$req = '/api/subscription';
		$para = array('url' => base_url('phone/ringing'), 'event' => 'Ringing');
		$rt = $this->phone_model->sendRequest($req, $para);
		print_r($rt);

		// Get current all setted event
		$req = '/api/subscriptions';
		$para = array();
		$rt = $this->phone_model->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);
		print_r($data); 
		echo "<pre>";
		die("\nEnd of All");
	}
	
	public function agent() {
		$this->load->model('pdf_model');
		$data['title'] = "test title";
		$this->pdf_model->output('test', $data);
		/*
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		*/
		$this->load->model('phone_model');
		
		echo "<pre>";
		/*
		$req = '/api/agent/test2/status';
		$para = array();
		$rt = $this->phone_model->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);
		print_r($rt);
		print_r($data);
		*/
		
		$req = '/api/agent/test1/status';
		$para = array('login' => true);
		$rt = $this->phone_model->sendRequest($req, $para, 'PUT');
		$data = json_decode($rt, true);
		echo "=====";
		print_r($rt);
		print_r($data);
		$req = '/api/agents';
		$para = array();
		$rt = $this->phone_model->sendRequest($req, $para, 'GET');
		$data = json_decode($rt, true);
		//print_r($rt);
		print_r($data);
		
		/*
		$req = 'api/agent/test1/status';
		$para = array('login' => false);
		$rt = $this->phone_model->sendRequest($req, $para);
		$data = json_decode($rt, true);
		//print_r($rt);
		print_r($data);
		*/
	}
	
	public function file($dt, $filename) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$this->load->model('phone_model');
		
		if ($r = $this->phone_model->get_s3_file($dt . "/" . $filename)) {
			header("Content-Type: {$r['ContentType']}");
			echo $r['Body'];
		} else {
			show_404('No such file', TRUE);
		}
	}
}
