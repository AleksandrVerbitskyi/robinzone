<?php echo $header; ?>
    <section>
        <div class="container-fluid registration_background registration_background2">
            <div class="container">
                <div class="row"><?= $content_top; ?></div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="successful_registration">
                            <?php if (isset($heading_title)) { ?>
                                <p class="registration_title_p"><?= isset($text_message_title) ? $text_message_title : $heading_title ?></p>
                            <?php } ?>
                            <p class="registration_title_pc"><?= $text_message; ?></p>
                            <a href="<?= $continue; ?>" class="forgotPassword_content_button2"><?= $button_continue; ?></a>
                        </div>
                    </div>
                </div>
                <div class="row"><?= $content_bottom; ?></div>
            </div>
        </div>
    </section>
<?php echo $footer; ?>