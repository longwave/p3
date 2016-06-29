<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_banner image=""]
function parallax_section_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'image' => '',
		'parallax' => '',
	), $atts ) );
	
	if (empty($image)) {
		return;
	}
	
	$output = '';
	
	if ($parallax == 'yes') {
		$parallax_class = ' pipdig_banner_parallax';
	}
	
	$output .= '<div class="pipdig_banner'.$parallax_class.'" style="background-image:url('.esc_url($image).');" data-stellar-background-ratio="1.4"></div>';
	
	return $output;
}
add_shortcode( 'pipdig_banner', 'parallax_section_func' );