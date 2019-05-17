<?= $header; ?>
<section>
    <div class="container">
        <?php if ($heading_title) { ?>
            <div class="row">
                <div class="col-lg-12 ">
                    <p class="catalog_title"><?= $heading_title; ?> </p>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <?= $content_top; ?>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <?= $filter; ?>
                    <div class="col-lg-9 col-md-9 col-sm-11 col-xs-11">
                        <?php if ($products) { ?>
                            <div class="row sort_st">
                                <?php include 'category_product_sort.php'; ?>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                    <div class="topPagination">
                                        <?= $pagination_top; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row itemBorder">
                                <?php foreach ($products as $product) { ?>
                                    <?php include 'product_card.tpl'; ?>
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php if ($thumb || $description) { ?>
                                    <div class="row">
                                        <?php if ($thumb) { ?>
<!--                                            <div class="col-sm-2">-->
                                                <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" />
<!--                                            </div>-->
                                        <?php } ?>
                                        <?php if ($description) { ?>
                                            <div class="col-sm-12 seo-text-description">
                                                <p class="catalog_title"><?= $description; ?> </p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if (!$products) { ?>
                            <div class="reward-content-cover" style="text-align: center; margin-top: 50px;">
                                <p><?= $text_empty; ?></p>
                                <a href="<?= $continue; ?>" class="moveToCatalog"><?= $button_continue; ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="row"><?= $content_bottom; ?></div>
</section>
<?= $footer; ?>

<script>
    $(function () {
        $('.disabled').click(function(e){
            e.preventDefault();
        });
    });
</script>

<script>
    $(function () {
        var $store_link_hover = $('.store-link-hover');
        var $store_link = $($store_link_hover.find('a'));
        if (!$store_link.hasClass('menu-active')) $store_link.toggleClass('menu-active');
    });
</script>
