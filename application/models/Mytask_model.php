<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Mytask_model extends CI_Model {
	const TASK_TYPE_CASE='CASE';
	const TASK_TYPE_CLAIM='CLAIM';
	const TASK_TYPE_CASE_CHANGE='CASE_CHANGE';

	const CATEGORY_ASSISTANCE='Assistance';
	const CATEGORY_CLAIMS='Claims';
	
	const USER_TYPE_EAC='EAC';
	const USER_TYPE_MANAGER='Manager';
	const USER_TYPE_EXAM='Examiner';
	
	const PRIORITY_CRITICAL='Critical';
	const PRIORITY_HIGH='High';
	const PRIORITY_MEDIUM='Medium';
	const PRIORITY_LOW='Low';
	
	const STATUS_ASSIGNED='Assigned';
	const STATUS_REASSIGNED='Reassigned';
	const STATUS_ONGOING='Ongoing';
	const STATUS_COMPLETED='Completed';
	const STATUS_CANCELLED='Cancelled';
	
	/**
	 * Return a list of mytask
	 *
	 * @param integer $id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('mytask')->row_array();
	}
	
	/**
	 * Return a list of mytask
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('mytask')->result_array();
	}

	/**
	 * Return a list of mytask
	 *
	 * @param integer $id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_status() {
		return array(self::STATUS_ASSIGNED, self::STATUS_REASSIGNED, self::STATUS_ONGOING, self::STATUS_COMPLETED, self::STATUS_CANCELLED);
	}
	
	/**
	 * Return a list of mytask
	 *
	 * @param integer $id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_priorities() {
		return array(self::PRIORITY_CRITICAL, self::PRIORITY_HIGH, self::PRIORITY_MEDIUM, self::PRIORITY_LOW);
	}
	
	/**
	 * Save or Update a mytask
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$rc = $this->get_by_id($id);
			if ($rc) {
				$update = array();
				$logstr = '';
				if (isset($data['user_id']) && ($data['user_id'] != $rc['user_id'])) {
					$update[] = "user_id='" . (int)$data['user_id'] . "'";
					$logstr = "user_id: ".$rc['user_id']." => ".$data['user_id']."; ";
				}
				if (isset($data['item_id']) && ($data['item_id'] != $rc['item_id'])) {
					$update[] = "item_id='" . (int)$data['item_id'] . "'";
					$logstr = "item_id: ".$rc['item_id']." => ".$data['item_id']."; ";
				}
				if (isset($data['task_no']) && ($data['task_no'] != $rc['task_no'])) {
					$update[] = "task_no=" . $this->db->escape($data['task_no']);
					$logstr = "task_no: ".$rc['task_no']." => ".$data['task_no']."; ";
				}
				if (isset($data['category']) && ($data['category'] != $rc['category'])) {
					$update[] = "category=" . $this->db->escape($data['category']);
					$logstr = "category: ".$rc['category']." => ".$data['category']."; ";
				}
				if (isset($data['due_date']) && ($data['due_date'] != $rc['due_date'])) {
					$update[] = "due_date=" . $this->db->escape($data['due_date']);
					$logstr = "due_date: ".$rc['due_date']." => ".$data['due_date']."; ";
				}
				if (isset($data['due_time']) && ($data['due_time'] != $rc['due_time'])) {
					$update[] = "due_time=" . $this->db->escape($data['due_time']);
					$logstr = "due_time: ".$rc['due_time']." => ".$data['due_time']."; ";
				}
				if (isset($data['completion_date']) && ($data['completion_date'] != $rc['completion_date'])) {
					$update[] = "completion_date=" . $this->db->escape($data['completion_date']);
					$logstr = "completion_date: ".$rc['completion_date']." => ".$data['completion_date']."; ";
				}
				if (isset($data['type']) && ($data['type'] != $rc['type'])) {
					$update[] = "type=" . $this->db->escape($data['type']);
					$logstr = "type: ".$rc['type']." => ".$data['type']."; ";
				}
				if (isset($data['priority']) && ($data['priority'] != $rc['priority'])) {
					$update[] = "priority=" . $this->db->escape($data['priority']);
					$logstr = "priority: ".$rc['priority']." => ".$data['priority']."; ";
				}
				if (isset($data['created_by']) && ($data['created_by'] != $rc['created_by'])) {
					$update[] = "created_by=" . (int)$data['created_by'];
					$logstr = "created_by: ".$rc['created_by']." => ".$data['created_by']."; ";
				}
				if (isset($data['user_type']) && ($data['user_type'] != $rc['user_type'])) {
					$update[] = "user_type=" . $this->db->escape($data['user_type']);
					$logstr = "user_type: ".$rc['user_type']." => ".$data['user_type']."; ";
				}
				if (isset($data['status']) && ($data['status'] != $rc['status'])) {
					$update[] = "status=" . $this->db->escape($data['status']);
					$logstr = "status: ".$rc['status']." => ".$data['status']."; ";
				}
				if (isset($data['finished']) && ($data['finished'] != $rc['finished'])) {
					$update[] = "finished=" . (int)$data['finished'];
					$logstr = "finished: ".$rc['finished']." => ".$data['finished']."; ";
				}
				if (isset($data['notes']) && !empty($data['notes'])) {
					$update[] = "notes=CONCAT(notes, " . $this->db->escape("---" . $this->session->userdata('user_id') . " at " . date("Ymd His") . "<br />   " . $data['notes'] . "<br />") . ")";
					$logstr = "notes: ".$rc['notes']."; ";
				}
				if (!empty($update)) {
					$update[] = "logs=CONCAT(logs, " . $this->db->escape("---" . $this->session->userdata('user_id') . " at " . date("Ymd His") . "<br />   " . $logstr . "<br />") . ")";
					
					$sql = "UPDATE mytask SET " . join(", ", $update) . " WHERE id='" . (int)$id . "'";
					$this->db->query($sql);
					$this->active_model->log_update('mytask', $id, $rc, $data, $this->db->last_query());
				}
				return $id;
			}
			return 0; // unknown id
		} else {
			// insert
			$this->db->insert('mytask', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('mytask', $id, $data, $sql);
			$this->db->query("UPDATE mytask SET logs='---" . $this->session->userdata('user_id') . " create at " . date("Ymd His") . "<br />' WHERE id='" . (int)$id . "'");
			return $id;
		}
	}
	
	/**
	 * Update a mytask
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function update($updatedata, $conditions) {
		$this->db->set($updatedata);
		$this->db->where($conditions);
		$this->db->update('mytask');
		$data = array();
		
		$this->active_model->log_update_more('mytask', 'Updated', $conditions, $this->db->last_query());
	}

	/**
	 * Return a list users
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() AS linenumber")->row()->linenumber;
	}
	
	/**
	 * Get mytask
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function get_mytask($para, $limit=30, $offset=0 ) {
		//	$fields = "mytask.*, IF(mytask.type='CLAIM', claim.last_update, case.last_update) as last_update, IF(mytask.type='CLAIM', concat_ws(' ', claim.insured_first_name, claim.insured_last_name), concat_ws(' ', case.insured_firstname, case.insured_lastname)) as insured_name, IF(type='CLAIM', '', LPAD(case.assign_to, 4, 0)) as followup_by, IF(mytask.type='CLAIM', claim.status, case.status) as task_status, u2.username as assign_name, concat_ws(' ', users.first_name, users.last_name) as created_by";
	
		if (isset($para['finished'])) {
			$sql = "SELECT SQL_CALC_FOUND_ROWS t.id,t.user_id,t.item_id,task_no,t.category,t.due_date,t.due_time,t.completion_date,t.type,c.priority,t.created_by,t.user_type,t.status,t.created,t.finished,t.notes,t.logs FROM mytask t LEFT JOIN `case` c ON (t.item_id=c.id AND t.type='CASE') WHERE t.finished='".(int)$para['finished']."'";
		} else {
			$sql = "SELECT SQL_CALC_FOUND_ROWS t.id,t.user_id,t.item_id,task_no,t.category,t.due_date,t.due_time,t.completion_date,t.type,c.priority,t.created_by,t.user_type,t.status,t.created,t.finished,t.notes,t.logs FROM mytask t LEFT JOIN `case` c ON (t.item_id=c.id AND t.type='CASE') WHERE t.finished='0'";
		}

		if (!$this->ion_auth->in_group(Users_model::GROUP_ADMIN)) {
			$sql .= " AND t.user_id='".$this->ion_auth->get_user_id()."'";
		}

		if (!empty($para['type'])) {
			$sql .= "  AND t.type=" . $this->db->escape($para['type']);
		}
		
		$orderby = array();
		$order = "DESC";
		if (isset($para['order']) && ($para['order'] == 'asc')) {
			$order = "ASC";
		}
		
		$oarr = array('id', 'user_id', 'task_no', 'due_date', 'completion_date', 'priority', 'created_by', 'status', 'created', 'due');
		if (isset($para['field']) && (in_array($para['field'], $oarr))) {
			if ($para['field'] != 'due') {
				if ($para['field'] == 'priority') {
					$orderby[] = "FIELD(c.priority, NULL, '".self::PRIORITY_CRITICAL."','".self::PRIORITY_HIGH."','".self::PRIORITY_MEDIUM."','".self::PRIORITY_LOW."') " . $order;
				} else {
					$orderby[] = $para['field'] . " " . $order;
				}
			} else {
				$orderby[] = 't.due_date '.$order;
				$orderby[] = 't.due_time '.$order;
			}
		}

		if ($orderby) {
			$sql .= " ORDER BY " .join(',', $orderby);
		} else {
			$sql .= " ORDER BY t.id DESC";
		}
		
		$sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_auto_assign_manager_id() {
		$sql = "SELECT u.id, (SELECT count(c.case_manager) FROM `case` c WHERE c.status='".Case_model::STATUS_ACTIVE."' AND c.case_manager=u.id) as cnt FROM users u WHERE u.active='1' AND groups LIKE '%".Users_model::GROUP_MANAGER."%' ORDER BY cnt ASC, u.id ASC";
		$rt = $this->db->query($sql);
		$rc = $rt->row_array();
		if ($rc) {
			return $rc['id'];
		}
		return 0;
	}
	
	function get_auto_assign_examiner_id() {
		$sql = "SELECT u.id, (SELECT count(c.assign_to) FROM `claim` c WHERE c.status IN ('".Claim_model::STATUS_Appealed."','".Claim_model::STATUS_Processing."','".Claim_model::STATUS_Pending."') AND c.assign_to=u.id) as cnt FROM users u WHERE u.active='1' AND groups LIKE '%".Users_model::GROUP_EXAMINER."%' ORDER BY cnt ASC, u.id ASC";
		$rt = $this->db->query($sql);
		$rc = $rt->row_array();
		if ($rc) {
			return $rc['id'];
		}
		return 0;
	}
}
