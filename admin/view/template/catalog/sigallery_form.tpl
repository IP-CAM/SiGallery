<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
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
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
					<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
					<li><a href="#tab-images" data-toggle="tab"><?php echo $tab_images; ?></a></li>
					<li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab-general">
						<ul class="nav nav-tabs" id="language">
							<?php foreach ($languages as $language) { ?>
							<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($languages as $language) { ?>
							<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sigallery_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
									<?php if (isset($error_title[$language['language_id']])) { ?>
										<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
									<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
									<div class="col-sm-10">
										<textarea name="sigallery_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['description'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description_after; ?></label>
									<div class="col-sm-10">
										<textarea name="sigallery_description[<?php echo $language['language_id']; ?>][description_after]" placeholder="<?php echo $entry_description_after; ?>" id="input-description-after<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['description_after'] : ''; ?></textarea>
									</div>
								</div>

								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sigallery_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
										<?php if (isset($error_meta_title[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
									<div class="col-sm-10">
										<textarea name="sigallery_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
									<div class="col-sm-10">
										<textarea name="sigallery_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($sigallery_description[$language['language_id']]) ? $sigallery_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
									</div>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="parent"><?php echo $entry_parent; ?></label>
								<div class="col-sm-10">
									<select name="parent" id="parent" class="form-control">
										<option value="0"><?php echo $text_parent; ?></option>
										<?php foreach ($parents[0]['children'] as $value) { 
											$selected=($value['id']==$parent)?"selected":"";
											echo '<option '.$selected.' value="'.$value['id'].'">'.$value['title'].'</option>';
											if (isset($parents[$value['id']])) {
												foreach ($parents[$value['id']]['children'] as $child2) {
													$selected=($child2['id']==$parent)?"selected":"";
													echo '<option '.$selected.' value="'.$child2['id'].'"> - '.$child2['title'].'</option>';
													if (isset($parents[$child2['id']])) {
														foreach ($parents[$child2['id']]['children'] as $child3) {
															$selected=($child3['id']==$parent)?"selected":"";
															echo '<option '.$selected.' value="'.$child3['id'].'" disabled> -- '.$child3['title'].'</option>';
														}
													}
												}
											}
										 } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-images">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
							<td class="text-left"><?php echo $entry_gallery_image; ?></td>
							</tr>
							</thead>
							<tbody>
							<tr>
							<td class="text-left">
								<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title="">
								<img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $thumb; ?>"></a>
								<input type="hidden" name="sigallery-one-image" value="<?php echo $gallery_image; ?>" id="input-image">
							</td>
							</tr>
							</tbody>
							</table>
						</div>

						<table id="images" class="table table-bordered">
							<thead>
								<tr>
									<th class="text-left" width="50%"><?php echo $entry_title; ?></th>
									<th class="text-left"><?php echo $entry_link; ?></th>
									<th class="text-left"><?php echo $entry_image; ?></th>
									<th></th>
								</tr>
							</thead>
							<?php $image_row = 0; ?>
							<?php foreach ($sigallery_images as $sigallery_image) { ?>
							<tbody id="image-row<?php echo $image_row; ?>">
								<tr>
									<td class="text-left"><?php foreach ($languages as $language) { ?>
										<div class="input-group col-md-6"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" class="form-control" name="sigallery_image[<?php echo $image_row; ?>][sigallery_image_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($sigallery_image['sigallery_image_description'][$language['language_id']]) ? $sigallery_image['sigallery_image_description'][$language['language_id']]['title'] : ''; ?>" />
										<?php if (isset($error_sigallery_image[$image_row][$language['language_id']])) { ?>
										<span class="error"><?php echo $error_sigallery_image[$image_row][$language['language_id']]; ?></span>
										<?php } ?>
										</div>
										<?php } ?></td>
									<td class="text-left">
										<input type="text" name="sigallery_image[<?php echo $image_row; ?>][link]" value="<?php echo $sigallery_image['link']; ?>" class="form-control"/>
									</td>
									<td class="text-left">
											<div class="col-sm-10">
												<a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-imagenail">
													<img src="<?php echo $sigallery_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" id="image<?php echo $image_row; ?>"/>
												</a>
												<input type="hidden" name="sigallery_image[<?php echo $image_row; ?>][image]" value="<?php echo $sigallery_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
											</div>
										</td>
									<td class="text-left">
										<button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" data-original-title="<?php echo $text_remove; ?>"><i class="fa fa-minus-circle"></i></button>
									</td>
								</tr>
							</tbody>
							<?php $image_row++; ?>
							<?php } ?>
							<tfoot>
								<tr>
									<td colspan="3"></td>
									<td class="text-left">
										<button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_sigallery; ?>" class="btn btn-primary" data-original-title="Add Image">
											<i class="fa fa-plus-circle"></i>
										</button></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="tab-pane" id="tab-data">

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
							<div class="col-sm-10">
								<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
								<?php if ($error_keyword) { ?>
									<div class="text-danger"><?php echo $error_keyword; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="status" class="form-control">
									<?php if ($status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
							<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-settings">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
							<div class="col-sm-10">
								<input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
							<div class="col-sm-10">
								<input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_width; ?>" id="input-height" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-width_popup">
								<?php echo $entry_width_popup; ?> 
								<span data-toggle="tooltip" title="<?php echo $help_popup; ?>"></span>
							</label>
							<div class="col-sm-10">
								<input type="text" name="width_popup" value="<?php echo $width_popup; ?>" placeholder="<?php echo $entry_width_popup; ?>" id="input-width_popup" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-height_popup">
								<?php echo $entry_height_popup; ?> 
								<span data-toggle="tooltip" title="<?php echo $help_popup; ?>"></span>
							</label>
							<div class="col-sm-10">
								<input type="text" name="height_popup" value="<?php echo $height_popup; ?>" placeholder="<?php echo $entry_width_popup; ?>" id="input-height_popup" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="type"><?php echo $entry_type; ?></label>
							<div class="col-sm-10">
								<select name="type" class="form-control" id="type">
									<?php if ($type==1) { ?>
									<option value="1" selected="selected"><?php echo $type_fade; ?></option>
									<option value="2"><?php echo $type_single; ?></option>
									<option value="3"><?php echo $type_multiple; ?></option>
									<option value="4"><?php echo $type_centerMode; ?></option>
									<option value="5"><?php echo $type_grid; ?></option>
									<?php } elseif ($type==2) { ?>
									<option value="1"><?php echo $type_fade; ?></option>
									<option value="2" selected="selected"><?php echo $type_single; ?></option>
									<option value="3"><?php echo $type_multiple; ?></option>
									<option value="4"><?php echo $type_centerMode; ?></option>
									<option value="5"><?php echo $type_grid; ?></option>
									<?php } elseif ($type==3) { ?>
									<option value="1"><?php echo $type_fade; ?></option>
									<option value="2"><?php echo $type_single; ?></option>
									<option value="3" selected="selected"><?php echo $type_multiple; ?></option>
									<option value="4"><?php echo $type_centerMode; ?></option>
									<option value="5"><?php echo $type_grid; ?></option>
									<?php } elseif ($type==4) { ?>
									<option value="1"><?php echo $type_fade; ?></option>
									<option value="2"><?php echo $type_single; ?></option>
									<option value="3"><?php echo $type_multiple; ?></option>
									<option value="4" selected="selected"><?php echo $type_centerMode; ?></option>
									<option value="5"><?php echo $type_grid; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $type_fade; ?></option>
									<option value="2"><?php echo $type_single; ?></option>
									<option value="3"><?php echo $type_multiple; ?></option>
									<option value="4"><?php echo $type_centerMode; ?></option>
									<option value="5" selected="selected"><?php echo $type_grid; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-autoplay"><?php echo $entry_autoplay; ?><span data-toggle="tooltip" title="<?php echo $help_autoplay; ?>"></span></label>
							<div class="col-sm-10">
									<input type="text" name="autoplay" value="<?php echo $autoplay; ?>" placeholder="<?php echo $entry_autoplay; ?>" id="input-autoplay" class="form-control" />
							</div>
						</div>
					</div>
				</div>
				</form>
			</div> 
		</div>
	</div>
</div>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
$('#input-description-after<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<tbody id="image-row' + image_row + '">';
	html += '<tr>';
	html += '<td class="text-left">';
	<?php foreach ($languages as $language) { ?>
		html += '<div class="input-group col-md-6"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" class="form-control" name="sigallery_image[' + image_row + '][sigallery_image_description][<?php echo $language['language_id']; ?>][title]" value="" /></div>';
	<?php } ?>
	html += '</td>';	
	html += '<td class="text-left"><input type="text" class="form-control" name="sigallery_image[' + image_row + '][link]" value="" /></td>';	
	html += '<td class="text-left">'+
	'<div class="col-sm-10"> <a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-imagenail"><img src="<?php echo $no_image; ?>" alt="" title="" id="image' + image_row + '"/></a><input type="hidden" name="sigallery_image[' + image_row + '][image]" value="<?php echo $image; ?>" id="input-image' + image_row + '" /></div>';
	html += '<td class="text-left">'+
	'<button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo $text_remove; ?>"><i class="fa fa-minus-circle"></i></button>'+
	'</td>';
	html += '</tr>';
	html += '</tbody>'; 
	$('#images tfoot').before(html);
	image_row++;
}
//--></script>
<?php echo $footer; ?>