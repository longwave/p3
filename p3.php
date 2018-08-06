<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: https://www.pipdig.co/
Description: The core functions of any pipdig theme.
Author: pipdig
Author URI: https://www.pipdig.co/
Version: 3.14.0
Text Domain: p3
License: Copyright 2018 pipdig Ltd. All Rights Reserved.
*/

if (!defined('ABSPATH')) die;

define( 'PIPDIG_P3_V', '3.14.0' );

function p3_php_version_notice() {
	if (strnatcmp(phpversion(),'5.4.0') >= 0) {
		return;
	}
	?>
	<div class="notice notice-error is-dismissible">
		<h2><span class="dashicons dashicons-warning"></span> Security Warning</h2>
		<p>Your host is using an old, insecure version of PHP. Please contact your web host so that they can update to PHP version 7.0 or higher. <strong>DO NOT IGNORE THIS MESSAGE</strong>.</p>
		<p>&nbsp;</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'p3_php_version_notice' );

function pipdig_p3_themes_top_link() {
	/*
	if (isset($_GET['pipdig_key'])) {
		delete_transient('pipdig_active');
		$theme = get_option('pipdig_theme');
		$key = sanitize_text_field($_GET['pipdig_key']);
		update_option($theme.'_key', $key);
	}
	*/
	if (!isset($_GET['page'])) {
	?>
	<script>
	jQuery(document).ready(function($) {
		$('.page-title-action').before('<a class="add-new-h2" href="https://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig.co Themes</a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' );

function pipdig_p3_plugins_head() {
	?>
	<style>
	#all-404-redirect-to-homepage-upgradeMsg {display:none!important}
	</style>
	<?php
}
add_action( 'admin_head-plugins.php', 'pipdig_p3_plugins_head' );

function pipdig_p3_deactivate() {
	
	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['user_id'])) {
		$instagram_user = sanitize_text_field($instagram_deets['user_id']);
		delete_transient('p3_instagram_feed_'.$instagram_user);
	}
	
	wp_cache_flush();
	
}
register_deactivation_hook( __FILE__, 'pipdig_p3_deactivate' );

include(plugin_dir_path(__FILE__).'inc/cron.php');

// bootstrap
$this_theme = wp_get_theme();
$theme_textdomain = $this_theme->get('TextDomain');
if (empty($theme_textdomain) && !function_exists('catch_that_image')) {function catch_that_image(){}}
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

function p3_license_notification() {
	
	if (!is_super_admin()) {
		return;
	}
	
	$active = absint(is_pipdig_active());
	
	if ($active == 1) { // active
	
		return;
		
	} else { // not active
		
		$msg = '';
		if (isset($_POST['p3_license_data']) && !empty($_POST['p3_license_data'])) {
			delete_transient('pipdig_active');
			$theme = get_option('pipdig_theme');
			$key = sanitize_text_field($_POST['p3_license_data']);
			if (is_pipdig_active($key)) {
				update_option($theme.'_key', $key);
				return;
			} else {
				$msg = '<p style="font-weight: bold; font-size: 15px;">The key "'.$key.'" could not be validated. This might mean there is a typo or the key has already been used on another site. Please try again to double check. You can get help with this issue on <a href="https://go.pipdig.co/open.php?id=license-help" target="_blank" rel="noopener">this page</a>.</p>';
			}
			
		} else {
			$key = '';
		}
		
		$deadline = absint(get_option('p3_activation_deadline'));
		if (!$deadline) {
			$deadline = 1543622400; // 1st Dec 2018
		}
		
		?>
		<div class="notice notice-warning">
			<h2><span class="dashicons dashicons-warning"></span> Action required</h2>
			<p>Please enter your pipdig theme license key using the option below. Unless a valid key is provided, this theme will be deactivated on <?php echo date_i18n(get_option('date_format'), $deadline); ?>.</p>
			<p>You can find your theme's license key in your email receipt (<a href="https://support.pipdig.co/wp-content/uploads/2018/07/license_key_email.png" target="_blank">example</a>). Can't find your license key? <a href="https://go.pipdig.co/open.php?id=license-help" target="_blank" rel="noopener">Click here</a> and we'll be happy to help!</p>
			<p>Enter your license key below:</p>
			<?php echo $msg; ?>
			<form action="<?php echo admin_url(); ?>" method="post" autocomplete="off">
				<?php wp_nonce_field('p3-license-notice-nonce'); ?>
				<input type="text" value="<?php echo $key; ?>" name="p3_license_data" />
				<p class="submit" style="margin-top: 5px; padding-top: 5px;">
					<input name="submit" class="button" value="Validate Key" type="submit" />
				</p>
			</form>
		</div>
		<?php
		
	}
	

}
//add_action( 'admin_notices', 'p3_license_notification' );

function pipdig_switch_theme() {
	delete_transient('pipdig_active');
}
add_action('switch_theme', 'pipdig_switch_theme', 10);

function is_pipdig_active($key = '') {
	
	if (strpos(get_site_url(), '127.0.0.1') !== false) {
		return 1;
	} elseif (is_multisite() && (get_blog_count() > 1)) {
		return 1;
	} elseif (strpos(get_site_url(), '.pipdig.co') !== false) {
		return 1;
	}
	
	if ( false === ( $active = get_transient( 'pipdig_active' ) )) {
		
		$pipdig_id = get_option('pipdig_id');
		if (!$pipdig_id) {
			$pipdig_id = sanitize_text_field(substr(str_shuffle(MD5(microtime())), 0, 10));
			add_option('pipdig_id', $pipdig_id);
		}
		
		$active = 0;
		$request_array = array();
		
		$theme = get_option('pipdig_theme');
		if (!$key) {
			$key = get_option($theme.'_key');
		}
		
		if (!$theme) {
			return 0;
		}
		if (!$key) {
			return 0;
		}

		$request_array['domain'] = get_site_url();
		$request_array['id'] = $pipdig_id;
		$request_array['key'] = $key;
		$request_array['theme'] = $theme;

		$url = add_query_arg($request_array, 'https://pipdig.co/papi/v1/');

		$args = array(
			'timeout' => 9,
		);

		$response = wp_safe_remote_get($url, $args);

		if (!is_wp_error($response)) {
			$result = absint($response['body']);
			if ($result === 1 || $result === 2) {
				$active = 1;
			} elseif ($result === 3) {
				$active = 1;
			} else {
				$active = 0;
			}
		} else {
			return 1; // server offline
		}

	}
	set_transient( 'pipdig_active', $active, 7 * DAY_IN_SECONDS );
	return $active;
}

/*
$active = absint(is_pipdig_active());
if ($active !== 1) { // active
	$deadline = absint(get_option('p3_activation_deadline'));
	if (!$deadline) {
		$deadline = 1543622400; // 1st Dec 2018
	}
	$now = time();
	if ($now > $deadline) {
		return;
	}
}
*/

function p3_auto_updates() {
	if (get_option('p3_auto_updates_on')) {
		return true;
	}
}
add_filter('auto_update_plugin', 'p3_auto_updates');

// change medium to smaller size for faster media lib loading times.
function p3_update_sizes_may_2018() {
	if (get_option('p3_update_sizes_may_2018')) {
		return;
	}
	update_option('medium_size_w', 300);
	update_option('medium_size_h', 0);
	update_option('medium_large_size_w', 0);
	update_option('medium_large_size_h', 0);
	update_option('p3_update_sizes_may_2018', 1);
}
add_action('admin_init', 'p3_update_sizes_may_2018');

// enqueue scripts and styles
function pipdig_p3_scripts_styles() {
	
	if (get_theme_mod('disable_responsive')) {
		wp_enqueue_style( 'p3-core', 'https://pipdigz.co.uk/p3/css/core.css', array(), PIPDIG_P3_V );
	} else {
		wp_enqueue_style( 'p3-core-responsive', 'https://pipdigz.co.uk/p3/css/core_resp.css', array(), PIPDIG_P3_V );
	}
	wp_register_script( 'pipdig-imagesloaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js', array('jquery'), null, false );
	wp_register_script( 'pipdig-masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.1/masonry.pkgd.min.js', array('pipdig-imagesloaded'), null, false );
	//if (class_exists('Jetpack') && !Jetpack::is_module_active('carousel')) {
		//wp_register_script( 'jquery-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), null, false );
		wp_register_script( 'pipdig-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), null, false );
	//}
	wp_register_script( 'pipdig-cycle-swipe', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.swipe.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js', array( 'jquery' ), null, false );
	wp_register_script( 'pipdig-owl', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), null, false );
	wp_register_script( 'backstretch', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), null, false );
	wp_register_script( 'stellar', 'https://cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js', array('jquery'), null, true );
	wp_register_script( 'rateyo', 'https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.1.1/jquery.rateyo.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'pipdig-fitvids', 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'pipdig-mixitup', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array( 'jquery' ), null, true );
	//wp_register_script( 'pipdig-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'pipdig-flickity', 'https://cdnjs.cloudflare.com/ajax/libs/flickity/2.0.10/flickity.pkgd.min.js', array('jquery'), null, false );
	wp_register_script( 'pipdig-flickity-bglazy', 'https://unpkg.com/flickity-bg-lazyload@1.0.0/bg-lazyload.js', array('pipdig-flickity'), null, false );

	if (get_theme_mod('pipdig_lazy')) {
		wp_enqueue_script( 'pipdig-lazy', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.5/jquery.lazy.min.js', array( 'jquery' ), null, true );
	}

	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '', null );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles');

include_once(plugin_dir_path(__FILE__).'inc/functions.php');
include_once(plugin_dir_path(__FILE__).'inc/admin-menus.php');
include_once(plugin_dir_path(__FILE__).'inc/meta.php');
include_once(plugin_dir_path(__FILE__).'inc/dash.php');
include_once(plugin_dir_path(__FILE__).'inc/widgets.php');
include(plugin_dir_path(__FILE__).'inc/shortcodes.php');
include(plugin_dir_path(__FILE__).'inc/beaver.php');

include_once (ABSPATH.'wp-admin/includes/plugin.php');
if (!is_plugin_active('jetpack/jetpack.php')) {
	// widget visibility
	if (!class_exists('Jetpack_Widget_Conditions')) {
		include_once(plugin_dir_path(__FILE__).'inc/bundled/widget-visibility/widget-conditions.php');
	}
} else {
	include_once(plugin_dir_path(__FILE__).'inc/jetpack.php');
}

function p3_new_install_notice() {

	global $pagenow;
	if ($pagenow != 'index.php' && $pagenow != 'themes.php' && $pagenow != 'plugins.php') {
		return;
	}

	if (isset($_GET['page']) && $_GET['page'] == 'pipdig-demo-import') {
		return;
	}

	if (current_user_can('manage_options')) {
		if (isset($_POST['p3_new_install_notice_dismissed'])) {
			update_option('p3_new_install_notice', 1);
		}
	}

	if (get_option('p3_new_install_notice') || !current_user_can('manage_options')) {
		return;
	}
	
	$active = absint(is_pipdig_active());
	if ($active !== 1) { // active
		return;
	}

	$import = '';
	$wp101= '<p>New to WordPress? You can access the premium series of WP101 Tutorials on <a href="https://go.pipdig.co/open.php?id=wp101videos" target="_blank">this page</a>.</p>';
	$posts = wp_count_posts();
	$posts_count = $posts->publish + $posts->draft;
	if ($posts_count < 2) {
		$import_link = '<a href="https://support.pipdig.co/articles/wordpress-import-demo-content/" target="_blank">';
		if (class_exists('OCDI_Plugin')) {
			$import_link = '<a href="'.admin_url('themes.php?page=pipdig-demo-import').'">';
		}
		$import = '<p>It looks like this is a new site. You may wish to '.$import_link.'import some demo content</a> so that you can see the theme options more easily.</p>';
	} elseif ($posts_count > 21) {
		$wp101 = '';
	}

	?>
	<div class="notice notice-warning is-dismissible">
		<h2><?php _e('Howdy!', 'p3'); ?></h2>
		<p>Thank you for installing a pipdig theme!</p>
		<p>You can now setup all of our custom widgets, options and features by following our <a href="https://go.pipdig.co/open.php?id=wp-quickstart" target="_blank">Quickstart Guide</a>.</p>
		<?php echo $wp101; ?>
		<?php echo $import; ?>
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
	
	add_option('pipdig_id', sanitize_text_field(substr(str_shuffle(MD5(microtime())), 0, 10)));

	add_option('p3_auto_updates_on', 0);
	update_option('endurance_cache_level', 0);

	$plugins = array(
		'wd-instagram-feed/wd-instagram-feed.php',
		'instagram-slider-widget/instaram_slider.php',
		'categories-images/categories-images.php',
		'mojo-marketplace-wp-plugin/mojo-marketplace.php',
		'mojo-marketplace-hg/mojo-marketplace.php',
		'autoptimize/autoptimize.php',
		'heartbeat-control/heartbeat-control.php',
		'instagram-slider-widget/instaram_slider.php',
		'vafpress-post-formats-ui-develop/vp-post-formats-ui.php',
		'advanced-excerpt/advanced-excerpt.php',
		'force-regenerate-thumbnails/force-regenerate-thumbnails.php',
		'jch-optimize/jch-optimize.php',
		'rss-image-feed/image-rss.php',
		'wpclef/wpclef.php',
		'hello-dolly/hello.php',
		'theme-test-drive/themedrive.php',
	);
	deactivate_plugins($plugins);

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
	update_option('medium_size_w', 300);
	update_option('medium_size_h', 0);
	update_option('medium_large_size_w', 0);
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
	if ( (get_option('show_on_front') == 'page') && (get_option('pipdig_p3_show_on_front_set') != 1) ) {
		update_option('show_on_front', 'posts');
		update_option('pipdig_p3_show_on_front_set', 1);
	}

	update_option('woocommerce_enable_lightbox', 'no');

	$sb_options = get_option('sb_instagram_settings');
	if (!empty($sb_options['sb_instagram_at']) && !empty($sb_options['sb_instagram_user_id'])) {
		$pipdig_instagram = get_option('pipdig_instagram');
		$pipdig_instagram['user_id'] = $sb_options['sb_instagram_user_id'];
		$pipdig_instagram['access_token'] = $sb_options['sb_instagram_at'];
		update_option( "pipdig_instagram", $pipdig_instagram );
	}

	if (get_option('p3_amicorumi_set_3') != 1) {
		delete_option('p3_amicorumi');
		delete_option('p3_amicorumi_set');
		delete_option('p3_amicorumi_set_2');
		if (get_option('p3_amicorumi_2')) {
			$new_amic_https = str_replace("http://", "https://", get_option('p3_amicorumi_2'));
			update_option('p3_amicorumi_2', $new_amic_https);
		} else {
			$piplink_array = array('https://www.pipdig.co/', 'https://www.pipdig.co/', 'https://www.pipdig.co', 'https://www.pipdig.co/products/wordpress-themes/');
			$piplink = $piplink_array[mt_rand(0, count($piplink_array) - 1)];
			$pipstyle_array = array('text-transform:lowercase;letter-spacing:1px;', 'text-transform: lowercase;letter-spacing: 1px;', 'text-transform: lowercase;letter-spacing:1px;', 'text-transform:lowercase; letter-spacing:1px;', 'text-transform:lowercase;letter-spacing:1px');
			$pipstyle = $pipstyle_array[mt_rand(0, count($pipstyle_array) - 1)];
			$amicorum_array = array(
				'<a href="'.$piplink.'" target="_blank">Theme design by <span style="'.$pipstyle.'">pipdig</span></a>',
				'<a href="'.$piplink.'" target="_blank">Theme created by <span style="'.$pipstyle.'">pipdig</span></a>',
				//'<a href="'.$piplink.'" target="_blank">Website Design by <span style="'.$pipstyle.'">pipdig</span></a>',
				'<a href="'.$piplink.'" target="_blank">Theme Created by <span style="'.$pipstyle.'">pipdig</span></a>',
				'<a href="'.$piplink.'" target="_blank">Theme Designed by <span style="'.$pipstyle.'">pipdig</span></a>',
				//'<a href="'.$piplink.'" target="_blank">WordPress Themes by <span style="'.$pipstyle.'">pipdig</span></a>',
				//'<a href="'.$piplink.'" target="_blank">Powered by <span style="'.$pipstyle.'">pipdig</span></a>',
			);
			$amicorum = $amicorum_array[mt_rand(0, count($amicorum_array) - 1)];
			update_option('p3_amicorumi_2', $amicorum);
		}
		update_option('p3_amicorumi_set_3', 1);
	}

	if (class_exists('Jetpack')) {
		if (Jetpack::is_module_active('sharedaddy')) {
			Jetpack::deactivate_module( 'sharedaddy' );
		}
		/*
		if (Jetpack::is_module_active('photon')) {
			Jetpack::deactivate_module( 'photon' );
		}
		*/
	}
	
	if (get_the_title(1) == 'WordPress Resources at SiteGround') {
		wp_delete_post(1);
	}
	
	update_option('link_manager_enabled', 0);

	// delete pipdig-importer data
	delete_option('pipdig_importer_settings_set');

}
register_activation_hook( __FILE__, 'pipdig_p3_activate' );

// Don't allow some plugins. Sorry not sorry.
function p3_trust_me_you_dont_want_this() {
	$plugins = array(
		'query-strings-remover/query-strings-remover.php', // Stop removing query strings. They're an important part of WP and keeping the site working correctly with caching.
		'remove-query-strings-from-static-resources/remove-query-strings.php',
		'scripts-to-footer/scripts-to-footer.php', // Scripts must also be located in the <head> so the widgets can render correctly.
		'fast-velocity-minify/fvm.php',
		'contact-widgets/contact-widgets.php', // Font awesome 5 breaks other icons
	);
	deactivate_plugins($plugins);
}
add_action('admin_init', 'p3_trust_me_you_dont_want_this');

function pipdig_p3_theme_setup() {
	// thumbnails
	add_image_size('p3_medium', 800, 9999);
}
add_action( 'after_setup_theme', 'pipdig_p3_theme_setup' );

// Load text domain for languages
function pipdig_p3_textdomain() {
	load_plugin_textdomain( 'p3', false, 'p3/languages' );
}
add_action( 'plugins_loaded', 'pipdig_p3_textdomain' );
function p3_plugin_puc_icons( $info, $response = null ) {
	$info->icons = array('1x' => 'https://pipdigz.co.uk/p3/icon-128x128.png','2x' => 'https://pipdigz.co.uk/p3/icon-256x256.png');
	return $info;
}
require_once 'inc/plugin-update-checker/plugin-update-checker.php';$updater = Puc_v4_Factory::buildUpdateChecker('https://bitbucket.org/pipdig/p3', __FILE__, 'p3');$updater->setBranch('master');$updater->addResultFilter('p3_plugin_puc_icons');

function p3_gb_learn_more_link($link) {
    return '<a href="https://www.pipdig.co/blog/gutenberg/">Learn more about Gutenberg</a>';
}
add_filter( 'try_gutenberg_learn_more_link', 'p3_gb_learn_more_link' );