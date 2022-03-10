<?php


class Log extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index(){
		$all_log = $this->log_model->getLog();
		$users = $this->admin_model->getUser();
		$data = array(
			"content"	=> "log",
			"tab"       => "Логови",
			"title"    =>  "Логови",
			"logs"    => $all_log,
			"users"  => $users
		);
		$this->load->view('template',$data);
	}
	function log_detail(){
		$id= $this->input->post('id');
		$article = $this->warehouse_model->getWarehouseByKey('id',$id, true);
		$html = "<table id='table_log_details_view'>
                      <tr>
							  <td>Сериски број</td>
							  <td>Артикл</td>
							  <td>Боја</td>
							  <td>Датум на внес</td>
							  <td>Датум на излез</td>
							  <td>Количина</td>
							  <td>Вредност</td>
							  <td>Статус</td> 
					  </tr>";
		$in_stock = 'Извадена';
		if($article[0]['in_stock'] == 1){
			$in_stock = 'На локација';
		}
		$color = $this->settings_model->getColor($article[0]['color']);
		$date=date_create($article[0]['date_entered']);
		$date_entered =  date_format($date,"d/m/Y H:i:s");
		$date_exit = '';
		if($article[0]['date_exit'] != '') {
			$date = date_create($article[0]['date_exit']);
			$date_exit = date_format($date, "d/m/Y H:i:s");
		}
		$html .= "      <tr>
							  <td>".$article[0]['serial_number']."</td>
							  <td>".$article[0]['article_name']."</td>
							  <td>".$color[0]['name']."</td>
							  <td>".$date_entered."</td>
							  <td>".$date_exit."</td>
							  <td>".$article[0]['qty']."</td>
							  <td>".$article[0]['price_total']." USD</td>
							  <td>".$in_stock."</td>  
					   </tr>";

        $html .= "</table>";

		echo $html;
	}



}
