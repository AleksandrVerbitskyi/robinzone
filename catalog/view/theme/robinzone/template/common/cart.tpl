<div id="cart" class="basket">
    <a href="#" onclick="event.preventDefault()" class="header__basket" id="count_in_cart"><img src="<?= $cart_icon; ?>" class="header__basket_img" alt="#"></a>
    <div id="qty-in-cart">
        <style>#count_in_cart:after {content: "<?= $all_in_cart; ?>";} </style>
    </div>
    <div class="basket__details">
        <div class="basket__item_static">
            <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <div class="basket__item">
                    <div class="basket__item_block">
                        <?php if ($product['thumb']) { ?>
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-basket__item_img" /></a>
                        <?php } ?>
                    </div>
                    <div class="item_description">
                        <a href="#" class="remove-from-cart" data-product_id="<?php echo $product['cart_id']; ?>" title="<?php echo $button_remove; ?>"><i class="far fa-times-circle"></i></a>
                        <a href="<?= $product['href']; ?>"><h6 class="item__title"><?= $product['name']; ?></h6></a>
                        <p class="item__model"><span><?= $text_model; ?></span><span> <?= $product['model']; ?></span></p>
                        <p class="item__quantity"><span><?= $text_qty; ?></span><span> <?= $product['quantity']; ?></span></p>
                        <?php if ($product['option']) { ?>
                            <?php foreach ($product['option'] as $option) { ?>
                                <p class="item__color"><span><?= $option['name']; ?>: </span><span> <?= $option['value']; ?></span></p>
                            <?php } ?>
                        <?php } ?>
                        <p class="item__price"><?= $product['total']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="cart_static">
            <div class="basket__sum">
            <?php foreach ($totals as $total) { ?>
                <?php if ($total['code'] == 'total') { ?>
                <span class="basket__sum_title"><?= $total['title']; ?></span>
                <span class="basket__sum_number"><?= $total['text']; ?></span>
                    <?php } ?>
            <?php } ?>
            </div>
            <a href="<?= $checkout; ?>" class="basket__order_button"><?php echo $text_checkout; ?></a>
                <?php } else { ?>
            <div class="basket__item">
                <p class="text-center"><?php echo $text_empty; ?></p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.remove-from-cart', function (e) {
        e.preventDefault();
        var id = $(this).data('product_id');
        cart.remove(id);
        location.reload();
    });
</script>
