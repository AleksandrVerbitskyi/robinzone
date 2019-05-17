<?php echo $header; ?>
<section>
    <div class="container">
        <div class="row">
            <?= $content_top; ?>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid registration_background">
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
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9 return_blank">
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left" colspan="2"><?php echo $text_return_detail; ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;"><b><?php echo $text_return_id; ?></b> #<?php echo $return_id; ?><br />
                                <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
                            <td class="text-left" style="width: 50%;"><b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
                                <b><?php echo $text_date_ordered; ?></b> <?php echo $date_ordered; ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="stage">
                        <div class="swipe">
                            <i class="fas fa-long-arrow-alt-left"></i>
                            <i class="far fa-hand-point-up"></i>
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                    </div>
                    <h3><?php echo $text_product; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_product; ?></td>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_model; ?></td>
                                <td class="text-right" style="width: 33.3%;"><?php echo $column_quantity; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left"><?php echo $product; ?></td>
                                <td class="text-left"><?php echo $model; ?></td>
                                <td class="text-right"><?php echo $quantity; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="stage">
                            <div class="swipe">
                                <i class="fas fa-long-arrow-alt-left"></i>
                                <i class="far fa-hand-point-up"></i>
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </div>
                        </div>
                    </div>
                    <h3><?php echo $text_reason; ?></h3>
                    <div class="table-responsive">
                        <table class="list table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_reason; ?></td>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_opened; ?></td>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_action; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left"><?php echo $reason; ?></td>
                                <td class="text-left"><?php echo $opened; ?></td>
                                <td class="text-left"><?php echo $action; ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="stage">
                            <div class="swipe">
                                <i class="fas fa-long-arrow-alt-left"></i>
                                <i class="far fa-hand-point-up"></i>
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </div>
                        </div>
                    </div>
                    <?php if ($comment) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-left"><?php echo $text_comment; ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-left"><?php echo $comment; ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="stage">
                                <div class="swipe">
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                    <i class="far fa-hand-point-up"></i>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <h3><?php echo $text_history; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_date_added; ?></td>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_status; ?></td>
                                <td class="text-left" style="width: 33.3%;"><?php echo $column_comment; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($histories) { ?>
                                <?php foreach ($histories as $history) { ?>
                                    <tr>
                                        <td class="text-left"><?php echo $history['date_added']; ?></td>
                                        <td class="text-left"><?php echo $history['status']; ?></td>
                                        <td class="text-left"><?php echo $history['comment']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center"><?php echo $text_no_results; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="stage">
                            <div class="swipe">
                                <i class="fas fa-long-arrow-alt-left"></i>
                                <i class="far fa-hand-point-up"></i>
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </div>
                        </div>
                    </div>
                    <a href="<?= $continue; ?>" class="moveToCatalog"><?= $button_continue; ?></a>
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
<?php echo $footer; ?>
<script>
    $(function () {
        $("li.cabinet_list a[href='<?= $address_url; ?>']").parent().toggleClass('active');
    });
</script>
