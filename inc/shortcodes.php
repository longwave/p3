<?php 

if (!defined('ABSPATH')) die;


include(plugin_dir_path(__FILE__).'shortcodes/pipdig_left_right.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_stars.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_mosaic.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_portfolio.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_image_overlay.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_image_side.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_social_icons.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_category_section.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_banner.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_youtube_slider.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_total_followers.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_instagram_feed.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_padded_text.php');
include(plugin_dir_path(__FILE__).'shortcodes/pipdig_code.php');


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