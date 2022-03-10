<div class="content">
	<h1><?php echo $title; ?></h1>
	<label for="location">Локација:</label>
	<select id="location_chocie" name="location_chocie">
		<option value="">--избери локација--</option>
    <?php
	      foreach($area as $a){
	?>
		<optgroup label="<?php echo $a['name'].'-ареа'; ?>">
			<?php
			foreach($location as $l ){
				if($a['id'] == $l['id_area'] && $l['old_price'] == $l['price']){
			?>
				<option value="<?php echo $l['id']; ?>"><?php echo $l['name']; ?></option>
			<?php
				}
			}
			?>
			?>
		</optgroup>

	<?php
		  }
	?>
	</select>
	<div class="row top-margin20">
		<div class="col-sm-12">
			<form method = 'post' action = '<?php  echo base_url().'warehouse/add_in_warehouse' ?>'>
				    <input type="hidden"  value="" id="location" name="location"/>
				    <input type="hidden"  value=0 id="number_of" name="number_of"/>
					<table id="warehouse" width="100%">
						<thead>
						   <tr>
							   <th width="15%">S број</th>
							   <th width="15%">Артикл</th>
							   <th width="15%">Боја</th>
							   <th width="10%">Количество</th>
							   <th width="5%"></th>
							   <th width="10%">Цена единечна</th>
							   <th width="10%">М ширина</th>
							   <th width="10%">Количина во пакет</th>
							   <th width="10%">Избриши</th>
						   </tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				    <br/>
				    <i class="fa fa-plus-square f-size grey pointer top-margin20" id='new_article' title="Додавање на нов влез"></i>
				    <i class="fa fa-clone f-size grey pointer left-margin20" aria-hidden="true" id='multiple_article' title="Додавање на нови влезови"></i>
				    <br/><br/>
				    <input type="submit" value="Внеси артикли"  id="input_article" />
			</form>
		</div>
	</div>
	<div id="multiple_input" title="Внесете колкаво количество од артиколот внесувате">
		<span>Внесете количество на артиклот кој го внесувате</span><br/><br/>
		<input type="number" name="multiple_article_qty"/>

	</div>
</div>
<script>
	$(document).ready(function () {
		$('form').on('submit', function(e){
			if($('#location').val() == ''){
				alert('Изберете локација');
				e.preventDefault();
			}
		});
		$('#location_chocie').change(function(){
			let loc = $('#location_chocie').val();
			$('#location').val(loc);
		});
		function allArticle(){
			var result = ''
			$.ajax({
				url: "<?php echo base_url()?>article/getAllArticleSelect",
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
		function getColor(){
			var result = ''
			$.ajax({
				url: "<?php echo base_url()?>settings/getAllColorSelect",
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
			var color = getColor();
			var snumber = allSnumber();
			if(rowCount < 101) {
				$('table#warehouse tbody').append("<tr>" +
						"<td>"+snumber+"</td>" +
						"<td>" + article_select+ "</td>" +
						"<td>" + color + "</td>" +
						"<td class='qty'><input type='number' name='quantity[]' min='0' step='0.00001' class='qty_in' style='width:130px' required/></td>" +
						"<td class='measure'></td>"+
						"<td class='qty'><input type='number' name='price[]' min='0' step='0.00001' class='price_in' style='width:130px' required/></td>" +
						"<td class='qty'><input type='number' name='width[]' min='0' step='0.00001' class='width_in' value = '0' style='width:100px' readonly/>m</td>" +
						"<td class='qty'><input type='number' name='package[]' min='0' class='package_in' value = '0' style='width:100px' readonly/></td>" +
						"<td class='fa fa-minus-circle f-size-20 left-margin10 grey pointer delete_input'></td>"+
						"</tr>");
			}
			else{
				alert('Внесување најмногу 100 парчиња одеднаш');
			}
		});
		$('#multiple_article').click(function(){
			var rowCount = $('table#warehouse tbody tr').length;
			if(rowCount > 0 && rowCount < 101){
				var last_row= $('#warehouse tr:last');
				var article = last_row.find('.article_in').val();
				var color  = last_row.find('.choice_color').val();
				var s_number = last_row.find('.s_number').val();
				if(article != '' && color != '' && s_number !=''){
					dialog.dialog( "open" );
				}
				else{
					alert('Пополни сите полињa артикл, боја и S број за да може да се изврши масовен внес!');
				}

			}
			else{
				alert('Внесете еден артикл, за да можете да направите масивен внес!')
			}



		});
		dialog = $( "#multiple_input" ).dialog({
			autoOpen: false,
			height: 400,
			width: 350,
			modal: true,
			buttons: {
				"Потврди количество": addQty,
				Cancel: function() {
					dialog.dialog( "close" );
				}
			},
		});
		function addQty(){
			var multiple_qty = $("input[name=multiple_article_qty]").val();
			var rowCount = $('table#warehouse tbody tr').length;
			var last_row= $('#warehouse tr:last');
			var article = last_row.find('.article_in').val();
			var color  = last_row.find('.choice_color').val();
			var s_number = last_row.find('.s_number').val();
			var qty = last_row.find('.qty_in').val();
			var price = last_row.find('.price_in').val();
			var width = last_row.find('.width_in').val();
			var package = last_row.find('.package_in').val();

			var sum = parseInt(multiple_qty)+parseInt(rowCount)
			if(sum > 100 ){
				alert('Ќе надминете 100 артикли');
			}else{
				var article_select = allArticle();
				var color_select = getColor();
				var snumber = allSnumber();
				var i = parseInt(rowCount);
				while(i < sum){
					$('table#warehouse tbody').append("<tr>" +
							"<td>"+snumber+"</td>" +
							"<td>" + article_select+ "</td>" +
							"<td>" + color_select + "</td>" +
							"<td class='qty'><input type='number' name='quantity[]' min='0' step='0.00001' class='qty_in' style='width:130px' required/></td>" +
							"<td class='measure'></td>"+
							"<td class='qty'><input type='number' name='price[]' min='0' step='0.00001' class='price_in' style='width:130px' required/></td>" +
							"<td class='qty'><input type='number' name='width[]' min='0' step='0.00001' class='width_in' value = '0' style='width:100px' readonly/>m</td>" +
							"<td class='qty'><input type='number' name='package[]' min='0' class='package_in' value = '0' style='width:100px' readonly/></td>" +
							"<td class='fa fa-minus-circle f-size-20 left-margin10 grey pointer delete_input'></td>"+
							"</tr>");
					i++;
					$('#number_of').val(i);
					var last_row_new= $('#warehouse tr:last');
					last_row_new.find('.choice_color').val(color);
					last_row_new.find('.article_in').val(article);
					last_row_new.find('.article_in').trigger('change');
					last_row_new.find('.s_number').val(s_number);
					last_row_new.find('.qty_in').val(qty);
					last_row_new.find('.width_in').val(width);
 					last_row_new.find('.price_in').val(price);
					last_row_new.find('.package_in').val(package);

				}
				dialog.dialog( "close" );
			}

		}
		$(document).on("click", ".delete_input",function() {
          $(this).closest('tr').remove();
          var num = parseInt($('#number_of').val());
          num = num - 1;
          $('#number_of').val(num);

		});
	});
</script>

