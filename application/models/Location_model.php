<?php


class Location_model extends CI_Model
{
    static $table = 'section';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function getSection($order = ''){
		$this->db->select('*');
		$this->db->from(static::$table);
		if($order != ''){
			$this->db->order_by($order);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getSectionById($id = ''){
		$this->db->select('*');
		$this->db->from(static::$table);
		if($id != ''){
			$this->db->where('id', $id);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		if(!empty($res)){
			return $res[0];
		}
		else{
			$res = array();
			return $res;
		}

	}
	function updateById($id, $data){
		$this->db->where('id', $id);
		$this->db->update(self::$table, $data);

	}
	function insert($data){
		$this->db->insert(static::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function getLocationByKey($key, $value){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $value);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

}
