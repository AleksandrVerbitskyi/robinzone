        </div>
    </div>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="novelties">
                    <h2 class="novelties_title"><?= $heading_title; ?></h2>
                </div>
                <div class="regular slider articleSlider">
                    <?php foreach ($articles as $article) { ?>
                        <div class="news_container">
                            <div class="news_photoCover" style="max-height: 100%">
                                <a href="<?= $article['url'] ?>">
                                    <img src="<?= $article['image'] ?>" alt="<?= $article['title'] ?>" title="<?= $article['title'] ?>" class="news_photo">
                                </a>
                            </div>
                            <a href='<?= $article['url'] ?>' class="newsTitle" style="margin: 10px"><?= $article['title'] ?></a>
                            <p class="newsDate"><?= $article['published'] ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div id="content" class="col-sm-12">


