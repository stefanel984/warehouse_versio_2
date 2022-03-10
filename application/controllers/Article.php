<?php

class Article extends MY_Controller
{

	function __construct() {
		parent::__construct();
	}
	function index(){
		$measure = $this->settings_model->getMeasure();
		$data = array(
			"content" => "add_article",
			"tab" => "Додади артикл",
			"title" => "Додади артикл",
			"measure" => $measure

		);
		$this->load->view('template', $data);
	}
	function add_article(){
		$article = $this->input->post();
		$measure = $this->settings_model->getMeasure();
		if($article['article'] != '' &&  $article['measure'] != ''){
			if(!isset($article['width'])){
				$article['width'] = 0;
			}
			if(!isset($article['package_sales'])){
				$article['package_sales'] = 0;
			}
			if(!isset($article['package_qty'])){
				$article['package_qty'] = 0;
			}
			$data = array(
						   'name' => $article['article'],
						   'deleted' => 0,
						   'measure' => $article['measure'],
				           'package_sales' => $article['package_sales'],
				           'width' => $article['width'],
				           'package_qty' => $article['package_qty']
						 );
			$article_id = $this->article_model->insert($data);
			if($article_id > 0){
				redirect("settings/index");
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
	function edit_article(){
		$article_id = $this->uri->segment(3);
		$article = $this->article_model->getArticleByID($article_id);
		$measure = $this->settings_model->getMeasure();
		$data = array(
			"content" => "edit_article",
			"tab" => "Додади артикл",
			"title" => "Додади артикл",
			"measure" => $measure,
			"article" => $article

		);
		$this->load->view('template', $data);
	}
	function confirm_edit_article(){
		$article_id = $this->uri->segment(3);
		$change_article = $this->input->post();
		if(!isset($change_article['width'])){
			$change_article['width'] = 0;
		}
		if(!isset($change_article['package_sales'])){
			$change_article['package_sales'] = 0;
		}
		if(!isset($change_article['package_qty'])){
			$change_article['package_qty'] = 0;
		}
		$data = array(
			'measure' => $change_article['measure'],
			'package_sales' => $change_article['package_sales'],
			'width' => $change_article['width'],
			'package_qty'=> $change_article['package_qty']
		);
		$this->article_model->update('id',$article_id, $data);

		redirect("settings/index");


	}
	function getArticle(){
		$id_article = $this->input->post('id');
		$result = $this->article_model->getArticleByID($id_article);
		$res = json_encode($result);
		echo $res;

	}
	function getAllArticleSelect(){
		$article = $this->article_model->getArticle();
		$html = '';
		$html .= '<script src="'.base_url().'js/insert_article.js"></script>';
		$html .= '
		           <select name="article[]" class="article_in" style="width: 100%;" required>
		           <option value="">--избери артикл--</option>';
		           foreach($article as $a) {
					   $html .= '<option value ="' . $a['id'] . '">' . $a['name'] . '</option>';
                   }


        $html .= '</select>';
		echo $html;
	}
	function getAllArticleProductSelect(){

		$article = $this->article_model->getArticle();
		$html = '';
		$html .= '
		           <select name="article[]" class="article_in" style="width: 100%;" required>
		           <option value="">--избери артикл--</option>';
		foreach($article as $a) {
			$html .= '<option value ="' . $a['id'] . '">' . $a['name'] . '</option>';
		}


		$html .= '</select>';
		echo $html;

	}
	function getAllArticle(){
		$article = $this->article_model->getArticle();
		$article_array = array();
		foreach($article as $a) {
			$measure_details = $this->settings_model->getMeasureById($a['measure']);
			$a['measure_name'] = $measure_details;
			$a['has_width'] = 0;
			if($a['width'] == '1'){
				$a['has_width'] = 1;
			}
			$a['add_package_qty'] = 0;
			if($a['package_qty'] == '1'){
				$a['add_package_qty'] = 1;
			}
			$article_array[$a['id']] = $a;
		}
		$res = json_encode($article_array);
		echo $res;

	}


}
?>





