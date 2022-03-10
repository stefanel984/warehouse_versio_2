<?php


class Article_model extends CI_Model
{
	static $table = 'article';
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}

	function getArticle($deleted = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		if(!$deleted){
			$this->db->where('deleted', 0);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function getArticleByID($id =0, $deleted = false){
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
	function getArticleByIDs($ids =array(), $deleted = false){
		$this->db->select('*');
		$this->db->from(static::$table);
		if(!empty($ids)){
			$this->db->where_in('id', $ids);
		}
		if(!$deleted){
			$this->db->where('deleted', 0);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}
	function insert($data){
		$this->db->insert('article', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function update($key, $key_value, $data){
		$this->db->where($key,$key_value);
		$this->db->update(static::$table, $data);

	}

}
