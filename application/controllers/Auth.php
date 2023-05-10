<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Auth extends CI_Controller {
	// set private properties here
	private $limit = 17; // no of records per page
	
	public function __construct() {
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the products list
	public function index() {
		redirect('auth/users');
	}
	
	// redirect if needed, otherwise display the my tasks list
	public function mytasks($type='') {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			// get my tasks here
			$this->load->model('mytask_model');
			$this->load->model('claim_model');
			$this->load->model('case_model');
			$this->load->model('html_model');

			if (empty($type)) $type = $this->session->userdata('tasktype');
			if (empty($type)) $type = 'CLAIM';
			$this->session->set_userdata('tasktype', $type);

			// if sorting enabled
			$para = array(
					'type' => $type,
					'finished' => (int)$this->session->userdata('finished'),
					'field' => $this->input->get("field"),
					'order' => $this->input->get("order")
			);

			$limit = $this->limit;
			$offset = $this->uri->segment(4);
			
			$this->data['finished'] = (int)$this->session->userdata('finished');
			if ($type == 'CLAIM') {
				$this->data['finished'] = 1;
			}
			$this->data['finish_url'] = base_url('auth/setfinish');
			$this->data['case_only_url'] = base_url('auth/mytasks/CASE');
			$this->data['claim_only_url'] = base_url('auth/mytasks/CLAIM');
			$this->data['type'] = $type;
				
			$this->data['records'] = $this->mytask_model->get_mytask($para, $limit, $offset);
			$config['total_rows'] = $this->mytask_model->last_rows();
			
			foreach ($this->data['records'] as $key => $rc) {
				if ($rc['type'] == 'CASE') {
					$case = $this->case_model->get_by_id($rc['item_id']);
					$this->data['records'][$key]['insured_name'] = $case['insured_firstname'] . " " . $case['insured_lastname'];
					$this->data['records'][$key]['priority'] = $case['priority'];
					$this->data['records'][$key]['policy_no'] = $case['policy_no'];
				} else {
					$claim = $this->claim_model->get_by_id($rc['item_id']);
					$this->data['records'][$key]['insured_name'] = $claim['insured_first_name'] . " " . $claim['insured_last_name'];
					$this->data['records'][$key]['priority'] = '-';
					$this->data['records'][$key]['policy_no'] = $claim['policy_no'];
					$this->data['records'][$key]['last_update'] = $claim['last_update'];
					$this->data['records'][$key]['status'] = $claim['status2'];
				}
				$ctuser = $this->users_model->get_by_id($rc['created_by']);
				$this->data['records'][$key]['created_email'] = isset($ctuser['email']) ? $ctuser['email'] : '';
				$user = $this->users_model->get_by_id($rc['user_id']);
				$this->data['records'][$key]['assign_name'] = $user['email'];
			}
			
			$config['base_url'] = base_url('auth/mytasks/' . (empty($type) ? 'CLAIM' : $type));
			$config['per_page'] = $limit;
			$config['first_url'] = $config['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0)	$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			$this->pagination->initialize($config); // initiaze pagination config
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			$this->data ['html_model'] = $this->html_model;
			
			$this->template->write('title', SITE_TITLE . ' - My Tasks', TRUE);
			$this->template->write_view('content', 'auth/mytasks', $this->data);
			$this->template->render();
		}
	}
	
	public function finish_task($id = 0) {
		if ($this->ion_auth->logged_in()) {
			$this->load->model('mytask_model');
			
			$task = $this->mytask_model->get_by_id($id);
			if ($task) {
				$data = array('id' => $id, 'status' => Mytask_model::STATUS_COMPLETED, 'completion_date' => date("Y-m-d"), 'finished' => 1);

				$this->mytask_model->save($data);
				$this->active_model->log_update('mytask', $id, $task, $data, $this->db->last_query());

				/* No need setup item assign_to for tracking 
				if ($task['type'] == Mytask_model::TASK_TYPE_CASE) {
					$this->load->model('case_model');
					$case = $this->case_model->get_by_id($task['item_id']);
					if ($case && (($data['finished'] == 1) || ($case['assign_to'] == $this->ion_auth->get_user_id()))) {
						$para = array('id' => $task['item_id'], 'assign_to' => 0);
						$this->case_model->save($para);
					}
				} else if ($task['type'] == Mytask_model::TASK_TYPE_CLAIM) {
					$this->load->model('claim_model');
					$claim = $this->case_model->get_by_id($task['item_id']);
					if ($claim && (($data['finished'] == 1) || ($claim['assign_to'] == $this->ion_auth->get_user_id()))) {
						$para = array('id' => $task['item_id'], 'assign_to' => 0);
						$this->claim_model->save($para);
					}
				}
				*/
			}
		}
		redirect('auth/mytasks', 'refresh');
	}
	
	public function setfinish() {
		$res = array();
		if ($this->ion_auth->logged_in()) {
			$finished = $this->input->post('finished');
			$res ['post'] = $finished;
			$this->session->set_userdata('finished', $finished);
			$res ['message'] = 'Set';
		}
		// add the header here
		header('Content-Type: application/json');
		$res ['status'] = 'OK';
		die(json_encode($res));
	}
	
	// edit task page
	public function password() {
		$this->data['my_message'] = '';
		$cur_password = $this->input->post('cur_password');
		$password = $this->input->post('password');
		$password_confirm = $this->input->post('password_confirm');
		
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if (!empty($this->input->post())) { 
			if ($password != $password_confirm) {
				$this->session->set_flashdata('error', $this->lang->line('change_password_validation_new_password_confirm_label'));
				$this->data['my_message'] = "Confirm Password isn't match ";
			} else {
				$this->load->model('users_model');
	
				$user_id = $this->ion_auth->get_user_id();
				
				$verify = $this->ion_auth->hash_password_db($user_id, $cur_password);
				if ($verify === TRUE) {
					$this->users_model->save(array('id' => $user_id, 'password' => $password));
					// if the password was successfully changed
					$this->data['my_message'] = 'Successfully';
					$this->session->set_flashdata('error', $this->ion_auth->messages());
					// $this->logout();
				} else {
					$this->data['my_message'] = 'Error! Can not change password';
					$this->session->set_flashdata('error', $this->ion_auth->errors());
				}
			}
		}

		// load view data
		$this->template->write('title', SITE_TITLE . ' - Change Password', TRUE);
		$this->template->write_view('content', 'auth/password', $this->data);
		$this->template->render();
	}
	
	// edit task page
	public function edit_task($id = 0) {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->load->model('mytask_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			
			$task_details = $this->mytask_model->get_by_id($id);
			if (empty($task_details)) {
				redirect('auth/mytasks', 'refresh');
			}

			$due_date = $this->input->post('due_date') ? $this->input->post('due_date') : date("Y-m-d");
			$due_time = $this->input->post('due_time') ? $this->input->post('due_time') : date("H:i:s");
				
			// validate form input
			/*
			if ($task_details ['type'] == 'CASE' and ($this->ion_auth->in_group(Users_model::GROUP_ADMIN) or $this->ion_auth->is_casemamager()))
				$this->form_validation->set_rules('assign_to', 'Assign To', 'required');
			if ($task_details ['type'] == 'CLAIM')
				$this->form_validation->set_rules('assign_to', 'Assign To', 'required');
			*/
			$this->form_validation->set_rules('priority', 'Priority', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
				
			if ($this->form_validation->run() == TRUE) {
				// update case/claim details
				$data = array(
						'id' => $id,
						'due_date' => $due_date,
						'due_time' => $due_time,
						'status' => $this->input->post('status'),
						'priority' => $this->input->post('priority') 
				);
				
				$user_id = (int)$this->input->post('user_id');
				if ($user_id > 0) {
					$data['user_id'] = $user_id;
				}
				$this->mytask_model->save($data);
				$this->active_model->log_update('mytask', $id, $task_details, $data, $this->db->last_query());
				
				// send success message
				$this->session->set_flashdata('success', "Task details successfully updated");

				// redirect them to the login page
				redirect('auth/mytasks', 'refresh');
			} else {
				if (empty($task_details)) {
					// send error message
					$this->session->set_flashdata('error', "Something went wrong, please try after some time.");
					
					// redirect them to the list page
					redirect('auth/mytask', 'refresh');
				}
				if ($task_details['type'] == 'CASE') {
					$case = $this->case_model->get_by_id($task_details['item_id']);
					$task_details['insured_name'] = $case['first_name'] . " " . $case['last_name'];
					$task_details['priority'] = $case['priority'];
				} else {
					$claim = $this->claim_model->get_by_id($task_details['item_id']);
					$task_details['insured_name'] = $claim['insured_first_name'] . " " . $claim['insured_last_name'];
					$task_details['priority'] = '-';
				}
				
				$ctuser = $this->users_model->get_by_id($task_details['created_by']);
				$task_details['created_email'] = $ctuser['email'];
				$user = $this->users_model->get_by_id($task_details['user_id']);
				$task_details['assigned_email'] = $user['email'];
				
				$this->data ['task_details'] = $task_details;

				$this->data ['priorities'] = $this->mytask_model->get_priorities();
				$this->data ['statuses'] = $this->mytask_model->get_status();
				/*
				$para = array('groups' => Users_model::GROUP_EAC);
				$this->data['eacs'] = $this->users_model->search($para);

				$para = array('groups' => Users_model::GROUP_EXAMINER);
				$this->data['examiners'] = $this->users_model->search($para);
				
				$para = array('groups' => Users_model::GROUP_MANAGER);
				$this->data['managers'] = $this->users_model->search($para);
				*/
				// load view data
				$this->template->write('title', SITE_TITLE . ' - Edit Task', TRUE);
				$this->template->write_view('content', 'auth/edit_task', $this->data);
				$this->template->render();
			}
		}
	}
	
	// log the user in
	public function login() {
		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
		if ($this->form_validation->run() == true) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login(strtolower($this->input->post('identity')), $this->input->post('password'), $remember)) {
				// if the login is successful
				// redirect them back to the home page
				$this->session->set_flashdata('success', $this->ion_auth->messages());
				if ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) {
					redirect('claim', 'refresh');
				} else {
					if ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER))) {
						redirect('claim', 'refresh');
					} else if ($this->ion_auth->in_group(array(Users_model::GROUP_ACCOUNTANT))) {
						redirect('claim/payments', 'refresh');
					} else {
						redirect('auth/mytasks', 'refresh');
					}
				}
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			$this->data ['identity'] = array(
					'name' => 'identity',
					'id' => 'identity',
					'type' => 'text',
					'value' => $this->form_validation->set_value('identity'),
					'class' => 'form-control',
					'placeholder' => 'Username' 
			);
			$this->data ['password'] = array(
					'name' => 'password',
					'id' => 'password',
					'type' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Password' 
			);
			$this->_render_page('auth/login', $this->data);
		}
	}
	
	// redirect if needed, otherwise display the user list
	public function users() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		} else {
			$this->load->model('product_model');
			// list the users group
			$this->data['groups'] = $this->users_model->get_groups();
			$this->data['products'] = $this->product_model->get_list();
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			$get = $this->input->get();
			$this->data['status'] = -1;
			if (isset($get['status']) && ($get['status'] >= 0)) {
				$get['active'] = $get['status'];
				$this->data['status'] = $get['status'];
			}
			$this->data['users'] = $this->users_model->search($get, $limit, $offset);
			$config['total_rows'] = $this->users_model->last_rows();
				
			$config['base_url'] = site_url('auth/users');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0) {
				$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			}

			$this->pagination->initialize($config); // initiaze pagination config
			
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - Manage Users', TRUE);
			$this->template->write_view('content', 'auth/users', $this->data);
			$this->template->render();
		}
	}
	
	// custom name validation
	function alpha_dash_space($fullname) {
		if (!preg_match('/^[a-zA-Z\s][0-9a-zA-Z\s]+$/', $fullname)) {
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	function phone_number_check($phone) {
		$phone = trim($phone);
		if (empty($phone)) {
			return TRUE;
		}
		
		$this->load->model('phone_model');
		$pArr = $this->phone_model->get_working_number();
		if (!in_array($phone, $pArr)) {
			$this->form_validation->set_message('phone_number_check', "The $phone isn't a working phone");
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// create / edit a user
	public function edit_user($id = 0) {
		$this->data ['pagetitle'] = $this->lang->line('edit_user_heading');
		
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group(Users_model::GROUP_ADMIN)) {
			redirect('auth/users', 'refresh');
		}
		
		$this->load->model('groups_model');
		$this->load->model('product_model');
		$this->load->model('schedule_model');
		
		$user = $this->users_model->get_by_id($id);
		$groups = $this->users_model->get_groups();
		$products = $this->product_model->get_list();
		
		$currentGroups = $this->users_model->get_users_groups($id);
		$currentProducts = $this->users_model->get_users_products($id);

		if (!$currentGroups) $currentGroups = array();
		if (!$currentProducts) $currentProducts = array();
		
		if ($user) {
			$this->data ['pagetitle'] = $this->lang->line('edit_user_heading');
		} else {
			$user = array();
			$this->data ['pagetitle'] = $this->lang->line('create_user_heading');
		}
		
		// validate form input
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if (empty($user)) {
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[users.email]');
		}
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|callback_alpha_dash_space');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|callback_alpha_dash_space');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'callback_phone_number_check');
		$this->form_validation->set_rules('groups[]', 'Member of groups', 'required');
		if (($post_group = $this->input->post('groups')) && !in_array(Users_model::GROUP_ADMIN, $post_group) && !in_array(Users_model::GROUP_ACCOUNTANT, $post_group)) {
			$this->form_validation->set_rules('products[]', 'Member of products', 'required');
		}
		
		$groupData = $this->input->post('groups');
		if (!empty($groupData) and in_array(Users_model::GROUP_EAC, $groupData)) {
			$this->form_validation->set_rules('shift', 'Shift', 'required');
		}
		
		if ($this->input->post()) {
			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			
			if ($this->form_validation->run() === TRUE) {
				$data = array(
						'email' => strtolower($this->input->post('email')),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'company' => $this->input->post('company'),
						'ip_address' => $this->input->server('REMOTE_ADDR'),
						'groups' => json_encode($this->input->post('groups')),
						'products' => json_encode($this->input->post('products')),
						'title' => $this->input->post('title'),
						'phone' => $this->input->post('phone'),
						'shift' => $this->input->post('shift') 
				);
				if ($id = $this->input->post('id')) {
					$data ['id'] = $this->input->post('id');
				}
				
				// update the password if it was posted
				if ($this->input->post('password')) {
					$data ['password'] = $this->ion_auth->hash_password($this->input->post('password'));
				}

				if ($id = $this->users_model->save($data)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', 'Some thing wrong, please contact admin');
				}
				
				// check to see if we are updating the user
				if ($this->ion_auth->in_group(Users_model::GROUP_ADMIN)) {
					redirect('auth/users', 'refresh');
				} else {
					redirect('/', 'refresh');
				}
			}
		}
		
		$this->data['action_url'] = base_url('auth/edit_user') . empty($user) ? '' : "/" . $id;
		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['allgroups'] = $groups;
		$this->data['allproducts'] = $products;
		$this->data = array_merge($this->data, $user);
		
		// $this->data ['products'] = $products;
		if ($this->input->post()) {
			$post = $this->input->post();
			$this->data['currentGroups'] = isset($post['groups']) ? $post['groups'] : array();
			$this->data['currentProducts'] = isset($post['products']) ? $post['products'] : array();
			$this->data = array_merge($this->data, $post);
		} else {
			$this->data['currentGroups'] = $currentGroups;
			$this->data['currentProducts'] = $currentProducts;
		}

		$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email', empty($this->data ['email']) ? '' : $this->data ['email']) 
		);
		if (!empty($user)) $this->data ['email'] ['readonly'] = 'readonly';
		
		$this->data['first_name'] = array(
				'name' => 'first_name',
				'id' => 'first_name',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name', empty($this->data ['first_name']) ? '' : $this->data ['first_name']) 
		);
		$this->data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name', empty($this->data ['last_name']) ? '' : $this->data ['last_name']) 
		);
		$this->data['title'] = array(
				'name' => 'title',
				'id' => 'title',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('title', empty($this->data ['title']) ? '' : $this->data ['title']) 
		);
		$this->data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company', empty($this->data ['company']) ? '' : $this->data ['company']) 
		);
		$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone', empty($this->data ['phone']) ? '' : $this->data ['phone']) 
		);
		$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'type' => 'password' 
		);
		$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'class' => 'form-control',
				'type' => 'password' 
		);
		$this->data['shift_options'] = $this->schedule_model->get_shift_options(1);
		
		$this->template->write('title', SITE_TITLE . ' - Edit User', TRUE);
		$this->template->write_view('content', 'auth/edit_user', $this->data);
		$this->template->render();
	}
	
	// change password
	public function change_password() {
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
		
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}
		
		$user = $this->ion_auth->user()->row();
		
		if ($this->form_validation->run() == false) {
			// display the form
			$this->data ['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data ['old_password'] = array(
					'name' => 'old',
					'id' => 'old',
					'type' => 'password' 
			);
			$this->data ['new_password'] = array(
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$' 
			);
			$this->data ['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$' 
			);
			$this->data ['user_id'] = array(
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id 
			);
			
			// render
			$this->_render_page('auth/change_password', $this->data);
		} else {
			$identity = $this->session->userdata('identity');
			
			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
			
			if ($change) {
				// if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}
	
	// activate the user
	public function activate($id) {
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(Users_model::GROUP_ADMIN)) {
			$this->load->model('users_model');
			$this->users_model->save(array(
					'id' => $id,
					'active' => 1 
			));
			// redirect them to the auth page
			$this->session->set_flashdata('message', 'User Actived');
			redirect("auth/users", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', 'Only Admin can do this');
			redirect("auth/forgot_password", 'refresh');
		}
	}
	
	// deactivate the user
	public function deactivate($id = NULL) {
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(Users_model::GROUP_ADMIN)) {
			$this->load->model('users_model');
			$this->users_model->save(array(
					'id' => $id,
					'active' => 0 
			));
			// redirect them to the auth page
			$this->session->set_flashdata('message', 'User Deactived');
			redirect("auth/users", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', 'Only Admin can do this');
			redirect("auth/forgot_password", 'refresh');
		}
	}
	
	// for autocomplete search
	public function autocomplete($field, $type = "") {
		$query = $this->input->get("query");
		
		// get search query
		$table = "users";
		$group_by = array(
				"users_groups.user_id" 
		);
		$fields = "users.$field as `value`, users.id as `data`";
		$joins [] = array(
				'table' => 'users_groups',
				'on' => 'users_groups.user_id = users.id',
				'type' => 'LEFT' 
		);
		$conditions = "users.$field like '%$query%' ";
		if ($type)
			$conditions .= " and users_groups.group_id = '$type' ";
		$results = $this->common_model->select($record = "list", $typecast = "object", $table, $fields, $conditions, $joins, $order_by = array(), $group_by);
		
		// return result in json format
		$results = array(
				'suggestions' => $results 
		);
		echo json_encode($results);
	}
	public function help() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else {
			$this->template->write('title', SITE_TITLE . ' - Help', TRUE);
			$this->template->write_view('content', 'auth/help');
			$this->template->render();
		}
	}
	
	// log the user out
	public function logout() {
		$this->data ['title'] = "Logout";
		
		$this->load->model('users_model');
		
		if ($phonenumber = $this->users_model->get_user_phoneid()) {
			$this->load->model('phone_model');
			$this->phone_model->do_phone_opt(Phone_model::PHONE_OPT_LOGOUT);
		}
		
		// log the user out
		$logout = $this->ion_auth->logout();
		
		// redirect them to the login page
		$this->session->set_flashdata('success', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}
	
	// check if login user is activated, if inactivate, then logout from here.
	public function check_user() {
		$user = $this->common_model->select($record = 'first', $typecast = 'array', $table = "users", $fields = "`users`.active", $conditions = array(
				'users.id' => $this->ion_auth->user()->row()->id 
		));
		
		if (!$user ['active']) {
			$logout = $this->ion_auth->logout();
			echo TRUE;
		}
		echo FALSE;
	}
	public function _get_csrf_nonce() {
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		
		return array(
				$key => $value 
		);
	}
	public function _valid_csrf_nonce() {
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function _render_page($view, $data = null, $returnhtml = false) {
		$this->viewdata = (empty($data)) ? $this->data : $data;
		
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		
		if ($returnhtml) {
			return $view_html; // This will return html on 3rd argument being true
		}
	}
}
