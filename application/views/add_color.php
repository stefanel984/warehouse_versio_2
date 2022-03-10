<div class="content">
	<h1><?php echo $title; ?></h1>
	<div>
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'settings/add_color' ?>' enctype='multipart/form-data'>
				<label for="color">Наслов боја:</label><input type="text" id="color"  name="color"  required/><br/><br/>
				<label for="color_img"> Слика боја:</label><input type="file" id="color_img"  name="color_img"   accept="image/gif, image/jpeg, image/png" required/><br/><br/>
				<input type="submit" value="Зачувај боја"  id="add_color" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>

