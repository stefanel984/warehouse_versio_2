<?php
function typeDocument($id){
	$setting = new Settings_model();
	$result = $setting->getDocType($id);

	return $result[0]['document_type'];

}
function userName($id_user){
	$user = new Admin_model();
	$result = $user->getUserById($id_user);

	return $result['full_name'];

}
?>
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
	<style>
		.title{
			font-weight: bold;
			text-transform: uppercase;
		}
		.border_all{
			border: 1px solid #000000;
		}
		.border_bottom{
			border-bottom: 1px solid #000000;
		}
	</style>

</head>
<body>
<?php
if(empty($document)){
	$message = "<div class = 'red'>Непостоечки или избришан документ</div>";
	echo $message;
	return 1;
}
$document = $document[0];
$date=date_create($document['date_of_document']);
$date_of_document =  date_format($date,"d/m/Y");
$date=date_create($document['date_entered']);
$date_entered =  date_format($date,"d/m/Y H:i:s");?>
<div class="row top-margin20">
	<div class="col-sm-5"></div>
	<div class="col-sm-2 title"><?php echo $title;?></div>
	<div class="col-sm-5"></div>
</div>
<div class="row top-margin20">
	<div class="col-sm-3"></div>
	<div class="col-sm-6 border_all">
		<div class="row border_bottom">
			<div class="col-sm-8"></div>
			<?php if($document['deleted'] == 0){  ?>
			<div class="col-sm-3">Избриши</div>
			<div class="col-sm-1"><i class="fa fa-trash pointer delete_document" id="delete_document_<?php echo $document['id']; ?>" title="Избриши документ"></i></div>
			<?php }else{  ?>
				<div class="col-sm-4 red">Избришан документ со прикачени документи.</div>
			<?php }  ?>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-6 title">Сериски број:</div>
			<div class="col-sm-6 "><?php echo $document['serial_number']; ?></div>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-6 title">Датум на документ:</div>
			<div class="col-sm-6 "><?php echo $date_of_document; ?></div>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-6 title">Датум на внес:</div>
			<div class="col-sm-6 "><?php echo $date_entered; ?></div>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-6 title">Тип на документ:</div>
			<div class="col-sm-6 "><?php echo typeDocument($document['type']);  ?></div>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-6 title">Внесено од:</div>
			<div class="col-sm-6 "><?php echo userName($document['created_by']);  ?></div>
		</div>
		<div class="row border_bottom">
			<div class="col-sm-4 "></div>
			<div class="col-sm-4 title">Прикачени документи:</div>
			<div class="col-sm-4 "></div>
		</div>
		<?php
		    $i=0;
		    foreach($document_upload as $d){
			$name_array = explode('/',$d['file_path']);
			$n = count($name_array)-1;
			$name = $name_array[$n];
			$i =$i + 1;

			?>
			<div class="row border">
				<div class="col-sm-1"><?php echo $i; ?></div>
				<div class="col-sm-6"><?php echo $name; ?></div>
				<div class="col-sm-4"><a href="<?php echo base_url().$d['file_path']; ?>" target="_blank">Линк за спуштање</a></div>
				<div class="col-sm-1"><i class="fa fa-minus-circle pointer delete_upload_doc" id="doc_<?php echo $d['id'] ?>" title="Избриши прикачен документ"></i></div>
			</div>

		<?php } ?>
	</div>
	<div class="col-sm-3"></div>
</div>
<div class="row top-margin20">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<form method = 'post' action = '<?php  echo base_url().'document/add_upload_document/'.$document['id'] ?>' enctype='multipart/form-data'>
			<div id="add_files">
			</div>
			<button type="button" onclick="addDocument()">Додади документ</button><br/><br/>
			<input type="submit" value="Зачувај документ"  id="add_document" disabled="disabled"/>
		</form>
	</div>
	<div class="col-sm-3"></div>
</div>


</body>
</html>
<script>
	function addDocument(){
		$('#add_files').append('<span class="doc_upload"><label for="document_upload"> Внеси документ<span class="required">*</span></label><input type="file" class="file"  name="document[]"   accept="image/gif, image/jpeg, image/png, image/jpg, application/pdf" required/><i class="fa fa-minus-circle grey f-size-20 pointer delete_doc" title="Избриши внес на документ"></i><br/><br/></span>');
		$('#add_document').removeAttr('disabled');
	}
	$(document).on("click", ".delete_doc",function() {
		$(this).closest('span.doc_upload').remove();
		let num = $(".doc_upload").length;
		if(num == 0){
			$('#add_document').attr('disabled','disabled');
		}
	})
	$('.delete_upload_doc').click(function(){
		let id_i =  $(this).attr('id');
		let id_array = id_i.split('_');
		let id = id_array[1];

		$.ajax({
			url: "<?php echo base_url()?>/document/delete_upload_doc",
			type: "post",
			async: false,
			dataType:"json",
			data : {"id":id},
			success: function(data){
               if(data.result == 'success'){
                  $('#'+id_i).closest('.row').remove();
			   }
			}
		});
	});
	$('.delete_document').click(function(){
		let id_i =  $(this).attr('id');
		let id_array = id_i.split('_');
		let id = id_array[2];


		$.ajax({
			url: "<?php echo base_url()?>/document/delete_document",
			type: "post",
			async: false,
			dataType:"json",
			data : {"id":id},
			success: function(data){
				if(data.result == 'success'){
					window.location = "<?php echo base_url()?>/document/document_detail/"+id;
				}
			}
		});
	});
	$(document).on("change", ".file",function() {
		let doc_name = this.files[0].name;
		if(this.files[0].size > 10485760){
			alert('Документот надминува 10MB');
			this.value = '';
		}
		let format = doc_name.split(".");
		let n = format.length;
		let allow_format = ["gif","jpg","png","jpeg","pdf"];
		if(jQuery.inArray(format[n-1],allow_format) == -1){
			alert('Документот е од недозволен формат. Дозволени формати .gif, .png, .jpg, .jpeg, .pdf');
			this.value = '';
		};
	});
</script>

