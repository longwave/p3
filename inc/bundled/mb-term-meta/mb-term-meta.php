<?php
/**
 * Plugin Name: MB Term Meta
 * Plugin URI: https://metabox.io/plugins/mb-term-meta/
 * Description: Add custom fields (meta data) for terms.
 * Version: 1.2.2
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

		require dirname( __FILE__ ) . '/inc/class-mb-term-meta-loader.php';
		require dirname( __FILE__ ) . '/inc/class-mb-term-meta-box.php';
		require dirname( __FILE__ ) . '/inc/class-rwmb-term-storage.php';

		$loader = new MB_Term_Meta_Loader;
		$loader->init();

		// Backward compatible with Meta Box Group extension < 1.2.7 when Meta Box 1.12 switch to use storage.
		$old_group = false;
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		if ( is_plugin_active( 'meta-box-group/meta-box-group.php' ) ) {
			$group = get_plugin_data( WP_PLUGIN_DIR . '/meta-box-group/meta-box-group.php' );

			if ( version_compare( $group['Version'], '1.2.7' ) < 0 ) {
				$old_group = true;
			}
		}

		if ( $old_group ) {
			require dirname( __FILE__ ) . '/inc/class-mb-term-meta-field.php';
			$term_meta_field = new MB_Term_Meta_Field();
			$term_meta_field->init();
		}
	}
}
