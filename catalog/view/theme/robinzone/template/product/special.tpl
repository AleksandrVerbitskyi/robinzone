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
                <?php if ($products) { ?>
                    <div class="row sort_st">
                        <?php include 'sorting_line_var2.php'; ?>
                        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
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
