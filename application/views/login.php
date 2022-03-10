<div class="login">
		<form action="<?php echo base_url(); ?>login/logiranje" method="post">
			<label for="username">Корисник: </label><br />
			<input type="text" name="username"  id="username" required/><br />
			<label for="password">Лозинка: </label><br />
			<input type="password" name="password" value="" id="password" required/><br /><br/>
			<input type="submit" value="Најави се!" />
			<p class="error"><?php echo $error_message ?></p>
		</form>
</div>

