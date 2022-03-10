<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'settings/add_measure' ?>' enctype='multipart/form-data'>
				<label for="measure">Мерка:</label><input type="text" id="measure"  name="measure"  required/><br/><br/>
				<input type="submit" value="Зачувај мерка"  id="add_measure" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>
