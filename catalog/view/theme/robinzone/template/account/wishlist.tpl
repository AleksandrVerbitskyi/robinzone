<?= $header; ?>
<?php if ($success) { ?>
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
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <div class="reward-content-cover">
                        <div class="table_cover table_cover2">
                            <?php if ($products) { ?>
                                <table class="history_table history_table2">
                                    <tr class="history_table__topRow">
                                        <th><?= $column_name; ?></th>
                                        <th><?= $column_model; ?></th>
                                        <th><?= $column_stock; ?></th>
                                        <th><?= $column_price; ?></th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($products as $product) { ?>
                                        <tr class="history_table__itemOrder history_table__itemOrder2">
                                            <td>
                                                <div class="history_table__order_imgCover">
                                                    <img src="<?= $product['thumb'] ?>" alt="<?= $product['name'] ?>" title="<?= $product['name'] ?>" class="history_table__order_img">
                                                </div>
                                                <div class="history_table__order_details">
                                                    <a href="<?= $product['href']; ?>" class="history_table_itemName"><?= $product['name'] ?></a>
                                                    <?php foreach ($product['options'] as $option) { ?>
                                                        <p class="history_table_itemColor"><?= $option['name']?>: <span><?= $option['value']?></span></p>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="history_table_itemModel"><?= $column_model ?> <span><?= $product['model']; ?></span></p>
                                            </td>
                                            <td>
                                                <p class="history_table_discountPeriod"><?= $product['stock']; ?></p>
                                            </td>
                                            <td>
                                                <?php if ($product['price']) { ?>
                                                    <p class="history_table_itemPrice">
                                                        <?php if (!$product['special']) { ?>
                                                            <span><?= $product['price']; ?></span>
                                                        <?php } else { ?>
                                                            <span class="discount"><?= $product['special']; ?></span> <span><?= $product['price']; ?></span>
                                                        <?php } ?>
                                                    </p>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <p class="history_table_itemIcons">
                                                    <a href="#" id="wishlistpage-add-to-cart" data-product-id="<?= $product['product_id']; ?>" data-toggle="tooltip" title="<?= $button_cart; ?>"><i class="fas fa-shopping-cart"></i></a>
                                                    <a href="<?= $product['remove']; ?>" data-toggle="tooltip" title="<?= $button_remove; ?>"><i class="far fa-times-circle"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <div class="stage">
                                    <div class="swipe">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                        <i class="far fa-hand-point-up"></i>
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </div>
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

<script>
    $(document).on('click', '#wishlistpage-add-to-cart', function (e) {
        e.preventDefault();
        let product_id = $(this).data('product-id');
        cart.add(product_id);
    });
</script>
