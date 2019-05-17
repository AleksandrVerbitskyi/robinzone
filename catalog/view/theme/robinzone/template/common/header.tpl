<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="Cip5KMZVAHRiVh85wHV51jOKGPeKq3LIN9G_YfYxwT0" />
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=utf-8">
    <title><?php echo $title;  ?></title>
    <base href="<?php echo $base; ?>" />
    <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords) { ?>
        <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php } ?>
    <meta property="og:title" content="<?php echo $title; ?>" />
    <?php if ($og_type) { ?>
        <meta property="og:type" content="<?= $og_type; ?>" />
    <?php } else { ?>
        <meta property="og:type" content="website" />
    <?php } ?>
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    <?php if ($og_image) { ?>
        <meta property="og:image" content="<?php echo $og_image; ?>" />
    <?php } else { ?>
        <meta property="og:image" content="<?php echo $logo; ?>" />
    <?php } ?>
    <meta property="og:site_name" content="<?php echo $name; ?>" />
    <!-- CSS -->
<!--    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />-->
    <link rel="shortcut icon" href="catalog/view/theme/robinzone/img/favicon.ico" type="image/x-icon"/>
    <link href="catalog/view/theme/robinzone/css/style.css" rel="stylesheet" media="screen">
    <link href="catalog/view/theme/robinzone/css/style_over.css" rel="stylesheet" media="screen">
    <link href="catalog/view/theme/robinzone/css/style_over_new.css?v=1.0" rel="stylesheet" media="screen">
    <link href="catalog/view/theme/robinzone/css/animate.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/robinzone/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/robinzone/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/robinzone/css/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/robinzone/css/nice-select.css" />
    <?php foreach ($styles as $style) { ?>
        <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
    <!-- END OF CSS -->

    <!-- SCRIPT -->
    <script src="catalog/view/theme/robinzone/js/jquery-3.3.1.js" type="text/javascript"></script>
    <!-- END OF SCRIPT -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <?php foreach ($links as $link) { ?>
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>
    <?php foreach ($scripts as $script) { ?>
        <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>
    <?php foreach ($analytics as $analytic) { ?>
        <?php echo $analytic; ?>
    <?php } ?>
</head>
<body class="<?php echo $class; ?>">
<div class="preloader">
    <div id="hold"></div>
</div>
<header>
    <div class="container-fluid header_background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-9 col-sm-8 col-xs-4">
                    <div class="header__local">
                        <?php echo $currency; ?>
                        <?php echo $language; ?>

                        <div class="header__phone">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo $telephone; ?>" class="header__phone_number"><?php echo $telephone; ?></a>
                        </div>
                        <div class="header__mail">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:<?= $email; ?>" class="header__mail_text"><?= $email; ?></a>
                        </div>
                    </div>
                    <div class="mobile">
                        <p class="mobile-menu-toggle js-toggle-menu hamburger-menu">
                            <span class="menu-item"></span>
                            <span class="menu-item"></span>
                            <span class="menu-item"></span>
                        </p>
                        <nav class="mobile-nav-wrap">
                            <ul class="mobile-header-nav">
                                <li class="navigation__list"><a <?= $current === $home ? 'rel="nofollow"' : '' ?> href="<?= $home; ?>" class="navigation__list_title"><?= $text_home; ?></a></li>
                                <li class="navigation__list"><a <?= $current === $link_about ? 'rel="nofollow"' : '' ?> href="<?= $link_about; ?>" class="navigation__list_title"><?= $text_about; ?></a></li>
                                <li class="navigation__list store-link-hover"><a <?= $current === $link_store ? 'rel="nofollow"' : '' ?> href="<?= $link_store; ?>" class="navigation__list_title"><?= $text_store; ?></a></li>
                                <li class="navigation__list"><a <?= $current === $link_opt ? 'rel="nofollow"' : '' ?> href="<?= $link_opt; ?>" class="navigation__list_title"><?= $text_opt; ?></a></li>
                                <li class="navigation__list"><a <?= $current === $link_representation ? 'rel="nofollow"' : '' ?> href="<?= $link_representation; ?>" class="navigation__list_title"><?= $text_representation; ?></a></li>
                                <li class="navigation__list"><a <?= $current === $link_contact ? 'rel="nofollow"' : '' ?> href="<?= $link_contact; ?>" class="navigation__list_title"><?= $text_contact; ?></a></li>
                                <li class="navigation__list"><a <?= $current === $link_special ? 'rel="nofollow"' : '' ?> href="<?= $link_special; ?>" class="navigation__list_title"><?= $text_sale; ?></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-3 col-xs-3">
                    <div class="headerCover-2">
                        <?php if ($logged) { ?>
                            <div class="personalCabinet__enter">
                                <i class="far fa-user"></i><a href="<?= $login_logup; ?>" class="header__enter_text"><?= $customer_name; ?></a>
                            </div>
                        <?php } else { ?>
                            <div class="personalCabinet__enter">
                                <i class="far fa-user"></i><a href="<?= $login_logup; ?>" class="header__enter_text"><?= $text_login_logup; ?></a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid border_line">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header__logo">
                        <?php if ($logo) { ?>
                            <a href="<?= $home; ?>" <?= $home == $current ? 'rel="nofollow"' : ''?> class="logo"><img src="<?= $logo; ?>" class="header__logoImg" title="<?= $name; ?>" alt="<?= $name; ?>"></a>
                        <?php } ?>
                    </div>
                    <div class="header__phone header__phone_new">
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?php echo $telephone; ?>" class="header__phone_number"><?php echo $telephone; ?></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="header__personalCabinet">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="header__basketSearchCover">
                        <?php echo $search; ?>
                        <?php echo $cart; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav id="menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="naigation" id="selectorScroll">
                        <ul class="navigation__block">
                            <li class="navigation__list"><a <?= $current === $home ? 'rel="nofollow"' : '' ?> href="<?= $home; ?>" class="navigation__list_title"><?= $text_home; ?></a></li>
                            <li class="navigation__list"><a <?= $current === $link_about ? 'rel="nofollow"' : '' ?> href="<?= $link_about; ?>" class="navigation__list_title"><?= $text_about; ?></a></li>
                            <li class="navigation__list store-link-hover"><a <?= (($current === $link_store) || ($isOnProductPage == true)) ? 'rel="nofollow"' : '' ?> href="<?= $link_store; ?>" data-set-active="<?= $isOnProductPage; ?>" class="navigation__list_title"><?= $text_store; ?></a></li>
<!--                            <li class="navigation__list"><a --><?//= $current === $link_opt ? 'rel="nofollow"' : '' ?><!-- href="--><?//= $link_opt; ?><!--" class="navigation__list_title">--><?//= $text_opt; ?><!--</a></li>-->
                            <li class="navigation__list"><a <?= $current === $link_representation ? 'rel="nofollow"' : '' ?> href="<?= $link_representation; ?>" class="navigation__list_title"><?= $text_contact; ?></a></li>
<!--                            <li class="navigation__list"><a --><?//= $current === $link_contact ? 'rel="nofollow"' : '' ?><!-- href="--><?//= $link_contact; ?><!--" class="navigation__list_title">--><?//= $text_contact; ?><!--</a></li>-->
                            <li class="navigation__list"><a <?= $current === $link_special ? 'rel="nofollow"' : '' ?> href="<?= $link_special; ?>" class="navigation__list_title"><?= $text_sale; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<?php if (isset($breadcrumbs) && !empty($breadcrumbs)) { ?>
    <section>
        <div class="container-fluid breadCrumbsBorder">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $breadcrumbs ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<script>
    function showMessage(msg, message_type) {
        var $cover, header, body, message, $form;
        $cover = $('#overlay2');
        if ($.isPlainObject(msg)) {
            message = msg['message'];
        } else {
            message = msg;
        }
        header = $cover.find('h3');
        $form = $(header).parent('.callbackBlock__form');
        body = $cover.find('p');

        if ($form.hasClass('warning_form')) $form.removeClass('warning_form');
        if ($form.hasClass('error_form')) $form.removeClass('error_form');

        if (message_type === undefined || message_type === 'success') {
            $('.overlay2add').remove();
            $(header).before('<i class="fas fa-check overlay2add"></i>');
        } else if (message_type === 'warning') {
            $('.overlay2add').remove();
            $(header).before('<i class="fas fa-exclamation-triangle overlay2add"></i>');
            $form.toggleClass('error_form');
        } else if (message_type === 'error') {
            $('.overlay2add').remove();
            $(header).before('<i class="fas fa-exclamation-circle overlay2add"></i>');
            $form.toggleClass('warning_form');
        }

        $(header).html('');
        $(body).html(message);
        $cover.addClass('is-visible');
        // setTimeout(function () {
        //     $cover.removeClass('is-visible');
        //     $(header).html('');
        //     $(body).html('');
        //     if ($form.hasClass('warning_form')) $form.removeClass('warning_form');
        //     if ($form.hasClass('error_form')) $form.removeClass('error_form');
        //     $('.overlay2add').remove();
        // }, 4000);
        setTimeout(function () {

        }, 3000);
    }

    var addActiveToCurrent = function () {
        $('.navigation__list_title').each(function (index, item) {
            if ($(item).attr('href') === '<?= $current ?>' || $(item).data('set-active') === 1) {
                $(item).toggleClass('menu-active');
            }
        });
    };

    $(function () {
        addActiveToCurrent();
    });
</script>
