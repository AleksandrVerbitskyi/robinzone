<?= $header; ?>
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
                    <h1 class="download_title"><?= $text_address_book; ?></h1>
                    <?php if ($addresses) { ?>
                        <ul class="adress_block">
                            <?php foreach ($addresses as $result) { ?>
                                <li class="adress_list"><span><?= $result['address']; ?></span> <a href="<?= $result['delete']; ?>"><i class="far fa-times-circle"></i></a><a href="<?= $result['update']; ?>"><i class="fas fa-pencil-alt"></i></a> </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <div class="text-center">
                            <p><?= $text_empty; ?></p>
                        </div>
                    <?php } ?>
                    <a href="<?= $add; ?>" class="personalDataForm_button"><?= $button_new_address; ?></a>
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