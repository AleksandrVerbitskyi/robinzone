<?= $header; ?>
<section>
    <div class="container-fluid registration_background registration_background2">
        <div class="container">
            <div class="row"><?= $content_top; ?></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="forgotPassword forgotPassword2">
                        <p class="forgotPassword_content2"><?= $heading_title; ?></p>
                        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="forgotPassword_content2_form password-reset">
                            <?php if ($error_password) { ?>
                                <div class="text-danger" style="font-size: 12px"><?= $error_password; ?></div>
                            <?php } ?>
                            <p class="forgotPassword_content2_formCover">
                                <i class="fas fa-lock"></i><input id="input-password" type="password" name="password" value="<?= $password; ?>" placeholder="<?= $entry_password; ?>" class="forgotPassword_content2_input" required>
                            </p>
                            <?php if ($error_confirm) { ?>
                                <div class="text-danger" style="font-size: 12px"><?= $error_confirm; ?></div>
                            <?php } ?>
                            <p class="forgotPassword_content2_formCover">
                                <i class="fas fa-lock"></i><input id="input-confirm" type="password" name="confirm" value="<?= $confirm; ?>" placeholder="<?= $entry_confirm; ?>" class="forgotPassword_content2_input" required>
                            </p>
                            <button type="submit" class="forgotPassword_content_button2"><?= $button_continue; ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row"><?= $content_bottom; ?></div>
        </div>
    </div>
</section>
<?= $footer; ?>
