<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: https://www.pipdig.co/
Description: The core functions of any pipdig theme.
Author: pipdig
Author URI: https://www.pipdig.co/
Version: 4.2.1
Text Domain: p3
License: Copyright 2018 pipdig Ltd. All Rights Reserved.
*/

if (!defined('ABSPATH')) die;

define('PIPDIG_P3_V', '4.2.1');
define('PIPDIG_P3_DIR', plugin_dir_path(__FILE__));

function p3_themes_top_link() {
	if (!isset($_GET['page'])) {
	?>
	<script>
	jQuery(document).ready(function($) {
		$('.page-title-action').before('<a class="add-new-h2" href="https://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank" rel="noopener">pipdig.co Themes</a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'p3_themes_top_link' );

function p3_plugins_head() {
	?>
	<style>
	#all-404-redirect-to-homepage-upgradeMsg {display:none!important}
	</style>
	<?php
}
add_action( 'admin_head-plugins.php', 'p3_plugins_head' );

function pipdig_p3_deactivate() {

	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['user_id'])) {
		$instagram_user = sanitize_text_field($instagram_deets['user_id']);
		delete_transient('p3_instagram_feed_'.$instagram_user);
	}

	wp_cache_flush();

}
register_deactivation_hook( __FILE__, 'pipdig_p3_deactivate' );

include(PIPDIG_P3_DIR.'inc/cron.php');

remove_action('welcome_panel', 'wp_welcome_panel');

// bootstrap
$this_theme = wp_get_theme();
$theme_textdomain = $this_theme->get('TextDomain');
if (empty($theme_textdomain) && (!is_multisite()) && !function_exists('catch_that_image')) {function catch_that_image(){}}
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

	if (absint(is_pipdig_active()) == 1) {

		return;

	} else {

		$msg = '';
		if (!empty($_POST['p3_license_data'])) {
			delete_transient('pipdig_active');
			$theme = get_option('pipdig_theme');
			$key = sanitize_text_field($_POST['p3_license_data']);
			if (is_numeric($key)) {
				$msg = '<p style="font-weight: bold; font-size: 15px;">The key "'.$key.'" could not be validated. Please note that the license key is not your order number. If you need any help finding your key please see the steps on <a href="https://go.pipdig.co/open.php?id=license-help" target="_blank" rel="noopener">this page</a>.</p>';
			} elseif (is_pipdig_active($key)) {
				update_option($theme.'_key', $key);
				return;
			} else {
				$msg = '<p style="font-weight: bold; font-size: 15px;">The key "'.$key.'" could not be validated. Please try again to double check. You can get help finding your license key on <a href="https://go.pipdig.co/open.php?id=license-help" target="_blank" rel="noopener">this page</a>.</p>';
			}
		} else {
			if (false === ($check = get_transient('pipdig_check_now_yeah'))) {
				$response = wp_safe_remote_get('https://pipdigz.co.uk/p3/check.txt', array('timeout' => 4));
				if (is_wp_error($response) || !isset($response['body'])) {
					return;
				}
				$check = absint($response['body']);
				set_transient( 'pipdig_check_now_yeah', $check, 3 * DAY_IN_SECONDS );
				if ($check !== 1) {
					return;
				}
			}
			$key = '';
		}

		$integer = absint(get_option('p3_activation_deadline'));
		if (!$integer) {
			$integer = 1543622400;
		}

		?>
		<div class="notice notice-warning">
			<h2><span class="dashicons dashicons-warning"></span> Action required</h2>
			<p>To ensure all features of your pipdig theme are active, please enter your pipdig theme license key below.</p>
			<p>Please see <a href="https://go.pipdig.co/open.php?id=license-help" target="_blank" rel="noopener">this page</a> for more information.</p>
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
add_action( 'admin_notices', 'p3_license_notification' );

function pipdig_switch_theme() {
	delete_transient('pipdig_active');
	delete_transient('pipdig_check_now_yeah');
	delete_option('pipdig_theme');
}
add_action('switch_theme', 'pipdig_switch_theme', 10);

function is_pipdig_active($key = '') {

	$me = get_site_url();

	if (strpos($me, '127.0.0.1') !== false) {
		return 1;
	} elseif (strpos($me, '.local') !== false) {
		return 1;
	} elseif (strpos($me, 'localhost') !== false) {
		return 1;
	} elseif (strpos($me, 'dev.') !== false) {
		return 1;
	} elseif (strpos($me, '/~') !== false) {
		return 1;
	} elseif (strpos($me, '.pipdig.co') !== false) {
		return 1;
	} elseif (is_multisite() && (get_blog_count() > 1)) {
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
		if (!$theme) {
			$active = 0;
		}

		if (!$key) {
			$key = get_option($theme.'_key');
			if (!$key) {
				$active = 0;
			}
		}

		$request_array['domain'] = $me;
		$request_array['id'] = $pipdig_id;
		$request_array['key'] = $key;
		$request_array['theme'] = $theme;

		$url = add_query_arg($request_array, 'https://pipdig.co/papi/v1/');
		$response = wp_remote_get($url);

		if (!is_wp_error($response)) {
			$result = absint($response['body']);
			if ($result === 1 || $result === 2 || $result === 3) {
				$active = 1;
			} else {
				$active = 0;
			}
		} else {
			$active = 1;
		}

		set_transient( 'pipdig_active', $active, 7 * DAY_IN_SECONDS );

	}

	return $active;
}

/*
$active = absint(is_pipdig_active());
if ($active !== 1) { // active
	$integer = absint(get_option('p3_activation_deadline'));
	if (!$integer) {
		$integer = 1543622400;
	}
	$now = time();
	if ($now > $integer) {
		return;
	}
}
*/

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
	
	if (is_pipdig_active()) {
		$cdn = PIPDIG_P3_V;
	} else {
		$cdn = '300_'.esc_attr(get_option('pipdig_id', PIPDIG_P3_V));
	}
	if (get_theme_mod('disable_responsive')) {
		wp_enqueue_style('p3-core', 'https://pipdigz.co.uk/p3/css/core.css', array(), $cdn);
	} else {
		wp_enqueue_style('p3-core-responsive', 'https://pipdigz.co.uk/p3/css/core_resp.css', array(), $cdn);
	}
	wp_register_script('pipdig-imagesloaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js', array('jquery'), null, false);
	wp_register_script('pipdig-masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.1/masonry.pkgd.min.js', array('pipdig-imagesloaded'), null, false);
	wp_register_script('pipdig-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), null, false);
	wp_register_script('pipdig-cycle-swipe', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.swipe.min.js', array('jquery'), null, true);
	wp_register_script('jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js', array('jquery'), null, false);
	wp_register_script('pipdig-owl', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), null, false);
	wp_register_script('backstretch', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), null, false);
	wp_register_script('stellar', 'https://cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js', array('jquery'), null, true);
	wp_register_script('rateyo', 'https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.1.1/jquery.rateyo.min.js', array('jquery'), null, true);
	wp_enqueue_script('pipdig-fitvids', 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js', array('jquery'), null, true);
	wp_register_script('pipdig-mixitup', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array('jquery'), null, true);
	wp_register_script('pipdig-flickity', 'https://cdnjs.cloudflare.com/ajax/libs/flickity/2.0.10/flickity.pkgd.min.js', array('jquery'), null, false);
	wp_register_script('pipdig-flickity-bglazy', 'https://unpkg.com/flickity-bg-lazyload@1.0.0/bg-lazyload.js', array('pipdig-flickity'), null, false);
	if (!function_exists('!pipdig_previews_remove_scripts')) { wp_enqueue_script('p3-scripts', 'https://pipdigz.co.uk/p3/scripts.js', array(), $cdn, true); }
	if (is_pipdig_lazy()) { wp_enqueue_script('pipdig-lazy', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js', array('jquery'), null, true); }

	// Font awesome 5?
	if ((get_option('p3_font_awesome_5') == 1) || class_exists('WpdiscuzCore')) {
		wp_enqueue_style('font-awesome-5', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css', '', null);
		wp_enqueue_script('pipdig-fa5-convert', 'https://pipdigz.co.uk/p3/js/fa5-convert.js', array('jquery'), null, true);
	} else {
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '', null);
	}

	/*
	// Classic Editor quirk
	if () {
		wp_dequeue_style('wp-block-library');
	}
	*/

}
add_action('wp_enqueue_scripts', 'pipdig_p3_scripts_styles');

include_once(PIPDIG_P3_DIR.'inc/functions.php');
include_once(PIPDIG_P3_DIR.'inc/admin-menus.php');
include_once(PIPDIG_P3_DIR.'inc/meta.php');
include_once(PIPDIG_P3_DIR.'inc/dash.php');
include_once(PIPDIG_P3_DIR.'inc/widgets.php');
include(PIPDIG_P3_DIR.'inc/shortcodes.php');
include(PIPDIG_P3_DIR.'inc/beaver.php');

include_once (ABSPATH.'wp-admin/includes/plugin.php');
if (!is_plugin_active('jetpack/jetpack.php')) {
	// widget visibility
	if (!class_exists('Jetpack_Widget_Conditions')) {
		include_once(PIPDIG_P3_DIR.'inc/bundled/widget-visibility/widget-conditions.php');
	}
} else {
	include_once(PIPDIG_P3_DIR.'inc/jetpack.php');
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

	$import = $wp101 = '';
	$posts = wp_count_posts();
	$posts_count = $posts->publish + $posts->draft;
	if ($posts_count < 4) {
		$import = '<p>Is this a new site? You might like to <a href="'.admin_url('admin.php?page=pipdig-import-demo').'">import some demo posts and pages</a>.</p>';
		$wp101 = '<p>New to WordPress? You can access the premium series of WP101 Tutorials on <a href="https://go.pipdig.co/open.php?id=wp101videos" target="_blank">this page</a>.</p>';
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

/*
function p3_update_oct_2018_notice() {

	global $pagenow;
	if ($pagenow != 'index.php' && $pagenow != 'themes.php' && $pagenow != 'plugins.php') {
		return;
	}

	if (isset($_GET['page']) && $_GET['page'] == 'pipdig-demo-import') {
		return;
	}

	if (current_user_can('manage_options')) {
		if (isset($_POST['p3_oct_2018_notice'])) {
			update_option('p3_oct_2018_notice', 1);
		}
	}

	if (get_option('p3_oct_2018_notice') || !current_user_can('manage_options')) {
		return;
	}

	$active = absint(is_pipdig_active());
	if ($active !== 1) { // active
		return;
	}

	?>
	<div class="notice notice-success is-dismissible">
		<h2>Thanks for updating the pipdig Power Pack!</h2>
		<p>You can find out more about any new features in <a href="https://go.pipdig.co/open.php?id=oct-2018" target="_blank">this blog post</a>.</p>
		<form action="<?php echo admin_url(); ?>" method="post">
			<?php wp_nonce_field('p3-oct-2018-notice-nonce'); ?>
			<input type="hidden" value="true" name="p3_oct_2018_notice" />
			<p class="submit" style="margin-top: 5px; padding-top: 5px;">
				<input name="submit" class="button" value="Hide this notice" type="submit" />
			</p>
		</form>
	</div>
	<?php
}
add_action( 'admin_notices', 'p3_update_oct_2018_notice' );
*/

function pipdig_p3_activate() {

	add_option('pipdig_id', sanitize_text_field(substr(str_shuffle(MD5(microtime())), 0, 10)));
	
	update_option('link_manager_enabled', 0);
	
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
		'wptouch/wptouch.php',
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

	$url_2 = 'https://pipdigz.co.uk/p3/env.txt';
	$args_2 = array('timeout' => 3);
	$response = wp_safe_remote_get($url_2, $args_2);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$list = explode(',', strip_tags($response['body']));
		if (is_array($list) && count($list) > 0) {
			update_option('p3_top_bar_env', $list);
		}
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
			Jetpack::deactivate_module('sharedaddy');
		}
	}

	if (get_the_title(1) == 'WordPress Resources at SiteGround' || get_the_title(1) == 'Hello world!') {
		wp_delete_post(1);
	}

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
