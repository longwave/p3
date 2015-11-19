<?php 

if (!defined('ABSPATH')) {
	exit;
}

require_once('shortcodes/layout.php');
require_once('shortcodes/stars.php');
require_once('shortcodes/grid-mosaic.php');
//require_once('shortcodes/grid-squares.php');

// stop wpautop on shortcodes
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );