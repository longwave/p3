<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://pipdig.co
Description: The core functions of any pipdig theme. Note: will only work when using a pipdig theme.
Author: pipdig
Author URI: http://pipdig.co
Version: 1.6.6
Text Domain: p3
*/


$theme = wp_get_theme();
if (!strpos($theme, 'pipdig')) {
	return;
}


if ( false === ( $value = get_transient('pipdig_shaq_fu') ) ) {
	set_transient('pipdig_shaq_fu', true, 1 * WEEK_IN_SECONDS);
}
/*
if ( false === ( $value = get_transient('pipdig_shaq_fu') ) ) {
	return;
}
*/
update_option('pipdig_p3_version', '1.6.6');

		// ========= remove this on 1st March 2016
		if (get_option('p3_social_transfer') != 1) {
			
			$links = get_option('pipdig_links');
			
			$socialz_twitter = get_theme_mod('socialz_twitter');
			$socialz_instagram = get_theme_mod('socialz_instagram');
			$socialz_facebook = get_theme_mod('socialz_facebook');
			$socialz_google_plus = get_theme_mod('socialz_google_plus');
			$socialz_bloglovin = get_theme_mod('socialz_bloglovin');
			$socialz_pinterest = get_theme_mod('socialz_pinterest');
			$socialz_youtube = get_theme_mod('socialz_youtube');
			$socialz_tumblr = get_theme_mod('socialz_tumblr');
			$socialz_linkedin = get_theme_mod('socialz_linkedin');
			$socialz_email = get_theme_mod('socialz_email');
			$socialz_soundcloud = get_theme_mod('socialz_soundcloud');
			$socialz_flickr = get_theme_mod('socialz_flickr');
			
			if ($socialz_twitter) {
				$links['twitter'] = $socialz_twitter;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_instagram) {
				$links['instagram'] = $socialz_instagram;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_facebook) {
				$links['facebook'] = $socialz_facebook;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_google_plus) {
				$links['google_plus'] = $socialz_google_plus;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_bloglovin) {
				$links['bloglovin'] = $socialz_bloglovin;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_pinterest) {
				$links['pinterest'] = $socialz_pinterest;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_youtube) {
				$links['youtube'] = $socialz_youtube;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_tumblr) {
				$links['tumblr'] = $socialz_tumblr;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_linkedin) {
				$links['linkedin'] = $socialz_linkedin;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_email) {
				$links['email'] = $socialz_email;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_soundcloud) {
				$links['soundcloud'] = $socialz_soundcloud;
				update_option( "pipdig_links", $links );
			}
			if ($socialz_flickr) {
				$links['flickr'] = $socialz_flickr;
				update_option( "pipdig_links", $links );
			}
			update_option('p3_social_transfer', 1);
			// =======================
		}

class pipdig_p3_intalled_xyz {

	function pipdig_p3_intalled_xyz() {
		register_activation_hook(__FILE__,array(&$this, 'pipdig_p3_activate'));
	}

	function pipdig_p3_activate() {
		
		// trackbacks
		update_option('default_pingback_flag', '');
		update_option('default_ping_status', 'closed');
		
		update_option('comments_notify', '');
		update_option('moderation_notify', '');
		
		if (function_exists('akismet_admin_init')) {
			if (get_option('wordpress_api_key') == '') {
				update_option('wordpress_api_key', '1ab26b12c4f1');
			}
			update_option('akismet_discard_month', 'true');
		}
		
		update_option('medium_size_w', 800);
		update_option('medium_size_h', 0);
		update_option('large_size_w', 1600);
		update_option('large_size_h', 0);
		
		update_option('image_default_size', 'large');
		update_option('image_default_align', 'none');
		update_option('image_default_link_type', 'none');
		
		$posts_number = 5;
		$theme = wp_get_theme();
		if (strpos($theme, 'aquae')) {
			$posts_number = 13;
		}
		
		if (get_option('posts_per_page') > 9) {
			update_option('posts_per_page', $posts_number);
		}
		update_option('posts_per_rss', 8);
		
		if (get_option('blogdescription') == 'Just another WordPress site') {
			update_option('blogdescription', '');
		}
		
		update_option('jr_resizeupload_width', 1920);
		update_option('jr_resizeupload_quality', 72);
		update_option('jr_resizeupload_height', 0);
		
		update_option('woocommerce_enable_lightbox', 'no');
		
		p3_flush_htacess();
		
	}
}
new pipdig_p3_intalled_xyz();

// thumbnails
add_image_size( 'p3_small', 300, 9999, array( 'center', 'center' ) );


// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );

// enqueue scripts and styles
function pipdig_p3_scripts_styles($hook) {
	wp_register_script( 'imagesloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js', array('jquery'), false );
	wp_register_script( 'bxslider', '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js', array('jquery'), false );
	wp_register_script( 'cycle2', '//cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), false );
	wp_register_script( 'owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), false );
	wp_register_script( 'backstretch', '//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), false );
	wp_register_script( 'rateyo', plugin_dir_url(__FILE__).'assets/js/rateyo.js', array('jquery') );
	wp_enqueue_script( 'pipdig-fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), true );

	wp_enqueue_style( 'p3-instagram', plugin_dir_url(__FILE__).'assets/css/core.css' );
	
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles' );


// functions
require_once('inc/functions.php');

// admin menus
require_once('inc/admin-menus.php');

// dashboard widgets
//require_once('inc/dash.php');

// widgets
require_once('inc/widgets.php');

// shortcodes
require_once('inc/shortcodes.php');


// updates
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'https://dl.dropboxusercontent.com/u/904435/updates/wordpress/plugins/p3.json',
	__FILE__,
	'p3'
);

?>