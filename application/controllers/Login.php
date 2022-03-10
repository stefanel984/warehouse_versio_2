<?php


class Login extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('admin_model');
		$this->load->model('issueslip_model');
	}
	function index(){
		$user_info= $this->session->userdata('user_info');
		if(isset($user_info) && $user_info!=''){

			redirect("dashboard/");

		}
		else{
			$data = array(
				"content"	=> "login",
				"tab"       => "Логирање",
				"error_message" => ""
			);
			$this->load->view('template',$data);
		}
	}
	function logiranje(){
		$credentials = $this->input->post();
		$this->load->model('admin_model');
		$status_login = $this->admin_model->login($credentials['password'],$credentials['username']);
		$status_login = json_decode($status_login);
		if($status_login->status ==  true){
			redirect("dashboard/");

		}
		else{
			$data = array(
				"content"	=> "login",
				"tab"       => "Логирање",
				"error_message" => "Грешен корисник и/или лозинка"
			);
			$this->load->view('template',$data);
		}


	}
	function logout(){
		$this->session->sess_destroy();
		redirect("login/");

	}
	function user(){
		$user = $this->admin_model->getUser(true);
		$data = array(
			"content"	=> "user",
			"tab"       => "Корисници",
			"error_message" => "",
			"user" => $user
		);
		$this->load->view('template',$data);

	}
	function changePasswordHtml(){
		$id_user = $this->input->post('id_user');
		$user = $this->admin_model->getUserById($id_user);
		$checked = '';
		if($user['is_admin'] == 1){
			$checked = 'checked';
		}
		$html = '<form><input type="hidden" name="user_id" id="user_id" value="'. $id_user.'"/><br/>';
		$html .= '<span> Корисник :'.$user['full_name'].'</span><br/>';
		$html .= '<label>Телефон: <span class="required">*</span></label><input type="text"  name="telephone" id="telephone" value="'. $user['mobile'].'" required/><br/>';
		$html .= '<label>Телефон 2:</label><input type="text"  name="telephone_2" id="telephone_2" value="'. $user['other_mobile'].'"/><br/>';
		$html .= '<label>Емаил: <span class="required">*</span></label><input type="text"  name="email" id="email" value="'. $user['email'].'"/><br/>';
		$html .= '<label>Администратор</label></label><input type="checkbox" name="admin" id="admin" '.$checked.' required/><br/>';
		$html .= '</form>';

		echo $html;

	}
	function viewPasswordHtml(){
		$id_user = $this->input->post('id_user');
		$user = $this->admin_model->getUserById($id_user);
		$checked = '';
		if($user['is_admin'] == 1){
			$checked = 'checked';
		}
		$html =  '<span> Корисник :'.$user['full_name'].'</span><br/>';
		$html .= '<span> Телефон :'.$user['mobile'].'</span><br/>';
		$html .= '<span> Телефон 2 :'.$user['other_mobile'].'</span><br/>';
		$html .= '<span> Емаил :'.$user['email'].'</span><br/>';
		$html .= '<span> Адинистратор :<input type="checkbox" name="admin" id="admin" '.$checked.' required disabled/></span><br/>';
		echo $html;

	}
	function update_user(){
		$user_details = $this->input->post();
		if($user_details['action'] == 'update'){
			$data = array(
				'email' => $user_details['email'],
				'mobile' => $user_details['phone'],
				'other_mobile' =>$user_details['other_mobile'],
				'is_admin' =>$user_details['is_admin'],
			);
			$this->admin_model->updateById($user_details['user_id'],$data);
			$res = array('success' => true);
		}
		else{

		}
		echo json_encode($res);
	}

	function add_user(){

		$data = array(
			"content"	=> "add_user",
			"tab"       => "Додади корисник",
			"title"     => "Нов корисник",
			"error_message" => "",
		);
		$this->load->view('template',$data);

	}
	function add_new_user(){
		$user_details = $this->input->post();
		if($user_details['name'] != '' && $user_details['surname'] != '' &&  $user_details['email'] != '' && $user_details['phone'] != '' && $user_details['password'] != '' && $user_details['username'] != ''  ){
           $is_admin = 0;
           if(isset($user_details['is_admin']) && $user_details['is_admin'] == 'on' ){
           	    $is_admin = 1;
		   }
           $logged_user =  $this->session->userdata('user_info');
			$data = array(
				'name' => $user_details['name'],
				'surname' => $user_details['surname'],
				'email' => $user_details['email'],
				'mobile' => $user_details['phone'],
				'other_mobile' => $user_details['other_phone'],
				'full_name' => $user_details['name'].' '.$user_details['surname'],
				'is_admin' => $is_admin,
				'created_by' => $logged_user['user_id'],
				'password' => md5($user_details['password']),
				'username' => $user_details['username']

			);
			$user_id = $this->admin_model->insertUser($data);
			if($user_id > 0){
				redirect("login/user");
			}

		}
		else{
			$data = array(
				"content"	=> "error_page",
				"tab"       => "Грешка",
				"error_message" => "Грешка при внесувањето податоци!!! Контактирјте админ"
			);
			$this->load->view('template',$data);

		}

	}
	function checkExistingUser(){
		$username = $this->input->post('username');
		$user = $this->admin_model->getUserByKey("username",$username);
		$res = array('exist' => 'no');
		if(!empty($user)){
			$res = array('exist' => 'yes');
		}
		echo json_encode($res);

	}
	function edit_pass(){
		$id = $this->uri->segment(3);

		$user = $this->admin_model->getUserById($id);
        if(!empty($user)) {
			$data = array(
				"content" => "edit_pass",
				"tab" => "Промена на лозинка",
				"title" => "Промена на лозинка",
				"id" => $id,
				"full_name" => $user['full_name'],
				"error_message" => ""
			);
			$this->load->view('template', $data);
		}
        else{
			$data = array(
				"content" => "edit_pass",
				"tab" => "Промена на лозинка",
				"title" => "Промена на лозинка",
				"id" => $id,
				"error_message" => "Грешка!! Повикај администратор",
			);
			$this->load->view('template', $data);
		}

	}
	function edit_user_pass(){
		$user_pass_details = $this->input->post();
		$data = array(
			'password' => md5($user_pass_details['password']),
		);
		$this->admin_model->updateById($user_pass_details['user_id'],$data);
		redirect("login/user");

	}
	function  delete_restore(){
		$id_user = $this->input->post('id_user');
		$action  = $this->input->post('action');
		if($action == 'delete'){
			$data =  array(
				'deleted' => 1
			);
		}
		elseif ($action == 'restore'){
			$data =  array(
				'deleted' => 0
			);

		}


		$this->admin_model->updateById($id_user,$data);
		$res =  array('id'=>$id_user, 'return'=>true);
		echo json_encode($res);

	}

}
