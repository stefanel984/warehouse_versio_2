$(document).ready(function () {
	var article = {};
	$('select').selectize({
		sortField: 'text'
	});
	$('.input-daterange input').each(function() {
		$(this).datepicker('clearDates');
	});
	var table_id = $('.table').attr('id');
	if(table_id == 'log_table' || table_id == 'article' || table_id == 'document_table' || table_id == 'view_issueslip' || table_id == 'all_article') {
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var min = $('#min').datepicker("getDate");
				var max = $('#max').datepicker("getDate");
				var startDate = new Date(data[1]);
				if (min == null && max == null) { return true; }
				if (min == null && startDate <= max) { return true; }
				if (max == null && startDate >= min) { return true; }
				if (startDate <= max && startDate >= min) { return true; }
				return false;
			}
		);
	}
	let col = 0;
	let order = 'asc';
	let ordering = true;
	let per_page = [[10, 25, 50, -1], [10, 25, 50, "All"]];
	let columnDefs = [];
	if(table_id == 'article'){

		 col = 4;
		 order = 'desc';
		 columnDefs =  [{
						"targets": [ 1 ],
						"visible": false

		              },
					 {
						 "orderable": false,
						 "targets": [5]

					 }]


	}
	else if(table_id == 'product_detail'){
		col = 0;
		order = 'desc';

	}
	else if(table_id == 'article_out_table'){

		col = 3;
		order = 'desc'

		per_page = [[10], [10]];

		columnDefs =  [{
			"orderable": false,
			"targets": [6,9]

		}];

	}
	else if(table_id == 'log_table'){

		col = 2;
		order = 'desc';
		columnDefs =  [{
			"targets": [ 1 ],
			"visible": false

		}]

	}
	else if(table_id == 'view_user' || table_id == 'view_measure_table'){

		per_page = [[10], [10]];
		ordering = false;

	}
	else if(table_id == 'document_table'){

		col = 4;
		order = 'desc'
		columnDefs =  [{
			"targets": [1,7],
			"searchable": true,
			"visible": false

		}]

	}
	else if(table_id == 'view_list'){
		col = 0;
		order = 'desc';
		per_page = [[10], [10]];


	}
	else if(table_id == 'view_issueslip'){
		col = 0;
		order = 'desc';
		columnDefs =  [{
			"orderable": false,
			"targets": [4,5]

		}, {
			"targets": [1],
			"searchable": true,
			"visible": false

			}];

	}
	else if(table_id == 's_numberdetails'){
		columnDefs =  [{
			"orderable": false,
			"searchable": false,
			"targets": [3]
		}];

	}
	else if(table_id == 'all_article'){
		col = 5;
		order = 'desc';
		columnDefs =  [{
			"targets": [ 1 ],
			"visible": false

		}]

	}
	else if(table_id == 'weight_list'){
		columnDefs =  [{
			"orderable": false,
			"searchable": false,
			"targets": [0,1,2,3,4,5]
		}];

	}

	var table = $('#' + table_id).DataTable({
				"order": [[col, order]],
				"aLengthMenu": per_page,
		        "ordering": ordering,
		        "columnDefs":columnDefs
			});
	if(table_id == 'article_out_table'){

		$("#location_choice").on('change', function() {
			table.column(0).search($(this).val()).draw();
		});
		$("#color").on('change', function() {
			table.column(2).search($(this).val()).draw();
		});
	}
	if(table_id == 'log_table') {

		$("#action").on('change', function() {
			table.column(0).search($(this).val()).draw();
		});
		$("#users").on('change', function() {
			table.column(3).search($(this).val()).draw();
		});

		$('.date-range-filter').change(function () {
			var table = $('#' + table_id).DataTable();
			table.draw();
		});
	}
	if(table_id == 'article'){
		$("#article_used").on('change', function() {
			table.column(2).search($(this).val()).draw();
		});
		$("#color").on('change', function() {
			table.column(3).search($(this).val()).draw();
		});
		$('.date-range-filter').change(function () {
			var table = $('#' + table_id).DataTable();
			table.draw();
		});
	}
	if(table_id == 'document_table'){
		$('.date-range-filter').change(function () {
			var table = $('#' + table_id).DataTable();
			table.draw();
		});
		$("#year").on('change', function() {
			table.column(7).search($(this).val()).draw();
		});
		$("#type").on('change', function() {
			table.column(2).search($(this).val()).draw();
		});
		$("#users").on('change', function() {
			table.column(5).search($(this).val()).draw();
		});

	}
	if(table_id == 'product_detail'){
		$("#s_number").on('keyup', function() {
			table.column(1).search($(this).val()).draw();
		});
		$("#article_used").on('change', function() {
			table.column(4).search($(this).val()).draw();
		});
		$("#in_stock").on('change', function() {
			table.column(8).search($(this).val()).draw();
		});

	}
	if(table_id == 'view_issueslip'){
		$('.date-range-filter').change(function () {
			var table = $('#' + table_id).DataTable();
			table.draw();
		});
		$("#users").on('change', function() {
			table.column(4).search($(this).val()).draw();
		});

	}
	if(table_id == 'all_article'){
		$('.date-range-filter').change(function () {
			var table = $('#' + table_id).DataTable();
			table.draw();
		});
		$("#location").on('change', function() {
			table.column(2).search($(this).val()).draw();
		});
		$("#article_used").on('change', function() {
			table.column(3).search($(this).val()).draw();
		});
		$("#color").on('change', function() {
			table.column(4).search($(this).val()).draw();
		});
	}



	$('.date-range-filter').datepicker();






	$('#view_color_button').click(function () {
		$('#view_color').addClass('show');
		$('#view_location').addClass('hide');
		$('#view_article').addClass('hide');
		$('#view_measure').addClass('hide');

		$('#view_color').removeClass('hide');
		$('#view_location').removeClass('show');
		$('#view_article').removeClass('show');
		$('#view_measure').removeClass('show');

	});
	$('#view_article_button').click(function () {
		$('#view_color').addClass('hide');
		$('#view_location').addClass('hide');
		$('#view_article').addClass('show');
		$('#view_measure').addClass('hide');

		$('#view_color').removeClass('show');
		$('#view_location').removeClass('show');
		$('#view_article').removeClass('hide');
		$('#view_measure').removeClass('show');

	});
	$('#view_measure_button').click(function () {
		$('#view_color').addClass('hide');
		$('#view_location').addClass('hide');
		$('#view_article').addClass('hide');
		$('#view_measure').addClass('show');

		$('#view_color').removeClass('show');
		$('#view_location').removeClass('show');
		$('#view_article').removeClass('show');
		$('#view_measure').removeClass('hide');

	});
	$('#view_location_button').click(function () {
		$('#view_color').addClass('hide');
		$('#view_location').addClass('show');
		$('#view_article').addClass('hide');
		$('#view_measure').addClass('hide');

		$('#view_color').removeClass('show');
		$('#view_location').removeClass('hide');
		$('#view_article').removeClass('show');
		$('#view_measure').removeClass('show');

	});
	dialog_area = $( "#dialog-form-location" ).dialog({
		autoOpen: false,
		height: 400,
		width: 350,
		modal: true,
		buttons: {
			"Додај ареа": addArea,
			Cancel: function() {

				dialog_area.dialog( "close" );
			}
		}
	});
	$('#new_area').click(function(){
		dialog_area.dialog( "open" );
	});


	$('.edit_user').click(function(){
		 var id_user = this.id;
		$('#dialog_user').html('');
		$.ajax({
			url: "../login/changePasswordHtml",
			type: "post",
			async: false,
			dataType:"html",
			data : { "id_user": id_user},
			success: function(data){
				$('#dialog_user').append(data);
				dialog_edit_user.dialog( "open" );
			}
		});
	});
	$('.view_user').click(function(){
		var id = this.id;
		var id_user = id.split('_');
		$('#dialog_user_view').html('');
		$.ajax({
			url: "../login/viewPasswordHtml",
			type: "post",
			async: false,
			dataType:"html",
			data : { "id_user": id_user[1]},
			success: function(data){
				$('#dialog_user_view').append(data);
				dialog_view_user.dialog( "open" );
			}
		});
	});
	$(document).on("click", ".delete_user",function() {
		var id = this.id;
		var id_user = id.split('_');
		$.ajax({
			url: "../login/delete_restore",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id_user": id_user[1], "action":"delete"},
			success: function(data){
				$('#'+id).closest('td').html('<i class="fa fa-repeat pointer restore_user" id="delete_'+id_user[1]+'" title="Избриши корисник"></i>');
			}
		});
	});
	$(document).on("click", ".restore_user",function() {
		var id = this.id;
		var id_user = id.split('_');
		$.ajax({
			url: "../login/delete_restore",
			type: "post",
			async: false,
			dataType:"json",
			data : { "id_user": id_user[1], "action":"restore"},
			success: function(data){
				$('#'+id).closest('td').html('<i class="fa fa-minus-circle  pointer delete_user" id="delete_'+id_user[1]+'" title="Врати корисник"></i>');
			}
		});
	});
	dialog_edit_user = $( "#dialog_user" ).dialog({
		autoOpen: false,
		height: 400,
		width: 350,
		modal: true,
		buttons: {
			"Потврди промена": changeUserDetails,
			Cancel: function() {
				dialog_edit_user.dialog( "close" );
			}
		},
		close: function() {
			dialog_edit_user.dialog( "close" );
		}
	});
	dialog_view_user = $( "#dialog_user_view" ).dialog({
		autoOpen: false,
		height: 400,
		width: 500,
		modal: true,
		buttons: {
			Cancel: function() {
				dialog_view_user.dialog( "close" );
			}
		},
		close: function() {
			dialog_view_user.dialog( "close" );
		}
	});
	$('#password_confirm').change(function(){
	       	let pass = $('#password').val();
		    let pass_confirm = $('#password_confirm').val();
		    if(pass != pass_confirm){
				alert('Имате разлика помеѓу лозинката и потврда на лозинка!');
			}
	});
	$('#new_user').change(function(){
		let username = $('#new_user').val();
		$.ajax({
			url: "../login/checkExistingUser",
			type: "post",
			async: false,
			dataType:"json",
			data : { "username": username},
			success: function(data){
				if(data.exist == "yes"){
					$('#new_user').val('')
					alert('Постои корисник со истото име!');
				}
			}
		});

	});
	$(document).on("click", ".log_details",function() {
		var id_warehouse = $(this).attr('id');
		$.ajax({
			url: "../log/log_detail",
			type: "post",
			async: false,
			dataType:"html",
			data : { "id": id_warehouse},
			success: function(data){
				$('#log_detail_view').html('');
				$('#log_detail_view').html(data);
				dialog.dialog( "open" );
			}
		});
	});

	dialog = $( "#log_detail_view" ).dialog({
		autoOpen: false,
		height: 400,
		width: 900,
		modal: true,
		buttons: {
			'Затвори': function() {
				dialog.dialog( "close" );
			}
		},
	});

	$( "#admin_button" ).click(function() {
		if($( ".submenu" ).hasClass("hide")) {
			$(".submenu").removeClass("hide");
			$(".submenu").addClass("show");
		}
		else{
			$(".submenu").removeClass("show");
			$(".submenu").addClass("hide");
		}

	});




});
