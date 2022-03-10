<?php


class Snumber_model extends CI_Model
{
	static $table = 's_number';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function insert($data){
		$this->db->insert(self::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function selectDistinct($key='', $value=''){
		$this->db->distinct();

		$this->db->select('name');
		$this->db->from(static::$table);


		if($key != '' && $value != ''){
			$this->db->where($key, $value);
		}


		$query = $this->db->get();
		$res = $query->result_array();

		return $res;
	}
	function select($key='', $value='', $all = false){

		$this->db->select('*');
		$this->db->from(static::$table);

		if($key != '' && $value != ''){
			$this->db->where($key, $value);
		}

		if(!$all) {
			$this->db->where('deleted', 0);
		}


		$query = $this->db->get();
		$res = $query->result_array();

		return $res;
	}
	function update($key,$value,$data){

		$this->db->where($key, $value);
		$this->db->update(static::$table, $data);

	}

}
