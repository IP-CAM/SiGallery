<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form').submit() : false;"><i class="fa fa-trash-o"></i></button>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
	<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
								<td class="left"><?php if ($sort == 'name') { ?>
									<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
									<?php } else { ?>
									<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
									<?php } ?></td>
								<td class="left"><?php if ($sort == 'status') { ?>
									<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
									<?php } else { ?>
									<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
									<?php } ?></td>
								<td class="right"><?php echo $column_action; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php if ($sigallerys) { ?>
							<?php foreach ($sigallerys as $sigallery) { ?>
							<tr>
								<td style="text-align: center;"><?php if ($sigallery['selected']) { ?>
									<input type="checkbox" name="selected[]" value="<?php echo $sigallery['sigallery_id']; ?>" checked="checked" />
									<?php } else { ?>
									<input type="checkbox" name="selected[]" value="<?php echo $sigallery['sigallery_id']; ?>" />
									<?php } ?></td>
								<td class="left"><?php echo $sigallery['name']; ?></td>
								<td class="left"><?php echo $sigallery['status']; ?></td>
								<td class="right"><?php foreach ($sigallery['action'] as $action) { ?>
									<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" class="btn btn-primary" data-original-title="<?php echo $action['text']; ?>"><i class="fa fa-pencil"></i></a>
									<?php } ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
			<div class="pagination"><?php echo $pagination; ?></div>
		</div>
	</div>
</div>
<?php echo $footer; ?>