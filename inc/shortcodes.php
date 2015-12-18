<?php 

if (!defined('ABSPATH')) {
	exit;
}

require_once('shortcodes/layout.php');
require_once('shortcodes/stars.php');
require_once('shortcodes/grid-mosaic.php');
//require_once('shortcodes/grid-squares.php');

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
