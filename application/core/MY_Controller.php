<?php


class MY_Controller extends CI_Controller
{
	public $color_img = 'images\color';
	public $technical_images = 'images/technical_images';
	public $user_info = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');


		$user_info= $this->session->userdata('user_info');
		$this->user_info  = $user_info;
		if(isset($user_info) && $user_info!=''){

			$this->load->model('admin_model');
			$this->load->model('location_model');
			$this->load->model('area_model');
			$this->load->model('warehouse_model');
			$this->load->model('article_model');
			$this->load->model('settings_model');
			$this->load->model('log_model');
			$this->load->model('document_model');
			$this->load->model('product_model');
			$this->load->model('issueslip_model');
			$this->load->model('snumber_model');

		}
		else{
			redirect("login/");
		}



	}
}
