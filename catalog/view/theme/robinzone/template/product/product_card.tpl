<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="productItem">
        <a href="<?= $product['href']; ?>" class="itemEnter"><img src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>"></a>
        <div class="productItem__caption">
            <a href="#" class="product-compare" data-product_id="<?= $product['product_id']; ?>" data-toggle="tooltip" title="<?= $button_compare; ?>"><i class="fas fa-exchange-alt"></i></a>
            <a href="#" class="product-wishlist" data-product_id="<?= $product['product_id']; ?>" data-toggle="tooltip" title="<?= $button_wishlist; ?>"><i class="far fa-heart"></i></a>
            <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>" />
            <a class="look2" data-toggle="tooltip" title="<?= $button_watch; ?>"><i class="fas fa-eye"></i></a>
            <a href="#"  data-toggle="tooltip" title="<?= $button_cart; ?>" onclick="cart.add('<?= $product['product_id']; ?>');" class="noveltiesSlider__buy_now"><i class="fas fa-shopping-cart"></i></a>
            <p class="slideCaption_title"><span class="slideCaption_title_name"><?= $product['name']; ?></span>
                <span class="slideCaption_title_model"><?= $text_model; ?> <?= $product['model']; ?></span>
            </p>
            <ul class="slideSizes">
                <?php if (isset($product['options']) && is_array($product['options'])) { ?>
                    <?php foreach ($product['options'] as $option) {?>
                        <li class="sizesList"><span class="sizeColor"><?= $option; ?></span></li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <?php if ($product['price']) { ?>
                <p class="sliderPrice">
                    <?php if (!$product['special']) { ?>
                        <?= $product['price']; ?>
                    <?php } else { ?>
                        <span class="oldPrice"><?= $product['price']; ?></span>
                        <span class="newPrice"><?= $product['special']; ?></span>
                    <?php } ?>
                </p>
            <?php } ?>
        </div>
    </div>
</div>