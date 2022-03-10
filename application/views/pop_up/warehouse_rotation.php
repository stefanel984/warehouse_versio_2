<div class="row top-margin20 admin_background">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
				<table id='article_rotation' class='display table' style='width:100%'>
					<thead>
						<tr>
							<th>Сериски број</th>
							<th>Артикл</th>
							<th>Боја</th>
							<th>Количина</th>
							<th>Цена</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
				foreach ($articles as $article){
					?>
						 <tr>
							<td><?php echo $article['serial_number']; ?></td>
							<td><?php echo $article['article_name']; ?></td>
							<td><?php echo $article['color']; ?></td>
							<td><?php echo $article['qty']; ?></td>
							<td><?php echo $article['price_total'] ?></td>
							 <td><span><i class="fa fa-plus-square f-size-20 grey pointer r_rotation"  id="rotation_<?php echo $article['id']; ?>" title="Припреми ролна за ротација"></i></span></td>
						 </tr>
				<?php
				}
				?>
					 </tbody>
				</table>
		<form method='post' action='<?php echo base_url(); ?>warehouse/rotation'>
			<input type='hidden' name='old_section' value='<?php echo $id; ?>'>
			<label>Избери локација<span class="required">*</span></span></label>
			<select id="location" name="location" class="top-margin20" required>
				<option value=" ">---избери локација----</option>
				<?php
				foreach($area as $a){
					?>
					<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
						<?php
						foreach($location as $l){
							$selected = "";
							if($l['price'] > 0){
								if($a['id'] == $l['id_area']){
									if($l['id'] == $uri){
										$selected = 'selected';
									}
									?>
									<option value="<?php echo $l['id']; ?>" <?php echo $selected; ?>><?php echo $l['name']; ?></option>
									<?php
								}
							}
						}
						?>
					</optgroup>

					<?php
				}
				?>
			</select><br/><br/>
			<div id="list_article_rotation">
				<div class='list_article'>Артикли спремни за ротација</div><br/>

			</div>
			<br/>
			<br/>
			<input type="submit" value="Ротирај ролни"  id="rotate_article" disabled="disabled"/>
		</form>
	</div>
	<div class="col-sm-1"></div>
</div>

