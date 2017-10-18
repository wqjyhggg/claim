<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */

class Word_comments_model extends CI_Model {
	/**
	 * Return a list
	 *
	 * @param array $data
	 *        	search parameter
	 * @return array result array, maybe null
	 */
	public function search($data) {
		$this->db->where($data);
		return $this->db->get('word_comments')->result_array();
	}

	/**
	 * Save
	 *
	 * @param integer	id
	 * @param string	title
	 * @param string	content
	 * @return int		inserted array ID
	 */
	public function save($id, $title, $content) {
		$data = array(
				'title' => $title,
				'content' => $content
		);
		if ($id) {
			$this->db->set('id', $id);
			$this->db->update('word_comments', $data);
			$sql = $this->db->last_query();
			$this->active_model->log_new('word_comments', $id, $data, $sql);
		} else {
			// insert
			$this->db->insert('word_comments', $data);
			$sql = $this->db->last_query();
			$id = $this->db->insert_id();
			$this->active_model->log_new('word_comments', $id, $data, $sql);
			return $id;
		}
	}
}