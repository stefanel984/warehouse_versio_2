<?php


class Snumber extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}

	public function index(){
		$number = $this->snumber_model->select('','',true);
		$data = array(
			"content"	=> "view_snumber",
			"tab"       => "S број",
			"title"    => "S број",
			"number"  => $number,


		);
		$this->load->view('template',$data);
	}
	public function create(){

		if(isset($_REQUEST['s_number']) && $_REQUEST['s_number'] != '' ){
			$user_info= $this->session->userdata('user_info');
			$data = array(
				          'name' => $_REQUEST['s_number'],
				          'created_by' => $user_info['user_id']

			              );
			$id = $this->snumber_model->insert($data);
			if($id > 0){
				redirect("snumber/index");
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
	    else{
			$data = array(
				"content"	=> "error_page",
				"tab"       => "Грешка",
				"error_message" => "Грешка контактирајте администратор"
			);
			$this->load->view('template',$data);

		}
	}
	public function check(){

		$s_number = $_REQUEST['s_number'];
		$s = $this->snumber_model->select('name',$s_number);
		$res = array();
		if(count($s) > 0){
			$res['exist'] = 'true';
		}
		else{
			$res['exist'] = 'false';
		}

		echo json_encode($res);

	}
	public function migration(){
		$s_numbers =  $this->warehouse_model->selectDistinct('serial_number');
		print_r($s_numbers);
		foreach($s_numbers as $s){
			$data = array(
				'name' => $s['serial_number'],
				'created_by' => 1

			);
			$id = $this->snumber_model->insert($data);

		}
	}

	public function delete_restore(){
		$id= $this->input->post('id');
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


		$this->snumber_model->update('id',$id,$data);
		$res =  array('id'=>$id, 'return'=>true);
		echo json_encode($res);
	}

	public function getSnumber(){

		$snumber = $this->snumber_model->select();
		$html = '';
		$html .= '<input list="s_num" name="s_number[]" class="s_number" required>
                  <datalist  id="s_num" class="s_number" style="width: 100%;">';
		foreach($snumber as $s) {
			$html .= '<option value ="' . $s['name'] . '">';
		}


		$html .= '</datalist>';
		echo $html;

     }



}
