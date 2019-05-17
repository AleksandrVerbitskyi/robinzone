<?php if (isset($slider_type)) { ?>
    <?php if ($slider_type == 'photogallery') { ?>
        <p class="aboutUs_rewards_title"><?= $slider_name; ?></p>
        <div class="aboutUs_rewards_sliderCover">
            <div class="regular slider aboutUs_rewards_slider">
                <?php if (isset($banners) && is_array($banners)) { ?>
                    <?php foreach ($banners as $banner) { ?>
                        <div>
                            <div class="aboutUs_rewards_slider_cover">
                                <a data-fancybox="gallery" href="<?= $banner['image'] != '' ? $banner['image'] : 'placeholder.png'; ?>" data-width="900" data-height="1365">
                                    <img src="<?= $banner['image'] != '' ? $banner['image'] : 'placeholder.png'; ?>" alt="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>" title="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>" class="aboutUs_rewards_slider_img">
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } elseif ($slider_type == 'text') { ?>
        <p class="boutUs_ourCompany_title"><?= $slider_name; ?></p>
        <div class="aboutUs_ourCompany_sliderCover">
            <div class="regular slider aboutUs_ourCompany_slider">
                <?php if (isset($banners) && is_array($banners)) { ?>
                    <?php foreach ($banners as $banner) { ?>
                        <div>
                            <div class="aboutUs_ourCompany_slider_cover">
                                <img src="<?= $banner['image'] != '' ? $banner['image'] : 'placeholder.png'; ?>" alt="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>" title="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>" class="aboutUs_ourCompany_slider_img">
                            </div>
                            <div class="aboutUs_rewards_slider_content">
                                <p class="worker_name"><?= $banner['title'] != '' ? $banner['title'] : ''; ?></p>
                                <p class="worker_position"><?= $banner['button_text'] != '' ? $banner['button_text'] : ''; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<script>
    $(function () {
        $(".aboutUs_rewards_slider").not('.slick-initialized').slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows:true,
            prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
            nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 835,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
        $(".aboutUs_ourCompany_slider").not('.slick-initialized').slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows:true,
            prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
            nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 835,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    });
</script>
