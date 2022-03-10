<?php
function color($id){
	$measure = new Settings_model();
	$result = $measure->getColor($id);

	return $result[0]['name'];

}
foreach($location as $l){
	if($id == $l['id']){
		$sum_loc = $l['price'];
	}

}
?>
<div class="row top-margin20 admin_background">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<table id='article_rotation' class='display table' style='width:100%'>
			<thead>
			<tr>
				<th>Сериски број</th>
				<th>Артикл</th>
				<th>Боја</th>
				<th>Количина</th>
				<th>Цена</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($articles as $article){
				$color = color($article['color']);
				?>
				<tr id="table_<?php echo $article['id']; ?>">
					<td><?php echo $article['serial_number']; ?></td>
					<td><?php echo $article['article_name']; ?></td>
					<td><?php echo $color; ?></td>
					<td><?php echo $article['qty']; ?></td>
					<td><?php echo $article['price_total'] ?> USD</td>
					<td><span><i class="fa fa-plus-square f-size-20 grey pointer r_rotation"  id="rotation_<?php echo $article['id']; ?>" title="Припреми ролна за ротација"></i></span></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<form method='post' action='<?php echo base_url(); ?>warehouse/rotation'>
			<input type='hidden' name='old_section' value='<?php echo $id; ?>'>
			<label>Останато на локација</label><input type='number' id="sum" value='<?php echo $sum_loc; ?>' step="0.1" readonly> USD<br/><br/><br/>
			<label>Избери локација<span class="required">*</span></span></label>
			<select id="location" name="location" class="top-margin20" required>
				<option value="">---избери локација----</option>
				<?php
				foreach($area as $a){
					?>
					<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
						<?php
						foreach($location as $l){
							$selected = "";
							if($a['id'] == $l['id_area']){
								if($id != $l['id'] && $l['old_price'] == $l['price']){
								?>
								<option value="<?php echo $l['id']; ?>" <?php echo $selected; ?>><?php echo $l['name']; ?></option>
								<?php
								}
							}

						}
						?>
					</optgroup>

					<?php
				}
				?>
			</select><br/><br/>
			<div id="list_article_rotation">
				<div class='list_article'>Артикли спремни за преместување</div><br/>

			</div>
			<br/>
			<br/>
			<input type="submit" value="Премести ролни"  id="rotate_article" disabled="disabled"/>
		</form>
	</div>
	<div class="col-sm-1"></div>
</div>
<script>
	$(document).on("click", ".delete_article",function() {
		let article_id = $(this).closest('div.list_article').find('.article_id').val();
		$(this).closest('div.list_article').remove();
		let numArticle = $('.list_article').length;
		let loc = $('#location').val();
		let new_sum = $('#sum').val();
		new_sum = parseFloat(new_sum);
		$.ajax({
			url: "../../warehouse/takeArticleWarehouse",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id_warehouse": article_id},
			success: function(data){
				var article = data[0];
				new_sum = new_sum + parseFloat(article['price_total']);

			}
		});
		new_sum = parseFloat(new_sum).toFixed(1);
		$('#sum').removeAttr('readonly');
		$('#sum').val(new_sum);
		$('#sum').attr('readonly','readonly');
		if(numArticle == 1 || loc == 0){
			$('#rotate_article').attr('disabled', 'disabled');
		}

		$('#table_'+article_id + ' :last-child').html('<span><i class="fa fa-plus-square f-size-20 grey pointer r_rotation"  id="rotation_'+article_id+'" title="Припреми ролна за преместување"></i></span>');
	});

</script>

