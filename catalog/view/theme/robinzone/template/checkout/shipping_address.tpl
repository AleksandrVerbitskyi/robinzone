<div class="cover-shipping-address">
    <?php if ($addresses && $logged) { ?>
        <p class="inputMargin">
            <label for="filter-2-5" class="filtration_form_label"><?= $text_address_existing; ?></label>
            <input type="radio" name="shipping_address" value="existing" placeholder="" checked="checked" class="cart_registration_checkbox">
        </p>

        <div id="shipping-existing">
            <select name="address_id">
                <?php foreach ($addresses as $address) { ?>
                    <?php if ($address['address_id'] == $address_id) { ?>
                        <option value="<?= $address['address_id']; ?>" selected="selected"><?= $address['firstname']; ?> <?= $address['lastname']; ?>, <?= $address['address_1']; ?>, <?= $address['city']; ?>, <?= $address['zone']; ?>, <?= $address['country']; ?></option>
                    <?php } else { ?>
                        <option value="<?= $address['address_id']; ?>"><?= $address['firstname']; ?> <?= $address['lastname']; ?>, <?= $address['address_1']; ?>, <?= $address['city']; ?>, <?= $address['zone']; ?>, <?= $address['country']; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <p class="inputMargin">
            <label for="filter-2-5" class="filtration_form_label"><?= $text_address_new; ?></label>
            <input type="radio" name="shipping_address" value="new" placeholder="" class="cart_registration_checkbox">
        </p>
    <?php } ?>

    <div id="shipping-new2" style="display: <?= count($addresses) > 0 ? 'none' : 'block' ?>;">
        <p class="font_cover">
            <i class="far fa-user"></i>
            <input type="text" name="shipping[firstname]" autocomplete="given-name" value="" placeholder="<?= $entry_firstname; ?>" id="input-shipping-firstname" class="signIn__form_input" required>
        </p>
        <p class="font_cover">
            <i class="far fa-user"></i>
            <input type="text" name="shipping[lastname]" autocomplete="family-name" value="" placeholder="<?= $entry_lastname; ?>" class="signIn__form_input" id="input-shipping-lastname" required>
        </p>
    </div>
</div>
