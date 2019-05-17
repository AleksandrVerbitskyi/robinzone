<div class="col-lg-10 sort2 sort3">
    <div class="sorting_style">
        <p class="sorting_title"><?= $text_sort; ?></p>
        <div id="sorting">
            <span class="sorting_select"></span>
            <ul>
                <?php foreach ($sorts as $sorts) { ?>
                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                        <li><input type="radio" name="sorting" class="filtration_form_input" data-text="<?= $sorts['text']; ?>"
                                   value="<?= $sorts['href']; ?>" checked="checked"><?= $sorts['text']; ?></li>
                        <script>$(function () {
                                var name = <?= json_encode($sorts['text']); ?>;
                                selectSortType(name);
                            });</script>
                    <?php } else { ?>
                        <li><input type="radio" name="sorting" class="filtration_form_input" data-text="<?= $sorts['text']; ?>"
                                   value="<?= $sorts['href']; ?>"><?= $sorts['text']; ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="sorting_style">
        <p class="showTitle"><?= $text_limit; ?></p>
        <div id="showOnPage">
            <span class="showOnPage_select"></span>
            <ul>
                <?php foreach ($limits as $limits) { ?>
                    <?php if ($limits['value'] == $limit) { ?>
                        <li data-text="<?php echo $limits['text']; ?>"
                            data-value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></li>
                        <script>$(function () {
                                var limit_value = <?= json_encode($limits['text']); ?>;
                                selectCountProductOnPage(limit_value);
                            });</script>
                    <?php } else { ?>
                        <li data-text="<?php echo $limits['text']; ?>"
                            data-value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="sorting_style">
        <p class="compare"><?= $text_compare; ?><span><a href="<?= $compare; ?>"><i class="fas fa-exchange-alt"></i></a></span></p>
    </div>
</div>