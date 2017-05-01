<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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

// remove default gallery shortcode styling
//add_filter( 'use_default_gallery_style', '__return_false' );

if ( !function_exists( 'pipdig_strip' ) ) {
	function pipdig_strip($data, $tags = '') {
		return strip_tags(trim($data), $tags);
	}
}

// check if this feature is enabled for this theme
// any enabled themes are passed in via array
function p3_theme_enabled($enabled_themes) {
	$this_theme = get_option('pipdig_theme');
	foreach($enabled_themes as $enabled_theme) {
		if ($this_theme == $enabled_theme) {
			return 1;
		} 
	}
	return 0;
}

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
		
		$first_img = esc_url($matches[1][0]);
		
		if (($first_img == 'http://assets.rewardstyle.com/images/search/350.gif') || ($first_img == '//assets.rewardstyle.com/images/search/350.gif')) {
			return $default_img;
		}
		
		return $first_img;
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
/*
if (!function_exists('pipdig_p3_dns_prefetch')) {
	function pipdig_p3_dns_prefetch() {
		?>
		<link rel="dns-prefetch" href="//ajax.googleapis.com" />
		<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
		<?php
	}
	add_action('wp_head', 'pipdig_p3_dns_prefetch', 1, 1);
}
*/

// use public CDNs for jquery
/*
if (!class_exists('JCP_UseGoogleLibraries') && !function_exists('pipdig_p3_cdn')) {
	function pipdig_p3_cdn() {
		global $wp_scripts;
		if (!is_admin()) {
			$jquery_ver = $wp_scripts->registered['jquery']->ver;
			$jquery_migrate_ver = $wp_scripts->registered['jquery-migrate']->ver;
			wp_deregister_script('jquery');
			wp_deregister_script('jquery-migrate');
			wp_enqueue_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/'.$jquery_ver.'/jquery.min.js', false, null, false);
			wp_enqueue_script('jquery-migrate', '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'.$jquery_migrate_ver.'/jquery-migrate.min.js', false, null, false);
		}
	}
	add_action('wp_enqueue_scripts', 'pipdig_p3_cdn', 9999);
}
*/


include('functions/api.php');

// Add Featured Image to feed if using excerpt mode, or just add the full content if not
if (!class_exists('Rss_Image_Feed') && !function_exists('pipdig_rss_post_thumbnail')) {
	function pipdig_p3_rss_post_thumbnail($content) {
		
		if (get_option('rss_use_excerpt')) {
			
			global $post;
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			if ($thumb) {
				$bg = esc_url($thumb['0']);
			} else {
				$bg = pipdig_p3_catch_that_image();
			}
			$content = '<p><img src="'.$bg.'" alt="'.esc_attr($post->post_title).'" style="max-width:100%;height:auto;"/></p><p>'.get_the_excerpt().'</p>';

		}

		return strip_shortcodes($content);
		
	}
	add_filter('the_excerpt_rss', 'pipdig_p3_rss_post_thumbnail');
	add_filter('the_content_feed', 'pipdig_p3_rss_post_thumbnail');
}


function p3_flush_htacess() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function p3_htaccess_edit($rules) {
$p3_rules = "
# p3
Redirect 301 /feeds/posts/default /feed

<ifmodule mod_deflate.c>
AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript text/javascript
</ifmodule>

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{QUERY_STRING} ^m=1$
RewriteRule ^(.*)$ /$1? [R=301,L]
</IfModule>
# /p3

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
				$("#adhesion_desktop_wrapper,#cookie-law-bar,#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box,#at4-whatsnext,#cookie-notice,.mailmunch-topbar,#cookieChoiceInfo,.sumome-scrollbox-popup,.tplis-cl-cookies,#eu-cookie,.pea_cook_wrapper,#milotree_box").css('opacity', '0').css('visibility', 'hidden');
			 } else {
				$("#adhesion_desktop_wrapper,#cookie-law-bar,#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box,#at4-whatsnext,#cookie-notice,.mailmunch-topbar,#cookieChoiceInfo,.sumome-scrollbox-popup,.tplis-cl-cookies,#eu-cookie,.pea_cook_wrapper,#milotree_box").css('opacity', '1').css('visibility', 'visible');
			 }
		});
	});
	</script>
	<!-- p3 v<?php echo PIPDIG_P3_V; ?> | <?php echo wp_get_theme()->get('Version'); ?> | <?php echo PHP_VERSION; ?> -->
	<?php
}
add_action('wp_footer','pipdig_p3_emmmm_heeey', 9999);

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
				if (get_locale() == 'pl_PL') {
					$comments_text = 'Komentarzy: '.number_format_i18n($comment_count);
				}
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

// allow 'text-transorm' in wp_kses http://wordpress.stackexchange.com/questions/173526/why-is-wp-kses-not-keeping-style-attributes-as-expected
function p3_safe_styles($styles) {
	array_push($styles, 'text-transform');
	return $styles;
}
add_filter('safe_style_css','p3_safe_styles');


// get image ID from url - https://wpscholar.com/blog/get-attachment-id-from-wp-image-url/
function pipdig_get_attachment_id( $url ) {

	$attachment_id = 0;
	$dir = wp_upload_dir();

	if ( false !== strpos($url, $dir['baseurl'] . '/') ) { // Is URL in uploads directory?

		$file = basename($url);

		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);

		$query = new WP_Query($query_args);

		if ( $query->have_posts() ) {

			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file = basename($meta['file']);
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array($file, $cropped_image_files) ) {
					$attachment_id = $post_id;
					break;
				}
			}

		}

	}

	return $attachment_id;
}

// no pages in search
function p3_no_pages_search($query) {
	if (is_admin()) {
		return;
	}
	if ($query->is_search) {
	$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts', 'p3_no_pages_search');


include('functions/social-sidebar.php');
include('functions/full_screen_landing_image.php');
include('functions/top_menu_bar.php');
include('functions/post-options.php');
include('functions/shares.php');
include('functions/related-posts.php');
include('functions/instagram.php');
include('functions/youtube.php');
include('functions/pinterest.php');
include('functions/pinterest_hover.php');
include('functions/social_footer.php');
include('functions/navbar_icons.php');
include('functions/feature_header.php');
include('functions/trending.php');
include('functions/post_slider_site_main_width.php');
//include('functions/post_slider_site_main_width_sq.php');
include('functions/post_slider_posts_column.php');
include('functions/width_customizer.php');
//include('functions/popup.php');
include('functions/featured_cats.php');
include('functions/featured_panels.php');

include('functions/schema.php');

// bundled
include_once('bundled/mb-settings-page/mb-settings-page.php');
include_once('bundled/meta-box-include-exclude/meta-box-include-exclude.php');
include_once('bundled/mb-term-meta/mb-term-meta.php');
//include_once('bundled/customizer-reset/customizer-reset.php');