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
                        <p class="news_title"> <?= $heading_title; ?> </p>
                    </div>
                </div>
                <div class="row news_borderLine">
                    <?php foreach ($news as $item) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="news_container">
                                <div class="news_photoCover">
                                    <a href="<?= $item['url'] ?>">
                                        <img src="<?= $item['thumb'] ?>" alt="<?= $item['title'] ?>" title="<?= $item['title'] ?>" class="news_photo">
                                    </a>
                                </div>
                                <a href='<?= $item['url'] ?>' class="newsTitle"><?= $item['title'] ?></a>
                                <p class="newsDate"><?= $item['published'] ?></p>
                                <p class="newsDescription"><?= $item['text'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pagination-cover">
                            <div id="pagination">
                                <?= $pagination; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $content_bottom; ?>
            </div>
            <?php echo $column_right; ?></div>
    </div>
</section>
<?php echo $footer; ?>