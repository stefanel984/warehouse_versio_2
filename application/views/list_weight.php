<?php
function location($id){
	$loc = new Location_model();
	$loc_details = $loc->getSectionById($id);
	return $loc_details['name'];
}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<form method = 'post' action = '<?php  echo base_url().'issueslip/confirm_list/'.$list_id; ?>'>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="weight_list" class="display table" style="width:100%">
				<thead>
				<tr>
					<th>Ареа</th>
					<th>Артикл</th>
					<th>Бруто</th>
					<th>Нето</th>
					<th>Вкупнo ролни</th>
					<th></th>
				</tr>
				</thead>
				<tbody>

				<?php
				$r = 0;
				foreach($list_details as $section => $list_section){
					$section_name = location($section);
					foreach($list_section as  $l){
					?>
					<tr>
						<td><?php echo $section_name;?></td>
						<td><?php echo $l['name'];?></td>
						<td><input type="number" step="0.001" name="sum[<?php echo $section; ?>][<?php echo $l['id'] ?>][brutto]" required/>kg</td>
						<td><input type="number" step="0.001" name="sum[<?php echo $section; ?>][<?php echo $l['id'] ?>][netto]" required/>kg</td>
						<td><input type="number" step="0.001" name="sum[<?php echo $section; ?>][<?php echo $l['id'] ?>][total_qty]" required/></td>
						<td><input type="hidden" value="<?php echo $l['qty']; ?>"  name="sum[<?php echo $section; ?>][<?php echo $l['id'] ?>][qty]" /></td>
					</tr>
				<?php }
				}?>

				</tbody>

			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class="row top-margin20">
			<div class="col-sm-1"></div>
		    <div class="col-sm-10">
				<input type="hidden" value="<?php echo $list_id; ?>"  name="list_id" id="list_id" />
				<input type="hidden" value="<?php echo $slip_number; ?>"  name="list_number"  id="list_number" />
				<input type="submit" value="Потврдете листа"  id="confirm />
		    </div>
		    <div class="col-sm-1"></div>
	</div>
	</form>
</div>
<script>

</script>
