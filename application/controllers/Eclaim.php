<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 */
class Eclaim extends CI_Controller {
	private $limit = 20;
	
	public function __construct() {
		parent::__construct();
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the claim page
	public function index() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('eclaim_model');
			$this->load->model('html_model');

			$limit = $this->limit;
			$offset = $this->uri->segment(3);

			$post = $this->input->get();
			$this->data['eclaims'] = $this->eclaim_model->search($post, $this->limit, $offset);
			// if ($this->data['eclaims'] && (sizeof($this->data['eclaims']) == 1)) {
			// 	redirect('eclaim/detail/'.$this->data['eclaims'][0]['id'], 'refresh');
			// }
			$config['total_rows'] = $this->eclaim_model->last_rows();
			$config['base_url'] = site_url('eclaim/index');
			$config['per_page'] = $this->limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0) {
				$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
				$this->data['export_para'] = $config ['suffix'];
			}

			$this->pagination->initialize($config); // initiaze pagination config

			$this->data['pagination'] = $this->pagination->create_links(); // create pagination links
			$this->data['html_model'] = $this->html_model;
			                                    
			// render view data
			$this->template->write('title', SITE_TITLE . ' - Eclaim', TRUE);
			$this->template->write_view('content', 'eclaim/index', $this->data);
			$this->template->render();
		}
	}

	public function setcaseno() {
		if ($this->ion_auth->logged_in()) {
			$this->load->model('eclaim_model');

			$post = $this->input->post();
			if (!empty($post['id']) && !empty($post['case_no'])) {
				$ec = $this->eclaim_model->get_by_id($post['id']);
				if ($ec) {
					$logs = json_decode($ec['logs'], true);
					$logs[] = date("Y-m-d H:i:s").' - update case_no to '.$post['case_no'].' processed_by '.$this->ion_auth->get_user_id();
					$data = array(
						'id' => $post['id'], 
						'case_no' => $post['case_no'],
						'logs' => json_encode($logs),
					);
					$id = $this->eclaim_model->save($data);
					$this->session->set_flashdata('success', "EClaim successfully updated.");
				}
			} else {
				$this->session->set_flashdata('error', 'post data has something wrong.');
			}
			redirect("eclaim/detail/".$post['id']);
		}
		redirect("eclaim");
	}

	public function disapprove($id) {
		$json = array("status" => 0, "message" => 'Sorry, you don\'t have any permission to access this function.');
		if ($this->ion_auth->logged_in()) {
			$this->load->model('eclaim_model');

			$post = $this->input->post();
			if (!empty($post['id']) && ($post['id'] == $id)) {
				$ec = $this->eclaim_model->get_by_id($post['id']);
				if ($ec) {
					$logs = json_decode($ec['logs'], true);
					$logs[] = date("Y-m-d H:i:s").' - Refuse this Eclaim by '.$this->ion_auth->get_user_id();
					$data = array('id' => $post['id'], 'status' => 3);
					$data['notes'] = empty($post['notes']) ? '' : $post['notes'];
					$data['processed_by'] = $this->ion_auth->get_user_id();
					$data['intnotes'] = 'Refuse this claim by ' . $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name . " (". $this->ion_auth->get_user_id() .")";
					$data['logs'] = json_encode($logs);
					$id = $this->eclaim_model->save($data);

					$this->load->model("mymail_model");
					$subject = "Web claim - " . $ec['eclaim_no'] . " - " . $ec['insured_first_name'];
					$to = $ec['email'];
					$body  = "Dear " . $ec['insured_first_name'] . ",<br /><br />\n"; 
					$body  .= "The web claim you submitted on ".date("Y-m-d")." has been reviewed. By visiting eclaim.jfgroup.ca and logging in to your account, you may review further details under your claim history.<br /><br />\n"; 
					$body  .= "You are receiving this email due to one of the following reasons:<br /><br />\n"; 
					$body  .= "- You have submitted a duplicate claim. You are not required to do anything further.<br /><br />\n"; 
					$body  .= "- Your claim was submitted under an incorrect policy. You are not required to take any further action as a claim examiner will make the necessary corrections.<br /><br />\n"; 
					$body  .= "- You have submitted additional documentation(s) related to an existing claim. You are not required to take any further action as a claim examiner will make the necessary corrections.<br /><br />\n"; 
					$body  .= "- Your total claim amount exceeds $500. You are required to mail your claim to our office. Please follow the instructions https://www.jfgroup.ca/how_to_claim.<br /><br />\n"; 
					$body  .= "This is an auto-generated email, please do not reply directly. We will reach out to you if your cooperation is needed. Should you have any questions, please contact us by phone at 905-707-3335 or email at claim@otcww.com.<br /><br />\n"; 
					$body  .= "Ontime Care Worldwide Inc. is the authorized claims administrator for JF Insurance policies.<br /><br />\n"; 
					$body  .= "Best regards,<br />\n"; 
					$body  .= "Ontime Care Worldwide Inc. <br />\n"; 
					$body  .= "Telephone: 905-707-3555<br />\n"; 
					$body  .= "Email: claim@otcww.com <br />\n"; 
					$this->mymail_model->send_mymail($to, $subject, $body, array(), 'Ontime Care Worldwide Inc.');
						
					$json["message"] = "Success";
					$json["status"] = 2;
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}

	// redirect if needed, otherwise display the create claim page
	public function create_claim() {
		if (! $this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			// redirect them to the home page because they must be an claim manager or claim examiner to view this
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			// validate form input
			//$this->form_validation->set_rules('diagnosis', 'Diagnosis ', 'required');
			//$this->form_validation->set_rules('date_symptoms', 'Date symptoms or injury first appeared ', 'required');
			$this->form_validation->set_rules('insured_first_name', 'Insured First Name ', 'required');
			$this->form_validation->set_rules('insured_last_name', 'Insured Last Name ', 'required');
			$this->form_validation->set_rules('guardian_name', 'Guardian Name ', '');
			$this->form_validation->set_rules('city', 'city ', '');
			$this->form_validation->set_rules('province', 'province ', 'alpha');
			$this->form_validation->set_rules('full_name', 'full name ', '');
			$this->form_validation->set_rules('employee_name', 'employee name ', '');
			$this->form_validation->set_rules('city_town', 'city town ', '');
			
			//$this->form_validation->set_rules('employee_telephone', 'employee telephone ', 'numeric');
			$this->form_validation->set_rules('amount_billed_org', 'amount billed ', 'numeric');
			$this->form_validation->set_rules('account_cheque', 'account no ', 'numeric');
			$this->form_validation->set_rules('amount_client_paid_org', 'amount client paid ', 'numeric');
			//$this->form_validation->set_rules('physician_name_canada', 'physician name canada ', '');
			$this->form_validation->set_rules('physician_city', 'physician city ', '');
			$this->form_validation->set_rules('payee_name', 'payee name ', '');
			$this->form_validation->set_rules('bank', 'bank name ', '');
			$this->form_validation->set_rules('physician_city_canada', 'physician city canada ', '');
			//$this->form_validation->set_rules('guardian_phone', 'Guardian Phone ', 'numeric');
			//$this->form_validation->set_rules('telephone', 'Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone', 'Physician Telephone ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone_canada', 'physician alt telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_telephone_canada', 'physician telephone canada ', 'numeric');
			//$this->form_validation->set_rules('physician_alt_telephone', 'physician alt telephone ', 'numeric');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			
			// $this->form_validation->set_rules('school_name', 'School Name', 'required');
			
			$this->form_validation->set_rules('contact_first_name', 'First Name', '');
			$this->form_validation->set_rules('contact_last_name', 'Last Name', '');
			//$this->form_validation->set_rules('contact_email', 'Email', 'valid_email');
			//$this->form_validation->set_rules('contact_phone', 'physician alt telephone ', 'numeric');
			
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('policy_no', 'Policy No', 'required');
			$this->form_validation->set_rules('case_no', 'Case No', 'alpha_numeric_spaces');
			
			$this->load->model('master_model');
			$this->load->model('claim_model');
			$this->load->model('eclaim_model');
			$this->load->model('eclaim_file_model');
			$this->load->model('mytask_model');
			$this->load->model('expenses_model');
			$this->load->model('provider_model');

			if ($this->form_validation->run() == TRUE) {
				// prepare post data array
				$error = FALSE;
				$data =[];
				$expenses=[];
				$array = $this->input->post();
				
				$payee = array(
					'claim_id' => 0,
					'payment_type' =>  $array['payees_payment_type'],
					'bank' => $array['payees_bank'],
					'payee_name' => $array['payees_payee_name'],
					'account_cheque' => $array['payees_account_cheque'],
					'address' => $array['payees_address'],
					'city' => $array['payees_city'],
					'province' => $array['payees_province'],
					'country' => $array['payees_country'],
					'postcode' => $array['payees_postcode'],
					'type' => 'person',
					'cheque' => '',
					'created' => date("Y-m-d H:i:s")
				);
				unset($array['payees_payment_type']);
				unset($array['payees_bank']);
				unset($array['payees_payee_name']);
				unset($array['payees_account_cheque']);
				unset($array['payees_address']);
				unset($array['payees_city']);
				unset($array['payees_province']);
				unset($array['payees_country']);
				unset($array['payees_postcode']);

				$expenses=[];

				if (empty($array['expenses_claimed_service_description'])) {
					/* no check has expenses for now
					$this->session->set_flashdata('error', "No Eclaim expenses exists");
					$id = $this->input->post('id');
					redirect("eclaim/detail/".$id); */
				} else {
					foreach ($array['expenses_claimed_service_description'] as $key => $val) {
						$expenses[] = array(
							'claim_id' => 0,
							'claim_no' => '',
							'claim_item_no' => '',
							'invoice' => '',
							'provider_name' => $array['expenses_claimed_provider_name'][$key],
							'provider_type' => 0,
							'expenses_provider_id' => 0,
							'referencing_physician' => $array['expenses_claimed_referencing_physician'][$key],
							'service_description' => $array['expenses_claimed_service_description'][$key],
							'date_of_service' => $array['expenses_claimed_date_of_service'][$key],
							'amount_billed' => $array['expenses_claimed_amount_client_paid_org'][$key],
							'amount_billed_org' => $array['expenses_claimed_amount_client_paid_org'][$key],
							'amount_client_paid' => $array['expenses_claimed_amount_client_paid_org'][$key],
							'amount_client_paid_org' => $array['expenses_claimed_amount_client_paid_org'][$key],
							'pay_to' => '',
							'reason' => '',
							'reason_other' => '',
							'amount_claimed' => $array['expenses_claimed_amount_claimed_org'][$key],
							'amount_claimed_org' => $array['expenses_claimed_amount_claimed_org'][$key],
							'other_reimbursed_amount' => $array['expenses_claimed_other_reimbursed_amount'][$key],
							'payee' => '',
							'currency' => isset($array['expenses_claimed_currency'][$key])?$array['expenses_claimed_currency'][$key]:'CAD',
						);
					}
				}
				unset($array['expenses_claimed_currency']);
				unset($array['expenses_claimed_provider_name']);
				unset($array['expenses_claimed_referencing_physician']);
				unset($array['expenses_claimed_service_description']);
				unset($array['expenses_claimed_date_of_service']);
				unset($array['expenses_claimed_amount_client_paid_org']);
				unset($array['expenses_claimed_amount_claimed_org']);
				unset($array['expenses_claimed_other_reimbursed_amount']);
				unset($array['expenses_claimed_provider_name']);

				if (!empty($array['exinfo'])) {
					$exinfo = $array['exinfo'];
					unset($array['exinfo']);
					$array['exinfo'] = json_encode($exinfo);
				} else {
					$array['exinfo'] = json_encode(array());
				}

				$data = $array;
				$data['created'] = date('Y-m-d H:i:s');
				$data['logs'] = json_encode(array(date("Y-m-d H:i:s").' - Transferred this Eclaim by ' . $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name . " (". $this->ion_auth->get_user_id() .")"));
				$data['created_by'] = $this->ion_auth->get_user_id();
				
				// set default status processing
				$data['status'] = Claim_model::STATUS_Processing;

				//$eclaim = $this->eclaim_model->get_by_id($data['id']);
				//$data['files'] = join(",", json_decode($eclaim['imgfile'], TRUE));
				if (empty($data['case_no'])) {
					$data['id'] = $this->master_model->get_id('claim'); // Get new id
				} else {
					$data['id'] = ltrim(substr($data['case_no'], 1), '0');
					if ($this->claim_model->get_by_id($data['id'])) {
						return show_error('The case has claimed already, you can\'t transfer this eclaim with same case number.');
					}
				}
				$data['claim_no'] = $this->claim_model->generate_claim_no($data['id']);

				// copy files
				$data['files'] = "";
				if (!empty($data['sign_image']) && ($imgfile = $this->eclaim_file_model->get_by_id($data['sign_image']))) {
					@mkdir(UPLOADFULLPATH . "claim_files/".$data['id']."/");
					if (copy(UPLOADFULLPATH . $imgfile["path"] . "/" . $imgfile["name"], UPLOADFULLPATH . "claim_files/".$data['id']."/".$imgfile["name"])) {
						if ($data['files']) $data['files'] .= ',';
						$data['files'] .= $imgfile["name"];
					}
				}
				unset($data['sign_image']);
				if (!empty($data['sign_image2']) && ($imgfile = $this->eclaim_file_model->get_by_id($data['sign_image2']))) {
					@mkdir(UPLOADFULLPATH . "claim_files/".$data['id']."/");
					if (copy(UPLOADFULLPATH . $imgfile["path"] . "/" . $imgfile["name"], UPLOADFULLPATH . "claim_files/".$data['id']."/".$imgfile["name"])) {
						if ($data['files']) $data['files'] .= ',';
						$data['files'] .= $imgfile["name"];
					}
				}
				unset($data['sign_image2']);

				$otherimages = json_decode($data['imgfile'], true);
				if (is_array($otherimages)) {
					@mkdir(UPLOADFULLPATH . "claim_files/".$data['id']."/");
					foreach ($otherimages as $oneimg) {
						if ($imgfile = $this->eclaim_file_model->get_by_id($oneimg)) {
							if (copy(UPLOADFULLPATH . $imgfile["path"] . "/" . $imgfile["name"], UPLOADFULLPATH . "claim_files/".$data['id']."/".$imgfile["name"])) {
								if ($data['files']) $data['files'] .= ',';
								$data['files'] .= $imgfile["name"];
							}
						}
					}
				}
				unset($data['imgfile']);
				$payee['claim_id'] = $data['id'];
				$payee_id = $this->claim_model->payees_save($payee);

				// insert values to database
				$record_id = $this->claim_model->save($data);
				$record_id = $data['id'];

				$i = 0;
				foreach ($expenses as $payee_data ) {
					$i++;
					$payee_data['claim_id'] = $record_id;
					$payee_data['cellular'] = '';
					$payee_data['claim_no'] = $data['claim_no'];
					$payee_data['claim_item_no'] = $data['claim_no'] . '_' . $i;
					$payee_data['case_no'] = '';
					$payee_data['coverage_code'] = '';
					$payee_data['diagnosis'] = '';
					$payee_data['payee'] = $payee_id;
					$payee_data['pay_to'] = ($payee['payment_type'] == 'cheque') ? ($payee['payment_type'] . " : " . $payee['payee_name'] . " : " . $payee['address'] . " : " . $payee['city'] . " : " . $payee['province'] . " : " . $payee['country'] . " : " . $payee['postcode']) : $payee['payment_type'] . " : " . $payee['bank'];
					$payee_data['third_party_payee'] = '';
					$payee_data['comment'] = '';
					$payee_data['status'] = Expenses_model::EXPENSE_STATUS_Received;
					$payee_data['created_by'] = $this->ion_auth->get_user_id();
					$payee_data['finalize_date'] = date('Y-m-d');
					$payee_data['created'] = date('Y-m-d H:i:s');
					
					$this->common_model->save("expenses_claimed", $payee_data);
				}
				
				$assign_to = $this->mytask_model->get_auto_assign_examiner_id();
				
				// settings for my task section for case manager
				$task_data = array(
						'user_id' => $assign_to,
						'item_id' => $record_id,
						'task_no' => $data['claim_no'],
						'category' => Mytask_model::CATEGORY_CLAIMS,
						'type' => Mytask_model::TASK_TYPE_CLAIM,
						'due_date' => date("Y-m-d", time() + 86400),
						'due_time' => date("H:i:s", time() + 86400),
						'priority' => Mytask_model::PRIORITY_LOW,
						'status' => Mytask_model::STATUS_ASSIGNED,
						'created_by' => $this->ion_auth->get_user_id(),
						'created' => date('Y-m-d H:i:s'),
						'user_type' => Mytask_model::USER_TYPE_EXAM
				);
				// insert values to database
				$this->mytask_model->save($task_data);

				$edata = array('id' => $this->input->post('id'), 'status' => 2);
				$edata['claim_no'] = $data['claim_no'];
				$edata['processed_by'] = $this->ion_auth->get_user_id();
				$edata['intnotes'] = 'Accept this claim by ' . $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name . " (". $this->ion_auth->get_user_id() .")";
				$this->eclaim_model->save($edata);
				// print_r($this->db->last_query());
				// send success message
				$this->load->model("mymail_model");
				$subject = "Web claim under review - " . $data['claim_no'] . " - " . $data['insured_first_name'];
				$to = $data['email'];
				$body  = "Dear " . $data['insured_first_name'] . ",<br /><br />\n"; 
				$body  .= "The web claim you submitted on ".date("Y-m-d")." has been accepted and is being reviewed. Your claim number is " . $data['claim_no'] . ". It will take approximately 5 business days for us to process your claim. <br /><br />\n"; 
				$body  .= "You can check the status of your claim by logging into the <a href='https://eclaim.jfgroup.ca'>eclaim.jfgroup.ca</a> with your policy number and birthday and selecting 'Check Claim Status' on the main menu.<br />\n"; 
				$body  .= "This is an system-generated email, please do not reply directly. Should you have any questions, please contact us by email at claim@otcww.com.<br /><br />\n"; 
				$body  .= "Ontime Care Worldwide Inc. is the authorized claims administrator for JF Insurance policies. <br /><br />\n"; 
				$body  .= "Best regards,<br />\n"; 
				$body  .= "Ontime Care Worldwide Inc. <br />\n"; 
				$body  .= "Telephone: 905-707-3555<br />\n"; 
				$body  .= "Email: claim@otcww.com <br />\n"; 
				$this->mymail_model->send_mymail($to, $subject, $body, array(), 'Ontime Care Worldwide Inc.');

				$this->session->set_flashdata('success', "Claim successfully created (" . $data['claim_no'] . ")");

				redirect("eclaim");
			}
			// echo validation_errors();
			$id = $this->input->post('id');
			//$this->session->set_flashdata('error', "Can't process Eclaim. Because some error");
			$this->session->set_flashdata('error', validation_errors());
			redirect("eclaim/detail/".$id);
		}
	}

	// redirect if needed, otherwise display the edit case page
	public function detail($id) {
		if (! $this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('api_model');
			$this->load->model('eclaim_model');
			$this->load->model('eclaim_file_model');
			$this->load->model('html_model');
			$this->load->model('country_model');

			// get claim details
			$this->data['eclaim'] = $this->eclaim_model->get_by_id($id);
			$this->data['html_model'] = $this->html_model;
			$this->data['eclaim_file_model'] = $this->eclaim_file_model;
			if (empty($this->data['eclaim'])) {
				// send error message
				$this->session->set_flashdata('error', "Can't find Eclaim.");
				
				// redirect them to the claim
				redirect('eclaim');
			}
			if ($policies = $this->api_model->get_policy(array('policy' => $this->data['eclaim']["policy_no"]))) {
				$this->data['policy'] = $policies[0];
			} else {
				// send error message
				$this->session->set_flashdata('error', "Can't find Policy(".$this->data['eclaim']["policy_no"].".");
				
				// redirect them to the claim
				redirect('eclaim');
			}
			// get all related files
			$this->data['eclaim_files'] = $this->eclaim_file_model->get_files_by_id($id);

			$this->data['country'] = $this->country_model->get_list();

			// load view data
			$this->template->write('title', SITE_TITLE . ' - Eclaim Details', TRUE);
			switch ($this->data['eclaim']['exinfo_type']) {
				case "top_baggage":
					$this->template->write_view('content', 'eclaim/top_baggage', $this->data);
					break;
				case "top_medical":
					$this->template->write_view('content', 'eclaim/top_medical', $this->data);
					break;
				case "top_trip":
					$this->template->write_view('content', 'eclaim/top_trip', $this->data);
					break;
				default:
					$this->template->write_view('content', 'eclaim/detail', $this->data);
					break;
			}
			$this->template->render();
		}
	}

	public function export($id) {
		if (! $this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} else if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) {
			return show_error('Sorry, you don\'t have any permission to access this page.');
		} else {
			$this->load->model('api_model');
			$this->load->model('eclaim_model');
			$this->load->model('eclaim_file_model');
			$this->load->model('html_model');
			$this->load->model('country_model');

			// get claim details
			$this->data['eclaim'] = $this->eclaim_model->get_by_id($id);
			$this->data['html_model'] = $this->html_model;
			$this->data['eclaim_file_model'] = $this->eclaim_file_model;
			if (empty($this->data['eclaim'])) {
				// send error message
				$this->session->set_flashdata('error', "Can't find Eclaim.");
				
				// redirect them to the claim
				redirect('eclaim');
			}
			if ($policies = $this->api_model->get_policy(array('policy' => $this->data['eclaim']["policy_no"]))) {
				$this->data['policy'] = $policies[0];
			} else {
				// send error message
				$this->session->set_flashdata('error', "Can't find Policy(".$this->data['eclaim']["policy_no"].".");
				
				// redirect them to the claim
				redirect('eclaim');
			}
			// get all related files
			$this->data['eclaim_files'] = $this->eclaim_file_model->get_files_by_id($id);

			$this->data['country'] = $this->country_model->get_list();

			// load view data
			switch ($this->data['eclaim']['exinfo_type']) {
				case "top_baggage":
					$html = $this->load->view('eclaim/top_baggage_pdf', $this->data);
					break;
				case "top_medical":
					$html = $this->load->view('eclaim/top_medical_pdf', $this->data);
					break;
				case "top_trip":
					$html = $this->load->view('eclaim/top_trip_pdf', $this->data);
					break;
				default:
					$html = $this->load->view('eclaim/detail_pdf', $this->data);
					break;
			}
		}
	}
}
