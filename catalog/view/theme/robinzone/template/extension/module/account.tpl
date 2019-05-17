<span class="personal_c_mobile"><i class="fas fa-user"></i><span class="personal_c_mobile_text"><?= $heading_title ?></span></span>
<ul class="cabinet_block">
    <?php if (!$logged) { ?>
        <li class="cabinet_list <?= $current_url == $login ? 'active' : ''; ?>"><a href="<?= $login; ?>" class="cabinet_l"><?= $text_login; ?></a></li>
        <li class="cabinet_list <?= $current_url == $register ? 'active' : ''; ?>"><a href="<?= $register; ?>" class="cabinet_l"><?= $text_register; ?></a></li>
        <li class="cabinet_list <?= $current_url == $forgotten ? 'active' : ''; ?>"><a href="<?= $forgotten; ?>" class="cabinet_l"><?= $text_forgotten; ?></a></li>
    <?php } else { ?>
        <li class="cabinet_list <?= $current_url == $account ? 'active' : ''; ?>"><a href="<?= $account; ?>" class="cabinet_l"><?= $text_account; ?></a></li>
        <li class="cabinet_list <?= $current_url == $edit ? 'active' : ''; ?>"><a href="<?= $edit; ?>" class="cabinet_l"><?= $text_edit; ?></a></li>
        <li class="cabinet_list <?= $current_url == $password ? 'active' : ''; ?>"><a href="<?= $password; ?>" class="cabinet_l"><?= $text_password; ?></a></li>
        <li class="cabinet_list <?= $current_url == $address ? 'active' : ''; ?>"><a href="<?= $address; ?>" class="cabinet_l"><?= $text_address; ?></a></li>
        <li class="cabinet_list <?= $current_url == $wishlist ? 'active' : ''; ?>"><a href="<?= $wishlist; ?>" class="cabinet_l"><?= $text_wishlist; ?></a></li>
        <li class="cabinet_list <?= $current_url == $order ? 'active' : ''; ?>"><a href="<?= $order; ?>" class="cabinet_l"><?= $text_order; ?></a></li>
        <li class="cabinet_list <?= $current_url == $download ? 'active' : ''; ?>"><a href="<?= $download; ?>" class="cabinet_l"><?= $text_download; ?></a></li>
<!--        <li class="cabinet_list --><?//= $current_url == $recurring ? 'active' : ''; ?><!--"><a href="--><?//= $recurring; ?><!--" class="cabinet_l">--><?//= $text_recurring; ?><!--</a></li>-->
        <li class="cabinet_list <?= $current_url == $reward ? 'active' : ''; ?>"><a href="<?= $reward; ?>" class="cabinet_l"><?= $text_reward; ?></a></li>
        <li class="cabinet_list <?= $current_url == $return ? 'active' : ''; ?>"><a href="<?= $return; ?>" class="cabinet_l"><?= $text_return; ?></a></li>
<!--        <li class="cabinet_list --><?//= $current_url == $transaction ? 'active' : ''; ?><!--"><a href="--><?//= $transaction; ?><!--" class="cabinet_l">--><?//= $text_transaction; ?><!--</a></li>-->
        <li class="cabinet_list <?= $current_url == $newsletter ? 'active' : ''; ?>"><a href="<?= $newsletter; ?>" class="cabinet_l"><?= $text_newsletter; ?></a></li>

        <li class="cabinet_list">
            <i class="fas fa-sign-out-alt"></i><a href="<?= $logout; ?>" class="cabinet_l"><?= $text_logout; ?></a>
        </li>
    <?php } ?>
</ul>

