<div class="content_dashboard">
   <?php foreach($area as $a){ ?>
		   <div class="area">
			   <div class="area_title"><b><?php echo $a['name']; ?>-ареа</b></div>
			   <?php foreach($location as $l){ ?>
					   <?php  if($a['id'] == $l['id_area']){?>
					          <div class="location">
								  <span class = 'name'><a href="<?php echo base_url(); ?>location/index/<?php echo $l['id']; ?>" title="Линк кон локација"><?php echo $l['name']; ?></a></span><br/>
								  <span class = 'price'><?php echo $l['price']; ?></span><br/>
								  <span class = 'rotation pointer' id="rotation_<?php echo $l['id']; ?>">Премести ролни</span><br/>
								  <input type="hidden"  id="amount_<?php echo $l['id']; ?>" value="<?php echo $l['price']; ?>" />
							  </div>
			           <?php }?>
			   <?php } ?>
		   </div><br/><br/>
   <?php } ?>
</div>
<div id="rotation_html">

</div>
