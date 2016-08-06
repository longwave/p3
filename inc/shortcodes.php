<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

include('shortcodes/pipdig_left_right.php');
include('shortcodes/pipdig_stars.php');
include('shortcodes/pipdig_mosaic.php');
include('shortcodes/pipdig_portfolio.php');
include('shortcodes/pipdig_image_overlay.php');
include('shortcodes/pipdig_image_side.php');
include('shortcodes/pipdig_social_icons.php');
include('shortcodes/pipdig_category_section.php');
include('shortcodes/pipdig_banner.php');
include('shortcodes/pipdig_youtube_slider.php');

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
