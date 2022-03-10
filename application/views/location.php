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
	function take_from($id){
		$location = new Location_model();
		$result = $location->getLocationByKey('rotation_location', $id);

		return $result[0]['name'];

	}
	function hasProductCharacteristics($s_number, $article_id){
		$product = new Product_model();
		$result = $product->getProductBySerialNumberandArticle($s_number, $article_id);
		return count($result);

   }
   function isHasWidth($id){
		$article = new Article_model();
		$result = $article->getArticleByID($id, true);
		return $result[0]['width'];

   }
   function packageQty($id){
		$article = new Article_model();
		$result = $article->getArticleByID($id,true);
		return $result[0]['package_qty'];

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
		</optgroup>

	<?php
		  }
	?>
	</select>
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
		<div class="col-sm-10">
			<label for="article_used">Артикл:</label>
			<select id="article_used" name="article_used">
				<option value="">--избери артикл--</option>
				<?php
				foreach($article_in_stock as $a){
					?>
					<option value="<?php echo $a['name']; ?>"><?php echo $a['name']; ?></option>

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
		<div class="col-sm-2"></div>
		<div class="col-sm-6">
			<a href="<?php  echo base_url().'location/statistic/'.$uri; ?>">Состојба на поле</a>
		</div>
		<div class="col-sm-4">
			<?php
			if($uri != ''){?>
			<div class = 'total_info'>
				<?php  $loc_details = $curr_location; ?>
				<span class="width100 left-margin20 color-white"><b>Тотал локација- <?php  echo $loc_details['name']; ?>:</b>  <?php  echo $loc_details['price']; ?> Денари </span><br/>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<?php
			if($uri != ''){?>
				<table id="article" class="display table" style="width:100%">
					<thead>
					<tr>
						<th>Сериски број</th>
						<th></th>
						<th>Артикл</th>
						<th>Боја</th>
						<th>Внесено на</th>
						<th>Широчина</th>
						<th>Количина во пакет</th>
						<th>Цена единечна</th>
						<th>Количина</th>
					</tr>
					</thead>
					<tbody>
					<?php
					    foreach($article as $a){
							$date=date_create($a['date_entered']);
							$date_entered =  date_format($date,"d/m/Y H:i:s");
							$date_entered_2 =  date_format($date,"m/d/Y");
							$merka = merka($a['measure_id']);
							$color = color($a['color']);
							$timestamp = date_timestamp_get($date);
							$has_width = isHasWidth($a['article_id']);
							$packageQty= packageQty($a['article_id']);


						 ?>
						<tr>
							<td><?php echo $a['serial_number'];  ?></td>
							<td><?php echo $date_entered_2;  ?></td>
							<td><?php echo $a['article_name'];  ?></td>
							<td><?php echo $color  ?></td>
							<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered;  ?></td>
							<?php
							    if($has_width == '1'){
							?>
									<td><input type="number" name="width"  id="width_<?php echo $a['id']?>" min="0" step="0.00001" onchange="ChangeWidth('<?php echo $a['id']?>')" value="<?php echo $a['width']?>" style="width:70%"/> m</td>
							<?php
								}
							    else{
							?>
									<td>-</td>
							<?php
								}
							?>
							<?php
							if($packageQty == '1'){
								?>
								<td><?php echo $a['package'];  ?></td>
								<?php
							}
							else{
								?>
								<td>-</td>
								<?php
							}
							?>
							<td><?php echo $a['price_per_piece'];  ?> USD</td>
							<td><?php echo $a['qty'].' '.$merka;  ?></td>
						</tr>

					<?php
					        } ?>

					</tbody>
				</table>
			<?php
			}
			?>
		</div>
		<div class="col-sm-1"></div>
	</div>

</div>
<script>
	$(document).ready(function () {
		$('#location').change(function() {
			let loc = $('#location').val();
			let url = "<?php echo base_url()?>location/index/"+loc;
			window.location.replace(url);
		});
	});
	function ChangeWidth(warehouse_id){
		var width = $('#width_'+warehouse_id).val();
		$.ajax({
			url: "<?php echo base_url()?>warehouse/change_width",
			type: "post",
			async: false,
			dataType:"json",
			data : {"id": warehouse_id,"width":width},
			success: function(data){
                if(data.return == 'success'){
                	alert("Успешно променета ширина на продукт");
				}
			}
		});
	}
</script>
