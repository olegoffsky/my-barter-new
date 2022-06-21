<?php
/*
Plugin Name: Referral
Plugin URI: http://www.osclass.org/
Description: Referral Plugin encourage the user to share our weblink to increase the site traffic
Version: 1.3
Author: RajaSekar
Author URI: http://www.osclass.org/
Short Name: Referral
*/

    function referral_install() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
        osc_set_preference('num_ref', '1','referral','STRING');
        $path = osc_plugin_resource('referral/struct.sql');
        $sql = file_get_contents($path);
        $conn->osc_dbImportSQL($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
}
   function referral_uninstall() {
        $conn = getConnection() ;
        $conn->osc_dbExec('DROP TABLE %st_referral', DB_TABLE_PREFIX);
        $conn->osc_dbExec('DROP TABLE %st_ref_premium', DB_TABLE_PREFIX);
		 $conn->autocommit(false);
			try {
				osc_delete_preference('num_ref', 'referral');
			}   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);

    }

     function num_ref() {
        return(osc_get_preference('num_ref', 'referral')) ;
    }

    function referral_user_menu() {
        echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'referrals.php') . '" >' . __('Your Referrals', 'referral') . '</a></li>';
    }

    function referral_admin_menu() {
    echo '<h3><a href="#">Referral Scheme</a></h3>
    <ul>
        <li><a href="'.osc_admin_render_plugin_url("referral/admin_menu.php").'?section=types">&raquo; ' . __('User Referrals', 'referral') . '</a></li>
        <li><a href="'.osc_admin_render_plugin_url("referral/settings.php").'?section=types">&raquo; ' . __('Settings', 'referral') . '</a></li>
        <li><a href="'.osc_admin_render_plugin_url("referral/help.php").'?section=types">&raquo; ' . __('F.A.Q. / Help', 'referral') . '</a></li>
    </ul>';
    }

    function referral_form() {
        include_once 'form.php';
    }

    function referral_save($userId){
    $conn = getConnection();
    if(Params::getParam('ref') != ''){
	$ref = Params::getParam('ref');
    }
    if (isset($_COOKIE["Referral"]))
    {
    $userinfo = $conn->osc_dbFetchResults("SELECT * FROM %st_user WHERE pk_i_id  = '%s'", DB_TABLE_PREFIX,$userId);
    $referrerinfo = $conn->osc_dbFetchResults("SELECT * FROM %st_user WHERE pk_i_id  = '%s'", DB_TABLE_PREFIX,$ref);
    $conn->osc_dbExec("INSERT INTO %st_referral(ref_id,ref_ip,ref_name,ref_email,user_id,user_name,user_email,date,time,status) VALUES('%s','%s','%s','%s','%s','%s','%s',CURDATE(),CURTIME(),'Invalid')", DB_TABLE_PREFIX,$ref,$_SERVER['REMOTE_ADDR'],$referrerinfo['0']['s_name'],$referrerinfo['0']['s_email'],$userId,$userinfo['0']['s_name'],$userinfo['0']['s_email'],DB_TABLE_PREFIX,$_SERVER['REMOTE_ADDR']);
    }
    else
    {
    $userinfo = $conn->osc_dbFetchResults("SELECT * FROM %st_user WHERE pk_i_id  = '%s'", DB_TABLE_PREFIX,$userId);
    $referrerinfo = $conn->osc_dbFetchResults("SELECT * FROM %st_user WHERE pk_i_id  = '%s'", DB_TABLE_PREFIX,$ref);
    $conn->osc_dbExec("INSERT INTO %st_referral(ref_id,ref_ip,ref_name,ref_email,user_id,user_name,user_email,date,time,status) SELECT '%s','%s','%s','%s','%s','%s','%s',CURDATE(),CURTIME(),'Invalid' FROM DUAL WHERE EXISTS (SELECT * FROM %st_referral WHERE ref_ip='%s' LIMIT 1)", DB_TABLE_PREFIX,$ref,$_SERVER['REMOTE_ADDR'],$referrerinfo['0']['s_name'],$referrerinfo['0']['s_email'],$userId,$userinfo['0']['s_name'],$userinfo['0']['s_email'],DB_TABLE_PREFIX,$_SERVER['REMOTE_ADDR']);
    $conn->osc_dbExec("INSERT INTO %st_referral(ref_id,ref_ip,ref_name,ref_email,user_id,user_name,user_email,date,time,status) SELECT '%s','%s','%s','%s','%s','%s','%s',CURDATE(),CURTIME(),'Valid' FROM DUAL WHERE NOT EXISTS (SELECT * FROM %st_referral WHERE ref_ip='%s' LIMIT 1)", DB_TABLE_PREFIX,$ref,$_SERVER['REMOTE_ADDR'],$referrerinfo['0']['s_name'],$referrerinfo['0']['s_email'],$userId,$userinfo['0']['s_name'],$userinfo['0']['s_email'],DB_TABLE_PREFIX,$_SERVER['REMOTE_ADDR']);
    $expire=time()+60*60*24*7;
    setcookie("Referral", "Referred", $expire);
    }
    }

    function referral_redirect($item) {
        osc_get_static_page('publish_ok');
        header('Location: ' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'makepremium.php&itemId=' . $item['pk_i_id'])); exit;
    }

    function top_referrals()
    {
    $conn   = getConnection();
     $details = $conn->osc_dbFetchResults("SELECT * , COUNT(status) FROM %st_referral WHERE status = 'Valid' GROUP BY ref_id ORDER BY COUNT(status) DESC LIMIT 5", DB_TABLE_PREFIX);
     ?>
     <div class="box location">
    <h3><strong><?php _e('Top Referrer', 'Referral');?></strong></h3>
    <table class="tstyle">
     <thead>
     <tr>
     <th><?php _e('Name','Referral'); ?></th>
     <th><?php _e('Referrings','Referral'); ?></th>
     </tr>
     </thead>
     <tbody>
      <?php
      foreach($details as $detail)
      {
      echo '<tr>';
      echo '<td>'.$detail['ref_name'].'</td>';
      echo '<td>'.$detail['COUNT(status)'].'</td>';
      echo '</tr>';
      }
      ?>
      </tbody>
      </table>
      </div>
      <?php
    }

     function referral_header() {
       echo '<link rel="stylesheet" href="'. osc_plugin_url('referral/style.css').'style.css" type="text/css" />';
    }
    osc_register_plugin(osc_plugin_path(__FILE__), 'referral_install');
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'referral_uninstall') ;
    osc_add_hook('header', 'referral_header');
    osc_add_hook('user_register_form', 'referral_form');
    osc_add_hook('user_register_completed', 'referral_save');
    osc_add_hook('user_menu', 'referral_user_menu') ;
    osc_add_hook('admin_menu', 'referral_admin_menu');
    osc_add_hook('posted_item', 'referral_redirect');
?>