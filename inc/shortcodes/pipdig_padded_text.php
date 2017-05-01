<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_padded_text padding=""]
function pipdig_padded_text_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'padding' => 150,
	), $atts ) );
	
	$output = $id = $margin_out = '';
	
	$id = 'p3_padded_text_'.rand(1, 999999999);
	$output .= '
	<style>
	@media screen and (min-width: 769px) {
		#'.$id.'{margin: 0 '.absint($padding).'px}
	}
	</style>';
	
	$output .= '<div id="'.$id.'" class="p3_padded_text">'.wpautop($content).'</div>';
	
	return $output;
}
add_shortcode( 'pipdig_padded_text', 'pipdig_padded_text_func' );