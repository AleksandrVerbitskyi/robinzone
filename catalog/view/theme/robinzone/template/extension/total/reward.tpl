<!--<div class="discount_form">-->
<!--    <label class="col-sm-2 control-label" for="input-reward">--><?php //echo $entry_reward; ?><!--</label>-->
    <input type="text" name="reward" value="<?php echo $reward; ?>" placeholder="<?php echo $text_entry_reward; ?>" id="input-reward" class="discount_input" />
    <button class="discount_button reward-button" id="button-reward" data-toggle="tooltip" title="<?php echo $entry_reward; ?>" ><?= $button_reward ?></button>
<!--</div>-->
      <script>
$('#button-reward').on('click', function() {
	$.ajax({
		url: 'index.php?route=extension/total/reward/reward',
		type: 'post',
		data: 'reward=' + encodeURIComponent($('input[name=\'reward\']').val()),
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward').button('loading');
		},
		complete: function() {
			$('#button-reward').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
                showMessage(json['error'], 'warning');
			}

			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});
</script>