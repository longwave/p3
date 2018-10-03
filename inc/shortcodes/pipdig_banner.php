<?php 
if (!defined('ABSPATH')) die;

// [pipdig_banner image=""]
function parallax_section_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'image' => '',
		'link' => '',
		'parallax' => false,
		'size' => '',
	), $atts ) );
	
	if (empty($image)) {
		return;
	}
	
	$parallax = filter_var($parallax, FILTER_VALIDATE_BOOLEAN);
	
	$output = $parallax_class = '';
	$tag_1 = '<div';
	$tag_2 = '</div>';
	
	if ($parallax) {
		$parallax_class .= ' pipdig_banner_parallax';
	}
	if ($link) {
		$tag_1 = '<a href="'.esc_url($link).'"';
		$tag_2 = '</a>';
	}
	
	if ($size == 'original') {
		$output .= $tag_1.' class="pipdig_banner'.$parallax_class.'" style="height:auto"><img src="'.esc_url($image).'" alt="" class="skip-lazy"/>'.$tag_2;
	} elseif (absint($size) > 10) {
		$output .= $tag_1.' class="pipdig_banner'.$parallax_class.'" style="background-image:url('.esc_url($image).');height:'.absint($size).'px;">'.$tag_2;
	} else {
		$output .= $tag_1.' class="pipdig_banner'.$parallax_class.'" style="background-image:url('.esc_url($image).');">'.$tag_2;
	}
	
	return $output;
}
add_shortcode( 'pipdig_banner', 'parallax_section_func' );