<?php


class Document_model extends CI_Model
{
	static $table = 'document';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function insert($data){
		$this->db->insert(static::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function update($key,$value,$data){
		$this->db->where($key, $value);
		$this->db->update(self::$table, $data);
	}
	function insert_doc_upload($data){
		$this->db->insert('document_upload', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function update_doc_upload($key,$value,$data){
		$this->db->where($key, $value);
		$this->db->update('document_upload', $data);
	}
	function getDocument($id =0, $deleted = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		if($id != 0){
			$this->db->where('id', $id);
		}
		if(!$deleted){
			$this->db->where('deleted', 0);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}
	function getUploadDocument($key, $param, $all = false){
		$this->db->select('*');
		$this->db->from('document_upload');
		$this->db->where($key, $param);
		if(!$all){
			$this->db->where('deleted', 0);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}

}
