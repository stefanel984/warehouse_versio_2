<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $tab;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
	<script src="<?php echo base_url();?>js/general.js"></script>
	<script src="<?php echo base_url();?>js/function.js"></script>
	<script src="<?php echo base_url();?>js/dashboard.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
	<script type="text/javascript" src="<?php echo base_url();?>js/DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/DataTables/datatables.min.css"/>
	<link type="text/css" href="<?php echo base_url();?>css/main_menu.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url();?>css/main.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url();?>css/dashboard.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>

</head>
<body>
    <div class="row horizontal_tab">
		<div class="col-sm-2"></div>
		<?php
		      $logged = false;
		      if(isset($_SESSION['user_info']) && (($_SESSION['user_info']['logged_in']) == true)){
				  $logged = true;
		?>

				  <div class="col-sm-10"><span class="login_user right right-margin20">Најавени сте како <?php echo $_SESSION['user_info']['full_name'] ?> <a class="logout" href="<?php echo base_url(); ?>login/logout">Одлогирај се!</a></span></div>
		<?php
			  }
		      else{
		?>
				  <div class="col-sm-10"></div>
		<?php
		}
		?>

	</div>
	<div class="row">
		<div class="col-sm-1 sidebar">
			<?php
			  if($logged == true){
			  	include 'main_menu.php';
			  }
			?>


		</div>
		<div class="col-sm-10">
			<?php include $content.".php";?>
		</div>
		<div class="col-sm-1"></div>
	</div>

</body>
</html>
