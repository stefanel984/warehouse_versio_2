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

if (!isset($s_number)) {
	$s_number = '';
}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row">
		<div class="col-sm-9"></div>
		<div class="col-sm-3">
			<?php if($active){ ?>
				<a href="<?php echo base_url()?>warehouse/list_view/<?php echo $is?>">Имате активна листа на артикли</a>
		    <?php } ?>
		</div>
	</div>
	<div class="row top-margin60">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-12">
					<form method="post" action="<?php  echo base_url().'warehouse/search_warehouse' ?>">
						<p>Пребарај по S number:</p><br>
						<label for="location">S-број:</label>
						<select id="serial_number" name="serial_number">
							<option value="">--избери S број--</option>
							<?php
							foreach($snumbers as $snumber){
								?>
								<option value="<?php echo $snumber['name']; ?>"><?php echo $snumber['name']; ?></option>
								<?php
							}
							?>
						</select>
						<input type="submit" value="Пребарај">

					</form>
				</div>

			</div>

		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if($s_number != ''){?>
		<div class="row top-margin20">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<table id="product_detail" class="display table" style="width:100%">
					<thead>
					<tr>
						<th></th>
						<th>Артикл</th>
						<th>Мерка</th>

					</tr>
					</thead>
					<tbody>
					<?php
					$i = 0;
					foreach($articles as $a){
						$merka = merka($a['measure']);
						$i ++;
						?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><a href = "<?php  echo base_url().'warehouse/search_article/'.$a['id'].'/'.$s_number; ?>"><?php echo $a['name'] ?></a></td>
								<td><?php echo $merka;?></td>
							</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-1"></div>
		</div>
	<?php } ?>
</div>
