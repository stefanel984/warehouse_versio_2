<?php


class Dashboard extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}
	public function index(){
		$location = $this->location_model->getSection();
		$area = $this->area_model->getArea();
		$data = array(
			"content"	=> "dashboard",
			"tab"       => "Преглед",
			"location"  => $location,
			"area"      => $area,
			"technical_url" => $this->technical_images

		);
		$this->load->view('template',$data);

	}
	public function rotationHtml(){
		$id_location =  $this->uri->segment(3);
		$articles = $this->warehouse_model->getWarehouseByKey('section_id',$id_location);
		$area = $this->area_model->getArea();
		$location = $this->location_model->getSection();
		$data = array(
			"content"	=> "dashboard/warehouse_rotation",
			"tab"       => "Премести ролни",
			"id"       => $id_location,
			"articles" => $articles,
			"area"      => $area,
			'location' => $location
		);
		$this->load->view('template',$data);
	}

}


