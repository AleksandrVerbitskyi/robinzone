<?php if ($error_warning) { ?>
    <script>
        $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
    </script>
<?php } ?>
<div class="cover-payment_method-form">
<?php if ($payment_methods) { ?>
    <p class="payment_options"><?php echo $text_payment_method; ?></p>
    <ul class="payment_block">
        <?php foreach ($payment_methods as $payment_method) { ?>
            <?php if (isset($payment_method['image'])) { ?>
                <?php if ($payment_method['code'] == $code || !$code) { ?>
                    <?php $code = $payment_method['code']; ?>
                    <li class="payment_list active">
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" style="display: none;" />
                        <div class="circle_cover">
                            <div class="circle_border">
                                <img src="<?= $payment_method['image']; ?>" alt="<?= $payment_method['title'] ?>" title="<?= $payment_method['title'] ?>" class="options_img liqpay">
                            </div>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="payment_list">
                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" style="display: none;" />
                        <div class="circle_cover">
                            <div class="circle_border">
                                <img src="<?= $payment_method['image']; ?>" alt="<?= $payment_method['title'] ?>" title="<?= $payment_method['title'] ?>" class="options_img liqpay">
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <?php if ($payment_method['code'] == $code || !$code) { ?>
                    <?php $code = $payment_method['code']; ?>
                    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
                <?php } else { ?>
                    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
                <?php } ?>
                <?php echo $payment_method['title']; ?>
                <?php if ($payment_method['terms']) { ?>
                    (<?php echo $payment_method['terms']; ?>)
                <?php } ?>
                <?php if (isset($payment_method['description'])) { ?>
                    <br /><small><?php echo $payment_method['description']; ?></small>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

<div class="comments">
    <span class="comments_number">3</span>
    <span class="comments_title"><?= $text_checkout_comments; ?></span>
    <div class="comments_textarea_cover">
        <i class="far fa-comment"></i>
        <textarea name="comment" placeholder="<?php echo $text_comments; ?>" class="comments_textarea"><?= $comment; ?></textarea>
    </div>
</div>

<?php if ($text_agree) { ?>
    <label class="cart_registration_label"><?= $text_agree; ?>
        <span class="cart_yes">
            <?php if ($agree) { ?>
                <input type="checkbox" name="agree" value="1" checked="checked" class="cart_registration_checkbox" />
            <?php } else { ?>
                <input type="checkbox" name="agree" value="1" class="cart_registration_checkbox" />
            <?php } ?>
        </span></label>
<?php } else { ?>
<!--    <div class="buttons">-->
<!--        <div class="pull-right">-->
<!--            <input type="button" value="--><?php //echo $button_continue; ?><!--" id="button-payment-method" data-loading-text="--><?php //echo $text_loading; ?><!--" class="btn btn-primary" />-->
<!--        </div>-->
<!--    </div>-->
<?php } ?>
</div>