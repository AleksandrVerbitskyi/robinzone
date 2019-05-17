<div class="modal-content" id="modal-form-constructor-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $text_seo; ?></h4>
  </div>
  <div class="modal-body">
    <div id="content" class="row" style="padding-bottom: 0;">
      <div class="panel-body" style="padding-top: 0;padding-bottom: 0;">
        <form method="post" enctype="multipart/form-data" id="modal-form" class="form-horizontal">
          <input type="hidden" style="display:none;" name="seo_id" value="<?php echo $seo_id; ?>" />
          <div class="tab-content">
            <!-- TAB General block -->
            <div class="tab-pane fade active in" role="tabpanel" id="modal-general-block">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-status"><?php echo $text_activate_module; ?></label>
                <div class="col-sm-9">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_url; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][seo_url]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_url'] : ''; ?>" class="form-control" />
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-url-<?php echo $language['language_id']; ?>"></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_title; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][seo_title]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_title'] : ''; ?>" class="form-control" />
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-title-<?php echo $language['language_id']; ?>"></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_h1; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="form_description[<?php echo $language['language_id']; ?>][seo_h1]" value="<?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_h1'] : ''; ?>" class="form-control" />
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-h1-<?php echo $language['language_id']; ?>"></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_meta_description; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <textarea name="form_description[<?php echo $language['language_id']; ?>][seo_meta_description]" class="form-control"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_meta_description'] : ''; ?></textarea>
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-meta-description-<?php echo $language['language_id']; ?>"></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_meta_keywords; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <textarea name="form_description[<?php echo $language['language_id']; ?>][seo_meta_keywords]" class="form-control"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_meta_keywords'] : ''; ?></textarea>
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-meta-keywords-<?php echo $language['language_id']; ?>"></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label"><?php echo $text_seo_description; ?></label>
                <div class="col-sm-9">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group" style="margin-bottom: 5px;">
                    <span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <textarea name="form_description[<?php echo $language['language_id']; ?>][seo_description]" id="seo_description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($form_description[$language['language_id']]) ? $form_description[$language['language_id']]['seo_description'] : ''; ?></textarea>
                  </div>
                  <div class="btn-group" style="margin-bottom: 5px;">
                    <button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({id: '#seo_description<?php echo $language['language_id']; ?>'});"><?php echo $text_open_texteditor; ?></button>
                    <button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({id: '#seo_description<?php echo $language['language_id']; ?>', start: false, destroy: true});" style="display: none;"><?php echo $text_save_texteditor; ?></button>
                  </div>
                  <div class="modal-error-block" id="modal-error-form-description-language-seo-description-<?php echo $language['language_id']; ?>" style="margin-bottom: 5px;"></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-info" onclick="submit_seo(this, <?php if ($seo_id) { ?>'edit'<?php } else { ?>'add'<?php } ?>);"><?php echo $button_submit; ?></button>
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" <?php if (!$seo_id) { ?>style="display: none;"<?php } ?>><?php echo $button_close; ?></button>
  </div>
</div>
</div>
