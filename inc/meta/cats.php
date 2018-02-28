<?php 

if (!defined('ABSPATH')) die;
if (function_exists('mb_term_meta_load')) {
function pipdig_p3_meta_boxes_cats($meta_boxes) {
	$prefix = 'pipdig_meta_';

	// Post meta boxes
	
	$meta_boxes[] = array(
		'title' => '',
		'taxonomies' => 'category', // List of taxonomies. Array or string
		'fields' => array(
			array(
				'name' => __('Featured Image'),
				'id'   => 'cat_image',
				'type' => 'image_advanced',
				'max_file_uploads' => 1,
			),
		),
	);
	
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'pipdig_p3_meta_boxes_cats' );
}