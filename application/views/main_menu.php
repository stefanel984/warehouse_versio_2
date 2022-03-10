<?php
function activeList($id_user){
	$user = new Issueslip_model();
	$result = $user->checkActive($id_user);

	return $result;

}
function numberList($id_user){
	$user = new Issueslip_model();
	$is_array = $user->selectActive($id_user);

	return $is_array['id'];

}
?>
<ul>
	<li><a href="<?php echo base_url(); ?>dashboard/">Преглед</a></li>
	<li><a href="<?php echo base_url(); ?>warehouse/warehouse">Преглед артикли</a></li>
	<li><a href="<?php echo base_url(); ?>location/">Локација</a></li>
	<li><a href="<?php echo base_url(); ?>warehouse/">Внес</a></li>
	<li><a href="<?php echo base_url(); ?>warehouse/outgoing">Излез</a></li>
	<li><a href="<?php echo base_url(); ?>product/add_product">Артикл карактеристики</a></li>
	<li><a href="<?php echo base_url(); ?>product/view_product">Артикли преглед</a></li>
	<li><a href="<?php echo base_url(); ?>snumber">S број</a></li>
	<?php  if($_SESSION['user_info']['is_admin'] == 1){ ?>
		<div id="admin_button" class="pointer">Админ</div>
		<li class="hide submenu admin"><a href="<?php echo base_url(); ?>settings/index">Склад Админ</a></li>
		<li class="hide submenu admin"><a href="<?php echo base_url(); ?>settings/document">Документ Админ</a></li>
	<?php } ?>
	<li><a href="<?php echo base_url(); ?>log/">Логови</a></li>
	<li><a href="<?php echo base_url(); ?>document/index">Документи</a></li>
	<li><a href="<?php echo base_url(); ?>issueslip/list">Излезни листи</a></li>
	<?php
	   if(activeList($_SESSION['user_info']['user_id'])){
	   	 $list_number = numberList($_SESSION['user_info']['user_id']);
	?>
		   <li><a href="<?php echo base_url()?>warehouse/list_view/<?php echo $list_number?>" class="red">Активна листа</a></li>
	<?php
	   }
	?>
	<li><a href="<?php echo base_url(); ?>login/logout">Одлогирај се!</a></li>

</ul>


