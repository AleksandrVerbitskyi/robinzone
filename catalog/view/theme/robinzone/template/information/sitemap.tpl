<?= $header; ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= $content_top; ?>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="sitemap_title"><?= $heading_title; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="sitemap_block">
                    <li class="sitemap_list"><a href="<?= $about_page; ?>" class="sitemap_list_a"><?= $text_about; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $link_store; ?>" class="sitemap_list_a"><?= $text_store; ?></a>
                        <ul class="sitemap_subBlock">
                            <?php foreach ($categories as $category_1) { ?>
                                <li class="sitemap_sublist"><a href="<?= $category_1['href']; ?>" class="sitemap_sublist_a"><?= $category_1['name']; ?></a>
                                    <?php if ($category_1['children']) { ?>
                                        <ul class="sitemap_subBlock2">
                                            <?php foreach ($category_1['children'] as $category_2) { ?>
                                                <li class="sitemap_sublist2"><a href="<?= $category_2['href']; ?>" class="sitemap_sublist2_a"><?= $category_2['name']; ?></a></li>
                                                    <?php if ($category_2['children']) { ?>
                                                    <ul class="sitemap_subBlock2">
                                                            <?php foreach ($category_2['children'] as $category_3) { ?>
                                                                <li class="sitemap_sublist2"><a href="<?= $category_3['href']; ?>" class="sitemap_sublist2_a"><?= $category_3['name']; ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <li class="sitemap_list"><a href="<?= $link_opt; ?>" class="sitemap_list_a"><?= $text_opt; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $representatives; ?>" class="sitemap_list_a"><?= $text_representatives; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $contact; ?>" class="sitemap_list_a"><?= $text_contact; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $special; ?>" class="sitemap_list_a"><?= $text_special; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $account; ?>" class="sitemap_list_a"><?= $text_account; ?></a>
                        <ul class="sitemap_subBlock">
                            <li class="sitemap_sublist"><a href="<?= $edit; ?>" class="sitemap_sublist_a"><?= $text_edit; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $password; ?>" class="sitemap_sublist_a"><?= $text_password; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $address; ?>" class="sitemap_sublist_a"><?= $text_address; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $wishlist; ?>" class="sitemap_sublist_a"><?= $text_wishlist; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $history; ?>" class="sitemap_sublist_a"><?= $text_history; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $reward; ?>" class="sitemap_sublist_a"><?= $text_reward; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $return; ?>" class="sitemap_sublist_a"><?= $text_return; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $newsletter; ?>" class="sitemap_sublist_a"><?= $text_newsletter; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $download; ?>" class="sitemap_sublist_a"><?= $text_download; ?></a></li>
                        </ul>
                    </li>
                    <li class="sitemap_list"><a href="<?= $cart; ?>" class="sitemap_list_a"><?= $text_cart; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $search; ?>" class="sitemap_list_a"><?= $text_search; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $compare; ?>" class="sitemap_list_a"><?= $text_compare; ?></a></li>
                    <li class="sitemap_list"><a href="<?= $delivery_page; ?>" class="sitemap_list_a"><?= $text_delivery; ?></a>
                    </li>
                    <li class="sitemap_list"><a href="<?= $link_for_clients; ?>" class="sitemap_list_a"><?= $text_for_clients;?></a>
                        <ul class="sitemap_subBlock">
                            <li class="sitemap_sublist"><a href="<?= $link_sheet; ?>" class="sitemap_list_a"><?= $text_sheet; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $link_sizes_table; ?>" class="sitemap_list_a"><?= $text_sizes_table; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $link_guidance; ?>" class="sitemap_list_a"><?= $text_guidance; ?></a></li>
                            <li class="sitemap_sublist"><a href="<?= $link_quality; ?>" class="sitemap_list_a"><?= $text_quality; ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= $content_bottom; ?>
            </div>
        </div>
    </div>
</section>
<?= $footer; ?>