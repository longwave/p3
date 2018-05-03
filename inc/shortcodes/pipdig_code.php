<?php 

if (!defined('ABSPATH')) die;

// [pipdig_code_1]
function pipdig_code_1_shortcode( $atts, $content = null ) {
	
	$output = '';
	
	$options = get_option('pipdig_settings');
	if (isset($options['pipdig_textarea_content_script_1'])) {
		$output = $options['pipdig_textarea_content_script_1'];
	}
	
	return $output;
}
add_shortcode( 'pipdig_code_1', 'pipdig_code_1_shortcode' );

// [pipdig_code_2]
function pipdig_code_2_shortcode( $atts, $content = null ) {
	
	$output = '';
	
	$options = get_option('pipdig_settings');
	if (isset($options['pipdig_textarea_content_script_2'])) {
		$output = $options['pipdig_textarea_content_script_2'];
	}
	
	return $output;
}
add_shortcode( 'pipdig_code_2', 'pipdig_code_2_shortcode' );