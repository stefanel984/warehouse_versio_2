function addArea(){
	let new_area = $('#add_area').val();
	let v = $('#area')[0].selectize;
	v.addOption({value:new_area,text:new_area}); //option can be created manually or loaded using Ajax
	v.refreshOptions();
	v.addItem(new_area);
	dialog_area.dialog( "close" );
}
function changeUserDetails(){
	let email = $('#email').val();
	let phone = $('#telephone').val();
	if(email !='' && phone !=''){
		let phone_2 = $('#telephone_2').val();
		let user_id = $('#user_id').val();
		let admin  = '0';
		if ($("#admin").is(":checked")) {
			admin = '1'
		}
		$.ajax({
			url: "../login/update_user",
			type: "post",
			async: false,
			dataType:"json",
			data : { "email": email, "phone":phone,"other_mobile":phone_2,"user_id":user_id, 'is_admin':admin, 'action':'update'},
			success: function(data){
				dialog_edit_user.dialog( "close" );
			}
		});
	}
	else{
		alert('Внесете емаил и мобилен телефон. Задолжителни податоци');
	}

}
function delete_settings(type, action, id){
	$.ajax({
		url: "../settings/settings_update",
		type: "post",
		async: false,
		dataType:"json",
		data : { "type": type, "action":action,"id":id},
		success: function(data){
			if(data.return == true){
				let class_fa = 'fa-minus-circle';

				if(action == 'delete'){
					action = 'restore';
					class_fa = 'fa-repeat';
				}
				else{
					action = 'delete';
				}
				$('#'+type+'_'+id).closest('div').html(`<i class="fa `+class_fa+` pointer delete_settings"`+
					`onClick="delete_settings('`+type+`', '`+action+`', '`+id+`')"`+
					`id="`+type+`_`+id+`" title="Избриши Артикл"></i>`);

			}
		}
	});

}
function document_settings(type, action, id){
	$.ajax({
		url: "../settings/document_update",
		type: "post",
		async: false,
		dataType:"json",
		data : { "type": type, "action":action,"id":id},
		success: function(data){
			if(data.return == true){
				let class_fa = 'fa-minus-circle';
				let title = 'Избриши тип на документ';

				if(action == 'delete'){
					action = 'restore';
					class_fa = 'fa-repeat';
					title='Додади тип на документ';
				}
				else{
					action = 'delete';

				}
				$('#'+type+'_'+id).closest('div').html(`<i class="fa `+class_fa+` pointer document_settings"`+
					`onClick="document_settings('`+type+`', '`+action+`', '`+id+`')"`+
					`id="`+type+`_`+id+`" title="`+title+`"></i>`);

			}
		}
	});

}
function showOnlyDeleted(){
	let show = $('#show_only_deleted').val();
	showAll();

	if(show == 0){
		$('.fa-minus-circle').closest('div').closest('div.row').hide();
		$('#show_only_deleted').val(1);
		$('#show_only_not_deleted').val(0);
		$( "#show_only_not_deleted" ).prop( "checked", false );
	}
	else{
		$('.fa-minus-circle').closest('div').closest('div.row').show();
		$('#show_only_deleted').val(0);

	}
}
function showOnlyNotDeleted(){
	showAll();
	let show = $('#show_only_not_deleted').val();

	if(show == 0){
		$('.fa-minus-circle').closest('div').closest('div.row').show();
		$('#show_only_deleted').val(0);
		$( "#show_only_deleted" ).prop( "checked", false );
		$('#show_only_not_deleted').val(1);
		$('.fa-repeat').closest('div').closest('div.row').hide();

	}

}
function showAll(){
	$('.fa-repeat').closest('div').closest('div.row').show();
	$('.fa-minus-circle').closest('div').closest('div.row').show();
}




