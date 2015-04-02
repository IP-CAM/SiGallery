<div class="box">
	<div class="box-heading">
		<div style="float:left;"><?php echo $heading_title; ?></div> 
		<button class="btn btn-danger catal" style="float:right;" data-toggle="collapse" data-target="#catalog-collapse-2"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></button>
	</div>
	<div class="box-content" id="catalog-collapse-2">
		<div class="box-gallery">
		<?php if (isset($sigallerys)) { ?>
			<?php foreach ($sigallerys as $sigallery) { ?>
				<?php if ($sigallery['link']) { ?>
				<div class="col-xs-6 col-md-12">
					<a href="<?php echo $sigallery['link']; ?>" title="<?php echo $sigallery['title']; ?>">
						<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail" />
					</a>
				</div>
				<?php } else { ?>
				<div class="col-xs-6 col-md-12">
					<a href="<?php echo $sigallery['popup']; ?>" title="<?php echo $sigallery['title']; ?>" class="magni">
						<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
					</a>
				</div>
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
			<ul class="box-category">
			<?php foreach ($menu as $value) { 
				$active=($gallery_id==$value['gallery'])?' class="active"':'';
				?>
				<li>
					<a href="<?php echo $value['href']; ?>"<?php echo $active; ?>><?php echo $value['title']; ?></a>
					<?php if ($value['children']) { ?>
					<ul>
					  <?php foreach ($value['children'] as $child) { ?>
					  <li>
					    <?php if ($child['sigallery_id'] == $child_id) { ?>
					    <a href="<?php echo $child['href']; ?>" class="active sub"> - <?php echo $child['title']; ?></a>
					    <?php } else { ?>
					    <a href="<?php echo $child['href']; ?>" class="sub"> - <?php echo $child['title']; ?></a>
					    <?php } ?>
					  </li>
					  <?php } ?>
					</ul>
					<?php } ?>
				</li>
			<?php } ?>
			</ul>
		<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		gallery: {
			enabled:true
		}
	});
});
//--></script>