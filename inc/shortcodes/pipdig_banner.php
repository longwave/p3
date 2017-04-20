<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_banner image=""]
function parallax_section_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'image' => '',
		'link' => '',
		'parallax' => '',
		'size' => '',
	), $atts ) );
	
	if (empty($image)) {
		return;
	}
	
	$output = $parallax_class = $stellar = '';
	$tag_1 = '<div';
	$tag_2 = '</div>';
	
	if ($parallax == 'yes') {
		$parallax_class = ' pipdig_banner_parallax';
		$stellar = 'data-stellar-background-ratio="1.4"';
	}
	if ($link) {
		$tag_1 = '<a href="'.esc_url($link).'"';
		$tag_2 = '</a>';
	}
	
	if ($size == 'original') {
		$output .= $tag_1.' class="pipdig_banner'.$parallax_class.'" style="height:auto"><img src="'.esc_url($image).'" alt=""/>'.$tag_2;
	} else {
		$output .= $tag_1.' class="pipdig_banner'.$parallax_class.'" style="background-image:url('.esc_url($image).');" '.$stellar.'>'.$tag_2;
	}
	
	return $output;
}
add_shortcode( 'pipdig_banner', 'parallax_section_func' );