<?php


class Pdfprint extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

// add library of Pdf
		$this->load->library('Pdf');
	}

	function index()
	{
// coder for CodeIgniter TCPDF Integration
		$tcpdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
// Set Title
		$tcpdf->SetTitle('Pdf Example onlinecode');
// Set Header Margin
		$tcpdf->SetHeaderMargin(30);
// Set Top Margin
		$tcpdf->SetTopMargin(20);
// set Footer Margin
		$tcpdf->setFooterMargin(20);
// Set Auto Page Break
		$tcpdf->SetAutoPageBreak(true);
// Set Author
		$tcpdf->SetAuthor('onlinecode');
// Set Display Mode
		$tcpdf->SetDisplayMode('real', 'default');
// Set Write text
		$tcpdf->Write(5, 'CodeIgniter TCPDF Integration - onlinecode');
// Set Output and file name
		$tcpdf->Output('tcpdfexample-onlinecode.pdf', 'I');
	}


	function printPDF(){
		$list_id = $this->uri->segment(3);
		$items = $this->issueslip_model->viewlist($list_id);
		$list_details = $this->issueslip_model->getList('id',$list_id);
		$weight_list  = $this->issueslip_model->getWeightList($list_id);
		$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


		$tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,65,256), array(0,65,127));
		$tcpdf->setFooterData(array(0,65,0), array(0,65,127));

//set header  textual styles
		$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//set footer textual styles
		$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set default monospaced textual style
		$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set default margins
		$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// Set Header Margin
		$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// Set Footer Margin
		$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto for page breaks
		$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image for scale factor
		$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$tcpdf->SetFont('dejavusans', '', 8, '', true);

		$weight_row = array();
		foreach($weight_list as $w){
			$res_article = $this->article_model->getArticleByID($w['article_id'], true);
			$article_name = $res_article[0]['name'];
			if(array_key_exists($article_name, $weight_row)){
				$weight_row['brutto'][$article_name] = $weight_row['brutto'][$article_name] + $w['brutto'];
				$weight_row['netto'][$article_name] = $weight_row['netto'][$article_name] + $w['netto'];
			}
			else{
				$weight_row['brutto'][$article_name] = $w['brutto'];
				$weight_row['netto'][$article_name] = $w['netto'];
			}


		}


		$p = 0;
		$c = count($items);
		$total = 0;
		$sum_array =  array();
		$sum_price =  array();
		$sum_width =  array();
		$measure_array = array();
		$section_array = array();
		$sum_section_array = array();
		$sum_measure_array = array();
		$sum_width_array = array();
		$sum_price_array = array();
		$sum_row = array();
		$product_by_price = array();
		foreach($items as $i){
			if($p%15==0){
				$tcpdf->AddPage();
				$date=date_create($list_details[0]['date']);
				$date_entered =  date_format($date,"d/m/Y H:i:s");
				$created_by= $this->admin_model->getUserById($list_details[0]['created_by']);
				$title = "<h1 style = 'text-align: center;'>Картон број:".$list_details[0]['list_number']."</h1>";
				$tcpdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);
				$details = "<br/><br/> Датум на креирање <b>".$date_entered."</b>";
				$details .= "<br/> Kреирано од <b>".$created_by['full_name']."</b>";
				$tcpdf->writeHTMLCell(0, 0, '', '', $details, 0, 1, 0, true, 'L', true);
				$html = '<br><br/><table cellspacing="0" cellpadding="1" border="1">';
				$html .= '<tr>
                              <td width="30" align="center" style="font-size: 12px;"></td>
							  <td  width="100" align="center" style="font-size: 12px;">Артикл</td>
							  <td width="100" align="center" style="font-size: 12px;">Боја</td>
							  <td width="95" align="center" style="font-size: 12px;">Единечна цена</td>
							  <td width="80" align="center" style="font-size: 12px;">Количина</td>
							  <th width="75" align="center" style="font-size: 12px;">Количина во пакет</th>
							  <td width="90" align="center" style="font-size: 12px;">Површина</td>
							  <td width="90" align="center" style="font-size: 12px;">Цена</td>';

				$html .= '</tr>';
			}
			$p++;
			$color = $this->settings_model->getColor($i['color']);
			$merka =  $this->settings_model->getMeasureById($i['measure_id']);
			if(array_key_exists($i['article_name'], $sum_array)){
				$sum_array[$i['article_name']] = $sum_array[$i['article_name']]  + $i['qty'];
				$sum_price[$i['article_name']] = $sum_price[$i['article_name']]  + round($i['price_total'],2);
				$sum_width[$i['article_name']] = $sum_width[$i['article_name']]  + $i['qty'] * $i['width'];
				$sum_row[$i['article_name']] = $sum_row[$i['article_name']] + 1;
			}
			else{
				$sum_array[$i['article_name']]  = $i['qty'];
				$sum_price[$i['article_name']] = round($i['price_total'],2);
				$sum_width[$i['article_name']] = $i['qty'] * $i['width'];
				$measure_array[$i['article_name']] =  $merka[0]['name'];
				$sum_row[$i['article_name']] =  1;
			}
			if(array_key_exists($i['section_id'], $section_array)){
				if(array_key_exists($i['article_name'], $sum_section_array[$i['section_id']])){
					$sum_section_array[$i['section_id']][$i['article_name']] = $sum_section_array[$i['section_id']][$i['article_name']] + $i['qty'];
					$sum_width_array[$i['section_id']][$i['article_name']] = $sum_width_array[$i['section_id']][$i['article_name']] + $i['qty']*$i['width'];
					$sum_price_array[$i['section_id']][$i['article_name']] = $sum_price_array[$i['section_id']][$i['article_name']] + round($i['price_total'],2);
				}
				else{
					$section_array[$i['section_id']] = $i['section_id'];
					$sum_section_array[$i['section_id']][$i['article_name']] = $i['qty'];
					$sum_width_array[$i['section_id']][$i['article_name']] = $i['qty']*$i['width'];
					$sum_measure_array[$i['section_id']][$i['article_name']] =  $merka[0]['name'];
					$sum_price_array[$i['section_id']][$i['article_name']] = round($i['price_total'],2);
				}
			}
			else{
				$section_array[$i['section_id']] = $i['section_id'];
				$sum_section_array[$i['section_id']][$i['article_name']] = $i['qty'];
				$sum_width_array[$i['section_id']][$i['article_name']] = $i['qty']*$i['width'];
				$sum_measure_array[$i['section_id']][$i['article_name']] =  $merka[0]['name'];
				$sum_price_array[$i['section_id']][$i['article_name']] = round($i['price_total'],2);
			}
			if(array_key_exists($i['article_name'], $product_by_price)){
				if(array_key_exists($i['price_per_piece'], $product_by_price[$i['article_name']])){
					$product_by_price[$i['article_name']][$i['price_per_piece']]['price_total'] = $product_by_price[$i['article_name']][$i['price_per_piece']]['price_total'] +  round($i['price_total'],2);
					$product_by_price[$i['article_name']][$i['price_per_piece']]['qty'] = $product_by_price[$i['article_name']][$i['price_per_piece']]['qty'] + $i['qty'];
					$product_by_price[$i['article_name']][$i['price_per_piece']]['width'] = $product_by_price[$i['article_name']][$i['price_per_piece']]['width'] + $i['qty']*$i['width'];
				}
				else{
					$product_by_price[$i['article_name']][$i['price_per_piece']]['price_total'] = round($i['price_total'],2);
					$product_by_price[$i['article_name']][$i['price_per_piece']]['qty'] = $i['qty'];
					$product_by_price[$i['article_name']][$i['price_per_piece']]['width'] = $i['qty']*$i['width'];
					$product_by_price[$i['article_name']][$i['price_per_piece']]['meassure'] = $merka;
				}
			}
			else{
				$product_by_price[$i['article_name']][$i['price_per_piece']]['price_total'] = round($i['price_total'],2);
				$product_by_price[$i['article_name']][$i['price_per_piece']]['qty'] = $i['qty'];
				$product_by_price[$i['article_name']][$i['price_per_piece']]['width'] = $i['qty']*$i['width'];
				$product_by_price[$i['article_name']][$i['price_per_piece']]['meassure'] = $merka;
			}
			$width = $i['qty'] * $i['width'];
			if($width == 0){
				$width = '-';
			}
			$package = $i['package'];
			if($package == 0){
				$package = '-';
			}
			$html .= '<tr>
                              <td width="30" align="center" style="font-size: 15px;">'.$p.'</td>
							  <td  width="100" align="center" style="font-size: 15px;">'.$i['article_name'].'</td>
							  <td width="100" align="center"  style="font-size: 15px;">'.$color[0]['name'].'</td>
							  <td width="95" align="center" style="font-size: 15px;">'.number_format($i['price_per_piece'],2,',','.').' USD</td>
							  <td width="80" align="center" style="font-size: 15px;">'.$i['qty'].' ' .$merka[0]['name'].'</td>
							   <th width="75" align="center" style="font-size: 15px;">'.$package.'</th>
							  <td width="90" align="center" style="font-size: 15px;">'.$width.' m2</td>
							  <td width="90" align="center"  style="font-size: 15px;">'.number_format($i['price_total'],2,',','.').' USD</td>';

			$html .= '</tr>';
			$total = $total + $i['price_total'];



			if(($p%15==0) || ($p == $c)){
				$html .= '</table>';
				$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			}

		}
		$total_text = 'Вкупно цена  <b>'.$total.' USD</b>';
		$tcpdf->writeHTMLCell(0, 0, '', '', $total_text, 0, 1, 0, true, 'R', true);

		$tcpdf->AddPage();
		$title = "<h1 style = 'text-align: center;'>Вкупно ролни</h1>";
		$tcpdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);

		$html = '<br><br/><table cellspacing="0" cellpadding="0" border="0">';
		$html .= '<tr>
                              <td width="85" align="center"><b>Производ</b></td>
							  <td  width="85" align="center">Количина</td>
							  <td  width="85" align="center">Цена</td>
							  <td  width="85" align="center">Површина</td>
							  <td  width="85" align="center">Бруто</td>
							  <td  width="85" align="center">Нето</td>
							  <td  width="85" align="center">Број ролни</td>';


		$html .= '</tr>';
		foreach ($sum_array as $key => $sum) {
			$html .= '<tr>
                              <td width="85" align="center"><b>'.$key.'</b></td>
							  <td  width="85" align="center">'.$sum.'  '.$measure_array[$key].'</td>
				              <td  width="85" align="center">'.number_format($sum_price[$key],'2',',','.').'USD</td>
				              <td  width="85" align="center">'.$sum_width[$key].'m2</td>
				              <td  width="85" align="center">'.ceil($weight_row['brutto'][$key]).'kg</td>
				              <td  width="85" align="center">'.ceil($weight_row['netto'][$key]).'kg</td>
				              <td  width="85" align="center">'.$sum_row[$key].'</td>';

			$html .= '</tr>';

		}
		$html .= '</table>';
		$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


		$tcpdf->AddPage();
		$title = "<h1 style = 'text-align: center;'>Ролни по единечна цена</h1>";
		$tcpdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);


		$html = '<br><br/><table cellspacing="0" cellpadding="0" border="0">';
		foreach($product_by_price as $name => $p_array ){
			$html .= '<tr>
                              <td width="300" ></td>
                               <td width="300"><b>Ролна '.$name.'</b></td>';

			$html .= '</tr>';
			$html .= '<tr>
                              <td width="150" align="center"><b>Единечна</b></td>
							  <td width="150" align="center">Количина</td>
							  <td width="150" align="center">Површина</td>
							  <td width="150" align="center">Тотал цена</td>';


			$html .= '</tr>';
		    foreach($p_array as $price=>$product_price){
				$html .= '<tr>
                              <td width="150" align="center">'.$price.'USD</td>
							  <td  width="150" align="center">'.number_format($product_price['qty'],'2',',','').'  '.$product_price['meassure'][0]['name'].'</td>
							  <td  width="150" align="center">'.number_format($product_price['width'],'2',',','').'m2</td>
							  <td  width="150" align="center">'.number_format($product_price['price_total'],'2',',','.').'USD</td>';

				$html .= '</tr>';
            }

		}
		$html .= '</table>';
		$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$tcpdf->AddPage();
		$title = "<h1 style = 'text-align: center;'>Ролни по локација</h1>";
		$tcpdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);


		$html = '<br><br/><table cellspacing="0" cellpadding="0" border="0">';
		foreach($sum_section_array as $location => $location_array) {
			$section = $this->location_model->getSectionById($location);
			$html .= '<tr>
                              <td width="300" ></td>
                               <td width="300"><b>Локација '.$section['name'].'</b></td>';

			$html .= '</tr>';
			$html .= '<tr>
                              <td width="150" align="center"><b>Производ</b></td>
							  <td width="150" align="center">Количина</td>
							  <td width="150" align="center">Површина</td>
							  <td width="150" align="center">Цена</td>';


			$html .= '</tr>';
			foreach($location_array as $key=>$value){
				$html .= '<tr>
                              <td width="150" align="center"><b>'.$key.'</b></td>
							  <td  width="150" align="center">'.number_format($sum,'2',',','').'  '.$sum_measure_array[$location][$key].'</td>
							  <td  width="150" align="center">'.number_format($sum_width_array[$location][$key],'2',',','').'m2</td>
							  <td  width="150" align="center">'.number_format($sum_price_array[$location][$key],'2',',','.').'USD</td>';

				$html .= '</tr>';
			}

		}
		$html .= '</table>';
		$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


		$tcpdf->AddPage();
		$title = "<h1 style = 'text-align: center;'>Тежина </h1>";
		$tcpdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, 'C', true);

		$html = '<br><br/><table cellspacing="0" cellpadding="0" border="0">';
		$html .= '<tr>
                              <td width="150" align="center"><b>Секција</b></td>
                              <td width="150" align="center"><b>Производ</b></td>
							  <td  width="150" align="center">Бруто</td>
		                      <td  width="150" align="center">Нето</td>';

		$html .= '</tr>';
		$total_weight_netto = 0;
		$total_weight_brutto = 0;
		foreach($weight_list as $key=>$sum){
			$total_weight_brutto = $total_weight_brutto + ceil($sum['brutto']);
			$total_weight_netto = $total_weight_netto + ceil($sum['netto']);
			$result = $this->article_model->getArticleByID($sum['article_id'], true);
			$section = $this->location_model->getSectionById($sum['section_id']);
			$html .= '<tr>
                              <td width="150" align="center"><b>'.$section['name'].'</b></td>
                              <td width="150" align="center"><b>'.$result[0]['name'].'</b></td>
							  <td  width="150" align="center">'.ceil($sum['brutto']).'kg</td>
							   <td  width="150" align="center">'.ceil($sum['netto']).'kg</td>';

			$html .= '</tr>';

		}
		$html .= '<tr>
                              <td width="150" align="center"></td>
                              <td width="150" align="center"><b>Тотал</b></td>
							  <td  width="150" align="center"><b>'.$total_weight_brutto.'kg</b></td>
							   <td  width="150" align="center"><b>'.$total_weight_netto.'kg</b></td>';

		$html .= '</tr>';
		$html .= '</table>';
		$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


		$tcpdf->Output($list_details[0]['list_number'], 'I');




	}
}


