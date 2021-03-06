<?= $header; ?><?= $column_left; ?>

<div id="content">

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a target="_blank" href="<?= $synchronize; ?>" data-toggle="tooltip" title="<?= $button_synchronize; ?>" class="btn btn-default" style="background-color: #eec73a;"><i class="fa fa-refresh"></i></a>
                <button type="submit" form="form" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
            <div class="warning"><?= $error_warning; ?></div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?= $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="novaposhta_status"  id="input-status" class="form-control">
                                <?php if ($novaposhta_status) { ?>
                                    <option value="1" selected="selected"><?= $text_enabled; ?></option>
                                    <option value="0"><?= $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?= $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?= $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?= $entry_api_code; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="novaposhta_api_code" placeholder="<?= $entry_api_code; ?>" value="<?= $novaposhta_api_code; ?>" id="input-api-code" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?= $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="novaposhta_sort_order" value="<?= $novaposhta_sort_order; ?>" id="input-sort-order" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $footer; ?>
