<div class="col-lg-3 col-md-3 col-sm-1 col-xs-1">
    <div class="filtration_icon">
        <i class="fas fa-filter"></i>
        <span class="filtration_mobile_text"><?= $heading_title; ?></span>
    </div>
    <div class="filtration">
        <form class="filtration_form">
<!--            <p class="text-category-in-filter">--><?//= $text_catalog; ?><!--</p>-->
            <?php $one = 1; ?>
            <?php foreach ($filter_groups as $filter_group) { ?>
            <?php if ($one === 1 && ($filter_group['alias'] != 'category' && $filter_group['alias'] != 'sex')) { ?>
<!--                <p class="text-filter-in-filter">--><?//= $heading_title; ?><!--</p>-->
            <?php $one++; } ?>
                <p class="gender_title"><?= $filter_group['name']; ?></p>
                <?php if ($filter_group['alias'] == 'size') { ?>
                    <ul class="sizeOption" id="SizesOptions">
                <?php } else if ($filter_group['alias'] == 'color') { ?>
                        <div class="inputCover option-group" id="filter-group-<?= $filter_group['filter_group_id']; ?>">
                        <?php } else if ($filter_group['alias'] != 'category' && $filter_group['alias'] != 'sex') { ?>
                            <div class="inputCover filter-option-group" id="filter-group-<?= $filter_group['filter_group_id']; ?>">
                            <?php } else { ?>
                            <div class="inputCover" id="filter-group-<?= $filter_group['filter_group_id']; ?>">
                        <?php } ?>
                    <?php if (!$filter_group['isSmartFilter']) { ?>
                        <?php if ($filter_group['alias'] == 'price') { ?>
                            <div class="range-slider" id="facet-price-range-slider">
                                <input name="range-1" value="<?= $minValue ?>" min="<?= $minPrice ?>" max="<?= $maxPrice ?>" step="1" type="range">
                                <input name="range-2" value="<?= $maxValue ?>" min="<?= $minPrice ?>" max="<?= $maxPrice ?>" step="1" type="range">
                            </div>
                        <?php } else { ?>
                            <?php foreach ($filter_group['filter'] as $filter) { ?>
                                <p class="inputMargin">
                                    <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
                                        <input type="checkbox" name="filter[<?=$filter_group['filter_group_id']?>][]" value="<?= $filter['filter_id']; ?>"
                                               id="filter-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_input" checked="checked">
                                    <?php } else { ?>
                                    <input type="checkbox" name="filter[<?=$filter_group['filter_group_id']?>][]" value="<?= $filter['filter_id']; ?>"
                                           id="filter-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_input">
                                    <?php } ?>
                                    <label for="filter-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_label"> <?= $filter['name']; ?></label>
                                </p>
                            <?php } ?>

                            <?php if ($categories) { ?>
                                <!-- Categories (main) start -->
                            <?php if ($filter_group['alias'] == 'sex') { ?>
                                <?php foreach ($categories as $category) { ?>
                                        <p class="inputMargin">
                                            <a href="<?= $category['href']?>">
                                            <?php if ($category['category_id'] == $category_id) { ?>
                                                <input type="checkbox" class="filtration_form_input" checked="checked">
                                            <?php } else { ?>
                                                <input type="checkbox" class="filtration_form_input">
                                            <?php } ?>
                                            <label for="category-<?=$category['category_id']?>" class="filtration_form_label"> <?= $category['name']; ?></label>
                                            </a>
                                        </p>
                                <?php } ?>
                            <?php } ?>
                                <!-- Categories (main) end -->
                                <!-- Categories (sub) start -->
                                <?php if ($filter_group['alias'] == 'category') { ?>
                                    <?php foreach ($categories as $category) { ?>
                                        <?php if ($category['children']) { ?>
                                            <?php foreach ($category['children'] as $child) { ?>
                                                <p class="inputMargin">
                                                    <a href="<?= $child['href']?>">
                                                        <?php if ($child['category_id'] == $child_id) { ?>
                                                            <input type="checkbox" class="filtration_form_input" checked="checked">
                                                        <?php } else { ?>
                                                            <input type="checkbox" class="filtration_form_input">
                                                        <?php } ?>
                                                        <label for="category-<?=$child['category_id']?>" class="filtration_form_label"> <?= $child['name']; ?></label>
                                                    </a>
                                                </p>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                <?php } ?>
                                <!-- Categories (sub) end -->
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($filter_group['alias'] == 'size') { ?>
                            <?php foreach ($filter_group['filter'] as $filter) { ?>
                                <li>
                                    <input type="checkbox" name="filter[<?=$filter_group['filter_group_id']?>][]"
                                           class="filtration_form_input" id="sizeTable-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>"
                                            data-type="size" data-group="<?=$filter_group['filter_group_id']?>"
                                            data-value="<?=$filter['filter_id']?>"
                                    <?= in_array($filter_group['filter_group_id'] . '_' . $filter['filter_id'], $filter_category) ? 'checked="checked"' : '' ?>>
                                    <label for="sizeTable-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_label"> <?= $filter['name']; ?></label>
                                </li>
                            <?php } ?>
                        <?php } else if ($filter_group['alias'] == 'default' || $filter_group['alias'] == 'color') { ?>
                            <?php foreach ($filter_group['filter'] as $filter) { ?>
                                <p class="inputMargin">
                                    <input type="checkbox" name="filter[<?=$filter_group['filter_group_id']?>][]" value="<?= $filter['filter_id']; ?>"
                                           id="filter-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_input"
                                           data-type="default" data-group="<?=$filter_group['filter_group_id']?>"
                                           data-value="<?=$filter['filter_id']?>"
                                        <?= in_array($filter_group['filter_group_id'] . '_' . $filter['filter_id'], $filter_category) ? 'checked="checked"' : '' ?>>
                                    <label for="filter-<?=$filter_group['filter_group_id']?>-<?=$filter['filter_id']?>" class="filtration_form_label"> <?= $filter['name']; ?></label>
                                </p>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php if ($filter_group['alias'] == 'size') { ?>
                    </ul>
                <?php } else { ?>
                    </div>
                <?php } ?>
            <?php } ?>
    <button type="reset" style="margin-top: 10px;" class="filtration_form_button" id="filtration_button"><?= $text_reset_filter; ?></button>
    <input type="submit" name="submit_filter" value="<?= $text_filter_button; ?>" id="button-submit-filter" />
        </form>
    </div>
</div>

<div id="bubble" class="bubble-arrow-left">
    <div class="bubble-content">
        <div class="filter-bubble">
            <a class="link-action" href="#"><?= $text_filter_button; ?></a>
        </div>
    </div>
    <div class="tail1"></div>
    <div class="tail2"></div>
</div>

<style>
    .bubble-arrow-left {
        display: none;
        position: absolute;
        z-index: 100;
        padding: 5px 15px 5px 15px;
        border: 2px solid;
        border-color: #72ce45;
    }
    .bubble-arrow-left .tail1 {
        border-right-color: rgb(247, 218, 196);
    }
</style>

<script>
    var resetFilter = function () {
        location = '<?= $action; ?>';
    };

    $(document).on('click', '.filtration_form_button', function () {
        resetFilter();
    });

    $(document).on('click', '#button-submit-filter', function (e) {
        e.preventDefault();
        var $min = $('input[name=\'range-1\']'), $max = $('input[name=\'range-2\']');
        filterAction([$min.val(), $max.val()]);
    });

    var filterAction = function (prices) {
        filter = [];
        $('input[name^=\'filter\']:checked').each(function(element) {
            if($(this).data('type') === 'size' || $(this).data('type') === 'default') {
                filter.push($(this).data('group') + '_' + $(this).data('value'));
            } else {
                filter.push(this.value);
            }
        });
        location = '<?= $action; ?>&filter=' + filter.join(',') + '&price=' + prices.join(',');
    };

    $(document).on('click', '.bubble-arrow-left a.link-action', function (e) {
        e.preventDefault();
        $('#button-submit-filter').trigger('click');
    });

    $('.filtration_form').mouseleave(function () {
        var $button = $('.bubble-arrow-left');
        $button.hide();
        $button.mouseenter(function () {
            $button.show();
        });
    });

    $(document).on('click', '.option-group .inputMargin, .filter-option-group .inputMargin', function () {
        var $button_block = $('.bubble-arrow-left');
        if ($(this).find('input:checkbox').is(':checked') === true) {
            var position = $(this).position();
            $button_block.css('top', position.top + Math.ceil(parseInt($(this).height())/2));
            $button_block.css('left', position.left + Math.ceil(parseInt($(this).width())/2) + 50);
            $button_block.show();
        } else {
            $button_block.hide();
        }
    });

    $(document).on('click', 'ul.sizeOption li', function () {
        var $button_block = $('.bubble-arrow-left');
        if ($(this).find('input:checkbox').is(':checked') === true) {
            var position = $(this).parent().position();
            $button_block.css('top', position.top + Math.ceil(parseInt($(this).height())/2));
            $button_block.css('left', position.left + parseInt($(this).parent().width()));
            $button_block.show();
        } else {
            $button_block.hide();
        }
    });


</script>
