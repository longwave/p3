<?php

if (!defined('ABSPATH')) {
	exit;
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



/*
if (!function_exists('pipdig_p3_mobile_detect')) {
	function pipdig_p3_mobile_detect() {
		if (!get_theme_mod('disable_responsive')) { // Check if responsive layout has been disabled in cust. If so, let's continue:
			if (pipdig_plugin_check('wp-super-cache/wp-cache.php') || pipdig_plugin_check('w3-total-cache/w3-total-cache.php') || pipdig_plugin_check('quick-cache/quick-cache.php') || pipdig_plugin_check('wp-fastest-cache/wpFastestCache.php') || pipdig_plugin_check('hyper-cache/plugin.php')) {
				// If there is a cache plugin active, let's jump ship:
				return false;
			} else {
				// No obvious cache plugin, so let's check if it's a mobile:
				require_once(dirname(__FILE__).'/third/Mobile_Detect.php');
				$detect = new Mobile_Detect();
				if($detect->isMobile() && !$detect->isTablet()) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}
}
*/

// add data rel for lightbox (still in theme functions)
/*
if (!function_exists('p3_lightbox_rel')) {
	function p3_lightbox_rel($content) {
		$content = str_replace('><img',' data-imagelightbox="g"><img', $content);
		return $content;
	}
	add_filter('the_content','p3_lightbox_rel');
}
*/

// load image catch function, just in case theme hasn't
if (!function_exists('pipdig_p3_catch_that_image')) {
	function pipdig_p3_catch_that_image() {
		global $post, $posts;
		$first_img = '';
		$default_img = 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		
		if(empty($output)){
			return $default_img;
		}
		
		$first_img = $matches [1] [0];
		
		if (($first_img == 'http://assets.rewardstyle.com/images/search/350.gif') || ($first_img == '//assets.rewardstyle.com/images/search/350.gif')) {
			return $default_img;
		}
		
		return esc_url($first_img);
	}
}

// truncate stuff
if (!function_exists('pipdig_p3_truncate')) {
	function pipdig_p3_truncate($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]).'&hellip;';
		}
		return $text;
	}
}

// dns prefetch
if (!function_exists('pipdig_p3_dns_prefetch')) {
	function pipdig_p3_dns_prefetch() {
		?>
		<link rel="dns-prefetch" href="//ajax.googleapis.com" />
		<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
		<?php
	}
	add_action('wp_head', 'pipdig_p3_dns_prefetch', 1, 1);
}


// use public CDNs for jquery
if (!class_exists('JCP_UseGoogleLibraries') && !function_exists('pipdig_p3_cdn')) {
	function pipdig_p3_cdn() {
		global $wp_scripts;
		if (!is_admin()) {
			$jquery_ver = $wp_scripts->registered['jquery']->ver;
			$jquery_migrate_ver = $wp_scripts->registered['jquery-migrate']->ver;
			wp_deregister_script('jquery');
			wp_deregister_script('jquery-migrate');
			wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/'.$jquery_ver.'/jquery.min.js', false, null, false);
			wp_enqueue_script('jquery-migrate', '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'.$jquery_migrate_ver.'/jquery-migrate.min.js', false, null, false);
		}
	}
	add_action('wp_enqueue_scripts', 'pipdig_p3_cdn', 9999);
}

include_once('functions/scrapey-scrapes.php');


// Add Featured Image to feed if using excerpt mode, or just add the full content if not
if (!function_exists('pipdig_rss_post_thumbnail')) {
	function pipdig_p3_rss_post_thumbnail($content) {
		
		if (get_option('rss_use_excerpt')) {
			global $post;
			if(has_post_thumbnail($post->ID)) {
				$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . get_the_excerpt();
			} elseif (pipdig_p3_catch_that_image()) {
				$content = '<p><img src="'.pipdig_p3_catch_that_image().'" alt=""/></p>' . get_the_excerpt();
			} else {
				$content = get_the_content();
			}
		} else {
			$content = get_the_content();
		}

		return $content;
	}
	add_filter('the_excerpt_rss', 'pipdig_p3_rss_post_thumbnail');
	add_filter('the_content_feed', 'pipdig_p3_rss_post_thumbnail');
}


// remove bad mojo
if (function_exists('mm_load_updater')) {
	function pipdig_p3_bad_mojo() {
		remove_action( 'admin_menu', 'mm_main_menu' ); // remove mojo menu
		remove_action( 'widgets_init', 'mm_register_widget' ); // remove mojo widget
		remove_action( 'admin_head-themes.php', 'mm_add_theme_button' ); // remove mojo theme menu item
		remove_action( 'admin_menu', 'mm_add_theme_page' ); // remove mojo themes link
	}
	add_action('plugins_loaded','pipdig_p3_bad_mojo', 11);
	
}



// add pipdig link to themes section
function pipdig_p3_themes_top_link() {
	if(!isset($_GET['page'])) {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.page-title-action').before('<a class="add-new-h2" href="http://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig.co <?php _e('Themes', 'p3'); ?></a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' );


function pipdig_p3_kill_jetpack_modules( $modules, $min_version, $max_version ) {
	$jp_mods_to_disable = array(
	// 'shortcodes',
	// 'widget-visibility',
	// 'contact-form',
	// 'shortlinks',
	'infinite-scroll',
	// 'wpcc',
	//'tiled-gallery',
	//'json-api',
	// 'publicize',
	// 'vaultpress',
	'custom-css',
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
	//'sharedaddy',
	'omnisearch',
	'mobile-push',
	// 'likes',
	// 'videopress',
	// 'sso',
	// 'monitor',
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

// Heartbeat rate
if ( !function_exists( 'heartbeat_control_menu' ) ) {
	function pipdig_p3_heartbeat_settings( $settings ) {
		$settings['interval'] = 60; // anything between 15-60
		return $settings;
	}
	add_filter( 'heartbeat_settings', 'pipdig_p3_heartbeat_settings' );
}


// hide tabs on social count plus
/*
if (pipdig_plugin_check('social-count-plus/social-count-plus.php')) {
	function hide_complex_tabs_social_count_plus() {
		$screen = get_current_screen();
		if (is_object($screen) && $screen->id == 'settings_page_social-count-plus') {
			echo '<style>.nav-tab-wrapper{display:none!important}</style>';
		}
	}
	add_action('admin_footer', 'hide_complex_tabs_social_count_plus');
}
*/

function p3_flush_htacess() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function p3_htaccess_edit($rules) {
$p3_rules = "
# p3 gzip
<ifmodule mod_deflate.c>
AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript text/javascript
</ifmodule>
# /p3 gzip

# p3 Blogger
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{QUERY_STRING} ^m=1$
RewriteRule ^(.*)$ /$1? [R=301,L]
</IfModule>
# /p3 Blogger

";
return $p3_rules . $rules;
}
add_filter('mod_rewrite_rules', 'p3_htaccess_edit');


function pipdig_p3_emmmm_heeey() {
	?>
	<script>	
	jQuery(document).ready(function($) {
		$(window).scroll(function() {
			 if($(window).scrollTop() + $(window).height() == $(document).height()) {
				$("#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box").slideUp();
			 } else {
				$("#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box").slideDown()
			 }
		});
	});
	</script>
	<!-- p3 v<?php echo PIPDIG_P3_V; ?> | <?php echo PHP_VERSION; ?> -->
	<?php
}
add_action('wp_footer','pipdig_p3_emmmm_heeey', 99);

// comments count
if (!function_exists('pipdig_p3_comment_count')) {
	function pipdig_p3_comment_count() {
		if (!post_password_required()) {
			$comment_count = get_comments_number();
			if ($comment_count == 0) {
				$comments_text = __('Leave a comment', 'p3');
			} elseif ($comment_count == 1) {
				$comments_text = __('1 Comment', 'p3');
			} else {
				$comments_text = number_format_i18n($comment_count).' '.__('Comments', 'p3');
			}
			echo $comments_text;
		}
	}
}

// comments nav
if (!function_exists('pipdig_p3_comment_nav')) {
	function pipdig_p3_comment_nav() {
		echo '<div class="nav-previous">'.previous_comments_link('<i class="fa fa-arrow-left"></i> '.__('Older Comments', 'p3')).'</div>';
		echo '<div class="nav-next">'.next_comments_link(__('Newer Comments', 'p3').' <i class="fa fa-arrow-right"></i>').'</div>';
	}
}

// depreciate this after 4.3+
/*
function pipdig_p3_favicon() {
	$output = '';
	$favicon = esc_url(get_theme_mod('pipdig_favicon'));
	if($favicon) {
		$output = '<link rel="shortcut icon" href="'.$favicon.'" />';
	}
	echo $output;
}
add_action('wp_head','pipdig_p3_favicon', 2);
*/

//include_once('functions/favicon.php');
include_once('functions/top_menu_bar.php');
include_once('functions/post-options.php');
include_once('functions/shares.php');
include_once('functions/related-posts.php');
//include_once('functions/smash.php');
include_once('functions/pinterest_hover.php');
include_once('functions/instagram.php');
include_once('functions/social_footer.php');
include_once('functions/navbar_icons.php');
include_once('functions/feature_header.php');
include_once('functions/trending.php');
include_once('functions/post_slider_site_main_width.php');
//include_once('functions/post_slider_site_main_width_sq.php');
include_once('functions/post_slider_posts_column.php');
include_once('functions/width_customizer.php');

// bundled
include_once('bundled/customizer-reset.php');
//include_once('bundled/simple-custom-css/simple-custom-css.php');