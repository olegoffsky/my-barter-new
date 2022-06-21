<?php
if(osc_is_web_user_logged_in() ) {
$item = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId'));
?>
<div class="makepremium">
<h3><?php _e('Premium Listing Offer', 'Referral');?></h3>
<a href="<?php echo osc_render_file_url(osc_plugin_folder(__FILE__) . 'activatepremium.php&itemId='.Params::getParam('itemId')) ?>">Make Premium</a>
</div>
<div class="referral offer">
<table cellspacing="0" border="0">
<tbody>
<tr>
<td class="photo">
<img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" width="120" height="90"  title="" alt="">
</td>
<td class="text">
<?php if (osc_price_enabled_at_items()) { ?><p class="price"><?php if ($item['f_price']="NULL") {  echo "Check with Seller"; } else { echo $item['f_price']; }?></p><?php } ?><h3><a href="http://localhost/index.php?page=item&amp;id=11"><?php echo $item['s_title']; ?></a></h3>
<p><strong>Publish date : </strong><?php echo osc_format_date($item['dt_pub_date']); ?></p>
<p><?php echo $item['s_description']; ?></p>
 <p><?php if ($item['s_region'] != '') { ?><strong> <?php _e('Region : ', 'Referral'); ?></strong><?php echo $item['s_region']; } if ($item['s_city'] != '') { ?><strong> <?php _e('City : ', 'Referral'); ?></strong><?php echo $item['s_city'];  }?></p>
</td>
</tr>
</tbody>
</table>
<br>
</div>
<?php } else { ?>
// HACK TO DO A REDIRECT
<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php osc_add_flash_error_message( __('Only logged in users are allowed.', 'Referral') ) ;
}
?>