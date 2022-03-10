<?php
function color($id){
	$measure = new Settings_model();
	$result = $measure->getColor($id);

	return $result[0]['name'];

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
					<td><?php echo $article['price_total'] ?></td>
					<td><span><i class="fa fa-plus-square f-size-20 grey pointer revert_rotation"  id="rotation_<?php echo $article['id']; ?>" title="Припреми ролна за ротација"></i></span></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
		$diff_price = $location['old_price'] - $location['price'];
		?>
		<form method='post' action='<?php echo base_url(); ?>warehouse/revert'>
			<input type='hidden' name='from_section' value='<?php echo $from_location[0]['id']; ?>'>
			<input type='hidden' name='location' value='<?php echo $id; ?>'>
			<span>Враќање ролни</span><br/>
			<div id="list_article_rotation">
				<div class='list_article'>Артикли спремни за враќање</div><br/>

			</div>
			<br/>
			<br/>
			<input type="submit" value="Поврати ролни"  id="rotate_article" disabled="disabled"/>
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
		$.ajax({
			url: "../../warehouse/takeArticleWarehouse",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id_warehouse": article_id},
			success: function(data){
				var article = data[0];
				new_sum = new_sum - parseFloat(article['price_total']);

			}
		});
		if(numArticle == 1 || loc == 0){
			$('#rotate_article').attr('disabled', 'disabled');
		}

		$('#table_'+article_id + ' :last-child').html('<span><i class="fa fa-plus-square f-size-20 grey pointer revert_rotation"  id="rotation_'+article_id+'" title="Припреми ролна за ротација"></i></span>');
	});

</script>

