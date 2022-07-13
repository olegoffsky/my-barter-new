<?php
/*
Plugin Name: OSClass mail
Plugin URI: 
Description: This plugin is aimed to mail all users at once
Version: 1.2.2
Authors: Randy Hough, teseo, Mnu
Author URI: 
Short Name: osclassmail
*/


	// This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'osclassmail_install');

	    function osclassmail_admin_menu() {
			osc_add_admin_submenu_page('plugins', __('OsclassMail', 'osclassmail'), osc_route_admin_url('osclassmail-menu'), 'osclassmail_settings', 'administrator');
        }
     function osclassmail_admin() {
        osc_redirect_to(osc_route_admin_url('osclassmail-menu'));
    }
			osc_add_route('osclassmail-menu', 'osclassmail', 'osclassmail', osc_plugin_folder(__FILE__).'settings.php');
			osc_add_hook('admin_menu_init', 'osclassmail_admin_menu');
    
?>
