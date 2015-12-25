<?php 

if (!defined('ABSPATH')) {
	exit;
}

include_once('shortcodes/pipdig_left_right.php');
include_once('shortcodes/pipdig_stars.php');
include_once('shortcodes/pipdig_mosaic.php');
include_once('shortcodes/pipdig_image_overlay.php');

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
