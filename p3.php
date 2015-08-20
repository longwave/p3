<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://pipdig.co
Description: The core functions and features of any pipdig theme.
Author: pipdig
Author URI: http://pipdig.co
Version: 1.3.0
Text Domain: p3
*/

$theme = wp_get_theme();
if (!strpos($theme, 'pipdig')) {
	return;
}

class pipdig_p3_intalled_xyz {
	// just to check this plugin is active
}

// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );


// functions
require_once('inc/functions.php');

// admin menus
require_once('inc/admin-menus.php');

// cron functions
require_once('inc/cron.php');

// widgets
require_once('inc/widgets.php');

// shortcodes
require_once('inc/shortcodes.php');

// Jetpack stuff
if(class_exists('Jetpack')) {
	require_once('inc/jetpack.php');
}


// updates
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'https://dl.dropboxusercontent.com/u/904435/updates/wordpress/plugins/p3.json',
	__FILE__,
	'p3'
);

?>