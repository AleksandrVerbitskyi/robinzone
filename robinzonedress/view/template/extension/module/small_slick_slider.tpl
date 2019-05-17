<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-small_slick_slider" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-small_slick_slider" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?= $entry_name_store; ?></label>
            <div class="col-sm-10">
                <?php foreach ($languages as $language) { ?>
                    <div class="input-group" style="margin-bottom: 5px;">
                        <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                        <input type="text" name="description[<?= $language['language_id']; ?>][name]" value="<?php if (isset($description[$language['language_id']]['name'])) { echo $description[$language['language_id']]['name']; } else echo ''; ?>" placeholder="<?= $entry_name_store; ?>" class="form-control" />
                    </div>
                <?php } ?>
            </div>
        </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-banner"><?php echo $entry_banner; ?></label>
            <div class="col-sm-10">
              <select name="banner_id" id="input-banner" class="form-control">
                <?php foreach ($banners as $banner) { ?>
                <?php if ($banner['banner_id'] == $banner_id) { ?>
                <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="input-slider_type"><?php echo $entry_slider_type; ?></label>
              <div class="col-sm-10">
                  <select name="slider_type" id="input-slider_type" class="form-control">
                        <?php if ($slider_type == 'text') { ?>
                            <option value="text" selected="selected"><?php echo $text_slider_type_1; ?></option>
                            <option value="photogallery"><?php echo $text_slider_type_2; ?></option>
                        <?php } elseif ($slider_type == 'photogallery') { ?>
                            <option value="text"><?php echo $text_slider_type_1; ?></option>
                            <option value="photogallery" selected="selected"><?php echo $text_slider_type_2; ?></option>
                        <?php } ?>
                  </select>
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
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>