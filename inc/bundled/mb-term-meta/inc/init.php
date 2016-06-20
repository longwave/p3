<?php
/**
 * Initialize for taxonomy meta
 * @package    Meta Box
 * @subpackage MB Taxonomy Meta
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

add_filter( 'rwmb_meta_boxes', 'mb_term_meta_filter', 999 );

/**
 * Filter meta boxes to prevent them to be added to posts
 * @param array $meta_boxes
 * @return array
 */
function mb_term_meta_filter( $meta_boxes )
{
	global $mb_term_meta_boxes;
	$mb_term_meta_boxes = array();
	foreach ( $meta_boxes as $k => $meta_box )
	{
		if ( isset( $meta_box['taxonomies'] ) )
		{
			unset( $meta_box['post_types'], $meta_box['pages'] );
			$mb_term_meta_boxes[$k] = $meta_box;

			// Prevent adding meta box to post
			unset( $meta_boxes[$k] );
		}
	}
	return $meta_boxes;
}

/**
 * Initialize meta boxes for term.
 * 'rwmb_meta_boxes' runs at priority 10, we use priority 20 to make sure global variable $mb_term_meta_boxes is set.
 * @see mb_term_meta_filter()
 */
add_action( 'admin_init', 'mb_term_meta_init', 20 );

/**
 * Register meta boxes for term, each meta box is a section
 * @return void
 */
function mb_term_meta_init()
{
	global $mb_term_meta_boxes;

	// Prevent errors showing if invalid value is returned from the filter above
	if ( empty( $mb_term_meta_boxes ) || ! is_array( $mb_term_meta_boxes ) )
		return;

	foreach ( $mb_term_meta_boxes as $meta_box )
	{
		new MB_Term_Meta_Box( $meta_box );
	}
}
