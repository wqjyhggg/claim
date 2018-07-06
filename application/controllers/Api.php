<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Jack
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

		$data['api_id'] = $this->input->post('api_id');
		$data['policy'] = $this->input->post('policy');
		$data['birthday'] = $this->input->post('birthday');
		$data['ip'] = $this->input->server('REMOTE_ADDR');
		$rdata = array('status' => Api_model::STATUS_OK, 'message' => 'Success', 'token' => '');
		if (empty($data['api_id'])) {
			$rdata['status'] = Api_model::STATUS_ERROR;
			$rdata['message'] = 'Invilad ID';
		} else if (empty($data['birthday']) || !preg_match('/^[1-2][0-9]{3}-[01][0-9]-[0123][0-9]$/',$data['birthday'])) {
			$rdata['status'] = Api_model::STATUS_ERROR;
			$rdata['message'] = 'Unknown Birth Day';
		} else if (empty($data['policy'])) {
			$rdata['status'] = Api_model::STATUS_ERROR;
			$rdata['message'] = 'Invilad Parameter';
		}

		$policy = array();
		$firstname = $lastname = $birthday='';
		if ($rdata['status'] == Api_model::STATUS_OK) {
			$policies = $this->api_model->get_policy(array('policy' => $data['policy']));
			if (empty($policies)) {
				$rdata['status'] = Api_model::STATUS_ERROR;
				$rdata['message'] = 'Invilad Policy';
			} else {
				$hasbirthday = 0;
				if ($policies[0]['birthday'] == $data['birthday']) {
					$hasbirthday = 1;
					$firstname = $policies[0]['firstname'];
					$lastname = $policies[0]['lastname'];
					$birthday = $policies[0]['birthday'];;
				} else if ($policies[0]['isfamilyplan']) {
					foreach ($policies[0]['family'] as $p) {
						if ($p['birthday'] == $data['birthday']) {
							$hasbirthday = 1;
							$firstname = $p['firstname'];
							$lastname = $p['lastname'];
							$birthday = $p['birthday'];;
							break;
						}
					}
				}
				if ($hasbirthday) {
					$rdata['policy'] = $policies[0];
					$data['firstname'] = $firstname;
					$data['lastname'] = $lastname;
					$rdata['birthday'] = $birthday;
				} else {
					$rdata['status'] = Api_model::STATUS_ERROR;
					$rdata['message'] = 'No Matched Policy';
				}
			}
		}

		if ($rdata['status'] == Api_model::STATUS_OK) {
			$rdata['token'] = $this->api_model->get_token($data['api_id']);
			$data['token'] = $rdata['token'];
			$this->api_model->update($data);
		}
		
		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
	
	private function conn_verify() {
		$this->load->model('api_model');

		$data['api_id'] = $this->input->post('api_id');
		$data['token'] = $this->input->post('token');
		$data['ip'] = $this->input->server('REMOTE_ADDR');
		$rdata = array('status' => Api_model::STATUS_OK, 'message' => 'Success');
		if (empty($data['api_id'])) {
			$rdata['status'] = Api_model::STATUS_ERROR;
			$rdata['message'] = 'Invilad ID';
		} else if (empty($data['token'])) {
			$rdata['status'] = Api_model::STATUS_ERROR;
			$rdata['message'] = 'Invilad Parameter';
		} else {
			$data['last_tm'] = date('c');
			$this->api = $this->api_model->check_last($data);
			if (empty($this->api)) {
				$rdata['status'] = Api_model::STATUS_ERROR;
				$rdata['message'] = 'Unknown ID';
			}
		}
		return $rdata;
	}
	
	/*
	public function policy() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == Api_model::STATUS_OK) {
			$policy = array();
			$policies = $this->api_model->get_policy(array('policy' => $this->api['policy']));
			if (empty($policies)) {
				$rdata['status'] = Api_model::STATUS_ERROR;
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
		if ($rdata['status'] == Api_model::STATUS_OK) {
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
				$ncs['product_short'] = $cs['product_short'];
				$rdata['cases'][] = $ncs;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
	*/
	public function claims() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == Api_model::STATUS_OK) {
			$this->load->model('claim_model');
			$this->load->model('expenses_model');
			$claims = $this->claim_model->search(array('policy_no' => $this->api['policy'], 'insured_first_name' => $this->api['firstname'], 'insured_last_name' => $this->api['lastname'], 'dob' => $this->api['birthday']));
			$rdata['claims'] = array();
			foreach ($claims as $cl) {
				$ncl = array();
				$ncl['id'] = $cl['id'];
				$ncl['claim_no'] = $cl['claim_no'];
				$ncl['status'] = $cl['status'];
				//$ncl['claim_date'] = $cl['apply_date'];
				$ncl['claim_date'] = substr($cl['created'], 0, 10);
				$ncl['insured_first_name'] = $cl['insured_first_name'];
				$ncl['insured_last_name'] = $cl['insured_last_name'];
				$ncl['dob'] = $cl['dob'];
				$ncl['policy_no'] = $cl['policy_no'];
				$ncl['product_short'] = $cl['product_short'];
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
				$ncl['deductible'] = isset($amt['deductible']) ? (float)$amt['deductible'] : 0;
				$ncl['received'] = isset($amt['received']) ? (float)$amt['received'] : 0;
				$ncl['payable'] = isset($amt['payable']) ? (float)$amt['payable'] : 0;
				$ncl['exceptional'] = isset($amt['exceptional']) ? (float)$amt['exceptional'] : 0;
				$ncl['items'] = $this->expenses_model->search(array('claim_id' => $cl['id']));
				$rdata['claims'][] = $ncl;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}

	public function apply() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == Api_model::STATUS_OK) {
			$this->load->model('claim_model');
			$this->load->model('mytask_model');
			$this->load->model('master_model');
			$this->load->model('expenses_model');
			
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
			$policies = $this->api_model->get_policy(array('policy' => $data['policy_no']));
			if (empty($policies)) {
				$error['policy_no'] = 'Invalid Policy';
			} else {
				$data['policy_info'] = $policies[0];
			}
						
			$data['product_short'] = $this->input->post('product_short');
			$data['agent_id'] = $this->input->post('agent_id');
			$data['totaldays'] = $this->input->post('totaldays');
			$data['case_no'] = '';
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
			if (empty($data['physician_street_address'])) {
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
			$data['diagnosis'] = $this->input->post('diagnosis');
			$data['travel_insurance_coverage_guardians'] = $this->input->post('travel_insurance_coverage_guardians');
			$data['full_name'] = $this->input->post('full_name');
			$data['employee_name'] = $this->input->post('employee_name');
			$data['employee_street_address'] = $this->input->post('employee_street_address');
			$data['employee_post_code'] = $this->input->post('employee_post_code');
			$data['city_town'] = $this->input->post('city_town');
			$data['country2'] = $this->input->post('country2');
			$data['employee_telephone'] = $this->input->post('employee_telephone');
			$data['medical_description'] = $this->input->post('medical_description');
			$data['date_symptoms'] = $this->input->post('date_symptoms');
			$data['date_first_physician'] = $this->input->post('date_first_physician');
			$data['treatment_before'] = $this->input->post('treatment_before');
			$data['medication_date_1'] = $this->input->post('medication_date_1');
			$data['medication_1'] = $this->input->post('medication_1');
			$data['medication_date_2'] = $this->input->post('medication_date_2');
			$data['medication_2'] = $this->input->post('medication_2');
			$data['medication_date_3'] = $this->input->post('medication_date_3');
			$data['medication_3'] = $this->input->post('medication_3');
			
			$data['created'] = date('c');
			$data['created_by'] = 0;
			$data['status'] = Claim_model::STATUS_Applied;
			$data['assign_to'] = $this->mytask_model->get_auto_assign_examiner_id();
			
			if (empty($error)) {
				$id = $data['id'] = $this->master_model->get_id(Master_model::TYPE_CLAIM);
				$data['claim_no'] = $claim_no = $this->claim_model->generate_claim_no($id);
				
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
				$payee_str = '';
				if (!empty($payees)) {
					foreach ($payees['payee_name'] as $key => $name) {
						$payee_data = array(
							'payment_type'=>$this->input->post('payment_type'),
							'claim_id'=>$id,
							'bank'=> isset($payees['bank'][$key]) ? $payees['bank'][$key] : '',
							'payee_name'=> isset($payees['payee_name'][$key]) ? $payees['payee_name'][$key] : '',
							'account_cheque'=> isset($payees['account_cheque'][$key]) ? $payees['account_cheque'][$key] : '',
							'address'=> isset($payees['address'][$key]) ? $payees['address'][$key] : '',
							'created'=>date('c')
							);
						$this->claim_model->payees_save($payee_data);
						if ($payee_data['payment_type'] == 'cheque') {
							$payee_str = "cheque : ".$payee_data['payee_name']." : ".$payee_data['address'];
						} else {
							$payee_str = "direct deposit : ".$payee_data['payee_name']." : ".$payee_data['bank']." : ".$payee_data['account_cheque'];
						}
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
								'cellular' => '',
								'invoice'=>$val,
								'claim_no' => $claim_no,
								'claim_item_no' => $claim_no . '_' . $i,
								'case_no' => '',
								'provider_name'=> isset($expenses_claimed['provider_name'][$key]) ? $expenses_claimed['provider_name'][$key] : '',
								'referencing_physician'=> isset($expenses_claimed['referencing_physician'][$key]) ? $expenses_claimed['referencing_physician'][$key] : '',
								'coverage_code'=> isset($expenses_claimed['coverage_code'][$key]) ? $expenses_claimed['coverage_code'][$key] : '',
								'diagnosis'=> isset($expenses_claimed['diagnosis'][$key]) ? $expenses_claimed['diagnosis'][$key] : '',
								'service_description'=> isset($expenses_claimed['service_description'][$key]) ? $expenses_claimed['service_description'][$key] : '',
								'date_of_service'=> isset($expenses_claimed['date_of_service'][$key]) ? $expenses_claimed['date_of_service'][$key] : '',
								'amount_billed_org'=> isset($expenses_claimed['amount_billed_org'][$key]) ? $expenses_claimed['amount_billed_org'][$key] : '',
								'amount_client_paid_org'=> isset($expenses_claimed['amount_client_paid_org'][$key]) ? $expenses_claimed['amount_client_paid_org'][$key] : '',
								'amount_claimed_org'=> isset($expenses_claimed['amount_claimed_org'][$key]) ? $expenses_claimed['amount_claimed_org'][$key] : '',
								'currency'=> isset($expenses_claimed['currency'][$key]) ? $expenses_claimed['currency'][$key] : 'CAD',
								'comment'=> isset($expenses_claimed['comment'][$key]) ? $expenses_claimed['comment'][$key] : '',
								'pay_to'=>$payee_str,
								'status' => Expenses_model::EXPENSE_STATUS_Pending,
								'created_by' => 0,
								'created' => date('Y-m-d H:i:s'));
								
						$expenses__data['amount_billed'] = $this->expenses_model->get_currency_exchange($expenses__data['amount_billed_org'], $expenses__data['currency'], $expenses_claimed['date_of_service'][$key]);
						$expenses__data['amount_claimed'] = $this->expenses_model->get_currency_exchange($expenses__data['amount_claimed_org'], $expenses__data['currency'], $expenses_claimed['date_of_service'][$key]);
						$this->expenses_model->save($expenses__data);
					}
				}

				if (is_array($data['policy_info'])) {
					$data['policy_info'] = json_encode($data['policy_info']);
				}
				$id = $this->claim_model->save($data);
				if ($id) {
					$assign_to = $data['assign_to'];
					if (empty($assign_to)) {
						$assign_to = $this->mytask_model->get_auto_assign_examiner_id();
					}
					
					$this->load->model('mytask_model');
					// settings for my task section for case manager
					$task_data = array(
							'user_id' => $assign_to,
							'item_id' => $id,
							'task_no' => $claim_no,
							'category' => Mytask_model::CATEGORY_CLAIMS,
							'type' => Mytask_model::TASK_TYPE_CLAIM,
							'due_date' => date("Y-m-d", time() + 86400),
							'due_time' => date("H:i:s", time() + 86400),
							'priority' => Mytask_model::PRIORITY_LOW,
							'status' => Mytask_model::STATUS_ASSIGNED,
							'created_by' => 0,
							'created' => date('Y-m-d H:i:s'),
							'user_type' => Mytask_model::USER_TYPE_EXAM
					);
					// insert values to database
					$this->mytask_model->save($task_data);
						
					$rdata['claim_no'] = $claim_no;
					$rdata['id'] = $id;
				} else {
					$rdata['status'] = Api_model::STATUS_ERROR;
					$rdata['message'] = 'Can not creae your claim, please try it later';
				}
			} else {
				$rdata['error'] = $error;
				$rdata['status'] = Api_model::STATUS_ERROR;
				$rdata['message'] = 'Something wrong with data';
			}
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}

	public function diagnosis_suggest() {
		$rdata = $this->conn_verify();
		if ($rdata['status'] == Api_model::STATUS_OK) {
			$this->load->model('diagnosis_model');
			$rdata['suggestions'] = $this->diagnosis_model->search_description($this->input->post("query"));
		}

		header('Content-Type: application/json');
		echo json_encode($rdata);
	}
}
