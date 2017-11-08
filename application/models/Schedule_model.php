<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Schedule_model extends CI_Model {
	const SHIFT_8AM='8';
	const SHIFT_2PM='14';
	const SHIFT_8PM='20';

	const SHIFT_8AM_STR='8am-2pm';
	const SHIFT_2PM_STR='2pm-8pm';
	const SHIFT_8PM_STR='8pm-8am';
	
	public function get_shift_options($flag=FALSE) {
		$rt = array(
				0 => '-- Select Shift--',
				self::SHIFT_8AM_STR => self::SHIFT_8AM_STR,
				self::SHIFT_2PM_STR => self::SHIFT_2PM_STR,
				self::SHIFT_8PM_STR => self::SHIFT_8PM_STR);
		if (!$flag) {
			unset($rt[0]);
		}				
		return $rt;
	}

	public function get_shift_shour($shift) {
		$hoursArr = array(
				self::SHIFT_8AM_STR => 8,
				self::SHIFT_2PM_STR => 14,
				self::SHIFT_8PM_STR => 20);
		if (isset($hoursArr[$shift])) {
			return $hoursArr[$shift];
		}
		return 0;
	}

	public function get_shift_long($shift) {
		$hoursArr = array(
				self::SHIFT_8AM_STR => 6,
				self::SHIFT_2PM_STR => 6,
				self::SHIFT_8PM_STR => 12);
		if (isset($hoursArr[$shift])) {
			return $hoursArr[$shift];
		}
		return 0;
	}

	public function get_by_id($id) {
		$this->db->where('id', $id);
		$rt = $this->db->get('schedule')->row_array();
		return $rt;
	}

	public function get_eacs($maxtime=86400) {
		$st_tm = time() + $maxtime;
		$now = date("Y-m-d H:i:s");
		$maxtm = date("Y-m-d H:i:s", $st_tm);
		$sql = "SELECT u.id, CONCAT(s.date, ' ', s.schedule, ' ', u.email) as schedule FROM schedule s LEFT JOIN users u ON (s.employee_id=u.id) WHERE s.start_tm<='".$maxtm."' AND ADDTIME(s.start_tm, CONCAT(s.shour, ':00:00'))>='".$now."' AND u.active='1'";
		$sql .= " ORDER BY s.start_tm ASC, u.email ASC";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_schedule($year, $month, $user_id = 0) {
		$first_day = $year."-".$month."-1";
		$first_tm = strtotime($first_day);
		$last_tm = strtotime(date("Y-m-t", $first_tm)) + 86400;
		$sql = "SELECT DATE_FORMAT(s.date, '%e') as day,s.*,u.* FROM schedule s LEFT JOIN users u ON (s.employee_id=u.id) WHERE s.start_tm>='".date("Y-m-d H:i:s", $first_tm)."' AND s.start_tm<'".date("Y-m-d H:i:s", $last_tm)."'";
		if ($user_id) {
			$sql .= " AND s.employee_id='" . (int)$user_id . "'";
		}
		$sql .= " ORDER BY s.start_tm ASC, s.shour ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_day_schedule($year, $month, $day, $user_id = 0) {
		$first_day = $year."-".$month."-".$day;
		$first_tm = strtotime($first_day);
		$last_tm = $first_tm + 86400;
		$sql = "SELECT DATE_FORMAT(s.date, '%e') as day,s.*,u.* FROM schedule s LEFT JOIN users u ON (s.employee_id=u.id) WHERE s.start_tm>='".date("Y-m-d H:i:s", $first_tm)."' AND s.start_tm<'".date("Y-m-d H:i:s", $last_tm)."'";
		if ($user_id) {
			$sql .= " AND s.employee_id='" . (int)$user_id . "'";
		}
		$sql .= " ORDER BY s.start_tm ASC, u.id ASC";
		return $this->db->query($sql)->result_array();
	}

	public function clear_schedule_by_month($year, $month, $user_id = 0) {
		$first_day = $year."-".$month."-1";
		$first_tm = strtotime($first_day);
		$last_tm = strtotime(date("Y-m-t", $first_tm)) + 86400;
		$sql = "DELETE FROM schedule WHERE start_tm>='".date("Y-m-d H:i:s", $first_tm)."' AND start_tm<'".date("Y-m-d H:i:s", $last_tm)."'";
		if ($user_id) {
			$sql .= " AND employee_id='" . (int)$user_id . "'";
		}
		$this->db->query($sql);
	}
	
	public function clear_schedule_by_day($year, $month, $day, $user_id = 0) {
		$first_day = $year."-".$month."-".$day;
		$first_tm = strtotime($first_day);
		$last_tm = $first_tm + 86400;
		$sql = "DELETE FROM schedule WHERE start_tm>='".date("Y-m-d H:i:s", $first_tm)."' AND start_tm<'".date("Y-m-d H:i:s", $last_tm)."'";
		if ($user_id) {
			$sql .= " AND employee_id='" . (int)$user_id . "'";
		}
		$this->db->query($sql);
	}
	
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			$cur = $this->get_by_id($id);
			unset($data['id']);
			if ($cur) {
				$this->db->where('id', $id);
				$this->db->update('schedule', $data);
				$this->active_model->log_update('schedule', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		} else {
			// insert
			$this->db->insert('schedule', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('schedule', $id, $data, $sql);
			return $id;
		}
	}
}