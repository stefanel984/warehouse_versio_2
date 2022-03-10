$(document).ready(function () {
	$('.rotation').click(function(){
		$('#rotation_html').html('');
		let id_text = $(this).attr('id');
		let id_array = id_text.split("_");
		let id = id_array[1];
		let amount = $('#amount_'+id).val();
		if(amount != 0) {


			window.location = "../dashboard/rotationHtml/"+id;

		}
		else{
			alert('Празна локација');
		}

	});
	$('#location').change(function(){
		let numArticle = $('.list_article').length;
		let loc = $('#location').val();
		if(numArticle > 1 && loc != 0){
			$('#rotate_article').removeAttr('disabled');
		}
		else{
			$('#rotate_article').attr('disabled', 'disabled');
		}

	})








})
$(document).on("click", ".r_rotation",function() {
	let id_text = $(this).attr('id');
	let id_array = id_text.split("_");
	let id = id_array[1];
	let c_span = $(this).closest('span');
	let new_sum = $('#sum').val();
	new_sum = parseFloat(new_sum);
	$.ajax({
		url: "../../warehouse/takeArticleWarehouse",
		type: "post",
		async: false,
		dataType:"json",
		data : { "id_warehouse": id},
		success: function(data){
			c_span.remove();
			var article = data[0];
			new_sum = new_sum - parseFloat(article['price_total']);
			var html = "<div class='list_article'>"+article['name']+" Цена: "+article['price_total']+"<input type='hidden' name='article_id[]'  class= 'article_id'  value='"+article['id']+"'  required/>" +
				"<i class='fa fa-minus-circle f-size-20 grey right right-margin10 pointer delete_article' aria-hidden='true'></i></div><br/>";
			$('#list_article_rotation').append(html);

		}
	});

	new_sum = parseFloat(new_sum).toFixed(1);
	$('#sum').removeAttr('readonly');
	$('#sum').val(new_sum);
	$('#sum').attr('readonly','readonly');


	let numArticle = $('.list_article').length;
	let loc = $('#location').val();
	if(numArticle > 1 && loc != 0){
		$('#rotate_article').removeAttr('disabled');
	}
});


