<?php

if (!defined('ABSPATH')) {
	exit;
}

if ( ! class_exists( 'ZOOM_Customizer_Reset' ) ) {
	final class pipdig_p3_Customizer_Reset {

		private static $instance = null;

		private $wp_customize;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		private function __construct() {
			add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
			add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
		}

		public function customize_controls_print_scripts() {
			wp_enqueue_script( 'zoom-customizer-reset', plugins_url( 'customizer-reset.js', __FILE__ ), array( 'jquery' ), '20150120' );
			wp_localize_script( 'zoom-customizer-reset', '_ZoomCustomizerReset', array(
				'reset'   => __( 'Reset', 'p3' ),
				'confirm' => __( "Warning! This will reset all options you have changed for this theme so far. Are you sure?", 'p3' ),
				'nonce'   => array(
					'reset' => wp_create_nonce( 'customizer-reset' ),
				)
			) );
		}

		/**
		 * Store a reference to `WP_Customize_Manager` instance
		 *
		 * @param $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		public function ajax_customizer_reset() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->reset_customizer();

			wp_send_json_success();
		}

		public function reset_customizer() {
			$settings = $this->wp_customize->settings();

			// remove theme_mod settings registered in customizer
			foreach ( $settings as $setting ) {
				if ( 'theme_mod' == $setting->type ) {
					remove_theme_mod( $setting->id );
					delete_option('p3_pinterest_theme_set');
				}
			}
		}
	}
	pipdig_p3_Customizer_Reset::get_instance();
}

