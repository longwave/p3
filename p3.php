<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://pipdig.co
Description: The core functions and features of any pipdig theme.
Author: pipdig
Author URI: http://pipdig.co
Version: 1.1.0
Text Domain: p3
*/

class pipdig_p3_intalled_xyz {
	// just to check this plugin is active
}


// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );


// load plugin check function, just in case theme hasn't
if ( !function_exists( 'pipdig_plugin_check' ) ) {
	function pipdig_plugin_check( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active($plugin_name) ) {
			return true;
		} else {
			return false;
		}
	}
}

require_once('inc/admin-menu.php');

// functions
//require_once('inc/functions.php');

// hooks
require_once('inc/hooks.php');

// customizer
//require_once('inc/customizer.php');

// cron functions
require_once('inc/cron.php');

//widgets
require_once('inc/widgets/bloglovin.php');
require_once('inc/widgets/socialz.php');
require_once('inc/widgets/pinterest.php');
require_once('inc/widgets/latest-youtube.php');
require_once('inc/widgets/profile.php');
require_once('inc/widgets/facebook.php');
require_once('inc/widgets/instagram.php');
require_once('inc/widgets/clw.php');
require_once('inc/widgets/popular-posts.php');
require_once('inc/widgets/random-posts.php');
if (!pipdig_plugin_check('bloglovin-widget/bloglovin-widget.php')) {
	require_once('inc/widgets/bloglovin.php'); // add widget
}


// updates
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'https://www.dropbox.com/s/uzjjcib0pcjtmgp/p3.json?dl=1',
	__FILE__,
	'p3'
);

?>