<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_left] [/pipdig_left]
function pipdig_p3_shortcode_left( $atts, $content = null ) {
	return '<div class="clearfix"></div><div class="pipdig_left">'.do_shortcode($content).'</div>';
}
add_shortcode( 'pipdig_left', 'pipdig_p3_shortcode_left' );

// [pipdig_right] [/pipdig_right]
function pipdig_p3_shortcode_right( $atts, $content = null ) {
	return '<div class="pipdig_right">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode( 'pipdig_right', 'pipdig_p3_shortcode_right' );




// [pipdig_col1] [/pipdig_col1]
function pipdig_p3_shortcode_col1( $atts, $content = null ) {
	return '<div class="pipdig_col1">'.do_shortcode($content).'</div>';
}
add_shortcode( 'pipdig_col1', 'pipdig_p3_shortcode_col1' );

// [pipdig_col2] [/pipdig_col2]
function pipdig_p3_shortcode_col2( $atts, $content = null ) {
	return '<div class="pipdig_col2">'.do_shortcode($content).'</div>';
}
add_shortcode( 'pipdig_col2', 'pipdig_p3_shortcode_col2' );

// [pipdig_col3] [/pipdig_col3]
function pipdig_p3_shortcode_col3( $atts, $content = null ) {
	return '<div class="pipdig_col3">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode( 'pipdig_col3', 'pipdig_p3_shortcode_col3' );