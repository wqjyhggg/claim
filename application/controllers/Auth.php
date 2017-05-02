<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Description of user
 *
 * @author Bhawani
 */
class Auth extends CI_Controller {
	// set private properties here
	private $limit = 17; // no of records per page

	public function __construct() {
		parent::__construct ();
		
		$this->form_validation->set_error_delimiters ( $this->config->item ( 'error_start_delimiter', 'ion_auth' ), $this->config->item ( 'error_end_delimiter', 'ion_auth' ) );
		
		$this->lang->load ( 'auth' );
		
		// show the flash data error message if there is one
		$this->data ['message'] = $this->parser->parse ( "elements/notifications", array (), TRUE );
	}
	
	// redirect if needed, otherwise display the products list
	public function index() {
		redirect ( 'auth/users' );
	}
	
	// redirect if needed, otherwise display the my tasks list
	public function mytasks() {
		if (! $this->ion_auth->logged_in ()) {
			// redirect them to the login page
			redirect ( 'auth/login', 'refresh' );
		} else {
			// get my tasks here
			$table = "mytask";
			$fields = "mytask.*, IF(mytask.type='CLAIM', claim.last_update, case.last_update) as last_update, IF(mytask.type='CLAIM', concat_ws(' ', claim.insured_first_name, claim.insured_last_name), concat_ws(' ', case.insured_firstname, case.insured_lastname)) as insured_name, IF(type='CLAIM', '', LPAD(case.assign_to, 4, 0)) as followup_by, IF(mytask.type='CLAIM', claim.status, case.status) as task_status, IF(type='CLAIM', LPAD(claim.assign_to, 4, 0), LPAD(case.assign_to, 4, 0)) as assign_to, concat_ws(' ', users.first_name, users.last_name) as created_by";
			$joins [] = array (
					'table' => 'users',
					'on' => 'users.id = mytask.created_by',
					'type' => 'LEFT' 
			);
			$joins [] = array (
					'table' => 'case',
					'on' => 'case.id = mytask.item_id',
					'type' => 'LEFT' 
			);
			$joins [] = array (
					'table' => 'claim',
					'on' => 'claim.id = mytask.item_id',
					'type' => 'LEFT' 
			);
			$order_by = array (
					'field' => 'id',
					'order' => 'desc' 
			);
			$conditions = "mytask.user_id = '" . $this->ion_auth->user ()->row ()->id . "'";
			
			// if sorting enabled
			if ($this->input->get ( "field" ))
				$order_by = array (
						'field' => $this->input->get ( "field" ),
						'order' => $this->input->get ( "order" ) 
				);
			$limit = $this->limit;
			$offset = $this->uri->segment ( 3 );
			
			// get resultresults
			$results = $this->common_model->select ( $record = "paginate", $typecast = "array", $table, $fields, $conditions, $joins, $order_by, $group_by = array (), $having = "", $limit, $offset );
			
			$config ['base_url'] = site_url ( 'auth/mytasks' );
			$config ['per_page'] = $limit;
			$config ['first_url'] = $config ['base_url'] . '?' . http_build_query ( $this->input->get () );
			if (count ( $this->input->get () ) > 0)
				$config ['suffix'] = '?' . http_build_query ( $this->input->get (), '', "&" );
			$config ['total_rows'] = $results ['rows'];
			$this->pagination->initialize ( $config ); // initiaze pagination config
			$this->data ['records'] = $results ['records'];
			$this->data ['pagination'] = $this->pagination->create_links (); // create pagination links
			                                                               // pagination end here
			
			$this->template->write ( 'title', SITE_TITLE . ' - My Tasks', TRUE );
			$this->template->write_view ( 'content', 'auth/mytasks', $this->data );
			$this->template->render ();
		}
	}
	
	// edit task page
	public function edit_task($id = 0) {
		if (! $this->ion_auth->logged_in ()) {
			// redirect them to the login page
			redirect ( 'auth/login', 'refresh' );
		} else {
			$this->load->model('mytask_model');
			$this->load->model('case_model');
			$this->load->model('claim_model');
			
			// get case details
			$joins = array ();
			$fields = "mytask.*, IF(type='CLAIM', concat_ws(' ', claim.insured_first_name, claim.insured_last_name), concat_ws(' ', case.insured_firstname, case.insured_lastname)) as insured_name, IF(type='CLAIM', LPAD(claim.assign_to, 4, 0), LPAD(case.assign_to, 4, 0)) as assign_to";
			$joins [] = array (
					'table' => 'users',
					'on' => 'users.id = mytask.created_by',
					'type' => 'LEFT' 
			);
			$joins [] = array (
					'table' => 'case',
					'on' => 'case.id = mytask.item_id',
					'type' => 'LEFT' 
			);
			$joins [] = array (
					'table' => 'claim',
					'on' => 'claim.id = mytask.item_id',
					'type' => 'LEFT' 
			);
			$order_by = array (
					'field' => 'id',
					'order' => 'desc' 
			);
			$task_details = $this->common_model->select ( $record = "first", $typecast = "array", $table = "mytask", $fields, $conditions = array (
					'mytask.id' => $id 
			), $joins );
			
			// validate form input
			if ($task_details ['type'] == 'CASE' and ($this->ion_auth->is_admin () or $this->ion_auth->is_casemamager ()))
				$this->form_validation->set_rules ( 'assign_to', 'Assign To', 'required' );
			if ($task_details ['type'] == 'CLAIM')
				$this->form_validation->set_rules ( 'assign_to', 'Assign To', 'required' );
			$this->form_validation->set_rules ( 'priority', 'Priority', 'required' );
			
			if ($this->form_validation->run () == TRUE) {
				// update case/claim details
				$data = array (
						'assign_to' => $this->input->post ( 'assign_to' ),
						'priority' => $this->input->post ( 'priority' ) 
				);
				
				// prepare post data array
				if ($task_details ['type'] == 'CASE') {
					// update values to database
					$this->common_model->update ( "case", $data, array (
							'id' => $task_details ['item_id'] 
					) );
					
					// update assign to data in task db
					if ($this->input->post ( 'assign_to' )) {
						$data_task = array (
								'user_id' => $this->input->post ( 'assign_to' ) 
						);
						
						$this->common_model->update ( "mytask", $data_task, array (
								'item_id' => $task_details ['item_id'],
								'type' => 'CASE',
								'user_type' => 'eac' 
						) );
					}
				} else {
					// update values to database
					$this->common_model->update ( "claim", $data, array (
							'id' => $task_details ['item_id'] 
					) );
					
					// update assign to data in task db for claim type
					$data_task = array (
							'user_id' => $this->input->post ( 'assign_to' ) 
					);
					$this->common_model->update ( "mytask", $data_task, array (
							'item_id' => $task_details ['item_id'],
							'type' => 'CLAIM',
							'user_type' => 'claimexaminer' 
					) );
				}
				$this->active_model->log_update('mytask', $id, $task_details, $data_task, $this->db->last_query());
				
				// update data in task database
				$data_task = array (
						'priority' => $this->input->post ( 'priority' ) 
				);
				$this->common_model->update ( "mytask", $data_task, array (
						'id' => $id 
				) );
				$this->active_model->log_update('mytask', $id, $task_details, $data_task, $this->db->last_query());
				
				// send success message
				$this->session->set_flashdata ( 'success', "Task details successfully updated" );
				
				// redirect them to the login page
				redirect ( 'auth/mytasks', 'refresh' );
			} else {
				$this->data ['task_details'] = $task_details;
				if (empty ( $task_details )) {
					// send error message
					$this->session->set_flashdata ( 'error', "Something went wrong, please try after some time." );
					
					// redirect them to the list page
					redirect ( 'emergency_assistance', 'refresh' );
				}
				$this->data ['eacmanagers'] = $this->common_model->getrusers ( $field_name = "assign_to", $selected = ($this->common_model->field_val ( $field_name, $task_details )), $group = array (
						"'eacmanager'" 
				), $empty = "--Follow Up EAC--" );
				
				// get claim examiners
				$this->data ['claim_examiner'] = $this->common_model->getrusers ( $field_name = "assign_to", $selected = ($this->common_model->field_val ( $field_name, $task_details )), $group = array (
						"'claimexaminer'" 
				), $empty = "--Select Claim Examiner--", $additional_conditions = "" );
				
				// load view data
				$this->template->write ( 'title', SITE_TITLE . ' - Edit Task', TRUE );
				$this->template->write_view ( 'content', 'auth/edit_task', $this->data );
				$this->template->render ();
			}
		}
	}
	
	// log the user in
	public function login() {
		
		// validate form input
		$this->form_validation->set_rules ( 'identity', str_replace ( ':', '', $this->lang->line ( 'login_identity_label' ) ), 'required' );
		$this->form_validation->set_rules ( 'password', str_replace ( ':', '', $this->lang->line ( 'login_password_label' ) ), 'required' );
		
		if ($this->form_validation->run () == true) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = ( bool ) $this->input->post ( 'remember' );
			
			if ($this->ion_auth->login ( $this->input->post ( 'identity' ), $this->input->post ( 'password' ), $remember )) {
				// if the login is successful
				// redirect them back to the home page
				$this->session->set_flashdata ( 'success', $this->ion_auth->messages () );
				redirect ( 'auth/mytasks', 'refresh' );
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata ( 'error', $this->ion_auth->errors () );
				redirect ( 'auth/login', 'refresh' ); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			$this->data ['identity'] = array (
					'name' => 'identity',
					'id' => 'identity',
					'type' => 'text',
					'value' => $this->form_validation->set_value ( 'identity' ),
					'class' => 'form-control',
					'placeholder' => 'Username' 
			);
			$this->data ['password'] = array (
					'name' => 'password',
					'id' => 'password',
					'type' => 'password',
					'class' => 'form-control',
					'placeholder' => 'Password' 
			)
			;
			$this->_render_page ( 'auth/login', $this->data );
		}
	}
	
	// redirect if needed, otherwise display the user list
	public function users() {
		if (! $this->ion_auth->logged_in ()) {
			// redirect them to the login page
			redirect ( 'auth/login', 'refresh' );
		} elseif (! $this->ion_auth->is_admin ()) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error ( 'You must be an administrator to view this page.' );
		} else {
			// list the users group
			$this->load->model('groups_model');
			$this->data ['groups'] = $this->groups_model->get_list(1);
			
			// table settings goes here
			$table = "users";
			$fields = "users.first_name, users.last_name, users.email, users.active, users.id";
			$group_by = array (	"users_groups.user_id" );
			
			// prepare conditions
			$conditions = [ ];
			if ($this->input->get ( "groups" ))
				$conditions ['users_groups.group_id'] = $this->input->get ( "groups" );
			if ($this->input->get ( "status" ))
				$conditions ['users.active'] = $this->input->get ( "status" );
			if ($this->input->get ( "last_name" ))
				$conditions ['users.last_name'] = trim ( $this->input->get ( "last_name" ) );
			if ($this->input->get ( "first_name" ))
				$conditions ['users.first_name'] = trim ( $this->input->get ( "first_name" ) );
			if ($this->input->get ( "email" ))
				$conditions ['users.email like '] = "%" . $this->input->get ( "email" ) . "%";
			if ($this->input->get ( "status" ) != '')
				$conditions ['users.active'] = $this->input->get ( "status" );
			
			$joins [] = array (
					'table' => 'users_groups',
					'on' => 'users_groups.user_id = users.id',
					'type' => 'LEFT' 
			);
			$order_by = array (
					'field' => 'id',
					'order' => 'desc' 
			);
			
			// if sorting enabled
			if ($this->input->get ( "field" ))
				$order_by = array (
						'field' => $this->input->get ( "field" ),
						'order' => $this->input->get ( "order" ) 
				);
			$limit = $this->limit;
			$offset = $this->uri->segment ( 3 );
			
			// get result
			$results = $this->common_model->select ( $record = "paginate", $typecast = "array", $table, $fields, $conditions, $joins, $order_by, $group_by, $having = "", $limit, $offset );
			
			$config ['base_url'] = site_url ( 'auth/users' );
			$config ['per_page'] = $limit;
			$config ['first_url'] = $config ['base_url'] . '?' . http_build_query ( $this->input->get () );
			if (count ( $this->input->get () ) > 0)
				$config ['suffix'] = '?' . http_build_query ( $this->input->get (), '', "&" );
			$config ['total_rows'] = $results ['rows'];
			$this->pagination->initialize ( $config ); // initiaze pagination config
			
			$this->data ['pagination'] = $this->pagination->create_links (); // create pagination links
			                                                               // pagination end here
			
			$this->data ['users'] = $results ['records'];
			foreach ( $this->data ['users'] as $k => $user ) {
				$this->data ['users'] [$k] ['groups'] = $this->ion_auth->get_users_groups ( $user ['id'] )->result ();
			}
			
			$this->template->write ( 'title', SITE_TITLE . ' - Manage Users', TRUE );
			$this->template->write_view ( 'content', 'auth/users', $this->data );
			$this->template->render ();
		}
	}
	
	// custom name validation
	function alpha_dash_space($fullname) {
		if (! preg_match ( '/^[a-zA-Z\s]+$/', $fullname )) {
			$this->form_validation->set_message ( 'alpha_dash_space', 'The %s field may only contain alpha characters & White spaces' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// create a new user
	public function create_user() {
		$this->data ['title'] = $this->lang->line ( 'create_user_heading' );
		
		if (! $this->ion_auth->logged_in () || ! $this->ion_auth->is_admin ()) {
			redirect ( 'auth/users', 'refresh' );
		}
		
		// Get model
		$this->load->model('groups_model');
		$this->load->model('product_model');
		
		$groups = $this->ion_auth->groups ()->result_array ();
		$tables = $this->config->item ( 'tables', 'ion_auth' );
		$identity_column = $this->config->item ( 'identity', 'ion_auth' );
		$this->data ['identity_column'] = $identity_column;
		
		// validate form input
		$this->form_validation->set_error_delimiters ( '<div class="error">', '</div>' );
		$this->form_validation->set_rules ( 'first_name', $this->lang->line ( 'create_user_validation_fname_label' ), 'required|callback_alpha_dash_space' );
		$this->form_validation->set_rules ( 'last_name', $this->lang->line ( 'create_user_validation_lname_label' ), 'required|callback_alpha_dash_space' );
		if ($identity_column !== 'email') {
			$this->form_validation->set_rules ( 'identity', $this->lang->line ( 'create_user_validation_identity_label' ), 'required|is_unique[' . $tables ['users'] . '.' . $identity_column . ']' );
			$this->form_validation->set_rules ( 'email', $this->lang->line ( 'create_user_validation_email_label' ), 'required|valid_email' );
		} else {
			$this->form_validation->set_rules ( 'email', $this->lang->line ( 'create_user_validation_email_label' ), 'required|valid_email|is_unique[' . $tables ['users'] . '.email]' );
		}
		$this->form_validation->set_rules ( 'phone', $this->lang->line ( 'create_user_validation_phone_label' ), 'trim|numeric|min_length[9]|max_length[15]' );
		$this->form_validation->set_rules ( 'company', $this->lang->line ( 'create_user_validation_company_label' ), 'trim' );
		$this->form_validation->set_rules ( 'password', $this->lang->line ( 'create_user_validation_password_label' ), 'required|min_length[' . $this->config->item ( 'min_password_length', 'ion_auth' ) . ']|max_length[' . $this->config->item ( 'max_password_length', 'ion_auth' ) . ']|matches[password_confirm]' );
		$this->form_validation->set_rules ( 'password_confirm', $this->lang->line ( 'create_user_validation_password_confirm_label' ), 'required' );
		$this->form_validation->set_rules ( 'groups[]', 'Member of groups', 'required' );
		
		$groupData = $this->input->post ( 'groups' );
		if (! empty ( $groupData ) and in_array ( 2, $groupData )) {
			$this->form_validation->set_rules ( 'shift', 'Shift', 'required' );
		}
		
		if ($this->form_validation->run () == true) {
			$email = strtolower ( $this->input->post ( 'email' ) );
			$identity = ($identity_column === 'email') ? $email : $this->input->post ( 'identity' );
			$password = $this->input->post ( 'password' );
			
			$additional_data = array (
					'first_name' => $this->input->post ( 'first_name' ),
					'last_name' => $this->input->post ( 'last_name' ),
					'company' => $this->input->post ( 'company' ),
					'phone' => $this->input->post ( 'phone' ),
					'shift' => $this->input->post ( 'shift' ) 
			);
		}
		if ($this->form_validation->run () == true && $id = $this->ion_auth->register ( $identity, $password, $email, $additional_data )) {
			// Update the groups user belongs to
			$groupData = $this->input->post ( 'groups' );
			
			if (isset ( $groupData ) && ! empty ( $groupData )) {
				
				foreach ( $groupData as $grp ) {
					$this->ion_auth->add_to_group ( $grp, $id );
				}
			}
			
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata ( 'message', array (
					'timeout' => 1000 
			), $this->ion_auth->messages () );
			redirect ( "auth/users", 'refresh' );
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
			
			$this->data ['first_name'] = array (
					'name' => 'first_name',
					'id' => 'first_name',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'first_name' ) 
			);
			$this->data ['last_name'] = array (
					'name' => 'last_name',
					'id' => 'last_name',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'last_name' ) 
			);
			$this->data ['identity'] = array (
					'name' => 'identity',
					'id' => 'identity',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'identity' ) 
			);
			$this->data ['email'] = array (
					'name' => 'email',
					'id' => 'email',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'email' ) 
			);
			$this->data ['company'] = array (
					'name' => 'company',
					'id' => 'company',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'company' ) 
			);
			$this->data ['phone'] = array (
					'name' => 'phone',
					'id' => 'phone',
					'type' => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'phone' ) 
			);
			$this->data ['password'] = array (
					'name' => 'password',
					'id' => 'password',
					'type' => 'password',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value ( 'password' ) 
			);
			$this->data ['password_confirm'] = array (
					'name' => 'password_confirm',
					'id' => 'password_confirm',
					'class' => 'form-control',
					'type' => 'password',
					'value' => $this->form_validation->set_value ( 'password_confirm' ) 
			);
			$this->data ['shift_options'] = array (
					'' => 'Select Shift',
					'8am-2pm' => '8am-2pm',
					'2pm-8pm' => '2pm-8pm',
					'8pm-8am' => '8pm-8am' 
			);
			$this->data ['groups'] = $groups;
			
			$this->template->write ( 'title', SITE_TITLE . ' - Create User', TRUE );
			$this->template->write_view ( 'content', 'auth/create_user', $this->data );
			$this->template->render ();
		}
	}
	
	// create / edit a user
	public function edit_user($id=0) {
		$this->data ['title'] = $this->lang->line ( 'edit_user_heading' );
		
		if (! $this->ion_auth->logged_in() || (!$this->ion_auth->is_admin () && ! ($this->ion_auth->get_user_id == $id))) {
			redirect ( 'auth/users', 'refresh' );
		}
		
		$this->load->model('users_model');
		$this->load->model('groups_model');
		$this->load->model('product_model');
		
		$user = $this->users_model->get_by_id($id);
		$groups = $this->groups_model->get_list();
		$currentGroups = $this->users_model->get_users_groups($id);
		$products = $this->product_model->get_list();
		$currentProducts = $this->users_model->get_users_products($id);
		if ($user) {
			$this->data ['title'] = $this->lang->line ( 'edit_user_heading' );
		} else {
			$user = array();
			$this->data ['title'] = $this->lang->line ( 'create_user_heading' );
		}
		
		// validate form input
		$this->form_validation->set_error_delimiters ( '<div class="error">', '</div>' );
		if (empty($user)) {
			$tables = $this->config->item ( 'tables', 'ion_auth' );
			$this->form_validation->set_rules ( 'email', $this->lang->line ( 'create_user_validation_email_label' ), 'required|valid_email|is_unique[' . $tables ['users'] . '.email]' );
		}
		$this->form_validation->set_rules ( 'first_name', $this->lang->line ( 'edit_user_validation_fname_label' ), 'required|callback_alpha_dash_space' );
		$this->form_validation->set_rules ( 'last_name', $this->lang->line ( 'edit_user_validation_lname_label' ), 'required|callback_alpha_dash_space' );
		$this->form_validation->set_rules ( 'phone', $this->lang->line ( 'edit_user_validation_phone_label' ), 'required|numeric|min_length[9]|max_length[15]' );
		$this->form_validation->set_rules ( 'groups[]', 'Member of groups', 'required' );
		$this->form_validation->set_rules ( 'products[]', 'Member of products', 'required' );
		
		$groupData = $this->input->post ( 'groups' );
		if (! empty ( $groupData ) and in_array ( 2, $groupData )) {
			$this->form_validation->set_rules ( 'shift', 'Shift', 'required' );
		}
		
		if ($this->input->post ()) {
			// update the password if it was posted
			if ($this->input->post ( 'password' )) {
				$this->form_validation->set_rules ( 'password', $this->lang->line ( 'edit_user_validation_password_label' ), 'required|min_length[' . $this->config->item ( 'min_password_length', 'ion_auth' ) . ']|max_length[' . $this->config->item ( 'max_password_length', 'ion_auth' ) . ']|matches[password_confirm]' );
				$this->form_validation->set_rules ( 'password_confirm', $this->lang->line ( 'edit_user_validation_password_confirm_label' ), 'required' );
			}
			
			if ($this->form_validation->run () === TRUE) {
				$data = array (
						'email' => $this->input->post ( 'email' ),
						'first_name' => $this->input->post ( 'first_name' ),
						'last_name' => $this->input->post ( 'last_name' ),
						'company' => $this->input->post ( 'company' ),
						'phone' => $this->input->post ( 'phone' ),
						'shift' => $this->input->post ( 'shift' ) 
				);
				if ($id = $this->input->post ( 'id' )) {
					$data ['id'] = $this->input->post ( 'id' );
				}
				
				// update the password if it was posted
				if ($this->input->post ( 'password' )) {
					$data ['password'] = $this->input->post ( 'password' );
				}

				if ($id = $this->users_model->save($data )) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', $this->ion_auth->messages () );
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata ( 'message', 'Some thing wrong, please contact admin');
				}
				
				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin ()) {
					// Update the groups user belongs to
					$this->users_model->set_users_products($id, $this->input->post('products[]'));
					$this->users_model->set_users_groups($id, $this->input->post('groups'));
				}
				
				// check to see if we are updating the user
				if ($this->ion_auth->is_admin ()) {
					redirect ( 'auth/users', 'refresh' );
				} else {
					redirect ( '/', 'refresh' );
				}
			}
		}
		
		$this->data ['action_url'] = base_url('auth/edit_user' ) . empty($user) ? '' : "/" . $id;
		// display the edit user form
		$this->data ['csrf'] = $this->_get_csrf_nonce ();
		
		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors () ? validation_errors () : ($this->ion_auth->errors () ? $this->ion_auth->errors () : $this->session->flashdata ( 'message' )));
		
		// pass the user to the view
		$this->data ['user'] = $user;
		$this->data ['groups'] = $groups;
		$this->data = array_merge($this->data, $user);

		$this->data ['products'] = $products;
		if ($this->input->post ()) {
			$post = $this->input->post ();
			$this->data ['currentGroups'] = isset($post['groups']) ? $post['groups'] : array();
			$this->data ['currentProducts'] = isset($post['products']) ? $post['products'] : array();
			unset($post['groups']);
			unset($post['products']);
			$this->data = array_merge($this->data, $post);
		} else {
			$this->data ['currentGroups'] = array();
			if ($currentGroups) {
				foreach ($currentGroups as $cur) {
					$this->data['currentGroups'][] = $cur['group_id'];
				}
			}
				
			$this->data ['currentProducts'] = array();
			if ($currentProducts) {
				foreach ($currentProducts as $cur) {
					$this->data['currentProducts'][] = $cur['product_short']; 
				}
			}
		}
		
		$this->data ['email'] = array (
				'name' => 'email',
				'id' => 'email',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'email', empty($this->data['email']) ? '' : $this->data['email'] ) 
		);
		if (!empty($user)) $this->data ['email']['readonly'] = 'readonly';
		$this->data ['first_name'] = array (
				'name' => 'first_name',
				'id' => 'first_name',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'first_name', empty($this->data['first_name']) ? '' : $this->data['first_name'] ) 
		);
		$this->data ['last_name'] = array (
				'name' => 'last_name',
				'id' => 'last_name',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'last_name', empty($this->data['last_name']) ? '' : $this->data['last_name'] ) 
		);
		$this->data ['company'] = array (
				'name' => 'company',
				'id' => 'company',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'company', empty($this->data['company']) ? '' : $this->data['company'] ) 
		);
		$this->data ['phone'] = array (
				'name' => 'phone',
				'id' => 'phone',
				'class' => 'form-control',
				'type' => 'text',
				'value' => $this->form_validation->set_value ( 'phone', empty($this->data['phone']) ? '' : $this->data['phone'] ) 
		);
		$this->data ['password'] = array (
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'type' => 'password' 
		);
		$this->data ['password_confirm'] = array (
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'class' => 'form-control',
				'type' => 'password' 
		);
		$this->data ['shift_options'] = $this->users_model->get_shift_options(1);
		
		$this->template->write ( 'title', SITE_TITLE . ' - Edit User', TRUE );
		$this->template->write_view ( 'content', 'auth/edit_user', $this->data );
		$this->template->render ();
	}
	
	// change password
	public function change_password() {
		$this->form_validation->set_rules ( 'old', $this->lang->line ( 'change_password_validation_old_password_label' ), 'required' );
		$this->form_validation->set_rules ( 'new', $this->lang->line ( 'change_password_validation_new_password_label' ), 'required|min_length[' . $this->config->item ( 'min_password_length', 'ion_auth' ) . ']|max_length[' . $this->config->item ( 'max_password_length', 'ion_auth' ) . ']|matches[new_confirm]' );
		$this->form_validation->set_rules ( 'new_confirm', $this->lang->line ( 'change_password_validation_new_password_confirm_label' ), 'required' );
		
		if (! $this->ion_auth->logged_in ()) {
			redirect ( 'auth/login', 'refresh' );
		}
		
		$user = $this->ion_auth->user ()->row ();
		
		if ($this->form_validation->run () == false) {
			// display the form
			$this->data ['min_password_length'] = $this->config->item ( 'min_password_length', 'ion_auth' );
			$this->data ['old_password'] = array (
					'name' => 'old',
					'id' => 'old',
					'type' => 'password' 
			);
			$this->data ['new_password'] = array (
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$' 
			);
			$this->data ['new_password_confirm'] = array (
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$' 
			);
			$this->data ['user_id'] = array (
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id 
			);
			
			// render
			$this->_render_page ( 'auth/change_password', $this->data );
		} else {
			$identity = $this->session->userdata ( 'identity' );
			
			$change = $this->ion_auth->change_password ( $identity, $this->input->post ( 'old' ), $this->input->post ( 'new' ) );
			
			if ($change) {
				// if the password was successfully changed
				$this->session->set_flashdata ( 'message', $this->ion_auth->messages () );
				$this->logout ();
			} else {
				$this->session->set_flashdata ( 'message', $this->ion_auth->errors () );
				redirect ( 'auth/change_password', 'refresh' );
			}
		}
	}
	
	// activate the user
	public function activate($id) {
		if ($this->ion_auth->logged_in () && $this->ion_auth->is_admin ()) {
			$this->load->model('users_model');
			$this->users_model->save(array('id' => $id, 'active' => 1));
			// redirect them to the auth page
			$this->session->set_flashdata ( 'message', 'User Actived');
			redirect ( "auth/users", 'refresh' );
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata ( 'message', 'Only Admin can do this' );
			redirect ( "auth/forgot_password", 'refresh' );
		}
	}
	
	// deactivate the user
	public function deactivate($id = NULL) {
		if ($this->ion_auth->logged_in () && $this->ion_auth->is_admin ()) {
			$this->load->model('users_model');
			$this->users_model->save(array('id' => $id, 'active' => 0));
			// redirect them to the auth page
			$this->session->set_flashdata ( 'message', 'User Deactived');
			redirect ( "auth/users", 'refresh' );
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata ( 'message', 'Only Admin can do this' );
			redirect ( "auth/forgot_password", 'refresh' );
		}
	}
	
	// for autocomplete search
	public function autocomplete($field, $type = "") {
		$query = $this->input->get ( "query" );
		
		// get search query
		$table = "users";
		$group_by = array (
				"users_groups.user_id" 
		);
		$fields = "users.$field as `value`, users.id as `data`";
		$joins [] = array (
				'table' => 'users_groups',
				'on' => 'users_groups.user_id = users.id',
				'type' => 'LEFT' 
		);
		$conditions = "users.$field like '%$query%' ";
		if ($type)
			$conditions .= " and users_groups.group_id = '$type' ";
		$results = $this->common_model->select ( $record = "list", $typecast = "object", $table, $fields, $conditions, $joins, $order_by = array (), $group_by );
		
		// return result in json format
		$results = array (
				'suggestions' => $results 
		);
		echo json_encode ( $results );
	}
	public function help() {
		if (! $this->ion_auth->logged_in ()) {
			// redirect them to the login page
			redirect ( 'auth/login', 'refresh' );
		} else {
			$this->template->write ( 'title', SITE_TITLE . ' - Help', TRUE );
			$this->template->write_view ( 'content', 'auth/help' );
			$this->template->render ();
		}
	}
	
	// log the user out
	public function logout() {
		$this->data ['title'] = "Logout";
		
		// log the user out
		$logout = $this->ion_auth->logout ();
		
		// redirect them to the login page
		$this->session->set_flashdata ( 'success', $this->ion_auth->messages () );
		redirect ( 'auth/login', 'refresh' );
	}
	
	// check if login user is activated, if inactivate, then logout from here.
	public function check_user() {
		$user = $this->common_model->select ( $record = 'first', $typecast = 'array', $table = "users", $fields = "`users`.active", $conditions = array (
				'users.id' => $this->ion_auth->user ()->row ()->id 
		) );
		
		if (! $user ['active']) {
			$logout = $this->ion_auth->logout ();
			echo TRUE;
		}
		echo FALSE;
	}
	public function _get_csrf_nonce() {
		$this->load->helper ( 'string' );
		$key = random_string ( 'alnum', 8 );
		$value = random_string ( 'alnum', 20 );
		$this->session->set_flashdata ( 'csrfkey', $key );
		$this->session->set_flashdata ( 'csrfvalue', $value );
		
		return array (
				$key => $value 
		);
	}
	public function _valid_csrf_nonce() {
		$csrfkey = $this->input->post ( $this->session->flashdata ( 'csrfkey' ) );
		if ($csrfkey && $csrfkey == $this->session->flashdata ( 'csrfvalue' )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function _render_page($view, $data = null, $returnhtml = false) // I think this makes more sense
{
		$this->viewdata = (empty ( $data )) ? $this->data : $data;
		
		$view_html = $this->load->view ( $view, $this->viewdata, $returnhtml );
		
		if ($returnhtml)
			return $view_html; // This will return html on 3rd argument being true
	}
}
