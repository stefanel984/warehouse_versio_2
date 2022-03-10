<?php
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<label for="range">Внесен во период:</label>
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
			<label for="users">Корисници:</label>
			<select id="users" name="users">
				<option value="">--избери корисници--</option>
				<?php
				foreach($users as $u){
					?>
					<option value="<?php echo $u['full_name']; ?>"><?php echo $u['full_name']; ?></option>

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
			<table id="view_issueslip" class="display table" style="width:100%">
				<thead>
				<tr>
					<th>id</th>
					<th></th>
					<th>Картон број</th>
					<th>Креиран на</th>
					<th>Креиран од</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				   <?php foreach($list as $l){
					   $date=date_create($l['date']);
					   $date_entered =  date_format($date,"d/m/Y H:i:s");
					   $date_entered_2 =  date_format($date,"m/d/Y");
					   $timestamp = date_timestamp_get($date);
				   	?>
					   <tr>
						   <td><?php echo $l['id']; ?></td>
						   <td><?php echo $date_entered_2; ?></td>
						   <td><?php echo $l['list_number']; ?></td>
						   <td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered; ?></td>
						   <td><?php echo userName($l['created_by']); ?></td>
						   <td><a href="<?php  echo base_url().'issueslip/all_item/'.$l['id']; ?>" target="_blank">Преглед</a></td>
						   <td><a href="<?php  echo base_url().'Pdfprint/printPDF/'.$l['id']; ?>" target="_blank"><i class="fa fa-file grey pointer" title="Спушти PDF"></i></a></td>
					   </tr>
				   <?php } ?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
