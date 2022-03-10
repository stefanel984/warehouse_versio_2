<div class="row top-margin20 admin_background">
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-1"></div>
</div>
<div class="row top-margin60">
	<div class="col-sm-1"></div>
	<div class="col-sm-3 view_button" id="view_type_button">Преглед типови документи</div>
	<div class="col-sm-8"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-11">
		<div class="row view show" id="view_type">
			<div class="col-sm-12" style = 'margin-top: 3px; margin-left: 5px;'>
				<input type="text" id="type_document"/>
				<input type="button" id="add_type" value="Додади тип"/>
			</div>
			<div class="col-sm-12" >
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-3"><b>Тип</b></div>
					<div class="col-sm-2"></div>
					<div class="col-sm-3"></div>
					<div class="col-sm-2"></div>
				</div>
			</div>
			<div class="col-sm-12" id="doc_type" >
					<?php foreach ($document_type as $d){?>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-3"><?php echo $d['document_type']; ?></div>
							<?php if($d['deleted'] == 0){ ?>
								<div class="col-sm-2"><i class="fa fa-minus-circle pointer delete_settings"  onclick="document_settings('document', 'delete', '<?php echo $d['id']; ?>')" id="document_<?php echo $d['id']; ?>" title="Избриши тип на документ"></i></div>
							<?php } else { ?>
								<div class="col-sm-2"><i class="fa fa-repeat pointer delete_settings"  onclick="document_settings('document', 'restore', '<?php echo $d['id']; ?>')" id="document_<?php echo $d['id']; ?>" title="Додади тип на документ"></i></div>
							<?php } ?>
							<div class="col-sm-3"></div>
							<div class="col-sm-2"></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#add_type').click(function(){
		let new_type=$("#type_document").val();
		$.ajax({
			url: "<?php echo base_url()?>settings/addDocType",
			type: "post",
			async: false,
			dataType:"json",
			data : { "type": new_type},
			success: function(data){
				let class_fa = 'fa-minus-circle';
				let title = 'Избриши тип на документ';
				let type = 'document';
				let action = 'delete'
				if(data.return ==  true){
					let html = `<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-3">`+data.type+`</div>
							<div class="col-sm-2"><i class="fa `+class_fa+` pointer document_settings"`+
							`onClick="document_settings('`+type+`', '`+action+`', '`+data.id+`')"`+
							`id="`+type+`_`+data.id+`" title="`+title+`"></i></div>
							<div class="col-sm-3"></div>
							<div class="col-sm-2"></div>
						</div>`;
					$('#doc_type').append(html);
				}
				else{
					alert(data.message);
				}
			}
		});
	})

</script>


