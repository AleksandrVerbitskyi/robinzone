<div class="cover-shipping-address">
    <div id="shipping-new" style="display: <?= ($addresses ? 'none' : 'block'); ?>;">
        <?php if ($validate_address_for_logged) { ?>
            <input type="hidden" name="validate_address_for_logged" value="true"/>
        <?php } ?>
        <p class="font_cover">
            <i class="far fa-user"></i>
            <input type="text" name="shipping[firstname]" autocomplete="given-name" value="<?= $firstname ?>" placeholder="<?= $entry_firstname; ?>" id="input-shipping_short-firstname" class="signIn__form_input" required>
        </p>
        <p class="font_cover">
            <i class="far fa-user"></i>
            <input type="text" name="shipping[lastname]" autocomplete="family-name" value="<?= $lastname ?>" placeholder="<?= $entry_lastname; ?>" class="signIn__form_input" id="input-shipping_short-lastname" required>
        </p>
        <p class="font_cover">
            <i class="fas fa-map-marker-alt"></i>
            <input type="text" name="shipping[address_1]"  autocomplete="address-level1" value="" placeholder="<?= $entry_address_1; ?>" class="signIn__form_input" id="input-shipping_short-address-1" required>
        </p>
        <p class="font_cover">
            <i class="far fa-building"></i>
            <input type="text" name="shipping[city]" autocomplete="address-level2" value="" placeholder="<?= $entry_city; ?>" class="signIn__form_input" id="input-shipping_short-city" required>
        </p>
    </div>
</div>
