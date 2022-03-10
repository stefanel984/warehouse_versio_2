<?php


class Product_model extends CI_Model
{
	static $table = 'product';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function insert($data){
		$this->db->insert(self::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function getProductByID($id = 0 ){
		$this->db->select('*');
		$this->db->from(static::$table);
		if($id != 0){
			$this->db->where('id', $id);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}
	function selectDistinct(){
		$this->db->distinct();

		$this->db->select('name');
		$this->db->from(static::$table);


		$query = $this->db->get();
		$res = $query->result_array();

		return $res;
	}

	function getProductBySerialNumber($s_number){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where('s_number', $s_number);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}
	function getProductBySerialNumberandArticle($s_number, $article){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where('s_number', $s_number);
		$this->db->where('article', $article);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}
	function getProductByKey($key,$param){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

}
