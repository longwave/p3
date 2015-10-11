<?php 

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_p3_meta_boxes_rs($meta_boxes) {
	$prefix = 'pipdig_meta_';

	// Post meta boxes
	$meta_boxes[] = array(
		'id'       => 'rs_shopthepost',
		'title'    => 'rewardStyle "Shop The Post" Options (pipdig)',
		'pages'    => 'post',
		'context'  => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name'  => 'rewardStyle "Shop the Post" widget ID:',
				'desc'  => 'Copy the ID number from the shorcode provided by rewardStyle.',
				'id'    => $prefix . 'rs_shopthepost',
				'type'  => 'number',
			),
			/*
			array(
				'name'		=> 'Display widget on this post?',
				'id'		=> $prefix . 'rs_shopthepost_post',
				'clone'		=> false,
				'type'		=> 'checkbox',
				'std'		=> true
			),
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
add_filter( 'rwmb_meta_boxes', 'pipdig_p3_meta_boxes_rs' );


function pipdig_p3_post_footer_rs() {
	if (pipdig_plugin_check('meta-box/meta-box.php')) {
		$rs_shopthepost_id = rwmb_meta('pipdig_meta_rs_shopthepost');
		if (empty($rs_id)) {
			return;
		}
		//$rs_shopthepost_post = rwmb_meta('pipdig_meta_rs_shopthepost_post');
		//$rs_shopthepost_home = rwmb_meta('pipdig_meta_rs_shopthepost_home');
		//$rs_shopthepost_cat = rwmb_meta('pipdig_meta_rs_shopthepost_cat');
	} else {
		return;
	}
	
	$output = '<div class="clearfix"></div>';
	$output .= do_shortcode('[show_shopthepost_widget id="'.$rs_shopthepost_id.'"]');
	$output .= '<div class="clearfix"></div>';
	echo $output;
}
add_action( 'p3_post_footer', 'pipdig_p3_post_footer_rs' );

