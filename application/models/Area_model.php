<?php


class Area_model extends CI_Model
{
	static $table = 'area';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function getArea(){
		$query = $this->db->get(self::$table);
		$res = $query->result_array();
		return $res;
	}
	function getAreaById($id){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res[0];
	}
	function getAreaByKey($key, $value){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $value);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function insert($data){
		$this->db->insert(static::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

}
