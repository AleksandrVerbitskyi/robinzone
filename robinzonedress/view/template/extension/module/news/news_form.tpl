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
          <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-general" data-toggle="tab"><?= $tab_general; ?></a></li>
                  <li><a href="#tab-data" data-toggle="tab"><?= $tab_data; ?></a></li>
                  <li><a href="#tab-text" data-toggle="tab"><?= $tab_text; ?></a></li>
                  <li><a href="#tab-image" data-toggle="tab"><?= $tab_image; ?></a></li>
              </ul>
              <div class="tab-content">
                  <div class="tab-pane active" id="tab-general">
                      <ul class="nav nav-tabs" id="language">
                          <?php foreach ($languages as $language) { ?>
                              <li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab"><img src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png" title="<?= $language['name']; ?>" /> <?= $language['name']; ?></a></li>
                          <?php } ?>
                      </ul>
                      <div class="tab-content">
                          <?php foreach ($languages as $language) { ?>
                              <div class="tab-pane" id="language<?= $language['language_id']; ?>">
                                  <div class="form-group required">
                                      <label class="col-sm-2 control-label" for="input-title<?= $language['language_id']; ?>"><?= $entry_title; ?></label>
                                      <div class="col-sm-10">
                                          <input type="text" name="news_description[<?= $language['language_id']; ?>][title]" value="<?= isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?= $entry_title; ?>" id="input-title<?= $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_name[$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_name[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-image-title<?= $language['language_id']; ?>"><?= $entry_image_title; ?></label>
                                      <div class="col-sm-10">
                                          <input type="text" name="news_description[<?= $language['language_id']; ?>][image_title]" value="<?= isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['image_title'] : ''; ?>" placeholder="<?= $entry_image_title; ?>" id="input-image-title<?= $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_name[$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_name[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-title<?= $language['language_id']; ?>"><?= $entry_meta_title; ?></label>
                                      <div class="col-sm-10">
                                          <input type="text" name="news_description[<?= $language['language_id']; ?>][meta_title]" value="<?= isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?= $entry_meta_title; ?>" id="input-meta-title<?= $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_meta_title[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-description<?= $language['language_id']; ?>"><?= $entry_meta_description; ?></label>
                                      <div class="col-sm-10">
                                          <textarea name="news_description[<?= $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?= $entry_meta_description; ?>" id="input-meta-description<?= $language['language_id']; ?>" class="form-control"><?= isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 control-label" for="input-meta-keyword<?= $language['language_id']; ?>"><?= $entry_meta_keyword; ?></label>
                                      <div class="col-sm-10">
                                          <textarea name="news_description[<?= $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?= $entry_meta_keyword; ?>" id="input-meta-keyword<?= $language['language_id']; ?>" class="form-control"><?= isset($news_description[$language['language_id']]) ? $news_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                      </div>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-data">
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-published"><?= $entry_published; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="published" data-date-format="YYYY-MM-DD hh:mm" value="<?= $published; ?>" placeholder="<?= $entry_published; ?>" id="input-published" class="form-control"/>
                              <?php if ($error_published) { ?>
                                  <div class="text-danger"><?= $error_published; ?></div>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-published_by"><?= $entry_published_by; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="published_by" value="<?= $published_by; ?>" id="input-published_by" class="form-control" <?= $published_block ? 'readonly="readonly"' : '' ?> />
                          </div>
                      </div>
                      <?php if (isset($last_edited) && isset($last_edited_by)) { ?>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-last_edited"><?= $entry_last_edited; ?></label>
                          <div class="col-sm-10">
                              <input type="hidden" name="last_edited" value="<?= $last_edited; ?>"/>
                              <input type="text" name="last_edited" value="<?= $last_edited; ?>" id="input-last_edited" class="form-control" readonly="readonly" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-last_edited_by"><?= $entry_last_edited_by; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="last_edited_by" value="<?= $last_edited_by; ?>" id="input-last_edited_by" class="form-control" readonly="readonly"/>
                          </div>
                      </div>
                      <?php } ?>

                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="thumb-thumb"><?= $entry_thumb; ?></label>
                          <div class="col-sm-10">
                              <a href="" id="thumb-thumb" data-toggle="image" class="img-thumbnail"><img src="<?= $thumb_thumb; ?>" alt="" title=""
                                     data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="thumb" value="<?= $thumb; ?>" id="input-thumb" />
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="thumb-image"><?= $entry_image; ?></label>
                          <div class="col-sm-10">
                              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?= $image_thumb; ?>" alt="" title=""
                                     data-placeholder="<?= $placeholder; ?>" /></a><input type="hidden" name="image" value="<?= $image; ?>" id="input-image" />
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-status"><?= $entry_status; ?></label>
                          <div class="col-sm-10">
                              <select name="status" id="input-status" class="form-control">
                                  <?php if ($status == '1') { ?>
                                      <option value="0"><?= $entry_status_off; ?></option>
                                      <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                  <?php } else { ?>
                                      <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                      <option value="1"><?= $entry_status_on; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-keyword"><?= $entry_keyword; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="<?= $entry_keyword; ?>" id="input-keyword" class="form-control" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-sort-order"><?= $entry_sort_order; ?></label>
                          <div class="col-sm-10">
                              <input type="text" name="sort_order" value="<?= $sort_order; ?>" placeholder="<?= $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                          </div>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-text">
                      <div class="table-responsive">
                          <table id="news_text_table" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left" style="width: 15%;"><?= $entry_text_sort_order; ?></td>
                                  <td class="text-left" style="width: 75%;"><?= $entry_text; ?></td>
                                  <td></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $text_row = 0; ?>
                              <?php foreach ($news_texts as $text_group_id => $news_text) { ?>
                                  <tr id="text-row-<?= $text_row; ?>">
                                      <td class="text-left" style="width: 40%;">
                                          <input type="text" name="news_texts[<?= $text_row; ?>][sort_order]" value="<?= $news_text['sort_order']; ?>" placeholder="<?= $entry_text_sort_order; ?>" class="form-control" />
                                          <input type="hidden" name="news_texts[<?= $text_row; ?>][text_group_id]" value="<?= $text_group_id; ?>" /></td>
                                      <td class="text-left">
                                      <?php foreach ($news_text['text'] as $language_id => $value) { ?>
                                          <?php foreach ($languages as $language) { ?>
                                              <?php if ($language['language_id'] == $language_id) { ?>
                                              <div class="input-group"><span class="input-group-addon"><img src="language/<?= $language['code']; ?>/<?= $language['code']; ?>.png" title="<?= $language['name']; ?>" /></span>
                                                  <textarea id="text-<?= $text_group_id; ?>-<?= $language['language_id']; ?>" name="news_texts[<?= $text_group_id; ?>][text][<?= $language['language_id']; ?>]" rows="5" placeholder="<?= $entry_text; ?>" class="form-control summernote"><?= isset($value) ? $value : ''; ?></textarea>
                                              </div>
                                                  <?php } ?>
                                        <?php } ?>
                                      <?php } ?></td>
                                      <td class="text-left"><button type="button" onclick="$('#text-row-<?= $text_row; ?>').remove();" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                  </tr>
                                  <?php $text_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr style="width: 10%;">
                                  <td colspan="2"></td>
                                  <td class="text-left"><button type="button" onclick="addTextBlock();" data-toggle="tooltip" title="<?= $button_text_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                              </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-image">
<!--                      <div class="table-responsive">-->
<!--                          <table class="table table-striped table-bordered table-hover">-->
<!--                              <thead>-->
<!--                              <tr>-->
<!--                                  <td class="text-left">--><?//= $entry_image; ?><!--</td>-->
<!--                              </tr>-->
<!--                              </thead>-->
<!---->
<!--                              <tbody>-->
<!--                              <tr>-->
<!--                                  <td class="text-left"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="--><?//= $thumb; ?><!--" alt="" title="" data-placeholder="--><?//= $placeholder; ?><!--" /></a><input type="hidden" name="image" value="--><?//= $image; ?><!--" id="input-image" /></td>-->
<!--                              </tr>-->
<!--                              </tbody>-->
<!--                          </table>-->
<!--                      </div>-->
                      <div class="table-responsive">
                          <table id="slider_images" class="table table-striped table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left"><?= $entry_slider_images; ?></td>
                                  <td class="text-right"><?= $entry_sort_order; ?></td>
                                  <td></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php $image_row = 0; ?>
                              <?php foreach ($news_images as $news_image) { ?>
                                  <tr id="image-row-<?= $image_row; ?>">
                                      <td class="text-left">
                                          <a href="" id="slider-image-<?= $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                              <img src="<?= $news_image['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />
                                          </a>
                                          <input type="hidden" name="news_images[<?= $image_row; ?>][image]" value="<?= $news_image['image']; ?>" id="input-image-<?= $image_row; ?>" />
                                      </td>
                                      <td class="text-right">
                                          <input type="text" name="news_images[<?= $image_row; ?>][sort_order]" value="<?= $news_image['sort_order']; ?>"
                                                 placeholder="<?= $entry_sort_order; ?>" class="form-control" />
                                      </td>
                                      <td class="text-left">
                                          <button type="button" onclick="$('#image-row-<?= $image_row; ?>').remove();"
                                                   class="btn btn-danger"><i class="fa fa-minus-circle"></i>
                                          </button>
                                      </td>
                                  </tr>
                                  <?php $image_row++; ?>
                              <?php } ?>
                              </tbody>
                              <tfoot>
                              <tr>
                                  <td colspan="2"></td>
                                  <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?= $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
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
$('#language a:first').tab('show');
//--></script> 
</div>
    <script>
        $('.summernote').summernote({ height: 150 });

        var input_pablished = $('#input-published'), input_last_edited =  $('#input-last_edited');
        var add_mode = <?= json_encode($published_block); ?>;

        var image_row = <?= $image_row; ?>, sort_order = 0, sort_order_texts = 0;

        $(function () {
            sort_order = <?= $last_sort_order_images; ?>;
            sort_order_texts = <?= $last_sort_order_texts; ?>;

            if (!add_mode) {
                $(input_pablished).datetimepicker({
                    locale:'ru'
                });
            }
        });

        function addImage() {
            html  = '<tr id="image-row-' + image_row + '">';
            html += ' <td class="text-left" style="width: 70%;">';
            html += '<a href="" id="slider-image-' + image_row + '" data-toggle="image" class="img-thumbnail">';
            html += '<img src="<?= $placeholder; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" />';
            html += '</a>';
            html += '<input type="hidden" name="news_images[' + image_row + '][image]" value="" id="input-image-' + image_row + '" /></td>';
            html += '</td>';
            html += '<td class="text-right" style="width: 20%;">';
            html += '<input type="text" name="news_images[' + image_row + '][sort_order]" value="' + sort_order + '" placeholder="<?= $entry_sort_order; ?>" class="form-control" />';
            html += '</td>';
            html += '<td class="text-left" style="width: 10%;">';
            html += '<button type="button" onclick="$(\'#image-row-' + image_row + '\').remove();" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i> </button>';
            html += '</td>';
            html += '</tr>';

            $('#slider_images tbody').append(html);

            image_row++;
            sort_order++;
        }

        var text_row = <?php echo $text_row; ?>;

        function addTextBlock() {
            html  = '<tr id="text-row-' + text_row + '">';
            html += '  <td class="text-left" style="width: 20%;"><input type="text" name="news_texts[' + text_row + '][sort_order]" value="' + sort_order_texts + '" placeholder="<?php echo $entry_text_sort_order; ?>" class="form-control" />';
            html += '<input type="hidden" name="news_texts[' + text_row + '][text_group_id]" value="' + text_row + '" /></td>';
            html += '  <td class="text-left">';
            <?php foreach ($languages as $language) { ?>
            html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>';
            html += '<textarea id="text-' + text_row + '-<?= $language['language_id']; ?>" name="news_texts[' + text_row + '][text][<?php echo $language['language_id']; ?>]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control summernote"></textarea></div>';
            <?php } ?>
            html += '  </td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#text-row-' + text_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#news_text_table tbody').append(html);
            <?php foreach ($languages as $language) { ?>
                initializeEditor('text-' + text_row + '-<?= $language['language_id']; ?>');
            <?php } ?>
            text_row++;
            sort_order_texts++;
        }
    </script>

    <script type="text/javascript">
        function initializeEditor(id) {
            $('#' + id).summernote({ height: 150 });
        }
    </script>

<?= $footer; ?>