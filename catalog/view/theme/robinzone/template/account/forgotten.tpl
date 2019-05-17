<?= $header; ?>
<section>
    <div class="container-fluid registration_background registration_background2">
        <div class="container">
            <?php if ($error_warning) { ?>
                <script>
                    $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
                </script>
            <?php } ?>
            <div class="row"><?= $content_top; ?></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="forgotPassword forgotPassword2">
                        <p class="forgotPassword_content2"><?= $heading_title; ?></p>
                        <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" class="forgotPassword_content2_form">
                            <p class="forgotPassword_content2_formCover">
                                <i class="far fa-envelope"></i><input id="input-email" type="email" name="email" value="<?= $email; ?>" placeholder="<?= $entry_email; ?>" class="forgotPassword_content2_input" required>
                            </p>
                            <button type="submit" class="forgotPassword_content_button2"><?= $text_button_forgotten; ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row"><?= $content_bottom; ?></div>
        </div>
    </div>
</section>
<?= $footer; ?>