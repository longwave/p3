<?php 

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_p3_meta_boxes_page($meta_boxes) {
	$prefix = 'pipdig_meta_';

	// Post meta boxes
	$meta_boxes[] = array(
		'id'       => 'page_options',
		'title'    => __('Extra Page Options', 'p3').' (pipdig)',
		'pages'    => 'page',
		'context'  => 'normal',
		'priority' => 'high',
		'fields' => array(
		/*
			array(
				'name'  => 'rewardStyle "Shop the Post" widget ID:',
				'desc'  => 'Copy the ID number from the shorcode provided by rewardStyle.',
				'id'    => $prefix . '_custom_page_title',
				'type'  => 'number',
			),
		*/
			array(
				'name'		=> __('Hide the page title', 'p3'),
				'id'		=> $prefix . 'hide_page_title',
				'clone'		=> false,
				'type'		=> 'checkbox',
				'std'		=> false
			),
		/*
			array(
				'name'		=> 'Display when viewing the post on the homepage?',
				'id'		=> $prefix . 'rs_shopthepost_home',
				'clone'		=> false,
				'type'		=> 'checkbox',
				'std'		=> false
			),
			array(
				'name'		=> 'Display when viewing the post in a category?',
				'id'		=> $prefix . 'rs_shopthepost_cat',
				'clone'		=> false,
				'type'		=> 'checkbox',
				'std'		=> false
			),
		*/
		)
	);
	
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'pipdig_p3_meta_boxes_page' );