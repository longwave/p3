<?php
/*
Plugin Name: pipdig Power Pack (p3)
Plugin URI: http://pipdig.co
Description: The core functions and features of any pipdig theme.
Author: pipdig
Author URI: http://pipdig.co
Version: 1.2.0
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

// load image catch function, just in case theme hasn't
if (!function_exists('pipdig_catch_that_image')) {
	function pipdig_catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(empty($output)){
			return;
		}
		$first_img = $matches [1] [0];
		return $first_img;
	}
}

require_once('inc/admin-menus.php');

// functions
//require_once('inc/functions.php');

// customizer
//require_once('inc/customizer.php');

// cron functions
require_once('inc/cron.php');


//widgets
require_once('inc/widgets.php');



function pipdig_p3_emmmm_heeey() {
	?>
	<script>	
	jQuery(document).ready(function($) {
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			   $("#cookie-law-info-bar,.cc_container").slideUp();
		   } else {
			   $("#cookie-law-info-bar,.cc_container").slideDown()
		   }
		});
	});
	</script>
	<?php
}
add_action('wp_footer','pipdig_p3_emmmm_heeey');

// get rid of some bad jetpack smells
function pipdig_p3_kill_jetpack_modules( $modules, $min_version, $max_version ) {
        $jp_mods_to_disable = array(
        // 'shortcodes',
        // 'widget-visibility',
        // 'contact-form',
        // 'shortlinks',
         'infinite-scroll',
        // 'wpcc',
         'tiled-gallery',
         'json-api',
        // 'publicize',
        // 'vaultpress',
        // 'custom-css',
         'post-by-email',
        // 'widgets',
        // 'comments',
         'minileven',
         'latex',
         'gravatar-hovercards',
        // 'enhanced-distribution',
        // 'notes',
        // 'subscriptions',
        // 'stats',
        // 'after-the-deadline',
        // 'carousel',
         'photon',
         'sharedaddy',
         'omnisearch',
         'mobile-push',
        // 'likes',
        // 'videopress',
        // 'gplus-authorship',
        // 'sso',
         'monitor',
         'markdown',
        // 'manage',
        // 'verification-tools',
         'related-posts',
        // 'custom-content-types',
         'site-icon',
        // 'protect',
    );
    foreach ( $jp_mods_to_disable as $mod ) {
        if ( isset( $modules[$mod] ) ) {
            unset( $modules[$mod] );
        }
    }
    return $modules;
}
add_filter( 'jetpack_get_available_modules', 'pipdig_p3_kill_jetpack_modules', 20, 3 );

// remove cruddy jetpack widgets
function pipdig_p3_jetpack() {
	remove_action('widgets_init', 'jetpack_facebook_likebox_init');
	remove_action('widgets_init', 'wpcom_social_media_icons_widget_load_widget');
	remove_action('widgets_init', 'jetpack_top_posts_widget_init');
	remove_action('widgets_init', 'jetpack_display_posts_widget');
}
add_action('jetpack_modules_loaded','pipdig_p3_jetpack');


function pipdig_p3_plugins_loaded() {
	remove_action( 'admin_menu', 'mm_main_menu' ); // remove mojo menu
	remove_action('widgets_init', 'mm_register_widget'); // remove mojo widget
	remove_action( 'admin_head-themes.php', 'mm_add_theme_button' ); // remove mojo theme menu item
	remove_action( 'admin_menu', 'mm_add_theme_page' ); // remove mojo themes link
	add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' ); // replace themes link...
}
add_action('plugins_loaded','pipdig_p3_plugins_loaded');

function pipdig_p3_themes_top_link() {
	if(!isset($_GET['page'])) {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.add-new-h2').before('<a class="add-new-h2" href="http://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig Themes</a>');
	});
	</script>
	<?php
	}
}

// updates
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 (
	'https://dl.dropboxusercontent.com/u/904435/updates/wordpress/plugins/p3.json',
	__FILE__,
	'p3'
);



?>