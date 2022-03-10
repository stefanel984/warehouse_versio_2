<?php
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<form method = 'post' action = '<?php  echo base_url().'snumber/create' ?>' enctype='multipart/form-data' id="s_number_form">
			<label for="s_number">S број:   <span class="required">*</span></label> <input type="text" id="s_number"  name="s_number" required/><br/><br/>
			<input type="submit" value="Внеси" id="add_s_number"/>
		</form>
	</div>
	<div class="col-sm-2"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<table id="s_numberdetails" class="display table" style="width:100%">
			<thead>
				<tr>
					<th></th>
					<th>S број</th>
					<th>Креирано од</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			    $i = 0;
			    foreach($number as $n){
			    	$i++;
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $n['name'] ?></td>
					<td><?php echo userName($n['created_by']) ?></td>
					<?php 		if($n['deleted'] == 0){ ?>
					<td><i class="fa fa-minus-circle pointer delete_number" id="number_<?php echo $n['id']; ?>" title="Избриши S број"></i></td>
					<?php 		} else{ ?>
					<td><i class="fa fa-repeat pointer restore_number" id="number_<?php echo $n['id']; ?>" title="Врати S број"></i></td>
					<?php
					}
					?>
				</tr>
			<?php
				}
			 ?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-1"></div>
</div>
<script>
	$('#add_s_number').click(function(e){

		var s_number = $('#s_number').val();
		$.ajax({
			url: "<?php echo base_url()?>/snumber/check",
			type: "post",
			async: false,
			dataType:"json",
			data : { "s_number": s_number},
			success: function(data){
				if(data.exist == 'true'){
					alert('Постои ваков S number ');
					$('#s_number').val('');
					e.preventDefault();
				}
				else{
					$("#s_number_form").submit();
				}

			}
		});


	});
	$(document).on("click", ".restore_number",function() {
		var id = this.id;
		var s_number = id.split('_');
		$.ajax({
			url: "<?php echo base_url()?>snumber/delete_restore",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id": s_number[1], "action":"restore"},
			success: function(data){
				if(data.return){
					$('#'+id).closest('td').html('<i class="fa fa-minus-circle  pointer delete_number" id="number_'+s_number[1]+'" title="Избриши S број"></i>');
				}

			}
		});

	});
	$(document).on("click", ".delete_number",function() {
		var id = this.id;
		var s_number = id.split('_');
		$.ajax({
			url: "<?php echo base_url()?>snumber/delete_restore",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id": s_number[1], "action":"delete"},
			success: function(data) {
				if(data.return) {
					$('#' + id).closest('td').html('<i class="fa fa-repeat  pointer restore_number" id="number_' + s_number[1] + '" title="Врати S број"></i>');
				}
			}
			});
		});
</script>

