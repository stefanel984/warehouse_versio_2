<?php
function typeDocument($id){
	$setting = new Settings_model();
	$result = $setting->getDocType($id);

	return $result[0]['document_type'];

}
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20 admin_background">
		<div class="col-sm-1"></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>document/add_document">Додај документ</a></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-1"></div>

	</div>
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
			<?php
			$date_array = array();
			foreach($document as $d){
				$date=date_create($d['date_of_document']);
				$date_document =  date_format($date,"d/m/Y");
				$array = explode('/',$date_document);
				if(!in_array($array[2],$date_array)){
					$date_array[] = $array[2];
				}

			}
			?>
			<label for="users">Година на документ:</label>
			<select id="year" name="year">
				<option value="">--избери година--</option>
				<?php
				foreach($date_array as $year){
					?>
					<option value="<?php echo $year; ?>"><?php echo $year; ?></option>

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
			<label for="name">Тип на документ:</label>
			<select id="type" name="type" required>
				<option value="">--избери тип на документ--</option>
				<?php foreach($type_document as $type){?>
					<option value="<?php echo $type['document_type']; ?>"><?php echo $type['document_type']; ?></option>
				<?php } ?>
			</select>

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
	<div class="row top-margin20 admin_background">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="document_table" class="display table" style="width:100%">
				<thead>
				<tr>
					<th>Сериски број</th>
					<th></th>
					<th>Тип на документи</th>
					<th>Датум на документ</th>
					<th>Датум на внес</th>
					<th>Внесен од</th>
					<th>Детали</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($document as $d){
					$date=date_create($d['date_entered']);
					$date_entered =  date_format($date,"d/m/Y H:i:s");
					$date_entered_2 =  date_format($date,"m/d/Y");
					$timestamp_entered = date_timestamp_get($date);
					$date=date_create($d['date_of_document']);
					$date_of_document =  date_format($date,"d/m/Y");
					$timestamp_of_document = date_timestamp_get($date);
					$date_array = explode('/',$date_of_document);

					?>
					<tr>
						<td><?php echo $d['serial_number']; ?></td>
						<td><?php echo $date_entered_2; ?></td>
						<td><?php echo typeDocument($d['type']);  ?></td>
						<td><span style="display:none;"><?php echo $timestamp_of_document;  ?></span><?php echo $date_of_document ?></td>
						<td><span style="display:none;"><?php echo $timestamp_entered;  ?></span><?php echo $date_entered ?></td>
						<td><?php echo userName($d['created_by']); ?></td>
						<td><a href="<?php echo base_url().'document/document_detail/'.$d['id'] ?>" target="_blank">Линк до прикачени документи</td>
						<td><?php echo $date_array[2]; ?></td>
					</tr>

				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
