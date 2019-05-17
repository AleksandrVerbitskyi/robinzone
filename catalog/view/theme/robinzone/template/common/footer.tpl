<footer>
    <section>
        <div class="container-fluid subscribeCover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                        <div class="subscribe">
                            <h3 class="subscribe__title"><?= $text_subscribe_title; ?></h3>
                            <p class="subscribe__subTitle"><?= $text_subscribe_sub_title; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                        <form action="#" id="footer-subscribe-form" method="post" enctype="multipart/form-data" class="subscribe__block_form">
                            <input type="email" name="email" autocomplete='email' id="subscribe-email" placeholder="<?= $text_subscribe_email; ?>" class="subscribe_input">
                            <button class="subscribe_button" id="subscribe-button"><?= $text_subscribe_button; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MODAL FORM -->
    <div id="overlay">
        <div id="modal_form">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 in-touch-form">
                    <div class="callbackBlock__form">
                        <span id="modal_close"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <h3 class="modalForm__title"><?= $text_write_us; ?></h3>
                        <p class="modalForm__subTitle"><?= $text_phone_us_full; ?></p>
                        <form action="#" id="footer-send-mail-form" method="post" enctype="multipart/form-data" class="modalForm__form">
                            <input type="text" id="write-us-name" name="name" autocomplete='name'  placeholder="<?= $text_modal_name; ?>" class="modalForm__name" required>
                            <input type="tel" id="write-us-telephone" name="telephone" autocomplete='tel-national'  placeholder="<?= $text_modal_telephone; ?>" class="modalForm__number" required>
                            <input type="email" id="write-us-email" name="email" autocomplete='email'  placeholder="<?= $text_modal_email; ?>" class="modalForm__mail" required>
                            <textarea style="height: auto" rows="5" id="write-us-question" name="question"  placeholder="<?= $text_modal_question; ?>" class="modalForm__mail" required></textarea>
                            <button id="footer-send-mail" class="modalForm__button"><?= $text_modal_button; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL FORM -->
    <div id="overlay2">
        <div id="gratitude_form">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 in-touch-form">
                    <div class="callbackBlock__form">
                        <h3></h3>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FABRICS MODALS -->
    <div id="overlay4">
        <div class="fabric_close_cover">
            <span id="modal_close_fabric"><i class="fa fa-times" aria-hidden="true"></i></span>
            <p class="fabric_close_title"></p>
            <div class="image-cover-fabric"><img src="" alt="" title="" class="fabric_close_img"></div>
            <p class="fabric_close_text"></p>
        </div>
    </div>
    <!-- END OF FABRICS MODALS -->

    <!-- MODAL FORM (FASTORDER) -->
    <div id="overlay3">
        <div class="modal_closeLook">
            <span id="modal_close_closeLook"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                        <div class="itemPhotoSlider_cover">
                            <div class="slider closeLookSlider" id="popup-product-images">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-9 col-sm-9 col-xs-10">
                        <div class="itemPhoto" id="popup-product-image">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 product-form-cover" id="product-form-in-fast-order">
                        <div class="itemPhoto_characteristics">
                            <div class="itemPhoto_characteristics_topBlock">
                                <a href="#" class="itemPhoto_characteristics_title modal_titleHover" id="popup-product-title"></a>
                                <p class="itemPhoto_characteristics_model"><span id="popup-product-text-model"></span> <span id="popup-product-model"></span></p>
                                <span class="item_icons">
                                    <a target="_blank" href="#" id="popup-product-facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="#" id="popup-product-google"><i class="fab fa-google-plus-g"></i></a>
                                    <a href="#" id="popup-product-compare" class="product-compare" data-toggle="tooltip" title=""><i class="fas fa-exchange-alt"></i></a>
                                    <a href="#" id="popup-product-wishlist" class="product-wishlist" data-toggle="tooltip" title=""><i class="far fa-heart"></i></a>
                            </span>
                                <p class="itemPhoto_characteristics_inStock" id="popup-product-instock">
                                </p>
                                <div class="itemPhoto_characteristics_feedback" id="popup-product-feedback-all">
                                    <span class="itemPhoto_characteristics_feedback_cover" id="popup-product-feedback-count"></span>
                                    <p class="stars stars_cover" id="popup-product-feedback-rating" data-stars="1">
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
                            </div>
                            <div class="itemPhoto_characteristics_price" id="popup-product-price">
                            </div>
                            <div class="itemPhoto_characteristics_sizes">
                                <div id="popup-product-options">
                                </div>
                                <a href="#" id="popup-product-sizes-table" class="slideSizes_table"></a>
                                <div class="itemPhoto_characteristics_count">
                                    <form class="cart_item_form" id="popup-product-quantity">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL FORM -->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="top_marker"><i class="fas fa-map-marker-alt"></i></div>
                        <div id="map"></div>

                        <?php if ($link_home !== $current) { ?>
                        <div class="write_block  wow pulse" data-wow-iteration="infinite" id="write_modal">
                            <div class="wrire_blockCover">
                                <p class="write_us"><?= $text_write_us ?></p>
                                <p class="phone_us"><?= $text_phone_us ?></p>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </section>


    <div class="container-fluid footerBackgroundOne">
        <div class="container">
            <div class="row footerPadding">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <p class="contacts__title"><?= $text_contact_title; ?></p>
                    <ul class="contacts__block">
                        <li class="contacts__list"><?= $config_address; ?></li>
                        <li class="contacts__list contact_style"><a href="tel:<?= $telephone; ?>"><?= $telephone; ?></a></li>
                        <li class="contacts__list contact_style"><a class="email-in-footer" href="mailto:<?= $config_email; ?>"><?= $config_email; ?></a></li>
                        <li class="contacts__list contact_style"><a href="/" rel="nofollow"><?= $config_comment; ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <?php if ($informations) { ?>
                    <p class="information"><?= $text_information; ?></p>
                    <ul class="information__block">
                        <?php foreach ($informations as $information) { ?>
                            <li class="information__list"><a class="footer-nav" <?= $current === $information['href'] ? 'rel="nofollow"' : '' ?> href="<?= $information['href']; ?>"><?= $information['title']; ?></a></li>
                        <?php } ?>
                        <li class="information__list"><a class="footer-nav" <?= $current === $link_representation ? 'rel="nofollow"' : '' ?> href="<?= $link_representation; ?>"><?= $text_contact_title; ?></a></li>
                        <li class="information__list"><a class="footer-nav" <?= $current === $link_news ? 'rel="nofollow"' : '' ?> href="<?= $link_news; ?>"><?= $text_news; ?></a></li>
                    </ul>
                    <?php } ?>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <p class="support"><?= $text_support; ?></p>
                    <ul class="support__block">
                        <li class="support__list news-link-hover2"><a class="footer-nav" <?= $current === $articles_page ? 'rel="nofollow"' : '' ?> href="<?= $articles_page; ?>"><?= $text_articles; ?></a></li>
                        <li class="support__list"><a class="footer-nav" <?= $current === $delivery_page ? 'rel="nofollow"' : '' ?> href="<?= $delivery_page; ?>"><?= $text_delivery; ?></a></li>
                        <li class="support__list"><a class="footer-nav" <?= $current === $contact ? 'rel="nofollow"' : '' ?> href="<?= $contact; ?>"><?= $text_contact; ?></a></li>
                        <li class="support__list"><a class="footer-nav" <?= $current === $link_clients ? 'rel="nofollow"' : '' ?> href="<?= $link_clients; ?>"><?= $text_clients; ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <p class="personalCabinet"><?= $text_account; ?></p>
                    <ul class="personalCabinet__block">
                        <li class="personalCabinet__list"><a class="footer-nav" <?= $current === $account ? 'rel="nofollow"' : '' ?> href="<?= $account; ?>"><?= $text_account; ?></a></li>
                        <li class="personalCabinet__list"><a class="footer-nav" <?= $current === $account_info_page ? 'rel="nofollow"' : '' ?> href="<?= $account_info_page; ?>"><?= $text_account_info; ?></a></li>
                        <li class="personalCabinet__list"><a class="footer-nav" <?= $current === $account_address_page ? 'rel="nofollow"' : '' ?> href="<?= $account_address_page; ?>"><?= $text_account_address; ?></a></li>
                        <li class="personalCabinet__list"><a class="footer-nav" <?= $current === $account_reward_page ? 'rel="nofollow"' : '' ?> href="<?= $account_reward_page; ?>"><?= $text_account_reward; ?></a></li>
                        <li class="personalCabinet__list"><a class="footer-nav" <?= $current === $order ? 'rel="nofollow"' : '' ?> href="<?= $order; ?>"><?= $text_order; ?></a></li>

                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <p class="social"> <?= $text_social_networks; ?></p>
                    <?= $social_networks; ?>

                </div>
                <div class="col-lg-12">
                    <p class="accordion"><?= $text_contact_title; ?></p>
                    <div class="panel">
                        <ul class="">
                            <li class=""><?= $config_address; ?></li>
                            <li class=""><a href="tel:<?= $telephone; ?>"><?= $telephone; ?></a></li>
                            <li class=""><a href="mailto:<?= $config_email; ?>"><?= $config_email; ?></a></li>
                            <li class=""><a rel="nofollow" href="/"><?= $config_comment; ?></a></li>
                        </ul>
                    </div>
                    <?php if ($informations) { ?>
                    <p class="accordion"><?= $text_information; ?></p>
                    <div class="panel">
                        <ul class="">
                            <?php foreach ($informations as $information) { ?>
                            <li class=""><a class="footer-nav" <?= $current === $information['href'] ? 'rel="nofollow"' : '' ?> href="<?= $information['href']; ?>"><?= $information['title']; ?></a></li>
                            <?php } ?>
                            <li class=""><a class="footer-nav" <?= $current === $link_representation ? 'rel="nofollow"' : '' ?> href="<?= $link_representation; ?>"><?= $text_representation; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $link_news ? 'rel="nofollow"' : '' ?> href="<?= $link_news; ?>"><?= $text_news; ?></a></li>

                        </ul>
                    </div>
                    <?php } ?>
                    <p class="accordion"><?= $text_support; ?></p>
                    <div class="panel">
                        <ul class="">
                            <li class="news-link-hover2"><a class="footer-nav" <?= $current === $articles_page ? 'rel="nofollow"' : '' ?> href="<?= $articles_page; ?>"><?= $text_articles; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $delivery_page ? 'rel="nofollow"' : '' ?> href="<?= $delivery_page; ?>"><?= $text_delivery; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $contact ? 'rel="nofollow"' : '' ?> href="<?= $contact; ?>"><?= $text_contact; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $link_clients ? 'rel="nofollow"' : '' ?> href="<?= $link_clients; ?>"><?= $text_clients; ?></a></li>
                        </ul>
                    </div>
                    <p class="accordion"><?= $text_account; ?></p>
                    <div class="panel">
                        <ul class="">
                            <li class=""><a class="footer-nav" <?= $current === $account ? 'rel="nofollow"' : '' ?> href="<?= $account; ?>"><?= $text_account; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $account_info_page ? 'rel="nofollow"' : '' ?> href="<?= $account_info_page; ?>"><?= $text_account_info; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $account_address_page ? 'rel="nofollow"' : '' ?> href="<?= $account_address_page; ?>"><?= $text_account_address; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $account_reward_page ? 'rel="nofollow"' : '' ?> href="<?= $account_reward_page; ?>"><?= $text_account_reward; ?></a></li>
                            <li class=""><a class="footer-nav" <?= $current === $order ? 'rel="nofollow"' : '' ?> href="<?= $order; ?>"><?= $text_order; ?></a></li>
                        </ul>
                    </div>
                    <p class="accordion"> <?= $text_social_networks; ?></p>
                    <div class="panel">
                        <?= $social_networks_adaptive; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid footerBackgroundTwo">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="scrollUp">
                        <p onclick="return up()">
                            <i class="fas fa-angle-up"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?php echo $powered; ?>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="payment">
                        <?php if ($payment_list) { ?>
                            <ul class="payment__block">
                                <?php foreach ($payment_list as $key => $item) { ?>
                                    <li class="payment_list"><img src="<?= $item['url']; ?>"
                                                                  alt="<?= $item['alt']; ?>"
                                                                  title="<?= $item['title']; ?>"></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--SCRIPT -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaToMhx8fQewGyukQJx75JijA0zQrUyuQ&callback=initMap">
</script>
<script src="catalog/view/theme/robinzone/js/poper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="catalog/view/theme/robinzone/slick/slick.js"></script>
<script src="catalog/view/theme/robinzone/js/jquery.maskedinput.js"></script>
<script src="catalog/view/theme/robinzone/js/wow.min.js"></script>
<script src="catalog/view/theme/robinzone/js/jquery.fancybox.min.js"></script>
<script src="catalog/view/theme/robinzone/js/jquery.nice-select.js"></script>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/jquery.scrollTo-2.1.2/jquery.scrollTo.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/robinzone/js/main.js"></script>
<script src="catalog/view/theme/robinzone/js/common.js"></script>
<script>
    new WOW().init();
</script>
<script>
    $(function () {
        $(document).on('click', '#footer-send-mail', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?= $contact_action; ?>',
                type: 'post',
                data: $('#footer-send-mail-form').serialize(),
                dataType: 'json',
                success: function (json) {
                    $('.text-danger, .has-error').remove();
                    if (json['errors']) {
                        for (i in json['errors']) {
                            var $element = $('#write-us-' + i);
                            $element.before('<div class="text-danger" style="margin-bottom: -13px"><span class="text-small">' + json['errors'][i] + '</span></div>');
                            if (!$element.hasClass('has-error')) $element.toggleClass('has-error');
                        }
                    }
                    if (json['success']) {
                        window.location.assign(json['redirect']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        $(document).on('click', '#subscribe-button', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?= $subscribe_action; ?>',
                type: 'post',
                data: $('#footer-subscribe-form').serialize(),
                dataType: 'json',
                success: function (json) {
                    $('.has-error').toggleClass('has-error');
                    $('.text-danger').remove();
                    if (json['success']) {
                        window.location.assign(json['redirect']);
                    } else if (json['errors']) {
                        for (i in json['errors']) {
                            var $element = $('#subscribe-' + i);
                            $element.before('<span class="text-danger error-subscribe-form" style="margin-bottom: -13px"><span class="text-small">' + json['errors'][i] + '</span></span>');
                            $element.addClass('has-error');
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
    });

    var addActiveToCurrentInFooter = function () {
        $('.footer-nav').each(function (index, item) {
            if ($(item).attr('href') === '<?= $current ?>') {
                $(item).toggleClass('menu-active');
            }
        });
    };

    $(function () {
        addActiveToCurrentInFooter();
    });
</script>
<!-- END OF SCRIPT -->

</body></html>