<!-- GUEST -->
<!--<form class="cover-guest-form">-->
<p class="delivery_options"><?php echo $text_your_details; ?></p>
<p class="font_cover">
    <i class="far fa-user"></i>
    <input type="text" name="firstname" autocomplete="given-name" value="" placeholder="<?= $entry_firstname; ?>" id="input-payment-firstname" class="signIn__form_input" required>
</p>
<p class="font_cover">
    <i class="far fa-user"></i>
    <input type="text" name="lastname" autocomplete='family-name' value="" placeholder="<?= $entry_lastname; ?>" class="signIn__form_input" id="input-payment-lastname" required>
</p>
<p class="font_cover">
    <i class="far fa-envelope"></i>
    <input type="email" name="email" autocomplete='email' value="" placeholder="<?= $entry_email; ?>" class="signIn__form_input" id="input-payment-email" required>
</p>
<p class="font_cover">
    <i class="fas fa-phone"></i>
    <input type="tel" name="telephone" autocomplete='tel' value="" placeholder="<?= $entry_telephone; ?>" class="signIn__form_input" id="input-payment-telephone" required>
</p>
<!--<p class="font_cover">-->
<!--    <i class="fas fa-fax"></i>-->
<!--    <input type="text" name="fax" value="" placeholder="--><?//= $entry_fax; ?><!--" class="signIn__form_input" id="input-payment-fax">-->
<!--</p>-->

<!--<p class="delivery_options">--><?php //echo $text_your_address; ?><!--</p>-->
<!--<p class="font_cover">-->
<!--    <i class="far fa-building"></i>-->
<!--    <input type="text" name="company" value="" placeholder="--><?//= $entry_company; ?><!--" class="signIn__form_input" id="input-payment-company" required>-->
<!--</p>-->
<!--<p class="font_cover">-->
<!--    <i class="fas fa-map-marker-alt"></i>-->
<!--    <input type="text" name="address_1" value="" placeholder="--><?//= $entry_address_1; ?><!--" class="signIn__form_input" id="input-payment-address-1" required>-->
<!--</p>-->
<!--<p class="font_cover">-->
<!--    <i class="fas fa-map-marker-alt"></i>-->
<!--    <input type="text" name="address_2" value="" placeholder="--><?//= $entry_address_2; ?><!--" class="signIn__form_input" id="input-payment-address-2" required>-->
<!--</p>-->
<!--<p class="font_cover">-->
<!--    <i class="far fa-building"></i>-->
<!--    <input type="text" name="city" value="" placeholder="--><?//= $entry_city; ?><!--" class="signIn__form_input" id="input-payment-city" required>-->
<!--</p>-->
<!--<p class="font_cover">-->
<!--    <i class="far fa-envelope"></i>-->
<!--    <input type="text" name="postcode" value="" placeholder="--><?//= $entry_postcode; ?><!--" class="signIn__form_input" id="input-payment-postcode" required>-->
<!--</p>-->

<?php echo $captcha; ?>

<?php //if ($shipping_required) { ?>
<!--      <label class="cart_registration_label">--><?//= $entry_shipping; ?>
<!--          <span class="cart_yes">-->
<!--    --><?php //if ($shipping_address) { ?>
<!--            <input type="checkbox" name="shipping_address" value="1" checked="checked" class="cart_registration_checkbox" />-->
<!--    --><?php //} else { ?>
<!--            <input type="checkbox" name="shipping_address" value="1" class="cart_registration_checkbox" />-->
<!--    --><?php //} ?>
<!--          </span>-->
<!--      </label>-->
<?php //} ?>

<!--</form>-->
<script>
    $(function() {
        $.mask.definitions['~'] = "[+-]";
        $("input[type='tel']").mask("+38 (999) 999-9999");
    });
</script>