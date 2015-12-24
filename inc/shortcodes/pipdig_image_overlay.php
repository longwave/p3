<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_image_overlay rating="5"]
function pipdig_p3_image_overlay( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'rating' => '5',
		'color' => '#fec400'
	), $atts ) );
	
	$id = rand(1, 999999999);
		
	$output = '';
	$output .= '<div id="'.$id.'"';
	$output .= '
	<script>
	jQuery(window).on("load", function() {
		var rowHeight = jQuery("#HTML519").height();
		jQuery("#'.$id.'").css("height", rowHeight);
	});
	</script>
	';
	
	return $output;
}
add_shortcode( 'pipdig_image_overlay', 'pipdig_p3_image_overlay' );