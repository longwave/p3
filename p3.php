<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://pipdig.co
Description: The core functions and features of any pipdig theme.
Author: pipdig
Author URI: http://pipdig.co
Version: 1.0.0
Text Domain: pipdig-power-pack
*/

class pipdig_p3_intalled_xyz {
	// just to check this plugin is active
}

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

// functions
//require_once('inc/functions.php');

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
require_once('inc/widgets/popular-posts.php');
require_once('inc/widgets/random-posts.php');
if (!pipdig_plugin_check('bloglovin-widget/bloglovin-widget.php')) {
	require_once('inc/widgets/bloglovin.php'); // add widget
}


// Load text domain for languages
function pipdig_power_pack_textdomain() {
	$domain = 'pipdig-power-pack';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	// wp-content/languages/plugin-name/plugin-name-en_GB.mo
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	// wp-content/plugins/plugin-name/languages/plugin-name-en_GB.mo
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'pipdig_power_pack_textdomain' );

// updates
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'http://zzgr1kfiso2f0i6rz4m.pipdig.co/plugins/pipdig-power-pack.json',
	__FILE__,
	'pipdig-power-pack'
);

?>