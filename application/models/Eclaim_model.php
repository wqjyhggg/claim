<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Eclaim_model extends CI_Model {
	/**
	 * Return a Claim Record
	 *
	 * @param int $id
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get('eclaim')->row_array();
	}

	/**
	 * Return a list of Claim
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data, $count=-1, $limit=-1, $sortby=array()) {

		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->where("status ", isset($data["status"])?$data["status"]:0);
		if (!empty($data["eclaim_id"])) {
			$this->db->like("id", $data["eclaim_id"]);
		}
		if (!empty($data["policy_no"])) {
			$this->db->where("policy_no", $data["policy_no"]);
		}
		if (!empty($data["created_from"])) {
			$this->db->where("created_from >=", $data["created_from"] . " 00:00:00");
		}
		if (!empty($data["created_to"])) {
			$this->db->where("created_to <=", $data["created_to"] . " 23:59:59");
		}
		if (!empty($data["processed_by"])) {
			$this->db->where("processed_by", $data["processed_by"]);
		}
		if (!empty($data["insured_first_name"])) {
			$this->db->like("insured_first_name", $data["insured_first_name"]);
		}
		if (!empty($data["insured_last_name"])) {
			$this->db->like("insured_last_name", $data["insured_last_name"]);
		}

		if (empty($sortby)) {
			if (isset($data["status"]) && ($data["status"]==1)) {
				$this->db->order_by('id', 'DESC');
			} else {
				$this->db->order_by('id', 'ASC');
			}
		} else {
			foreach ($sortby as $key => $val) {
				$this->db->order_by($key, $val);
			}
		}
		if ($count >= 0) {
			if ($limit < 0) {
				$this->db->limit($count);
			} else {
				$this->db->limit($count, $limit);
			}
		}
		return $this->db->get('eclaim')->result_array();
	}

	public function last_rows() {
		return $this->db->query("SELECT FOUND_ROWS() as linenumber")->row()->linenumber;
	}
	
	/**
	 * Save or Update a Claim
	 *
	 * @param array $para     	parameter
	 * @return int				inserted array ID
	 */
	public function save($post) {
		$data = array();
        if (!empty($post['imgfile'])) {
            //$data['imgfile'] = json_encode($post['imgfile']);
            $data['imgfile'] = $post['imgfile'];
        }
        if (!empty($post['expenses_claimed_service_description'])) {
            //$data['expenses_claimed_service_description'] = json_encode($post['expenses_claimed_service_description']);
            $data['expenses_claimed_service_description'] = $post['expenses_claimed_service_description'];
        }
        if (!empty($post['expenses_claimed_provider_name'])) {
            //$data['expenses_claimed_provider_name'] = json_encode($post['expenses_claimed_provider_name']);
            $data['expenses_claimed_provider_name'] = $post['expenses_claimed_provider_name'];
        }
        if (!empty($post['expenses_claimed_referencing_physician'])) {
            //$data['expenses_claimed_referencing_physician'] = json_encode($post['expenses_claimed_referencing_physician']);
            $data['expenses_claimed_referencing_physician'] = $post['expenses_claimed_referencing_physician'];
        }
        if (!empty($post['expenses_claimed_date_of_service'])) {
            //$data['expenses_claimed_date_of_service'] = json_encode($post['expenses_claimed_date_of_service']);
            $data['expenses_claimed_date_of_service'] = $post['expenses_claimed_date_of_service'];
        }
        if (!empty($post['expenses_claimed_amount_client_paid_org'])) {
            //$data['expenses_claimed_amount_client_paid_org'] = json_encode($post['expenses_claimed_amount_client_paid_org']);
            $data['expenses_claimed_amount_client_paid_org'] = $post['expenses_claimed_amount_client_paid_org'];
        }
        if (!empty($post['expenses_claimed_amount_claimed_org'])) {
            //$data['expenses_claimed_amount_claimed_org'] = json_encode($post['expenses_claimed_amount_claimed_org']);
            $data['expenses_claimed_amount_claimed_org'] = $post['expenses_claimed_amount_claimed_org'];
        }
        if (!empty($post['eclaim_no'])) {
            $data['eclaim_no'] = $post['eclaim_no'];
        }
        if (!empty($post['processed_by'])) {
            $data['processed_by'] = $post['processed_by'];
        }
        if (!empty($post['lastupdate'])) {
            $data['lastupdate'] = $post['lastupdate'];
        }
        if (!empty($post['created'])) {
            $data['created'] = $post['created'];
        }
        if (!empty($post['insured_first_name'])) {
            $data['insured_first_name'] = $post['insured_first_name'];
        }
        if (!empty($post['insured_last_name'])) {
            $data['insured_last_name'] = $post['insured_last_name'];
        }
        if (!empty($post['gender'])) {
            $data['gender'] = ($post['gender'] == 'F') ? "female" : "male";
        }
        if (!empty($post['dob'])) {
            $data['dob'] = $post['dob'];
        }
        if (!empty($post['policy_no'])) {
            $data['policy_no'] = $post['policy_no'];
        }
        if (!empty($post['product_short'])) {
            $data['product_short'] = $post['product_short'];
        }
        if (!empty($post['claim_no'])) {
            $data['claim_no'] = $post['claim_no'];
        }
        if (!empty($post['school_name'])) {
            $data['school_name'] = $post['school_name'];
        }
        if (!empty($post['group_id'])) {
            $data['group_id'] = $post['group_id'];
        }
        if (!empty($post['arrival_date'])) {
            $data['arrival_date'] = $post['arrival_date'];
        }
        if (!empty($post['guardian_name'])) {
            $data['guardian_name'] = $post['guardian_name'];
        }
        if (!empty($post['guardian_phone'])) {
            $data['guardian_phone'] = $post['guardian_phone'];
        }
        if (!empty($post['street_address'])) {
            $data['street_address'] = $post['street_address'];
        }
        if (!empty($post['city'])) {
            $data['city'] = $post['city'];
        }
        if (!empty($post['province'])) {
            $data['province'] = $post['province'];
        }
        if (!empty($post['telephone'])) {
            $data['telephone'] = $post['telephone'];
        }
        if (!empty($post['email'])) {
            $data['email'] = $post['email'];
        }
        if (!empty($post['post_code'])) {
            $data['post_code'] = $post['post_code'];
        }
        if (!empty($post['arrival_date_canada'])) {
            $data['arrival_date_canada'] = $post['arrival_date_canada'];
        }
        if (!empty($post['contact_first_name'])) {
            $data['contact_first_name'] = $post['contact_first_name'];
        }
        if (!empty($post['contact_last_name'])) {
            $data['contact_last_name'] = $post['contact_last_name'];
        }
        if (!empty($post['contact_email'])) {
            $data['contact_email'] = $post['contact_email'];
        }
        if (!empty($post['contact_phone'])) {
            $data['contact_phone'] = $post['contact_phone'];
        }
        if (!empty($post['cellular'])) {
            $data['cellular'] = $post['cellular'];
        }
        if (!empty($post['physician_name'])) {
            $data['physician_name'] = $post['physician_name'];
        }
        if (!empty($post['clinic_name'])) {
            $data['clinic_name'] = $post['clinic_name'];
        }
        if (!empty($post['physician_street_address'])) {
            $data['physician_street_address'] = $post['physician_street_address'];
        }
        if (!empty($post['physician_city'])) {
            $data['physician_city'] = $post['physician_city'];
        }
        if (!empty($post['physician_country'])) {
            $data['physician_country'] = $post['physician_country'];
        }
        if (!empty($post['country'])) {
            $data['country'] = $post['country'];
        }
        if (!empty($post['physician_post_code'])) {
            $data['physician_post_code'] = $post['physician_post_code'];
        }
        if (!empty($post['physician_telephone'])) {
            $data['physician_telephone'] = $post['physician_telephone'];
        }
        if (!empty($post['physician_alt_telephone'])) {
            $data['physician_alt_telephone'] = $post['physician_alt_telephone'];
        }
        if (!empty($post['physician_name_canada'])) {
            $data['physician_name_canada'] = $post['physician_name_canada'];
        }
        if (!empty($post['clinic_name_canada'])) {
            $data['clinic_name_canada'] = $post['clinic_name_canada'];
        }
        if (!empty($post['physician_street_address_canada'])) {
            $data['physician_street_address_canada'] = $post['physician_street_address_canada'];
        }
        if (!empty($post['physician_city_canada'])) {
            $data['physician_city_canada'] = $post['physician_city_canada'];
        }
        if (!empty($post['physician_post_code_canada'])) {
            $data['physician_post_code_canada'] = $post['physician_post_code_canada'];
        }
        if (!empty($post['physician_telephone_canada'])) {
            $data['physician_telephone_canada'] = $post['physician_telephone_canada'];
        }
        if (!empty($post['physician_alt_telephone_canada'])) {
            $data['physician_alt_telephone_canada'] = $post['physician_alt_telephone_canada'];
        }
        if (!empty($post['treatment_before'])) {
            $data['treatment_before'] = $post['treatment_before'];
        }
        if (!empty($post['travel_insurance_coverage_guardians'])) {
            $data['travel_insurance_coverage_guardians'] = $post['travel_insurance_coverage_guardians'];
        }
        if (!empty($post['other_insurance_coverage'])) {
            $data['other_insurance_coverage'] = $post['other_insurance_coverage'];
        }
        if (!empty($post['full_name'])) {
            $data['full_name'] = $post['full_name'];
        }
        if (!empty($post['employee_name'])) {
            $data['employee_name'] = $post['employee_name'];
        }
        if (!empty($post['employee_street_address'])) {
            $data['employee_street_address'] = $post['employee_street_address'];
        }
        if (!empty($post['employee_post_code'])) {
            $data['employee_post_code'] = $post['employee_post_code'];
        }
        if (!empty($post['city_town'])) {
            $data['city_town'] = $post['city_town'];
        }
        if (!empty($post['country2'])) {
            $data['country2'] = $post['country2'];
        }
        if (!empty($post['employee_telephone'])) {
            $data['employee_telephone'] = $post['employee_telephone'];
        }
        if (!empty($post['medical_description'])) {
            $data['medical_description'] = $post['medical_description'];
        }
        if (!empty($post['date_symptoms'])) {
            $data['date_symptoms'] = $post['date_symptoms'];
        }
        if (!empty($post['date_first_physician'])) {
            $data['date_first_physician'] = $post['date_first_physician'];
        }
        if (!empty($post['medication_date_1'])) {
            $data['medication_date_1'] = $post['medication_date_1'];
        }
        if (!empty($post['medication_1'])) {
            $data['medication_1'] = $post['medication_1'];
        }
        if (!empty($post['medication_date_2'])) {
            $data['medication_date_2'] = $post['medication_date_2'];
        }
        if (!empty($post['medication_2'])) {
            $data['medication_2'] = $post['medication_2'];
        }
        if (!empty($post['medication_date_3'])) {
            $data['medication_date_3'] = $post['medication_date_3'];
        }
        if (!empty($post['medication_3'])) {
            $data['medication_3'] = $post['medication_3'];
        }
        if (!empty($post['payment_type'])) {
            $data['payment_type'] = $post['payment_type'];
        }
        if (!empty($post['status'])) {
            $data['status'] = $post['status'];
        }
        if (!empty($post['reason'])) {
            $data['reason'] = $post['reason'];
        }
        if (!empty($post['notes'])) {
            $data['notes'] = $post['notes'];
        }
        if (!empty($post['diagnosis'])) {
            $data['diagnosis'] = $post['diagnosis'];
        }
        if (!empty($post['exinfo_type'])) {
            $data['exinfo_type'] = $post['exinfo_type'];
        }
        if (!empty($post['intnotes'])) {
            $data['intnotes'] = $post['intnotes'];
        }
        if (!empty($post['sign_name'])) {
            $data['sign_name'] = $post['sign_name'];
        }
        if (!empty($post['sign_image'])) {
            $data['sign_image'] = $post['sign_image'];
        }
        if (!empty($post['sign_image2'])) {
            $data['sign_image2'] = $post['sign_image2'];
        }
        if (!empty($post['payees_payment_type'])) {
            $data['payees_payment_type'] = $post['payees_payment_type'];
        }
        if (!empty($post['payees_payment_cheque_type'])) {
            $data['payees_payment_cheque_type'] = $post['payees_payment_cheque_type'];
        }
        if (!empty($post['payees_payee_name'])) {
            $data['payees_payee_name'] = $post['payees_payee_name'];
        }
        if (!empty($post['payees_address'])) {
            $data['payees_address'] = $post['payees_address'];
        }
        if (!empty($post['payees_city'])) {
            $data['payees_city'] = $post['payees_city'];
        }
        if (!empty($post['payees_province'])) {
            $data['payees_province'] = $post['payees_province'];
        }
        if (!empty($post['payees_country'])) {
            $data['payees_country'] = $post['payees_country'];
        }
        if (!empty($post['payees_postcode'])) {
            $data['payees_postcode'] = $post['payees_postcode'];
        }
        if (!empty($post['payees_email'])) {
            $data['payees_email'] = $post['payees_email'];
        }
        if (!empty($post['exinfo_depature_date'])) {
            $data['exinfo_depature_date'] = $post['exinfo_depature_date'];
        }
        if (!empty($post['exinfo_return_date'])) {
            $data['exinfo_return_date'] = $post['exinfo_return_date'];
        }
        if (!empty($post['exinfo_destination'])) {
            $data['exinfo_destination'] = $post['exinfo_destination'];
        }
        if (!empty($post['exinfo_other_medical_insurance'])) {
            $data['exinfo_other_medical_insurance'] = $post['exinfo_other_medical_insurance'];
        }
        if (!empty($post['exinfo_spouse_insurance'])) {
            $data['exinfo_spouse_insurance'] = $post['exinfo_spouse_insurance'];
        }
        if (!empty($post['exinfo_credit_card_insurance'])) {
            $data['exinfo_credit_card_insurance'] = $post['exinfo_credit_card_insurance'];
        }
        if (!empty($post['exinfo_group_insurance'])) {
            $data['exinfo_group_insurance'] = $post['exinfo_group_insurance'];
        }
        if (!empty($post['exinfo_other_insurance_name'])) {
            $data['exinfo_other_insurance_name'] = $post['exinfo_other_insurance_name'];
        }
        if (!empty($post['exinfo_other_insurance_policy'])) {
            $data['exinfo_other_insurance_policy'] = $post['exinfo_other_insurance_policy'];
        }
        if (!empty($post['exinfo_other_insurance_number'])) {
            $data['exinfo_other_insurance_number'] = $post['exinfo_other_insurance_number'];
        }
        if (!empty($post['exinfo_other_insurance_phone'])) {
            $data['exinfo_other_insurance_phone'] = $post['exinfo_other_insurance_phone'];
        }
        if (!empty($post['exinfo_spouse_insurance_name'])) {
            $data['exinfo_spouse_insurance_name'] = $post['exinfo_spouse_insurance_name'];
        }
        if (!empty($post['exinfo_spouse_insurance_policy'])) {
            $data['exinfo_spouse_insurance_policy'] = $post['exinfo_spouse_insurance_policy'];
        }
        if (!empty($post['exinfo_spouse_insurance_number'])) {
            $data['exinfo_spouse_insurance_number'] = $post['exinfo_spouse_insurance_number'];
        }
        if (!empty($post['exinfo_spouse_insurance_phone'])) {
            $data['exinfo_spouse_insurance_phone'] = $post['exinfo_spouse_insurance_phone'];
        }
        if (!empty($post['exinfo_spouse_name'])) {
            $data['exinfo_spouse_name'] = $post['exinfo_spouse_name'];
        }
        if (!empty($post['exinfo_spouse_dob'])) {
            $data['exinfo_spouse_dob'] = $post['exinfo_spouse_dob'];
        }
        if (!empty($post['exinfo_credit_card_insurance_name'])) {
            $data['exinfo_credit_card_insurance_name'] = $post['exinfo_credit_card_insurance_name'];
        }
        if (!empty($post['exinfo_credit_card_number'])) {
            $data['exinfo_credit_card_number'] = $post['exinfo_credit_card_number'];
        }
        if (!empty($post['exinfo_credit_card_expire'])) {
            $data['exinfo_credit_card_expire'] = $post['exinfo_credit_card_expire'];
        }
        if (!empty($post['exinfo_credit_card_holder'])) {
            $data['exinfo_credit_card_holder'] = $post['exinfo_credit_card_holder'];
        }
        if (!empty($post['exinfo_group_insurance_company'])) {
            $data['exinfo_group_insurance_company'] = $post['exinfo_group_insurance_company'];
        }
        if (!empty($post['exinfo_group_insurance_policy'])) {
            $data['exinfo_group_insurance_policy'] = $post['exinfo_group_insurance_policy'];
        }
        if (!empty($post['exinfo_group_insurance_member'])) {
            $data['exinfo_group_insurance_member'] = $post['exinfo_group_insurance_member'];
        }
        if (!empty($post['exinfo_group_insurance_phone'])) {
            $data['exinfo_group_insurance_phone'] = $post['exinfo_group_insurance_phone'];
        }
        if (!empty($post['exinfo_loss_type'])) {
            $data['exinfo_loss_type'] = $post['exinfo_loss_type'];
        }
        if (!empty($post['exinfo_loss_describe'])) {
            $data['exinfo_loss_describe'] = $post['exinfo_loss_describe'];
        }
        if (!empty($post['exinfo_loss_date'])) {
            $data['exinfo_loss_date'] = $post['exinfo_loss_date'];
        }
        if (!empty($post['exinfo_loss_report_to'])) {
            $data['exinfo_loss_report_to'] = $post['exinfo_loss_report_to'];
        }
        if (!empty($post['exinfo_loss_report_other'])) {
            $data['exinfo_loss_report_other'] = $post['exinfo_loss_report_other'];
        }
        if (!empty($post['exinfo_cancelled_date'])) {
            $data['exinfo_cancelled_date'] = $post['exinfo_cancelled_date'];
        }
        if (!empty($post['exinfo_loss_reason'])) {
            $data['exinfo_loss_reason'] = $post['exinfo_loss_reason'];
        }
        if (!empty($post['exinfo_sickness'])) {
            $data['exinfo_sickness'] = $post['exinfo_sickness'];
        }
        if (!empty($post['exinfo_injury1_date'])) {
            $data['exinfo_injury1_date'] = $post['exinfo_injury1_date'];
        }
        if (!empty($post['exinfo_physician_date'])) {
            $data['exinfo_physician_date'] = $post['exinfo_physician_date'];
        }
        if (!empty($post['exinfo_injury_details'])) {
            $data['exinfo_injury_details'] = $post['exinfo_injury_details'];
        }
        if (!empty($post['exinfo_injury_date'])) {
            $data['exinfo_injury_date'] = $post['exinfo_injury_date'];
        }
        if (!empty($post['exinfo_patient_name'])) {
            $data['exinfo_patient_name'] = $post['exinfo_patient_name'];
        }
        if (!empty($post['exinfo_death_date'])) {
            $data['exinfo_death_date'] = $post['exinfo_death_date'];
        }
        if (!empty($post['exinfo_relation'])) {
            $data['exinfo_relation'] = $post['exinfo_relation'];
        }
        if (!empty($post['exinfo_death_describe'])) {
            $data['exinfo_death_describe'] = $post['exinfo_death_describe'];
        }
        if (!empty($post['exinfo_circumstances'])) {
            $data['exinfo_circumstances'] = $post['exinfo_circumstances'];
        }
        if (!empty($post['exinfo_occured_date'])) {
            $data['exinfo_occured_date'] = $post['exinfo_occured_date'];
        }
		if (!empty($post['id'])) {
			$id = $post['id'];
			if ($cur = $this->get_by_id($id)) {
				// Update
				
				$this->db->where('id', $id);
				$this->db->update('eclaim', $data);
				$this->active_model->log_update('eclaim', $id, $cur, $data, $this->db->last_query());
				return $id;
			}
		}

		$this->db->insert('eclaim', $data);
		$sql = $this->db->last_query();
		$id = $this->db->insert_id();
		$this->active_model->log_new('eclaim', $id, $data, $sql);
	        $rfrid = $id;

		if ($id) {
		    $rfrid = "RFR".str_pad($id, 6, "0", STR_PAD_LEFT);
		    $this->db->where('id', $id);
		    $this->db->update('eclaim', array('eclaim_no' => $rfrid));
		}
		if ($id && !empty($post['imgfile'])) {
		    $imgfile = json_decode($post['imgfile'], TRUE);
		    foreach ($imgfile as $fid) {
		        $this->db->where('id', $fid);
		        $this->db->update('eclaim_file', array('eclaim_id' => $id));
		    }
		    if (!empty($post['sign_image'])) {
		        $this->db->where('id', $post['sign_image']);
		        $this->db->update('eclaim_file', array('eclaim_id' => $id));
		    }
		    if (!empty($post['sign_image2'])) {
		        $this->db->where('id', $post['sign_image2']);
		        $this->db->update('eclaim_file', array('eclaim_id' => $id));
		    }
		}
		return $rfrid;
	}
}
