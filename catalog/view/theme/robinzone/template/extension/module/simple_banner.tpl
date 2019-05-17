        </div>
    </div>
</div>
<section>
    <div class="container-fluid border_line">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if (isset($banners) && is_array($banners)) { ?>
                        <?php foreach ($banners as $banner) { ?>
                            <a href="<?= $banner['link'] != '' ? $banner['link'] : ''; ?>" class="girls_collection">
                                <img src="<?= $banner['image'] != '' ? $banner['image'] : ''; ?>"
                                     class="girls_collection_img"
                                     alt="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>"
                                     title="<?= $banner['title'] != '' ? $banner['title'] : ''; ?>"></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div id="content" class="col-sm-12">