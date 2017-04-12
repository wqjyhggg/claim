<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Bhawani
 */
class Api extends CI_Controller {
	public $api;
	
	public function index() {
		$data = array("status" => "OK", "message" => "API V0.01.01");
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	
	public function login() {
		$this->load->model('api_model');

		$data['ap_id'] = $this->input->post('ap_id');
		$data['token'] = $this->input->post('token');
		$data['policy'] = $this->input->post('policy');
		$data['birthday'] = $this->input->post('birthday');
		$data['ip'] = $this->input->server('REMOTE_ADDR');
		$rdata = array('status' => 'OK', 'message' => 'Success', 'token' => '');
		if (empty($data['ap_id'])) {
			$rdata['status'] = 'ERROR';
			$rdata['message'] = 'Invilad ID';
		} else if (!empty($data['token'])) {
			$rdata['status'] = 'WARNING';
			$rdata['message'] = 'Login Already ?';
		} else if (empty($data['birthday']) || !preg_match('/^[1-2][0-9]{3}-[01][0-9]-[0123][0-9]$/',$data['birthday'])) {
			$rdata['status'] = 'ERROR';
			$rdata['message'] = 'Unknown Birth Day';
		} else if (empty($data['policy'])) {
			$rdata['status'] = 'ERROR';
			$rdata['message'] = 'Invilad Parameter';
		}

		$policy = array();
		if ($rdata['status'] == 'OK') {
			$policies = $this->api_model->get_policy(array('policy' => $data['policy']));
			if (empty($policies)) {
				$rdata['status'] = 'ERROR';
				$rdata['message'] = 'Invilad Policy';
			} else if ($policies[0]['birthday'] != $data['birthday']) {
				$rdata['status'] = 'ERROR';
				$rdata['message'] = 'No Matched Policy';
			} else {
				$rdata['policy'] = $policies[0];
			}
		}

		if ($rdata['status'] == 'OK') {
			$rdata['token'] = $this->api_model->get_token($data['ap_id']);
			$data['token'] = $rdata['token'];
			$this->api_model->update($data);
		}
		
		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
	
	private function conn_verify() {
		$this->load->model('api_model');

		$data['ap_id'] = $this->input->post('ap_id');
		$data['token'] = $this->input->post('token');
		$data['ip'] = $this->input->server('REMOTE_ADDR');
		$rdata = array('status' => 'OK', 'message' => 'Success');
		if (empty($data['ap_id'])) {
			$rdata['status'] = 'ERROR';
			$rdata['message'] = 'Invilad ID';
		} else if (empty($data['token'])) {
			$rdata['status'] = 'WARNING';
			$rdata['message'] = 'Invilad Parameter';
		} else {
			$data['last_tm'] = date('c');
			$this->api = $this->api_model->check_last($data);
			if (empty($this->api)) {
				$rdata['status'] = 'ERROR';
				$rdata['message'] = 'Unknown ID';
			}
		}
		return $rdata;
	}
	
	public function policy() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == 'OK') {
			$policy = array();
			$policies = $this->api_model->get_policy(array('policy' => $this->api['policy']));
			if (empty($policies)) {
				$rdata['status'] = 'ERROR';
				$rdata['message'] = 'No Policy Information';
			} else {
				$rdata['policy'] = $policies[0];
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}

	public function cases() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == 'OK') {
			$this->load->model('case_model');
			$cases = $this->case_model->search(array('policy_no' => $this->api['policy'], 'claim_no' => '', 'status' => 'A'));
			$rdata['cases'] = array();
			foreach ($cases as $cs) {
				$ncs = array();
				$ncs['id'] = $cs['id'];
				$ncs['case_no'] = $cs['case_no'];
				$ncs['insured_address'] = $cs['insured_address'];
				$ncs['insured_firstname'] = $cs['insured_firstname'];
				$ncs['insured_lastname'] = $cs['insured_lastname'];
				$ncs['dob'] = $cs['dob'];
				$ncs['created'] = $cs['created'];
				$ncs['reason'] = $cs['reason'];
				$ncs['policy_no'] = $cs['policy_no'];
				$rdata['cases'][] = $ncs;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
	
	public function claims() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == 'OK') {
			$this->load->model('claim_model');
			$cases = $this->claim_model->search(array('policy_no' => $this->api['policy']/*, 'is_complete' => 'Y'*/));
			$rdata['claims'] = array();
			foreach ($cases as $cl) {
				$ncl = array();
				$ncl['id'] = $cl['id'];
				$ncl['claim_no'] = $cl['claim_no'];
				$ncl['claim_date'] = $cl['claim_date'];
				$ncl['insured_first_name'] = $cl['insured_first_name'];
				$ncl['insured_last_name'] = $cl['insured_last_name'];
				$ncl['dob'] = $cl['dob'];
				$ncl['policy_no'] = $cl['policy_no'];
				$ncl['case_no'] = $cl['case_no'];
				$ncl['physician_name'] = $cl['physician_name'];
				$ncl['clinic_name'] = $cl['clinic_name'];
				$ncl['physician_name_canada'] = $cl['physician_name_canada'];
				$ncl['clinic_name_canada'] = $cl['clinic_name_canada'];
				$ncl['payment_type'] = $cl['payment_type'];
				$ncl['reason'] = $cl['reason'];
				$amt = $this->claim_model->expenses_summary($cl['id']);
				$ncl['billed'] = isset($amt['billed']) ? (float)$amt['billed'] : 0;
				$ncl['client_paid'] = isset($amt['client_paid']) ? (float)$amt['client_paid'] : 0;
				$ncl['claimed'] = isset($amt['claimed']) ? (float)$amt['claimed'] : 0;
				$ncl['deductable'] = isset($amt['deductable']) ? (float)$amt['deductable'] : 0;
				$ncl['received'] = isset($amt['received']) ? (float)$amt['received'] : 0;
				$ncl['payable'] = isset($amt['payable']) ? (float)$amt['payable'] : 0;
				$ncl['exempt'] = isset($amt['exempt']) ? (float)$amt['exempt'] : 0;
				$rdata['claims'][] = $ncl;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
	
	public function apply() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == 'OK') {
			$this->load->model('claim_model');
			$data = array();
			$error = array();
			
			$data['insured_first_name'] = $this->input->post('insured_first_name');
			if (empty($data['insured_first_name'])) {
				$error['insured_first_name'] = 'Required';
			}
			
			$data['insured_last_name'] = $this->input->post('insured_last_name');
			if (empty($data['insured_last_name'])) {
				$error['insured_last_name'] = 'Required';
			}
			
			$data['gender'] = $this->input->post('gender');
			$data['personal_id'] = $this->input->post('personal_id');

			$data['dob'] = $this->input->post('dob');
			if (empty($data['dob']) || !preg_match('/^[1-2][0-9]{3}-[01][0-9]-[0123][0-9]$/',$data['dob'])) {
				$error['dob'] = 'Invalid Date of Birth';
			}
			
			$data['policy_no'] = $this->api['policy'];
			$data['policy_info'] = $this->input->post('policy_info');
			$data['case_no'] = $this->input->post('case_no');
			$data['school_name'] = $this->input->post('school_name');
			$data['group_id'] = $this->input->post('group_id');
			$data['apply_date'] = $this->input->post('apply_date');
			$data['arrival_date'] = $this->input->post('arrival_date');
			$data['guardian_name'] = $this->input->post('guardian_name');
			$data['guardian_phone'] = $this->input->post('guardian_phone');
			$data['street_address'] = $this->input->post('street_address');
			$data['city'] = $this->input->post('city');
			$data['province'] = $this->input->post('province');
			$data['telephone'] = $this->input->post('telephone');
			$data['email'] = $this->input->post('email');
			$data['post_code'] = $this->input->post('post_code');
			if (empty($data['post_code'])) {
				$error['post_code'] = 'Required';
			}
			$data['arrival_date_canada'] = $this->input->post('arrival_date_canada');
			$data['cellular'] = $this->input->post('cellular');
			$data['contact_first_name'] = $this->input->post('contact_first_name');
			$data['contact_last_name'] = $this->input->post('contact_last_name');
			$data['contact_email'] = $this->input->post('contact_email');
			$data['contact_phone'] = $this->input->post('contact_phone');
			$data['physician_name'] = $this->input->post('physician_name');
			$data['clinic_name'] = $this->input->post('clinic_name');
			$data['physician_street_address'] = $this->input->post('physician_street_address');
			if (empty($data['post_code'])) {
				$error['physician_street_address'] = 'Required';
			}
			$data['physician_city'] = $this->input->post('physician_city');
			$data['country'] = $this->input->post('country');
			$data['physician_post_code'] = $this->input->post('physician_post_code');
			$data['physician_telephone'] = $this->input->post('physician_telephone');
			$data['physician_alt_telephone'] = $this->input->post('physician_alt_telephone');
			$data['physician_name_canada'] = $this->input->post('physician_name_canada');
			$data['clinic_name_canada'] = $this->input->post('clinic_name_canada');
			$data['physician_street_address_canada'] = $this->input->post('physician_street_address_canada');
			$data['physician_city_canada'] = $this->input->post('physician_city_canada');
			$data['physician_post_code_canada'] = $this->input->post('physician_post_code_canada');
			$data['physician_telephone_canada'] = $this->input->post('physician_telephone_canada');
			$data['physician_alt_telephone_canada'] = $this->input->post('physician_alt_telephone_canada');
			$data['other_insurance_coverage'] = $this->input->post('other_insurance_coverage');
			$data['travel_insurance_coverage_guardians'] = $this->input->post('travel_insurance_coverage_guardians');
			$data['full_name'] = $this->input->post('full_name');
			$data['employee_name'] = $this->input->post('employee_name');
			$data['employee_street_address'] = $this->input->post('employee_street_address');
			$data['city_town'] = $this->input->post('city_town');
			$data['country2'] = $this->input->post('country2');
			$data['employee_telephone'] = $this->input->post('employee_telephone');
			$data['medical_description'] = $this->input->post('medical_description');
			$data['date_symptoms'] = $this->input->post('date_symptoms');
			$data['date_first_physician'] = $this->input->post('date_first_physician');
			$data['travel_insurance_coverage'] = $this->input->post('travel_insurance_coverage');
			$data['medication_date_1'] = $this->input->post('medication_date_1');
			$data['medication_1'] = $this->input->post('medication_1');
			$data['medication_date_2'] = $this->input->post('medication_date_2');
			$data['medication_2'] = $this->input->post('medication_2');
			$data['medication_date_3'] = $this->input->post('medication_date_3');
			$data['medication_3'] = $this->input->post('medication_3');
			
			$data['created'] = date('c');
			$data['created_by'] = 0;
			$data['status'] = 'processing';
			
			if (empty($error)) {
				$id = $this->claim_model->save($data);
				if ($id) {
					$claim_no = $this->claim_model->generate_claim_no($id);
					$data = array('id' => $id, 'claim_no' => $claim_no);
					if (empty($this->input->post('case_no'))) {
						$this->load->model('case_model');
						$case = $this->case_model->search(array('case_no' => $this->input->post('case_no')));
						if ($case) {
							$this->case_model->save(array('id' => $case['id'], 'claim_no' => $claim_no));
						}
					}
					
					// upload claim pdf files to server
					$files = @$_FILES['files_multi'];
					if (!empty($files)) {
						// create directory to copy/shift files
						@mkdir(UPLOADFULLPATH . 'claim_files/'.$id, 0777);
							
						$file_names = [];
						// load upload class
						$config['upload_path'] = UPLOADFULLPATH . '/claim_files/'.$id;
						$config['allowed_types'] = '*';
						$config['overwrite'] = FALSE;
						$this->load->library('upload', $config);
						
						// initialize upload config
						$this->upload->initialize($config);
						
						foreach ($files['name'] as $key => $value) {
							if($files['name'][$key]) {
								$_FILES['userfile']['name'] = $files['name'][$key];
				                $_FILES['userfile']['type'] = $files['type'][$key];
				                $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
				                $_FILES['userfile']['error'] = $files['error'][$key];
				                $_FILES['userfile']['size'] = $files['size'][$key];
								
								// upload file to server
								$this->upload->do_upload();
								$file_data = $this->upload->data();
								$file_names[] = $file_data['file_name'];
							}
						}
	
						$data['files'] = implode(",", $file_names);
					}
	
					// insert payee information
					$payees = $this->input->post('payees');
					if (!empty($payees)) {
						foreach ($payees['bank'] as $key => $val) {
							$payee_data = array(
								'payment_type'=>$this->input->post('payment_type_'.($key+1)),
								'claim_id'=>$id,
								'bank'=>$val,
								'payee_name'=>$payees['payee_name'][$key],
								'account_cheque'=>$payees['account_cheque'][$key],
								'address'=>$payees['address'][$key],
								'created'=>date('c')
								);
							$this->claim_model->payees_save($payee_data);
						}
					}
	
					// insert expenses_claimed data
					$expenses_claimed = $this->input->post('expenses_claimed');
					if (!empty($expenses_claimed)) {	
						$i = 0;
						foreach ($expenses_claimed['invoice'] as $key => $val) {
							$i++;
							$expenses__data = array(
								'claim_id'=>$id,
								'cellular'=>$array['cellular'],
								'invoice'=>$val,
								'claim_no'=>$claim_no,
								'claim_item_no'=>$claim_no.'_'.$i,
								'case_no'=>$array['case_no'],
								'provider_name'=>$expenses_claimed['provider_name'][$key],
								'referencing_physician'=>$expenses_claimed['referencing_physician'][$key],
								'coverage_code'=>$expenses_claimed['coverage_code'][$key],
								'diagnosis'=>$expenses_claimed['diagnosis'][$key],
								'service_description'=>$expenses_claimed['service_description'][$key],
								'date_of_service'=>$expenses_claimed['date_of_service'][$key],
								'amount_billed'=>$expenses_claimed['amount_billed'][$key],
								'amount_client_paid'=>$expenses_claimed['amount_client_paid'][$key],
								'pay_to'=>$expenses_claimed['payee'][$key],
								'comment'=>$expenses_claimed['comment'][$key],
								'created'=>date('Y-m-d H:i:s')
								);
							$this->claim_model->expenses_save($expenses__data);
						}
					}
	
	
					/* what is intake form ???? XXXXXXXXXXXXXXXXX
					// insert intake forms if exists
					$no_of_form = $array['no_of_form'];
	
					// load upload class
					$config['upload_path'] = UPLOADFULLPATH . 'intake_forms/';
					$config['allowed_types'] = '*';
					$config['overwrite'] = FALSE;
					$this->load->library('upload', $config);
	
					// initialize upload config
					$this->upload->initialize($config);
					if($no_of_form)
					{
						// add intake form batch
						for($i = 1; $i <= $no_of_form; $i++)
						{
							// initialize file names array
							$file_names = [];
	
							// upload files to server
							$files = @$_FILES['files_'.$i];
							if(!empty($files))
							{	foreach ($files['name'] as $key => $value) 
								{	
									if($files['name'][$key])
									{
										$_FILES['userfile']['name'] = $files['name'][$key];
						                $_FILES['userfile']['type'] = $files['type'][$key];
						                $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
						                $_FILES['userfile']['error'] = $files['error'][$key];
						                $_FILES['userfile']['size'] = $files['size'][$key];
										
										$field_name = 'userfile';
	
										// upload file to server
										$this->upload->do_upload();
										$file_data = $this->upload->data();
										$file_names[] = $file_data['file_name'];
									}
								}
							}
	
							// generate data array
							$data_intake = array(
								'case_id' => $record_id,
								'created_by' => $this->ion_auth->user()->row()->id,
								'notes' => $array['notes_'.$i],
								'created' => date("Y-m-d H:i:s"),
								'docs' => implode(",", $file_names),
								'type'=>'CLAIM'
								);
	
							// if file is getting from email/print function
							if(@$array['file_pdf_'.$i])
							{
								$data_intake['docs'] = $array['file_pdf_'.$i];
							}
	
							// save values to database
							$intake_form_id = $this->common_model->save("intake_form", $data_intake);
	
							// create directory to identify intake files
							@mkdir(UPLOADFULLPATH . 'intake_forms/'.$intake_form_id, 0777);
	
							// if file is getting from email/print function
							if(@$array['file_pdf_'.$i])
							{
								$fname = $array['file_pdf_'.$i];
								copy(UPLOADFULLPATH . "temp/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
								unlink(UPLOADFULLPATH . "$fname");
							}
							// move all files to that directory
							if(!empty($file_names))
								foreach ($file_names as $fname)
								{
									copy(UPLOADFULLPATH . "intake_forms/$fname", UPLOADFULLPATH . "intake_forms/$intake_form_id/$fname");
									unlink(UPLOADFULLPATH . "intake_forms/$fname");
								}
						}
					}
					*/
							
					$this->claim_model->save($data);
	
					// settings for my task section for case manager
					$this->load->model('mytask_model');
					$task_data = array(
						'user_id'=>0,
						'item_id'=>$id,
						'task_no'=>$claim_no,
						'category'=>'Claims',
						'type'=>'CLAIM',
						'priority'=>'Normal',
						'created_by'=>0,
						'created'=>date('Y-m-d H:i:s'),
						'user_type'=>'claimsmanager'
						);
					// insert values to database
					$this->mytask_model->save($task_data);

					$rdata['claim_no'] = $claim_no;
					$rdata['id'] = $id;
				} else {
					$rdata['status'] = 'ERROR';
					$rdata['message'] = 'Can not creae your claim, please try it later';
				}
			} else {
				$rdata['error'] = $error;
				$rdata['status'] = 'ERROR';
				$rdata['message'] = 'Something wrong with data';
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}

	public function diagnosis_suggest() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == 'OK') {
			$this->load->model('diagnosis_model');
			$rdata['suggestions'] = $this->diagnosis_model->search_description($this->input->post("query"));
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
}
