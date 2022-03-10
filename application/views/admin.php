<?php
function merka($id){
	$measure = new Settings_model();
	$result = $measure->getMeasureById($id);

	return $result[0]['name'];

}
function area($id){
	$area = new Area_model();
	$result = $area->getAreaById($id);

	return $result['name'];

}
function user($id){
	$area = new Admin_model();
	$result = $area->getUserById($id);

	return $result;

}
?>
<div class="row top-margin20 admin_background">
	<div class="col-sm-1"></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>settings/color">Боја</a></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>article">Артикл</a></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>settings/measure">Мерка</a></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>login/user">Корисници</a></div>
	<div class="col-sm-2"><a class="admin_link" href="<?php echo base_url(); ?>location/location">Локации</a></div>
	<div class="col-sm-1"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 view_button" id="view_location_button">Преглед Локаци</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2 view_button" id="view_color_button">Преглед Бои</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2 view_button" id="view_article_button">Преглед Артикли</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2 view_button" id="view_measure_button">Преглед Мерки</div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-11">
		<div class="row view show" id="view_location">
			<div class="col-sm-12" >
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-3"><b>Локација</b></div>
						<div class="col-sm-2"><b>Ареа</b></div>
						<div class="col-sm-3"><b>Креирано од</b></div>
						<div class="col-sm-2"></div>
					</div>
			</div>
			<div class="col-sm-12" >
				<?php foreach ($location as $l){
					$area = area($l['id_area']);
					$user = user($l['created_by'])?>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-3"><?php echo $l['name']; ?></div>
						<div class="col-sm-2"><?php echo $area; ?></div>
						<div class="col-sm-3"><?php echo $user['full_name']; ?></div>
						<div class="col-sm-2"></div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="row view hide" id="view_color">
			<div class="col-sm-12" >
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-5"><b>Боја</b></div>
						<div class="col-sm-3"></div>
						<div class="col-sm-2"></div>
					</div>
			</div>
			<div class="col-sm-12" >
				<?php foreach ($color as $c){ ?>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-5"><?php echo $c['name']; ?></div>
					<div class="col-sm-3"><img src="<?php echo base_url().$color_image."/".$c['img']; ?>" class="img_view" width="20" height="20"/></div>
					<div class="col-sm-2"></div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row view hide" id="view_article">
			<div class="col-sm-12" style = 'margin-top: 3px; margin-left: 5px;'>
				<input type="text" id="search-article"/>
				<input type="button" id="search" value="Пребарај артикл"/>
			</div>
			<div class="col-sm-12" style = 'margin-top: 3px; margin-left: 5px;'>
				<input type="checkbox"  value="0" id="show_only_not_deleted" onclick="showOnlyNotDeleted()"> Прикажи активните продукти
				<input type="checkbox"  value="0" id="show_only_deleted" onclick="showOnlyDeleted()"> Прикажи само избришани
			</div>
			<div class="col-sm-12" >
					<div class="row">
						<div class="col-sm-4"><b>Артикл</b></div>
						<div class="col-sm-4"><b>Мерка</b></div>
						<div class="col-sm-2"></div>
						<div class="col-sm-2"></div>
					</div>
			</div>
			<div class="col-sm-12" >
				<?php foreach($article as $a) {
					$merka = merka($a['measure']);?>
				<div class="row">
					<div class="col-sm-4 article-name"><?php echo $a['name']; ?></div>
					<div class="col-sm-4"><?php echo $merka; ?></div>
					<?php if($a['deleted'] == 0){ ?>
						<div class="col-sm-2"><a href="<?php echo base_url().'article/edit_article/'.$a['id'] ?>"><i class="fa fa-edit edit_user pointer black"  title="Промена артикл"></i></a></div>
					<div class="col-sm-2"><i class="fa fa-minus-circle pointer delete_settings"  onclick="delete_settings('article', 'delete', '<?php echo $a['id']; ?>')" id="article_<?php echo $a['id']; ?>" title="Избриши Артикл"></i></div>
					<?php } else { ?>
						<div class="col-sm-2"></div>
						<div class="col-sm-2"><i class="fa fa-repeat pointer delete_settings"  onclick="delete_settings('article', 'restore', '<?php echo $a['id']; ?>')" id="article_<?php echo $a['id']; ?>" title="Додади Артикл"></i></div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row view hide" id="view_measure">
			<div class="col-sm-12" >
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4"><b>Мерка</b></div>
						<div class="col-sm-4"></div>
						<div class="col-sm-2"></div>
					</div>
			</div>
			<div class="col-sm-12" >
				<?php foreach($measure as $m){ ?>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-4"><?php echo $m['name']; ?></div>
					<div class="col-sm-4"></div>
					<div class="col-sm-2"></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#show_only_not_deleted').val(0);
		$( "#show_only_not_deleted" ).prop( "checked", true );
		$('#show_only_deleted').val(0);
		$( "#show_only_deleted" ).prop( "checked", false );
		showOnlyNotDeleted();
		$('#search').click(function(){
			$('.article-name').closest('.row').hide();
			var txt = $('#search-article').val();
			$('.article-name').each(function(){
				if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
					$(this).closest('.row').show();
				}
			});
		});
	})
</script>
