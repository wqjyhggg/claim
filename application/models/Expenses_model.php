<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Expenses_model extends CI_Model {
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
	 * Return a Expenses Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_expenses_by_id($id) {
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
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('expenses_claimed')->result_array();
	}

	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($data) {
		if (isset($data['id'])) {
			// Update
			$id = $data['id'];
			unset($data['id']);
			
			$this->db->where('id', $id);
			$this->db->update('expenses_claimed', $data);
			return $id;
		} else {
			// insert
			$this->db->insert('expenses_claimed', $data);
			return $this->db->insert_id();
		}
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
		$this->db->select_sum('amt_deductable', 'deductable');
		$this->db->select_sum('amt_received', 'received');
		$this->db->select_sum('amt_payable', 'payable');
		$this->db->select_sum('amt_exempt', 'exempt');
		$this->db->where('claim_id', $claim_id);
		return $this->db->get('expenses_claimed')->row_array();
	}
}