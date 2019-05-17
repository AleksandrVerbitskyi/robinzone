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
                  <?php if (isset($city_id)) { ?>
                      <li><a href="#tab-data" data-toggle="tab"><?= $tab_data; ?></a></li>
                  <?php } ?>
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
                                      <label class="col-sm-2 control-label" for="input-name<?= $language['language_id']; ?>"><?= $entry_name; ?></label>
                                      <div class="col-sm-10">
                                          <input type="text" name="city_description[<?= $language['language_id']; ?>][name]" value="<?= isset($city_description[$language['language_id']]) ? $city_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?= $entry_name; ?>" id="input-name<?= $language['language_id']; ?>" class="form-control" />
                                          <?php if (isset($error_name[$language['language_id']])) { ?>
                                              <div class="text-danger"><?= $error_name[$language['language_id']]; ?></div>
                                          <?php } ?>
                                      </div>
                                  </div>
                              </div>
                          <?php } ?>
                          <div class="form-group required">
                              <label class="col-sm-2 control-label" for="input-alias"><?= $entry_alias; ?></label>
                              <div class="col-sm-10">
                                  <input type="text" name="alias" value="<?= isset($alias) ? $alias : ''; ?>" placeholder="<?= $entry_alias; ?>" id="input-alias" class="form-control" />
                                  <?php if (isset($error_alias) && $error_alias != '') { ?>
                                      <div class="text-danger"><?= $error_alias; ?></div>
                                  <?php } ?>
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
                              <label class="col-sm-2 control-label" for="input-sort-order"><?= $entry_sort_order; ?></label>
                              <div class="col-sm-10">
                                  <input type="text" name="sort_order" value="<?= $sort_order; ?>" placeholder="<?= $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="tab-pane" id="tab-data">
                      <div class="table-responsive">
                          <table class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                  <td class="text-left"><?= $column_name; ?></td>
                                  <td class="text-left"><?= $column_status; ?></td>
                                  <td class="text-left"><?= $column_sort_order; ?></td>
                                  <td class="text-right"><?= $column_action; ?></td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php if ($representatives) { ?>
                                  <?php foreach ($representatives as $representative) { ?>
                                      <tr>
                                          <td class="text-left"><?= $representative['name']; ?></td>
                                          <td class="text-left"><?= $representative['status']; ?></td>
                                          <td class="text-left"><?= $representative['sort_order']; ?></td>
                                          <td class="text-right"><a href="#" data-id="<?= $representative['representative_id']; ?>" data-toggle="tooltip" title="<?= $button_edit; ?>" class="btn btn-primary edit-representative"><i class="fa fa-pencil"></i></a></td>
                                      </tr>
                                  <?php } ?>
                              <?php } else { ?>
                                  <tr>
                                      <td class="text-center" colspan="4"><?= $text_no_results; ?></td>
                                  </tr>
                              <?php } ?>
                              <tr>
                                  <td class="text-center" colspan="4">
                                      <div class="pull-right"><span onclick="addRepresentative()" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></span>
                                  </td>
                              </tr>
                              </tbody>
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
        var image_row = 0, sort_order = 0, sort_order_texts = 0;

        function addRepresentative() {
            resetRepresentativeForm();
            $('#myModal').modal('toggle');
        }

        $(document).on('click', '.edit-representative', function (e) {
            e.preventDefault();
            resetRepresentativeForm();
            var representative_id = $(this).data('id');
            loadRepresentative(representative_id);
        });

        function loadRepresentative(representative_id) {
            const data = {
                representative_id: representative_id
            };
            $.ajax({
                url: 'index.php?route=extension/module/representatives/loadRepresentative&token=' + '<?= $token ?>',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (json) {
                    $('#representative-city_id').val(json['city_id']);
                    $('#representative-representative_id').val(json['representative_id']);
                    if (json['description']) {
                        for (language in json['description']) {
                            $('#representative-description-name-' + language).val(json['description'][language]['name']);
                            $('#catch-address-' + language).val(json['description'][language]['address']);
                        }
                    }
                    $('#catch-lat').val(json['lat']);
                    $('#catch-lng').val(json['lng']);
                    $('#representative-sort_order').val(json['sort_order']);
                    if (json['status']) {
                        let select = $('#representative-status');
                        $(select).empty();
                        if (json['status'] === '1') {
                            $(select).append('<option value="1" selected="selected">' + json['entry_status_on'] + '</option>');
                            $(select).append('<option value="0">' + json['entry_status_off'] + '</option>');
                        } else if (json['status'] === '0') {
                            $(select).append('<option value="1">' + json['entry_status_on'] + '</option>');
                            $(select).append('<option value="0" selected="selected">' + json['entry_status_off'] + '</option>');
                        }
                    }
                    $('#myModal').modal('toggle');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        function resetRepresentativeForm() {
            $('#representative-representative_id').val('');
            $('.representative-address').val('');
            $('.representative-name').val('');
            $('#catch-lat').val('');
            $('#catch-lng').val('');
            $('#representative-sort_order').val('');
            let select = $('#representative-status');
            $(select).empty();
            $(select).append('<option value="1">' + '<?= $entry_status_on; ?>' + '</option>');
            $(select).append('<option value="0" selected="selected">' + '<?= $entry_status_off; ?>' + '</option>');
        }

    </script>

<?php require_once 'representative_form.tpl'; ?>

<?= $footer; ?>