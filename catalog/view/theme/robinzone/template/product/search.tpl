<?= $header; ?>
    <section>
        <div class="container">
            <div class="row"><?= $content_top ?></div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="search_title"><?= $heading_title; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="search_direction_title"><?= $entry_search; ?></p>
                    <form class="search_direction_form">
                        <input type="text" name="search" id="input-search" value="<?= $search; ?>" placeholder="<?= $text_keyword; ?>" class="search_direction_input">
                        <select name="category_id" id="direction2">
                            <option value="0"><?= $text_category; ?></option>
                            <?php foreach ($categories as $category_1) { ?>
                                <?php if ($category_1['category_id'] == $category_id) { ?>
                                    <option value="<?= $category_1['category_id']; ?>" selected="selected"><?= $category_1['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?= $category_1['category_id']; ?>"><?= $category_1['name']; ?></option>
                                <?php } ?>
                                <?php foreach ($category_1['children'] as $category_2) { ?>
                                    <?php if ($category_2['category_id'] == $category_id) { ?>
                                        <option value="<?= $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $category_2['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $category_2['name']; ?></option>
                                    <?php } ?>
                                    <?php foreach ($category_2['children'] as $category_3) { ?>
                                        <?php if ($category_3['category_id'] == $category_id) { ?>
                                            <option value="<?= $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $category_3['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $category_3['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <p class="search_direction_check_cover">
                            <?php if ($sub_category) { ?>
                                <input type="checkbox" name="sub_category" id="sub_category" value="1" checked="checked" class="search_direction_check" />
                            <?php } else { ?>
                                <input type="checkbox" name="sub_category" id="sub_category" value="1" class="search_direction_check" />
                            <?php } ?>
                            <label for="sub_category" class="signUp__form_label search_direction_label"><?= $text_sub_category; ?></label>
                        </p>
                        <p class="search_direction_check_cover">
                            <?php if ($description) { ?>
                                <input type="checkbox" name="description" id="description" value="1" checked="checked" class="search_direction_check" />
                            <?php } else { ?>
                                <input type="checkbox" name="description" id="description" value="1" class="search_direction_check" />
                            <?php } ?>
                            <label for="description" class="signUp__form_label search_direction_label"><?= $entry_description; ?></label>
                        </p>
                        <input type="submit" value="<?= $button_search; ?>" id="button-search" class="search_direction_button" />
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="search_products_title"><?= $text_search; ?></p>
                </div>
            </div>
            <?php if ($products) { ?>
                <?php if ($products) { ?>
                    <div class="row">
                        <?php include 'sorting_line_var2.php'; ?>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                            <div class="topPagination">
                                <?= $pagination_top; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row itemBorder search2_cover">
                        <?php foreach ($products as $product) { ?>
                            <?php include 'product_card.tpl'; ?>
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
                <?php } ?>
            <?php } else { ?>
                <div class="reward-content-cover" style="text-align: center; margin-top: 50px;">
                    <p><?= $text_empty; ?></p>
                </div>
            <?php } ?>
            <div class="row"><?= $content_bottom ?></div>
        </div>
    </section>
    <script type="text/javascript"><!--
        $('#button-search').bind('click', function() {
            url = 'index.php?route=product/search';

            var search = $('#content input[name=\'search\']').prop('value');

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            var category_id = $('#content select[name=\'category_id\']').prop('value');

            if (category_id > 0) {
                url += '&category_id=' + encodeURIComponent(category_id);
            }

            var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

            if (sub_category) {
                url += '&sub_category=true';
            }

            var filter_description = $('#content input[name=\'description\']:checked').prop('value');

            if (filter_description) {
                url += '&description=true';
            }

            location = url;
        });

        $('#content input[name=\'search\']').bind('keydown', function(e) {
            if (e.keyCode == 13) {
                $('#button-search').trigger('click');
            }
        });

        $('select[name=\'category_id\']').trigger('change');
        --></script>
<?= $footer; ?>