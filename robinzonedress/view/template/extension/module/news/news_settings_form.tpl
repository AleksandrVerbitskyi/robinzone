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
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                  <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                  <li><a href="#tab-text" data-toggle="tab"><?php echo $tab_text; ?></a></li>
                  <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
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
                                          <input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_name[$language['language_id']])) { ?>
                                              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                      <div class="col-sm-10">
                                          <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                              <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                      <div class="col-sm-10">
                                          <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                      <div class="col-sm-10">
                                          <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                      </div>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-data">
                      <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                              <?php if ($error_model) { ?>
                                  <div class="text-danger"><?php echo $error_model; ?></div>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-sku"><span data-toggle="tooltip" title="<?php echo $help_sku; ?>"><?php echo $entry_sku; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="sku" value="<?php echo $sku; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-sku" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group<?php echo ($hide_upc == true)? ' hide':''; ?>">
                          <label class="col-sm-2 control-label" for="input-upc"><span data-toggle="tooltip" title="<?php echo $help_upc; ?>"><?php echo $entry_upc; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="upc" value="<?php echo $upc; ?>" placeholder="<?php echo $entry_upc; ?>" id="input-upc" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group<?php echo ($hide_ean == true)? ' hide':''; ?>">
                          <label class="col-sm-2 control-label" for="input-ean"><span data-toggle="tooltip" title="<?php echo $help_ean; ?>"><?php echo $entry_ean; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="ean" value="<?php echo $ean; ?>" placeholder="<?php echo $entry_ean; ?>" id="input-ean" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group<?php echo ($hide_jan == true)? ' hide':''; ?>">
                          <label class="col-sm-2 control-label" for="input-jan"><span data-toggle="tooltip" title="<?php echo $help_jan; ?>"><?php echo $entry_jan; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="jan" value="<?php echo $jan; ?>" placeholder="<?php echo $entry_jan; ?>" id="input-jan" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group<?php echo ($hide_isbn == true)? ' hide':''; ?>">
                          <label class="col-sm-2 control-label" for="input-isbn"><span data-toggle="tooltip" title="<?php echo $help_isbn; ?>"><?php echo $entry_isbn; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="isbn" value="<?php echo $isbn; ?>" placeholder="<?php echo $entry_isbn; ?>" id="input-isbn" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group<?php echo ($hide_mpn == true)? ' hide':''; ?>">
                          <label class="col-sm-2 control-label" for="input-mpn"><span data-toggle="tooltip" title="<?php echo $help_mpn; ?>"><?php echo $entry_mpn; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="mpn" value="<?php echo $mpn; ?>" placeholder="<?php echo $entry_mpn; ?>" id="input-mpn" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_location; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="location" value="<?php echo $location; ?>" placeholder="<?php echo $entry_location; ?>" id="input-location" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                          <div class="col-sm-10">
                              <select name="tax_class_id" id="input-tax-class" class="form-control">
                                  <option value="0"><?php echo $text_none; ?></option>
                                  <?php foreach ($tax_classes as $tax_class) { ?>
                                      <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
                                          <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                      <?php } else { ?>
                                          <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                      <?php } ?>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="<?php echo $help_minimum; ?>"><?php echo $entry_minimum; ?></span></label>
                          <div class="col-sm-10">
                              <input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_minimum; ?>" id="input-minimum" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-subtract"><?php echo $entry_subtract; ?></label>
                          <div class="col-sm-10">
                              <select name="subtract" id="input-subtract" class="form-control">
                                  <?php if ($subtract) { ?>
                                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                      <option value="0"><?php echo $text_no; ?></option>
                                  <?php } else { ?>
                                      <option value="1"><?php echo $text_yes; ?></option>
                                      <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-stock-status"><span data-toggle="tooltip" title="<?php echo $help_stock_status; ?>"><?php echo $entry_stock_status; ?></span></label>
                          <div class="col-sm-10">
                              <select name="stock_status_id" id="input-stock-status" class="form-control">
                                  <?php foreach ($stock_statuses as $stock_status) { ?>
                                      <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
                                          <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                                      <?php } else { ?>
                                          <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                                      <?php } ?>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_shipping; ?></label>
                          <div class="col-sm-10">
                              <label class="radio-inline">
                                  <?php if ($shipping) { ?>
                                      <input type="radio" name="shipping" value="1" checked="checked" />
                                      <?php echo $text_yes; ?>
                                  <?php } else { ?>
                                      <input type="radio" name="shipping" value="1" />
                                      <?php echo $text_yes; ?>
                                  <?php } ?>
                              </label>
                              <label class="radio-inline">
                                  <?php if (!$shipping) { ?>
                                      <input type="radio" name="shipping" value="0" checked="checked" />
                                      <?php echo $text_no; ?>
                                  <?php } else { ?>
                                      <input type="radio" name="shipping" value="0" />
                                      <?php echo $text_no; ?>
                                  <?php } ?>
                              </label>
                          </div>
                      </div>
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
                          <label class="col-sm-2 control-label" for="input-date-available"><?php echo $entry_date_available; ?></label>
                          <div class="col-sm-3">
                              <div class="input-group date">
                                  <input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
                                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-length"><?php echo $entry_dimension; ?></label>
                          <div class="col-sm-10">
                              <div class="row">
                                  <div class="col-sm-4">
                                      <input type="text" name="length" value="<?php echo $length; ?>" placeholder="<?php echo $entry_length; ?>" id="input-length" class="form-control" />
                                  </div>
                                  <div class="col-sm-4">
                                      <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
                                  </div>
                                  <div class="col-sm-4">
                                      <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-length-class"><?php echo $entry_length_class; ?></label>
                          <div class="col-sm-10">
                              <select name="length_class_id" id="input-length-class" class="form-control">
                                  <?php foreach ($length_classes as $length_class) { ?>
                                      <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
                                          <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                                      <?php } else { ?>
                                          <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                                      <?php } ?>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-weight"><?php echo $entry_weight; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-weight-class"><?php echo $entry_weight_class; ?></label>
                          <div class="col-sm-10">
                              <select name="weight_class_id" id="input-weight-class" class="form-control">
                                  <?php foreach ($weight_classes as $weight_class) { ?>
                                      <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                                          <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                      <?php } else { ?>
                                          <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                      <?php } ?>
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
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                          </div>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-text">
                      <div class="table-responsive">
                          <table id="attribute" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left"><?php echo $entry_attribute; ?></td>
                                  <td class="text-left"><?php echo $entry_text; ?></td>
                                  <td></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $attribute_row = 0; ?>
                              <?php foreach ($product_attributes as $product_attribute) { ?>
                                  <tr id="attribute-row<?php echo $attribute_row; ?>">
                                      <td class="text-left" style="width: 40%;"><input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
                                          <input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" /></td>
                                      <td class="text-left"><?php foreach ($languages as $language) { ?>
                                              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                                                  <textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
                                              </div>
                                          <?php } ?></td>
                                      <td class="text-left"><button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                  </tr>
                                  <?php $attribute_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="2"></td>
                                  <td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_attribute_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-image">
                      <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left"><?php echo $entry_image; ?></td>
                              </tr>
                              </thead>

                              <tbody>
                              <tr>
                                  <td class="text-left"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /></td>
                              </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="table-responsive">
                          <table id="images" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left"><?php echo $entry_additional_image; ?></td>
                                  <td class="text-right"><?php echo $entry_sort_order; ?></td>
                                  <td></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $image_row = 0; ?>
                              <?php foreach ($product_images as $product_image) { ?>
                                  <tr id="image-row<?php echo $image_row; ?>">
                                      <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                      <td class="text-right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                      <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                  </tr>
                                  <?php $image_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="2"></td>
                                  <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
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