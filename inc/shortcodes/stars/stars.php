<?php 

// add scripts
function pipdig_p3_star_enqueue_scripts($hook) {
	wp_register_script( 'rateyo', plugin_dir_url(__FILE__) . 'rateyo.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_star_enqueue_scripts' );


// [stars rating="5"]
function pipdig_p3_star_rating_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'rating' => '5',
		'color' => '#fec400'
	), $atts ) );
	
	wp_enqueue_script( 'rateyo' );

	add_action('wp_footer', 'pipdig_p3_star_enqueue_styles');
	
	$post_id = get_the_ID();
	
	return '
	<div class="rateyo-'.$post_id.'" style="margin-top:5px;margin-bottom:10px;"></div>
	<script>
		jQuery(document).ready(function($) {
			$(".rateyo-'.$post_id.'").rateYo({
				rating: '.$rating.',
				normalFill: "#e8e8e8",
				ratedFill: "'.$color.'",
				readOnly: true
			});
		});
	</script>
	';
}
add_shortcode( 'pipdig_stars', 'pipdig_p3_star_rating_shortcode' );


function pipdig_p3_star_enqueue_styles() {
	echo '<style>.jq-ry-container{position:relative;padding:0 5px;line-height:0;display:block;cursor:pointer}.jq-ry-container[readonly=readonly]{cursor:default}.jq-ry-container>.jq-ry-group-wrapper{position:relative;width:100%}.jq-ry-container>.jq-ry-group-wrapper>.jq-ry-group{position:relative;line-height:0;z-index:10;white-space:nowrap}.jq-ry-container>.jq-ry-group-wrapper>.jq-ry-group>svg{display:inline-block}.jq-ry-container>.jq-ry-group-wrapper>.jq-ry-group.jq-ry-normal-group{width:100%}.jq-ry-container>.jq-ry-group-wrapper>.jq-ry-group.jq-ry-rated-group{width:0;z-index:11;position:absolute;top:0;left:0;overflow:hidden}</style>';
}