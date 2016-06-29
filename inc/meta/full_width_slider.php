<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

function pipdig_p3_meta_boxes_extra_images($meta_boxes) {
	$prefix = 'pipdig_meta_';

	$meta_boxes[] = array(
		'id'       => 'full_width_slider',
		'title'    => __('Full Width Slider Options', 'p3'),
		'pages'    => 'post',
		'context'  => 'normal',
		'priority' => 'low',
		'fields' => array(
				array(
					'name'  => __('Image to use in slider', 'p3'),
					'desc'  => __('Use this option to select an image to display in the Full Width Slider. You should upload an image which is 1920 wide if possible. If you leave this options blank then this post will display the Featured Image or first image from the post instead.', 'p3'),
					'id'    => $prefix . 'full_width_slider_image',
					'type'  => 'image',
					'max_file_uploads' => 1,
				),
		)
	);
	
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'pipdig_p3_meta_boxes_extra_images' );