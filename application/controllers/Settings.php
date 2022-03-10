<?php


class Settings extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}
	function index(){
		$color = $this->settings_model->getColor();
		$measure = $this->settings_model->getMeasure();
		$artilce = $this->article_model->getArticle(true);
		$location = $this->location_model->getSection('id_area ASC, id ASC');
		$data = array(
			"content"	=> "admin",
			"tab"       => "Администраторски панел",
			"color"    => $color,
			'measure'  => $measure,
			'article'  => $artilce,
			'location' => $location,
			'color_image' => $this->color_img

		);
		$this->load->view('template',$data);
	}
	function color(){
		$data = array(
			"content"	=> "add_color",
			"tab"       => "Додади боја",
			"title"     => "Панел боја"

		);
		$this->load->view('template',$data);
	}
	function add_color(){
		$all_img_data = $this->input->post();
		if($all_img_data['color'] != '') {
			$all_color = $this->settings_model->getColor();
			$exist = false;
			foreach($all_color as $col){
				if($col['name'] == $all_img_data['color']){
					$exist = true;
					break;
				}
			}
			if($exist == false) {

					$config['upload_path']          = './images/color';
					$config['allowed_types']        = 'gif|jpg|png|jpeg';

					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('color_img'))
					{
						$error = array('error' => $this->upload->display_errors());


						$data = array(
							"content"	=> "error_page",
							"tab"       => "Грешка",
							"error_message" => $error['error']
						);
						$this->load->view('template',$data);
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());

						$config['image_library'] = 'gd2';
						$config['source_image'] = './images/color/'.$data['upload_data']['file_name'];
						$config['create_thumb'] = false;
						$config['maintain_ratio'] = false;
						$config['width']         = 100;
						$config['height']       = 100;

						$this->load->library('image_lib', $config);

						$this->image_lib->resize();

						rename($data['upload_data']['full_path'],$data['upload_data']['file_path'].$all_img_data['color'].$data['upload_data']['file_ext']);

						$data = array(
							'name' => $all_img_data['color'],
							'img'  => $all_img_data['color'].$data['upload_data']['file_ext']
						);
						$color_id = $this->settings_model->addColor($data);
						if ($color_id > 0) {
							redirect("settings/index");
						}
					}





			}
			else{
				$data = array(
					"content" => "add_color",
					"tab" => "Додади боја",
					"title" => "Панел боја",
					"error" => 'Постоечка боја, внесете друга'

				);
				$this->load->view('template', $data);

			}
		}
		else{
			$data = array(
				"content" => "add_color",
				"tab" => "Додади боја",
				"title" => "Панел боја",
				"error" => 'Грешка! Контактирај администратор!'

			);
			$this->load->view('template', $data);

		}
	}
	function measure(){
		$data = array(
			"content"	=> "add_measure",
			"tab"       => "Додади мерка",
			"title"     => "Панел мерка"

		);
		$this->load->view('template',$data);
	}
	function add_measure(){
		$all_measure_details =  $this->input->post();
		if($all_measure_details['measure'] != ''){

			$data = array(
				'name' => $all_measure_details['measure'],
				'symbol' => $all_measure_details['measure']
			);
			$measure_id = $this->settings_model->addMeasure($data);
			if ($measure_id > 0) {
				redirect("settings/index");
			}

		}
		else{
			$data = array(
				"content"	=> "add_measure",
				"tab"       => "Додади мерка",
				"title"     => "Панел мерка",
				"error" => 'Грешка! Контактирај администратор!'

			);
			$this->load->view('template', $data);

		}
	}
	function getMeasureByID(){
		$id_measure = $this->input->post('id');
		$result = $this->settings_model->getMeasureById($id_measure);
		$res = json_encode($result);
		echo $res;
	}
	function getAllColor(){
		$result = $this->settings_model->getColor();
		$res = json_encode($result);
		echo $res;
	}
	function getAllColorSelect(){
		$color = $this->settings_model->getColor();
		$html = '';
		$html .= '
		           <select name="color[]" class="choice_color" style="width: 100%;" required>
		           <option value="">--избери боја--</option>';
		foreach($color as $c) {
			$html .= '<option value ="' . $c['id'] . '">' . $c['name'] . '</option>';
		}


		$html .= '</select>';
		echo $html;
	}
	function error(){
		$data = array(
			"content"	=> "error_page",
			"tab"       => "Грешка",
			"error_message" => "Грешка при внесувањето податоци!!! Контактирјте админ"
		);
		$this->load->view('template',$data);
	}
	function settings_update(){
		$post = $this->input->post();
		if($post['type'] == 'article'){
			if($post['action'] == 'delete'){
				$data = array(
					         'deleted' => 1,
				             );
			}
			else{
				$data = array(
					'deleted' => 0,
				);

			}

			$key = 'id';
			$value = $post['id'];
			$this->article_model->update($key, $value, $data);
			$result = array('return'=>true);

			$res = json_encode($result);
			echo $res;
		}

	}
	function document_update(){
		$post = $this->input->post();
		if($post['type'] == 'document'){
			if($post['action'] == 'delete'){
				$data = array(
					'deleted' => 1,
				);
			}
			else{
				$data = array(
					'deleted' => 0,
				);

			}

			$key = 'id';
			$value = $post['id'];
			$this->settings_model->updateDocType($key, $value, $data);
			$result = array('return'=>true);

			$res = json_encode($result);
			echo $res;
		}

	}
	function addDocType(){
		$type = $this->input->post('type');

		$data = array('document_type' => $type);
		$id = $this->settings_model->insertDocType($data);

		if($id > 0){
			$result = array('return'=>true,'id'=>$id,'type'=>$type);
		}
		else{
			$result = array('return'=>false, 'message'=>'Грешка при внесување тип на документ');
		}

		$res = json_encode($result);
		echo $res;



	}
	function document(){
		$document_type = $this->settings_model->getDocType();
		$data = array(
			"content"	=> "document_settings",
			"tab"       => "Админ документи",
			"document_type"    => $document_type,
		);
		$this->load->view('template',$data);

	}

	function getAllMeasure(){
		$measure = $this->settings_model->getAllMeasure();
		$html = '';
		$html .= '
		           <select name="measure[]" class="choice_measure" style="width: 100%;" required>
		           <option value="">--мерка--</option>';
		foreach($measure as $m) {
			$html .= '<option value ="' . $m['id'] . '">' . $m['name'] . '</option>';
		}
		$html .= '</select>';
		echo $html;
	}

}
