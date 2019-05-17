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
                    <h1 class="download_title"><?= $text_newsletter; ?></h1>
                    <div class="pesonalCabinet_mailingBlock">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <span class="news_and_discount"><?= $entry_newsletter; ?></span>
                            <p class="news_and_discount_cover">
                                <?php if ($newsletter) { ?>
                                    <span>
                                    <input type="radio" name="newsletter" value="1" checked="checked" class="news_and_discount__input" />
                                    <label class="news_and_discount__label"><?php echo $text_yes; ?></label>
                                </span>
                                    <span>
                                    <input type="radio" name="newsletter" value="0" class="news_and_discount__input" />
                                    <label class="news_and_discount__label"><?php echo $text_no; ?></label>
                                </span>
                                <?php } else { ?>
                                    <span>
                                    <input type="radio" name="newsletter" value="1" class="news_and_discount__input" />
                                    <label class="news_and_discount__label"><?php echo $text_yes; ?></label>
                                </span>
                                    <span>
                                    <input type="radio" name="newsletter" value="0" checked="checked" class="news_and_discount__input" />
                                    <label class="news_and_discount__label"><?php echo $text_no; ?></label>
                                </span>
                                <?php } ?>
                            </p>
                            <input type="submit" value="<?php echo $button_continue; ?>" style="padding-top: 0" class="pesonalCabinet_mailingBlock_button" />
                        </form>
                    </div>
                    </form>
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