<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of user
 *
 * @author Bhawani
 */
class Blocklist extends CI_Controller {
	// set private properties here
	private $limit = 17; // no of records per page
	
	public function __construct() {
		parent::__construct();
		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		
		// show the flash data error message if there is one
		$this->data['message'] = $this->parser->parse("elements/notifications", array(), TRUE);
	}
	
	// redirect if needed, otherwise display the user list
	public function index() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You can not view this page.');
		} else {
			$this->load->model('block_list_model');
			// list the users group
				
			$limit = $this->limit;
			$offset = $this->uri->segment(3);
			$get = $this->input->get();
			$this->data['block_list'] = $this->block_list_model->search($get, $limit, $offset);
			$config['total_rows'] = $this->block_list_model->last_rows();
				
			$config['base_url'] = site_url('blocklist');
			$config['per_page'] = $limit;
			$config['first_url'] = $config ['base_url'] . '?' . http_build_query($this->input->get());
			if (count($this->input->get()) > 0) {
				$config ['suffix'] = '?' . http_build_query($this->input->get(), '', "&");
			}

			$this->pagination->initialize($config); // initiaze pagination config
			
			$this->data ['pagination'] = $this->pagination->create_links(); // create pagination links
			
			$this->template->write('title', SITE_TITLE . ' - Block Customer List', TRUE);
			$this->template->write_view('content', 'blocklist', $this->data);
			$this->template->render();
		}
	}

	public function add() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You can not use this page.');
		} else {
			$this->load->model('block_list_model');
			// list the users group
				
			$get = $this->input->get_post();
      if (empty($get["firstname"]) || empty($get["lastname"]) || empty($get["birthday"])) {
  			return show_error('You can not use add user data.');
      }
      $para = [
        "firstname" => $get["firstname"],
        "lastname" => $get["lastname"],
        "birthday" => $get["birthday"],
        "status" => 2
      ];
      if ($block_user = $this->block_list_model->check_list_name($get["firstname"], $get["lastname"], $get["birthday"])) {
        $para["block_list_id"] = $block_user["block_list_id"];
        $para["created"] = $block_user["created"];
      }
      $id = $this->block_list_model->save($para);
      redirect('blocklist', 'refresh');
    }
	}

  public function update() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You can not use this page.');
		} else {
			$this->load->model('block_list_model');
			// list the users group
				
			$get = $this->input->get_post();
      if (empty($get["firstname"]) || empty($get["lastname"]) || empty($get["birthday"])) {
  			return show_error('You can not use add user data.');
      }
      $para = [];
      if (isset($get["block_list_id"])) {
        $para["block_list_id"] = $get["block_list_id"];
      }
      if (isset($get["status"])) {
        $para["status"] = $get["status"];
      }
      if (isset($get["firstname"])) {
        $para["firstname"] = $get["firstname"];
      }
      if (isset($get["lastname"])) {
        $para["lastname"] = $get["lastname"];
      }
      if (isset($get["birthday"])) {
        $para["birthday"] = $get["birthday"];
      }
      if (isset($get["policies"])) {
        $para["policies"] = $get["policies"];
      }
      if (isset($get["notes"])) {
        $para["notes"] = $get["notes"];
      }
      $id = $this->block_list_model->save($para);
      redirect('blocklist', 'refresh');
    }
	}

	public function get_amount() {
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You can not use this page.');
		} else {
			$this->load->model('block_list_model');
			// list the users group
				
			$get = $this->input->get_post();
      if (empty($get["firstname"]) || empty($get["lastname"]) || empty($get["birthday"])) {
  			return show_error('You can not use add user data.');
      }
      $rt = $this->block_list_model->get_user_status($get["firstname"], $get["lastname"], $get["birthday"]);
      header('Content-Type: application/json');
		  echo json_encode($rt);
    }
	}
}
