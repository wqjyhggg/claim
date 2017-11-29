<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cron extends CI_Controller {
	public $error;
	public $s3;
	
	private function valid() {
		$this->error = '';
		
		if ((php_sapi_name() === 'cli')) {
			return TRUE;
		}
		show_error("ERROR", 404);
	}
	
	public function index() {
		if ($this->valid()) {
			die("OK\n");
		} else {
			die($this->error . "\n");
		}
	}
	
	public function save_to_s3() {
		$this->valid();
		
		$this->load->model('phone_model');
	
		$date = date("Y-m-d", time() - 43200);
		$req = '/api/cdr/'.$date;
		$data = array();
		$rt = $this->phone_model->sendRequest($req, $data, 'GET');
		
		$calls = json_decode($rt, true);
		foreach ($calls['rows'] as $call) {
			if (!isset($call['recording_url'])) continue;
			$filename = basename($call['recording_url']);
			if ($this->phone_model->save_s3_file($call['recording_url'], $date."/".$filename)) {
				echo "Save file : " . $date. "/" . $filename . "\n";
				// Update local file name if is has
				if ($this->phone_model->update_file_url($call['recording_url'], base_url("phone/file/".$date."/".$filename))) {
					echo "Update database : " . base_url("phone/file/".$date."/".$filename) . "\n";
				}
			}
		}
	}
}
