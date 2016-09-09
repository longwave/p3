<?php
/**
 * The main class of the plugin which handles show, edit, save meta boxes for settings page
 * @package    Meta Box
 * @subpackage MB Settings Page
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Class for handling meta boxes for settings page
 */
class MB_Settings_Page_Meta_Box extends RW_Meta_Box {
	/**
	 * @var string Current settings page ID. It will be set when page loads.
	 */
	public $page_args;

	/**
	 * Constructor
	 * Call parent constructor and add specific hooks
	 *
	 * @param array $meta_box
	 */
	public function __construct( $meta_box ) {
		parent::__construct( $meta_box );
		$this->meta_box['settings_pages'] = (array) $this->meta_box['settings_pages'];

		remove_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		remove_action( 'save_post_post', array( $this, 'save_post' ) );

		add_action( 'mb_settings_page_load', array( $this, 'load' ) );
	}

	/**
	 * Add hooks for current settings page
	 *
	 * @param array $page_args Settings page arguments
	 */
	public function load( $page_args ) {
		$this->page_args = $page_args;

		// Add meta boxes
		foreach ( $this->meta_box['settings_pages'] as $settings_page ) {
			if ( $settings_page == $this->page_args['id'] ) {
				add_meta_box(
					$this->meta_box['id'],
					$this->meta_box['title'],
					array( $this, 'show' ),
					null, // Current page
					$this->meta_box['context'],
					$this->meta_box['priority']
				);
			}
		}

		// Filter field meta (saved value)
		add_filter( 'rwmb_field_meta', array( $this, 'field_meta' ), 10, 2 );

		// Filter saved value
		add_filter( 'mb_settings_pages_data', array( $this, 'save' ) );
	}

	/**
	 * Get field meta value
	 *
	 * @param mixed $meta Meta value
	 * @param array $field Field parameters
	 *
	 * @return mixed
	 */
	public function field_meta( $meta, $field ) {
		if ( ! $this->is_edit_screen() ) {
			return $meta;
		}

		$option_name = sanitize_text_field( $this->page_args['option_name'] );
		$data        = get_option( $option_name );
		if ( empty( $data ) ) {
			$data = array();
		}
		$data = (array) $data;

		$meta = isset( $data[ $field['id'] ] ) ? $data[ $field['id'] ] : $field['std'];

		// Escape attributes
		$meta = RWMB_Field::call( $field, 'esc_meta', $meta );

		// Make sure meta value is an array for clonable and multiple fields
		if ( $field['clone'] || $field['multiple'] ) {
			if ( empty( $meta ) || ! is_array( $meta ) ) {
				/**
				 * Note: if field is clonable, $meta must be an array with values
				 * so that the foreach loop in self::show() runs properly
				 * @see self::show()
				 */
				$meta = $field['clone'] ? array( '' ) : array();
			}
		}

		return $meta;
	}

	/**
	 * Save settings fields
	 *
	 * @param array $data Array of settings options
	 *
	 * @return array
	 */
	public function save( $data ) {
		$nonce = (string) filter_input( INPUT_POST, "nonce_{$this->meta_box['id']}" );
		if ( ! wp_verify_nonce( $nonce, "rwmb-save-{$this->meta_box['id']}" ) ) {
			return $data;
		}

		foreach ( $this->fields as $field ) {
			$name = $field['id'];

			$old = isset( $data[ $name ] ) ? $data[ $name ] : false;

			$new = isset( $_POST[ $name ] ) ? $_POST[ $name ] : ( $field['multiple'] ? array() : '' );
			/**
			 * WordPress automatically adds slashes to $_POST. This function remove slashes.
			 * Note: for post meta we don't need to do this because WordPress does automatically in update_post_meta().
			 */
			$new = wp_unslash( $new );

			// Allow field class change the value
			$new = RWMB_Field::call( $field, 'value', $new, $old, 0 );
			$new = RWMB_Field::filter( 'value', $new, $field, $old );

			$data[ $name ] = $new;
		}

		return $data;
	}

	/**
	 * Check if settings page is saved.
	 * @return bool
	 */
	public function is_saved() {
		$option_name = sanitize_text_field( $this->page_args['option_name'] );
		$data        = get_option( $option_name );
		foreach ( $this->fields as $field ) {
			if ( isset( $data[ $field['id'] ] ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if we're on the right edit screen.
	 *
	 * @param WP_Screen $screen Screen object. Optional. Use current screen object by default.
	 *
	 * @return bool
	 */
	public function is_edit_screen( $screen = null ) {
		return in_array( $this->page_args['id'], $this->meta_box['settings_pages'] );
	}
}
