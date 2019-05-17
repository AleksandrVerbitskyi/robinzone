<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button onclick="$('#form').submit();" type="submit" form="form-carousel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a class="btn btn-success" onclick="$('#actionstay').val('1');$('#form').submit();" data-toggle="tooltip" title="<?php echo $button_stay_in_module; ?>"><i class="fa fa-save"></i> + <i class="fa fa-refresh" aria-hidden="true"></i></a>
                <button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#collapse-refresh-block" aria-expanded="false" aria-controls="collapse-refresh-block" title="<?php echo $button_refresh; ?>"><i class="fa fa-download"></i></button>
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
        <div class="row">
            <div class="collapse" id="collapse-refresh-block">
                <div class="form-group" style="margin-bottom: 0px;">
                    <div class="col-sm-12">
                        <div class="well">
                            <b id="block-refresh-attribute" style="display: none;"><i class="fa fa-spinner fa-spin"></i></b> <?php echo $button_refresh_attribute; ?><br/>
                            <b id="block-refresh-filter" style="display: none;"><i class="fa fa-spinner fa-spin"></i></b> <?php echo $button_refresh_filter; ?><br/>
                            <b id="block-refresh-option" style="display: none;"><i class="fa fa-spinner fa-spin"></i></b> <?php echo $button_refresh_option; ?><br/>
                            <b id="block-refresh-stickers" style="display: none;"><i class="fa fa-spinner fa-spin"></i></b> <?php echo $button_refresh_stickers; ?><br/>
                            <b id="block-refresh-manufacturers" style="display: none;"><i class="fa fa-spinner fa-spin"></i></b> <?php echo $button_refresh_manufacturers; ?><br/><br/>
                            <button class="btn btn-success btn-sm" type="button" onclick="refreshIndexes();" id="button-refresh-start"><?php echo $button_refresh_start; ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="settings-body">
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
                    <input type="hidden" id="actionstay" name="actionstay" value="0" />
                    <div class="row">

                        <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo $entry_enable_seo; ?></label>
                                        <div class="col-sm-10">
                                            <select name="seo_expo_data[enable_seo]" class="form-control">
                                                <?php if (isset($seo_expo_data['enable_seo']) && $seo_expo_data['enable_seo']) { ?>
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
                                        <label class="col-sm-2 control-label"><?php echo $entry_data_feed; ?></label>
                                        <div class="col-sm-10">
                                            <input value="<?php echo $data_feed; ?>" type="text" class="form-control" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="well">
                                        <div class="input-group">
                                            <input type="text" name="filter_seo_url" value="" placeholder="<?php echo $text_enter_seo_url; ?>" class="form-control" />
                                            <span class="input-group-btn">
                        <button class="btn btn-danger" type="button" id="clear-filter-form"><i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?></button>
                        <button class="btn btn-primary" type="button" id="submit-filter-form"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                      </span>
                                        </div>
                                    </div>
                                    <div id="history-seo"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var types = ['stickers','filter','manufacturers','option','attribute'];
    var i = 0;

    function refreshIndexes(type) {
        $('#collapse-refresh-block b').show();
        $('#button-refresh-start').attr('disabled', 'disabled');
        if (typeof(type) == 'undefined') {
            type = 'stickers';
        }

        $.ajax({
            type: 'get',
            url:  'index.php?route=extension/module/seo_expo/refresh&<?php echo $token; ?>&type='+type,
            dataType: 'json',
            success: function(json) {
                i++;
                if (i <= types.length) {
                    $('#block-refresh-'+type).html('<i class="fa fa-check-circle"></i>');

                    refreshIndexes(types[i]);
                } else {
                    $('#button-refresh-start').removeAttr('disabled');
                    $('#collapse-refresh-block').append('<div class="container-fluid"><div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> '+json['success']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $('body').on('hidden.bs.modal', function () {
        if($('.modal.in').length > 0) {
            $('body').addClass('modal-open');
        }
    });

    function texteditor_action({id = '', destroy = false, start = true} = {}) {
        if (start) {
            $(id).summernote({focus: true});

            $(id).parent().next().find('button:eq(1)').show();

            if ($(id).summernote('isEmpty')) {
                $(id).val('');
            }
        }

        if (destroy) {
            $(id).summernote('destroy');
            $(id).parent().next().find('button:eq(1)').hide();
        }
    }
</script>
<script type="text/javascript">
    $(function() {
        $('a[href=#tab-seo]').on('click', function() {
            $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');
            $('#tab-seo .alert, #tab-seo .text-danger').remove();
        });
    });

    function submit_seo(element, action) {
        $.ajax({
            url:  'index.php?route=extension/module/seo_expo/history_seo_action&<?php echo $token; ?>',
            type: 'post',
            data: $('#modal-form-constructor input[type=\'text\'], #modal-form-constructor input[type=\'hidden\'], #modal-form-constructor textarea, #modal-form-constructor select'),
            dataType: 'json',
            success: function(json) {
                $('#modal-form-constructor-content .alert-danger, #modal-form-constructor-content .alert-success').remove();
                $('#modal-form-constructor-content .form-group').removeClass('has-error');

                if (json['error']) {
                    for (i in json['error']) {
                        if (i.replace(/_/g, '-') == 'warning') {
                            $('#modal-form-constructor-content .panel-body').append('<div class="alert alert-danger" style="margin-bottom: 0px;"><i class="fa fa-exclamation-circle"></i> ' + json['error'][i] + '</div>');
                        } else if (i.replace(/_/g, '-') == 'form-description-language') {
                            for (b in json['error'][i]) {
                                for (c in json['error'][i][b]) {
                                    $('#modal-error-'+i.replace(/_/g, '-')+'-'+b.replace(/_/g, '-')+'-'+c).append('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'][i][b][c] + '</div>');
                                }
                            }
                        } else {
                            $('#modal-error-' + i.replace(/_/g, '-')).html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'][i] + '</div>');
                            $('#modal-error-' + i.replace(/_/g, '-')).parent().parent().addClass('has-error');
                        }
                    }
                }

                if (json['success']) {
                    if (action == 'add') {
                        $(element).attr('disabled', true);
                        $(element).next().show();
                    }
                    $('a[href=#tab-seo]').click();
                    $('#modal-form-constructor-content > div > div >.panel-body').append('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            }
        });
    }

    $('#history-seo').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();
        $('#history-seo').load(this.href);
    });

    $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');

    $('#submit-filter-form').on('click', function() {
        $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>&filter_seo_url='+encodeURIComponent($('input[name=\'filter_seo_url\']').val()));
    });

    $('#clear-filter-form').on('click', function() {
        $('input[name=\'filter_seo_url\']').val('');
        $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>&filter_seo_url='+encodeURIComponent($('input[name=\'filter_seo_url\']').val()));
    });

    $('input[name=\'filter_seo_url\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=extension/module/seo_expo/autocomplete_seo_url&<?php echo $token; ?>&filter_seo_url='+encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['seo_url'],
                            value: item['seo_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'filter_seo_url\']').val(item['label']);
        }
    });

    function open_seo({id = 0} = {}) {
        html = '';

        html += '<div id="modal-form-constructor" class="modal fade">';
        html += '  <div class="modal-dialog modal-lg">';
        html += '    <div id="modal-form-constructor-list"></div>';
        html += '  </div>';
        html += '</div>';

        $('body').append(html);

        if (id > 0) {
            $('#modal-form-constructor-list').load('index.php?route=extension/module/seo_expo/history_seo&<?php echo $token; ?>&seo_id='+id);
        } else {
            $('#modal-form-constructor-list').load('index.php?route=extension/module/seo_expo/history_seo&<?php echo $token; ?>');
        }

        $('#modal-form-constructor').modal('show');
    }

    function delete_selected(filter_status, type, id) {
        $.ajax({
            type: 'post',
            url:  'index.php?route=extension/module/seo_expo/delete_selected&<?php echo $token; ?>&type='+type+'&delete='+id,
            dataType: 'json',
            success: function(json) {
                $('#tab-seo .alert, #tab-seo .text-danger').remove();

                if (json['error']) {
                    $('#history-seo').before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> '+json['error']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                if (json['success']) {
                    $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');
                    $('#history-seo').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+json['success']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                $('[role=\'tooltip\']').tooltip('destroy');
            }
        });
    }

    function delete_all(filter_status, type) {
        $.ajax({
            type: 'get',
            url:  'index.php?route=extension/module/seo_expo/delete_all&<?php echo $token; ?>&type='+type,
            dataType: 'json',
            success: function(json) {
                $('#tab-seo .alert, #tab-seo .text-danger').remove();

                if (json['error']) {
                    $('#history-seo').before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> '+json['error']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                if (json['success']) {
                    $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');
                    $('#history-seo').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+json['success']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                $('[role=\'tooltip\']').tooltip('destroy');
            }
        });
    }

    function delete_all_selected(filter_status, type) {
        var checkbox_data = $('#history-seo input[type=\'checkbox\']:checked');

        $.ajax({
            type: 'post',
            url:  'index.php?route=extension/module/seo_expo/delete_all_selected&<?php echo $token; ?>&type='+type,
            data: checkbox_data,
            dataType: 'json',
            success: function(json) {
                $('#tab-seo .alert, #tab-seo .text-danger').remove();

                if (json['error']) {
                    $('#history-seo').before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> '+json['error']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                if (json['success']) {
                    $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');
                    $('#history-seo').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+json['success']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                $('[role=\'tooltip\']').tooltip('destroy');
            }
        });
    }

    function copy_selected(id) {
        $.ajax({
            type: 'post',
            url:  'index.php?route=extension/module/seo_expo/copy_selected&<?php echo $token; ?>&copy='+id,
            dataType: 'json',
            success: function(json) {
                $('#tab-seo .alert, #tab-seo .text-danger').remove();

                if (json['error']) {
                    $('#history-seo').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+json['error']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                if (json['success']) {
                    $('#history-seo').load('index.php?route=extension/module/seo_expo/history_seo_list&<?php echo $token; ?>');
                    $('#history-seo').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+json['success']+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                $('[role=\'tooltip\']').tooltip('destroy');
            }
        });
    }
</script>
<?php echo $footer; ?>
