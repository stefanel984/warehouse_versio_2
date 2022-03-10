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
	$section = new Location_model();
	$result = $section->getSectionById($id);

	return $result['name'];

}
function package_sales($article_id){
	$article = new Article_model();
	$result = $article->getArticleByID($article_id);

	return $result[0]['package_sales'];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<label for="location_choice">Локација:</label>
	<select id="location_choice" name="location_choice">
		<option value=" ">---избери локација----</option>
		<?php foreach($area as $a){
			?>
			<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
				<?php
				foreach($location as $l){
					$selected = "";
					if($a['id'] == $l['id_area']){
						if($l['id'] == $loc ){
							$selected = 'selected';
						}
						if($l['old_price'] == $l['price']){
							?>
							<option value="<?php echo $l['name']; ?>" <?php echo $selected; ?>><?php echo $l['name']; ?></option>
							<?php
						}
					}
				}
				?>
			</optgroup>

			<?php
		}
		?>
	</select>
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
	<div class="row top-margin20">
		<div class="col-sm-12">
			<table id="article_out_table" class="display table" style="width:100%">
				<thead>
				<tr>
					<th>Локација</th>
					<th>Артикл</th>
					<th>Боја</th>
					<th>Внесено на</th>
					<th>Цена единечна</th>
					<th>Количина</th>
					<th></th>
					<th>Количина во пакет</th>
					<th>Површина</th>
					<th>Тотал цена</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach($articles as $a){
					$date=date_create($a['date_entered']);
					$date_entered =  date_format($date,"d/m/Y H:i:s");
					$merka = merka($a['measure_id']);
					$color = color($a['color']);
					$timestamp = date_timestamp_get($date);
					$package_sales = package_sales($a['article_id']);
					$width = $a['qty'] * $a['width'];
					if($width == 0){
						$width  = '-';
					}
					$package = $a['package'];
					$show_package = $a['package'];
					if($package == 0){
						$package == '-';
						$show_package = 1;
					}
   					?>
					<tr>
						<td><?php echo location($a['section_id']);  ?></td>
						<td><?php echo $a['article_name'];  ?></td>
						<td><?php echo $color  ?></td>
						<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered;  ?></td>
						<td><?php echo $a['price_per_piece'];  ?> USD</td>
						<td><?php echo $a['qty'].' '.$merka;  ?></td>
						<?php if($package_sales == 1){ ?>
						<td><input type="number" id="qty_<?php echo $a['id'];  ?>" min="0" step="0.00001" max="<?php echo $a['qty']  ?>" value="<?php echo $a['qty']  ?>" class="part_qty">
							<input type="hidden" id="limit_<?php echo $a['id'];  ?>"  value="<?php echo $a['qty']  ?>" data-limit = 'limit'>
							<input type="hidden" id="price_<?php echo $a['id'];  ?>"  value="<?php echo $a['price_per_piece']; ?>"  data-price = 'price' >
							<input type="hidden" id="price_<?php echo $a['id'];  ?>"  value="<?php echo $merka;  ?>"  data-merka = 'merka' >
							<input type="hidden" id="price_<?php echo $a['id'];  ?>"  value="<?php echo $show_package;  ?>"  data-package = 'package' >
						</td>
						<?php
						}else{ ?>
						<td><input type="hidden" id="qty_<?php echo $a['id'];  ?>" min="0" step="0.00001" max="<?php echo $a['qty']  ?>" value="<?php echo $a['qty']  ?>"></td>
						<?php } ?>
						<td><?php echo $package;  ?></td>
						<td><?php echo $width;  ?> M2</td>
						<td><?php echo $a['price_total'];  ?> USD</td>
						<td class="out_article"><div ><img src="<?php  echo base_url().$technical_images.'/out.png'; ?>" title="Излез на артикл" width="20px" height="20px" />
									<input type="hidden" value="<?php echo $a['id'];  ?>" id="article_wh_<?php echo $a['id'];  ?>" data-loc="<?php echo $a['section_id'];  ?>" />
								</div></td>

					</tr>
					<?php
				} ?>

				</tbody>
			</table>
		</div>
</div>
<script>
	$(document).ready(function () {
		$(document).on("click", ".out_article",function() {
			let article_id = $(this).find('input').val();
			let location = $(this).find('input').data("loc");
			let id = "article_wh_"+article_id;
			let qty = $("#qty_"+article_id).val();
			$.ajax({
				url: "<?php echo base_url()?>warehouse/remove_article",
				type: "post",
				dataType:"json",
				data : { "article_id": article_id, "location_id":location, "qty":qty},
				success: function(data){
					if(data.result == 'success'){
						$("#"+id).closest("tr").find(':last-child').html('');
					}
					else{
						alert('Greska kontaktirajte admin');
					}

				}
			});
		});
		$('.part_qty').change(function(){
			var max_value = $(this).attr("max");
			var limit = $(this).closest("td").find("[data-limit = 'limit']");
			var price = $(this).closest("td").find("[data-price = 'price']");
			var merka = $(this).closest("td").find("[data-merka = 'merka']");
			var package = $(this).closest("td").find("[data-package = 'package']");
			if(parseFloat($(this).val()) > parseFloat(limit.val()) ){
				alert('Изнесувате повеќе од она што е залиха. Направете проверка');
				$(this).val(max_value);
			}
			else{
                var tr_row =  $(this).closest("tr");
                var  tekst = $(this).val()+' '+merka.val();
                tr_row.find("td").eq(5).text(tekst);
                var total = parseFloat(price.val()) * parseFloat($(this).val()) *  parseFloat(package.val());
				total = total.toFixed(2)
				tr_row.find("td").eq(9).text(total+'USD');

			}
		})

	})
</script>
