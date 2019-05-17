<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $modal_title; ?></h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="representative-modal" class="form-horizontal">
                    <input type="hidden" id="representative-city_id" name="representative[city_id]" value="<?= $representative['city_id']; ?>" />
                    <input type="hidden" id="representative-representative_id" name="representative[representative_id]" value="<?= $representative['representative_id']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label pull-left"><?= $modal_name; ?></label>
                        <div class="col-sm-9">
                            <?php foreach ($languages as $language) { ?>
                                <div class="input-group" style="margin-bottom: 5px;">
                                    <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                    <input id="representative-description-name-<?= $language['language_id']; ?>" type="text" name="representative[description][<?= $language['language_id']; ?>][name]" value="<?php if (isset($representative['description'][$language['language_id']]['name'])) { echo $representative['description'][$language['language_id']]['name']; } else echo ''; ?>" placeholder="<?= $modal_name; ?>" class="form-control representative-name" />
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-3 control-label pull-left"><?= $modal_address; ?></label>
                        <div class="col-sm-9">
                            <?php foreach ($languages as $language) { ?>
                                <div class="input-group" style="margin-bottom: 5px;">
                                    <span class="input-group-addon"><img src="<?= version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : sprintf('language/%1$s/%1$s.png', $language['code']) ?>" title="<?= $language['name']; ?>" /></span>
                                    <textarea id="catch-address-<?= $language['language_id'] ?>" rows="5" name="representative[description][<?= $language['language_id']; ?>][address]" placeholder="<?= nl2br($modal_address_example); ?>" class="form-control representative-address"><?php if (isset($representative['description'][$language['language_id']]['address'])) { echo $representative['description'][$language['language_id']]['address']; } else echo ''; ?></textarea>
                                </div>
                                <?php if (isset($error_address[$language['language_id']])) { ?>
                                    <div class="text-danger"><?= $error_address[$language['language_id']]; ?></div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-3 control-label pull-left"><?= $modal_latitude; ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="catch-lat" name="representative[lat]" value="<?= $representative['lat']; ?>" placeholder="<?= $modal_latitude; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-3 control-label pull-left"><?= $modal_longitude; ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="catch-lng" name="representative[lng]" value="<?= $representative['lng']; ?>" placeholder="<?= $modal_longitude; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label pull-left"><?= $modal_sort_order; ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="representative-sort_order" name="representative[sort_order]" value="<?= $representative['sort_order']; ?>" placeholder="<?= $modal_sort_order; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label pull-left"><?= $entry_status; ?></label>
                        <div class="col-sm-9">
                            <select id="representative-status" name="representative[status]" class="form-control">
                                <?php if ($representative['status']) { ?>
                                    <option value="1" selected="selected"><?= $entry_status_on; ?></option>
                                    <option value="0"><?= $entry_status_off; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?= $entry_status_on; ?></option>
                                    <option value="0" selected="selected"><?= $entry_status_off; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" onclick="deleteRepresentative()"><?= $modal_delete; ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $modal_cancel; ?></button>
                <button type="button" class="btn btn-primary" onclick="saveRepresentative()"><?= $modal_save; ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    function saveRepresentative() {
        const data = $('#representative-modal').serialize();
        $.ajax({
            url: 'index.php?route=extension/module/representatives/addRepresentative&token=' + '<?= $token ?>',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (json) {
                $('.text-danger').remove();
                if (json['errors']) {
                    for (i in json['errors']) {
                        if (i === 'address') {
                            for (language_id in json['errors'][i]) {
                                $('#catch-' + i + '-' + language_id).after('<div class="text-danger">' + json['errors'][i][language_id] + '</div>');
                            }
                        } else {
                            $('#catch-' + i).after('<div class="text-danger">' + json['errors'][i] + '</div>');
                        }
                    }
                } else if (json['success']) {
                    location.reload();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function deleteRepresentative() {
        let data = {
            representative_id: $('#representative-representative_id').val()
        };

        $.ajax({
            url: 'index.php?route=extension/module/representatives/deleteRepresentative&token=' + '<?= $token ?>',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (json) {
                $('.text-danger').remove();
                if (json['success']) {
                    location.reload();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
</script>