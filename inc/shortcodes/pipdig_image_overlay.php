<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_image_overlay title="poop" image="" position="topleft"]
function pipdig_p3_image_overlay( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => 'In this photo',
		'titlecolor' => '',
		'titletextsize' => '',
		'image' => '',
		'position' => 'topleft'
	), $atts ) );
	
	$id = rand(1, 999999999);
	$position_out = '';
	switch ($position) {
		case 'topleft':
			$position_out = 'top:20px;left:21px;text-align:left';
			break;
		case 'topright':
			$position_out = 'top:20px;right:21px;text-align:right';
			break;
		case 'bottomright':
			$position_out = 'bottom:28px;right:25px;text-align:right';
			break;
		case 'bottomleft':
			$position_out = 'bottom:28px;left:25px;text-align:left';
			break;
		case 'bottomcentre':
			$position_out = 'width:100%;bottom:25px;';
			break;
		case 'middlecentre':
			$position_out = 'width:100%;top:45%;';
			break;
		case 'topcentre':
			$position_out = 'width:100%;top:20px;';
			break;
	}
	
	$output = '';
	$output .= '<div style="position:relative;" class="editorial-photo-text">
		<img src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'" />
		<div style="position:absolute;'.$position_out.';z-index:20">
		<div class="editorial-photo-title" style="color:'.$titlecolor.';font-size:'.$titletextsize.';">'.$title.'</div>
		'.$content.'
		</div>
		</div>';
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