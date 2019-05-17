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
                    <div class="return_block_cover">
                        <?php if ($returns) { ?>
                        <div class="accardion">
                            <div class="return_order_c">
                                <p class="return_order__number"><?= $column_return_id; ?></p>
                                <p class="return_satus"><?= $column_status; ?></p>
                                <p class="return_order__date"><?= $column_date_added; ?></p>
                                <p class="order_number"><?= $column_price; ?></p>
                                <p class="return_order__left"><?= $column_order_id; ?></p>
                            </div>
                            <?php foreach ($returns as $return) { ?>
                                <div class="return">
                                    <div class="return_order_allStyle">
                                        <p class="return_order1">#<?= $return['return_id']; ?></p>
                                        <p class="return_order__date"><?= $return['status']; ?></p>
                                        <p class="return_order2"><?= $return['date_added']; ?></p>
                                        <p class="return_order3"><?= $return['summ']; ?></p>
                                        <p class="return_order5"><?= $return['order_id']; ?></p>
                                    </div>
                                    <article class="article_open">
                                        <div class="return_content">
                                            <div class="return_content_img_cover">
                                                <div class="return_content_img-c">
                                                    <img src="<?= $return['product']['thumb'] ?>" class="return_content_img" alt="<?= $return['product']['name'] ?>" title="<?= $return['product']['name'] ?>">
                                                </div>
                                            </div>
                                            <div class="return_content_description">
                                                <p class="return_content_title_i"><?= $return['product']['name'] ?></p>
                                                <p class="return_content_model_i"><span><?= $column_model; ?></span><span> <?= $return['product']['model'] ?></span></p>
                                                <p class="return_content_art_i"><span><?= $column_sku; ?></span><span> <?= $return['product']['sku'] ?></span></p>
                                                <p class="return_content_quantity_i"><span><?= $column_qty; ?></span><span> <?= $return['quantity'] ?></span></p>
                                            </div>
                                            <?php if (isset($return['product']['options'])) { ?>
                                                <div class="return_content_size">
                                                <?php foreach ($return['product']['options'] as $key => $value) { ?>
                                                        <?= $key; ?>: <?= $value; ?><br>
                                                <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <div class="return_content_price">
                                                Цена: <?= $return['product']['price'] ?>
                                            </div>
                                            <div class="return_content_reason">
                                                <a href="<?= $return['href']; ?>" data-toggle="tooltip" title="<?= $button_view; ?>"><i class="fas fa-eye"></i></a>
                                                <p><?= $return['reason']; ?></p>
                                                </select>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="pagination-cover">
                                    <div id="pagination">
                                        <?= $pagination; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="text-center">
                                <p><?= $text_empty; ?></p>
                            </div>
                        <?php } ?>
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
