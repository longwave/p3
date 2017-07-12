<?php
/**
 * Plugin Name: MB Term Meta
 * Plugin URI: https://metabox.io/plugins/mb-term-meta/
 * Description: Add custom fields (meta data) for terms.
 * Version: 1.1
 * Author: MetaBox.io
 * Author URI: https://metabox.io
 * License: GPL2+
 * Text Domain: mb-term-meta
 * Domain Path: /languages/
 *
 * @package Meta Box
 * @subpackage MB Term Meta
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_term_meta_load' ) ) {
	/**
	 * Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs
	 */
	add_action( 'init', 'mb_term_meta_load', 5 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_term_meta_load() {
		if ( ! defined( 'RWMB_VER' ) || class_exists( 'MB_Term_Meta_Box' ) ) {
			return;
		}

		require dirname( __FILE__ ) . '/inc/class-mb-term-meta-field.php';
		require dirname( __FILE__ ) . '/inc/class-mb-term-meta-loader.php';
		require dirname( __FILE__ ) . '/inc/class-mb-term-meta-box.php';
		require dirname( __FILE__ ) . '/inc/class-rwmb-term-storage.php';
		$loader = new MB_Term_Meta_Loader;
		$loader->init();
	}
}
