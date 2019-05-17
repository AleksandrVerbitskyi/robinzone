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
                        <div class="cover_404">
                            <?php if (isset($text_title_404)) { ?>
                                <p class="title_404"><?= $text_title_404; ?></p>
                            <?php } ?>
                            <?php if (isset($text_title_404_description)) { ?>
                                <p class="title_404_description"><?= $text_title_404_description; ?></p>
                            <?php } ?>
                            <p class="pageNotFound"><?= $heading_title; ?></p>
                            <p class="pageNotFound_description"><?= $text_error; ?></p><br/>
                            <?php if (isset($continue)) { ?>
                                <a href="<?= $continue; ?>" class="cover_404_button"><?= $button_continue; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php echo $content_bottom; ?></div>
            <?php echo $column_right; ?></div>
    </div>
</section>
<?php echo $footer; ?>
