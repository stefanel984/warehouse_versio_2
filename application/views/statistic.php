<?php
function article($id){
	$article = new Article_model();
	$result = $article->getArticleByID($id);

	return $result[0];

}

function merka($id){
	$measure = new Settings_model();
	$result = $measure->getMeasureById($id);

	return $result[0]['name'];

}
function color($id){
	$measure = new Settings_model();
	$result = $measure->getColor($id);

	return $result[0];

}
?>
<div class="content">
	<h1><?php echo $title; ?></h1>
	<div class="row top-margin20">
		<div class="col-sm-4"></div>
		<div class="col-sm-4 f-size-20"><b>Состојба на поле <a href="<?php  echo base_url().'location/index/'.$area; ?>" class="black underline"><?php echo $area; ?></a></b></div>
		<div class="col-sm-4"></div>
	</div>
</div>
<?php
foreach($articles as $key=>$article){

	$article_details = article($key);
	$sum_artikl = 0;
	$present_article = array();
	foreach($article as $color=>$article_array){
		$sum_color = 0;
		foreach($article_array as $k=>$v){
			$sum_color = $v['qty'] + $sum_color;
			$sum_artikl = $v['qty'] + $sum_artikl;
		}
		$present_article[$color] = $sum_color;

	}
?>
	<div class="row top-margin20 ">
		<div class="col-sm-4 f-size-20 border-bottom-black"><b>Артикл: <?php echo $article_details['name']; ?> - <?php echo $sum_artikl.' '.merka($article_details['measure']) ?></b></div>
		<div class="col-sm-8"></div>
	</div>

<?php
	foreach($present_article as $k=>$p){
		$color = color($k);
?>
		<br/>
		<div class="row">
			<div class="col-sm-2"><img src="<?php echo base_url().$color_image."/".$color['img']; ?>" width="30" height="30" class="img_view"/></div>
			<div class="col-sm-4"><?php echo $color['name'].' - '.$p.' '.merka($article_details['measure']); ?></div>
			<div class="col-sm-6"></div>
		</div>
		<br/>


<?php
	}

}
