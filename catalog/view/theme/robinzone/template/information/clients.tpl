<?= $header; ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="news_title"> <?= $content_top; ?> </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 clientsBorderStyle">
                <p class="clientsTitle"><?= $heading_title ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="itemTabs_cover clientTabs_cover" id="itemTabs_cover">
                    <ul class="itemTabs_block itemTabs_block2" id="itemTabs_block">
                        <li class="itemTabs_list active" id="item-fabricTypes" id="defaultOpen" onclick="openBlock('fabricTypes', this)"><?= $tab_textile; ?></li>
                        <li class="itemTabs_list" id="item-fabricSizes" onclick="openBlock('fabricSizes', this)"><?= $tab_size; ?></li>
                        <li class="itemTabs_list" id="item-fabricCare" onclick="openBlock('fabricCare', this)"><?= $tab_recommendation; ?></li>
                        <li class="itemTabs_list slideInit" id="item-fabricQuality" onclick="openBlock('fabricQuality', this)"><?= $tab_quality; ?></li>
                    </ul>
                    <div class="itemTabs_content_one itemTabs_content" id="fabricTypes">
                        <div class="fabricTypes">
                            <?php if (isset($textile)) { ?>
                                <?php foreach ($textile as $item) { ?>
                                    <div class="fabricTypes_general">
                                        <div class="fabricTypes_imgCover">
                                            <img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>" title="<?= $item['title'] ?>" class="fabricTypes_img">
                                        </div>
                                        <input class="textile-title" type="hidden" value="<?= $item['title'] ?>"/>
                                        <textarea class="textile-description" style="display: none;"><?= $item['text'] ?></textarea>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="seo-text-description">
                                <?php if (isset($settings['textile_description']) && !empty($settings['textile_description'])) { ?>
                                    <?= $settings['textile_description']; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="itemTabs_content_two itemTabs_content" id="fabricSizes">
                        <div class="fabricSizes">
                            <div class="fabricSizesTable_cover">
                                <table class="fabricSizesTable">
                                    <tr class="fabricSizesTable_caption">
                                        <td><?= $column_age; ?></td>
                                        <td><?= $column_height; ?></td>
                                        <td><?= $column_chest; ?></td>
                                        <td><?= $column_thigh; ?></td>
                                    </tr>
                                    <?php if (isset($sizes)) { ?>
                                        <?php foreach ($sizes as $size) { ?>
                                            <tr>
                                                <td><?= $size['age'] ?></td>
                                                <td><?= $size['height'] ?></td>
                                                <td><?= $size['chest'] ?></td>
                                                <td><?= $size['thigh'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="4"><?= $text_sizes_table_empty; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <div class="seo-text-description">
                                    <?php if (isset($settings['sizes_description']) && !empty($settings['sizes_description'])) { ?>
                                    <?= $settings['sizes_description']; ?>
                                    <?php } ?>
                                </div>
                                <div class="stage">
                                    <div class="swipe">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                        <i class="far fa-hand-point-up"></i>
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="itemTabs_content_two itemTabs_content" id="fabricCare">
                        <div class="fabricCare">
                            <div class="fabricCare_cover">
                                <p class="fabricCare_content"><?php if (isset($care)) echo $care['text'] ?></p>
                                <ul class="fabricCare_block">
                                    <?php if (isset($recommendations)) { ?>
                                        <?php foreach ($recommendations as $recommendation) { ?>
                                            <li class="fabricCare_list">
                                                <img src="<?= $recommendation['image'] ?>" alt="<?= $recommendation['title'] ?>" title="<?= $recommendation['title'] ?>" class="fabricCare_list_img">
                                                <span class="fabricCare_list_content"><?= $recommendation['description'] ?></span>
                                            </li>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <li class="fabricCare_list">
                                            <span class="fabricCare_list_content"><b><?= $text_recommendations_empty; ?></b></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="seo-text-description">
                                    <?php if (isset($settings['recommendation_description']) && !empty($settings['recommendation_description'])) { ?>
                                        <?= $settings['recommendation_description']; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="itemTabs_content_two itemTabs_content" id="fabricQuality">
                        <div class="fabricQuality">
                            <div class="fabricQuality_cover">
                                <div class="fabricQuality_cover_block">
                                    <?php if (isset($qualities) && isset($qualities[0])) { ?>
                                        <p class="fabricQuality_title"><?= $qualities[0]['title'] ?></p>
                                        <div class="fabricQuality_content"><?= $qualities[0]['text'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 sol-xs-12">
                                    <?php if (isset($images)) { ?>
                                    <div class="fabricQuality_slider_blockCover">
                                        <div class="regular slider fabricQuality_slider">
                                            <?php foreach ($images as $image) { ?>
                                                <div>
                                                    <div class="certivicate_cover">
                                                        <img src="<?= $image['image'] ?>" alt="<?= $image['title'] ?>" title="<?= $image['title'] ?>" class="certivicate_img">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 sol-xs-12">
                                    <div class="fabricQuality_cover_block2">
                                        <?php if (isset($qualities) && isset($qualities[1])) { ?>
                                            <p class="fabricQuality_title2"><?= $qualities[1]['title'] ?></p>
                                            <?= $qualities[1]['text'] ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($qualities) && isset($qualities[2])) { ?>
                                <p class="fabricQuality_title"><?= $qualities[2]['title'] ?></p>
                                <?= $qualities[2]['text'] ?>
                            <?php } ?>
                            <div class="seo-text-description">
                                <?php if (isset($settings['quality_description']) && !empty($settings['quality_description'])) { ?>
                                    <?= $settings['quality_description']; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="news_title"> <?= $content_bottom; ?> </p>
            </div>
        </div>
    </div>
</section>
<?= $footer; ?>
<script>
$('.slideInit').on('click', function(){
    $(".fabricQuality_slider").slick({
        dots: true,
        infinite: true,
        arrows:true,
        slidesToShow: 2,
        slidesToScroll: 2,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 550,
                settings: {
                    slidesToShow: 1
                }
            },
        ]
    });

});
    $(function () {
        var current_url = location.href, anchor_start, anchor;
        if (current_url.indexOf('#') !== -1) {
            anchor_start = current_url.indexOf('#');
            anchor = current_url.substring(anchor_start + 1, current_url.length);
            openBlock(anchor);
            $('.itemTabs_list.active').removeClass('active');
            $('#item-' + anchor).addClass('active');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        }
    });
</script>
