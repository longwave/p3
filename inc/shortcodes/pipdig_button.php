<?php 
if (!defined('ABSPATH')) die;

// [pipdig_button link="" title=""]
function pipdig_button_shortcode_function( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'link' => '',
	), $atts ) );
	
	$output = '';
	
	if ($link && $title) {
		$output = '<div class="pipdig_button_shortcode"><a class="more-link" href="'.esc_url($link).'">'.esc_html($title).'</a></div>';
	}
	
	return $output;
}
add_shortcode('pipdig_button', 'pipdig_button_shortcode_function');