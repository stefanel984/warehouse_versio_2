<?php
function action($action){
			switch ($action) {
				case "in":
					$result = 'Влез';
					break;
				case "out":
					$result = 'Излез';
					break;
				case "transfer":
					$result = 'Ротација';
					break;
				default:
					$result = '';
			}

			return $result;

}
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
function linkRelation($ids){
	$id_array = explode(',',$ids);
	$result = '';
	foreach ($id_array as $id){
		$result .= '<div class="log_details pointer" id="'.$id .'">ID-'.$id.'</div>  ';
	}

	return $result;
}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
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
			<label for="action">Акција:</label>
			<select id="action" name="action">
				<option value="">--избери акција--</option>
				<option value="Излез">Излез</option>
				<option value="Влез">Влез</option>
				<option value="Ротација">Ротација</option>
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
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<table id="log_table" class="display table" style="width:100%">
				<thead>
				<tr>
					<th width="20%">Акција</th>
					<th></th>
					<th width="25%">Датум на креирање</th>
					<th width="25%">Креирано од</th>
					<th width="30%">Релации</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach($logs as $l){
					$date=date_create($l['date_entered']);
					$date_entered =  date_format($date,"d/m/Y H:i:s");
					$date_entered_2 =  date_format($date,"m/d/Y");
					$timestamp = date_timestamp_get($date);


					?>
					<tr>
						<td><?php echo action($l['action']);  ?></td>
						<td><?php echo $date_entered_2;  ?></td>
						<td><span style="display:none;"><?php echo $timestamp;  ?></span><?php echo $date_entered;  ?></td>
						<td><?php echo userName($l['created_by']);  ?></td>
						<td><span style="display:none;"><?php echo $l['id'];  ?></span><?php echo linkRelation($l['relation_id']); ?></td>
					</tr>

					<?php
				} ?>

				</tbody>
			</table>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div id="log_detail_view" title="Преглед на лог">

	</div>

</div>



