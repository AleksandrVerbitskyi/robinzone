<?= $header; ?>
<section>
    <div class="container">
        <div class="row"><?= $content_top; ?></div>
        <div class="row">
            <?php if ($thumb || $images) { ?>
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                    <div class="itemPhotoSlider_cover">
                        <?php if ($images) { ?>
                            <div class="slider itemPhotoSlider">
                                <?php if ($thumb) { ?>
                                    <div>
                                        <div class="itemImgCover active">
                                            <img src="<?= $thumb; ?>" data-full_image="<?= $popup ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>" class="itemSlider_img">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php foreach ($images as $image) { ?>
                                    <div>
                                        <div class="itemImgCover">
                                            <img src="<?= $image['thumb']; ?>" data-full_image="<?= $image['popup'] ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>" class="itemSlider_img">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($thumb) { ?>
                    <div class="col-lg-5 col-md-9 col-sm-9 col-xs-10">
                        <div class="slider itemPhotoSl">
                            <?php if ($thumb) { ?>
                                <div>
                                    <div class="itemPhoto">
                                        <a href="<?php echo $popup; ?>" data-fancybox="gallery">
                                            <img src="<?= $popup; ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>"  class="itemPhoto_img" />
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php foreach ($images as $image) { ?>
                                <div>
                                    <div class="itemPhoto">
                                        <a href="<?php echo $image['popup']; ?>" data-fancybox="gallery">
                                            <img src="<?= $image['popup']; ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>"  class="itemPhoto_img" />
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 product-form-cover" id="product-form-in-card">
                <div class="itemPhoto_characteristics">
                    <div class="itemPhoto_characteristics_topBlock">
                        <h1 class="itemPhoto_characteristics_title"><?= $heading_title ?></h1>
                        <?php if ($manufacturer) { ?>
                            <p class="itemPhoto_characteristics_model"><?= $text_manufacturer; ?> <span><?= $manufacturer; ?></span></p>
                        <?php } ?>
                        <?php if ($reward) { ?>
                            <p class="itemPhoto_characteristics_model"><?= $text_reward; ?> <span><?= $reward; ?></span></p>
                        <?php } ?>
                        <p class="itemPhoto_characteristics_model"><?= $text_model ?> <span><?= $model; ?></span></p>
                        <span class="item_icons">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $product_link; ?>&title=<?= $title; ?>"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="https://plus.google.com/share?url=<?= $product_link; ?>"><i class="fab fa-google-plus-g"></i></a>
                                    <a href="#" class="product-compare" data-toggle="tooltip" title="<?= $button_compare; ?>" onclick="compare.add('<?= $product_id; ?>');"><i class="fas fa-exchange-alt"></i></a>
                                    <a href="#" class="product-wishlist" data-toggle="tooltip" title="<?= $button_wishlist; ?>" onclick="wishlist.add('<?= $product_id; ?>');"><i class="far fa-heart"></i></a>
                            </span>
                        <p class="itemPhoto_characteristics_inStock">
                            <?php if ($in_stock) { ?>
                                <i class="fas fa-check"></i><span><?= $stock; ?></span>
                            <?php } else { ?>
                                <i class="fas fa-times" style="color:red;"></i> <span><?= $stock; ?></span>
                            <?php } ?>
                        </p>
                        <?php if ($review_status && (int)$rating > 0) { ?>
                            <div class="itemPhoto_characteristics_feedback">
                                <span class="itemPhoto_characteristics_feedback_cover reviews-text"><?= $reviews; ?></span>
                                <p class="stars stars_cover" data-stars="<?= $rating ?>">
                                    <svg height="25" width="23" class="star rating" data-rating="1">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                    <svg height="25" width="23" class="star rating" data-rating="2">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                    <svg height="25" width="23" class="star rating" data-rating="3">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                    <svg height="25" width="23" class="star rating" data-rating="4">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                    <svg height="25" width="23" class="star rating" data-rating="5">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($price) { ?>
                        <div class="itemPhoto_characteristics_price">
                            <?php if (!$special) { ?>
                                <span class="itemPhoto_characteristics_newPrice"><?= $price; ?></span>
                            <?php } else { ?>
                                <span class="itemPhoto_characteristics_oldPrice"><?= $price; ?></span>
                                <span class="itemPhoto_characteristics_newPrice"><?= $special; ?></span>
                            <?php } ?>
<!--                            --><?php //if ($discounts) { ?>
<!--                                <li>-->
<!--                                    <hr>-->
<!--                                </li>-->
<!--                                --><?php //foreach ($discounts as $discount) { ?>
<!--                                    <li>--><?//= $discount['quantity']; ?><!----><?//= $text_discount; ?><!----><?//= $discount['price']; ?><!--</li>-->
<!--                                --><?php //} ?>
<!--                            --><?php //} ?>
                        </div>
                    <?php } ?>
                    <?php if ($options) { ?>
                    <div class="itemPhoto_characteristics_sizes">
<!--                        <span class="itemPhoto_characteristics_sizesTitle">--><?//= $text_option; ?><!--:</span>-->
                        <?php foreach ($options as $option) { ?>
                            <?php if ($option['type'] == 'select' && count($option['product_option_value']) > 0) { ?>
                                <div class="error-after-me">
                                    <span class="itemPhoto_characteristics_sizesTitle <?= ($option['required'] ? ' required-field' : ''); ?>"><?= $option['name']; ?>:</span>
                                    <select name="option[<?= $option['product_option_id']; ?>]" id="input-option<?= $option['product_option_id']; ?>" class="select-product-color">
                                        <option value=""><?= $text_select; ?></option>
                                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                            <option value="<?= $option_value['product_option_value_id']; ?>"><?= $option_value['name']; ?>
                                                <?php if ($option_value['price']) { ?>
                                                    (<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
                                                <?php } ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'radio' && count($option['product_option_value']) > 0) { ?>
                                <div class="error-after-me">
                                    <span class="itemPhoto_characteristics_sizesTitle <?= ($option['required'] ? ' required-field' : ''); ?>"><?= $option['name']; ?>:</span>
                                    <ul class="slideSizes" id="input-option<?= $option['product_option_id']; ?>">
                                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                            <li class="sizesList" data-name="option[<?= $option['product_option_id']; ?>]" data-value="<?= $option_value['product_option_value_id']; ?>" ><span class="sizeColor"><?= $option_value['name']; ?></span></li>
                                            <div class="radio" style="display: none;">
                                                <label>
                                                    <input type="radio" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option_value['product_option_value_id']; ?>" />
                                                    <?php if ($option_value['image']) { ?>
                                                        <img src="<?= $option_value['image']; ?>" alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                                                    <?php } ?>
                                                    <?= $option_value['name']; ?>
                                                    <?php if ($option_value['price']) { ?>
                                                        (<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
                                                    <?php } ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <a href="<?= $sizes_table_link; ?>" class="slideSizes_table"><?= $text_size_table ?></a>
                            <?php } ?>
                            <?php if ($option['type'] == 'checkbox') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label"><?= $option['name']; ?></label>
                                    <div id="input-option<?= $option['product_option_id']; ?>">
                                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="option[<?= $option['product_option_id']; ?>][]" value="<?= $option_value['product_option_value_id']; ?>" />
                                                    <?php if ($option_value['image']) { ?>
                                                        <img src="<?= $option_value['image']; ?>" alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                                                    <?php } ?>
                                                    <?= $option_value['name']; ?>
                                                    <?php if ($option_value['price']) { ?>
                                                        (<?= $option_value['price_prefix']; ?><?= $option_value['price']; ?>)
                                                    <?php } ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'text') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
                                    <input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>" class="form-control"/>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'textarea') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
                                    <textarea name="option[<?= $option['product_option_id']; ?>]" rows="5" placeholder="<?= $option['name']; ?>" id="input-option<?= $option['product_option_id']; ?>" class="form-control"><?= $option['value']; ?></textarea>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'file') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label"><?= $option['name']; ?></label>
                                    <button type="button" id="button-upload<?= $option['product_option_id']; ?>" data-loading-text="<?= $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?= $button_upload; ?></button>
                                    <input type="hidden" name="option[<?= $option['product_option_id']; ?>]" value="" id="input-option<?= $option['product_option_id']; ?>" />
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'date') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
                                    <div class="input-group date">
                                        <input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
                                        <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'datetime') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
                                    <div class="input-group datetime">
                                        <input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
                                        <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                                </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'time') { ?>
                                <div class="form-group<?= ($option['required'] ? ' required' : ''); ?>">
                                    <label class="control-label" for="input-option<?= $option['product_option_id']; ?>"><?= $option['name']; ?></label>
                                    <div class="input-group time">
                                        <input type="text" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['value']; ?>" data-date-format="HH:mm" id="input-option<?= $option['product_option_id']; ?>" class="form-control" />
                                        <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if ($recurrings) { ?>
                        <p class="itemPhoto_characteristics_details_title"><?= $text_payment_recurring ?>: </p>
                            <select name="recurring_id">
                                <option value=""><?= $text_select; ?></option>
                                <?php foreach ($recurrings as $recurring) { ?>
                                    <option value="<?= $recurring['recurring_id']; ?>"><?= $recurring['name']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block" id="recurring-description"></div>
                    <?php } ?>
                    <?php if ($minimum > 1) { ?>
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?= $text_minimum; ?></div>
                    <?php } ?>
                    <div class="itemPhoto_characteristics_sizes">
                        <div class="itemPhoto_characteristics_count">
                            <form class="cart_item_form" id="cart_item_form">
                                <div class="clearfix quantity" style="user-select: none;">
                                    <div class="dec button">+</div>
                                    <input type="text" name="quantity" id="input-quantity" value="<?= $minimum; ?>" size="1" class="form-control cart-q qty-in-product-card" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" >
                                    <div class="inc button">-</div>
                                </div>
                                <button type="button" id="button-cart" data-loading-text="<?= $text_loading; ?>" class="itemPhoto_characteristics_button"><?= $button_cart; ?></button>
                                <span class="itemPhoto_characteristics_order fast-order"><i class="far fa-hand-point-up"></i><?= $text_fast_order ?></span>
                            </form>
                            <input type="hidden" name="product_id" value="<?= $product_id; ?>" />
                        </div>
                    </div>
                    <?php if ($attribute_groups) { ?>
                        <div class="itemPhoto_characteristics_details">
                            <?php foreach ($attribute_groups as $attribute_group) { ?>
                                <p class="itemPhoto_characteristics_details_title"><?= $attribute_group['name']; ?>: </p>
                                <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                    <p class="itemPhoto_characteristics_details_material"><?= $attribute['name']; ?>: <span class="type"><?= $attribute['text']; ?></span></p>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($tags) { ?>
                        <p class="itemPhoto_characteristics_details_material"><?= $text_tags; ?>

                        <?php for ($i = 0; $i < count($tags); $i++) { ?>
                                <?php if ($i < (count($tags) - 1)) { ?>
                                <a href="<?= $tags[$i]['href']; ?>" class="type-tag"><?= $tags[$i]['tag']; ?></a>,
                                <?php } else { ?>
                                <a href="<?= $tags[$i]['href']; ?>" class="type-tag"><?= $tags[$i]['tag']; ?></a>
                                <?php } ?>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
<!--            <div class="col-lg-1 col-md-4 col-sm-4 col-xs-12">-->
<!--                --><?//= $column_right ?>
<!--            </div>-->
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="itemTabs_cover" id="itemTabs_cover">
                    <ul class="itemTabs_block" id="itemTabs_block">
                        <li class="itemTabs_list active" id="defaultOpen" onclick="openBlock('description', this)"><?= $tab_description; ?></li>
                        <?php if ($review_status) { ?>
                            <li class="itemTabs_list" id="item-feedback" onclick="openBlock('feedback', this)"><?= $tab_review; ?></li>
                        <?php } ?>
                    </ul>
                    <div class="itemTabs_content_one itemTabs_content" id="description">
                        <div class="description">
                            <p><?= $description; ?></p>
                            <?php if ($attribute_groups) { ?>
                                <div class="itemPhoto_characteristics_details">
                                    <?php foreach ($attribute_groups as $attribute_group) { ?>
                                        <p class="itemPhoto_characteristics_details_title"><?= $attribute_group['name']; ?>: </p>
                                        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                            <p class="itemPhoto_characteristics_details_material"><?= $attribute['name']; ?>: <span class="type"><?= $attribute['text']; ?></span></p>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($review_status) { ?>
                        <div class="itemTabs_content_two itemTabs_content" id="feedback">
                            <div class="fb_cover" id="review"></div>
                            <?php if ($review_status) { ?>
                                <div class="fb_form">
                                    <p class="leaveComment"><?= $text_write ?></p>
                                    <form class="leaveComment_form" id="form-review">
                                        <?php if ($review_guest) { ?>
                                        <span class="fb_form_c">
                                            <i class="far fa-user"></i>
                                            <input type="text" name="name" autocomplete='name' id="input-name" value="<?= $customer_name; ?>" placeholder="<?= $entry_name; ?>" class="leaveComment_input" required>
                                        </span>
                                                <span class="fb_form_c">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" name="email" autocomplete='email' id="input-email" placeholder="<?= $entry_email ?>" class="leaveComment_input" required>
                                        </span>
                                                <span class="feedback_name"><?= $entry_rating; ?></span>
                                                <p class="stars stars_cover" data-stars="1">
                                                    <svg height="25" width="23" class="star rating" data-rating="1">
                                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                                    </svg>
                                                    <svg height="25" width="23" class="star rating" data-rating="2">
                                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                                    </svg>
                                                    <svg height="25" width="23" class="star rating" data-rating="3">
                                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                                    </svg>
                                                    <svg height="25" width="23" class="star rating" data-rating="4">
                                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                                    </svg>
                                                    <svg height="25" width="23" class="star rating" data-rating="5">
                                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                                    </svg>
                                                </p>
                                                <div class="rating-inputs" style="display: none">
                                                    <input type="radio" name="rating" value="1" checked="checked" />
                                                    <input type="radio" name="rating" value="2" />
                                                    <input type="radio" name="rating" value="3" />
                                                    <input type="radio" name="rating" value="4" />
                                                    <input type="radio" name="rating" value="5" />
                                                </div>
                                                <?= $captcha; ?>
                                                <span class="fb_form_c">
                                            <i class="fab fa-telegram-plane"></i>
                                            <textarea name="text" id="input-review" placeholder="<?= $entry_review ?>" class="leaveComment_textarea" required></textarea>
                                            <div class="help-block"><?= $text_note; ?></div>
                                        </span>
                                                <button type="button" id="button-review" class="leaveComment_button"><?= $button_continue; ?></button>

                                        <?php } else { ?>
                                            <?= $text_login; ?>
                                        <?php } ?>
                                    </form>
                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($products) { ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="novelties recome">
                        <h2 class="novelties_title"><?= $text_related; ?></h2>
                    </div>
                    <div class="regular slider noveltiesSlider itemPageSlider">
                        <?php foreach ($products as $product) { ?>
                            <div>
                                <div class="noveltiesItem">
                                    <a href="<?= $product['href']; ?>" class="itemEnter"> <img src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>"></a>
                                    <div class="noveltiesSlider__caption">
                                        <a href="#" class="product-compare" data-toggle="tooltip" title="<?= $button_compare; ?>"><i class="fas fa-exchange-alt"></i></a>
                                        <a href="#" class="product-wishlist" data-toggle="tooltip" title="<?= $button_wishlist; ?>"><i class="far fa-heart"></i></a>
                                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>" />
                                        <a href="#" class="look" data-toggle="tooltip" title="<?= $button_watch; ?>"><i class="fas fa-eye"></i></a>
                                        <a href="#" data-toggle="tooltip" title="<?= $button_cart; ?>" onclick="cart.add('<?= $product['product_id']; ?>', '<?= $product['minimum']; ?>');" class="noveltiesSlider__buy_now a-cart"><i class="fas fa-shopping-cart"></i></a>

                                        <p class="slideCaption_title">
                                            <span class="slideCaption_title_name"><?= $product['name']; ?></span>
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section>
    <div class="row"><?= $content_bottom; ?></div>
</section>

                                                <!-- Review -->
<script>
    $('#review').load('index.php?route=product/product/review&product_id=<?= $product_id; ?>');

    $('#button-review').on('click', function() {
        $.ajax({
            url: 'index.php?route=product/product/write&product_id=<?= $product_id; ?>',
            type: 'post',
            dataType: 'json',
            data: $("#form-review").serialize(),
            success: function(json) {
                $('.alert-success, .alert-danger, .text-danger.error-review-form').remove();

                if (json['error']) {
                    for (name in json['error']) {
                        if (name === 'review') {
                            $('#input-' + name).after('<span class="text-danger error-review-form error-review"> ' + json['error'][name] + '</span>');
                        } else {
                            $('#input-' + name).before('<span class="text-danger error-review-form"> ' + json['error'][name] + '</span>');
                        }
                    }
                }

                if (json['success']) {
                    showMessage(json['success']);
                    $('input[name=\'name\']').val('');
                    $('input[name=\'email\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
                }
            }
        });
        // grecaptcha.reset();
    });
</script>

<script type="text/javascript"><!--
    $('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
        $.ajax({
            url: 'index.php?route=product/product/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
                $('#recurring-description').html('');
            },
            success: function(json) {
                $('.alert, .text-danger').remove();

                if (json['success']) {
                    $('#recurring-description').html(json['success']);
                }
            }
        });
    });
    //--></script>
                                                                                    <!-- ADD TO CART -->
<script>
    $('#button-cart').on('click', function() {
        var data = {}, size = $('.sizesList.active'), color = $('.select-product-color'), input = $(this).parent().find('input[name=\'quantity\']');
        data['product_id'] = $($(this).parents('.itemPhoto_characteristics_sizes').find('input[name=\'product_id\']')).val();
        data['qty'] = $(input).val();
        if ($(size).data('value') !== undefined) {
            data['size'] = $(size).data('value');
        }
        if ($(color).val() !== '') {
            data['color'] = $(color).val();
        }

        checkIfProductQtyAvailable(input, data, function (success) {
            if (success === true) {
                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: $('#product-form-in-card input[type=\'text\'], #product-form-in-card input[type=\'hidden\'], #product-form-in-card input[type=\'radio\']:checked, #product-form-in-card input[type=\'checkbox\']:checked, #product-form-in-card select, #product-form-in-card textarea'),
                    dataType: 'json',
                    success: function(json) {
                        $('.text-danger').remove();
                        $('.form-group').removeClass('has-error');
                        if (json['error']) {
                            if (json['error']['option']) {
                                for (i in json['error']['option']) {
                                    var product_card_error_class = ' text-danger-product-card';
                                    var element = $('#input-option' + i.replace('_', '-'));
                                    if (element.parent().hasClass('input-group')) {
                                        element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                    } else {
                                        if (element.is('SELECT')) {
                                            product_card_error_class += ' text-danger-select';
                                        }
                                        element.parents('.error-after-me').after('<div class="text-danger' + product_card_error_class + '">' + json['error']['option'][i] + '</div>');
                                    }
                                }
                            }

                            if (json['error']['recurring']) {
                                $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                            }
                        }

                        if (json['success']) {
                            CartObservable.sendMessage(json['success']);
                            $('html, body').animate({ scrollTop: 0 }, 'slow');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        });


    });
</script>

<script type="text/javascript"><!--
    // $('.date').datetimepicker({
    //     pickTime: false
    // });
    //
    // $('.datetime').datetimepicker({
    //     pickDate: true,
    //     pickTime: true
    // });
    //
    // $('.time').datetimepicker({
    //     pickDate: false
    // });

    $('button[id^=\'button-upload\']').on('click', function() {
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if ($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(node).button('loading');
                    },
                    complete: function() {
                        $(node).button('reset');
                    },
                    success: function(json) {
                        $('.text-danger').remove();

                        if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').val(json['code']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    //--></script>
<script type="text/javascript"><!--
    $('#review').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#review').fadeOut('slow');

        $('#review').load(this.href);

        $('#review').fadeIn('slow');
    });

    // $(document).ready(function() {
    //     $('.thumbnails').magnificPopup({
    //         type:'image',
    //         delegate: 'a',
    //         gallery: {
    //             enabled:true
    //         }
    //     });
    // });

    $(document).ready(function() {
        var hash = window.location.hash;
        if (hash) {
            var hashpart = hash.split('#');
            var  vals = hashpart[1].split('-');
            for (i=0; i<vals.length; i++) {
                $('#product').find('select option[value="'+vals[i]+'"]').attr('selected', true).trigger('select');
                $('#product').find('input[type="radio"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
                $('#product').find('input[type="checkbox"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
            }
        }
    })
    //--></script>

<script>
    $(document).ready(function () {
        $(document).on('mouseleave', '.itemPhoto' ,function () {
            $('.magnify-lens').css('display', 'none');
            $("body").css("cursor","default");
        });
    });

    $(document).ready(function() {
        if ($(window).width() > 700) {
            $('.itemPhoto .itemPhoto_img').magnify({
                speed: 200,
                src: $('.itemPhoto a').attr('href')
            });
        }
    });
    $(window).resize(function() {
        if ($(window).width() > 700) {
            $('.itemPhoto .itemPhoto_img').magnify({
                speed: 200,
                src: $('.itemPhoto a').attr('href')
            });
        }
    });
    // $(".itemPhoto a").click(function(){
    //     return false;
    // });

    // $(document).on('click', '.itemImgCover', function() {
    //     var image = $(this).find('img').data('full_image');
    //     var SlideImages = $('.itemPhoto .itemPhoto_img');
    //     $.each(SlideImages, function (index, element) {
    //         if ($(element).attr('src') === image) {
    //             set_img(element, image);
    //         }
    //     });
    //
    // });

    function setAllImgMagnify() {
        var SlideImages = $('.itemPhoto .itemPhoto_img');
        $.each(SlideImages, function (index, element) {
            set_img(element, $(element).attr('src'));
        });
    }

    $(function () {
        setAllImgMagnify();

    });

    function set_img(target, image) {
        $(document).ready(function() {
            if ($(window).width() > 700) {
                $(target).magnify({
                    speed: 200,
                    src: image
                });
            }
        });
        $(window).resize(function() {
            if ($(window).width() > 700) {
                $(target).magnify({
                    speed: 200,
                    src: image
                });
            }
        });
    }

    $(function () {
        var current_url = location.href, anchor_start, anchor;
        if (current_url.indexOf('#') !== -1) {
            anchor_start = current_url.indexOf('#');
            anchor = current_url.substring(anchor_start + 1, current_url.length);
            openBlock(anchor);
            $('.itemTabs_list.active').removeClass('active');
            $('#item-' + anchor).addClass('active');
            $('html, body').animate({ scrollBottom: 25 }, 'slow');
        }
    });
    $(function () {
        $("[data-magnify=gallery]").magnify();
        $("[data-fancybox]").fancybox({
        });
    });
</script>

<?= $footer; ?>
