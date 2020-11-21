<div class="form-button-section clearfix">
    <div class="qodef-input-change"><?php esc_html_e('You should save your changes' , 'bazaar') ?></div>
    <div class="qodef-changes-saved"><?php esc_html_e('All your changes are successfully saved' , 'bazaar') ?></div>
    <div class="form-buttom-section-holder" id="anchornav">
        <div class="form-button-section-inner clearfix" >
            <?php if(is_array($page->layout) && count($page->layout)) { ?>
                <div class="qodef-anchors-holder">
                    <span class="qodef-page-anchors-label"><?php esc_html_e('Scroll to:' , 'bazaar') ?></span>
                    <select class="nav-select qodef-selectpicker" data-width="315px" data-hide-disabled="true" data-live-search="true" id="qodef-select-anchor">
                        <option value="" disabled selected></option>
                        <?php foreach ($page->layout as $panel) { ?>
                            <option data-anchor="#qodef_<?php echo esc_attr($panel->name); ?>"><?php echo esc_html($panel->title); ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="qodef-form-save-holder">
                <input type="submit" class="btn btn-primary btn-sm pull-right" value="<?php esc_html_e('Save Changes', 'bazaar'); ?>"/>
            </div>
        </div>
    </div>
</div>