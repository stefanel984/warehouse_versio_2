<?php
function merka($id){
	$measure = new Settings_model();
	$result = $measure->getMeasureById($id);

	return $result[0]['name'];

}
function color($id){
	$measure = new Settings_model();
	$result = $measure->getColor($id);

	return $result[0]['name'];

}
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
function getArticle($article_id){
	$article = new Article_model();
	$result = $article->getArticleByID($article_id,true);
	return $result[0]['name'];

}
function location($id){
	$loc = new Location_model();
	$loc_details = $loc->getSectionById($id);
	return $loc_details['name'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $tab;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
	<script src="<?php echo base_url();?>js/general.js"></script>
	<script src="<?php echo base_url();?>js/function.js"></script>
	<script src="<?php echo base_url();?>js/dashboard.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
	<script type="text/javascript" src="<?php echo base_url();?>js/DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/DataTables/datatables.min.css"/>
	<link type="text/css" href="<?php echo base_url();?>css/main_menu.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url();?>css/main.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url();?>css/dashboard.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
	<style>
		.title{
			font-weight: bold;
			text-transform: uppercase;
		}
		.border_all{
			border: 1px solid #000000;
		}
		.logo{
			height: 75px;
		}
	</style>


</head>
<body>
<div class="row top-margin20">
	<div class="col-sm-5"></div>
	<div class="col-sm-2 title"><b>Картон број <?php echo $details[0]['list_number'];  ?></b></div>
	<div class="col-sm-5"></div>
</div>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8 border_all logo">Дел со лого</div>
	<div class="col-sm-2"></div>
</div>
<?php
  $date=date_create($details[0]['date']);
  $date_entered =  date_format($date,"d/m/Y H:i:s");
  $user =  userName($details[0]['created_by']);
?>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-3">Датум на креирање:<b> <?php echo $date_entered; ?></b></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-3">Креирано од:<b> <?php echo $user; ?></b></div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<table border="1" width="100%">
			<thead>
				<tr>
					<th width="5%"></th>
					<th width="20%">Артикл</th>
					<th width="15%">Боја</th>
				    <th width="15%">Цена единечна</th>
				    <th width="10%">Количина</th>
					<th width="10%">Количина во пакет</th>
					<th width="10%">Површина</th>
				    <th width="15%">Цена</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$weight_row = array();
			foreach($weight_list as $w){
				$article_name = getArticle($w['article_id']);
				if(array_key_exists($article_name, $weight_row)){
					$weight_row['brutto'][$article_name] = $weight_row['brutto'][$article_name] + $w['brutto'];
					$weight_row['netto'][$article_name] = $weight_row['netto'][$article_name] + $w['netto'];
					}
				else{
					$weight_row['brutto'][$article_name] = $w['brutto'];
					$weight_row['netto'][$article_name] = $w['netto'];
					}


			}
            $price = 0;
            $count = 0;
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
				$merka = merka($i['measure_id']);
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
					$measure_array[$i['article_name']] =  $merka;
					$sum_row[$i['article_name']] = 1;
				}
			    if(array_key_exists($i['section_id'], $section_array)){
			    	if(array_key_exists($i['article_name'], $sum_section_array[$i['section_id']])){
						$sum_section_array[$i['section_id']][$i['article_name']] = $sum_section_array[$i['section_id']][$i['article_name']] + $i['qty'];
						$sum_price_array[$i['section_id']][$i['article_name']] = $sum_price_array[$i['section_id']][$i['article_name']] + round($i['price_total'],2);
						$sum_width_array[$i['section_id']][$i['article_name']] = $sum_width_array[$i['section_id']][$i['article_name']] + $i['qty']*$i['width'];
					}
			    	else{
						$section_array[$i['section_id']] = $i['section_id'];
						$sum_section_array[$i['section_id']][$i['article_name']] = $i['qty'];
						$sum_price_array[$i['section_id']][$i['article_name']] = round($i['price_total'],2);
						$sum_width_array[$i['section_id']][$i['article_name']] = $i['qty']*$i['width'];
						$sum_measure_array[$i['section_id']][$i['article_name']] =  $merka;
					}
				}
			    else{
					$section_array[$i['section_id']] = $i['section_id'];
					$sum_section_array[$i['section_id']][$i['article_name']] = $i['qty'];
					$sum_width_array[$i['section_id']][$i['article_name']] = $i['qty']*$i['width'];
					$sum_measure_array[$i['section_id']][$i['article_name']] =  $merka;
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


				$price = $price + $i['price_total'];
				$count++;
				$color = color($i['color']);
                $width = $i['qty'] * $i['width'];
                if($width == 0){
                	$width = '-';
				}
				$package = $i['package'];
				if($package == 0){
					$package == '-';
				}
				?>
			     <tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $i['article_name']; ?></td>
					<td><?php echo $color; ?></td>
					<td><?php echo number_format($i['price_per_piece'],'2',',','.'); ?> USD</td>
					<td><?php echo $i['qty'].' '.$merka; ?></td>
					 <td><?php echo $package ?></td>
					<td><?php echo $width.' m2 ' ?></td>
					<td><?php echo number_format($i['price_total'],'2',',','.'); ?> USD</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="4"></td>
				<td colspan="3"><b>Вкупно цена:</b></td>
				<td><?php echo number_format($price,'2',',','.'); ?> USD</td>
			</tr>
			</tfoot>
		</table>
	</div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><b>Вкупно</b></div>
	<div class="col-sm-4"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<table border="0" width="100%">
			<tr>
				<td><b>Производ</b></td>
				<td>Количина</td>
				<td>Површина</td>
				<td>Цена</td>
				<td>Бруто</td>
				<td>Нето</td>
				<td>Број ролни</td>
			</tr>
			<?php foreach($sum_array as $key=>$sum){ ?>
				<tr>
					<td><b><?php echo $key ?></b></td>
					<td><?php echo $sum.'  '.$measure_array[$key]; ?></td>
					<td><?php echo $sum_width[$key]; ?>m2</td>
					<td><?php echo number_format($sum_price[$key],'2',',','.') ?>USD</td>
					<td><?php echo ceil($weight_row['brutto'][$key]); ?> kg</td>
					<td><?php echo ceil($weight_row['netto'][$key]); ?> kg</td>
					<td><?php echo $sum_row[$key]; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><b>Ролни по единечна цена</b></div>
	<div class="col-sm-4"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
			<?php foreach($product_by_price as $name => $p_array){?>
				<div class="row top-margin60">
					<div class="col-sm-4"></div>
					<div class="col-sm-4"><b>Ролна <?php  echo $name; ?></b></div>
					<div class="col-sm-4"></div>
				</div>

				<table border="0" width="100%">
						<tr>
							<td>Единечна цена</td>
							<td>Количина</td>
							<td>Површина</td>
							<td>Тотал Цена</td>
						</tr>
						<?php foreach($p_array as $price=>$product_price){ ?>
							<tr>
								<td><?php echo $price; ?> USD</td>
								<td><?php echo number_format($product_price['qty'],'2',',','').'  '.$product_price['meassure'] ?></td>
								<td><?php echo number_format($product_price['width'],'2',',','').'m2'; ?></td>
								<td><?php echo number_format($product_price['price_total'],'2',',','.') ?>USD</td>
							</tr>
						<?php } ?>
				</table>
			<?php } ?>

	</div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><b>Ролни по локација</b></div>
	<div class="col-sm-4"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<?php foreach($sum_section_array as $location => $location_array){?>
			<div class="row top-margin60">
				<div class="col-sm-4"></div>
				<div class="col-sm-4"><b>Локација <?php echo location($location); ?></b></div>
				<div class="col-sm-4"></div>
			</div>

			<table border="0" width="100%">
				<tr>
					<td><b>Производ</b></td>
					<td>Количина</td>
					<td>Површина</td>
					<td>Цена</td>
				</tr>
				<?php foreach($location_array as $key=>$sum){ ?>
					<tr>
						<td><b><?php echo $key ?></b></td>
						<td><?php echo number_format($sum,'2',',','').'  '.$sum_measure_array[$location][$key]; ?></td>
						<td><?php echo number_format($sum_width_array[$location][$key],'2',',','').'m2'; ?></td>
						<td><?php echo number_format($sum_price_array[$location][$key],'2',',','.') ?>USD</td>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>

	</div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><b>ТЕЖИНА</b></div>
	<div class="col-sm-4"></div>
</div>

<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<table border="0" width="100%">
			<tr>
				<td><b>Поле</b></td>
				<td><b>Производ</b></td>
				<td>Teжина бруто</td>
				<td>Teжина нето</td>
			</tr>
			<?php
			$total_weight_brutto = 0;
			$total_weight_netto = 0;
			foreach($weight_list as $key=>$sum){
				$total_weight_brutto = $total_weight_brutto + ceil($sum['brutto']);
				$total_weight_netto = $total_weight_netto   + ceil($sum['netto']);
				?>
				<tr>
					<td><b><?php echo location($sum['section_id']); ?></b></td>
					<td><b><?php echo getArticle($sum['article_id']); ?></b></td>
					<td><?php echo ceil($sum['brutto']); ?> kg</td>
					<td><?php echo ceil($sum['netto']); ?> kg</td>
				</tr>
			<?php } ?>
			<tr>
				<td></td>
				<td><b>ТОТАЛ</b></td>
				<td><?php echo $total_weight_brutto; ?> kg</td>
				<td><?php echo $total_weight_netto; ?> kg</td>
			</tr>
		</table>
	</div>
		<div class="col-sm-2"></div>
</div>


</body>
