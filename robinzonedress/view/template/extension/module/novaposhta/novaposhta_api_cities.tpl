<?= $header; ?><?= $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <a target="_blank" href="<?= $synchronize; ?>" data-toggle="tooltip" title="<?= $button_synchronize; ?>" class="btn btn-default" style="background-color: #eec73a;"><i class="fa fa-refresh"></i></a>
                    <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
                </div>
                <h1><?= $heading_title; ?></h1>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <?php if ($error_warning) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <?php if ($success) { ?>
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> <?= $text_list_cities; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left"><?= '№ номер'; $n = $start_n; ?></td>
                                <td class="text-left"><?php if ($sort == 'name') { ?>
                                        <a href="<?= $sort_name; ?>" class="<?= strtolower($order); ?>"><?= $column_city_name; ?></a>
                                    <?php } else { ?>
                                        <a href="<?= $sort_name; ?>"><?= $column_city_name; ?></a>
                                    <?php } ?></td>
                                <td class="text-right"><?= $column_city_type; ?></td>
                                <td class="text-right"><?= $column_city_ref; ?></td>
                                <td class="text-right"><?= $column_city_warehouses; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($cities) { ?>
                                <?php foreach ($cities as $item) { ?>
                                    <tr>

                                        <td class="text-left"><?= $n++; ?></td>
                                        <td class="text-left"><?= $item['name']; ?></td>
                                        <td class="text-left"><?= $item['type']; ?></td>
                                        <td class="text-left"><?= $item['ref']; ?></td>
                                        <td class="text-right"><a href="<?= $item['warehouses']; ?>" data-toggle="tooltip" title="<?= $text_watch_warehouses; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="4"><?= $text_no_results; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 text-left"><?= $pagination; ?></div>
                        <div class="col-sm-6 text-right"><?= $results; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $footer; ?>