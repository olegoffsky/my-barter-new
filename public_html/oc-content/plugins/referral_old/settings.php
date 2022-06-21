<?php
$num_ref = '';
$dao_preference = new Preference();
if(Params::getParam('num_ref') != '') {
$num_ref = Params::getParam('num_ref');
} else {
$num_ref = (num_ref() != '') ? num_ref() : '' ;
}
if( Params::getParam('option') == 'stepone' ) {
$dao_preference->update(array("s_value" => $num_ref), array("s_section" =>"referral", "s_name" => "num_ref"));
osc_add_flash_ok_message(_m('Referral configuration has been changed', 'referral'), 'admin');
}
unset($dao_preference) ;
?>
<div id="content-page" style="padding-bottom: 60px;">
<div class="grid-system">
<div class="grid-row grid-first-row grid-100">
<div class="row-wrapper "><!--los input tienen una class para el tamaño ...-->
<div id="general-settings">
<h2 class="render-title"><?php _e('Referral Settings', 'Referral'); ?></h2>
<ul id="error_list"></ul>
<form method="post" action="<?php osc_admin_base_url(true); ?>" name="media_form">
<input type="hidden" name="page" value="plugins" />
<input type="hidden" name="action" value="renderplugin" />
<input type="hidden" name="file" value="referral/settings.php" />
<input type="hidden" name="option" value="stepone" />
<fieldset>
<div class="form-horizontal">
<div class="form-row">
<div class="form-label"><?php _e('Number of referral needs to make the item as premium listing: ', 'referral'); ?></div>
<div class="form-controls"><input type="text" value="<?php echo $num_ref; ?>" name="num_ref" class="input-medium"></div>
</div>
<div class="clear"></div>
<div class="form-actions">
<input type="submit" class="btn btn-submit" value="Save changes" id="save_changes">
</div>
</div>
</fieldset>
</form>
</div>
</div></div><div class="clear"></div></div><!-- #grid-system -->
</div>