<?php echo $header; ?>
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
                    <div class="change_password">
                        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="change_password__block">
                            <div class="input-field-change-password">
                                <span class="change_password__cover"><i class="fas fa-lock"></i><input type="password" value="<?php echo $password_old; ?>" name="password_old" autocomplete="current-password" class="change_password__input <?= $error_password_old ? 'has-error' : '' ?>" id="input-password-old" placeholder="<?= $entry_password_old; ?>"></span>
                                <?php if ($error_password_old) { ?>
                                    <span class="text-danger error-contact-password-form"><?php echo $error_password_old; ?></span>
                                <?php } ?>
                            </div>
                            <div class="input-field-change-password">
                                <span class="change_password__cover"><i class="fas fa-lock"></i><input type="password" value="<?php echo $password; ?>" name="password" autocomplete="new-password" class="change_password__input <?= $error_password ? 'has-error' : '' ?>" id="input-password" placeholder="<?= $entry_password; ?>"></span>
                                <?php if ($error_password) { ?>
                                    <span class="text-danger error-contact-password-form"><?php echo $error_password; ?></span>
                                <?php } ?>
                            </div>
                            <div class="input-field-change-password">
                                <span class="change_password__cover"><i class="fas fa-lock"></i><input type="password" value="<?php echo $confirm; ?>" name="confirm" autocomplete="new-password" class="change_password__input <?= $error_confirm ? 'has-error' : '' ?>" id="input-confirm" placeholder="<?= $entry_confirm; ?>"></span>
                                <?php if ($error_confirm) { ?>
                                    <span class="text-danger error-contact-password-form"><?php echo $error_confirm; ?></span>
                                <?php } ?>
                            </div>
                            <button type="submit" class="change_password__button"><?= $text_submit; ?></button>
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
<?php echo $footer; ?>