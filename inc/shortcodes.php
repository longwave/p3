<?php if (!defined('ABSPATH')) die;

include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_left_right.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_stars.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_mosaic.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_portfolio.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_image_overlay.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_image_side.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_social_icons.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_category_section.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_banner.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_youtube_slider.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_total_followers.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_instagram_feed.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_padded_text.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_code.php');
include(PIPDIG_P3_DIR.'inc/shortcodes/pipdig_button.php');


// stop wpautop on shortcodes http://stackoverflow.com/questions/5940854/disable-automatic-formatting-inside-wordpress-shortcodes
//remove_filter('the_content', 'wpautop');
//add_filter('the_content', 'wpautop' , 99);
//add_filter('the_content', 'shortcode_unautop', 100);


// http://www.wpexplorer.com/clean-up-wordpress-shortcode-formatting/
if( !function_exists('pipdig_fix_shortcode_wpautop') ) {
	function pipdig_fix_shortcode_wpautop($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
	add_filter('the_content', 'pipdig_fix_shortcode_wpautop');
}

add_filter('widget_text','do_shortcode');