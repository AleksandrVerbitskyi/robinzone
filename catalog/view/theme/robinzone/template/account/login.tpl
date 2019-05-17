<?= $header; ?>
    <section>
        <div class="container-fluid registration_background">
            <div class="container">
                <?php if ($success) { ?>
                    <script>
                        $(function(){ showMessage('<?= $success; ?>') });
                    </script>
                <?php } ?>
                <?php if ($error_warning) { ?>
                    <script>
                        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
                    </script>
                <?php } ?>
                <div class="row"><?= $content_top; ?></div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="signIn__form_cover">
                            <p class="signIn__form_title"><?= $text_login; ?></p>
                            <p class="signIn__form_title2"><?= $text_account; ?></p>
                            <form action="<?= $action_login; ?>" enctype="multipart/form-data" method="post" class="signIn__form">
                                <p class="font_cover">
                                    <i class="far fa-envelope"></i>
                                    <input type="email" name="email" autocomplete='email' value="<?= $email; ?>" placeholder="<?= $entry_email; ?>" id="input-email" class="signIn__form_input" required>
                                </p>
                                <p class="font_cover">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" name="password" autocomplete="current-password" value="<?= $password; ?>" placeholder="<?= $entry_password; ?>" id="input-password" class="signIn__form_input" required>
                                </p>
                                <input type="checkbox" name="remember_me" id="rememberMe">
                                <label for="rememberMe" class="signUp__form_label"><?= $text_remember_me; ?></label><span></span>
                                <a href="<?= $forgotten; ?>" class="signUp__form_password"><?= $text_forgotten; ?></a>
                                <span class="signUp__form_socialEnter"><?= $text_login_soc_networks; ?>
                                    <a href="/socnetauth2/gmail.php?first=1"><i class="fab fa-google-plus-g"></i></a>
                                <a href="/socnetauth2/facebook.php?first=1"><i class="fab fa-facebook-f"></i></a>
                            </span>
                                <button type="submit" class="signIn__form_button"><?= $text_login; ?></button>
                                <?php if ($redirect) { ?>
                                    <input type="hidden" name="redirect" value="<?= $redirect; ?>" />
                                <?php } ?>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="signUp__form_cover">
                            <p class="signUp__form_title"><?= $text_register; ?></p>
                            <form action="<?= $action_register; ?>" enctype="multipart/form-data" method="post" class="signUp__form">
                                <p class="font_cover">
                                    <i class="far fa-user"></i>
                                    <input type="text" name="firstname" autocomplete='given-name' placeholder="<?= $entry_firstname; ?>" value="<?php echo $firstname; ?>" class="signUp__form_input" required>
                                    <?php if ($error_firstname) { ?>
                                <div class="text-danger"><?php echo $error_firstname; ?></div>
                                <?php } ?>
                                </p>
                                <p class="font_cover">
                                    <i class="far fa-envelope"></i>
                                    <input type="email" name="email" autocomplete='email' placeholder="<?= $entry_email; ?>" value="<?php echo $email; ?>" class="signUp__form_input" required>
                                    <?php if ($error_email) { ?>
                                <div class="text-danger"><?php echo $error_email; ?></div>
                            <?php } ?>
                                </p>
                                <p class="font_cover">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" name="telephone" autocomplete='tel-national' value="<?php echo $telephone; ?>" placeholder="<?= $entry_telephone; ?>" class="signUp__form_input" id="phone2" required>
                                    <?php if ($error_telephone) { ?>
                                <div class="text-danger"><?php echo $error_telephone; ?></div>
                            <?php } ?>
                                </p>
                                <span class="signUp__form_socialEnter"><?= $text_register_soc_networks; ?>
                                    <a href="/socnetauth2/gmail.php?first=1" class="socnetauth2_buttons"><i class="fab fa-google-plus-g"></i></a>
                                <a href="/socnetauth2/facebook.php?first=1" class="socnetauth2_buttons"><i class="fab fa-facebook-f"></i></a>
                            </span>
                                <button type="submit" class="signUp__form_button"><?= $text_register; ?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row"><?= $content_bottom; ?></div>
            </div>
        </div>
    </section>
<?= $footer; ?>

<style>
    .signIn__form_cover:after {
        content: '<?= $text_or ?>';
    }
</style>
