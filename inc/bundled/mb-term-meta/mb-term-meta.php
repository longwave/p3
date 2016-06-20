<?php
/**
 * Plugin Name: MB Term Meta
 * Plugin URI: https://metabox.io/plugins/mb-term-meta/
 * Description: Add custom fields (meta data) for terms.
 * Version: 1.0.2
 * Author: Rilwis
 * Author URI: http://www.deluxeblogtips.com
 * License: GPL2+
 * Text Domain: mb-term-meta
 * Domain Path: /lang/
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_term_meta_load' ) )
{
	add_action( 'init', 'mb_term_meta_load' );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_term_meta_load()
	{
		if ( ! class_exists( 'RW_Meta_Box' ) || class_exists( 'MB_Term_Meta_Box' ) )
		{
			return;
		}

		require plugin_dir_path( __FILE__ ) . 'inc/term-meta-box.php';
		require plugin_dir_path( __FILE__ ) . 'inc/init.php';
	}
}
