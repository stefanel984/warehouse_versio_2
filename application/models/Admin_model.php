<?php
/**
 * Class Admin_model
 * admin things
 */

class Admin_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	public function login($password, $username){

	   $query = $this->db->query('SELECT * FROM user WHERE password =  "'.md5($password).'" and username = "'.$username.'" and 
	                              deleted = 0');
	   //$query = $this->db->query('SELECT * FROM user WHERE password =  "'.$password.'" and username = "'.$username.'"');
       $num = $query->num_rows();
       if($num == 1){
       	   $user_array  = $query->row();
		   $user = array(
			   'username'  => $password,
			   'email'     => $username,
			   'user_id'   => $user_array->id,
			   'full_name' => $user_array->full_name,
			   'is_admin' => $user_array->is_admin,
			   'logged_in' => TRUE
		   );
		   $this->session->set_userdata('user_info',$user);
		   $res = array();
		   $res['status'] = true;
		   return json_encode($res,true);

	   }
       else{
		   $res['status'] = false;
		   return json_encode($res,true);
	   }
   }
   public function getUser($deleted = false){
	   $this->db->select('*');
	   $this->db->from('user');
	   if(!$deleted){
		   $this->db->where('deleted', 0);
	   }
	   $query = $this->db->get();
	   $res = $query->result_array();
	   return $res;

   }
	public function getUserById($id){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$res = $query->result_array();
		if(!empty($res)){
			return $res[0];
		}
		else{
			return array();
		}


	}
	function updateById($id, $data){
		$this->db->where('id', $id);
		$this->db->update('user', $data);

	}
	function insertUser($data){
		$this->db->insert('user', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	function getUserByKey($key, $value){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where($key, $value);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

}
