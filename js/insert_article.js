article = getAllArticle();
$('.article_in').change(function () {
	let article_id = $(this).val();
	$(this).closest('tr').find('td.measure').html('');
	$(this).closest('tr').find('td.measure').append('<b>'+article[article_id].measure_name[0].name+'</b>');
    if(article[article_id].has_width == 1){
		$(this).closest('tr').find('.width_in').removeAttr('readonly');
		$(this).closest('tr').find('.width_in').attr('required', 'required');
		$(this).closest('tr').find('.width_in').val(1.45);

	}
    else{
		$(this).closest('tr').find('.width_in').removeAttr('required');
		$(this).closest('tr').find('.width_in').attr('readonly', 'readonly');
		$(this).closest('tr').find('.width_in').val(0);

	}
	if(article[article_id].add_package_qty == 1){
		$(this).closest('tr').find('.package_in').removeAttr('readonly');
		$(this).closest('tr').find('.package_in').attr('required', 'required');

	}
	else{
		$(this).closest('tr').find('.package_in').removeAttr('required');
		$(this).closest('tr').find('.package_in').attr('readonly', 'readonly');

	}
});

function getAllArticle(){
	var result = ''
	$.ajax({
		url: "../article/getAllArticle",
		type: "post",
		async: false,
		dataType:"html",
		success: function(data){
			result = JSON.parse(data);
		}
	});
	return result;
}


