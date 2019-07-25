<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Expenses_model extends CI_Model {
	const EXPENSE_STATUS_Received='Received';
	const EXPENSE_STATUS_Pending='Pending';
	const EXPENSE_STATUS_Approved='Approved';
	const EXPENSE_STATUS_Declined='Declined';
	const EXPENSE_STATUS_Duplicated='Duplicated';
	const EXPENSE_STATUS_Paid='Paid';
	
	/**
	 * 
	 */
	public function get_coverage_code() {
		return array(
				'V01' => 'V01 - Hospitalization',
				'V01A' => 'V01A - Out-PatientTreatment',
				'V01B' => 'V01B - MedicalAppliances',
				'V02A' => 'V02A - Medical Services',
				'V02AE' => 'V02A - EmergencyVisit',
				'V02AO' => 'V02A - Others',
				'V02AS' => 'V02A - SpecialistVisit',
				'V02B' => 'V02B - DiagnoisticServices',
				'V02BB' => 'V02B - BloodTest',
				'V02BC' => 'V02B - CTScans',
				'V02BM' => 'V02B - MRI',
				'V02BO' => 'V02B - Others',
				'V02BT' => 'V02B - Ultrasound',
				'V02BU' => 'V02B - UrineTest',
				'V02BX' => 'V02B - X-Ray',
				'V02C' => 'V02A - ParamedicalServices',
				'V02D' => 'V02D - Acupuncture',
				'V02E' => 'V02E - Osteopath',
				'V02F' => 'V02F - Physiotherapy',
				'V02G' => 'V02G - Chiropractor',
				'V02H' => 'V02H - Chiropodist',
				'V02J' => 'V02J - Podiatrist',
				'V04A' => 'V04A - Ambulance',
				'V06' => 'V06 - AccidentalDental',
				'V06B' => 'V06B - ReliefofDentalPain',
				'V07' => 'V07 - PrescriptionDrugs',
				'V08A' => 'V08A - ReturnofRemains',
				'V08B' => 'V08B - Cremation/Burial',
				'V0JF1' => 'V0JF1 - Trip interruption',
				'V0JF2' => 'V0JF2 - Trip cancellation',
				'V0JF3' => 'V0JF3 - Meal',
				'V0JF4' => 'V0JF4 - Hotel',
				'V0JF5' => 'V0JF5 - Transportation',
				'V0JF6' => 'V0JF6 - Internet',
				'V0JF7' => 'V0JF7 - Phone',
				'V0JF8' => 'V0JF8 - Baggage lost',
				'V0JF9' => 'V0JF9 - Baggage damaged',
				'V0JFA' => 'V0JFA - Air ticket',
				'V12' => 'V12 - AirFlightAccident',
				'V13' => 'V13 - PrivateDutyNursing',
		);
	}
	
	public function get_coverage_code2() {
		return array(
				'V01' => 'Hospitalization',
				'V01A' => 'Out-PatientTreatment',
				'V01B' => 'MedicalAppliances',
				'V02A' => 'Medical Services',
				'V02AE' => 'EmergencyVisit',
				'V02AO' => 'Others',
				'V02AS' => 'SpecialistVisit',
				'V02B' => 'DiagnoisticServices',
				'V02BB' => 'BloodTest',
				'V02BC' => 'CTScans',
				'V02BM' => 'MRI',
				'V02BO' => 'Others',
				'V02BT' => 'Ultrasound',
				'V02BU' => 'UrineTest',
				'V02BX' => 'X-Ray',
				'V02C' => 'ParamedicalServices',
				'V02D' => 'Acupuncture',
				'V02E' => 'Osteopath',
				'V02F' => 'Physiotherapy',
				'V02G' => 'Chiropractor',
				'V02H' => 'Chiropodist',
				'V02J' => 'Podiatrist',
				'V04A' => 'Ambulance',
				'V06' => 'AccidentalDental',
				'V06B' => 'ReliefofDentalPain',
				'V07' => 'PrescriptionDrugs',
				'V08A' => 'ReturnofRemains',
				'V08B' => 'Cremation/Burial',
				'V0JF1' => 'Trip interruption',
				'V0JF2' => 'Trip cancellation',
				'V0JF3' => 'Meal',
				'V0JF4' => 'Hotel',
				'V0JF5' => 'Transportation',
				'V0JF6' => 'Internet',
				'V0JF7' => 'Phone',
				'V0JF8' => 'Baggage lost',
				'V0JF9' => 'Baggage damaged',
				'V0JFA' => 'Air ticket',
				'V12' => 'AirFlightAccident',
				'V13' => 'PrivateDutyNursing',
		);
	}
	
	/**
	 * 
	 */
	public function get_currencies() {
		$this->db->where('active', 1);
		$this->db->order_by('orderby', 'ASC');
		return $this->db->get('currency')->result_array();
	}

	public function get_currency_exchange($amount, $currency, $dt) {
		//$this->db->reset_query();
		$this->db->where('name', $currency);
		$this->db->where('dt', $dt);
		if ($rc = $this->db->get('currency_exchange')->row_array()) {
			return ($amount * $rc['rate']);
		}
		$this->db->where('name', $currency);
		$this->db->order_by('dt', 'DESC');
		$this->db->limit(1);
		if ($rc = $this->db->get('currency_exchange')->row_array()) {
			return ($amount * $rc['rate']);
		}
		return $amount;
	}
	/**
	 * 
	 */
	public function get_status($nopaid=FALSE) {
		$rt =  array(
				'Received' => self::EXPENSE_STATUS_Received,
				'Pending' => self::EXPENSE_STATUS_Pending,
				'Approved' => self::EXPENSE_STATUS_Approved,
				'Declined' => self::EXPENSE_STATUS_Declined,
				'Duplicated' => self::EXPENSE_STATUS_Duplicated,
				'Paid' => self::EXPENSE_STATUS_Paid,
		);
		if ($nopaid) {
			unset($rt['Paid']);
		}
		return $rt;
	}

	/**
	 * Return a Expenses Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('expenses_claimed')->row_array();
	}

	/**
	 * Return a list of Claim
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function report($data, $limit=0, $offset=0) {
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->where($data);
		if (empty($data['status'])) {
			$this->db->where_in('status', array(self::EXPENSE_STATUS_Approved, self::EXPENSE_STATUS_Paid));
		}
		if ($offset) {
			$this->db->limit($limit, $offset);
		} else if ($limit) {
			$this->db->limit($limit);
		}
		return $this->db->get('expenses_claimed')->result_array();
	}

	/**
	 * Return a list of Claim
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data, $limit=0, $offset=0, $orderby=array()) {
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->where($data);
		if ($orderby) {
			foreach ($orderby as $key => $val) {
				$this->db->order_by($key, $val);
			}
		}
		if ($offset) {
			$this->db->limit($limit, $offset);
		} else if ($limit) {
			$this->db->limit($limit);
		}
		return $this->db->get('expenses_claimed')->result_array();
	}
	
	public function search2($data, $limit=0, $offset=0, $orderby=array()) {
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->where($data);
		if (empty($data['status'])) {
			$this->db->where_in('status', array(self::EXPENSE_STATUS_Approved, self::EXPENSE_STATUS_Paid));
		}
		if ($orderby) {
			foreach ($orderby as $key => $val) {
				$this->db->order_by($key, $val);
			}
		}
		if ($offset) {
			$this->db->limit($limit, $offset);
		} else if ($limit) {
			$this->db->limit($limit);
		}
		return $this->db->get('expenses_claimed')->result_array();
	}
	
	public function payment_search($data, $limit=0, $offset=0, $orderby=array()) {
		$sql  = "SELECT SQL_CALC_FOUND_ROWS e.*,c.product_short,c.policy_no,c.insured_first_name,c.insured_last_name FROM expenses_claimed e ";
			
		$sql .= " JOIN claim c ON (e.claim_id= c.id)";
		
		if (!empty($data['status'])) {
			$sql .= " WHERE e.status=" . $this->db->escape($data['status']);;
		} else {
			$sql .= " WHERE e.status=" . $this->db->escape(Expenses_model::EXPENSE_STATUS_Approved);
		}
		
		if (!empty($data['created_to'])) {
			$sql .= " AND e.created <= " . $this->db->escape($data['created_to']." 23:59:59");
		}
		
		if (!empty($data['id'])) {
			$sql .= " AND e.id = '" . (int)$data['id'] . "'";
		}
		if (!empty($data['claim_id'])) {
			$sql .= " AND e.claim_id = '" . (int)$data['claim_id'] . "'";
		}
		if (!empty($data['created_by'])) {
			$sql .= " AND e.created_by = '" . (int)$data['created_by'] . "'";
		}
		if (!empty($data['claim_no'])) {
			$sql .= " AND e.claim_no = " . $this->db->escape($data['claim_no']);
		}
		if (!empty($data['claim_item_no'])) {
			$sql .= " AND e.claim_item_no = " . $this->db->escape($data['claim_item_no']);
		}
		if (!empty($data['case_no'])) {
			$sql .= " AND e.case_no = " . $this->db->escape($data['case_no']);
		}
		if (!empty($data['claim_date'])) {
			$sql .= " AND e.claim_date = " . $this->db->escape($data['claim_date']);
		}
		if (!empty($data['cellular'])) {
			$sql .= " AND e.cellular = " . $this->db->escape($data['cellular']);
		}
		if (!empty($data['invoice'])) {
			$sql .= " AND e.invoice = " . $this->db->escape($data['invoice']);
		}
		if (!empty($data['referencing_physician'])) {
			$sql .= " AND e.referencing_physician = " . $this->db->escape($data['referencing_physician']);
		}
		if (!empty($data['coverage_code'])) {
			$sql .= " AND e.coverage_code = " . $this->db->escape($data['coverage_code']);
		}
		if (!empty($data['date_of_service'])) {
			$sql .= " AND e.date_of_service = " . $this->db->escape($data['date_of_service']);
		}
		if (!empty($data['pay_to'])) {
			$sql .= " AND e.pay_to = " . $this->db->escape($data['pay_to']);
		}
		if (!empty($data['pay_date'])) {
			$sql .= " AND e.pay_date = " . $this->db->escape($data['pay_date']);
		}
		if (!empty($data['finalize_date'])) {
			$sql .= " AND e.finalize_date = " . $this->db->escape($data['finalize_date']);
		}
		if (!empty($data['updated_by'])) {
			$sql .= " AND e.updated_by = '" . (int)$data['updated_by'] . "'";
		}
		
		if (!empty($data['last_update_from'])) {
			$sql .= " AND e.last_update >= " . $this->db->escape($data['last_update_from']);
		}
		if (!empty($data['last_update_to'])) {
			$sql .= " AND e.last_update <= " . $this->db->escape($data['last_update_to']." 23:59:59");
		}
		if (!empty($data['claim_no'])) {
			$sql .= " AND e.claim_no = " . $this->db->escape($data['claim_no']);
		}
		if (!empty($data['product_short'])) {
			$sql .= " AND c.product_short = " . $this->db->escape($data['product_short']);
		}
		if (!empty($data['created_from'])) {
			$sql .= " AND e.created >= " . $this->db->escape($data['created_from']);
		}
		if (!empty($data['created_to'])) {
			$sql .= " AND e.created <= " . $this->db->escape($data['created_to']." 23:59:59");
		}
		
		if ($orderby) {
			$sql .= " ORDER BY";
			foreach ($orderby as $key => $val) {
				$sql .= " " . $key . " " . $val . ",";
			}
			$sql = substr($sql, 0, -1);
		}
		if ($offset) {
			$sql .= " LIMIT " . $offset . ", " . $limit;
		} else if ($limit) {
			$sql .= " LIMIT " . $limit;
		}
		return $this->db->query($sql)->result_array();
	}

	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as rows")->row()->rows;
	}
	
	/**
	 * Return a list of Expenses
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function summary($data) {
		if (empty($data['start_dt']) || empty($data['end_dt'])) {
			return array();
		}
		$s_tm = strtotime($data['start_dt']);
		$e_tm = strtotime($data['end_dt']);
		if ($s_tm > $e_tm) {
			return array();
		}

		$this->load->model('api_model');
		$policy_sum = $this->api_model->get_policy_month_summary($data);
		if (empty($policy_sum)) {
			return array();
		}
		
		$st = new DateTime($data['start_dt']);
		$et = new DateTime($data['end_dt']);
		$interval = new DateInterval('P1M');
		
		$ststr = $st->format("Y-m-01 00:00:00");
		$edstr = $et->format("Y-m-t 23:59:59");
		
		if (empty($policy_sum['policies'])) {	
			$expensessql = "SELECT LEFT(date_of_service, 7) as m, SUM(amount_claimed) as billed, SUM(amt_payable) as paid, SUM(IF(DATEDIFF(NOW(),last_update)>30,0,recovery_amt)) as recovery FROM expenses_claimed WHERE status='".self::EXPENSE_STATUS_Paid."' AND date_of_service>='".$ststr."' AND date_of_service<='".$edstr."' GROUP BY m";
		} else {
			$policy_str = '';
			foreach ($policy_sum['policies'] as $policy) {
				$policy_str .= $this->db->escape($policy) . ",";
			}
			$expensessql  = "SELECT LEFT(e.date_of_service, 7) as m, SUM(e.amount_claimed) as billed, SUM(e.amt_payable) as paid, SUM(IF(DATEDIFF(NOW(),e.last_update)>30,0,e.recovery_amt)) as recovery FROM expenses_claimed e";
			if ($policy_str) {
				$policy_str = substr($policy_str, 0, -1);
				$expensessql .= " LEFT JOIN claim c ON (e.claim_id=c.id AND c.policy_no IN (".$policy_str."))";
			}
			$expensessql .= " WHERE e.status='".self::EXPENSE_STATUS_Paid."' AND e.date_of_service>='".$ststr."' AND e.date_of_service<='".$edstr."' GROUP BY m";
		}
		$rt = array();
		
		while ($st <= $et) {
			$monthstr = $st->format("Y-m");
			$st->add($interval);

			$rt[$monthstr] = array('writen' => 0, 'earned' => 0, 'billed' => 0, 'paid' => 0, 'recovery' => 0);

			if (isset($policy_sum['summary'][$monthstr])) {
				$rt[$monthstr]['writen'] = $policy_sum['summary'][$monthstr]['writen'];
				$rt[$monthstr]['earned'] = $policy_sum['summary'][$monthstr]['earned'];
			}
		}
		
		$expenses = $this->db->query($expensessql)->result_array();
		foreach ($expenses as $rc) {
			$rt[$rc['m']]['billed'] = $rc['billed'];
			$rt[$rc['m']]['paid'] = $rc['paid'];
			$rt[$rc['m']]['recovery'] = $rc['recovery'];
		}
		return $rt;
	}
	
	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['status']) && ($data['status'] === self::EXPENSE_STATUS_Paid)) {
			$data['pay_date'] = date("Y-m-d");
		}
		if (empty($data['status'])) {
			$data['status'] = self::EXPENSE_STATUS_Received;
		}
		if (isset($data['currency']) && empty($data['currency'])) {
			$data['currency'] = "CAD";
		}
		if (!empty($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$cur = $this->get_by_id($id);
			if ($cur && ($cur['status'] != self::EXPENSE_STATUS_Paid)) {
				if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
					// No change if not account
					if (isset($data['status']) && ($data['status'] === self::EXPENSE_STATUS_Paid)) {
						return 0;
					}
				}
				if (empty($data['status'])) {
					if (empty($cur['status'])) {
						$data['status'] = self::EXPENSE_STATUS_Received;
					} else {
						$data['status'] = $cur['status'];
					}
				}
				if (($cur['status'] != $data['status']) && ($cur['status'] != self::EXPENSE_STATUS_Paid)) {
					$data['finalize_date'] = date("Y-m-d");
				} else {
					unset($data['finalize_date']);
				}
				$this->db->where('id', $id);
				$this->db->update('expenses_claimed', $data);
				$this->active_model->log_update('expenses_claimed', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			if (empty($data['third_party_payee'])) {
				$data['third_party_payee'] = 0;
			}
			if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) {
				// No change if not account
				if (isset($data['status']) && ($data['status'] === self::EXPENSE_STATUS_Paid)) {
					return 0;
				}
			}
			// insert
			$data['created_by'] = $this->ion_auth->get_user_id();
			$data['finalize_date'] = date("Y-m-d");
			if (empty($data['created_by'])) $data['created_by'] = 0;
			$this->db->insert('expenses_claimed', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('expenses_claimed', $id, $data, $sql);
			return $id;
		}
	}

	public function expenses_history($claim_id) { // Stupid function !!!!!
		$this->db->select(array('claim_no','case_no','claim_date','currency','pay_to'));
		$this->db->select_sum('amount_claimed', 'amount_claimed');
		$this->db->select_sum('amount_client_paid', 'amount_client_paid');
		$this->db->where('claim_id', $claim_id);
		$this->db->group_by('id');
		return $this->db->get('expenses_claimed')->row_array();
	}
	
	/**
	 * Return a summary of a Claim
	 *
	 * @param int $claim_id
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function expenses_summary($claim_id) {
		$this->db->select_sum('amount_billed', 'billed');
		$this->db->select_sum('amount_client_paid', 'client_paid');
		$this->db->select_sum('amount_claimed', 'claimed');
		$this->db->select_sum('amt_deductible', 'deductible');
		$this->db->select_sum('amt_received', 'received');
		$this->db->select_sum('amt_payable', 'payable');
		$this->db->select_sum('amt_exceptional', 'exceptional');
		$this->db->where('claim_id', $claim_id);
		return $this->db->get('expenses_claimed')->row_array();
	}
	
	public function get_policy_payinfo($policy_no) {
		$sql  = "SELECT sum(e.amt_payable) as payable, sum(e.amt_deductible) as deductible FROM claim c";
		$sql .= " JOIN expenses_claimed e ON (e.claim_id=c.id)";
		$sql .= " WHERE c.policy_no=".$this->db->escape($policy_no)." AND e.status IN ('".self::EXPENSE_STATUS_Approved."','".self::EXPENSE_STATUS_Paid."')";
		return $this->db->query($sql)->row_array();
	}
	
	public function make_pay($item_id, $update_claim_status=TRUE) {
		$this->load->model('claim_model');
		$item = $this->expenses_model->get_by_id($item_id);
		if ($item && $item['status'] == Expenses_model::EXPENSE_STATUS_Approved) {
			$para = array('id' => $item_id, 'status' => self::EXPENSE_STATUS_Paid);
			$this->save($para);
			if ($update_claim_status) {
				$sdata = array('claim_id' => $item['claim_id'], 'status' => self::EXPENSE_STATUS_Approved);
				$appr = $this->search($sdata);
				if (empty($appr)) {
					$sdata = array('claim_id' => $item['claim_id'], 'status' => self::EXPENSE_STATUS_Pending);
					$pend = $this->search($sdata);
					if (empty($sdata)) {
						$sdata = array('id' => $item['claim_id'], 'status' => Claim_model::STATUS_Paid);
						$this->claim_model->save($data);
					}
				}
			}
		}
	}
	
	public function get_report($data, $nozero='', $monthly=TRUE) {
		$this->load->model('claim_model');
		
		if (empty($data['start_dt']) || empty($data['end_dt'])) {
			return array();
		}
		$s_tm = strtotime($data['start_dt']);
		$e_tm = strtotime($data['end_dt']);
		if ($s_tm > $e_tm) {
			return array();
		}

		$st = new DateTime($data['start_dt']);
		$et = new DateTime($data['end_dt']);
		$interval = new DateInterval('P1M');
		
		if ($monthly) {
			$ststr = $st->format("Y-m-01 00:00:00");
			$edstr = $et->format("Y-m-t 23:59:59");
		} else {
			$ststr = $st->format("Y-m-d 00:00:00");
			$edstr = $et->format("Y-m-d 23:59:59");
		}

		$dtcolumn = "e.date_of_service";
		if (isset($data['claim_date_type'])) {
			if ($data['claim_date_type'] == 'e.created') {
				$dtcolumn = "e.created";
			} else if ($data['claim_date_type'] == 'e.finalize_date') {
				$dtcolumn = "e.finalize_date";
			}
		}
		
		$sql  = "SELECT e.claim_no, e.invoice, e.provider_name, c.diagnosis, c.insured_first_name as first_name, c.insured_last_name as last_name, c.dob as birth_day, c.gender, c.policy_no, e.date_of_service, c.totaldays, e.finalize_date, IF(e.status='".self::EXPENSE_STATUS_Paid."','F',( IF(e.status='".self::EXPENSE_STATUS_Declined."' OR e.status='".self::EXPENSE_STATUS_Duplicated."', 'D', 'P') )) as status, c.status2, IF(e.reason='Other',e.reason_other,e.reason) AS reason, e.created, e.amount_claimed, e.amt_payable, 0 as reserve_amount, e.recovery_amt, c.street_address, c.city, c.province, c.post_code, c.agent_id, e.service_description, e.coverage_code, e.amt_deductible, e.pay_to  FROM expenses_claimed e";
		$sql .= " RIGHT JOIN claim c ON (e.claim_id=c.id)";
		$sql .= " WHERE " . $dtcolumn . ">='".$ststr."' AND " . $dtcolumn . "<='".$edstr."' AND e.status!='".self::EXPENSE_STATUS_Duplicated."'";
		if (!empty($data['status'])) {
			$sql .= " AND c.status=".$this->db->escape($data['status']);
		}
		if (!empty($data['product_short'])) {
			$sql .= " AND c.product_short=".$this->db->escape($data['product_short']);
		}
		if (!empty($data['agent_id'])) {
			$sql .= " AND c.agent_id='". (int)$data['agent_id']."'";
		}
		if (!empty($nozero)) {
			$sql .= " AND " . $nozero . "!='0'";
		}
		$sql .= " ORDER BY e.claim_no";
		return $this->db->query($sql)->result_array();
	}
	
	public function expense_report($para) {
		$where = array();
		if (!empty($para['status_group'])) {
			if ($para['status_group'] == 'Paid') {
				$where[] = "expenses_claimed.status IN ('Paid', 'Declined')";
			} else if ($para['status_group'] == 'Unpaid') {
				$where[] = "expenses_claimed.status IN ('Received', 'Approved', 'Pending')";
			}
		}
		if (!empty($para['start_dt'])) {
			$where[] = "expenses_claimed.finalize_date >= " . $this->db->escape($para['start_dt']);
		}
		if (!empty($para['end_dt'])) {
			$where[] = "expenses_claimed.finalize_date <= " . $this->db->escape($para['end_dt']);
		}
		$sql  = "SELECT expenses_claimed.* FROM expenses_claimed";
		
		if (!empty($para['product_short'])) {
			$sql .= " JOIN claim ON (expenses_claimed.claim_id=claim.id AND claim.product_short=" . $this->db->escape($para['product_short']) . ")";
		}
		if ($where) {
			$sql .= " WHERE " . join(" AND ", $where);
		}
		$rt = $this->db->query($sql)->result_array();
		
		if ($rt) {
			$this->load->model('api_model');
			$last_policy = '';
			$last_payment_tm = '';
			foreach ($rt as $key => $val) {
				if ($val['provider_type'] == 1) { // Business
					$rt[$key]['provider'] = $this->db->query("SELECT * FROM provider WHERE id='".(int)$val['expenses_provider_id']."'")->row_array();
				} else {
					$rt[$key]['provider'] = $this->db->query("SELECT * FROM expenses_provider WHERE id='".(int)$val['expenses_provider_id']."'")->row_array();
				}
				if ($val['status'] != self::EXPENSE_STATUS_Declined) {
					$rt[$key]['payeearr'] = $this->db->query("SELECT * FROM payees WHERE id='".(int)$val['payee']."'")->row_array();
				} else {
					$rt[$key]['payeearr'] = array();
				}
				$rt[$key]['claim'] = $this->db->query("SELECT * FROM claim WHERE id='".(int)$val['claim_id']."'")->row_array();
				if ($last_policy != $rt[$key]['claim']['policy_no']) {
					$policy = $this->api_model->get_policy(array('policy' => $rt[$key]['claim']['policy_no']));
					if ($policy) {
						$last_policy = $rt[$key]['claim']['policy_no'];
						$last_payment_tm = $policy[0]['payment_tm'];
					}
				}
				$rt[$key]['payment_tm'] = $last_payment_tm;
			}
		}
		return $rt;
	}
	
	public function expense_sum_report($firstname, $lastname, $dob) {
		$sql = "SELECT case_no, policy_no, CONCAT(street_no, ' ', street_name, ' ', city, ', ', province, ' ', country, ' ', post_code) as address, SUM(reserve_amount) as amount FROM `case` WHERE LOWER(insured_firstname)=".$this->db->escape($firstname)." AND LOWER(insured_lastname)=".$this->db->escape($lastname)." AND dob=".$this->db->escape($dob)." AND claim_no=''";
		$rt = $this->db->query($sql)->result_array();
		return $rt;
	}
}
