<?php


class Warehouse extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}

	public function index(){
		$stock = $this->warehouse_model->getWarehouse();
		$area = $this->area_model->getArea();
		$location = $this->location_model->getSection();
		$article = $this->article_model->getArticle();
		$color = $this->settings_model->getColor();
		$data = array(
			"content"	=> "warehouse_in",
			"tab"       => "Внес артикли",
			"title"     => "Внес артикли во складиште",
			"stock"     =>$stock,
			"area"      =>$area,
			"location"  =>$location,
			"article"   =>$article,
			"img_url"   =>$this->color_img,
			"color"     =>$color

		);
		$this->load->view('template',$data);

	}
	public function outgoing(){

		$user_info= $this->session->userdata('user_info');


		$active = $this->issueslip_model->checkActive($user_info['user_id']);

		$is = '';

		if($active){
			$is_array = $this->issueslip_model->selectActive($user_info['user_id']);
			$is = $is_array['id'];
		}

		$snumber = $this->snumber_model->select();


		$data = array(
			"content"	=> "warehouse_out",
			"tab"       => "Излез артикли",
			"title"     => "Излез артикли од складиште",
			"active"    => $active,
			"is"        => $is,
			"snumbers"  => $snumber
		);

		$this->load->view('template',$data);

	}
	public function add_in_warehouse(){
		$warehouse = $this->input->post();
		if($warehouse['location'] !='' ){
			if($warehouse['number_of'] != 0) {
				for ($i = 0; $i < $warehouse['number_of']; $i++) {
					$article_details = $this->article_model->getArticleByID($warehouse['article'][$i]);
					$name = $article_details[0]['name'];
					$price_per_piece = $warehouse['price'][$i];
					$qty = floatval($warehouse['quantity'][$i]);
					if(!isset($warehouse['width'][$i])){
						$warehouse['width'][$i] = 0;
					}
					if(!isset($warehouse['package'][$i])){
						$warehouse['package'][$i] = 0;
						$package = 1;
					}
					else{
						$package = $warehouse['package'][$i];
					}
					$price_total = $price_per_piece * $qty * $package;

					$data = array(
						'name' => $name,
						'color' => $warehouse['color'][$i],
						'article_id' => $article_details[0]['id'],
						'created_by' => $this->user_info['user_id'],
						'qty' => $qty,
						'date_entered' => date("Y-m-d H:i:s"),
						'price_per_piece' => $price_per_piece,
						'article_name' => $name,
						'price_total' => $price_total,
						'measure_id' => $article_details[0]['measure'],
						'section_id' => $warehouse['location'],
						'serial_number' => $warehouse['s_number'][$i],
						'width' => $warehouse['width'][$i],
						'package' => $warehouse['package'][$i],


					);
					$wm_id = $this->warehouse_model->insert($data);
					$location = $this->location_model->getSectionById($warehouse['location']);
					$price = $location['price'] + $price_total;
					$old_price = $location['old_price'] + $price_total;
					$data = array(
						'price' => $price,
						'old_price' => $old_price
					);
					$this->location_model->updateById($warehouse['location'], $data);
					$data = array(
						'action' => 'in',
						'date_entered' => date("Y-m-d H:i:s"),
						'created_by' => $this->user_info['user_id'],
						'relation_id' => $wm_id
					);
					$lg_id = $this->log_model->insert($data);

				}
				if ($lg_id > 0) {
					redirect("location/index/" . $location['id']);
				}
			}
			else{
				redirect("warehouse");
			}


		}
		else{
			redirect("settings/error/");
		}

	}
	public function articleInLocation(){
		$loc = $this->input->post('loc');
		$article_in_stock = $this->warehouse_model->selectDistinct('article_id', 'section_id', $loc);
		$article_ids = array();
		foreach($article_in_stock as $a){
			$article_ids[] = $a['article_id'];
		}
		$res = $this->article_model->getArticleByIDs($article_ids);
		$res = json_encode($res);
		echo $res;

	}
	public function remove_article(){
		$id = $this->input->post('article_id');
		$location_id = $this->input->post('location_id');
		$qty = $this->input->post('qty');
		$article = $this->warehouse_model->getWarehouseByKey('id',$id);
		if($article[0]['qty'] - $qty < 0){
			$res = array('result' => 'error');
			echo json_encode($res);
			exit;

		}

        if($qty != $article[0]['qty']){

        	$data = array('in_stock' => 1,
				          'date_exit' => date("Y-m-d H:i:s"),
				          'qty' => $qty);
			$this->warehouse_model->update('id',$id, $data);


			$data = array(
				'action' => 'out',
				'date_entered' => date("Y-m-d H:i:s"),
				'created_by' => $this->user_info['user_id'],
				'relation_id'=> $id
			);
			$this->log_model->insert($data);
			$package = $article[0]['package'];
			if($article[0]['package'] == 0){
				$package = 1;
			}


			$data = array('serial_number' => $article[0]['serial_number'],
				          'name' => $article[0]['name'],
				          'color' => $article[0]['color'],
				          'article_id' => $article[0]['article_id'],
				          'created_by' => $article[0]['created_by'],
				          'qty' => $article[0]['qty'] - $qty,
				          'date_entered' => $article[0]['date_entered'],
				          'price_per_piece' => $article[0]['price_per_piece'],
				          'article_name' => $article[0]['article_name'],
				          'in_stock' => 0,
				          'price_total' => ($article[0]['qty'] - $qty) * $article[0]['price_per_piece'] * $package,
				          'measure_id' => $article[0]['measure_id'],
				          'section_id' => $article[0]['section_id'],
				          't_number' => $article[0]['t_number'],
				          'currency' => $article[0]['currency'],
				          'ex_change'=> $article[0]['ex_change'],
				          'width' => $article[0]['width'],
				          'package'=>$article[0]['package']

			);

			$new_id = $this->warehouse_model->insert($data);

			$data = array(
				'action' => 'in',
				'date_entered' => $article[0]['date_entered'],
				'created_by' => $article[0]['created_by'],
				'relation_id'=> $new_id
			);
			$this->log_model->insert($data);


		}
        else{
			$data = array('in_stock' => 0,
				'date_exit' => date("Y-m-d H:i:s"));
			$this->warehouse_model->update('id',$id, $data);
			$data = array(
				'action' => 'out',
				'date_entered' => date("Y-m-d H:i:s"),
				'created_by' => $this->user_info['user_id'],
				'relation_id'=> $id
			);
			$this->log_model->insert($data);
		}

		$section_info = $this->location_model->getSectionById($location_id);
		$new_price = $section_info['price'] - ($qty * $article[0]['price_per_piece']);
		$data = array('price' => $new_price,
			          'old_price' => $new_price);
		$this->location_model->updateById($location_id,$data);



		$user_info= $this->session->userdata('user_info');


		$active = $this->issueslip_model->checkActive($user_info['user_id']);

		if($active){
			$is_array = $this->issueslip_model->selectActive($user_info['user_id']);
			$is = $is_array['id'];
		}
		else{
			$data= array(
				'date'=> date("Y-m-d H:i:s"),
				'created_by' => $user_info['user_id'],
				'confirm '=> 0
			);

			$is = $this->issueslip_model->insert($data);
		}
		$data = array(
			          'warehouse_id' => $id,
			          'date'=> date("Y-m-d H:i:s"),
			          'created_by' => $user_info['user_id'],
			          'issue_id'=> $is
		              );

		$item_id = $this->issueslip_model->insert_item($data);

		if($item_id > 0) {
			$res = array('result' => 'success');
		}
		else{
			$res = array('result' => 'error');
		}
		echo json_encode($res);


	}
	public function rotation(){

		$article= $this->input->post();


		if($article['old_section'] == '' || $article['location'] == '' || empty($article['article_id'])){
			$data = array(
				"content"	=> "error_page",
				"tab"       => "Грешка",
				"error_message" => "Настана грешка!!! Контактирјте админ"
			);
			$this->load->view('template',$data);

		}
		else {
			$sum = 0;
			foreach ($article['article_id'] as $a) {
				$article_warehouse = $this->warehouse_model->getWarehouseByKey('id', $a);
				$sum = $sum + $article_warehouse[0]['price_total'];
				$data = array(
					'name' => $article_warehouse[0]['name'],
					'color' => $article_warehouse[0]['color'],
					'article_id' => $article_warehouse[0]['article_id'],
					'created_by' => $this->user_info['user_id'],
					'qty' => $article_warehouse[0]['qty'],
					'date_entered' => date("Y-m-d H:i:s"),
					'price_per_piece' => $article_warehouse[0]['price_per_piece'],
					'article_name' => $article_warehouse[0]['name'],
					'price_total' => $article_warehouse[0]['price_total'],
					'measure_id' => $article_warehouse[0]['measure_id'],
					'section_id' => $article['location'],
					'serial_number' => $article_warehouse[0]['serial_number'],
					'width'=> $article_warehouse[0]['width'],
					'package'=> $article_warehouse[0]['package']

				);
				$wm_id = $this->warehouse_model->insert($data);
				$data = array(
					'action' => 'transfer',
					'date_entered' => date("Y-m-d H:i:s"),
					'created_by' => $this->user_info['user_id'],
					'relation_id' => $a . ',' . $wm_id
				);
				$this->log_model->insert($data);
				$data = array(
					'in_stock' => 0
				);
				$this->warehouse_model->update('id', $a, $data);
			}
			$old_section = $this->location_model->getSectionById($article['old_section']);
			$old_price_update = $old_section['price'] - $sum;
			$data = array(
				'price' => $old_price_update,
				'old_price' => $old_price_update
			);
			$this->location_model->updateById($article['old_section'], $data);

			$new_section = $this->location_model->getSectionById($article['location']);
			$new_price_update = $new_section['price'] + $sum;
			$data = array(
				'price' => $new_price_update,
				'old_price' => $new_price_update
			);
			$this->location_model->updateById($article['location'], $data);

			redirect("dashboard/");
		}
	}
	public function takeArticleWarehouse(){
		$id_warehouse = $this->input->post('id_warehouse');
		$article = $this->warehouse_model->getWarehouseByKey('id',$id_warehouse);
		echo json_encode($article);

	}

	public function search_article(){
		$article_id = $this->uri->segment(3);
		$s_number = $this->uri->segment(4);
		$articles = $this->warehouse_model->getWarehouseBySNumber($s_number, $article_id);
		$color = $this->settings_model->getColor();
		$location = $this->location_model->getSection();
		$area = $this->area_model->getArea();
		$data = array(
			"content"	=> "warehouse_product_out",
			"tab"       => "Изнеси артикли",
			"title"    =>  "Припрема листа за вадење артикли",
			"articles" => $articles,
			"technical_images"   =>$this->technical_images,
			"color" => $color,
			"area"      =>$area,
			"location"  =>$location

		);
		$this->load->view('template',$data);

	}
	function list_view(){
		$is = $this->uri->segment(3);
		$list = $this->issueslip_model->viewlist($is);
		$user_info= $this->session->userdata('user_info');
		$active = $this->issueslip_model->checkActive($user_info['user_id']);
		if($active) {
			$data = array(
				"content" => "view_list",
				"tab" => "Листа на артикли за излез",
				"title" => "Листа на артикли за излез",
				"list" => $list,
				"active"=> $active,
				"is"=>$is

			);
		}
		else{
			$data = array(
				"content"	=> "error_page",
				"tab"       => "Грешка",
				"error_message" => "Непости листа за излез за соодветниот корисник. Контактирјте админ"
			);
		}
		$this->load->view('template',$data);



	}
	public function warehouse(){
		$location = $this->location_model->getSection();
		$area = $this->area_model->getArea();
		$article_in_stock = $this->warehouse_model->selectDistinct('article_name');
		$color = $this->settings_model->getColor();
		$warehouse_article = $this->warehouse_model->getWarehouse();
		$data = array(
			"content"	=> "warehouse",
			"tab"       => "Преглед на  артикли во склад",
			"title"       => "Преглед на артикли во склад",
			"location"  => $location,
			"area"      => $area,
			"warehouse_article" => $warehouse_article,
			"technical_images"   =>$this->technical_images,
			"article_in_stock" => $article_in_stock,
			"color" => $color


		);
		$this->load->view('template',$data);
	}
	public function search_warehouse(){
		$s_number = $_POST['serial_number'];
		echo $s_number;
		$article_ids = $this->warehouse_model->selectDistinct('article_id', 'serial_number', $s_number);
		$ids = array();
		foreach($article_ids as $a){
			$ids[] = $a['article_id'];
		}
		$articles = array();
		if(!empty($article_ids)){
			$articles = $this->article_model->getArticleByIDs($ids, true);
		}

		$user_info= $this->session->userdata('user_info');



		$active = $this->issueslip_model->checkActive($user_info['user_id']);
		$is = '';

		if($active){
			$is_array = $this->issueslip_model->selectActive($user_info['user_id']);
			$is = $is_array['id'];
		}
		$data = array(
			"content"	=> "warehouse_out",
			"tab"       => "Припрема за излазница",
			"title"     => "Припрема за излазница",
			"articles"   => $articles,
			"s_number" => $s_number,
			"active"=> $active,
			"is"=>$is

		);
		$this->load->view('template',$data);

	}
	function change_width(){
		$new_data = $this->input->post();
		$data = array(
			     "width" => $new_data['width']
		);
		$this->warehouse_model->update('id',$new_data['id'],$data);

		$result = array('return'=>'success');
		echo json_encode($result);
	}


}
