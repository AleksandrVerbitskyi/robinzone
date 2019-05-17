        </div>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mainPageSlider">
                    <div class="lazy slider mainSlider" id="slick_slideshow-<?php echo $module; ?>">
                        <?php foreach ($banners as $banner) { ?>
                            <div class="slick-slide slide slide--has-caption">
                                <img src="<?= $banner['image']; ?>" alt="<?= $banner['title']; ?>">
                                <div class="caption">
                                    <?php if ($banner['title']) { ?><p class="slideCaption_title"><?= $banner['title'] ?></p><?php } ?>
                                    <?php if ($banner['button_text'] && $banner['link']) { ?><a href="<?= $banner['link']; ?>" class="slideCaption_button"><?= $banner['button_text'] ?></a><?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div id="content" class="col-sm-12">
<script type="text/javascript"><!--
$(function () {
    $("#slick_slideshow-<?php echo $module; ?>").slick({
        lazyLoad: 'ondemand',
        infinite: true,
        dots: true,
        adaptiveHeight: true,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
    });
});
--></script>