<ul class="acc_social_block">
    <?php foreach ($social_networks as $index => $social) { ?>
        <li class="acc_social"><a href="<?= $social['url'] ?>" target="_blank">
                <?php if ($social['which_ico'] == 'font') { ?>
                    <i class="<?= $social['font'] ?>"></i>
                <?php } else if ($social['which_ico'] == 'image') { ?>
                    <img width="35px" src="image/<?= $social['image'] ?>" alt="<?= $social['image_alt'] ?>" title="<?= $social['image_title'] ?>" />
                <?php } ?>
            </a></li>
    <?php } ?>
</ul>