<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Reasons_model extends CI_Model {
	/**
	 * Get country list
	 * 
	 * @param int $flag		list condition
	 * @return array result array, maybe null
	 */
	public function get_list() {
		$this->db->order_by('name');
		$rt = $this->db->get('reasons')->result_array();
		$rArr = array();
		foreach ($rt as $rc) {
			$rArr[$rc['id']] = $rc['name'];
		}
		return $rArr;
	}

	public function get_list2() {
		$this->db->order_by('name');
		$rt = $this->db->get('reason2s')->result_array();
		$rArr = array();
		foreach ($rt as $rc) {
			$rArr[$rc['id']] = $rc['name'];
		}
		return $rArr;
	}

	/**
	 * Get country id
	 * 
	 * @param int $short_code		short_code
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where('id', $id);
		$rt = $this->db->get('reasons')->row_array();
		return $rt;
	}
	
	public function get_reason_french($engstr) {
		$covertArr = array(
      "Documentation’s fee is not covered by this policy" => "Les frais de documentation ne sont pas couverts par cette police",
      "Maximum of 30 days’ supply per prescription" => "Maximum de 30 jours d’approvisionnement par ordonnance",
      "No official invoice/receipt provided" => "Aucune facture ni aucun reçu officiel fourni",
      "No original document provided" => "Aucun document original fourni",
      "Not a benefit of this policy" => "Ce service n’est pas couvert par cette police",
      "Not considered an emergency" => "Non considéré comme une urgence",
      "Ongoing care is not covered by this policy" => "Les soins continus ne sont pas couverts par cette police",
      "Other" => "Autre",
      "Symptoms did not appear within policy coverage dates" => "Les symptômes ne sont pas apparus pendant la période de couverture de la police",
      "This dental procedure is not covered by this policy" => "Cette intervention dentaire n’est pas couverte par cette police",
      "Treatment not sought within policy coverage dates" => "Le traitement n’a pas été demandé pendant la période de couverture de la police",
      "Unstable pre-existing condition" => "Affection préexistante instable"
    );
    if (key_exists($engstr, $covertArr)) {
      return $covertArr[$engstr];
    }
    return $engstr;
	}
}