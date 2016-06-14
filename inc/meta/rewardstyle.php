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
			)
		)
	);
	
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'pipdig_p3_meta_boxes_rs' );


function pipdig_p3_post_footer_rs() {
	if (function_exists('rwmb_meta')) {
		$rs_shopthepost_id = rwmb_meta('pipdig_meta_rs_shopthepost');
		if (empty($rs_shopthepost_id)) {
			return;
		}
	} else {
		return;
	}
	
	$output = '<div class="clearfix"></div>';
	$output .= do_shortcode('[show_shopthepost_widget id="'.$rs_shopthepost_id.'"]');
	$output .= '<div class="clearfix"></div>';
	echo $output;
}
add_action( 'p3_post_footer', 'pipdig_p3_post_footer_rs' );

