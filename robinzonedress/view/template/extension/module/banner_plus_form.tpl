<?= $header; ?><?= $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?= $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-banner" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?= $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?= $name; ?>" placeholder="<?= $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?= $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?= $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?= $text_enabled; ?></option>
                <option value="0"><?= $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?= $text_enabled; ?></option>
                <option value="0" selected="selected"><?= $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br />
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab"><img src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png" title="<?= $language['name']; ?>" /> <?= $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php $image_row = 0; ?>
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?= $language['language_id']; ?>">
              <table id="images<?= $language['language_id']; ?>" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?= $entry_title; ?></td>
                      <td class="text-left"><?= $entry_button_text; ?></td>
                    <td class="text-left"><?= $entry_link; ?></td>
                    <td class="text-center"><?= $entry_image; ?></td>
                    <td class="text-right"><?= $entry_sort_order; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($banner_images[$language['language_id']])) { ?>
                  <?php foreach ($banner_images[$language['language_id']] as $banner_image) { ?>
                  <tr id="image-row<?= $image_row; ?>">
                    <td class="text-left"><input type="text" name="banner_image[<?= $language['language_id']; ?>][<?= $image_row; ?>][title]" value="<?= $banner_image['title']; ?>" placeholder="<?= $entry_title; ?>" class="form-control" />
                      <?php if (isset($error_banner_image[$language['language_id']][$image_row])) { ?>
                      <div class="text-danger"><?= $error_banner_image[$language['language_id']][$image_row]; ?></div>
                      <?php } ?></td>
                      <td class="text-left"><input type="text" name="banner_image[<?= $language['language_id']; ?>][<?= $image_row; ?>][button_text]" value="<?= $banner_image['button_text']; ?>" placeholder="<?= $entry_button_text; ?>" class="form-control" /></td>
                    <td class="text-left" style="width: 30%;"><input type="text" name="banner_image[<?= $language['language_id']; ?>][<?= $image_row; ?>][link]" value="<?= $banner_image['link']; ?>" placeholder="<?= $entry_link; ?>" class="form-control" /></td>
                    <td class="text-center"><a href="" id="thumb-image-<?= $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?= $banner_image['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a>
                      <input type="hidden" name="banner_image[<?= $language['language_id']; ?>][<?= $image_row; ?>][image]" value="<?= $banner_image['image']; ?>" id="input-image<?= $image_row; ?>" /></td>
                    <td class="text-right" style="width: 10%;"><input type="text" name="banner_image[<?= $language['language_id']; ?>][<?= $image_row; ?>][sort_order]" value="<?= $banner_image['sort_order']; ?>" placeholder="<?= $entry_sort_order; ?>" class="form-control" /></td>
                    <td class="text-left"><button type="button" onclick="$('#image-row<?= $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $image_row++; ?>
                  <?php } ?>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-left"><button type="button" onclick="addImage('<?= $language['language_id']; ?>');" data-toggle="tooltip" title="<?= $button_banner_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <?php } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
var image_row = <?= $image_row; ?>;

function addImage(language_id) {
	html  = '<tr id="image-row' + image_row + '">';
    html += '  <td class="text-left"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][title]" value="" placeholder="<?= $entry_title; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][button_text]" value="" placeholder="<?= $entry_button_text; ?>" class="form-control" /></td>';
    html += '  <td class="text-left" style="width: 30%;"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][link]" value="" placeholder="<?= $entry_link; ?>" class="form-control" /></td>';
	html += '  <td class="text-center"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="banner_image[' + language_id + '][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right" style="width: 10%;"><input type="text" name="banner_image[' + language_id + '][' + image_row + '][sort_order]" value="" placeholder="<?= $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + ', .tooltip\').remove();" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#images' + language_id + ' tbody').append(html);
	
	image_row++;
}
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script> 
</div>
<?= $footer; ?>