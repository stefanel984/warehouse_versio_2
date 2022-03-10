<div>
	<div class="row top-margin20">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<form method = 'post' action = '<?php  echo base_url().'document/upload_document' ?>' enctype='multipart/form-data'>
				<div class="form-group">
					<label for="name">S Number:<span class="required">*</span></label>
					<input type="text" class="form-control" id="serial_number" name="serial_number">
				</div>
				<label for="name">Датум на документ:<span class="required">*</span></label>
				<div class="input-group date" data-date-format="dd.mm.yyyy">
					<input  type="text" class="form-control" name='date_of_document' placeholder="dd.mm.yyyy" required>
					<div class="input-group-addon" >
						<span class="glyphicon glyphicon-th"></span>
					</div>
				</div><br/><br/>
			    <label for="name">Тип на документ:<span class="required">*</span></label>
				<select id="type" name="type" required>
					<option value="">--избери тип на документ--</option>
					<?php foreach($document_type as $type){
						       if($type['deleted'] == 0){
						?>

						<option value="<?php echo $type['id']; ?>"><?php echo $type['document_type']; ?></option>
					<?php  }
					}?>
				</select>
				<div id="add_files">
					<span class="doc_upload"><label for="document_upload"> Внеси документ<span class="required">*</span></label><input type="file" class="file"   name="document[]"   accept="image/gif, image/jpeg, image/png, image/jpg, application/pdf" required/></span><br/><br/>
				</div>
				<button type="button" onclick="addDocument()">Додади документ</button><br/><br/>
				<input type="submit" value="Зачувај документ"  id="add_document" />
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<script>
	$('.input-group.date').datepicker({format: "dd.mm.yyyy"});
	function addDocument(){
		$('#add_files').append('<span class="doc_upload"><label for="document_upload"> Внеси документ<span class="required">*</span></label><input type="file" class="file"   name="document[]"   accept="image/gif, image/jpeg, image/png, image/jpg, application/pdf" required/><i class="fa fa-minus-circle grey f-size-20 pointer delete_doc" title="Избриши внес на документ"></i><br/><br/></span>');
	}
	$(document).on("click", ".delete_doc",function() {
		$(this).closest('span.doc_upload').remove();
	})
	$(document).on("change", ".file",function() {
		let doc_name = this.files[0].name;
		if(this.files[0].size > 10485760 ){
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
