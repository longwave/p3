<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://www.pipdig.co/
Description: The core functions of any pipdig theme. Note: will only work when using a pipdig theme.
Author: pipdig
Author URI: http://www.pipdig.co/
Version: 1.8.1
Text Domain: p3
*/

update_option('pipdig_p3_version', '1.8.1');

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
		
		if ( false === ( $value = get_transient('p3_houekeeping') ) ) {
			
			set_transient('p3_houekeeping', true, 1 * WEEK_IN_SECONDS);
		
			// trackbacks
			update_option('default_pingback_flag', '');
			update_option('default_ping_status', 'closed');
			
			if (get_option('comments_notify') === 1 && (get_option('pipdig_p3_comments_set') != 1)) {
				update_option('comments_notify', '');
				update_option('moderation_notify', '');
				update_option('pipdig_p3_comments_set', 1);
			}
			
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
			
			if (get_option('posts_per_page') == 10 && (get_option('pipdig_p3_posts_per_page_set') != 1)) {
				update_option('posts_per_page', 5);
				update_option('pipdig_p3_posts_per_page_set', 1);
			}
			update_option('posts_per_rss', 8);
			
			if (get_option('blogdescription') == 'Just another WordPress site') {
				update_option('blogdescription', '');
			}
			
			update_option('jr_resizeupload_width', 1920);
			update_option('jr_resizeupload_quality', 72);
			update_option('jr_resizeupload_height', 0);
			
			update_option('woocommerce_enable_lightbox', 'no');
			
			$sb_options = get_option('sb_instagram_settings');
			if (!empty($sb_options['sb_instagram_at']) && !empty($sb_options['sb_instagram_user_id'])) {
				$pipdig_instagram = get_option('pipdig_instagram');
				$pipdig_instagram['user_id'] = $sb_options['sb_instagram_user_id'];
				$pipdig_instagram['access_token'] = $sb_options['sb_instagram_at'];
				update_option( "pipdig_instagram", $pipdig_instagram );
			}
			
			// set header if WP default used
			if (!get_theme_mod('logo_image') && (get_option('pipdig_p3_header_set') != 1)) {
				if (get_header_image()) {
					 set_theme_mod('logo_image', get_header_image());
					 update_option('pipdig_p3_header_set', 1);
				}
			}
			
			p3_flush_htacess();
			
		} // transient check
	}
}
new pipdig_p3_intalled_xyz();

// thumbnails
add_image_size( 'p3_small', 300, 9999, array( 'center', 'center' ) );
add_image_size( 'p3_medium', 800, 9999, array( 'center', 'center' ) );
add_image_size( 'p3_large', 1280, 9999, array( 'center', 'center' ) );


// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );

// enqueue scripts and styles
function pipdig_p3_scripts_styles() {
	
	wp_enqueue_style( 'p3-core', plugin_dir_url(__FILE__).'assets/css/core.css' );
	if (!get_theme_mod('disable_responsive')) { wp_enqueue_style( 'p3-responsive', plugin_dir_url(__FILE__).'assets/css/responsive.css' ); }
	
	wp_register_script( 'imagesloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js', array('jquery'), false );
	wp_register_script( 'bxslider', '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js', array('jquery'), false );
	wp_register_script( 'pipdig-cycle', '//cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), false );
	wp_register_script( 'owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), false );
	wp_register_script( 'backstretch', '//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), false );
	wp_register_script( 'stellar', '//cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js', array('jquery'), true );
	wp_register_script( 'rateyo', plugin_dir_url(__FILE__).'assets/js/rateyo.js', array('jquery'), true );
	wp_enqueue_script( 'pipdig-fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), true );

	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles');


// functions
require_once('inc/functions.php');

// admin menus
require_once('inc/admin-menus.php');

// meta boxes
//require_once('inc/meta.php');

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

// 800 x 450

// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=

// 1200 x 800
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAAMgAQMAAAAJLglBAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJhJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9d+MAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAFNfvAAEQ/dDPAAAAAElFTkSuQmCC

// 600 x 400
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII=

// 500 x 500
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC
?>