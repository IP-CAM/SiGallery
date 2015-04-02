<?php echo $header; ?>
<div class="container">
	<div class="row"><?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
			<h1><?php echo $heading_title; ?></h1>
			<?php echo $description; ?>
			<ul class="nav nav-pills">
				<?php if (isset($childrens)) 
				 foreach ($childrens as $child) {  ?>
					<li role="presentation">
						<a href="<?php echo $child['href']; ?>" class="btn btn-default"><?php echo $child['title']; ?></a>
					</li>
				<?php }	?>
			</ul><p>&nbsp;</p>
			<?php if (($type==4) OR ($type==1)) { ?>
				<style type="text/css">.slick-slide {opacity: 0.4;}</style>
			<?php } ?>
			<?php if ($type==1) { ?>
				<div class="single-for" >
				<?php foreach ($sigallerys as $sigallery) { ?>
					<div>
						<img src="<?php echo $sigallery['popup']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
					</div>
				<?php } ?>
				</div>
			<?php } ?>
			<?php if ($type!=5) { ?>
				<div class="single-item">
				<?php foreach ($sigallerys as $sigallery) { ?>
					<div>
						<a href="<?php echo $sigallery['popup']; ?>" title="<?php echo $sigallery['title']; ?>" class="magni">
							<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
						</a>
					</div>
				<?php } ?>
				</div>
			<?php } else { ?>
				<?php foreach ($sigallerys as $sigallery) { ?>
						<div>
						<?php if ($sigallery['link']) { ?>
						<div class="col-xs-6 col-md-3">
							<a href="<?php echo $sigallery['popup']; ?>" title="<?php echo $sigallery['title']; ?>" class="magni">
								<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
							</a>
						</div>
						<?php } else { ?>
						<div class="col-xs-6 col-md-3">
							<a href="<?php echo $sigallery['popup']; ?>" title="<?php echo $sigallery['title']; ?>" class="magni">
								<img src="<?php echo $sigallery['image']; ?>" alt="<?php echo $sigallery['title']; ?>" title="<?php echo $sigallery['title']; ?>" class="thumbnail"/>
							</a>
						</div>
						<?php } ?>
						</div>
					  <?php } ?>
			<?php } ?>
			<?php echo $description_after; ?>
			<script type="text/javascript"><!--
			$(document).ready(function() {
				<?php echo $parameters; ?>
				$('.magni').magnificPopup({
					type:'image',
					gallery: {
						enabled:true
					}
				});
			});
			//--></script>
			<?php echo $content_bottom; ?>
		</div>
		<?php echo $column_right; ?>
	</div>
</div>
<?php echo $footer; ?>