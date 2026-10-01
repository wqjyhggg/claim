<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Reasons_model extends CI_Model {
  public $reasonArr = [
    1 => 'Documentation’s fee is not covered by this policy',
    2 => 'Maximum of 30 days’ supply per prescription',
    3 => 'No official invoice/receipt provided',
    4 => 'No original document provided',
    5 => 'Not a benefit of this policy',
    6 => 'Not considered an emergency',
    7 => 'Ongoing care is not covered by this policy',
    8 => 'Other',
    9 => 'Symptoms did not appear within policy coverage dates',
    10 => 'This dental procedure is not covered by this policy',
    11 => 'Treatment not sought within policy coverage dates',
    12 => 'Unstable pre-existing condition'];

  public $reasonFrArr = [
    'Documentation’s fee is not covered by this policy' => 'Les frais de documentation ne sont pas couverts par cette police',
    'Maximum of 30 days’ supply per prescription' => 'Maximum de 30 jours d’approvisionnement par ordonnance',
    'No official invoice/receipt provided' => 'Aucune facture ni aucun reçu officiel fourni',
    'No original document provided' => 'Aucun document original fourni',
    'Not a benefit of this policy' => 'Ce service n’est pas couvert par cette police',
    'Not considered an emergency' => 'Non considéré comme une urgence',
    'Ongoing care is not covered by this policy' => 'Les soins continus ne sont pas couverts par cette police',
    'Other' => 'Autre',
    'Symptoms did not appear within policy coverage dates' => 'Les symptômes ne sont pas apparus pendant la période de couverture de la police',
    'This dental procedure is not covered by this policy' => 'Cette intervention dentaire n’est pas couverte par cette police',
    'Treatment not sought within policy coverage dates' => 'Le traitement n’a pas été demandé pendant la période de couverture de la police',
    'Unstable pre-existing condition' => 'Affection préexistante instable'];

	public function get_list() {
		return $this->reasonArr;
	}

	public function get_fr_list() {
		return $this->reasonFrArr;
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
}