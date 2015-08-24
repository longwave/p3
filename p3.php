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

update_option('pipdig_p3_version', '1.3.0');

class pipdig_p3_intalled_xyz {
	//constructor for pipdig_p3_intalled_xyz object
	function pipdig_p3_intalled_xyz() {
		register_activation_hook(__FILE__,array(&$this, 'pipdig_p3_activate'));
	}

	function pipdig_p3_activate() {
		
		// trackbacks
		update_option('default_pingback_flag', 0);
		update_option('default_ping_status', 'closed');
		
		// comments notify
		update_option('comments_notify', 0);
		update_option('moderation_notify', 0);
		
		// akismet
		if (get_option('wordpress_api_key') == '') {
			update_option('wordpress_api_key', '1ab26b12c4f1');
			update_option('akismet_discard_month', 'false');
		}
		
		// media sizes
		update_option('medium_size_w', 800);
		update_option('medium_size_h', 0);
		update_option('large_size_w', 1600);
		update_option('large_size_h', 0);
		
		update_option('image_default_size', 'full');
		update_option('image_default_align', 'none');
		
		if (get_option('posts_per_page') == '10') {
			update_option('posts_per_page', 5);
		}
		
		// change default values for https://wordpress.org/plugins/resize-image-after-upload/
		if(get_option('jr_resizeupload_width') == '1200') {
			update_option('jr_resizeupload_width', '1920');
			// change height
			if(get_option('jr_resizeupload_height') == '1200') {
				update_option('jr_resizeupload_height', '0');
			}
			// change quality
			if(get_option('jr_resizeupload_quality') == '90') {
				update_option('jr_resizeupload_quality', '75');
			}
		}
		
	}
}
// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );

// enqueue scripts and styles
function pipdig_p3_scripts_styles($hook) {
	wp_register_script( 'rateyo', plugin_dir_url(__FILE__) . 'assets/js/rateyo.js', array('jquery') );
	wp_register_script( 'imagesloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js', array('jquery'), false );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles' );

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