<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" size="3" id="input-name"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="module-type"><?php echo $entry_module_type; ?></label>
						<div class="col-sm-10">
							<select name="module_type" class="form-control" id="module-type">
								<?php if ($sigallery['module_type'] == $module_type) { ?>
								<option value="0"><?php echo $text_module_menu; ?></option>
								<option value="1" selected="selected"><?php echo $text_module_image; ?></option>
								<?php } else { ?>
								<option value="0" selected="selected"><?php echo $text_module_menu; ?></option>
								<option value="1"><?php echo $text_module_image; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group imgt">
						<label class="col-sm-2 control-label" for="input-gallery"><?php echo $entry_sigallery; ?></label>
						<div class="col-sm-10">
							<select name="gallery" class="form-control" id="input-gallery">
								<?php foreach ($sigallerys as $sigallery) { ?>
								<?php if ($sigallery['sigallery_id'] == $gallery) { ?>
								<option value="<?php echo $sigallery['sigallery_id']; ?>" selected="selected"><?php echo $sigallery['title']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $sigallery['sigallery_id']; ?>"><?php echo $sigallery['title']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group imgt">
						<label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="width" value="<?php echo $width; ?>" size="3" id="input-width"/>
							<?php if (isset($error_dimension)) { ?>
							<span class="error"><?php echo $error_dimension; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group imgt">
						<label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="height" value="<?php echo $height; ?>" size="3" id="input-height"/>
							<?php if (isset($error_dimension)) { ?>
							<span class="error"><?php echo $error_dimension; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-control">
								<?php if ($status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#module-type').change( function() {
				if($(this).val()==0)
					 $('.imgt').hide();
				else
					 $('.imgt').show();
			});
			if (<?php echo $module_type; ?>==0)
				$('.imgt').hide();
		});
	</script>
<?php echo $footer; ?>