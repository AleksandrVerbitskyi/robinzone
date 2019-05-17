<?php echo $header; ?>
    <section>
        <div class="container">
            <div class="row"><?php echo $column_left; ?>
                <?php if ($column_left && $column_right) { ?>
                    <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                    <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                    <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p class="news_title"> <?= $news['title']; ?> </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                            <div class="block_newsDetails">
                                <div class="newsDetails_imgCover">
                                    <img src="<?= $news['image'] ?>" class="newsDetails_img" alt="<?= $news['title'] ?>" title="<?= $news['title'] ?>">
                                    <div class="img_content">
                                        <?php if (isset($news['image_title'])) { ?><p class="img_content_title"><?= $news['image_title'] ?></p><?php } ?>
                                        <?php if (isset($news['published'])) { ?><p class="img_content_date"><?= $news['published'] ?></p><?php } ?>
                                    </div>
                                </div>
                                <?php foreach ($news['content'] as $content) { ?>
                                    <?php if ($content['type'] == 'text') { ?>
                                        <div class="newsDetails_text">
                                            <?= $content['value'] ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($content['type'] == 'slider') { ?>
                                        <div class="newsSlider">
                                            <?= $content['value'] ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="newsSocial">
                                        <ul class="newsSocial_block">
<!--                                            <li class="newsSocial_list"><a href="#"><i class="fab fa-odnoklassniki-square"></i></a></li>-->
                                            <li class="newsSocial_list"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $news_url; ?>&title=<?= $title; ?>"><i class="fab fa-facebook-square"></i></a></li>
                                            <li class="newsSocial_list"><a target="_blank" href="https://plus.google.com/share?url=<?= $news_url; ?>"><i class="fab fa-google-plus-square"></i></a></li>
                                            <li class="newsSocial_list"><a target="_blank" href="https://twitter.com/home?status=<?= $title; ?>+<?= $news_url; ?>"><i class="fab fa-twitter-square"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($top5)) { ?>
                            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                                <div class="block_fiveNewsCover">
                                    <p class="fiveNews_title"><?= $text_top5; ?></p>
                                    <ul class="fiveNews_block">
                                        <?php $count = 0; foreach ($top5 as $item) { ?>
                                            <li class="fiveNews_list">
                                                <div class="fiveNews_newsCount"><?= ++$count; ?></div>
                                                <div class="fiveNews_newsDescription_cover">
                                                    <a href="<?= $item['url']; ?>" class="fiveNews_newsDescription"><?= $item['title']; ?></a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <?php echo $content_bottom; ?>
                </div>
                <?php echo $column_right; ?></div>
        </div>
    </section>
<?php echo $footer; ?>

<script>
    $(function () {
        var $news_link_hover = $('.news-link-hover');
        var $news_link = $($news_link_hover.find('a'));
        if (!$news_link.hasClass('menu-active')) $news_link.toggleClass('menu-active');

        $news_link_hover = $('.news-link-hover2');
        $news_link = $($news_link_hover.find('a'));
        if (!$news_link.hasClass('menu-active')) $news_link.toggleClass('menu-active');
    });
</script>
