<?php


class Settings_model extends CI_Model
{

	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function getMeasure(){
		$query = $this->db->get('measure');
		$res = $query->result_array();
		return $res;
	}
	function getColor($id = 0){
		$this->db->select('*');
		$this->db->from('color');
		if($id != 0){
			$this->db->where('id', $id);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getMeasureById($id){
		$this->db->select('*');
		$this->db->from('measure');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getAllMeasure(){
		$this->db->select('*');
		$this->db->from('measure');
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function addColor($data){
		$this->db->insert('color', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function addMeasure($data){
		$this->db->insert('measure', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function getDocType($id = 0){
		$this->db->select('*');
		$this->db->from('document_type');
		if($id != 0){
			$this->db->where('id', $id);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function updateDocType($key, $key_value, $data){
		$this->db->where($key,$key_value);
		$this->db->update('document_type', $data);

	}
	function insertDocType($data){
		$this->db->insert('document_type', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
}
