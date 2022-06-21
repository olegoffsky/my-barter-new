<?php if (osc_is_web_user_logged_in()) {?>
<div class="content user_account">
<h1>
<strong><?php _e('Your Referrals', 'Referral');?></strong>
</h1>
<div id="sidebar">
<?php echo osc_private_user_menu();?>
</div>
<div id="main">
<h3 class="referral">
<?php _e('Refer ' . num_ref() . ' friends to get one premium ads. Send your invite link to your friends using IM, Email, Scraps etc..', 'Referreal') ?></h3>
<br/>
<h3 class="referral"><?php _e('Your Referral Link: ', 'Referreal') ?><?php echo osc_register_account_url() . '?&ref=' . osc_logged_user_id() ?></h3>
<br/>
<table class="tstyle">
<thead>
<tr>
<th><?php _e('User ID', 'Referral');?></th>
<th><?php _e('Name', 'Referral');?></th>
<th><?php _e('Email', 'Referral');?></th>
<th><?php _e('Date', 'Referral');?></th>
<th><?php _e('Time', 'Referral');?></th>
<th><?php _e('Status', 'Referral');?></th>
</tr>
</thead>
<tbody>
  <?php
  $conn = getConnection();
  $details = $conn->osc_dbFetchResults("SELECT * FROM %st_referral WHERE ref_id  = '%s'", DB_TABLE_PREFIX, osc_logged_user_id());
  foreach ($details as $detail) {
    ?>
<tr>
<td><?php echo $detail['user_id'];?></td>
<td><a href="<?php echo osc_user_public_profile_url($detail['user_id']); ?>"><?php echo $detail['user_name'];?></a></td>
<td><?php echo $detail['user_email'];?></td>
<td><?php echo $detail['date'];?></td>
<td><?php echo $detail['time'];?></td>
<td><?php echo $detail['status'];?></td>
</tr>
<?php }?>
</tbody>
</table>
<br>
<table class="tstyle">
<tbody>
<tr>
<?php
$valid = $conn->osc_dbFetchResults("SELECT COUNT(status) FROM %st_referral WHERE ref_id  = '%s' AND status = 'Valid'", DB_TABLE_PREFIX, osc_logged_user_id());
$invalid = $conn->osc_dbFetchResults("SELECT COUNT(status) FROM %st_referral WHERE ref_id  = '%s' AND status = 'Invalid'", DB_TABLE_PREFIX, osc_logged_user_id());
$totalreferral = $conn->osc_dbFetchResults("SELECT COUNT(status) FROM %st_referral WHERE ref_id  = '%s'", DB_TABLE_PREFIX, osc_logged_user_id());
?>
<td><?php _e('Valid Referral: ', 'Referral');echo $valid['0']['COUNT(status)'] ?></td>
<td><?php _e('Invalid Referral: ', 'Referral');echo $invalid['0']['COUNT(status)'] ?></td>
<td><?php _e('Total Referrals: ', 'Referral');echo $totalreferral['0']['COUNT(status)'] ?></td>
</tr>
</tbody>
</table>
<p><?php _e('<br/><font color="red">Note: </font>We are using some technics to find out the invalid referrals.', 'Referral');?></p>
  <?php
  $userID = osc_logged_user_id();
  $user = User :: newInstance()->findByPrimaryKey($userID);
  View :: newInstance()->_exportVariableToView('user', $user);
  $items = Item :: newInstance()->findByUserIDEnabled($user['pk_i_id'], 0, 10);
  View :: newInstance()->_exportVariableToView('items', $items);
  ?>
<br/>
<div class="referral">
<h2><?php _e('Your items to Make Premium', 'Referral');?></h2>
<?php if (osc_count_items() == 0) {?>
<h3><?php _e('You don\'t have any items yet', 'Referral');?></h3>
<?php }else {?>
<table border="0" cellspacing="0">
<tbody>
<?php $class = "even";?>
<?php while (osc_has_items()) {?>
<tr class="<?php echo $class . (osc_item_is_premium() ? " premium" : "");?>">
<?php if (osc_images_enabled_at_items()) {?>
<td class="photo">
<?php if (osc_count_item_resources()) {?>
<a href="<?php echo osc_item_url();?>">
<img src="<?php echo osc_resource_thumbnail_url();?>" width="110" height="90" title="<?php echo osc_item_title();?>" alt="<?php echo osc_item_title();?>" />
</a>
<?php }else {?>
<img src="<?php echo osc_current_web_theme_url('images/no_photo.gif');?>" width="120" height="90" alt="" title="" />
<?php }?>
</td>
<?php }?>
<td class="text">
<?php if (osc_item_is_premium()) {?> <p class="featured"> <?php if (osc_price_enabled_at_items()) {echo "Fearured | " . osc_item_formated_price();}?></p> <?php }else {?> <p class="price"> <?php if (osc_price_enabled_at_items()) {echo osc_item_formated_price();}?></p> <?php }?>
<h3><a href="<?php echo osc_item_url();?>"><?php echo osc_item_title();?></a></h3>
<p><strong><?php _e('Publish date : ', 'classic');?></strong><?php echo osc_format_date(osc_item_pub_date());?></p>
<p><?php if (osc_item_region() != '') {?><strong> <?php _e('Region : ', 'classic');?></strong><?php echo osc_item_region();}if (osc_item_city() != '') {?><strong> <?php _e('City : ', 'classic');?></strong><?php echo osc_item_city();}?> <strong><?php _e(' Total Views: ', 'classic');?></strong><?php echo ItemStats :: newInstance()->getViews(osc_item_id());?></p>
<p><?php echo osc_highlight(strip_tags(osc_item_description()));?></p>
<?php if (!osc_item_is_premium()) {?>
<p class="options">
<strong><a onclick="javascript:return confirm('<?php _e('This action can not be undone. Are you sure you want to continue?', 'Referral');?>')" href="<?php echo osc_render_file_url(osc_plugin_folder(__FILE__) . 'activatepremium.php&itemId=' . osc_item_id()) ?>"><?php _e('Make Premium', 'Referral');?></a></strong>
</p>
<?php }?>
</td>
</tr>
<?php $class = ($class == 'even') ? 'odd' : 'even';?>
<?php }?>
</tbody>
</table>
<br />
<?php }?>
</div>
</div>
</div>
  <?php
}
else {
// HACK TO DO A REDIRECT
  osc_add_flash_error_message(__('Only logged in users are allowed to view referrals.', 'Referral'));
  ?>
<script>location.href="<?php echo osc_user_login_url();?>"</script>
  <?php
}
?>