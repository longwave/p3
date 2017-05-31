<?php
/**
 * The main class of the plugin which handle show, edit, save custom fields (meta data) for terms.
 *
 * @package    Meta Box
 * @subpackage MB Term Meta
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Class for handling custom fields (meta data) for terms.
 */
class MB_Term_Meta_Box extends RW_Meta_Box {
	/**
	 * The field meta object.
	 *
	 * @var MB_Term_Meta_Field
	 */
	private $field_meta;

	/**
	 * Create meta box based on given data.
	 *
	 * @param array $meta_box Meta box configuration.
	 */
	public function __construct( $meta_box ) {

		$meta_box['taxonomies'] = (array) $meta_box['taxonomies'];
		parent::__construct( $meta_box );
	}

	/**
	 * Setter method for the field meta property.
	 *
	 * @param MB_Term_Meta_Field $field_meta The field meta object.
	 */
	public function set_field_meta_object( MB_Term_Meta_Field $field_meta ) {
		$this->field_meta = $field_meta;
	}

	/**
	 * Specific hooks for meta box object. Default is 'post'.
	 * This should be extended in sub-classes to support meta fields for terms, user, settings pages, etc.
	 */
	protected function object_hooks() {
		// Add meta fields to edit term page.
		add_action( 'load-edit-tags.php', array( $this, 'add' ) );
		add_action( 'load-term.php', array( $this, 'add' ) );

		// Save term meta.
		foreach ( $this->meta_box['taxonomies'] as $taxonomy ) {
			add_action( "edited_$taxonomy", array( $this, 'save' ) );
		}

		add_action( "rwmb_before_{$this->meta_box['id']}", array( $this, 'show_heading' ) );
	}

	/**
	 * Show heading of the section.
	 */
	public function show_heading() {
		echo '<h2>', esc_html( $this->meta_box['title'] ), '</h2>';
	}

	/**
	 * Add meta box to term edit form, each meta box is a section.
	 */
	public function add() {
		if ( ! $this->is_edit_screen() ) {
			return;
		}

		// Add meta box.
		foreach ( $this->meta_box['taxonomies'] as $taxonomy ) {
			add_action( "{$taxonomy}_edit_form", array( $this, 'show' ), 10, 2 );
		}

		// Change field meta.
		add_filter( 'rwmb_field_meta', array( $this->field_meta, 'meta' ), 10, 3 );
	}

	/**
	 * Enqueue styles for term meta.
	 */
	public function enqueue() {
		if ( ! $this->is_edit_screen() ) {
			return;
		}

		// Backward compatibility.
		if ( method_exists( $this, 'admin_enqueue_scripts' ) ) {
			parent::admin_enqueue_scripts();
		} else {
			parent::enqueue();
		}
		list( , $url ) = RWMB_Loader::get_path( dirname( dirname( __FILE__ ) ) );
		wp_enqueue_style( 'mb-term-meta', $url . 'css/style.css', '', '1.0.2' );
	}

	/**
	 * Save meta fields for terms.
	 *
	 * @param int $term_id Term ID.
	 */
	public function save( $term_id ) {
		// Check whether form is submitted properly.
		$nonce = (string) filter_input( INPUT_POST, "nonce_{$this->meta_box['id']}" );
		if ( ! wp_verify_nonce( $nonce, "rwmb-save-{$this->meta_box['id']}" ) ) {
			return;
		}

		foreach ( $this->fields as $field ) {
			$name   = $field['id'];
			$single = $field['clone'] || ! $field['multiple'];
			$old    = get_term_meta( $term_id, $name, $single );
			$new    = isset( $_POST[ $name ] ) ? $_POST[ $name ] : ( $single ? '' : array() );

			// Allow field class change the value.
			if ( $field['clone'] ) {
				$new = RWMB_Clone::value( $new, $old, $term_id, $field );
			} else {
				$new = RWMB_Field::call( $field, 'value', $new, $old, $term_id );
				$new = RWMB_Field::filter( 'sanitize', $new, $field );
			}
			$new = RWMB_Field::filter( 'value', $new, $field, $old );

			$this->field_meta->save( $new, $old, $term_id, $field );
		}
	}

	/**
	 * Check if term meta is saved.
	 *
	 * @return bool
	 */
	public function is_saved() {
		$term_id = filter_input( INPUT_GET, 'tag_ID', FILTER_SANITIZE_NUMBER_INT );

		foreach ( $this->fields as $field ) {
			$value = get_term_meta( $term_id, $field['id'], ! $field['multiple'] );
			if (
				( ! $field['multiple'] && '' !== $value )
				|| ( $field['multiple'] && array() !== $value )
			) {
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
		$screen = get_current_screen();

		return
			( 'edit-tags' === $screen->base || 'term' === $screen->base )
			&& in_array( $screen->taxonomy, $this->meta_box['taxonomies'], true );
	}
}
