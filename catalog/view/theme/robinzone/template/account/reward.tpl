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
                    <div class="reward-content-cover">
                        <p class="bonus_number"><?= $text_total; ?> <span><?= $total; ?></span></p>
                        <?php if ($rewards) { ?>
                            <?php foreach ($rewards  as $reward) { ?>
                                <ul class="bonus_block">
                                    <li class="bonus_list"><?= $column_date_added; ?> <span><?= $reward['date_added']; ?></span></li>
                                    <li class="bonus_list"><?= $column_description; ?> <span class="reward-order-id"><?php if ($reward['order_id']) { ?>
                                                <a href="<?= $reward['href']; ?>"><?= $reward['description']; ?></a>
                                            <?php } else { ?>
                                                <?= $reward['description']; ?>
                                            <?php } ?></span></li>
                                    <li class="bonus_list"><?= $column_points; ?> <span><?= $reward['points']; ?></span></li>
                                </ul>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="bonus_left"><?= $text_empty; ?></p>
                        <?php } ?>
                        <a href="<?= $continue; ?>" class="moveToCatalog"><?= $button_continue; ?></a>
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
<?= $footer; ?>