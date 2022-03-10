<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'location/add_location' ?>' enctype='multipart/form-data'>
				<label for="color">Ареа:</label>
				<select id="area" name="area" required>
					<option value="">--избери ареа--</option>
					<?php
					foreach($area as $a){
						?>
						<option value="<?php echo $a['name']; ?>"><?php echo $a['name']; ?></option>
						<?php
					}
					?>
				</select><i class="fa fa-plus-square f-size grey pointer top-margin20" id='new_area' title="Додавање на новa ареа"></i><span style="margin-left: 20px;">Додади нова ареа</span><br/><br/>
				<label for="color">Локација:</label><input type="text" id="location"  name="location"  required/><br/><br/>
				<input type="submit" value="Зачувај локација"  id="add_location" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>
<div id="dialog-form-location" title="Додади нова ареа">
	<label for="area">Ареа</label>
	<input type="text" id="add_area"  name="add_area"  required/>
</div>


