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
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<?php
			   if($active){
			?>
				       <form method = 'post' action = '<?php  echo base_url().'issueslip/list_weight/'.$is; ?>'>
						   <p><b>Потврди ја листата, после потврда неможете да додавате нови артикли за излез!</b></p><br/>
						   <label for="list_number">Внесете ја картицата:<span class="required">*</span></label><input type="text" id="list_number"  name="list_number"  required/><br/><br/>
						   <input type="submit" value="Потврдете листа"  id="confirm" />
						   <input type="hidden" value="<?php echo $is; ?>"  id="list_id" />
						   <button type="button" id="cancel">Откажи листа</button>
					   </form>
			<?php
			   }
			?>

		</div>
		<div class="col-sm-2"></div>

	</div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="view_list" class="display table" style="width:100%">
			   <thead>
			     <tr>
			         <th></th>
				     <th>S број</th>
					 <th>Локација</th>
				     <th>Артикл</th>
				     <th>Цена парче</th>
				     <th>Цена</th>
			         <th>Боја</th>
			         <th>Количество</th>
				 </tr>
			   </thead>
				<tbody>

				<?php
				   $r = 0;
				   foreach($list as $l){
					$merka = merka($l['measure_id']);
					$color = color($l['color']);
					$r++;
					?>
				<tr>
					   <td><?php echo $r; ?></td>
					   <td><?php echo $l['serial_number'];?></td>
					   <td><?php echo location($l['section_id']);  ?></td>
					   <td><?php echo $l['name'];?></td>
					   <td><?php echo $l['price_per_piece'];?> USD</td>
					   <td><?php echo $l['price_total'];?> USD</td>
					   <td><?php echo $color; ?></td>
					   <td><?php echo $l['qty'].' '.$merka;?></td>
				</tr>
				<?php } ?>

				</tbody>

			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<script>
	$('#list_number').change(function(){
		let list_number = $('#list_number').val();
		$.ajax({
			url: "<?php echo base_url()?>/issueslip/checkExistingCardNumber",
			type: "post",
			async: false,
			dataType:"json",
			data : { "list_number": list_number},
			success: function(data){
				if(data.exist == "yes"){
					$('#list_number').val('')
					alert('Постои ист број на картичка. Внесете нов број');
				}
			}
		});

	});
	$('#cancel').click(function(){
		let list_id = $('#list_id').val();
		$.ajax({
			url: "<?php echo base_url()?>/issueslip/deleteCard",
			type: "post",
			async: false,
			dataType:"json",
			data : { "list_id": list_id},
			success: function(data){
				if(data.success == "yes"){
					let url = "<?php echo base_url()?>dashboard/";
					window.location.replace(url);
				}
				else{
					alert('Грешка во бришењето на листата, број на картица. Ве молам контактирајте админ');
				}
			}
		});

	})

</script>
