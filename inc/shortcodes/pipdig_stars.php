<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_stars rating="5"]
function pipdig_p3_star_rating_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'rating' => '5',
		'color' => '#fec400',
		'align' => '',
	), $atts ) );
	
	$alignment = '';
	
	if ($align == 'center' || $align == 'centre') {
		$alignment = 'margin-left:auto;margin-right:auto;';
	} elseif ($align == 'right') {
		$alignment = 'margin-left:auto;margin-right:0;';
	}
	
	wp_enqueue_script( 'rateyo' );

	$post_id = rand(1, 999999999);
	
	$output = '
	<div class="rateyo-'.$post_id.'" style="margin-top:5px;margin-bottom:10px;'.$alignment.'"></div>
	<script>
		jQuery(document).ready(function($) {
			$(".rateyo-'.$post_id.'").rateYo({
				rating: '.strip_tags($rating).',
				normalFill: "#e8e8e8",
				ratedFill: "'.strip_tags($color).'",
				readOnly: true
			});
		});
	</script>
	';
	
	return $output;
}
add_shortcode( 'pipdig_stars', 'pipdig_p3_star_rating_shortcode' );