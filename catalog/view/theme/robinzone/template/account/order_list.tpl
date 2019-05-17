<?= $header; ?>
<section>
    <div class="container">
        <div class="row">
            <?= $content_top; ?>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid registration_background registration_background2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="greeting">
                        <img src="catalog/view/theme/robinzone/img/marker.png" class="greeting_img" alt="greeting_img" title="greeting_img">
                        <p class="greeting_title"><?= $text_greeting; ?></p>
                    </div>
                </div>
            </div>
            <div class="row background-height">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
                    <?= $column_left ?>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9">
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <div class="reward-content-cover">
                        <?php if ($orders) { ?>
                            <div class="table_cover">
                                <table class="history_table">
                                    <tr class="history_table__topRow">
                                        <th><?= $column_date_added; ?></th>
                                        <th><?= $column_customer; ?></th>
                                        <th><?= $column_product; ?></th>
                                        <th><?= $column_status; ?></th>
                                        <th><?= $column_total; ?></th>
                                        <th></th>
                                    </tr>
                                    <?php foreach ($orders as $order) { ?>
                                        <tr class="history_table__itemOrder">
                                            <td>
                                                <div class="date_cover">
                                                    <p class="history_table__order_date"><?= $order['date_added']; ?></p>
                                                    <p class="history_table__order_number"><?= $text_order; ?> <span>№<?= $order['order_id']; ?></span></p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="history_table_canceled"><?= $order['name']; ?></p>
                                            </td>
                                            <td>
                                                <p class="history_table_canceled"><?= $order['products']; ?></p>
                                            </td>
                                            <td>
                                                <p class="history_table_canceled"><?= $order['status']; ?></p>
                                            </td>
                                            <td>
                                                <p class="history_table_itemPrice"><?= $order['total']; ?></p>
                                            </td>
                                            <td>
                                                <div class="history_table__order_details">
                                                    <a href="<?= $order['view']; ?>" class="history_table_itemName"><i class="fas fa-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <div class="stage">
                                    <div class="swipe">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                        <i class="far fa-hand-point-up"></i>
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="text-center">
                                <p><?= $text_empty; ?></p>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="pagination-cover">
                                    <div id="pagination">
                                        <?= $pagination; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= $continue; ?>" style="width: 280px;" class="moveToCatalog"><?= $button_continue; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <?= $content_bottom; ?>
        </div>
    </div>
</section>
<?= $footer; ?>
