<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin60">
		<div class="col-sm-12">
			<form method = 'post' action = '<?php  echo base_url().'product/add_in_product' ?>'>
				<input type="hidden"  value="" id="location" name="location"/>
				<input type="hidden"  value=0 id="number_of" name="number_of"/>
				<table id="warehouse" width="100%">
					<thead>
					<tr>
						<th width="20%">S број</th>
						<th width="7%">T број</th>
						<th width="20%">Артикл</th>
						<th width="10%">Количество</th>
						<th width="13%">Мерка</th>
						<th width="10%">Цена</th>
						<th width="10%">Валута</th>
						<th width="5%">Курс</th>
						<th width="5%">Избриши</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<br/>
				<i class="fa fa-plus-square f-size grey pointer top-margin20" id='new_article' title="Додавање на нов влез"></i>
				<br/><br/>
				<input type="submit" value="Внеси артикли"  id="input_article" />
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('form').on('submit', function(e){
			var rowCount = $('table#warehouse tbody tr').length;
			if(rowCount == 0){
				alert('Внесете еден артикл');
				e.preventDefault();
			}
		});

		function allArticle(){
			var result = ''
			$.ajax({
				url: "<?php echo base_url()?>article/getAllArticleProductSelect",
				type: "post",
				async: false,
				dataType:"html",
				success: function(data){
					result = data;
				}
			});
			return result;
		}

		function allMeasure(){
			var result = ''
			$.ajax({
				url: "<?php echo base_url()?>settings/getAllMeasure",
				type: "post",
				async: false,
				dataType:"html",
				success: function(data){
					result = data;
				}
			});
			return result;
		}
		function allSnumber(){
			var result = ''
			$.ajax({
				url: "<?php echo base_url()?>snumber/getSnumber",
				type: "post",
				async: false,
				dataType:"html",
				success: function(data){
					result = data;
				}
			});
			return result;
		}

		$('#new_article').click(function(){
			var rowCount = $('table#warehouse tbody tr').length;
			rowCount = rowCount + 1;
			$('#number_of').val(rowCount);
			var article_select = allArticle();
			var measure = allMeasure();
			var snumber = allSnumber();
			if(rowCount < 101) {
				$('table#warehouse tbody').append("<tr>" +
					"<td>" + snumber+"</td>" +
					"<td><input type='text' name='t_number[]' class='t_number' size='20'  required/></td>" +
					"<td>" + article_select+ "</td>" +
					"<td class='qty'><input type='number' name='quantity[]' min='0' step='0.00001' class='qty_in' style='width:130px' required/></td>" +
					"<td class='measure'>"+measure+"</td>"+
					"<td class='qty'><input type='number' name='price[]' min='0' step='0.00001' class='price_in' style='width:130px' required/></td>" +
					"<td class='qty'><select name='currency[]'>"+
					                 "<option value='eur'>EUR</option>"+
					                 "<option value='usd'>USD</option>"+
					                 "</select>"+
					"<td class='qty'><input type='number' name='exchange[]' min='0' step='0.00001' class='exchange' style='width:130px' required/></td>" +
					"<td class='fa fa-minus-circle f-size-20 left-margin10 grey pointer delete_input'></td>"+
					"</tr>");
			}
			else{
				alert('Внесување најмногу 100 парчиња одеднаш');
			}
		});
		$(document).on("click", ".delete_input",function() {
			$(this).closest('tr').remove();
			var num = parseInt($('#number_of').val());
			num = num - 1;
			$('#number_of').val(num);

		});
	});
</script>

