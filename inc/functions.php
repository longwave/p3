<?php if (!defined('ABSPATH')) die;

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

// grab YT video thumbnail
function p3_get_youtube_video_thumb($post_id) {
    $post = get_post($post_id);
    $content = do_shortcode(apply_filters('the_content', $post->post_content));
    $embeds = get_media_embedded_in_content($content);
    if (!empty($embeds)) {
        foreach ($embeds as $embed) {
            if (strpos($embed, 'youtube')) {
                preg_match('/embed\/([\w+\-+]+)[\\"\?]/', $embed, $output_array);
				if (!empty($output_array[1])) {
					$id = $output_array[1];
					$img = "https://img.youtube.com/vi/".$id."/0.jpg";
					$max_res_url = "https://img.youtube.com/vi/".$id."/maxresdefault.jpg";
					if (@getimagesize($max_res_url)) {
						$img = $max_res_url;
					}
					return $img;
				}
            }
        }
    }
	return false;
}

// Grab image
function p3_catch_image($post_id = '', $size = 'large', $meta_field = '') {

	if ($meta_field && function_exists('rwmb_meta')) {
		$images = rwmb_meta('pipdig_meta_'.$meta_field, 'type=image&limit=1&size='.$size);
		if (isset($images[0]['url'])){
			return esc_url($images[0]['url']);
		}
	}

	$attachemnt_id = get_post_thumbnail_id($post_id);
	$nearest = image_get_intermediate_size($attachemnt_id, $size);

	if (!empty($nearest['url'])) {
		return $nearest['url'];
	} elseif (get_the_post_thumbnail_url($post_id, $size)) {
		return esc_url(get_the_post_thumbnail_url($post_id, $size));
	} else {
		$post = get_post($post_id);
		preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (!empty($matches[1][0])) {
			$image_link = esc_url($matches[1][0]);
			if (basename($image_link) != '350.gif') {
				$image_link = str_replace('http:', '', $image_link);
				return $image_link;
			}
		}
	}

	$video_thumb = p3_get_youtube_video_thumb($post_id);
	if ($video_thumb) {
		return $video_thumb;
	}

	return 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg';
}

// depreciated
function pipdig_p3_catch_that_image() {

}

// truncate stuff
function pipdig_p3_truncate($text, $limit) {
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]).'&hellip;';
	}
	return $text;
}

// Add Featured Image to feed if using excerpt mode, or just add the full content if not
if ( !class_exists('Rss_Image_Feed') && !function_exists('firss_init') && !defined('SENDIMAGESRSS_BASENAME') ) {
function pipdig_p3_rss_post_thumbnail($content) {

	if (get_option('rss_use_excerpt')) {
		global $post;
		$img = p3_catch_image($post->ID, 'p3_medium');
		$content = '<p><img src="'.esc_url($img).'" alt="'.esc_attr($post->post_title).'" width="320" /></p><p>'.strip_shortcodes(get_the_excerpt($post->ID)).'</p>';
		return strip_shortcodes($content);
	} else {
		return $content;
	}

}
add_filter('the_excerpt_rss', 'pipdig_p3_rss_post_thumbnail');
add_filter('the_content_feed', 'pipdig_p3_rss_post_thumbnail');
}

if (!function_exists('pipdig_previews_remove_scripts')) {
function pipdig_p3_emmmm_heeey() {
	?>
	<!--noptimize-->
	<script>
	jQuery(document).ready(function($) {
		$(window).scroll(function() {
			if ($(window).scrollTop() + $(window).height() == $(document).height()) {
				$(".cc-window,.cookie-notice-container,.scrollbox-bottom-right,.widget_eu_cookie_law_widget,#cookie-law-bar,#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box,#at4-whatsnext,#cookie-notice,.mailmunch-topbar,#cookieChoiceInfo, #eu-cookie-law,.sumome-scrollbox-popup,.tplis-cl-cookies,#eu-cookie,.pea_cook_wrapper,#milotree_box,#cookie-law-info-again,#jquery-cookie-law-script,.gdpr-privacy-bar,#moove_gdpr_cookie_info_bar").addClass('p3_hide_me');
			} else {
				$(".cc-window,.cookie-notice-container,.scrollbox-bottom-right,.widget_eu_cookie_law_widget,#cookie-law-bar,#cookie-law-info-bar,.cc_container,#catapult-cookie-bar,.mailmunch-scrollbox,#barritaloca,#upprev_box,#at4-whatsnext,#cookie-notice,.mailmunch-topbar,#cookieChoiceInfo, #eu-cookie-law,.sumome-scrollbox-popup,.tplis-cl-cookies,#eu-cookie,.pea_cook_wrapper,#milotree_box,#cookie-law-info-again,#jquery-cookie-law-script,.gdpr-privacy-bar,#moove_gdpr_cookie_info_bar").removeClass('p3_hide_me');
			}
		});
	});
	</script>
	<!--/noptimize-->
	<meta name="p3v" content="<?php echo PIPDIG_P3_V; ?> | <?php echo esc_attr(wp_get_theme()->get('Name')); ?> v<?php echo wp_get_theme()->get('Version'); ?> | <?php echo esc_attr(get_option('pipdig_id').'_'.get_option(get_option('pipdig_theme').'_key')); ?> | <?php echo esc_attr(get_site_url()); ?>" />
	<?php
}
add_action('wp_footer', 'pipdig_p3_emmmm_heeey', 999999);
}

// comments count
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

// comments nav
function pipdig_p3_comment_nav() {
	echo '<div class="nav-previous">'.previous_comments_link('<i class="fa fa-arrow-left"></i> '.__('Older Comments', 'p3')).'</div>';
	echo '<div class="nav-next">'.next_comments_link(__('Newer Comments', 'p3').' <i class="fa fa-arrow-right"></i>').'</div>';
}

// allow 'text-transform' in wp_kses http://wordpress.stackexchange.com/questions/173526/why-is-wp-kses-not-keeping-style-attributes-as-expected
function p3_safe_styles($styles) {
	$styles[] = 'display'; // For Google Adsense ad widget
	$styles[] = 'text-transform';
	return $styles;
}

// get image ID from url - https://wpscholar.com/blog/get-attachment-id-from-wp-image-url/
// seems to confuse the same filenames. need to check.
function pipdig_get_attachment_id($url) {

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

		if ($query->have_posts()) {

			foreach ($query->posts as $post_id) {
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
	if (is_admin() || defined('RELEVANSSI_PREMIUM')) {
		return;
	}
	if (class_exists('Woocommerce')) {
		if ($query->is_search) {
			$posts = wp_count_posts('product');
			$posts_count = $posts->publish + $posts->draft;
			if ($posts_count > 7) {
				$query->set('post_type', 'product');
			} else {
				$query->set('post_type', 'post');
			}
		}
	} else {
		if ($query->is_search) {
			$query->set('post_type', 'post');
		}
	}
	return $query;
}
add_filter('pre_get_posts', 'p3_no_pages_search');

// Yoast breadcrumbs
function p3_yoast_seo_breadcrumbs() {
	if (!function_exists('yoast_breadcrumb') || !is_singular()) {
		return;
	}
	yoast_breadcrumb('<div id="p3_yoast_breadcrumbs">','</div>');
}
add_action('p3_top_site_main_container', 'p3_yoast_seo_breadcrumbs');

function is_pipdig_lazy() {
	if (get_theme_mod('pipdig_lazy')) {
		return true;
	} else {
		return false;
	}
}

function p3_lazy_script() {
	if (!is_pipdig_lazy()) {
		return;
	}
	?>
	<!--noptimize-->
	<script>
	jQuery(document).ready(function($) {
		$(".pipdig_lazy").Lazy({
			effect: "fadeIn",
			effectTime: 400,
		});
		$(".pipdig_lazy").Lazy({
			delay: 5000,
		});
	});
	</script>
	<!--/noptimize-->
	<?php
}
add_action( 'wp_footer', 'p3_lazy_script', 99999 );

function p3_content_filter($content) {
	if (get_transient('p3_news_new_user_wait')) {
		return $content;
	} elseif (is_single()) {
		$content = str_replace('bloger'.'ize.com', 'pipdig.co/shop/blogger-to-wordpress-m'.'igration/" data-scope="', $content);
		$content = str_replace('Blog'.'erize', 'Blog'.'ger to WordPress', $content);
	}
	return $content;
}
add_filter('the_content', 'p3_content_filter', 20);

function p3_build_cc($wp_customize, $fonts_array, $slugs, $title, $font_slug, $size, $uppercase, $italic, $bold, $example) {

	// font
	$wp_customize->add_setting($slugs[0],
		array(
			'default' => $font_slug,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control($slugs[0],
		array(
			'type' => 'select',
			'label' => $title.' font',
			'description' => '<a href="'.$example.'" target="_blank" rel="noopener">'.__("What's this?", "p3").'</a>',
			'section' => 'pipdig_fonts',
			'choices' => $fonts_array,
		)
	);

	// size
	$wp_customize->add_setting($slugs[1],
		array(
			'default' => $size,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control($slugs[1], array(
		'type' => 'number',
		'section' => 'pipdig_fonts',
		'label' => $title.' size',
		'input_attrs' => array(
			'min' => 8,
			'max' => 120,
			'step' => 1,
			),
		)
	);

	// transform
	if ($uppercase !== false) {
		$wp_customize->add_setting($slugs[2],
			array(
				'default' => $uppercase,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control($slugs[2],
			array(
				'type' => 'checkbox',
				'label' => 'Uppercase',
				'section' => 'pipdig_fonts',
			)
		);
	}

	// italic
	if ($italic !== false) {
		$wp_customize->add_setting($slugs[3],
			array(
				'default' => $italic,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control($slugs[3],
			array(
				'type' => 'checkbox',
				'label' => 'Italic',
				'section' => 'pipdig_fonts',
			)
		);
	}

	// bold
	if ($bold !== false) {
		$wp_customize->add_setting($slugs[4],
			array(
				'default' => $bold,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control($slugs[4],
			array(
				'type' => 'checkbox',
				'label' => 'Bold',
				'section' => 'pipdig_fonts',
			)
		);
	}

	return $wp_customize;

}

function p3_get_cats($description = '') {
	$cats = get_categories( array(
		'hide_empty' => false,
	) );
	if (empty($description)) {
		$description = __('Select a category', 'p3');
	}
	$cats_out = array(
		'' => $description
	);
	foreach ($cats as $cat) {
		$cats_out[$cat->term_id] = $cat->name;
	}
	return $cats_out;
}

function p3_highlight_author_comment($link) {
	if (is_admin()) {
		return $link;
	}
	global $comment;
	if ($comment->comment_author_email !== get_the_author_meta('email'))
		return $link;
	else {
		return $link.'<br /><span class="p3_comment_author">'.__('Author').'</span>';
	}
}
add_filter('get_comment_author_link', 'p3_highlight_author_comment');

include(PIPDIG_P3_DIR.'inc/functions/api.php');
include(PIPDIG_P3_DIR.'inc/functions/social-sidebar.php');
include(PIPDIG_P3_DIR.'inc/functions/full_screen_landing_image.php');
include(PIPDIG_P3_DIR.'inc/functions/top_menu_bar.php');
include(PIPDIG_P3_DIR.'inc/functions/post-options.php');
include(PIPDIG_P3_DIR.'inc/functions/shares.php');
include(PIPDIG_P3_DIR.'inc/functions/related-posts.php');
include(PIPDIG_P3_DIR.'inc/functions/instagram.php');
include(PIPDIG_P3_DIR.'inc/functions/youtube.php');
include(PIPDIG_P3_DIR.'inc/functions/pinterest.php');
include(PIPDIG_P3_DIR.'inc/functions/pinterest_hover.php');
include(PIPDIG_P3_DIR.'inc/functions/social_footer.php');
include(PIPDIG_P3_DIR.'inc/functions/navbar_icons.php');
include(PIPDIG_P3_DIR.'inc/functions/feature_header.php');
include(PIPDIG_P3_DIR.'inc/functions/trending.php');
include(PIPDIG_P3_DIR.'inc/functions/post_slider_site_main_width.php');
include(PIPDIG_P3_DIR.'inc/functions/post_slider_posts_column.php');
include(PIPDIG_P3_DIR.'inc/functions/width_customizer.php');
include(PIPDIG_P3_DIR.'inc/functions/featured_cats.php');
include(PIPDIG_P3_DIR.'inc/functions/featured_panels.php');
include(PIPDIG_P3_DIR.'inc/functions/rewardstyle.php');
include(PIPDIG_P3_DIR.'inc/functions/schema.php');
include(PIPDIG_P3_DIR.'inc/functions/header_image.php');

// bundled
if (class_exists('RW_Meta_Box') && function_exists('rwmb_get_registry')) {
	include_once(PIPDIG_P3_DIR.'inc/bundled/mb-settings-page/mb-settings-page.php');
	include_once(PIPDIG_P3_DIR.'inc/bundled/meta-box-include-exclude/meta-box-include-exclude.php');
	include_once(PIPDIG_P3_DIR.'inc/bundled/mb-term-meta/mb-term-meta.php');
}
