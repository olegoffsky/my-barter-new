<?php
if(osc_is_web_user_logged_in() ) {
$conn   = getConnection();
$valid = $conn->osc_dbFetchResults("SELECT COUNT(status) FROM %st_referral WHERE ref_id  = '%s' AND status = 'Valid'", DB_TABLE_PREFIX,osc_logged_user_id());
$premium = $conn->osc_dbFetchResults("SELECT COUNT(user_id) FROM %st_ref_premium WHERE user_id = '%s'", DB_TABLE_PREFIX,osc_logged_user_id());
if($valid['0']['COUNT(status)']-$premium['0']['COUNT(user_id)']*num_ref()>=num_ref())
{
$id = Params::getParam('itemId');
$conn->osc_dbExec("INSERT INTO %st_ref_premium(user_id,item_id,premium)VALUES('%s','%s','%s')", DB_TABLE_PREFIX,osc_logged_user_id(),$id,1);
$mItems = new ItemActions(true);
$mItems->premium($id); ?>
<script>location.href="<?php echo osc_base_url(); ?>"</script>
<?php osc_add_flash_ok_message( __('Your item has been changed to premium.', 'Referral') ) ;
}
else
{
$remain=num_ref()-($valid['0']['COUNT(status)']-$premium['0']['COUNT(user_id)']*num_ref());?>
<script>location.href="<?php echo osc_base_url(); ?>"</script>
<?php osc_add_flash_error_message( __($remain.' referral needed to make this item as premium listing.', 'Referral') ) ;
}
}
 else { ?>
// HACK TO DO A REDIRECT
<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php osc_add_flash_error_message( __('Only logged in users are allowed.', 'Referral') ) ;
}
?>