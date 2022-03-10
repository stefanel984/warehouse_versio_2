<?php
function merka($id){
	$measure = new Settings_model();
	$result = $measure->getMeasureById($id);

	return $result[0]['name'];

}
function currency($currency){
	switch ($currency) {
		case "eur":
			$res = "EUR";
			break;
		case "usd":
			$res = "USD";
			break;
		default:
			$res='';

	}
	return $res;
}
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
function inStock($s_number, $article_id){
	$warehouse = new Warehouse_model();
	$result = $warehouse->getWarehouseBySNumber($s_number, $article_id);
	return count($result);

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<input id="s_number" name="s_number" class="form-control" value="" placeholder="Пребарај по S број">
		    <br/><br/>
			<label for="article_used">Артикл:</label>
			<select id="article_used" name="article_used">
				<option value="">--избери артикл--</option>
				<?php
				foreach($article as $a){
					?>
					<option value="<?php echo $a['name']; ?>"><?php echo $a['name']; ?></option>

					<?php
				}
				?>

			</select>
			<br/>
			<br/>
		</div>
		<div class="col-sm-1"></div>
	</div>

	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="product_detail" class="display table" style="width:100%">
				<thead>
				<tr>
					<th></th>
					<th>S број</th>
					<th>Т број</th>
					<th>Креирано од</th>
					<th>Артикл</th>
					<th>Мерка</th>
					<th>Набавна цена</th>
					<th>Курс</th>

				</tr>
				</thead>
				<tbody>
				<?php
				foreach($product as $p){
					$merka = merka($p['merka']);
					$currency = currency($p['currency']);
					$date=date_create($p['date_entered']);
					$date_entered =  date_format($date,"d/m/Y H:i:s");
					$timestamp = date_timestamp_get($date);
				?>
					<tr>
						<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered;  ?></td>
						<td><?php echo $p['s_number'];?></td>
						<td><?php echo $p['t_number'];?></td>
						<td><?php echo userName($p['created_by']);  ?></td>
						<td><?php echo $p['name'];?></td>
						<td><?php echo $p['qty'].' '.$merka;?></td>
						<td><?php echo $p['price'].' '. $currency;?></td>
						<td><?php echo $p['exchange'];?></td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
