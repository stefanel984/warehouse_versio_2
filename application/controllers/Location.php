<?php


class Location extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}

	public function index(){
		$location = $this->location_model->getSection();
		$uri = $this->uri->segment(3);
		$curr_location = $this->location_model->getSectionById($uri);
		$area = $this->area_model->getArea();
		$warehouse_article = $this->warehouse_model->getWarehouseByKey('section_id', $uri);
		$article_in_stock = $this->warehouse_model->selectDistinct('article_id', 'section_id', $uri);
		$article_ids = array();
		foreach($article_in_stock as $a){
			$article_ids[] = $a['article_id'];
		}
		$article_used = array();
		if(isset($uri)){
			$article_used = $this->article_model->getArticleByIDs($article_ids, true);
		}
		$color = $this->settings_model->getColor();
		$data = array(
			"content"	=> "location",
			"tab"       => "Локации",
			"location"  => $location,
			"area"      => $area,
			"uri"     => $uri,
			"technical_images"   =>$this->technical_images,
			"article" => $warehouse_article,
			"curr_location" => $curr_location,
			"article_in_stock" => $article_used,
			"color" => $color


		);
		$this->load->view('template',$data);

	}
	public function location(){
		    $area = $this->area_model->getArea();
			$data = array(
				"content"	=> "add_location",
				"tab"       => "Додади локација",
				"title"     => "Додади локација",
				"area"      => $area

			);
			$this->load->view('template',$data);

	}
	public function add_location(){
		$loc = $this->input->post();
		$area = $this->area_model->getAreaByKey('name',$loc['area']);
		$user_info= $this->session->userdata('user_info');
		if(!empty($area)){
			$location = $this->location_model->getLocationByKey('name',$loc['location']);
			if(empty($location)){
				$data = array(
					'name' => $loc['location'],
					'id_area'=> $area[0]['id'],
					'price'=>0,
					'old_price'=>0,
					'created_by'=>$user_info['user_id']
				);
				$location_id = $this->location_model->insert($data);
				if($location_id > 0){
					redirect("settings/");
				}

			}
			else{
				$area = $this->area_model->getArea();
				$data = array(
					"content"	=> "add_location",
					"tab"       => "Додади локација",
					"title"     => "Додади локација",
					"area"      => $area,
					"error"     => 'Постоечка локација'

				);
				$this->load->view('template',$data);

			}

		}
		else{
			$data = array(
				          'name' => $loc['area'],
				          'created_by'=>$user_info['user_id']
			              );
			$area_id = $this->area_model->insert($data);
			$data = array(
				           'name' => $loc['location'],
				            'id_area'=> $area_id,
				            'price'=>0,
				            'old_price'=>0,
				            'created_by'=>$user_info['user_id']
			              );
			$location_id = $this->location_model->insert($data);
			if($location_id > 0){
				redirect("settings/");
			}
		}
	}
	public function statistic(){
		$uri = $this->uri->segment(3);
		$article_in_stock = $this->warehouse_model->selectDistinct('article_id', 'section_id', $uri);
		$article_array = array();
		foreach($article_in_stock as $article){
			$article_by_color = $this->warehouse_model->selectDistinct('color', 'article_id', $article['article_id']);
			foreach($article_by_color as $color){
				$article_array[$article['article_id']][$color['color']] = $this->warehouse_model->getWarehouseByArticleColor($article['article_id'],$color['color']);

			}
		}

		$data = array(
			"content"	=> "statistic",
			"tab"       => "Состојба",
			"title"     => "Состојба",
			"area"      => $uri,
			"articles"   => $article_array,
			"color_image" => $this->color_img


		);
		$this->load->view('template',$data);


	}

}
