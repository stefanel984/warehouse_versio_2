<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'login/add_new_user' ?>' enctype='multipart/form-data'>
				<label for="name">Име:<span class="required">*</span></label><input type="text" id="name"  name="name"  required/><br/><br/>
				<label for="surname">Презиме:<span class="required">*</span></label><input type="text" id="surname"  name="surname"  required/><br/><br/>
				<label for="phone">Мобилен:<span class="required">*</span></label><input type="text" id="phone"  name="phone"  required/><br/><br/>
				<label for="other_phone">Мобилен 2:</label><input type="text" id="other_phone"  name="other_phone"/><br/><br/>
				<label for="email">Емаил:<span class="required">*</span></label><input type="text" id="email"  name="email" required/><br/><br/>
				<label for="admin">Администратор:</label><input type="checkbox" id="is_admin"  name="is_admin"/><br/><br/>
				<label for="username">Корисник:<span class="required">*</span></label><input type="text" id="new_user"  name="username" required/><br/><br/>
				<label for="password">Лозинка:<span class="required">*</span></label><input type="password" id="password"  name="password" required/><br/><br/>
				<label for="password_confirm">Лозинка потврда:<span class="required">*</span></label><input type="password" id="password_confirm"  name="password_confirm" required/><br/><br/>


				<input type="submit" value="Зачувај корисник"  id="add_user" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>

