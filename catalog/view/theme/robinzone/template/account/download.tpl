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
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <?php if ($downloads) { ?>
                        <ul class="download_block">
                        <?php foreach ($downloads as $download) { ?>
                            <li class="download_list">
                                <div class="download_file">
                                    <?php if ($download['image'] != '') { ?>
                                        <img src="<?= $download['image'] ?>" alt="<?= $download['name']; ?>" title="<?= $download['name']; ?>" class="download_img">
                                    <?php } ?>
                                    <p class="download_file_buttonCover">
                                        <a href="<?= $download['href']; ?>" data-toggle="tooltip" title="<?= $button_download; ?>" class="download_button" download><?= $download['name']; ?></a>
                                    </p>
                                    <div class="download_description_cover">
                                        <p class="download_description"><?= $download['description']; ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <div class="text-center">
                            <p><?= $text_empty; ?></p>
                        </div>
                    <?php } ?>
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