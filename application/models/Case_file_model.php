<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Case_file_model extends CI_Model {
  // id INT NOT NULL AUTO_INCREMENT,
  // case_id INT NOT NULL DEFAULT 0,
  // `case_no` varchar(64) NOT NULL DEFAULT '',
  // `doc_type` varchar(32) NOT NULL DEFAULT '',
  // `filename` char(64) NOT NULL DEFAULT '' COMMENT 'File Name for showing',
  // `url` varchar(8) NOT NULL DEFAULT '' COMMENT 'Download URL',
  // notes TEXT,
  // update_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  // create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  // user_id INT NOT NULL DEFAULT 0,

  /**
	 * Return a list
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function get_by_id($id) {
		$this->db->where("id", $id);
		return $this->db->get('case_file')->row_array();
	}

	/**
	 * Save
	 *
	 * @param array	data
	 * @return int		inserted array ID
	 */
	public function save($data) {
    $id = 0;
    if (isset($data["id"])) {
      if ($cur = $this->get_by_id($data["id"])) {
        $id = $cur["id"];
      }
    }
    if (isset($data["case_id"])) {
      $tis->db->set("case_id", $data["case_id"]);
    }
    if (isset($data["user_id"])) {
      $tis->db->set("user_id", $data["user_id"]);
    }
    if (isset($data["case_no"])) {
      $tis->db->set("case_no", $data["case_no"]);
    }
    if (isset($data["doc_type"])) {
      $tis->db->set("doc_type", $data["doc_type"]);
    }
    if (isset($data["filename"])) {
      $tis->db->set("filename", $data["filename"]);
    }
    if (isset($data["url"])) {
      $tis->db->set("url", $data["url"]);
    }
    if (isset($data["notes"])) {
      $tis->db->set("notes", $data["notes"]);
    }
		if ($id) {
			$this->db->where('id', $id);
			$this->db->update('case_file');
			$sql = $this->db->last_query();
			$this->active_model->log_new('case_file', $id, $data, $sql);
		} else {
			// insert
			$this->db->insert('case_file');
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('case_file', $id, $data, $sql);
		}
    return $id;
	}

	/**
	 * Save
	 *
	 * @param array	data
	 * @return int		inserted array ID
	 */
	public function get_files($case_id) {
		$this->db->where("case_id", $case_id);
		return $this->db->get('case_file')->result_array();
	}
}