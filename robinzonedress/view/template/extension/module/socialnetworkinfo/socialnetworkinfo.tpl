<?= $header; ?><?= $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="" id='save-social' data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></a>
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
        <div id="alert-success" style="display: none;">
            <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <span id="success-message"></span>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?= $save; ?>" method="post" enctype="multipart/form-data" id="form-social-network-info" class="form-horizontal">
                    <div class="table-responsive">
                        <table id="table-social" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left"><?= $entry_ico; ?></td>
                                <td class="text-left"><?= $entry_font; ?></td>
                                <td class="text-left"><?= $entry_url; ?></td>
                                <td class="text-left"><?= $entry_sort; ?></td>
                                <td class="text-left"><?= $entry_status; ?></td>
                                <td class="text-left"><?= $entry_which_ico; ?></td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($soc_net_rows as $social_network_row => $value) { ?>
                                <tr id="social-network-row-<?= $social_network_row; ?>">
                                    <td class="text-left">
                                        <a href="" id="thumb-image-<?= $social_network_row; ?>" data-toggle="image" class="img-thumbnail">
                                            <img src="<?= $value['thumb']; ?>" alt="" title="" data-placeholder="<?= $placeholder; ?>" /></a>
                                        <input type="hidden" name="soc_net_rows[<?= $social_network_row; ?>][image]" value="<?= $value['image']; ?>" id="input-image-<?= $social_network_row; ?>" />
                                        <?php if ($error['soc_net_rows'][$social_network_row]['error_image']) { ?>
                                            <div class="text-danger"><?= $error['soc_net_rows'][$social_network_row]['error_image']; ?></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <input type="text" name="soc_net_rows[<?= $social_network_row; ?>][font]" value="<?= $value['font']; ?>" placeholder="<?= $entry_which_ico; ?>" id="input-font-<?= $social_network_row; ?>" class="form-control" />
                                        <?php if ($error['soc_net_rows'][$social_network_row]['error_font']) { ?>
                                            <div class="text-danger"><?= $error['soc_net_rows'][$social_network_row]['error_font']; ?></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <input type="text" name="soc_net_rows[<?= $social_network_row; ?>][url]" value="<?= $value['url']; ?>" placeholder="<?= $entry_url; ?>" id="input-url-<?= $social_network_row; ?>" class="form-control" />
                                        <?php if ($error['soc_net_rows'][$social_network_row]['error_url']) { ?>
                                            <div class="text-danger"><?= $error['soc_net_rows'][$social_network_row]['error_url']; ?></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <input type="text" name="soc_net_rows[<?= $social_network_row; ?>][sort]" value="<?= $value['sort']; ?>" placeholder="<?= $entry_sort; ?>" id="input-sort-<?= $social_network_row; ?>" class="form-control" />
                                        <?php if ($error['soc_net_rows'][$social_network_row]['error_sort']) { ?>
                                            <div class="text-danger"><?= $error['soc_net_rows'][$social_network_row]['error_sort']; ?></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <select name="soc_net_rows[<?= $social_network_row; ?>][status]" id="input-status-<?= $social_network_row; ?>" class="form-control">
                                            <?php if ($value['status']) { ?>
                                                <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                                <option value="0"><?= $entry_status_off; ?></option>
                                            <?php } else { ?>
                                                <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                                <option value="1"><?= $entry_status_on; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="text-left">
                                        <select name="soc_net_rows[<?= $social_network_row; ?>][which_ico]" id="input-which_ico-<?= $social_network_row; ?>" class="form-control">
                                            <?php if ($value['which_ico'] == 'image') { ?>
                                                <option value="image" selected="selected"><?= $entry_which_image; ?></option>
                                                <option value="font"><?= $entry_which_font; ?></option>
                                            <?php } else { ?>
                                                <option value="font" selected="selected"><?= $entry_which_font; ?></option>
                                                <option value="image"><?= $entry_which_image; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="text-left">
                                        <button type="button" id="delete-social-<?= $social_network_row; ?>" data-toggle="tooltip" title="<?= $button_remove; ?>" class="btn btn-danger delete-social"><i class="fa fa-minus-circle"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td class="text-left"><button type="button" onclick="addSocialNetwork(getDataForRowAdding());" data-toggle="tooltip" title="<?= $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $footer; ?>

    <script>

        function getDataForRowAdding() {
            var last_row_id, data = [];
            if ($('#table-social tbody tr:last-child').length === 0) {
                last_row_id = 0;
            }
            else {
                last_row_id = parseInt($('#table-social tbody tr:last-child').attr('id').split('-').slice(-1)[0])
            }

            data['soc_net_row'] = last_row_id + 1;
            data['thumb'] = '<?php echo $thumb; ?>';
            data['placeholder'] = '<?php echo $placeholder; ?>';
            data['image'] = '<?php echo $image; ?>';
            data['entry_url'] = '<?php echo $entry_url; ?>';
            data['entry_sort'] = '<?php echo $entry_sort; ?>';
            data['button_remove'] = '<?php echo $button_remove; ?>';
            data['entry_status_on'] = '<?php echo $entry_status_on; ?>';
            data['entry_status_off'] = '<?php echo $entry_status_off; ?>';
            data['entry_which_image'] = '<?php echo $entry_which_image; ?>';
            data['entry_which_font'] = '<?php echo $entry_which_font; ?>';
            data['entry_font'] = '<?php echo $entry_font; ?>';
            data['entry_which_font'] = '<?php echo $entry_which_font; ?>';
            return data;
        }

        function showErrors(errors) {
            $.each(errors, function (row_id, value) {
                $.each(value, function (key, val) {
                    if ($('#error-' + row_id + '-' + key).length === 0) $('#input-' + key + '-' + row_id).after('<div class="text-danger" id="error-' + row_id + '-' + key + '">' + val + '</div>');
                });
            });
        }

        function cleanErrors() {
            $('.text-danger').remove();
            $('.alert-danger').remove();
        }

        function showSuccess(message) {
            cleanErrors();
            $('#success-message').html(message);
            $('#alert-success').show();
            setTimeout(function () {
                $('#alert-success').hide();
            }, 2000);
        }


        $(function () {
            $(document).on('click', '#save-social', function (event) {
                event.preventDefault();
                $.ajax({
                    url: 'index.php?route=extension/module/socialnetworkinfo/save&token=<?= $token; ?>',
                    dataType: 'json',
                    data: $('#form-social-network-info').serialize(),
                    type: 'post',
                    success: function (data) {
                        if (data['success']) {
                            showSuccess(data['success']);
                        } else if (data['error']) {
                            showErrors(data['error']['soc_net_rows']);
                        }
                    }
                });
                return false;
            });

            $(document).on('click', '.delete-social', function (event) {
                event.preventDefault();
                $(this).tooltip('destroy');
                var this_id = parseInt($($(this).parents('tr')).attr('id').split('-').slice(-1)[0]);
                $('#social-network-row-' + this_id).remove();
                $.ajax({
                    url: 'index.php?route=extension/module/socialnetworkinfo/delete&token=<?= $token; ?>',
                    dataType: 'json',
                    data: { 'delete' : this_id },
                    type: 'post',
                    success: function (data) {
                        if (data['success']) {
                            showSuccess(data['success']);
                        } else if (data['error']) {
                            showErrors(data['error']['soc_net_rows']);
                        }
                    }
                });
            });
        });

    </script>