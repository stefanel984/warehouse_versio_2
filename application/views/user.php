<div class="row top-margin20 admin_background">
	<div class="col-sm-4"></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>login/add_user">Додади нов корисник</a></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>login/user">Преглед на корисници</a></div>
	<div class="col-sm-4"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<table id="view_user" class="display table" style="width:100%">
			<thead>
			<tr>
				<th>Корисник</th>
				<th>Корисничко име</th>
				<th>Привилегии</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			</thead>
			<tbody>
                <?php
				$user_id = $_SESSION['user_info']['user_id'];
				foreach($user as $u){
					$admin = '';
					if($u['is_admin'] == 1){
						$admin = 'Administrator';
					}
						?>
					<tr>
						<td><div class="view_user pointer link" id="view_<?php echo $u['id']; ?>" title="Преглед податоци"><?php echo $u['full_name']; ?></div></td>
						<td><?php echo $u['username']; ?></td>
						<td><?php echo $admin; ?></td>
						<td><i class="fa fa-edit edit_user pointer" id="<?php echo $u['id']; ?>" title="Промена на податоци"></i></td>
						<td><a class="admin_link" href="<?php echo base_url(); ?>login/edit_pass/<?php echo $u['id']; ?>"><i class="fa fa-key pointer "  title="Промена на лозинка"></i></a></td>
						<?php if($u['id'] != $user_id){ ?>
						<?php 		if($u['deleted'] == 0){ ?>
						<td><i class="fa fa-minus-circle pointer delete_user" id="delete_<?php echo $u['id']; ?>" title="Избриши корисник"></i></td>
						<?php 		} else{ ?>
						<td><i class="fa fa-repeat pointer restore_user" id="delete_<?php echo $u['id']; ?>" title="Врати корисник"></i></td>
						<?php 				}
						      }else{
						?>
						<td></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-2"></div>
</div>
<div id="dialog_user">

</div>
<div id="dialog_user_view">

</div>
<script>

</script>

