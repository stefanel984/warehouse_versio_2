<?php


class Warehouse_model extends CI_Model
{
	static $table = 'warehouse';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}

	function getWarehouse($all = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		if(!$all){
			$this->db->where('in_stock', 1);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getWarehouseByKey($key,$param, $all = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $param);
		if(!$all){
			$this->db->where('in_stock', 1);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getWarehouseSumQtyByKey($key,$param, $all = false){
		$this->db->select_sum('qty');
		$this->db->from(static::$table);
		$this->db->where($key, $param);
		if(!$all){
			$this->db->where('in_stock', 1);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getWarehouseBySNumber($s_number,$article_id, $all = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where('serial_number', $s_number);
		$this->db->where('article_id', $article_id);
		if(!$all){
			$this->db->where('in_stock', 1);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getWarehouseByIDs($ids =array(), $all_stock = false ){
		$this->db->select('*');
		$this->db->from(static::$table);
		if(!empty($ids)){
			$this->db->where_in('id', $ids);
		}
		if(!$all_stock){
			$this->db->where('in_stock', 1);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getWarehouseTable($loc){
		$sql = "SELECT * FROM warehouse WHERE section_id = ".$loc." AND  (in_stock = 1 OR (in_stock = 0 and date_exit >= DATE(NOW() - INTERVAL 15 MINUTE)))";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}
	function insert($data){
		 $this->db->insert('warehouse', $data);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	}
	function update($key,$value,$data){
		$this->db->where($key, $value);
		$this->db->update(self::$table, $data);
	}
	function selectDistinct($column, $key = '', $value = '', $all_stock = false){
		$this->db->distinct();

		$this->db->select($column);
		$this->db->from(static::$table);

		if($key != '' && $value !=''){
			$this->db->where($key, $value);
		}
		if(!$all_stock){
			$this->db->where('in_stock', 1);
		}

		$query = $this->db->get();
		$res = $query->result_array();

		return $res;

	}
	function getWarehouseByArticleColor($article, $color){

		$this->db->select('*');
		$this->db->from(static::$table);

		$this->db->where('article_id', $article);
		$this->db->where('color', $color);
		$this->db->where('in_stock', 1);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}

	function getWarehouseByArticleLocation($article, $location){

		$this->db->select('*');
		$this->db->from(static::$table);

		$this->db->where('article_id', $article);
		$this->db->where('section_id', $location);
		$this->db->where('in_stock', 1);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;

	}


}
