<?php
/**
 * Plugin Name: MB Settings Page
 * Plugin URI: https://metabox.io/plugins/mb-settings-page/
 * Description: Add-on for meta box plugin which helps you create settings pages easily.
 * Version: 1.1.2
 * Author: Rilwis
 * Author URI: http://www.deluxeblogtips.com
 * License: GPL2+
 * Text Domain: mb-settings-page
 * Domain Path: /lang/
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_settings_page_load' ) )
{
	add_action( 'init', 'mb_settings_page_load' );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_settings_page_load()
	{
		if ( ! class_exists( 'RW_Meta_Box' ) || class_exists( 'MB_Settings_Page' ) )
		{
			return;
		}

		require plugin_dir_path( __FILE__ ) . 'inc/settings-page.php';
		require plugin_dir_path( __FILE__ ) . 'inc/settings-page-meta-box.php';
		require plugin_dir_path( __FILE__ ) . 'inc/init.php';
	}
}
