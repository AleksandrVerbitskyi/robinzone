  <?php if ($error_warning) { ?>
      <script>
          $(function(){ showMessage('<?= $error_warning; ?>', 'warning') });
      </script>
  <?php } ?>
  <?php if (isset($oplata_error)) { ?>
      <script>
          $(function(){ showMessage('<?= $oplata_error; ?>', 'warning') });
      </script>
  <?php } ?>
        <div class="content-top"><?= $content_top; ?></div>
        <form action="index.php?route=checkout/confirm" method="post" class="all-data-form" enctype="multipart/form-data">
            <div class="contacts">
                <span class="contacts_number">1</span>
                <span class="contacts_title"><?= $text_checkout_option; ?></span>
                <?php if (!$logged && $account != 'guest') { ?>
                    <a href="<?= $login; ?>" class="contacts_enter"><?= $text_login; ?></a>
                <?php } else { ?>

                <?php } ?>
                <div class="cart_registration">
                    <div class="cart_registration_form">
                        <?php if (!$logged) { ?>
                        <label class="cart_registration_label"><?= $text_register; ?></label>
                        <?php if ($checkout_guest) { ?>
                            <span class="cart_yes">
                                <?php if ($account == 'guest') { ?>
                                    <input type="radio" name="account" value="guest" checked="checked" class="cart_registration_checkbox" />
                                <?php } else { ?>
                                    <input type="radio" name="account" value="guest" class="cart_registration_checkbox" />
                                <?php } ?><span class="yes"><?= $text_no; ?></span>
                            </span>
                        <?php } ?>
                        <span class="cart_no">
                            <?php if ($account == 'register') { ?>
                                <input type="radio" name="account" value="register" checked="checked" class="cart_registration_checkbox" />
                            <?php } else { ?>
                                <input type="radio" name="account" value="register" class="cart_registration_checkbox" />
                            <?php } ?><span class="yes"><?= $text_yes; ?></span>
                        </span>
                        <?php } elseif ($logged) { ?>
                            <div class="shipping-address-cover" style="display: block;">
                                <?php if ($add_address_for_logged !== false) { ?>
                                    <?= $add_address_for_logged ?>
                                <?php } else { ?>
                                    <?= $column_shipping_address; ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if (!$logged) { ?>
                            <div class="account-cover">
                                <?php if ($account == 'register') { ?>
                                    <?= $column_register; ?>
                                <?php } elseif ($account == 'guest') { ?>
                                    <?= $column_guest; ?>
                                <?php } ?>
                            </div>
                        <?php } ?>

<!--                        --><?php //if ($shipping_required && !$logged) { ?>
<!--                            <div class="shipping-address-cover" style="display: none;">-->
<!--                                <p class="delivery_options">--><?php //echo $text_address_new; ?><!--</p>-->
<!--                                --><?//= $column_shipping_address; ?>
<!--                            </div>-->
<!--                        --><?php //} ?>
                    </div>
                </div>
            </div>

            <div class="delivery">
                <span class="delivery_number">2</span>
                <span class="delivery_title"><?= $text_checkout_shipping_payment; ?></span>
            </div>
            <?php if ($shipping_required) { ?>
                <?= $column_shipping_method; ?>
            <?php } ?>

            <?= $column_payment_method; ?>
            <button type="submit" class="submit-all-data-form" style="display: none"></button>
        </form>

<div class="content-bottom"><?= $content_bottom; ?></div>

<script>
  $(function() {
      let showShippingAddress = $('input:checkbox[name=\'shipping_address\']').prop('checked');
      let $account = $('input:radio:checked[name=\'account\']');
      if (showShippingAddress) {
          $('#shipping-new, #shipping-new2').hide();
      }
      loadRegisterGuestViews();
      selectNewOrExistingAddress();
  });
  $(document).on('change', 'input:checkbox[name=\'shipping_address\']', function() {
      if ($(this).prop('checked')) {
          $('#shipping-new, #shipping-new2').hide();
      } else {
          $('#shipping-new, #shipping-new2').show();
      }
  });
  $(document).on('change', 'input:radio[name=\'shipping_address\']', function() {
      selectNewOrExistingAddress();
  });

  $(document).on('change', 'input:radio[name=\'account\']', function() {
      loadRegisterGuestViews();
  });

  function loadRegisterGuestViews(view = null) {
      var account = $('input[name=\'account\']:checked').val();
      if (account === undefined) return false;
      if (view !== null) account = view;
      $.ajax({
          url: 'index.php?route=checkout/' + account,
          dataType: 'html',
          success: function (html) {
              var new_account = $('input[name=\'account\']:checked').val();
              // $('.alert, .text-danger').remove();
              $('.account-cover').html(html);
              refreshShippingAddressBlock();
              selectNewOrExistingAddress();
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
      });
  }

  function refreshShippingAddressBlock() {
      let showShippingAddress = $('input:checkbox[name=\'shipping_address\']').prop('checked');
      if (!showShippingAddress) {
          $('.shipping-address-cover').css('display', 'block');
          $('#shipping-new, #shipping-new2').show();
      } else {
          $('.shipping-address-cover').css('display', 'none');
          $('#shipping-new, #shipping-new2').hide();
      }
  }

  function selectNewOrExistingAddress () {
      let element = $('input:radio:checked[name=\'shipping_address\']');
      if ($(element).val() === 'new') {
          $('#shipping-existing').hide();
          $('#shipping-new, #shipping-new2').show();
      } else if ($(element).val() === 'existing') {
          $('#shipping-new, #shipping-new2').hide();
          $('#shipping-existing').show();
      }
  }
</script>