<?= $header; ?>
<section>
    <div class="container">
        <div class="row">
            <?= $content_top; ?>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid registration_background registration_background2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="greeting">
                        <img src="catalog/view/theme/robinzone/img/marker.png" class="greeting_img" alt="greeting_img" title="greeting_img">
                        <p class="greeting_title"><?= $text_greeting; ?></p>
                    </div>
                </div>
            </div>
            <div class="row background-height">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
                    <?= $column_left ?>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9">
                    <h1 class="download_title"><?= $text_edit_address; ?></h1>
                    <div class="pesonalCabinet_personalDataBlock personalDataForm_cover add-address-form address-edit-cover">
                        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="pesonalCabinet_personalDataForm">
                            <?php if ($error_firstname) { ?>
                                <span class="text-danger"><?= $error_firstname; ?></span>
                            <?php } ?>
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i>
                                    <input type="text" name="firstname" autocomplete='given-name' id="input-firstname" value="<?= $firstname; ?>" placeholder="<?= $entry_firstname; ?>" class="personalDataForm_input address-edit-input <?= $error_firstname ? 'has-error' : '' ?>">
                                </span>
                            </div>
                            <?php if ($error_lastname) { ?>
                                <div class="text-danger"><?= $error_lastname; ?></div>
                            <?php } ?>
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i>
                                    <input type="text" name="lastname" autocomplete='family-name' id="input-lastname" value="<?= $lastname; ?>" placeholder="<?= $entry_lastname; ?>" class="personalDataForm_input address-edit-input <?= $error_lastname ? 'has-error' : '' ?>">
                                </span>
                            </div>
<!--                            <div class="personalDataForm_cover">-->
<!--                                <span><i class="far fa-building"></i>-->
<!--                                    <input type="text" name="company" id="input-company" value="--><?//= $company; ?><!--" placeholder="--><?//= $entry_company; ?><!--" class="personalDataForm_input address-edit-input">-->
<!--                                </span>-->
<!--                            </div>-->
                            <?php if ($error_address_1) { ?>
                                <div class="text-danger"><?= $error_address_1; ?></div>
                            <?php } ?>
                            <div class="personalDataForm_cover">
                                <span><i class="fas fa-map-marker-alt"></i>
                                    <input type="text" name="address_1" autocomplete='address-level1' id="input-address_1" value="<?= $address_1; ?>" placeholder="<?= $entry_address_1; ?>" class="personalDataForm_input address-edit-input <?= $error_address_1 ? 'has-error' : '' ?>">
                                </span>
                            </div>
                            <?php if ($error_city) { ?>
                                <div class="text-danger"><?= $error_city; ?></div>
                            <?php } ?>
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-building"></i>
                                    <input type="text" name="address_2" autocomplete='address-line1' id="input-address_2" value="<?= $address_2; ?>" placeholder="<?= $entry_address_2; ?>" class="personalDataForm_input address-edit-input <?= $error_city ? 'has-error' : '' ?>">
                                </span>
                            </div>
                            <?php if ($error_postcode) { ?>
                                <div class="text-danger"><?= $error_postcode; ?></div>
                            <?php } ?>
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-building"></i>
                                    <input type="text" name="city" id="input-city" autocomplete='address-line1' value="<?= $city; ?>" placeholder="<?= $entry_city; ?>" class="personalDataForm_input address-edit-input <?= $error_postcode ? 'has-error' : '' ?>">
                                </span>
                            </div>
<!--                            --><?php //if ($error_postcode) { ?>
<!--                                <div class="text-danger">--><?//= $error_postcode; ?><!--</div>-->
<!--                            --><?php //} ?>
<!--                            <div class="personalDataForm_cover">-->
<!--                                <span><i class="far fa-envelope"></i>-->
<!--                                    <input type="text" name="postcode" id="input-postcode" value="--><?//= $postcode; ?><!--" placeholder="--><?//= $entry_postcode; ?><!--" class="personalDataForm_input address-edit-input --><?//= $error_postcode ? 'has-error' : '' ?><!--">-->
<!--                                </span>-->
<!--                            </div>-->
                            <div class="inputCover">
                                <p class="address_default_title"><?= $entry_default; ?></p>
                                    <?php if ($default) { ?>
                                        <div class="inputMargin">
                                            <input type="radio" name="default" value="1" checked="checked" class="cart_registration_checkbox" />
                                            <label class="radio-inline"><?= $text_yes; ?></label>
                                        </div>
                                        <div class="inputMargin">
                                            <input type="radio" name="default" value="0" class="cart_registration_checkbox" />
                                            <label class="radio-inline"><?= $text_no; ?></label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="inputMargin">
                                            <input type="radio" name="default" value="1"  class="cart_registration_checkbox" />
                                            <label class="radio-inline"><?= $text_yes; ?></label>
                                        </div>
                                        <div class="inputMargin">
                                            <input type="radio" name="default" value="0"  class="cart_registration_checkbox" checked="checked" />
                                            <label class="radio-inline"><?= $text_no; ?></label>
                                        </div>
                                    <?php } ?>
                            </div>
                            <input type="submit" value="<?= $button_continue; ?>" class="personalDataForm_button" />
                            <a href="<?= $back; ?>" class="btn btn-default"><?= $button_back; ?></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <?= $content_bottom; ?>
        </div>
    </div>
</section>

<script>
    $(function () {
        $("li.cabinet_list a[href='<?= $address_url; ?>']").parent().toggleClass('active');
    });
</script>

<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length-2) {
		$('.form-group').eq(parseInt($(this).attr('data-sort'))+2).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length-2) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/account/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?= $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?= $zone_id; ?>') {
						html += ' selected="selected"';
			  		}

			  		html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?= $text_none; ?></option>';
			}

			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<?= $footer; ?>
