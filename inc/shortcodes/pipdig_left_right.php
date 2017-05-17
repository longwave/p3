<?php 

if (!defined('ABSPATH')) die;

// [pipdig_left] [/pipdig_left]
function pipdig_p3_shortcode_left( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'border' => '',
	), $atts ) );
	
	$border_css_class = '';
	if ($border == 'yes') {
		$border_css_class = 'pipdig_col_border';
	}
	
	return '<div class="clearfix"></div><div class="pipdig_left '.$border_css_class.'">'.do_shortcode($content).'</div>';
}
add_shortcode( 'pipdig_left', 'pipdig_p3_shortcode_left' );
add_shortcode( 'left', 'pipdig_p3_shortcode_left' );

// [pipdig_right] [/pipdig_right]
function pipdig_p3_shortcode_right( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'border' => '',
	), $atts ) );
	
	$border_css_class = '';
	if ($border == 'yes') {
		$border_css_class = 'pipdig_col_border';
	}
	
	return '<div class="pipdig_right '.$border_css_class.'">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode( 'pipdig_right', 'pipdig_p3_shortcode_right' );
add_shortcode( 'right', 'pipdig_p3_shortcode_right' );



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