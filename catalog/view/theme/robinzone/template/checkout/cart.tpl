<?= $header; ?>
<?php if ($attention) { ?>
    <script>
        $(function(){ showMessage('<?= $attention; ?>', 'warning') });
    </script>
<?php } ?>
<?php if ($success) { ?>
    <script>
        $(function(){ showMessage('<?= $success; ?>') });
    </script>
<?php } ?>
<?php if ($error_warning) { ?>
    <script>
        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
    </script>
<?php } ?>
<section class="container-fluid registration_background registration_background2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="cartPage_title"><?= $heading_title; ?>
                    <?php if ($weight) { ?>
                        &nbsp;(<?= $weight; ?>)
                    <?php } ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <?= $checkout_column; ?>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="row"><?= $content_top; ?></div>
                <div class="cart_itemList">
                    <p class="cart_itemList_left"><?= $text_items ?></p>
<!--                    <form action="--><?//= $action; ?><!--" method="post" enctype="multipart/form-data">-->
                        <table class="cart_itemList_tabel">
                                <tr class="cart_item_row">
                                    <th class="cart_tabelTitle_name"><?= $column_name; ?></th>
                                    <th class="cart_tabelTitle_name"><?= $column_quantity; ?></th>
                                    <th class="cart_tabelTitle_name tabel_itemPrice"><?= $column_price; ?></th>
                                    <th class="cart_tabelTitle_name tabel_itemPrice"><?= $column_total; ?></th>
                                    <th class="cart_tabelTitle_name"></th>
                                </tr>
                            <?php foreach ($products as $product) { ?>
                                <tr class="cart_item_row">
                                    <td class="cart_item_cell">
                                        <div class="basket__item_block">
                                            <?php if ($product['thumb']) { ?>
                                                <a href="<?= $product['href']; ?>">
                                                    <img src="<?= $product['thumb']; ?>" class="basket__item_img" alt="<?= $product['name']; ?> title="<?= $product['name']; ?>" />
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="item_description">
                                            <h6 class="item__title"><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></h6>
                                            <?php if (!$product['stock']) { ?>
                                                <span class="text-danger-star" style="color: red">***</span>
                                            <?php } ?>
                                            <p class="item__model"><span><?= $column_model; ?></span><span> <?= $product['model']; ?></span></p>
                                            <?php if ($product['option']) { ?>
                                                <?php foreach ($product['option'] as $option) { ?>
                                                    <p class="item__color">
                                                        <span><?= $option['name']; ?>: </span><span> <?= $option['value']; ?></span>
                                                    </p>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($product['reward']) { ?>
                                                <p class="item__color">
                                                    <span><?= $product['reward']; ?></span>
                                                </p>
                                            <?php } ?>
                                            <?php if ($product['recurring']) { ?>
                                                <p class="item__color">
                                                    <span><?= $text_recurring_item; ?>: </span><span> <?= $product['recurring']; ?></span>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="cart_item_cell">
                                        <div class="cart_item_form">
                                            <div class="clearfix quantity" style="user-select: none;">
                                                <div class="inc button">-</div>
                                                    <input type="text" data-cart_id="<?= $product['cart_id']; ?>" name="quantity" value="<?= $product['quantity']; ?>" size="1" class="form-control cart-q input-qty-in-cart" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                <div class="dec button">+</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart_item_cell">
                                        <?php if ($product['price']) { ?>
                                            <p class="cart_item_price">
                                                <?php if (!$product['special']) { ?>
                                                    <span><?= $product['price']; ?></span>
                                                <?php } else { ?>
                                                    <span class="cart-discount"><?= $product['special']; ?></span> <span><?= $product['price']; ?></span>
                                                <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </td>
                                    <td class="cart_item_cell">
                                        <p class="cart_item_price2 product-total-in-cart"><?= $product['total']; ?></p>
                                    </td>
                                    <td class="cart_item_cell">
                                        <i onclick="cart.remove('<?= $product['cart_id']; ?>');" data-toggle="tooltip" title="<?= $button_remove; ?>" class="far fa-times-circle"></i>
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
<!--                    </form>-->
                </div>
                <div class="cart_item_row_discount">
                    <div class="cart_item_cell">
                        <div class="discount_form">
                            <input type="text" name="coupon" class="discount_input" placeholder="<?= $text_input_coupon ?>">
                            <button class="discount_button" id="getCouponButton"><?= $text_get_coupon ?></button>
                        </div>
                    </div>
                    <div class="cart_item_cell totals-in-cart">
                        <?php foreach ($totals as $total) { ?>
                            <p class="cart_finalPrice"><?= $total['title']; ?></p>
                            <p class="cart_finalPrice_number"><?= $total['text']; ?></p>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($customer_reward_points > 0) { ?>
                    <div class="cart_item_row_discount">
                        <div class="cart_item_cell">
                            <div class="discount_form">
                                <?= $reward; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <div class="checkout-confirm-button-cover">
                    <a href="<?= $checkout_confirm; ?>" class="orderAndBuy"><?= $text_checkout_confirm; ?></a>
                </div>
                <div class="row"><div class="payment-content"></div></div>
                <div class="row"><?= $content_bottom; ?></div>
            </div>
        </div>
    </div>
</section>

<?= $footer; ?>

<script>

    $(function () {

        $(document).on('click', '#getCouponButton', function () {
            var coupon = $($(this).prev('input[name=\'coupon\']')).val();
            console.log(coupon);
            getCoupon({coupon: coupon});
        });

        function getCoupon(data) {
            $.ajax({
                'url': '<?= $coupon; ?>',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (json) {
                    if (json['error']) {
                        showMessage(json['error'], 'warning');
                    } else if (json['redirect']) {
                        window.location.assign('index.php?route=checkout/cart');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });

        }

        function confirmCheckoutForm(data) {
            data = $('.all-data-form').serialize();

            $.ajax({
                url: 'index.php?route=checkout/confirm',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(json) {
                    $('.alert, .text-danger').remove();
                    $('.has-error').toggleClass('has-error');

                    // if (json) {
                    //     $('.payment-content').html(json);
                    // }
                    if (json['error']) {
                        var element;
                        var element_array = [];

                        for (i in json['error']) {
                            if (i === 'shipping') {
                                for (j in json['error']['shipping']) {
                                    // element = $('#input-shipping-' + j.replace('_', '-'));
                                    element = $('#input-shipping-' + j);
                                    element_array.push(element);
                                    $(element).after('<div class="text-danger"><span class="text-small">' + json['error']['shipping'][j] + '</span></div>');
                                    $(element).parent().find('.nice-select').addClass('has-error');
                                }
                            } else if (i === 'products') {
                                showMessage(json['error'][i], 'warning');
                            } else if (i === 'shipping_short') {
                                for (j in json['error']['shipping_short']) {
                                    element = $('#input-shipping_short-' + j.replace('_', '-'));
                                    element_array.push(element);
                                    $(element).after('<div class="text-danger"><span class="text-small">' + json['error']['shipping_short'][j] + '</span></div>');
                                    $(element).parent().find('.nice-select').addClass('has-error');
                                }
                            } else {
                                element = $('#input-payment-' + i.replace('_', '-'));
                                element_array.push(element);
                                $(element).after('<div class="text-danger"><span class="text-small">' + json['error'][i] + '</span></div>');
                            }
                        }

                        var scroll_to = $('.text-danger:first').parents('p.font_cover');
                        $('body').scrollTo(scroll_to, 200, {over: {top: -1, left: 0}});

                        // Highlight any found errors
                        $('.text-danger').prev('input').addClass('has-error');
                    } else if (json['redirect']) {
                        window.location.assign(json['redirect']);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        $(document).on('click', '.orderAndBuy', function (e) {
            var data = {};
            var $account = $('input:radio:checked[name=\'account\']');
            if ($account.val() === 'register') {
                // saveRegister();
                data['checkout_type'] = 'register';
            } else if ($account.val() === 'guest') {
                // saveGuest();
                data['checkout_type'] = 'guest';
            }
            e.preventDefault();
            confirmCheckoutForm(data);
        });
    });
</script>
