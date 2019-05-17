<?= $header; ?>
<?php if ($error_warning) { ?>
    <script>
        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
    </script>
<?php } ?>
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
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <div class="pesonalCabinet_personalDataBlock">
                        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="pesonalCabinet_personalDataForm personal-data-edit-form">
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i>
                                    <?php if ($error_firstname) { ?>
                                        <div class="text-danger"><?= $error_firstname; ?></div>
                                    <?php } ?>
                                    <input type="text" name="firstname" autocomplete='given-name' id="input-firstname" value="<?= $firstname; ?>" placeholder="<?= $entry_firstname; ?>" class="personalDataForm_input <?= $error_firstname ? 'has-error' : ''; ?>">
                                </span>
                                <span><i class="far fa-user"></i>
                                    <?php if ($error_lastname) { ?>
                                        <div class="text-danger danger-right"><?= $error_lastname; ?></div>
                                    <?php } ?>
                                    <input type="text" name="lastname" autocomplete='family-name' id="input-lastname" value="<?= $lastname; ?>" placeholder="<?= $entry_lastname; ?>" class="personalDataForm_input <?= $error_lastname ? 'has-error' : ''; ?>">
                                </span>
                            </div>
                            <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i><input type="text" name="thirdname" id="input-thirdname" value="<?= $thirdname; ?>" placeholder="<?= $entry_thirdname; ?>" class="personalDataForm_input"></span>
                                <span><i class="far fa-envelope"></i>
                                    <?php if ($error_email) { ?>
                                        <div class="text-danger danger-right"><?= $error_email; ?></div>
                                    <?php } ?>
                                    <input type="email" name="email" autocomplete='email' value="<?= $email; ?>" placeholder="<?= $entry_email; ?>" id="input-email" class="personalDataForm_input <?= $error_email ? 'has-error' : ''; ?>"><i class="fas fa-pencil-alt"></i>
                                </span>
                            </div>
                            <div class="personalDataForm_cover">
                                <span><i class="fas fa-phone"></i>
                                    <?php if ($error_telephone) { ?>
                                        <div class="text-danger danger-right"><?= $error_telephone; ?></div>
                                    <?php } ?>
                                    <input type="tel" name="telephone" autocomplete='tel-national' value="<?= $telephone; ?>" placeholder="<?= $entry_telephone; ?>" id="input-telephone" class="personalDataForm_input <?= $error_telephone ? 'has-error' : ''; ?>"><i class="fas fa-pencil-alt"></i></span>
                                <div class="return_content_reason">
                                    <select name="birthday[day]" autocomplete='off' data-name="birthday-day" id="birthday-day" class="personalDataForm_date">
                                        <option value=""><?= $text_day; ?></option>
                                        <?php foreach ($days as $day) { ?>
                                            <option value="<?= $day; ?>"><?= $day; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="return_content_reason">
                                    <select name="birthday[month]" autocomplete='off' data-name="birthday-month" id="birthday-month" class="personalDataForm_month">
                                        <option value=""><?= $text_month; ?></option>
                                        <?php foreach ($months as $key => $month) { ?>
                                            <option value="<?= $key; ?>"><?= $month; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="return_content_reason">
                                    <select name="birthday[year]" autocomplete='organization' data-name="birthday-year" id="birthday-year" class="personalDataForm_year">
                                        <option value=""><?= $text_year; ?></option>
                                        <?php foreach ($years as $year) { ?>
                                            <option value="<?= $year; ?>"><?= $year ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="personalDataForm_button"><?= $text_submit; ?></button>
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
        $('#birthday-day option[value=\'<?= $birthday[0]; ?>\']').prop('selected', true);
        $('#birthday-month option[value=\'<?= $birthday[1]; ?>\']').prop('selected', true);
        $('#birthday-year option[value=\'<?= $birthday[2]; ?>\']').prop('selected', true);
        refreshSelect();
    });
</script>

<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length) {
		$('.form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length) {
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
<?= $footer; ?>
