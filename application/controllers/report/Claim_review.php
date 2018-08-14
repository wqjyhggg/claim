<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_review extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the products list
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('claim_model');
				
			$claim = array();
			if ($claim_id = $this->input->get('claim_id')) {
				$claim = $this->claim_model->get_by_id($claim_id);
			} else {
				$para = array();
				if ($claim_no = $this->input->get('claim_no')) {
					$para['claim_no'] = $claim_no;
				}
				if ($case_no = $this->input->get('case_no')) {
					$para['case_no'] = $case_no;
				}
				if ($policy_no = $this->input->get('policy_no')) {
					$para['policy_no'] = $policy_no;
				}
				if ($para) {
					if ($claims = $this->claim_model->search($para)) {
						if (count($claims) > 1) {
							$this->data['claims'] = $claims;
						} else {
							$claim = $claims[0];
						}
					} else {
						$this->data['message'] = "No record available";
					}
				}
			}
			$this->data['claim'] = $claim;
			$this->data['ispdf'] = false;
				
			$this->data['export_url'] = site_url('report/claim_review/export');
			$this->data['current_url'] = site_url('report/claim_review');
				
			$this->template->write('title', SITE_TITLE . ' - Claim Review', TRUE);
			if ($claim) {
				$this->load->model('api_model');
				$this->load->model('expenses_model');
				$this->load->model('product_model');
				
				$dob = new DateTime($this->data['claim']['dob']);
				$apply_date = new DateTime($this->data['claim']['apply_date']);
				$this->data['claim']['age'] = $dob->diff($apply_date)->format('%y');
				
				$others = $this->claim_model->search(array('policy_no' => $claim['policy_no']));
				if ($others && (sizeof($others) > 1)) {
					$this->data['claim']['other_claims'] = 'Yes';
				} else {
					$this->data['claim']['other_claims'] = 'No';
				}
				$this->data['claim']['product_full_name'] = $this->product_model->get_full_name($claim['product_short']);
				if ($policies = $this->api_model->get_policy(array('policy' => $claim['policy_no']))) {
					$this->data['claim']['policy_info'] = $policies[0];
				}
				if (is_string($this->data['claim']['policy_info'])) {
					$this->data['claim']['policy_info'] = json_decode($this->data['claim']['policy_info'], TRUE);
				}
				/*
				if ($expenses = $this->expenses_model->search(array('claim_id' => $claim['id']))) {
					$this->data['claim']['expense'] = $expenses[0];
				}
				*/
				$this->data['claim']['expenses_summary'] = $this->expenses_model->expenses_summary($claim['id']);
				
				$this->template->write_view('content', 'report/claim_review', $this->data);
			} else if (isset($this->data['claims'])) {
				$this->template->write_view('content', 'report/claim_review_list', $this->data);
			} else {
				$this->template->write_view('content', 'report/claim_review_search', $this->data);
			}
			$this->template->render();
		}
	}

	public function export() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('claim_model');
				
			$claim = array();
			if ($claim_id = $this->input->post('claim_id')) {
				$claim = $this->claim_model->get_by_id($claim_id);
				if (empty($claim)) {
					die("Can not find Claim Record");
				}
			} else {
				die("Unknow Claim ID");
			}
			$this->data['claim'] = $claim;
			$this->data['ispdf'] = true;
				
			$this->template->write('title', SITE_TITLE . ' - Claim Review', TRUE);
			
			$this->load->model('api_model');
			$this->load->model('expenses_model');
			$this->load->model('product_model');
			
			$dob = new DateTime($this->data['claim']['dob']);
			$apply_date = new DateTime($this->data['claim']['apply_date']);
			$this->data['claim']['age'] = $dob->diff($apply_date)->format('%y');
			
			$others = $this->claim_model->search(array('policy_no' => $claim['policy_no']));
			if ($others && (sizeof($others) > 1)) {
				$this->data['claim']['other_claims'] = 'Yes';
			} else {
				$this->data['claim']['other_claims'] = 'No';
			}
			$this->data['claim']['product_full_name'] = $this->product_model->get_full_name($claim['product_short']);
			if ($policies = $this->api_model->get_policy(array('policy' => $claim['policy_no']))) {
				$this->data['claim']['policy_info'] = $policies[0];
			}
			/*
			if ($expenses = $this->expenses_model->search(array('claim_id' => $claim['id']))) {
				$this->data['claim']['expense'] = $expenses[0];
			}
			*/
			$this->data['claim']['expenses_summary'] = $this->expenses_model->expenses_summary($claim['id']);
			
			$html = $this->load->view('report/claim_review', $this->data, true);

			$this->data['title'] = '<h1>Claim Medical Review</h1>';
			$this->load->model('pdf_model');
			$this->pdf_model->htmloutput($html, $this->data);
		}
	}
}
