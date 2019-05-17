<?= $header; ?>
<?php if ($success) { ?>
<?php } ?>
<section>
    <div class="container">
        <div class="row"><?= $content_top; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="deliveryPage_title"><?= $heading_title; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="reward-content-cover">
                    <div class="comparison_table__cover" style="text-align: center">
                        <?php if ($products) { ?>
                            <table class="comparison_table">
                                <tr class="comparison_delete">
                                    <td></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td><a href="<?= $product['remove']; ?>"><i class="far fa-times-circle"></i></a></td>
                                    <?php } ?>
                                </tr>
                                <tr class="comparison_img">
                                    <td></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td class="comparison_img__cover"><?php if ($product['thumb']) { ?>
                                                <img src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>" />
                                            <?php } ?></td>
                                    <?php } ?>
                                </tr>
                                <tr class="comparison_name">
                                    <td class="comparison_first_td_style"><?= $text_name; ?></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></td>
                                    <?php } ?>
                                </tr>
                                <tr class="comparison_model">
                                    <td class="comparison_first_td_style"><?= $text_model; ?></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td><?= $product['model']; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php if (isset($all_filters)) { ?>
                                    <?php foreach ($all_filters as $filter) {?>
                                        <tr class="comparison_season">
                                            <td class="comparison_first_td_style"><?= $filter ?></td>
                                            <?php foreach ($products as $product) { ?>
                                                <?php $i = false; ?>
                                                <?php if (isset($product['filters'])) { ?>
                                                    <?php foreach ($product['filters'] as $group => $value) { ?>
                                                        <?php if ($group == $filter) { ?>
                                                            <?php $i = true; ?>
                                                            <td><?= trim(implode(', ', $value), ', ') ?></td>
                                                            <?php break; } ?>
                                                    <?php } ?>
                                                <?php } else { ?><td></td><?php } ?>
                                                <?php if ($i == false) { ?><td></td><?php } ?>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($all_options)) { ?>
                                    <?php foreach ($all_options as $option) {?>
                                        <tr class="comparison_size">
                                            <td class="comparison_first_td_style"><?= $option ?></td>
                                            <?php foreach ($products as $product) { ?>
                                                <?php $i = false; ?>
                                                <?php if (isset($product['options'])) { ?>
                                                    <?php foreach ($product['options'] as $name => $value) { ?>
                                                        <?php if ($name == $option) { ?>
                                                            <?php $i = true; ?>
                                                            <td><?= trim(implode(', ', $value), ', ') ?></td>
                                                            <?php break; } ?>
                                                    <?php } ?>
                                                <?php } else { ?><td></td><?php } ?>
                                                <?php if ($i == false) { ?><td></td><?php } ?>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <tr class="comparison_price">
                                    <td class="comparison_first_td_style"><?= $text_price; ?></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td><?php if ($product['price']) { ?>
                                                <?php if (!$product['special']) { ?>
                                                    <?= $product['price']; ?>
                                                <?php } else { ?>
                                                    <strike><?= $product['price']; ?></strike> <?= $product['special']; ?>
                                                <?php } ?>
                                            <?php } ?></td>
                                    <?php } ?>
                                </tr>
                                <tr class="comparison_buyButton">
                                    <td class="comparison_first_td_style"></td>
                                    <?php foreach ($products as $product) { ?>
                                        <td><i class="fas fa-shopping-cart" onclick="cart.add('<?= $product['product_id']; ?>', '<?= $product['minimum']; ?>');"></i></td>
                                    <?php } ?>
                                </tr>
                            </table>
                            <div class="stage">
                                <div class="swipe">
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                    <i class="far fa-hand-point-up"></i>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </div>
                            </div>
                        <?php } else { ?>
                            <p><?= $text_empty; ?></p>
                        <?php } ?>
                    </div>
                    <a href="<?= $continue; ?>" class="moveToCatalog"><?= $button_continue; ?></a>
                </div>
            </div>
        </div>
        <div class="row"><?= $content_bottom; ?></div>
    </div>
</section>
<?= $footer; ?>
