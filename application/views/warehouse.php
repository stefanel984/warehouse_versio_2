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
function location($id){
	$location = new Location_model();
	$result = $location->getSectionById($id);

	return $result['name'];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="input-group input-daterange">
				<input type="text" class="form-control date-range-filter" placeholder="Од" data-date-format="dd/mm/yyyy" id="min" />
				<input type="text" class="form-control date-range-filter" placeholder="До" data-date-format="dd/mm/yyyy" id="max"/>
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10"
			<label for="location">Локација</label>
			<select id="location" name="locaion">
				<option value=" ">---избери локација----</option>
				<?php
				foreach($area as $a){
					?>
					<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
						<?php
						foreach($location as $l){
							?>

								<option value="<?php echo $l['name']; ?>" ><?php echo $l['name']; ?></option>
								<?php

						}
						?>
					</optgroup>

					<?php
				}
				?>
			</select>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<label for="article_used">Артикл:</label>
			<select id="article_used" name="article_used">
				<option value="">--избери артикл--</option>
				<?php
				foreach($article_in_stock as $a){
					?>
					<option value="<?php echo $a['article_name']; ?>"><?php echo $a['article_name']; ?></option>

					<?php
				}
				?>

			</select>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<label for="color">Боја:</label>
			<select id="color" name="color">
				<option value="">--избери боја--</option>
				<?php
				foreach($color as $c){
					?>
					<option value="<?php echo $c['name']; ?>"><?php echo $c['name']; ?></option>

					<?php
				}
				?>

			</select>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="all_article" class="display table" style="width:100%">
				<thead>
				<tr>
					<th>Сериски број</th>
					<th></th>
					<th>Локација</th>
					<th>Артикл</th>
					<th>Боја</th>
					<th>Внесено на</th>
					<th>Цена единечна</th>
					<th>Количина</th>
					<th>Тотал цена</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach($warehouse_article as $a){
					$date=date_create($a['date_entered']);
					$date_entered =  date_format($date,"d/m/Y H:i:s");
					$date_entered_2 =  date_format($date,"m/d/Y");
					$merka = merka($a['measure_id']);
					$color = color($a['color']);
					$timestamp = date_timestamp_get($date);

									?>
					<tr>
						<td> <?php echo $a['serial_number'];  ?></td>
						<td><?php echo $date_entered_2;  ?></td>
						<td> <?php echo location($a['section_id']);  ?></td>
						<td><?php echo $a['article_name'];  ?></td>
						<td><?php echo $color  ?></td>
						<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered;  ?></td>
						<td><?php echo $a['price_per_piece'];  ?> USD</td>
						<td><?php echo $a['qty'].' '.$merka;  ?></td>
						<td><?php echo $a['price_total'] ?> USD</td>
					</tr>

					<?php
				} ?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-1"></div>
</div>
