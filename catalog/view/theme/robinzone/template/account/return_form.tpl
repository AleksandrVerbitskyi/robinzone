<?php echo $header; ?>
<?php if ($error_warning) { ?>
    <script>
        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
    </script>
<?php } ?>
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
            <div class="row background-height" style="padding-bottom: 10%;">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
                    <?= $column_left ?>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9">
                    <h1 class="download_title"><?= $heading_title; ?></h1>
                    <div style="text-align: center">
                        <p class="return-form-description"><?php echo $text_description; ?></p>
                    </div>
                    <div class="pesonalCabinet_personalDataBlock address-edit-cover add-return-cover">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="pesonalCabinet_personalDataForm return-form">
                            <fieldset class="fieldset-new">
                                <legend><?php echo $text_order; ?></legend>
                                <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i>
                                    <input type="text" name="firstname" autocomplete='given-name' id="input-firstname" value="<?= $firstname; ?>" placeholder="<?= $entry_firstname; ?>" class="personalDataForm_input address-edit-input <?= $error_firstname ? 'has-error' : '' ?>">
                                    <?php if ($error_firstname) { ?>
                                        <span class="text-danger"><?= $error_firstname; ?></span>
                                    <?php } ?>
                                </span>
                                </div>
                                <div class="personalDataForm_cover">
                                <span><i class="far fa-user"></i>
                                    <input type="text" name="lastname" autocomplete='family-name' id="input-lastname" value="<?= $lastname; ?>" placeholder="<?= $entry_lastname; ?>" class="personalDataForm_input address-edit-input <?= $error_lastname ? 'has-error' : '' ?>">
                                    <?php if ($error_lastname) { ?>
                                        <div class="text-danger"><?= $error_lastname; ?></div>
                                    <?php } ?>
                                </span>
                                </div>
                                <div class="personalDataForm_cover">
                                <span><i class="far fa-envelope"></i>
                                    <input type="text" name="email" autocomplete='email' id="input-email" value="<?= $email; ?>" placeholder="<?= $entry_email; ?>" class="personalDataForm_input address-edit-input <?= $error_email ? 'has-error' : '' ?>">
                                    <?php if ($error_email) { ?>
                                        <div class="text-danger"><?= $error_email; ?></div>
                                    <?php } ?>
                                </span>
                                </div>
                                <div class="personalDataForm_cover">
                                <span><i class="fas fa-phone"></i>
                                    <input type="text" name="telephone" autocomplete='tel' id="input-telephone" value="<?= $telephone; ?>" placeholder="<?= $entry_telephone; ?>" class="personalDataForm_input address-edit-input <?= $error_telephone ? 'has-error' : '' ?>">
                                    <?php if ($error_telephone) { ?>
                                        <div class="text-danger"><?= $error_telephone; ?></div>
                                    <?php } ?>
                                </span>
                                </div>
                                <div class="personalDataForm_cover">
                                    <span>
                                    <!--                                <i class="fas fa-phone"></i>-->
                                    <input type="text" name="order_id" id="input-order_id" value="<?= $order_id; ?>" placeholder="<?= $entry_order_id; ?>" class="personalDataForm_input address-edit-input <?= $error_order_id ? 'has-error' : '' ?>">
                                    <?php if ($error_order_id) { ?>
                                        <div class="text-danger"><?= $error_order_id; ?></div>
                                    <?php } ?>
                                    </span>
                                </div>
                            </fieldset>
                            <fieldset class="fieldset-new">
                                <legend><?php echo $text_product; ?></legend>
                                <div class="personalDataForm_cover">
                                    <span>
                                        <input type="text" name="product" id="input-product" value="<?= $product; ?>" placeholder="<?= $entry_product; ?>" class="personalDataForm_input address-edit-input <?= $error_product ? 'has-error' : '' ?>">
                                        <?php if ($error_product) { ?>
                                            <div class="text-danger"><?= $error_product; ?></div>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="personalDataForm_cover">
                                    <span>
                                        <input type="text" name="product" id="input-product" value="<?= $product; ?>" placeholder="<?= $entry_product; ?>" class="personalDataForm_input address-edit-input <?= $error_product ? 'has-error' : '' ?>">
                                        <?php if ($error_product) { ?>
                                            <div class="text-danger"><?= $error_product; ?></div>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="personalDataForm_cover">
                                    <span>
                                        <input type="hidden" name="product_id" value="<?= isset($product_id) ? $product_id : ''; ?>">
                                        <input type="text" name="model" id="input-model" value="<?= $model; ?>" placeholder="<?= $entry_model; ?>" class="personalDataForm_input address-edit-input <?= $error_model ? 'has-error' : '' ?>">
                                        <?php if ($error_model) { ?>
                                            <div class="text-danger"><?= $error_model; ?></div>
                                        <?php } ?>
                                    </span>
                                </div>
                                <div class="personalDataForm_cover">
                                    <span>
                                        <input type="text" name="quantity" id="input-quantity" value="<?= $quantity; ?>" placeholder="<?= $entry_quantity; ?>" class="personalDataForm_input address-edit-input">
                                    </span>
                                </div>
                            </fieldset>
                            <div class="col-lg-12">
                                <fieldset style="margin-top: 35px;">
                                    <div class="form-group new-date-cover">
                                        <div class="input-group date">
                                            <label class="control-label" for="input-date-ordered"><?php echo $entry_date_ordered; ?></label>
                                            <input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" placeholder="<?php echo $entry_date_ordered; ?>" data-date-format="YYYY-MM-DD" id="input-date-ordered" class="form-control date date-input" /><span class="input-group-btn">
<!--                                        <button type="button" class="calendar-btn btn btn-default date-input"><i class="fa fa-calendar"></i></button>-->
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group required new-date-cover">
                                        <label class="col-sm-2 control-label opened"><?php echo $entry_opened; ?></label>
                                        <label class="radio-inline">
                                            <?php if ($opened) { ?>
                                                <input type="radio" name="opened" value="1" checked="checked" class="cart_registration_checkbox" />
                                            <?php } else { ?>
                                                <input type="radio" name="opened" value="1" class="cart_registration_checkbox" />
                                            <?php } ?>
                                            <?php echo $text_yes; ?></label>
                                        <label class="radio-inline">
                                            <?php if (!$opened) { ?>
                                                <input type="radio" name="opened" value="0" checked="checked" class="cart_registration_checkbox" />
                                            <?php } else { ?>
                                                <input type="radio" name="opened" value="0" class="cart_registration_checkbox" />
                                            <?php } ?>
                                            <?php echo $text_no; ?></label>
                                    </div>
                                    <div class="reason-group form-group required">
                                        <label class="control-label"><?php echo $entry_reason; ?></label>
                                        <?php foreach ($return_reasons as $return_reason) { ?>
                                            <?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="cart_registration_checkbox"  name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" checked="checked" />
                                                        <?php echo $return_reason['name']; ?></label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="cart_registration_checkbox"  name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" />
                                                        <?php echo $return_reason['name']; ?></label>
                                                </div>
                                            <?php  } ?>
                                        <?php  } ?>
                                        <?php if ($error_reason) { ?>
                                            <div class="text-danger reason-danger"><?php echo $error_reason; ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment"><?php echo $entry_fault_detail; ?></label>
                                        <textarea name="comment" rows="10" placeholder="<?php echo $entry_fault_detail2; ?>" id="input-comment" class="form-control date-input"><?php echo $comment; ?></textarea>
                                    </div>
                                    <?php echo $captcha; ?>
                                </fieldset>

                                <?php if ($text_agree) { ?>
                                    <div class="buttons clearfix">
                                        <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-danger"><?php echo $button_back; ?></a></div>
                                        <div class="pull-right"><?php echo $text_agree; ?>
                                            <?php if ($agree) { ?>
                                                <input type="checkbox" name="agree" value="1" checked="checked" />
                                            <?php } else { ?>
                                                <input type="checkbox" name="agree" value="1" />
                                            <?php } ?>
                                            <input type="submit" value="<?php echo $button_submit; ?>" class="moveToCatalog" />
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="buttons clearfix">
                                        <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default return-btn"><?php echo $button_back; ?></a></div>
                                        <div class="pull-right">
                                            <input type="submit" value="<?php echo $button_submit; ?>" class="moveToCatalog" />
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </form>
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
<script type="text/javascript"><!--
$('#input-date-ordered').datetimepicker({timepicker: false});
//--></script>
<?php echo $footer; ?>
<script>
    $(function () {
        $("li.cabinet_list a[href='<?= $address_url; ?>']").parent().toggleClass('active');
    });
</script>
