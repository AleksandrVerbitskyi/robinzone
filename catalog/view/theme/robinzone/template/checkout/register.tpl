<!-- REGISTER -->
<!--<form class="cover-register-form">-->
    <p class="delivery_options"><?php echo $text_your_details; ?></p>
    <p class="font_cover">
        <i class="far fa-user"></i>
        <input type="text" name="firstname" autocomplete="given-name" value="" placeholder="<?= $entry_firstname; ?>" id="input-payment-firstname" class="signIn__form_input" required>
    </p>
    <p class="font_cover">
        <i class="far fa-user"></i>
        <input type="text" name="lastname" autocomplete="family-name" value="" placeholder="<?= $entry_lastname; ?>" class="signIn__form_input" id="input-payment-lastname" required>
    </p>
    <p class="font_cover">
        <i class="far fa-envelope"></i>
        <input type="email" name="email" autocomplete='email' value="" placeholder="<?= $entry_email; ?>" class="signIn__form_input" id="input-payment-email" required>
    </p>
    <p class="font_cover">
        <i class="fas fa-phone"></i>
        <input type="tel" name="telephone" autocomplete='tel' value="" placeholder="<?= $entry_telephone; ?>" class="signIn__form_input" id="input-payment-telephone" required>
    </p>
<!--    <p class="font_cover">-->
<!--        <i class="fas fa-fax"></i>-->
<!--        <input type="text" name="fax" value="" placeholder="--><?//= $entry_fax; ?><!--" class="signIn__form_input" id="input-payment-fax">-->
<!--    </p>-->

    <p class="delivery_options"><?php echo $text_your_password; ?></p>
    <p class="font_cover">
        <i class="fas fa-key"></i>
        <input type="password" name="password" autocomplete='password' value="" placeholder="<?= $entry_password; ?>" class="signIn__form_input" id="input-payment-password" required>
    </p>
    <p class="font_cover">
        <i class="fas fa-key"></i>
        <input type="password" name="confirm" autocomplete='password' value="" placeholder="<?= $entry_confirm; ?>" class="signIn__form_input" id="input-payment-confirm" required>
    </p>

<!--    <p class="delivery_options">--><?php //echo $text_your_address; ?><!--</p>-->
<!--    <p class="font_cover">-->
<!--        <i class="far fa-building"></i>-->
<!--        <input type="text" name="company" value="" placeholder="--><?//= $entry_company; ?><!--" class="signIn__form_input" id="input-payment-company" required>-->
<!--    </p>-->
<!--    <p class="font_cover">-->
<!--        <i class="fas fa-map-marker-alt"></i>-->
<!--        <input type="text" name="address_1" value="" placeholder="--><?//= $entry_address_1; ?><!--" class="signIn__form_input" id="input-payment-address-1" required>-->
<!--    </p>-->
<!--    <p class="font_cover">-->
<!--        <i class="fas fa-map-marker-alt"></i>-->
<!--        <input type="text" name="address_2" value="" placeholder="--><?//= $entry_address_2; ?><!--" class="signIn__form_input" id="input-payment-address-2" required>-->
<!--    </p>-->
<!--    <p class="font_cover">-->
<!--        <i class="far fa-building"></i>-->
<!--        <input type="text" name="city" value="" placeholder="--><?//= $entry_city; ?><!--" class="signIn__form_input" id="input-payment-city" required>-->
<!--    </p>-->
<!--    <p class="font_cover">-->
<!--        <i class="far fa-envelope"></i>-->
<!--        <input type="text" name="postcode" value="" placeholder="--><?//= $entry_postcode; ?><!--" class="signIn__form_input" id="input-payment-postcode" required>-->
<!--    </p>-->

    <!--<div class="form-group required">-->
    <!--    <label class="control-label" for="input-payment-country">--><?php //echo $entry_country; ?><!--</label>-->
    <!--    <select name="country_id" id="input-payment-country" class="form-control">-->
    <!--        <option value="">--><?php //echo $text_select; ?><!--</option>-->
    <!--        --><?php //foreach ($countries as $country) { ?>
    <!--            --><?php //if ($country['country_id'] == $country_id) { ?>
    <!--                <option value="--><?php //echo $country['country_id']; ?><!--" selected="selected">--><?php //echo $country['name']; ?><!--</option>-->
    <!--            --><?php //} else { ?>
    <!--                <option value="--><?php //echo $country['country_id']; ?><!--">--><?php //echo $country['name']; ?><!--</option>-->
    <!--            --><?php //} ?>
    <!--        --><?php //} ?>
    <!--    </select>-->
    <!--</div>-->
    <!--<div class="form-group required">-->
    <!--    <label class="control-label" for="input-payment-zone">--><?php //echo $entry_zone; ?><!--</label>-->
    <!--    <select name="zone_id" id="input-payment-zone" class="form-control">-->
    <!--    </select>-->
    <!--</div>-->

    <?php echo $captcha; ?>

    <label class="cart_registration_label"><?= $entry_newsletter; ?>
        <span class="cart_yes">
        <input type="checkbox" name="newsletter" value="1" id="newsletter" checked="checked" class="cart_registration_checkbox" />
    </span>
    </label>

<!--    --><?php //if ($shipping_required) { ?>
<!--        <label class="cart_registration_label">--><?//= $entry_shipping; ?>
<!--            <span class="cart_yes">-->
<!--            <input type="checkbox" name="shipping_address" value="1" checked="checked" class="cart_registration_checkbox" />-->
<!--        </span>-->
<!--        </label>-->
<!--    --><?php //} ?>
    <?php if ($text_agree) { ?>
        <label class="cart_registration_label"><?= $text_agree; ?>
            <span class="cart_yes">
            <input type="checkbox" name="agree" value="0" class="cart_registration_checkbox" />
        </span>
        </label>
    <?php } else { ?>
        <!--    <div class="buttons clearfix">-->
        <!--        <div class="pull-right">-->
        <!--            <input type="button" value="--><?php //echo $button_continue; ?><!--" id="button-register" data-loading-text="--><?php //echo $text_loading; ?><!--" class="btn btn-primary" />-->
        <!--        </div>-->
        <!--    </div>-->
    <?php } ?>
<!--</form>-->

<script>
    $(function() {
        $.mask.definitions['~'] = "[+-]";
        $("input[type='tel']").mask("+38 (999) 999-9999");
    });
</script>
