<?php


class Product extends MY_Controller
{

	function __construct() {
		parent::__construct();
	}

	function add_product(){
		$article = $this->article_model->getArticle();
		$color = $this->settings_model->getColor();
		$data = array(
			"content"	=> "product_in",
			"tab"       => "Внес карактеристики артикли",
			"title"     => "Внес карактеристики артикли",
			"article"   =>$article,
			"color"     =>$color

		);
		$this->load->view('template',$data);
	}
	function view_product(){
		$product = $this->product_model->getProductByID();
		$article = $this->product_model->selectDistinct();
		$data = array(
			"content"	=> "product_view",
			"tab"       => "Преглед карактеристики артикли",
			"title"     => "Преглед карактеристики артикли",
			"product"   => $product,
			"article"   => $article

		);
		$this->load->view('template',$data);
	}
	function add_in_product(){
		$product = $this->input->post();
		echo "<br/><br/>";
		if($product['number_of'] != 0) {
			for ($i = 0; $i < $product['number_of']; $i++) {
				$article_details = $this->article_model->getArticleByID($product['article'][$i]);
				$name = $article_details[0]['name'];
				$merka = $product['measure'][$i];
				$price= $product['price'][$i];
				$exchange = $product['exchange'][$i];
				$price_mkd = floatval($price) * floatval($exchange);
				$data = array(
					'name' => $name,
					'article' => $product['article'][$i],
					'currency' => $product['currency'][$i],
					'exchange' => $exchange,
					'merka' => $merka,
					'qty'=> $product['quantity'][$i],
					's_number'=> $product['s_number'][$i],
					't_number'=> $product['t_number'][$i],
					'price'=> $price,
					'price_mkd' => $price_mkd,
					'created_by' => $this->user_info['user_id'],
					'date_entered' => date("Y-m-d H:i:s")
				);
				$this->product_model->insert($data);

			}

			redirect("product/view_product");

		}
		else{
			redirect("settings/error/");
		}
	}

}
