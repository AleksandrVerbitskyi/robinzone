function addSocialNetwork(data) {
    html  = '<tr id="social-network-row-' + data['soc_net_row'] + '">';
    html += '  <td class="text-left"><a href="" id="thumb-image-' + data['soc_net_row']  + '" data-toggle="image" class="img-thumbnail">';
    html += '<img src="' + data['thumb']  + '" alt="" title="" data-placeholder="' + data['placeholder']  + '" /></a>';
    html += '  <input type="hidden" name="soc_net_rows[' + data['soc_net_row']  + '][image]" value="' + data['image'] + '" id="input-image-' + data['soc_net_row']  + '" />';
    html += '  <?php if ($error["soc_net_rows"][' + data['soc_net_row'] + ']["error_image"]) { ?>';
    html += '  <div class="text-danger"><?= $error["soc_net_rows"][' + data['soc_net_row'] + ']["error_image"]; ?></div>';
    html += ' <?php } ?></td>';
    html += '<td class="text-left">';
    html += ' <input type="text" name="soc_net_rows[' + data['soc_net_row']  + '][font]" value="" placeholder="' + data['entry_font'] + '" id="input-font-' + data['soc_net_row'] + '" class="form-control" />';
    html += ' <?php if ($error[\'soc_net_rows\'][$social_network_row][\'error_font\']) { ?>\n' +
        '                                            <div class="text-danger"><?= $error[\'soc_net_rows\'][$social_network_row][\'error_font\']; ?></div>\n' +
        '                                        <?php } ?></td>\n';
    html += '<td class="text-left"><input type="text" name="soc_net_rows[' + data['soc_net_row']  + '][url]" value="" placeholder="' + data['entry_url'] + '" id="input-url-' + data['soc_net_row'] + '" class="form-control" />';
    html += ' <?php if ($error[\'soc_net_rows\'][$social_network_row][\'error_url\']) { ?>\n' +
        '                                            <div class="text-danger"><?= $error[\'soc_net_rows\'][$social_network_row][\'error_url\']; ?></div>\n' +
        '                                        <?php } ?></td>\n';
    html += '<td class="text-left"><input type="text" name="soc_net_rows[' + data['soc_net_row'] + '][sort]" value="0" placeholder="' + data['entry_sort'] + '" id="input-sort-' + data['soc_net_row'] + '" class="form-control" />';
    html += ' <?php if ($error[\'soc_net_rows\'][$social_network_row][\'error_sort\']) { ?>\n' +
        '                                            <div class="text-danger"><?= $error[\'soc_net_rows\'][$social_network_row][\'error_sort\']; ?></div>\n' +
        '                                        <?php } ?></td>\n';
    html += '<td class="text-left">';
    html += '<select name="soc_net_rows[' + data['soc_net_row'] + '][status]" id="input-status" class="form-control">';
    html += '<option value="0" selected="selected">' + data['entry_status_off'] + '</option>\n' +
            '<option value="1">' + data['entry_status_on'] + '</option>';
    html += '</select></td>';

    html += '<td class="text-left">';
    html += '<select name="soc_net_rows[' + data['soc_net_row'] + '][which_ico]" id="input-which_ico" class="form-control">';
    html += '<option value="image" selected="selected">' + data['entry_which_image'] + '</option>\n' +
        '<option value="font">' + data['entry_which_font'] + '</option>';
    html += '</select></td>';

    html += '<td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#social-network-row-' + data['soc_net_row'] + '\').remove();" data-toggle="tooltip" title="' + data['button_remove'] + '" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
    html += '</td>';
    html += '</tr>';

    $('#table-social tbody').append(html);
    $('[rel=tooltip]').tooltip();

    data['soc_net_row'] += 1;
}
