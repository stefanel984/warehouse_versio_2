<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'login/edit_user_pass' ?>' enctype='multipart/form-data'>
				Корисник:  <b><?php echo $full_name; ?></b><br/><br/>
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $id;  ?>"/>
				<label for="password">Лозинка:<span class="required">*</span></label><input type="password" id="password"  name="password" required/><br/><br/>
				<label for="password_confirm">Лозинка потврда:<span class="required">*</span></label><input type="password" id="password_confirm"  name="password_confirm" required/><br/><br/>
				<input type="submit" value="Зачувај корисник"  id="edit_pass" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>
