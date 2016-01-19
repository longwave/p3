<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_social_icons size="15px" color=""]
function pipdig_p3_social_icons_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'size' => '',
		'color' => ''
	), $atts ) );
	
	$links = get_option('pipdig_links');
	
	$output = '<div class="socialz p3_social_icons_shortcode">';
	
	if ($size || $color) {
		$output .= '<style scoped>.p3_social_icons_shortcode a {font-size:'.$size.';color:'.$color.';}</style>';
	}
	
		if (!empty($links['twitter'])) {
			$output .= '<a href="'.esc_url($links['twitter']).'" target="_blank"><i class="fa fa-twitter"></i></a>';
		}
		if (!empty($links['instagram'])) {
			$output .= '<a href="'.esc_url($links['instagram']).'" target="_blank"><i class="fa fa-instagram"></i></a>';
		}
		if (!empty($links['facebook'])) {
			$output .= '<a href="'.esc_url($links['facebook']).'" target="_blank"><i class="fa fa-facebook"></i></a>';
		}
		if (!empty($links['bloglovin'])) {
			$output .= '<a href="'.esc_url($links['bloglovin']).'" target="_blank"><i class="fa fa-plus"></i></a>';
		}
		if (!empty($links['pinterest'])) {
			$output .= '<a href="'.esc_url($links['pinterest']).'" target="_blank"><i class="fa fa-pinterest"></i></a>';
		}
		if (!empty($links['youtube'])) {
			$output .= '<a href="'.esc_url($links['youtube']).'" target="_blank"><i class="fa fa-youtube-play"></i></a>';
		}
		if (!empty($links['tumblr'])) {
			$output .= '<a href="'.esc_url($links['tumblr']).'" target="_blank"><i class="fa fa-tumblr"></i></a>';
		}
		if (!empty($links['linkedin'])) {
			$output .= '<a href="'.esc_url($links['linkedin']).'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		}
		if (!empty($links['soundcloud'])) {
			$output .= '<a href="'.esc_url($links['soundcloud']).'" target="_blank"><i class="fa fa-soundcloud"></i></a>';
		}
		if (!empty($links['flickr'])) {
			$output .= '<a href="'.esc_url($links['flickr']).'" target="_blank"><i class="fa fa-flickr"></i></a>';
		}
		if (!empty($links['vk'])) {
			$output .= '<a href="'.esc_url($links['vk']).'" target="_blank"><i class="fa fa-vk"></i></a>';
		}
		if (!empty($links['email'])) {
			$output .= '<a href="mailto:'.sanitize_email($links['facebook']).'"><i class="fa fa-envelope"></i></a>';
		}

	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'pipdig_social_icons', 'pipdig_p3_social_icons_shortcode' );