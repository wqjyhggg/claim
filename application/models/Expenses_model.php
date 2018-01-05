<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Expenses_model extends CI_Model {
	const EXPENSE_STATUS_Pending='Pending';
	const EXPENSE_STATUS_Approved='Approved';
	const EXPENSE_STATUS_Declined='Declined';
	const EXPENSE_STATUS_Paid='Paid';
	
	/**
	 * 
	 */
	public function get_coverage_code() {
		return array(
				'V01B' => 'V01B - MedicalAppliances',
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
				'V12' => 'V12 - AirFlightAccident',
				'V13' => 'V13 - PrivateDutyNursing',
				'V01' => 'V01 - Hospitalization',
				'V02A' => 'V02A - Medical Services',
				'V01A' => 'V01A - Out-PatientTreatment',
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
				'Pending' => self::EXPENSE_STATUS_Pending,
				'Approved' => self::EXPENSE_STATUS_Approved,
				'Declined' => self::EXPENSE_STATUS_Declined,
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
		if (isset($data['currency']) && empty($data['currency'])) {
			$data['currency'] = "CAD";
		}
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			$cur = $this->get_by_id($id);
			if ($cur && ($cur['status'] != self::EXPENSE_STATUS_Paid)) {
				if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT)) && ($data['status'] == self::EXPENSE_STATUS_Paid)) {
					// No change if not account
					return 0;
				}
				$this->db->where('id', $id);
				$this->db->update('expenses_claimed', $data);
				$this->active_model->log_update('expenses_claimed', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
			return 0;
		} else {
			if (! $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT)) && ($data['status'] == self::EXPENSE_STATUS_Paid)) {
				// No change if not account
				return 0;
			}
			// insert
			$data['created_by'] = $this->ion_auth->get_user_id();
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
	
	public function get_report($data) {
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
		
		$ststr = $st->format("Y-m-01 00:00:00");
		$edstr = $et->format("Y-m-t 23:59:59");
		
		$sql  = "SELECT e.claim_no, e.invoice, e.provider_name, c.insured_first_name as first_name, c.insured_last_name as last_name, c.policy_no, e.date_of_service, c.totaldays, e.pay_date, IF(e.status='".self::EXPENSE_STATUS_Paid."','F','P') as status, e.created, e.amount_billed, e.amt_payable, e.amount_billed as reserve_amount, e.recovery_amt FROM expenses_claimed e";
		$sql .= " RIGHT JOIN claim c ON (e.claim_id=c.id)";
		$sql .= " WHERE e.status != '".self::EXPENSE_STATUS_Declined."' AND e.date_of_service>='".$ststr."' AND e.date_of_service<='".$edstr."'";
		if (!empty($data['status'])) {
			$sql .= " AND c.status=".$this->db->escape($data['status']);
		}
		if (!empty($data['product_short'])) {
			$sql .= " AND c.product_short=".$this->db->escape($data['product_short']);
		}
		if (!empty($data['agent_id'])) {
			$sql .= " AND c.agent_id='". (int)$data['agent_id']."'";
		}
		$sql .= " ORDER BY e.claim_no";
		
		return $this->db->query($sql)->result_array();
	}
}