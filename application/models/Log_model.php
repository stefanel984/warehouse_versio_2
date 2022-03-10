<?php


class Log_Model extends CI_Model
{
	/*
	 * action -in, vlez, out izlez, transfer -promena na lokacija
	 *
	 */
	static $table = 'warehouse_log';
	static $table_rotation = 'rotation_audit';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function insert($data){
		$this->db->insert(self::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete($data){
		$this->db->delete(self::$table, $data);

	}

	function getLogByKey($key,$param){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getLog(){
		$this->db->select('*');
		$this->db->from(static::$table);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

	function insert_revert($data){
		$this->db->insert(self::$table_rotation, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete_revertByKey($key, $value){
		$this->db->where($key, $value);
		$this->db->delete(self::$table_rotation);

	}
	function getRevertByKey($key,$param){
		$this->db->select('*');
		$this->db->from(static::$table_rotation);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}


}
