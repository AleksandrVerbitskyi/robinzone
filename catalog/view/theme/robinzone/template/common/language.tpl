<?php if (count($languages) > 1) { ?>
<div class="headerCover header__localization">
    <div id="lang-menu">
        <div><?= $current_lang_name; ?></div>
        <ul>
            <?php foreach ($languages as $language) { ?>
            <li class="lang-item" data-name="<?= $language['code']; ?>"><?= $language['name']; ?></li>
            <?php } ?>
        </ul>
        <input type="hidden" id="lang-redirect" value="<?= $redirect; ?>" />
    </div>
</div>
<?php } ?>

<script>
    $(document).on('click', '.lang-item', function () {
        var code = $(this).data('name');
        changeLanguage(code);
    });

    function changeLanguage(code) {
        $.ajax({
            url: '<?= $action; ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                'code' : code,
                'redirect' : $('#lang-redirect').val()
            },
            success: function (data) {
                location.assign(data['redirect']);
            }
        });
    }
</script>
