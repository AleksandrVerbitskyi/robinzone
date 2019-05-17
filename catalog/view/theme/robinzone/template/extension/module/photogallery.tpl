<div class="aboutUs_slider">
    <div class="row">
        <?php if (isset($banners) && is_array($banners) && isset($rows) && count($rows) >= 3) { ?>
            <?php $row = 0; $image = 0; $image_i = 0; ?>
            <?php foreach ($banners as $banner) { ?>
                <?php if ($image == 0) { ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php } ?>
                        <?php if (((($image + 1) == 1) && $row == 0) || ((($image + 1) == 2) && $row == 2)) { ?>
                            <div class="first_cover">
                        <?php } ?>
                                <div class="img<?= ++$image_i; ?>">
                                    <a data-fancybox="gallery" href="<?= $banner['image'] != '' ? $banner['image'] : ''; ?>" data-width="<?= $banner['width']; ?>" data-height="<?= $banner['height']; ?>" data-caption="<?= $banner['title']; ?>" class="fancy_style">
                                        <img src="<?= $banner['image'] != '' ? $banner['image'] : ''; ?>" alt="<?= $banner['title']; ?>" title="<?= $banner['title']; ?>">
                                    </a>
                                </div>
                        <?php if (($image == 1 && $row == 0) || ($image == 2 && $row == 2)) { ?>
                            </div>
                        <?php } ?>
                <?php $image++; ?>
                <?php if ($image == $rows[$row]) {
                    $image = 0;
                    $row++;
                    echo '</div>';
                } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<p class="morePhotos"><i class="fas fa-sort-down"></i></p>