<?php


class Issueslip extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}
	function list_weight(){
		$id = $this->uri->segment(3);
		$post = $this->input->post();
		$slip_number = $post['list_number'];
		$list = $this->issueslip_model->viewlist($id);
		$list_article = array();
		$list_details = array();
		$list_section = array();
		foreach($list as $l){
			if(array_key_exists($l['section_id'], $list_section)){
				if(array_key_exists($l['article_id'], $list_article[$l['section_id']])){
					$list_article[$l['section_id']][$l['article_id']]  =  $list_article[$l['section_id']][$l['article_id']]  +  1;
					$list_details[$l['section_id']][$l['article_id']]['qty'] = $list_article[$l['section_id']][$l['article_id']];
				}
				else{
					$list_article[$l['section_id']][$l['article_id']]  =  1;
					$list_details[$l['section_id']][$l['article_id']]['name'] = $l['name'];
					$list_details[$l['section_id']][$l['article_id']]['id'] = $l['article_id'];
					$list_details[$l['section_id']][$l['article_id']]['qty'] = $list_article[$l['section_id']][$l['article_id']];

				}

			}
			else{
				$list_section[$l['section_id']] = $l['section_id'];
				$list_article[$l['section_id']][$l['article_id']]  =  1;
				$list_details[$l['section_id']][$l['article_id']]['name'] = $l['name'];
				$list_details[$l['section_id']][$l['article_id']]['id'] = $l['article_id'];
				$list_details[$l['section_id']][$l['article_id']]['qty'] = $list_article[$l['section_id']][$l['article_id']];
			}

		}
		$data = array(
			"content"	=> "list_weight",
			"tab"       => "Внеси тежини",
			"title"     => "Внеси тежини",
			"list_id"      => $id,
			"list_details" => $list_details,
			"list_article" => $list_article,
			"slip_number"   => $slip_number
		);
		$this->load->view('template',$data);

    }

	function confirm_list(){
		$post = $this->input->post();
		foreach($post['sum'] as $section => $list) {
			foreach ($list as $k => $v){
				$full_brutto = $v['brutto'];
				$brutto = ($full_brutto / $v['total_qty']);
				$brutto = $brutto * $v['qty'];
				$full_netto = $v['netto'];
				$netto = ($full_netto / $v['total_qty']);
				$netto = $netto * $v['qty'];
				$data = array(
					'article_id' => $k,
					'issue_slip_id' => $post['list_id'],
					'brutto' => $brutto,
					'netto' => $netto,
					'section_id'  => $section
				);
				$this->issueslip_model->insert_weight($data);
			}
		}
		$data = array(
			          'list_number'=>$post['list_number'],
			          'confirm'=> 1
		              );
		$this->issueslip_model->update('id',$post['list_id'], $data);
		redirect('issueslip/list');
	}

	function checkExistingCardNumber(){
		$list_number = $this->input->post('list_number');
		$cart = $this->issueslip_model->getCartInfoByKey("list_number",$list_number);
		$res = array('exist' => 'no');
		if(!empty($cart)){
			$res = array('exist' => 'yes');
		}
		echo json_encode($res);
	}

	function deleteCard(){
		$list_id = $this->input->post('list_id');
		$item = $this->issueslip_model->getItem("issue_id",$list_id);
		foreach($item as $i){
			$data = array(
				          'in_stock'=> 1,
				          'date_exit'=>null
			              );
			$this->warehouse_model->update('id',$i['warehouse_id'], $data);
			$this->issueslip_model->deleteItem("issue_id",$list_id);
			$this->issueslip_model->delete("id",$list_id);
			$data = array(
				          'action'=>'out',
				          'relation_id'=>$i['warehouse_id']

			              );
			$this->log_model->delete($data);
			$warehouse = $this->warehouse_model->getWarehouseByKey('id',$i['warehouse_id']);
			$location = $this->location_model->getSectionById($warehouse[0]['section_id']);
			$price = $location['price'] + $warehouse[0]['price_total'];
			$old_price = $location['old_price'] + $warehouse[0]['price_total'];
			$data = array(
				'price' => $price,
				'old_price' => $old_price
			);
			$this->location_model->updateById($warehouse[0]['section_id'], $data);

		}
		$user_info= $this->session->userdata('user_info');
		$active = $this->issueslip_model->checkActive($user_info['user_id']);
		if($active){
			$res = array('success' => 'no');
		}
		else{
			$res = array('success' => 'yes');
		}
		echo json_encode($res);

	}
	function list(){
		$list = $this->issueslip_model->getList('confirm', 1);
		$users = $this->admin_model->getUser();
		$data = array(
			"content"	=> "list_slip",
			"tab"       => "Преглед на  излез артикли",
			"title"     => "Преглед на излез артикли",
			"list"      => $list,
			"users"     => $users
		);
		$this->load->view('template',$data);
	}
	function all_item(){
		$list_id = $this->uri->segment(3);
		$items = $this->issueslip_model->viewlist($list_id);
		$list_details = $this->issueslip_model->getList('id',$list_id);
		$weight_list  = $this->issueslip_model->getWeightList($list_id);
		$data = array(
			"tab"       => "Картон излезен",
			"list"      => $list_id,
			"items"     => $items,
			"details"   => $list_details,
			"weight_list" => $weight_list

		);
		$this->load->view('list_item',$data);

	}

}
