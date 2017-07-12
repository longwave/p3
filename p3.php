<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: https://www.pipdig.co/
Description: The core functions of any pipdig theme.
Author: pipdig
Author URI: https://www.pipdig.co/
Version: 2.14.6
Text Domain: p3
*/

if (!defined('ABSPATH')) die;

define( 'PIPDIG_P3_V', '2.14.6' );

function p3_php_version_notice() {
	if (strnatcmp(phpversion(),'5.3.10') >= 0) {
		return;
	}
	?>
	<div class="notice notice-error is-dismissible">
		<h2><span class="dashicons dashicons-warning"></span> PHP Warning</h2>
		<p>Your web server is using an insecure version of PHP. Please contact your web host so that they can update your server to PHP 5.6 or higher. <strong>DO NOT IGNORE THIS MESSAGE</strong>.</p>
		<p>&nbsp;</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'p3_php_version_notice' );
/*
if (strnatcmp(phpversion(),'5.3.10') <= 0) {
	return;
}
*/
function pipdig_p3_themes_top_link() {
	if(!isset($_GET['page'])) {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.page-title-action').before('<a class="add-new-h2" href="https://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig.co Themes</a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' );

function pipdig_p3_deactivate() {
    if (!current_user_can('activate_plugins')) {
        return;
	}
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "deactivate-plugin_{$plugin}" );
	// delete this site
	$remove_data = wp_remote_fopen('https://status.pipdig.co/?dcx15=15&action=2&site_url='.rawurldecode(get_site_url()));
	delete_option('pipdig_live_site');
}
register_deactivation_hook( __FILE__, 'pipdig_p3_deactivate' );

// bootstrap
$this_theme = wp_get_theme();
$theme_textdomain = $this_theme->get('TextDomain');
if ($this_theme->get('Author') != 'pipdig') {
	$child_parent = $this_theme->get('Template');
	if ($child_parent) {
		$child_parent = explode('-', trim($child_parent));
		if ($child_parent[0] != 'pipdig') {
			return;
		}
	} else {
		if ($theme_textdomain) {
			$theme_textdomain = explode('-', trim($theme_textdomain));
			if ($theme_textdomain[0] != 'pipdig') {
				return;
			}
		} else {
			return;
		}
	}
}

/*
$theme_name = explode('-', trim(get_template()));
if ($theme_name[0] != 'pipdig') {
	return;
} else {
	function pipdig_bootstrap_active() {
		$pipdig_bootstrap_active = 1;
	}
}
*/

//add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

// enqueue scripts and styles
function pipdig_p3_scripts_styles() {
	wp_enqueue_style( 'p3-core', plugin_dir_url(__FILE__).'assets/css/core.css', array(), PIPDIG_P3_V );
	if (!get_theme_mod('disable_responsive')) { wp_enqueue_style( 'p3-responsive', plugin_dir_url(__FILE__).'assets/css/responsive.css', array(), PIPDIG_P3_V ); }
	//wp_register_script( 'imagesloaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js', array('jquery'), false );
	wp_register_script( 'pipdig-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), null, false );
	wp_register_script( 'jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'pipdig-owl', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), null, false );
	wp_register_script( 'backstretch', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), null, false );
	wp_register_script( 'stellar', 'https://cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js', array('jquery'), null, true );
	wp_register_script( 'rateyo', 'https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.1.1/jquery.rateyo.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'pipdig-fitvids', 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'pipdig-mixitup', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array( 'jquery' ), null, true );
	//wp_register_script( 'pipdig-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'pipdig-flickity', 'https://unpkg.com/flickity@2.0/dist/flickity.pkgd.min.js', array('jquery'), null, false );
	
	wp_enqueue_style( 'font-awesome', 'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', '', null );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles');

include_once('inc/functions.php');
include_once('inc/admin-menus.php');
include_once('inc/meta.php');
include_once('inc/dash.php');
include_once('inc/jetpack.php');
include_once('inc/widgets.php');
include('inc/shortcodes.php');
include('inc/cron.php');
include('inc/beaver.php');

/*
function pipdig_change_posts_number_theme() {
	if (get_option('pipdig_p3_posts_per_page_set') != 1) { // legacy check
		if (get_option('pipdig_p3_posts_per_page_set_'.get_template()) != 1) {
			if (get_option('pipdig_theme') == 'aquae') {
				update_option('posts_per_page', 13);
			} elseif (get_option('pipdig_theme') == 'hollyandweave') {
				update_option('posts_per_page', 8);
			} elseif (get_option('pipdig_theme') == 'galvani') {
				update_option('posts_per_page', 12);
			} elseif (get_option('pipdig_theme') == 'thegrid') {
				update_option('posts_per_page', 6);
			} elseif (get_option('pipdig_theme') == 'crystal') {
				update_option('posts_per_page', 9);
			} else {
				update_option('posts_per_page', 5);
			}
			update_option('pipdig_p3_posts_per_page_set_'.get_template(), 1);
		}
	}
}
add_action( 'after_setup_theme', 'pipdig_change_posts_number_theme', 9999);
*/

function p3_new_install_notice() {

	if (current_user_can('manage_options')) {
		if (isset($_POST['p3_new_install_notice_dismissed'])) {
			update_option('p3_new_install_notice', 1);
		}
	}
	
	if (get_option('p3_new_install_notice') || !current_user_can('manage_options')) {
		return;
	}
	/*
	$this_theme = wp_get_theme();
	$theme_textdomain = $this_theme->get('TextDomain');
	if ($this_theme->get('Author') != 'pipdig') {
		$child_parent = $this_theme->get('Template');
		if ($child_parent) {
			$child_parent = explode('-', trim($child_parent));
			if ($child_parent[0] != 'pipdig') {
				return;
			}
		} else {
			if ($theme_textdomain) {
				$theme_textdomain = explode('-', trim($theme_textdomain));
				if ($theme_textdomain[0] != 'pipdig') {
					return;
				}
			}
		}
	}
	$theme_name_full = $this_theme->get('Name');
	$theme_name = str_replace(' (pipdig)', '', $theme_name_full);
	*/
	?>
	<div class="notice notice-warning is-dismissible">
		<h2><?php _e('Howdy!', 'p3'); ?></h2>
		<p>Thank you for installing a pipdig theme!</p>
		<p>You can now setup all of our custom widgets, options and features by following our <a href="https://go.pipdig.co/open.php?id=wp-quickstart" target="_blank">Quickstart Guide</a>.</p>
		<p>New to WordPress? You can access the premium series of WP101 Tutorials on <a href="https://go.pipdig.co/open.php?id=wp101videos" target="_blank">this page</a>.</p>
		<form action="<?php echo admin_url(); ?>" method="post">
			<?php wp_nonce_field('p3-new-install-notice-nonce'); ?>
			<input type="hidden" value="true" name="p3_new_install_notice_dismissed" />
			<p class="submit" style="margin-top: 5px; padding-top: 5px;">
				<input name="submit" class="button" value="Hide this notice" type="submit" />
			</p>
		</form>
	</div>
	<?php
}
add_action( 'admin_notices', 'p3_new_install_notice' );



function pipdig_p3_activate() {
	
	update_option('endurance_cache_level', 0);
	
	// trackbacks
	update_option('default_pingback_flag', '');
	update_option('default_ping_status', 'closed');
		
	if (get_option('comments_notify') === 1 && (get_option('pipdig_p3_comments_set') != 1)) {
		update_option('comments_notify', '');
		update_option('moderation_notify', '');
		update_option('pipdig_p3_comments_set', 1);
	}
	
	update_option('thumbnail_size_h', 150);
	update_option('thumbnail_size_w', 150);
	update_option('medium_size_w', 800);
	update_option('medium_size_h', 0);
	update_option('medium_large_size_w', 800);
	update_option('medium_large_size_h', 0);
	update_option('large_size_w', 1440);
	update_option('large_size_h', 0);
	
	update_option('image_default_size', 'large');
	update_option('image_default_align', 'none');
	update_option('image_default_link_type', 'none');
	
	update_option('imsanity_bmp_to_jpg', 0);
	update_option('imsanity_max_height', 0);
	update_option('imsanity_max_height_library', 0);
	update_option('imsanity_max_height_other', 0);
	update_option('imsanity_quality', 80);
	update_option('imsanity_bmp_to_jpg', 0);
	
	if (!get_option('rss_use_excerpt') && (get_option('pipdig_p3_rss_use_excerpt_set') != 1)) {
		update_option('posts_per_rss', 10);
		update_option('rss_use_excerpt', 1);
		update_option('pipdig_p3_rss_use_excerpt_set', 1);
	}
	if (get_option('blogdescription') == 'My WordPress Blog') {
		update_option('blogdescription', '');
	}
	if (get_option('pipdig_p3_show_on_front_set') != 1) {
		update_option('show_on_front', 'posts');
		update_option('pipdig_p3_show_on_front_set', 1);
	}
	/*
	if (get_option('jr_resizeupload_width') == '1200' && (get_option('pipdig_p3_jr_resizeupload_width_set') != 1)) {
		update_option('jr_resizeupload_width', 1920);
		update_option('jr_resizeupload_quality', 75);
		update_option('jr_resizeupload_height', 0);
		update_option('jr_resizeupload_convertgif_yesno', 'no');
		update_option('pipdig_p3_jr_resizeupload_width_set', 1);
	}
	*/
	
	update_option('woocommerce_enable_lightbox', 'no');
		
	$sb_options = get_option('sb_instagram_settings');
	if (!empty($sb_options['sb_instagram_at']) && !empty($sb_options['sb_instagram_user_id'])) {
		$pipdig_instagram = get_option('pipdig_instagram');
		$pipdig_instagram['user_id'] = $sb_options['sb_instagram_user_id'];
		$pipdig_instagram['access_token'] = $sb_options['sb_instagram_at'];
		update_option( "pipdig_instagram", $pipdig_instagram );
	}
	
	if (get_option('p3_instagram_transfer') != 1) {
		if (get_theme_mod('footer_instagram')) {
		set_theme_mod('p3_instagram_footer', 1);
		remove_theme_mod('footer_instagram');
		}
		if (get_theme_mod('header_instagram')) {
		set_theme_mod('p3_instagram_header', 1);
		remove_theme_mod('header_instagram');
		}
		remove_theme_mod('footer_instagram_num');
		remove_theme_mod('header_instagram_num');
		update_option('p3_instagram_transfer', 1);
	}
	
	remove_theme_mod('footer_instagram');
	remove_theme_mod('header_instagram');
	
	// set header if WP default used
	/*
	if (!get_theme_mod('logo_image') && (get_option('pipdig_p3_header_set') != 1)) {
		if (get_header_image()) {
		 set_theme_mod('logo_image', get_header_image());
		 update_option('pipdig_p3_header_set', 1);
		}
	}
	*/
	
	p3_flush_htacess();
	
	// live site check
	if (get_option('pipdig_live_site') != 1) {
		$submit_data = wp_remote_fopen('https://status.pipdig.co/?dcx15=15&action=1&site_url='.rawurldecode(get_site_url()));
		update_option('pipdig_live_site', 1);
	}
	
	if (get_option('p3_amicorumi_set_3') != 1) {
		delete_option('p3_amicorumi');
		delete_option('p3_amicorumi_set');
		delete_option('p3_amicorumi_set_2');
		if (get_option('p3_amicorumi_2')) {
			$new_amic_https = str_replace("http://", "https://", get_option('p3_amicorumi_2'));
			update_option('p3_amicorumi_2', $new_amic_https);
		} else {
			$piplink = 'https://www.pipdig.co';
			$piplink2 = 'https://www.pipdig.co/';
			$piplink3 = 'https://www.pipdig.co/products/wordpress-themes/';
			$amicorum = array(
			'<a href="'.$piplink2.'" target="_blank">Theme created by <span style="text-transform:lowercase;letter-spacing:1px;">pipdig</span></a>',
			'<a href="'.$piplink3.'" target="_blank">Theme Created by <span style="text-transform:lowercase;letter-spacing:1px;">pipdig</span></a>',
			'<a href="'.$piplink.'" target="_blank">Website Design by <span style="text-transform:lowercase;letter-spacing:1px;">pipdig</span></a>',
			'<a href="'.$piplink2.'" target="_blank">Theme Created by <span style="text-transform:lowercase; letter-spacing:1px;">pipdig</span></a>',
			'<a href="'.$piplink3.'" target="_blank">WordPress Theme by <span style="text-transform: lowercase;letter-spacing: 1px;">pipdig</span></a>',
			'<a href="'.$piplink3.'" target="_blank">WP theme by <span style="letter-spacing:1px;text-transform:lowercase;">pipdig</span></a>',
			'<a href="'.$piplink3.'" target="_blank">WordPress Themes by <span style="letter-spacing:1px;text-transform:lowercase;">pipdig</span></a>',
			'<a href="'.$piplink.'" target="_blank">Powered by <span style="text-transform:lowercase;letter-spacing:1px;">pipdig</span></a>',
			);
			update_option('p3_amicorumi_2', $amicorum[array_rand($amicorum)]);
		}
		update_option('p3_amicorumi_set_3', 1);
	}
	
	if (class_exists('Jetpack')) {
		if (Jetpack::is_module_active('sharedaddy')) {
			Jetpack::deactivate_module( 'sharedaddy' );
		}
	}
	
	// delete pipdig-importer data
	delete_option('pipdig_importer_settings_set');
	
}
register_activation_hook( __FILE__, 'pipdig_p3_activate' );




/*
function pipdig_p3_theme_setup() {
	// thumbnails
	add_image_size( 'p3_small', 640, 360, array( 'center', 'center' ) );
	add_image_size( 'p3_medium', 800, 450, array( 'center', 'center' ) );
	add_image_size( 'p3_large', 1280, 720, array( 'center', 'center' ) );
}
add_action( 'after_setup_theme', 'pipdig_p3_theme_setup' );
*/

// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );


require_once 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker('https://www.wpupdateserver.com/p3.json', __FILE__, 'p3');

// 1280 x 720
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABQAAAALQAQMAAAD1s08VAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJRJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9eeMAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKsAxN8AAX2oznYAAAAASUVORK5CYII=

// 800 x 450
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=

// 640 x 360
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC

// 1200 x 800
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAAMgAQMAAAAJLglBAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJhJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9d+MAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAFNfvAAEQ/dDPAAAAAElFTkSuQmCC

// 600 x 400
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII=

// 500 x 500
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC

// 360 x 480
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC