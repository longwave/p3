<?php
/**
 * Loader for settings page
 *
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
	 *
	 * @var array
	 */
	protected $meta_boxes = array();

	/**
	 * Settings pages.
	 *
	 * @var array
	 */
	protected $settings_pages = array();

	/**
	 * Run hooks to get meta boxes for terms and initialize them.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_settings_pages' ), 1 );

		add_filter( 'rwmb_meta_boxes', array( $this, 'filter' ), 999 );

		/**
		 * Initialize meta boxes for settings pages.
		 * 'rwmb_meta_boxes' runs at priority 10, we use priority 20 to make sure $this->meta_boxes is set.
		 *
		 * @see $this->filter()
		 */
		add_action( 'init', array( $this, 'register' ), 20 );

		add_filter( 'rwmb_meta_type', array( $this, 'filter_meta_type' ), 10, 3 );
	}

	/**
	 * Register settings pages.
	 */
	public function register_settings_pages() {
		// Prevent errors showing if invalid value is returned from the filter above.
		if ( empty( $this->settings_pages ) || ! is_array( $this->settings_pages ) ) {
			return;
		}

		foreach ( $this->settings_pages as $settings_page ) {
			new MB_Settings_Page( $settings_page );
		}
	}

	/**
	 * Filter meta boxes to get only meta boxes for terms and remove them from posts.
	 *
	 * @param array $meta_boxes Meta boxes.
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
	 * Register meta boxes for settings pages, each meta box is a section.
	 */
	public function register() {
		// Get settings page.
		$this->settings_pages = apply_filters( 'mb_settings_pages', array() );

		// Register meta boxes for settings pages.
		$field_registry = rwmb_get_registry( 'field' );
		foreach ( $this->meta_boxes as $meta_box ) {
			$meta_box = new MB_Settings_Page_Meta_Box( $meta_box );

			foreach ( $meta_box->settings_pages as $page ) {
				$option_name = $this->get_option_name_from_settings_page_id( $page );

				foreach ( $meta_box->fields as $field ) {
					$field_registry->add( $field, $option_name, 'setting' );
				}
			}
		}
	}

	/**
	 * Filter meta type from object type and object id.
	 *
	 * @param string     $type        Meta type get from object type and object id.
	 *                                Assert 'setting' if object id is a string.
	 * @param string     $object_type Object type.
	 * @param string|int $object_id   Object id. Should be the option name.
	 *
	 * @return string
	 */
	public function filter_meta_type( $type, $object_type, $object_id ) {
		return 'setting' === $object_type ? $object_id : $type;
	}

	/**
	 * Get option name from settings page id.
	 *
	 * @param  string $page_id Settings page id.
	 * @return string
	 */
	protected function get_option_name_from_settings_page_id( $page_id ) {
		$option_name = '';

		foreach ( $this->settings_pages as $settings_page ) {
			if ( $page_id === $settings_page['id'] ) {
				$option_name = $settings_page['option_name'];
				break;
			}
		}

		return $option_name;
	}
}
