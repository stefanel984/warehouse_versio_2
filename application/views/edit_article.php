<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'article/confirm_edit_article/'.$article[0]['id'] ?>' enctype='multipart/form-data'>
				<label for="color">Артикл:</label><input type="text" id="article"  name="article"  value="<?php echo $article[0]['name'] ?>" required readonly/><br/><br/>
				<label for="measure">Мерки:</label>
				<select id="measure" name="measure">
					<option value="">--избери мерка--</option>
					<?php
					foreach($measure as $m){
						$selected = '';
						$disabled = 'disabled';
						if($m['id'] == $article[0]['measure']){
							$selected = 'selected';
							$disabled = '';
						}
						?>
						<option value="<?php echo $m['id']; ?>" <?php echo $selected.' '.$disabled ?>><?php echo $m['name']; ?></option>
						<?php
					}
					?>
				</select><br/>
				<?php
				      $width ='';
				     if($article[0]['width'] == 1){
						 $width = 'checked';
					 }
					$package_sales ='';
					if($article[0]['package_sales'] == 1){
						$package_sales = 'checked';
					}
					$package_qty ='';
					if($article[0]['package_qty'] == 1){
						$package_qty = 'checked';
					}
				?>
				<label for="width">Дали да се внесува широчина?</label> <input type="checkbox" id="width" name="width" value="1" <?php echo $width; ?>><br/>
				<label for="package_sales">Вадење на дел од залихата на артиклот?</label><input type="checkbox" id="package_sales" name="package_sales" value="1" <?php echo $package_sales; ?>><br/>
				<label for="package_sales">Количина  во  пакет?</label><input type="checkbox" id="package_qty" name="package_qty" value="1"    <?php echo $package_qty; ?>>
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
