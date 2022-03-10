<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'article/add_article ' ?>' enctype='multipart/form-data'>
				<label for="color">Артикл:</label><input type="text" id="article"  name="article"  required/><br/><br/>
				<label for="measure">Мерки:</label>
				<select id="measure" name="measure" required>
					<option value="">--избери мерка--</option>
					<?php
					foreach($measure as $m){
									?>
									<option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
									<?php
					}
					?>
				</select><br/>
				<label for="width">Дали да се внесува широчина?</label> <input type="checkbox" id="width" name="width" value="1"><br/>
				<label for="package_sales">Вадење на дел од залихата на артиклот?</label><input type="checkbox" id="package_sales" name="package_sales" value="1"><br/>
				<label for="package_sales">Количина  во  пакет?</label><input type="checkbox" id="package_qty" name="package_qty" value="1">
				<br/><br/>
				<input type="submit" value="Зачувај артикл"  id="add_article" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<?php if(isset($error)){ ?>
		<p class="error"><?php echo $error;  ?></p>
	<?php } ?>

</div>
