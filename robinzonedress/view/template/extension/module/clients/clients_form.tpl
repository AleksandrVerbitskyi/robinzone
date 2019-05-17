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
      <div class="success-cover">
          <?php if ($success) { ?>
              <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
          <?php } ?>
      </div>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $heading_title; ?></h3>
      </div>
      <div class="panel-body">
          <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-textile" data-toggle="tab"><?= $tab_textile; ?></a></li>
                  <li><a href="#tab-sizes_table" data-toggle="tab"><?= $tab_sizes_table; ?></a></li>
                  <li><a href="#tab-recommendations" data-toggle="tab"><?= $tab_recommendations; ?></a></li>
                  <li><a href="#tab-quality" data-toggle="tab"><?= $tab_quality; ?></a></li>
                  <li><a href="#tab-slider" data-toggle="tab"><?= $tab_slider; ?></a></li>
                  <li><a href="#tab-settings" data-toggle="tab"><?= $tab_settings; ?></a></li>
              </ul>
              <div class="tab-content">
                  <div class="tab-pane active" id="tab-textile">
                      <div class="table-responsive">
                          <table id="textile_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 30%;"><?= $entry_image_title; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_images; ?></td>
                                  <td class="text-left" style="width: 25%;"><?= $entry_sort_order; ?></td>
                                  <td class="text-left" style="width: 20%;"><?= $entry_status; ?></td>
                                  <td style="width: 10%;"></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $textile_row = 0; ?>
                              <?php foreach ($textile as $item) { ?>
                                  <tr id="textile-row-<?= $textile_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="textile_id" name="textile[<?= $item['textile_id']; ?>][textile_id]" value="<?= $item['textile_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="textile[<?= $item['textile_id']; ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <textarea name="textile[<?= $item['textile_id']; ?>][description][<?= $language['language_id'] ?>][text]"
                                                            placeholder="<?= $entry_text; ?>" rows="5" class="form-control"><?= isset($item['description'][$language['language_id']]['text']) ? $item['description'][$language['language_id']]['text'] : ''; ?></textarea>
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_textile['title'][$item['textile_id']])) { ?>
                                                <div class="text-danger"><?= $error_textile['title'][$item['textile_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="textile-image-<?= $item['textile_id']; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="textile[<?= $item['textile_id']; ?>][image]" value="<?= $item['image']; ?>" id="input-textile-image-<?= $item['textile_id']; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="textile[<?= $item['textile_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="textile[<?= $item['textile_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="textile-row-<?= $textile_row; ?>" data-type="textile"
                                                  class="btn btn-danger delete-textile"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $textile_row++; ?>
                              <?php } ?>
                              <?php if (isset($textile_new)) foreach ($textile_new as $item) { ?>
                                  <tr id="textile_new-row-<?= $textile_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="textile_id" name="textile_new[<?= $item['textile_id']; ?>][textile_id]" value="<?= $item['textile_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="textile_new[<?= $item['textile_id']; ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <textarea name="textile_new[<?= $item['textile_id']; ?>][description][<?= $language['language_id'] ?>][text]"
                                                            placeholder="<?= $entry_text; ?>" rows="5" class="form-control"><?= isset($item['description'][$language['language_id']]['text']) ? $item['description'][$language['language_id']]['text'] : ''; ?></textarea>
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_textile_new['title'][$item['textile_id']])) { ?>
                                              <div class="text-danger"><?= $error_textile_new['title'][$item['textile_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="textile-image-<?= $item['textile_id']; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="textile_new[<?= $item['textile_id']; ?>][image]" value="<?= $item['image']; ?>" id="input-textile-image-<?= $item['textile_id']; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="textile_new[<?= $item['textile_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="textile_new[<?= $item['textile_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="textile_new-row-<?= $textile_row; ?>" data-type="textile_new"
                                                  class="btn btn-danger delete-textile"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $textile_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="4"></td>
                                  <td class="text-left"><button type="button" onclick="addTextile();" data-toggle="tooltip" title="<?= $button_textile_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-sizes_table">
                      <div class="table-responsive">
                          <table id="size_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 15%;"><?= $entry_age; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_height; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_chest; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_thigh; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_sort_order; ?></td>
                                  <td class="text-left" style="width: 20%;"><?= $entry_status; ?></td>
                                  <td style="width: 10%;"></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $size_row = 0; ?>
                              <?php foreach ($size as $item) { ?>
                                  <tr id="size-row-<?= $size_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="size_id" name="size[<?= $item['size_id']; ?>][size_id]" value="<?= $item['size_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="size[<?= $item['size_id']; ?>][description][<?= $language['language_id'] ?>][age]" value="<?= isset($item['description'][$language['language_id']]['age']) ? $item['description'][$language['language_id']]['age'] : ''; ?>"
                                                         placeholder="<?= $entry_age; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_size['age'][$item['size_id']])) { ?>
                                              <div class="text-danger"><?= $error_size['age'][$item['size_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size[<?= $item['size_id']; ?>][height]" value="<?= $item['height']; ?>"
                                                 placeholder="<?= $entry_height; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size[<?= $item['size_id']; ?>][chest]" value="<?= $item['chest']; ?>"
                                                 placeholder="<?= $entry_chest; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size[<?= $item['size_id']; ?>][thigh]" value="<?= $item['thigh']; ?>"
                                                 placeholder="<?= $entry_thigh; ?>" class="form-control" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="size[<?= $item['size_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="size[<?= $item['size_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="size-row-<?= $size_row; ?>" data-type="size"
                                                  class="btn btn-danger delete-size"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $size_row++; ?>
                              <?php } ?>
                              <?php if (isset($size_new)) foreach ($size_new as $item) { ?>
                                  <tr id="size_new-row-<?= $size_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="size_id" name="size_new[<?= $item['size_id']; ?>][size_id]" value="<?= $item['size_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="size_new[<?= $item['size_id']; ?>][description][<?= $language['language_id'] ?>][age]" value="<?= isset($item['description'][$language['language_id']]['age']) ? $item['description'][$language['language_id']]['age'] : ''; ?>"
                                                         placeholder="<?= $entry_age; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_size['age'][$item['size_id']])) { ?>
                                              <div class="text-danger"><?= $error_size['age'][$item['size_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size_new[<?= $item['size_id']; ?>][height]" value="<?= $item['height']; ?>"
                                                 placeholder="<?= $entry_height; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size_new[<?= $item['size_id']; ?>][chest]" value="<?= $item['chest']; ?>"
                                                 placeholder="<?= $entry_chest; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <input type="text" name="size_new[<?= $item['size_id']; ?>][thigh]" value="<?= $item['thigh']; ?>"
                                                 placeholder="<?= $entry_thigh; ?>" class="form-control" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="size_new[<?= $item['size_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="size_new[<?= $item['size_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="size_new-row-<?= $size_row; ?>" data-type="size_new"
                                                  class="btn btn-danger delete-size"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $size_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="6"></td>
                                  <td class="text-left"><button type="button" onclick="addSize();" data-toggle="tooltip" title="<?= $button_size_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-recommendations">
                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_status; ?></label>
                          <div class="col-sm-10">
                              <select name="care[status]" class="form-control">
                                  <?php if ($care['status']) { ?>
                                      <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                      <option value="0"><?= $entry_status_off; ?></option>
                                  <?php } else { ?>
                                      <option value="1"><?= $entry_status_on; ?></option>
                                      <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group required">
                          <input type="hidden" name="care[care_id]" value="<?= isset($care['care_id']) ? $care['care_id'] : '' ?>"/>
                          <label class="col-sm-2 control-label pull-left"><?= $entry_care_text; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <textarea rows="5" class="form-control" name="care[description][<?= $language['language_id'] ?>][text]" placeholder="<?= $entry_care_text; ?>"><?= isset($care['description'][$language['language_id']]['text']) ? $care['description'][$language['language_id']]['text'] : '' ?></textarea>
                                      <?php if (isset($error_care_text[$language['language_id']])) { ?>
                                          <div class="text-danger"><?= $error_care_text[$language['language_id']]; ?></div>
                                      <?php } ?>
                                  </div>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="table-responsive">
                          <table id="recommendation_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 20%;"><?= $entry_image_title; ?></td>
                                  <td class="text-left" style="width: 10%;"><?= $entry_images; ?></td>
                                  <td class="text-left" style="width: 40%;"><?= $entry_recommendation; ?></td>
                                  <td class="text-left" style="width: 10%;"><?= $entry_sort_order; ?></td>
                                  <td class="text-left" style="width: 20%;"><?= $entry_status; ?></td>
                                  <td style="width: 10%;"></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $recommendation_row = 0; ?>
                              <?php foreach ($recommendation as $item) { ?>
                                  <tr id="recommendation-row-<?= $recommendation_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="recommendation_id" name="recommendation[<?= $item['recommendation_id']; ?>][recommendation_id]" value="<?= $item['recommendation_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="recommendation[<?= $item['recommendation_id']; ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_recommendation[$item['recommendation_id']]['title'][$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_recommendation[$item['recommendation_id']]['title'][$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="recommendation-image-<?= $item['recommendation_id']; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="recommendation[<?= $item['recommendation_id']; ?>][image]" value="<?= $item['image']; ?>" id="input-recommendation-image-<?= $item['recommendation_id']; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <textarea rows="5" class="form-control" name="recommendation[<?= $item['recommendation_id']; ?>][description][<?= $language['language_id'] ?>][description]" placeholder="<?= $entry_care_text; ?>"><?= isset($item['description'][$language['language_id']]['description']) ? $item['description'][$language['language_id']]['description'] : '' ?></textarea>
                                                  <?php if (isset($error_recommendation[$item['recommendation_id']]['description'][$language['language_id']])) { ?>
                                                      <div class="text-danger"><?= $error_recommendation[$item['recommendation_id']]['description'][$language['language_id']]; ?></div>
                                                  <?php } ?>
                                              </div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="recommendation[<?= $item['recommendation_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="recommendation[<?= $item['recommendation_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="recommendation-row-<?= $recommendation_row; ?>" data-type="recommendation"
                                                  class="btn btn-danger delete-recommendation"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $recommendation_row++; ?>
                              <?php } ?>
                              <?php if (isset($recommendation_new)) foreach ($recommendation_new as $item) { ?>
                                  <tr id="recommendation_new-row-<?= $recommendation_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="recommendation_id" name="recommendation_new[<?= $item['recommendation_id']; ?>][recommendation_id]" value="<?= $item['recommendation_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="recommendation_new[<?= $item['recommendation_id']; ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_recommendation_new[$item['recommendation_id']]['title'][$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_recommendation_new[$item['recommendation_id']]['title'][$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="recommendation-image-new-<?= $item['recommendation_id']; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="recommendation_new[<?= $item['recommendation_id']; ?>][image]" value="<?= $item['image']; ?>" id="input-recommendation-image-new-<?= $item['recommendation_id']; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <textarea rows="5" class="form-control" name="recommendation_new[<?= $item['recommendation_id']; ?>][description][<?= $language['language_id'] ?>][description]" placeholder="<?= $entry_care_text; ?>"><?= isset($item['description'][$language['language_id']]['description']) ? $item['description'][$language['language_id']]['description'] : '' ?></textarea>
                                                  <?php if (isset($error_recommendation_new[$item['recommendation_id']]['description'][$language['language_id']])) { ?>
                                                      <div class="text-danger"><?= $error_recommendation_new[$item['recommendation_id']]['description'][$language['language_id']]; ?></div>
                                                  <?php } ?>
                                              </div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="recommendation_new[<?= $item['recommendation_id']; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="recommendation_new[<?= $item['recommendation_id']; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="recommendation_new-row-<?= $recommendation_row; ?>" data-type="recommendation_new"
                                                  class="btn btn-danger delete-recommendation"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $recommendation_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="5"></td>
                                  <td class="text-left"><button type="button" onclick="addRecommendation();" data-toggle="tooltip" title="<?= $button_recommendation_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-quality">
                      <div class="table-responsive">
                          <table id="quality_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 15%;"><?= $entry_sort_order; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_status; ?></td>
                                  <td class="text-left" style="width: 60%;"><?= $entry_text; ?></td>
                                  <td style="width: 10%;"></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $text_row = 0; ?>
                              <?php foreach ($quality as $item) { ?>
                                  <tr id="quality-row-<?= $text_row; ?>">
                                      <td class="text-left" style="width: 15%;">
                                          <input type="hidden" name="quality[<?= $text_row; ?>][quality_id]" value="<?= $item['quality_id']; ?>" />
                                          <input type="text" name="quality[<?= $text_row; ?>][sort_order]" value="<?= $item['sort_order']; ?>" placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="width: 15%;">
                                          <select name="quality[<?= $text_row; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left" style="width: 60%;">
                                          <?php foreach ($item['description'] as $language_id => $value) { ?>
                                              <?php foreach ($languages as $language) { ?>
                                                  <?php if ($language['language_id'] == $language_id) { ?>
                                                      <div class="input-group" style="margin-bottom: 5px;">
                                                          <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                          <input type="text" name="quality[<?= $text_row; ?>][description][<?= $language['language_id']; ?>][title]" value="<?= isset($value['title']) ? $value['title'] : ''; ?>"
                                                                 placeholder="<?= $entry_title; ?>" class="form-control" />
                                                      </div>
                                                      <div class="input-group" style="margin-bottom: 5px;"><span class="input-group-addon"><img src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png" title="<?= $language['name']; ?>" /></span>
                                                          <textarea id="quality-<?= $text_row; ?>-<?= $language_id ?>" name="quality[<?= $text_row; ?>][description][<?= $language['language_id']; ?>][text]" rows="5" placeholder="<?= $entry_text; ?>" class="form-control summernote"><?= isset($value['text']) ? $value['text'] : ''; ?></textarea>
                                                      </div>
                                                  <?php } ?>
                                              <?php } ?>
                                          <?php } ?></td>
                                      <td class="text-left" style="width: 10%;"><button type="button" data-row="quality-row-<?= $text_row; ?>" data-type="quality" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-quality"><i class="fa fa-minus-circle"></i></button></td>
                                  </tr>
                                  <?php $text_row++; ?>
                              <?php } ?>
                              <?php if (isset($quality_new)) foreach ($quality_new as $item) { ?>
                                  <tr id="quality_new-row-<?= $text_row; ?>">
                                      <td class="text-left" style="width: 15%;">
                                          <input type="hidden" name="quality_new[<?= $text_row; ?>][quality_id]" value="<?= $item['quality_id']; ?>" />
                                          <input type="text" name="quality_new[<?= $text_row; ?>][sort_order]" value="<?= $item['sort_order']; ?>" placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left" style="width: 15%;">
                                          <select name="quality_new[<?= $text_row; ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left" style="width: 60%;">
                                          <?php foreach ($item['description'] as $language_id => $value) { ?>
                                              <?php foreach ($languages as $language) { ?>
                                                  <?php if ($language['language_id'] == $language_id) { ?>
                                                      <div class="input-group" style="margin-bottom: 5px;">
                                                          <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                          <input type="text" name="quality_new[<?= $text_row; ?>][description][<?= $language['language_id']; ?>][title]" value="<?= isset($value['title']) ? $value['title'] : ''; ?>"
                                                                 placeholder="<?= $entry_title; ?>" class="form-control" />
                                                      </div>
                                                      <div class="input-group" style="margin-bottom: 5px;"><span class="input-group-addon"><img src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png" title="<?= $language['name']; ?>" /></span>
                                                          <textarea name="quality_new[<?= $text_row; ?>][description][<?= $language['language_id']; ?>][text]" rows="5" placeholder="<?= $entry_text; ?>" class="form-control summernote"><?= isset($value['text']) ? $value['text'] : ''; ?></textarea>
                                                      </div>
                                                  <?php } ?>
                                              <?php } ?>
                                          <?php } ?></td>
                                      <td class="text-left" style="width: 10%;"><button type="button" data-toggle="tooltip" data-row="quality_new-row-<?= $text_row; ?>" data-type="quality_new" title="<?= $button_remove; ?>" class="btn btn-danger delete-quality"><i class="fa fa-minus-circle"></i></button></td>
                                  </tr>
                                  <?php $text_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr style="width: 10%;">
                                  <td colspan="3"></td>
                                  <td class="text-left"><button type="button" onclick="addQuality();" data-toggle="tooltip" title="<?= $button_text_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-slider">
                      <div class="table-responsive">
                          <table id="image_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 45%;"><?= $entry_image_title; ?></td>
                                  <td class="text-left" style="width: 15%;"><?= $entry_slider_images; ?></td>
                                  <td class="text-right" style="width: 10%;"><?= $entry_sort_order; ?></td>
                                  <td class="text-left" style="width: 20%;"><?= $entry_status; ?></td>
                                  <td style="width: 10%;"></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $image_row = 0; ?>
                              <?php foreach ($image as $item) { ?>
                                  <tr id="image-row-<?= $image_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="image_id" name="image[<?= $image_row ?>][image_id]" value="<?= $item['image_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="image[<?= $image_row ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_image[$item['image_id']]['title'][$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_image[$item['image_id']]['title'][$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="image-<?= $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="image[<?= $image_row; ?>][image]" value="<?= $item['image']; ?>" id="input-image-<?= $image_row; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="image[<?= $image_row; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="image[<?= $image_row ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="image-row-<?= $image_row; ?>" data-type="image" class="btn btn-danger delete-image"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $image_row++; ?>
                              <?php } ?>
                              <?php if (isset($image_new)) foreach ($image_new as $item) { ?>
                                  <tr id="image_new-row-<?= $image_row; ?>">
                                      <td class="text-left">
                                          <input type="hidden" class="image_id" name="image_new[<?= $image_row ?>][image_id]" value="<?= $item['image_id']; ?>"/>
                                          <?php foreach ($languages as $language) { ?>
                                              <div class="input-group" style="margin-bottom: 5px;">
                                                  <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                                  <input type="text" name="image_new[<?= $image_row ?>][description][<?= $language['language_id'] ?>][title]" value="<?= isset($item['description'][$language['language_id']]['title']) ? $item['description'][$language['language_id']]['title'] : ''; ?>"
                                                         placeholder="<?= $entry_image_title_p; ?>" class="form-control" />
                                              </div>
                                          <?php } ?>
                                          <?php if (isset($error_image_new[$item['image_id']]['title'][$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_image_new[$item['image_id']]['title'][$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </td>
                                      <td class="text-left" style="text-align: center;">
                                          <a href="" id="image_new-<?= $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $item['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="image_new[<?= $image_row; ?>][image]" value="<?= $item['image']; ?>" id="input-image_new-<?= $image_row; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="image_new[<?= $image_row; ?>][sort_order]" value="<?= $item['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <select name="image_new[<?= $image_row ?>][status]" class="form-control">
                                              <?php if ($item['status'] == '1') { ?>
                                                  <option value="0"><?= $entry_status_off; ?></option>
                                                  <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                              <?php } else { ?>
                                                  <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                  <option value="1"><?= $entry_status_on; ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class="text-left">
                                          <button type="button" data-row="image_new-row-<?= $image_row; ?>" data-type="image_new" class="btn btn-danger delete-image"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $image_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="4"></td>
                                  <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?= $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-settings">
                      <input type="hidden" name="setting_exist" value="<?= isset($settings) && !empty($settings) ? '1' : '0' ?>">
                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_meta_title; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <input class="form-control" name="settings[<?= $language['language_id'] ?>][meta_title]" value="<?= isset($settings[$language['language_id']]['meta_title']) ? $settings[$language['language_id']]['meta_title'] : '' ?>" placeholder="<?= $entry_meta_title; ?>" />
                                  </div>
                              <?php } ?>
                          </div>
                          <label class="col-sm-2 control-label pull-left"><?= $entry_meta_description; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <input class="form-control" name="settings[<?= $language['language_id'] ?>][meta_description]" value="<?= isset($settings[$language['language_id']]['meta_description']) ? $settings[$language['language_id']]['meta_description'] : '' ?>" placeholder="<?= $entry_meta_description; ?>" />
                                  </div>
                              <?php } ?>
                          </div>
                          <label class="col-sm-2 control-label pull-left"><?= $entry_meta_keywords; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <input class="form-control" name="settings[<?= $language['language_id'] ?>][meta_keywords]" value="<?= isset($settings[$language['language_id']]['meta_keywords']) ? $settings[$language['language_id']]['meta_keywords'] : '' ?>" placeholder="<?= $entry_meta_keywords; ?>" />
                                  </div>
                              <?php } ?>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_textile_description; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <textarea id="textile_description-<?= $language['language_id'] ?>" rows="5" class="form-control" name="settings[<?= $language['language_id'] ?>][textile_description]"
                                                placeholder="<?= $entry_textile_description; ?>"><?= isset($settings[$language['language_id']]['textile_description']) ? $settings[$language['language_id']]['textile_description'] : '' ?></textarea>
                                  </div>
                                  <script>
                                      $(function () {
                                          initializeEditor('textile_description-<?= $language['language_id'] ?>');
                                      });
                                  </script>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_sizes_description; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <textarea id="sizes_description-<?= $language['language_id'] ?>" class="form-control" name="settings[<?= $language['language_id'] ?>][sizes_description]"
                                                placeholder="<?= $entry_sizes_description; ?>"><?= isset($settings[$language['language_id']]['sizes_description']) ? $settings[$language['language_id']]['sizes_description'] : '' ?></textarea>
                                  </div>
                                  <script>
                                      $(function () {
                                          initializeEditor('sizes_description-<?= $language['language_id'] ?>');
                                      });
                                  </script>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_recommendation_description; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <textarea id="recommendation_description-<?= $language['language_id'] ?>" rows="5" class="form-control" name="settings[<?= $language['language_id'] ?>][recommendation_description]"
                                                placeholder="<?= $entry_recommendation_description; ?>"><?= isset($settings[$language['language_id']]['recommendation_description']) ? $settings[$language['language_id']]['recommendation_description'] : '' ?></textarea>
                                  </div>
                                  <script>
                                      $(function () {
                                          initializeEditor('recommendation_description-<?= $language['language_id'] ?>');
                                      });
                                  </script>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label pull-left"><?= $entry_quality_description; ?></label>
                          <div class="col-sm-10">
                              <?php foreach ($languages as $language) { ?>
                                  <div class="input-group" style="margin-bottom: 5px;">
                                      <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                      <textarea id="quality_description-<?= $language['language_id'] ?>" rows="5" class="form-control" name="settings[<?= $language['language_id'] ?>][quality_description]"
                                                placeholder="<?= $entry_quality_description; ?>"><?= isset($settings[$language['language_id']]['quality_description']) ? $settings[$language['language_id']]['quality_description'] : '' ?></textarea>
                                  </div>
                                  <script>
                                      $(function () {
                                          initializeEditor('quality_description-<?= $language['language_id'] ?>');
                                      });
                                  </script>
                              <?php } ?>
                          </div>
                      </div>
                  </div>
              </div>
          </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script> 
</div>
    <script>
        $('.summernote').summernote({ height: 150 });

        var textile_row = <?= $textile_row; ?>,
            size_row = <?= $size_row; ?>,
            recommendation_row = <?= $recommendation_row; ?>,
            text_row = <?= $text_row; ?>,
            image_row = <?= $image_row; ?>,
            sort_order = 0,
            sort_order_size = 0,
            sort_order_image = 0;

        $(function () {
            sort_order = parseInt('<?= $last_sort_order_textile; ?>');
            sort_order_size = parseInt('<?= $last_sort_order_size; ?>');
            sort_order_recommendation = parseInt('<?= $last_sort_order_recommendation; ?>');
            sort_order_quality = parseInt('<?= $last_sort_order_quality; ?>');
            sort_order_image = parseInt('<?= $last_sort_order_image; ?>');
        });

        function addTextile() {
            html  = '<tr id="textile_new-row-' + textile_row + '">';
            html += '<td class="text-left" style="width: 30%;">';
            html += '<input type="hidden" class="textile_id" name="textile_new[' + textile_row + '][textile_id]" value="' + textile_row + '" />';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<input type="text" name="textile_new[' + textile_row + '][description][<?= $language['language_id']; ?>][title]" value="" placeholder="<?= $entry_image_title_p; ?>" class="form-control" />';
            html += '</div>';
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<textarea rows="5" name="textile_new[' + textile_row + '][description][<?= $language['language_id']; ?>][text]" placeholder="<?= $entry_text; ?>" class="form-control"></textarea>';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += ' <td class="text-left" style="width: 15%; text-align: center;">';
            html += '<a href="" id="textile-image-new-' + textile_row + '" data-toggle="image" class="img-thumbnail">';
            html += '<img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />';
            html += '</a>';
            html += '<input type="hidden" name="textile_new[' + textile_row + '][image]" value="" id="input-textile-image-new-' + textile_row + '" /></td>';
            html += '</td>';
            html += '<td class="text-left" style="width: 25%;">';
            html += '<input type="text" name="textile_new[' + textile_row + '][sort_order]" value="' + sort_order + '" placeholder="<?= $entry_sort_order; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 20%;">';
            html += '<select name="textile_new[' + textile_row + '][status]" class="form-control">';
            html += '<option value="0" selected="selected"><?= $entry_status_off; ?></option>';
            html += '<option value="1"><?= $entry_status_on; ?></option>';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-textile" data-row="textile_new-row-' + textile_row + '" data-type="textile_new"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#textile_table tbody').append(html);

            textile_row++;
            sort_order++;
        }

        function addSize() {
            html  = '<tr id="size_new-row-' + size_row + '">';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="hidden" class="size_id" name="size_new[' + size_row + '][size_id]" value="' + size_row + '" />';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<input type="text" name="size_new[' + size_row + '][description][<?= $language['language_id']; ?>][age]" value="" placeholder="<?= $entry_age; ?>" class="form-control" />';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="text" name="size_new[' + size_row + '][height]" value="" placeholder="<?= $entry_height; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="text" name="size_new[' + size_row + '][chest]" value="" placeholder="<?= $entry_chest; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="text" name="size_new[' + size_row + '][thigh]" value="" placeholder="<?= $entry_thigh; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="text" name="size_new[' + size_row + '][sort_order]" value="' + sort_order_size + '" placeholder="<?= $entry_sort_order; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 20%;">';
            html += '<select name="size_new[' + size_row + '][status]" class="form-control">';
            html += '<option value="0" selected="selected"><?= $entry_status_off; ?></option>';
            html += '<option value="1"><?= $entry_status_on; ?></option>';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-textile" data-row="size_new-row-' + size_row + '" data-type="size_new"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#size_table tbody').append(html);

            size_row++;
            sort_order_size++;
        }

        function addRecommendation() {
            html  = '<tr id="recommendation_new-row-' + recommendation_row + '">';
            html += '<td class="text-left" style="width: 20%;">';
            html += '<input type="hidden" class="recommendation_id" name="recommendation_new[' + recommendation_row + '][recommendation_id]" value="' + recommendation_row + '" />';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<input type="text" name="recommendation_new[' + recommendation_row + '][description][<?= $language['language_id']; ?>][title]" value="" placeholder="<?= $entry_image_title_p; ?>" class="form-control" />';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += ' <td class="text-left" style="width: 10%; text-align: center;">';
            html += '<a href="" id="recommendation-image-new-' + recommendation_row + '" data-toggle="image" class="img-thumbnail">';
            html += '<img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />';
            html += '</a>';
            html += '<input type="hidden" name="recommendation_new[' + recommendation_row + '][image]" value="" id="input-recommendation-image-new-' + recommendation_row + '" /></td>';
            html += '</td>';
            html += '<td class="text-left" style="width: 40%;">';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<textarea rows="5" class="form-control" name="recommendation_new[' + recommendation_row + '][description][<?= $language['language_id'] ?>][description]" placeholder="<?= $entry_care_text; ?>"></textarea>';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<input type="text" name="recommendation_new[' + recommendation_row + '][sort_order]" value="' + sort_order_recommendation + '" placeholder="<?= $entry_sort_order; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 20%;">';
            html += '<select name="recommendation_new[' + recommendation_row + '][status]" class="form-control">';
            html += '<option value="0" selected="selected"><?= $entry_status_off; ?></option>';
            html += '<option value="1"><?= $entry_status_on; ?></option>';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-recommendation" data-row="recommendation_new-row-' + recommendation_row + '" data-type="recommendation_new"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#recommendation_table tbody').append(html);

            recommendation_row++;
            sort_order_recommendation++;
        }

        function addQuality() {
            html  = '<tr id="quality_new-row-' + text_row + '">';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<input type="hidden" name="quality_new[' + text_row + '][quality_id]" value=""/>';
            html += '<input type="text" name="quality_new[' + text_row + '][sort_order]" value="' + sort_order_quality + '"  class="form-control"/>';
            html += '</td>';
            html += '<td class="text-left" style="width: 15%;">';
            html += '<select name="quality_new[' + text_row + '][status]" class="form-control">';
            html += '<option value="0" selected="selected"><?= $entry_status_off; ?></option>';
            html += '<option value="1"><?= $entry_status_on; ?></option>';
            html += '</td>';
            html += '<td class="text-left" style="width: 60%;">';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<input type="text" name="quality_new[' + text_row + '][description][<?= $language['language_id']; ?>][title]" value="" placeholder="<?= $entry_title; ?>" class="form-control" />';
            html += '</div>';
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<textarea id="quality-' + text_row + '-<?= $language['language_id']; ?>" rows="5" class="form-control summernote" name="quality_new[' + text_row + '][description][<?= $language['language_id'] ?>][text]" placeholder="<?= $entry_text; ?>"></textarea>';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-quality" data-row="quality_new-row-' + text_row + '" data-type="quality_new"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#quality_table tbody').append(html);

            <?php foreach ($languages as $language) { ?>
            initializeEditor('quality-' + text_row + '-<?= $language['language_id']; ?>');
            <?php } ?>

            text_row++;
            sort_order_quality++;
        }

        function addImage() {
            html  = '<tr id="image_new-row-' + image_row + '">';
            html += '<td class="text-left" style="width: 45%;">';
            html += '<input type="hidden" name="image_new[' + image_row + '][image_id]" value=""/>';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group" style="margin-bottom: 5px;">';
            html += '<span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>';
            html += '<input type="text" name="image_new[' + image_row + '][description][<?= $language['language_id'] ?>][title]" value="" placeholder="<?= $entry_image_title_p; ?>" class="form-control" />';
            html += '</div>';
            <?php } ?>
            html += '</td>';
            html += ' <td class="text-left" style="width: 15%; text-align: center;">';
            html += '<a href="" id="image_new-new-' + image_row + '" data-toggle="image" class="img-thumbnail">';
            html += '<img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />';
            html += '</a>';
            html += '<input type="hidden" name="image_new[' + image_row + '][image]" value="" id="input-image_new-new-' + image_row + '" /></td>';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<input type="text" name="image_new[' + image_row + '][sort_order]" value="' + sort_order_image + '"  class="form-control"/>';
            html += '</td>';
            html += '<td class="text-left" style="width: 20%;">';
            html += '<select name="image_new[' + image_row + '][status]" class="form-control">';
            html += '<option value="0" selected="selected"><?= $entry_status_off; ?></option>';
            html += '<option value="1"><?= $entry_status_on; ?></option>';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-image" data-row="image_new-row-' + image_row + '" data-type="image_new"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#image_table tbody').append(html);

            image_row++;
            sort_order_image++;
        }

        $(document).on('click', '.delete-textile', function (e) {
            e.preventDefault();
            let row_id = $(this).data('row');
            let type = $(this).data('type');
            let textile_id = $($(this).parents('tr').find('.textile_id')).val();
            $('#' + row_id).remove();
            if (type === 'textile') {
                deleteItem({'textile_id': textile_id}, 'deleteTextile');
            }
        });

        $(document).on('click', '.delete-size', function (e) {
            e.preventDefault();
            let row_id = $(this).data('row');
            let type = $(this).data('type');
            let size_id = $($(this).parents('tr').find('.size_id')).val();
            $('#' + row_id).remove();
            if (type === 'size') {
                deleteItem({'size_id': size_id}, 'deleteSize');
            }
        });

        $(document).on('click', '.delete-recommendation', function (e) {
            e.preventDefault();
            let row_id = $(this).data('row');
            let type = $(this).data('type');
            let recommendation_id = $($(this).parents('tr').find('.recommendation_id')).val();
            $('#' + row_id).remove();
            if (type === 'recommendation') {
                deleteItem({'recommendation_id': recommendation_id}, 'deleteRecommendation');
            }
        });

        $(document).on('click', '.delete-quality', function (e) {
            e.preventDefault();
            let row_id = $(this).data('row');
            let type = $(this).data('type');
            let quality_id = $($(this).parents('tr').find('.quality_id')).val();
            $('#' + row_id).remove();
            if (type === 'quality') {
                deleteItem({'quality_id': quality_id}, 'deleteQuality');
            }
        });

        $(document).on('click', '.delete-image', function (e) {
            e.preventDefault();
            let row_id = $(this).data('row');
            let type = $(this).data('type');
            let image_id = $($(this).parents('tr').find('.image_id')).val();
            $('#' + row_id).remove();
            if (type === 'image') {
                deleteItem({'image_id': image_id}, 'deleteImage');
            }
        });

        function deleteItem(data, action) {
            $.ajax({
                url: 'index.php?route=extension/module/clients/' + action + '&token=<?= $token ?>',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (json) {
                    if (json['success']) {
                        $('.success-cover').empty();
                        $('.success-cover').append('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+ json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        setTimeout(function () {
                            $('.success-cover').empty();
                        }, 2500);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    </script>

    <script type="text/javascript">
        function initializeEditor(id) {
            $('#' + id).summernote({ height: 150 });
        }
    </script>

<?= $footer; ?>