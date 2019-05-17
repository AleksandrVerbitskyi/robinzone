<?= $header; ?>
<?php if ($success) { ?>
    <script>
        $(function(){ showMessage('<?= $success; ?>') });
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
                    <h1 class="download_title"><?= $text_my_account; ?></h1>
                    <ul class="account-list list-unstyled">
                        <li><a href="<?= $edit; ?>"><?= $text_edit; ?></a></li>
                        <li><a href="<?= $password; ?>"><?= $text_password; ?></a></li>
                        <li><a href="<?= $address; ?>"><?= $text_address; ?></a></li>
                        <li><a href="<?= $wishlist; ?>"><?= $text_wishlist; ?></a></li>
                    </ul>
                    <?php if ($credit_cards) { ?>
                        <h2><?= $text_credit_card; ?></h2>
                        <ul class="account-list list-unstyled">
                            <?php foreach ($credit_cards as $credit_card) { ?>
                                <li><a href="<?= $credit_card['href']; ?>"><?= $credit_card['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <h2 class="account_name"><?= $text_my_orders; ?></h2>
                    <ul class="account-list list-unstyled">
                        <li><a href="<?= $order; ?>"><?= $text_order; ?></a></li>
                        <li><a href="<?= $download; ?>"><?= $text_download; ?></a></li>
                        <?php if ($reward) { ?>
                            <li><a href="<?= $reward; ?>"><?= $text_reward; ?></a></li>
                        <?php } ?>
                        <li><a href="<?= $return; ?>"><?= $text_return; ?></a></li>
                    </ul>
                    <h2 class="account_name"><?= $text_my_newsletter; ?></h2>
                    <ul class="account-list list-unstyled">
                        <li><a href="<?= $newsletter; ?>"><?= $text_newsletter; ?></a></li>
                    </ul>
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
<?= $footer; ?>