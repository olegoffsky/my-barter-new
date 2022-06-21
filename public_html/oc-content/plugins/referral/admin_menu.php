<div class="grid-system">
<h2 class="render-title">Geo Data Installer</h2>
<div class="table-contains-actions">
<table cellspacing="0" cellpadding="0" class="table">
<thead>
<tr>
<th><?php _e('User ID','Referral'); ?></th>
<th><?php _e('Name','Referral'); ?></th>
<th><?php _e('Email','Referral'); ?></th>
<th><?php _e('Referrings','Referral'); ?></th>
</tr>
</thead>
<tbody>
<?php
$conn   = getConnection();
$details = $conn->osc_dbFetchResults("SELECT * , COUNT(status) FROM %st_referral WHERE status = 'Valid' GROUP BY ref_id ORDER BY COUNT(status) DESC LIMIT 5", DB_TABLE_PREFIX);
foreach($details as $detail){
?>
<tr>
<td><?php echo $detail['ref_id']; ?></td>
<td><a href="<?php echo osc_user_public_profile_url($detail['ref_id']); ?>" target="_blank"><?php echo $detail['ref_name'];?></a></td>
<td><?php echo $detail['ref_email']; ?></td>
<td><?php echo $detail['COUNT(status)']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>