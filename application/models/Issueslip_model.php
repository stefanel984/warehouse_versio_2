<?php


class Issueslip_model extends CI_Model
{
	static $table = 'issue_slip';
	static $sub_table = 'out_item';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	function insert($data){
		$this->db->insert(self::$table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function insert_item($data){
		$this->db->insert(self::$sub_table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function checkActive($user_id){

		$query = $this->db->query('SELECT * FROM '.self::$table.' WHERE created_by = "'.$user_id.'" AND confirm = 0');
		$num = $query->num_rows();


		if($num > 0){
			return true;
		}
		else{
			return false;
		}


	}
	function selectActive($user_id){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where('created_by', $user_id);
		$this->db->where('confirm', 0);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res[0];
	}

	function viewlist($list_id){
		$sql = "SELECT out_item.*, warehouse.*  FROM out_item LEFT JOIN warehouse
                                   ON out_item.warehouse_id = warehouse.id WHERE out_item.issue_id = '".$list_id."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;

	}

	function update($key,$value,$data){
		$this->db->where($key, $value);
		$this->db->update(self::$table, $data);
	}
	function getCartInfoByKey($key, $value){
		$this->db->select('*');
		$this->db->from(self::$table);
		$this->db->where($key, $value);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getItem($key,$param){
		$this->db->select('*');
		$this->db->from(static::$sub_table);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getDistinctItem($column,$key,$param){
		$this->db->distinct();
		$this->db->select($column);
		$this->db->from(static::$sub_table);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getList($key,$param){
		$this->db->select('*');
		$this->db->from(static::$table);
		$this->db->where($key, $param);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;


	}
	function deleteItem($key, $param){
		$this->db->where($key, $param);
		$this->db->delete(self::$sub_table);
		return true;
	}
	function delete($key, $param){
		$this->db->where($key, $param);
		$this->db->delete(self::$table);
		return true;
	}
	function insert_weight($data)
	{
		$this->db->insert('list_weight', $data);
		$insert_id = $this->db->insert_id();
	}
	function getWeightList($slip_id){
		$this->db->select('*');
		$this->db->from('list_weight');
		$this->db->where('issue_slip_id', $slip_id);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

}
