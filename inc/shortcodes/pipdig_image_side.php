<?php 

if (!defined('ABSPATH')) die;

// [pipdig_image_side title="" image="" image_position="left"]
if (!function_exists('pipdig_p3_image_side')) {
	function pipdig_p3_image_side( $atts, $content = null ) {
		extract( shortcode_atts( array(
			//'title' => 'In this photo',
			//'titlecolor' => '',
			//'titletextsize' => '',
			'image' => '',
			'image_position' => 'left'
		), $atts ) );
		
		$img_id = rand(1, 999999999);
		$text_id = rand(1, 999999999);
		
		$img_output = '<img id="'.esc_attr($img_id).'" src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'" />';
		$text_output = '<div id="'.esc_attr($text_id).'" class="pipdig_image_side_text">'.do_shortcode($content).'</div>';
		
		if ($image_position == 'left') {
			$left = $img_output;
			$right = $text_output;
		} else {
			$left = $text_output;
			$right = $img_output;
		}
		
		$output = '';
		$output .= '<div class="clearfix"></div><div class="pipdig_image_side_wrapper">';
		$output .= '<div class="pipdig_left">'.$left.'</div>';
		$output .= '<div class="pipdig_right">'.$right.'</div>';
		
		$output .= '</div><div class="clearfix"></div>'; // close .pipdig_image_side_wrapper
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
}