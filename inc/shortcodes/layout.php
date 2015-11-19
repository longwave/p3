<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_left] [/pipdig_left]
function pipdig_p3_shortcode_left( $atts, $content = null ) {
	return '<div class="clearfix"></div><div class="pipdig_left">' . $content . '</div>';
}
add_shortcode( 'pipdig_left', 'pipdig_p3_shortcode_left' );

// [pipdig_right] [/pipdig_right]
function pipdig_p3_shortcode_right( $atts, $content = null ) {
	return '<div class="pipdig_right">' . $content . '</div><div class="clearfix"></div>';
}
add_shortcode( 'pipdig_right', 'pipdig_p3_shortcode_right' );
