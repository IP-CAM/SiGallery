<div class="box">
	<div class="navbar-header">
		<span class="visible-xs"><?php echo $heading_title; ?></span> 
		<button class="btn btn-navbar navbar-toggle collapsed" data-toggle="collapse" data-target="#catalog-collapse-2">
			<i class="fa fa-bars"></i>
		</button>
	</div>
	<div class="box-content" id="catalog-collapse-2">
		<div class="box-gallery">
		<?php if (isset($sigallerys)) { ?>
			<?php foreach ($sigallerys as $sigallery) { ?>
				<?php if ($sigallery['link']) { ?>
				<div class="col-md-12">
					<a href="<?php echo $sigallery['link']; ?>" title="<?php echo $sigallery['title']; ?>">
						<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail" />
					</a>
				</div>
				<?php } else { ?>
				<div class="col-md-12">
					<a href="<?php echo $sigallery['popup']; ?>" title="<?php echo $sigallery['title']; ?>" class="magni">
						<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
					</a>
				</div>
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
			<div class="list-group">
			<?php foreach ($menu as $value) { 
				$active=($gallery_id==$value['gallery'])?' active':''; ?>
				<a href="<?php echo $value['href']; ?>" class="list-group-item<?php echo $active; ?>"><?php echo $value['title']; ?></a>
				<?php if ($value['children']) { ?>
					<?php foreach ($value['children'] as $child) { ?>
						<?php if ($child['sigallery_id'] == $child_id) { ?>
							<a href="<?php echo $child['href']; ?>" class="list-group-item active"> - <?php echo $child['title']; ?></a>
						<?php } else { ?>
							<a href="<?php echo $child['href']; ?>" class="list-group-item"> - <?php echo $child['title']; ?></a>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			</div>
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