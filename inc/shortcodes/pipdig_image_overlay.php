<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_image_overlay title="" image="" position="topleft"]
if (!function_exists('pipdig_p3_image_overlay')) {
	function pipdig_p3_image_overlay( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => 'In this photo',
			'titlecolor' => '',
			'titletextsize' => '',
			//'background' => '',
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
			case 'bottommiddle':
				$position_out = 'width:100%;bottom:25px;';
				break;
			case 'middlemiddle':
				$position_out = 'width:100%;top:45%;';
				break;
			case 'topmiddle':
				$position_out = 'width:100%;top:20px;';
				break;
		}
		
		if ($titletextsize) {
			$titletextsize = 'font-size:'.esc_attr($titletextsize).'px;';
		}
		if ($titlecolor) {
			$titlecolor = 'color:'.esc_attr($titlecolor).';';
		}
		//if ($background) {
			//$background = 'background:'.esc_attr($background).';';
		//}
		
		$output = '';
		$output .= '<div style="position:relative;" class="editorial-photo-text">
			<img src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'" />
			<div style="padding:5px 10px;background:rgba(255,255,255,.5);position:absolute;'.$position_out.';z-index:20">
			<div class="editorial-photo-title" style="'.$titlecolor.$titletextsize.'">'.$title.'</div>
			'.$content.'
			</div>
			</div>';
		
		return $output;
	}
	add_shortcode( 'pipdig_image_overlay', 'pipdig_p3_image_overlay' );
}