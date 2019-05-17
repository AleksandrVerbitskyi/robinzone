<?php if ($error_warning) { ?>
    <script>
        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
    </script>
<?php } ?>
<?php if ($shipping_methods) { ?>
    <div class="cover-shipping_method-form">
        <div class="error-shipping_method"></div>
        <p class="delivery_options"><?= $text_shipping_method; ?></p>
        <ul class="delivery_block">
            <?php foreach ($shipping_methods as $shipping_method) { ?>
                <?php if (isset($shipping_method['image'])) { ?>
                    <?php if (!$shipping_method['error']) { ?>
                        <?php foreach ($shipping_method['quote'] as $quote) { ?>
                            <?php if ($quote['code'] == $code || !$code) { ?>
                                <?php $code = $quote['code']; ?>
                                <li class="delivery_list active">
                                    <input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" checked="checked" style="display: none;" />
                                    <div class="circle_cover">
                                        <div class="circle_border<?= $quote['code'] == 'ukrposhta.ukrposhta' ? ' ukrposhta-cover' : '' ?>">
                                            <img src="<?= $shipping_method['image']; ?>" alt="<?= $quote['title'] ?>" title="<?= $quote['title'] ?>" class="options_img nova-poshta">
                                        </div>
                                    </div>
                                </li>
                            <?php } else { ?>
                                <li class="delivery_list">
                                    <input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" style="display: none;" />
                                    <div class="circle_cover">
                                        <div class="circle_border<?= $quote['code'] == 'ukrposhta.ukrposhta' ? ' ukrposhta-cover' : '' ?>">
                                            <img src="<?= $shipping_method['image']; ?>" alt="<?= $quote['title'] ?>" title="<?= $quote['title'] ?>" class="options_img nova-poshta">
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>

                    <?php } else { ?>
                        <div class="alert alert-danger"><?= $shipping_method['error']; ?></div>
                    <?php } ?>
                <?php } else { ?>
                    <li class="delivery_list active">
                        <p><strong><?= $shipping_method['title']; ?></strong></p>
                        <?php if (!$shipping_method['error']) { ?>
                            <?php foreach ($shipping_method['quote'] as $quote) { ?>
                                <div class="radio">
                                    <label>
                                        <?php if ($quote['code'] == $code || !$code) { ?>
                                            <?php $code = $quote['code']; ?>
                                            <input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" checked="checked" />
                                        <?php } else { ?>
                                            <input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" />
                                        <?php } ?>
                                        <?= $quote['title']; ?> - <?= $quote['text']; ?>
                                        <?php if (isset($quote['description'])) { ?>
                                            <br /><small><?= $quote['description']; ?></small>
                                        <?php } ?>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="alert alert-danger"><?= $shipping_method['error']; ?></div>
                        <?php } ?>
                    </li>
                <?php } ?>

            <?php } ?>
        </ul>
    </div>
<?php } ?>

<div class="cover-shipping_method-form" id="shipping-new">
    <div class="error-shipping_method"></div>
    <p class="delivery_options"><?= $text_select_address; ?></p>
    <div class="select-styling3" style="display: <?= isset($addresses) && count($addresses) > 0 ? 'none' : 'block' ?>;">
        <div class="shipping_select area select-styling" style="margin-bottom: 10px;">
            <select name="shipping_area" autocomplete="address-level1" id="input-shipping-shipping_area" data-company="">
            </select>
        </div>
        <div class="shipping_select city" style="margin-bottom: 10px;">
            <select name="shipping_city" autocomplete="address-level2" id="input-shipping-shipping_city" data-company="">
                <option value="default">dfdvifv</option>
            </select>
        </div>
        <div class="shipping_select warehouse" style="margin-bottom: 5px;">
            <select name="shipping_warehouse" autocomplete="address-level2" id="input-shipping-shipping_warehouse" data-company="">
                <option value="default">dfdvifv</option>
            </select>
        </div>
    </div>
</div>

<!--<div class="buttons">-->
<!--    <div class="pull-right">-->
<!--        <input type="button" value="--><?//= $button_continue; ?><!--" id="button-shipping-method" data-loading-text="--><?//= $text_loading; ?><!--" class="btn btn-primary" />-->
<!--    </div>-->
<!--</div>-->
<style>
    .shipping_select .select {
        width: 100%;
    }
</style>

<script>
    var api_action = '<?= $novaposhta_api_action; ?>', current_api_action = 'novaposhta';
    
    $(document).on('change', 'input:radio[name=\'shipping_method\']', function () {
        var type = this.value.split('.')[0];
        current_api_action = type;
        switch (type) {
            case 'novaposhta':
                api_action = '<?= $novaposhta_api_action; ?>';
                setWarehouseAsSelect();
                setAreas('description');
                break;
            case 'intime':
                api_action = '<?= $intime_api_action; ?>';
                setWarehouseAsSelect();
                setAreas('name');
                break;
            case 'autolux':
                api_action = '<?= $autolux_api_action; ?>';
                setWarehouseAsSelect();
                setAreas('name');
                break;
            case 'ukrposhta':
                api_action = '<?= $ukrposhta_action; ?>';
                setWarehouseAsInput();
                setAreas('name');
                break;
        }
    });

    var setWarehouseAsInput = function () {
        $('.shipping_select.warehouse').html('');
        $('.shipping_select.warehouse').html('<input name="shipping_warehouse" value="" placeholder="" id="input-shipping-shipping_warehouse" class="warehouse_input" />');
    };
    var setWarehouseAsSelect = function () {
        // $('.shipping_select.warehouse').html('');
        var select = "";
        select += '<select name="shipping_warehouse" autocomplete="address-level2" id="input-shipping-shipping_warehouse" data-company="">';
        select += '<option value="default">dfdvifv</option>';
        select += '</select>';
        $('.shipping_select.warehouse').html(select);
        $('select[name=\'shipping_warehouse\']').niceSelect();
    };

    var getTitleField = function () {
        if (current_api_action === 'novaposhta') {
            return 'description';
        } else if (current_api_action === 'intime') {
            return 'name';
        } else if (current_api_action === 'autolux') {
            return 'name';
        } else if (current_api_action === 'ukrposhta') {
            return 'name';
        }
    };
    
    var setAreas = function (title_field) {
        $.ajax({
            url: api_action,
            type: 'post',
            data: {},
            dataType: 'json',
            success: function (json) {
                if (json['success']) {
                    if (json['areas']) {
                        var html = renderSelectOptions(json['areas'], 'area_id', title_field, json['text_area']);
                        $('select[name=\'shipping_area\']').html(html);
                        $('select[name=\'shipping_city\']').html(renderDefaultOptions(json['text_city']));
                        if (current_api_action === 'ukrposhta') {
                            $('input[name=\'shipping_warehouse\']').attr('placeholder', json['text_warehouse']);
                        } else {
                            $('select[name=\'shipping_warehouse\']').html(renderDefaultOptions(json['text_warehouse']));
                        }
                        updateAllSelect();
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError  + '\r\n' + xhr.responseText);
            }
        });
    };
    var setCities = function (data, title_field) {
        $.ajax({
            url: api_action,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                if (json['success']) {
                    if (json['cities']) {
                        var html = renderSelectOptions(json['cities'], 'city_id', title_field, json['text_city']);
                        $('select[name=\'shipping_city\']').html(html);
                        updateAllSelect();
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError  + '\r\n' + xhr.responseText);
            }
        });
    };
    var setWarehouses = function (data, title_field) {
        $.ajax({
            url: api_action,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (json) {
                if (json['success']) {
                    if (json['warehouses']) {
                        var html = renderSelectOptions(json['warehouses'], 'warehouse_id', title_field, json['text_warehouse']);
                        $('select[name=\'shipping_warehouse\']').html(html);
                        updateAllSelect();
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError  + '\r\n' + xhr.responseText);
            }
        });
    };

    $(function () {
        $('select[name=\'shipping_area\']').niceSelect();
        $('select[name=\'shipping_city\']').niceSelect();
        $('select[name=\'shipping_warehouse\']').niceSelect();

        setAreas('description');
    });

    $(document).on('change', 'select[name=\'shipping_area\']', function () {
        var data = {
            area_id: this.value
        };

        setCities(data, getTitleField());
    });

    $(document).on('change', 'select[name=\'shipping_city\']', function () {
        var data = {
            city_id: this.value
        };
        setWarehouses(data, getTitleField());
    });

    $(document).on('click', '.nice-select', function () {
        if ($(this).hasClass('has-error')) {
            $(this).toggleClass('has-error');
            $($(this).parent().find('.text-danger')).remove();
            updateAllSelect();
        }
    });

    var renderSelectOptions = function (data, id_field, title_field, defaultVal) {
        var html = '';
        if (defaultVal !== undefined) {
            html += '<option value="default">' + defaultVal + '</option>'
        }
        $.each(data, function (index, item) {
            html += '<option value="' + item[id_field] + '">' + item[title_field] + '</option>'
        });
        return html;
    };

    var renderDefaultOptions = function (defaultVal) {
        return '<option value="default">' + defaultVal + '</option>'
    };

    var updateAllSelect = function () {
        $('select[name=\'shipping_area\']').niceSelect('update');
        $('select[name=\'shipping_city\']').niceSelect('update');
        $('select[name=\'shipping_warehouse\']').niceSelect('update');
    };
</script>