<?php
/**
 * Initialize for settings pages and their meta boxes
 * @package    Meta Box
 * @subpackage MB Settings Page
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

add_action( 'admin_menu', 'mb_settings_page_register', 1 );

/**
 * Register settings pages
 */
function mb_settings_page_register()
{
	$settings_pages = apply_filters( 'mb_settings_pages', array() );

	// Prevent errors showing if invalid value is returned from the filter above
	if ( empty( $settings_pages ) || ! is_array( $settings_pages ) )
	{
		return;
	}

	foreach ( $settings_pages as $settings_page )
	{
		new MB_Settings_Page( $settings_page );
	}
}

add_filter( 'rwmb_meta_boxes', 'mb_settings_page_filter', 999 );

/**
 * Filter meta boxes to prevent them to be added to posts
 * @param array $meta_boxes
 * @return array
 */
function mb_settings_page_filter( $meta_boxes )
{
	global $mb_settings_boxes;
	$mb_settings_boxes = array();
	foreach ( $meta_boxes as $k => $meta_box )
	{
		if ( isset( $meta_box['settings_pages'] ) )
		{
			unset( $meta_box['post_types'], $meta_box['pages'] );
			$mb_settings_boxes[$k] = $meta_box;

			// Prevent adding meta box to post
			unset( $meta_boxes[$k] );
		}
	}
	return $meta_boxes;
}

/**
 * Initialize meta boxes for settings page.
 * 'rwmb_meta_boxes' runs at priority 10, we use priority 20 to make sure global variable $mb_settings_boxes is set.
 * @see mb_settings_page_filter()
 */
add_action( 'admin_init', 'mb_settings_page_init', 20 );

/**
 * Register meta boxes for settings page
 */
function mb_settings_page_init()
{
	global $mb_settings_boxes;

	// Prevent errors showing if invalid value is returned from the filter above
	if ( empty( $mb_settings_boxes ) || ! is_array( $mb_settings_boxes ) )
		return;

	foreach ( $mb_settings_boxes as $meta_box )
	{
		new MB_Settings_Page_Meta_Box( $meta_box );
	}
}
