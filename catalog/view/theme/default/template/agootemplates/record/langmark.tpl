<?php if (count($languages) > 1) { ?>
    <div class="headerCover header__localization">
        <div id="lang-menu">
            <div><?= $current_lang_name; ?></div>
            <ul>
                <?php foreach ($languages as $language) { ?>
                    <li class="lang-item" data-name="<?= $language['code']; ?>">
                        <a href="<?php echo $language['url']; ?><?php if ($language['code'] == $code) { echo '#'; }?>"><?= $language['name']; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <input type="hidden" id="lang-redirect" value="<?= $redirect; ?>" />
        </div>
    </div>
<?php } ?>
