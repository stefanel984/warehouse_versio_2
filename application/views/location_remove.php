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
?>
<div class="content">
	<label for="location">Локација</label>
	<select id="location" name="locaion">
		<option value=" ">---избери локација----</option>
		<?php
		foreach($area as $a){
			?>
			<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
				<?php
				foreach($location as $l){
					$selected = "";
					if($a['id'] == $l['id_area']){
						if($l['id'] == $uri){
							$selected = 'selected';
						}
						?>
						<option value="<?php echo $l['id']; ?>" <?php echo $selected; ?>><?php echo $l['name']; ?></option>
						<?php
					}
				}
				?>
				?>
			</optgroup>

			<?php
		}
		?>
	</select>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
				<table id="article" class="display table" style="width:100%">
					<thead>
					<tr>
						<th>Сериски број</th>
						<th>Артикл</th>
						<th>Боја</th>
						<th>Извадено на</th>
						<th>Цена единечна</th>
						<th>Количина</th>
						<th>Тотал цена</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($article as $a){
						$date=date_create($a['date_exit']);
						$date_exit =  date_format($date,"d/m/Y H:i:s");
						$timestamp = date_timestamp_get($date);
						$merka = merka($a['measure_id']);
						$color = color($a['color']);

						?>
						<tr>
							<th><?php echo $a['serial_number'];  ?></th>
							<th><?php echo $a['article_name'];  ?></th>
							<th><?php echo $color  ?></th>
							<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_exit;  ?></td>
							<th><?php echo $a['price_per_piece'];  ?></th>
							<th><?php echo $a['qty'].' '.$merka;  ?></th>
							<th><?php echo $a['price_total'];  ?></th>
						</tr>

						<?php
					} ?>

					</tbody>
				</table>
		</div>
		<div class="col-sm-1"></div>
	</div>

</div>
<script>
	$(document).ready(function () {
		$('#location').change(function() {
			let loc = $('#location').val();
			let url = "<?php echo base_url()?>warehouse/allOutList/"+loc;
			window.location.replace(url);
		});
	});
</script>

