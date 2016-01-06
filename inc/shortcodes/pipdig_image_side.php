<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_image_side title="poop" image="" position="left"]
function pipdig_p3_image_side( $atts, $content = null ) {
	extract( shortcode_atts( array(
		//'title' => 'In this photo',
		//'titlecolor' => '',
		//'titletextsize' => '',
		'image' => '',
		'position' => 'left'
	), $atts ) );
	
	$img_id = rand(1, 999999999);
	$text_id = rand(1, 999999999);
	$position_out = '';
	switch ($position) {
		case 'left':
			$position_out = 'top:20px;left:21px;text-align:left';
			break;
		case 'right':
			$position_out = 'top:20px;right:21px;text-align:right';
			break;
	}
	
	$output = '';
	$output .= '
	
	<div class="clearfix"></div>
	
	<div class="pipdig_image_side_wrapper">
	
	<style>
		.pipdig_image_side_text {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
			width: 800px;
		}
	</style>
	
	<div class="pipdig_left"><div id="'.$text_id.'" class="pipdig_image_side_text">'.do_shortcode($content).'</div></div>
	
	<div class="pipdig_right"><img id="'.$img_id.'" src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'" /></div>
	
	</div>
	
	<div class="clearfix"></div>
	
	';
	$output .= '
	<script>
	jQuery(window).on("load", function() {
		var rowHeight = jQuery("#'.$img_id.'").height();
		jQuery("#'.$text_id.'").css("height", rowHeight);
	});
	</script>
	';
	
	return $output;
}
add_shortcode( 'pipdig_image_side', 'pipdig_p3_image_side' );