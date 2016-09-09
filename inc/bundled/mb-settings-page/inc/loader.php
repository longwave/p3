<?php
/**
 * Loader for settings page
 * @package    Meta Box
 * @subpackage MB Settings Page
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Loader class
 */
class MB_Settings_Page_Loader {
	/**
	 * Meta boxes for terms only.
	 * @var array
	 */
	protected $meta_boxes = array();

	/**
	 * Run hooks to get meta boxes for terms and initialize them.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_settings_pages' ), 1 );

		add_filter( 'rwmb_meta_boxes', array( $this, 'filter' ), 999 );

		/**
		 * Initialize meta boxes for term.
		 * 'rwmb_meta_boxes' runs at priority 10, we use priority 20 to make sure $this->meta_boxes is set.
		 * @see mb_term_meta_filter()
		 */
		add_action( 'admin_init', array( $this, 'register' ), 20 );
	}

	/**
	 * Register settings pages.
	 */
	function register_settings_pages() {
		$settings_pages = apply_filters( 'mb_settings_pages', array() );

		// Prevent errors showing if invalid value is returned from the filter above
		if ( empty( $settings_pages ) || ! is_array( $settings_pages ) ) {
			return;
		}

		foreach ( $settings_pages as $settings_page ) {
			new MB_Settings_Page( $settings_page );
		}
	}

	/**
	 * Filter meta boxes to get only meta boxes for terms and remove them from posts.
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	public function filter( $meta_boxes ) {
		foreach ( $meta_boxes as $k => $meta_box ) {
			if ( isset( $meta_box['settings_pages'] ) ) {
				$this->meta_boxes[] = $meta_box;
				unset( $meta_boxes[ $k ] );
			}
		}

		return $meta_boxes;
	}

	/**
	 * Register meta boxes for term, each meta box is a section
	 */
	public function register() {
		foreach ( $this->meta_boxes as $meta_box ) {
			new MB_Settings_Page_Meta_Box( $meta_box );
		}
	}
}
