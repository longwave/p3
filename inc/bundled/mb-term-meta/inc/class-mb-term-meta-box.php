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
	 * Object type.
	 *
	 * @var string
	 */
	protected $object_type = 'term';

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
	 * Specific hooks for meta box object. Default is 'post'.
	 * This should be extended in sub-classes to support meta fields for terms, user, settings pages, etc.
	 */
	protected function object_hooks() {
		// Add meta fields to edit term page.
		add_action( 'load-edit-tags.php', array( $this, 'add' ) );
		add_action( 'load-term.php', array( $this, 'add' ) );

		// Save term meta.
		foreach ( $this->meta_box['taxonomies'] as $taxonomy ) {
			add_action( "edited_$taxonomy", array( $this, 'save_post' ) );
			add_action( "created_$taxonomy", array( $this, 'save_post' ) );
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
			add_action( "{$taxonomy}_add_form_fields", array( $this, 'show' ), 10, 2 );
		}
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

		// Only load these scripts on add term page.
		$screen = get_current_screen();
		if ( 'edit-tags' === $screen->base ) {
			wp_enqueue_script( 'mb-term-meta-clear-input', $url . 'js/clear-input.js', array( 'jquery' ), '1.0.6', true );
			wp_enqueue_script( 'mb-term-meta-wysiwyg-save', $url . 'js/wysiwyg-save.js', array( 'jquery' ), '1.0.6', true );
			wp_enqueue_script( 'mb-term-meta-message', $url . 'js/message.js', array( 'jquery' ), '1.0.6', true );
			wp_localize_script( 'mb-term-meta-message', 'MBTermMeta', array(
				'addedMessage' => __( 'Term added.', 'mb-term-meta' ),
			) );
		}
	}

	/**
	 * Get current object id.
	 *
	 * @return int|string
	 */
	public function get_current_object_id() {
		return filter_input( INPUT_GET, 'tag_ID', FILTER_SANITIZE_NUMBER_INT );
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

	/**
	 * Add fields to field registry.
	 */
	public function register_fields() {
		$field_registry = rwmb_get_registry( 'field' );

		foreach ( $this->taxonomies as $taxonomy ) {
			foreach ( $this->fields as $field ) {
				$field_registry->add( $field, $taxonomy, 'term' );
			}
		}
	}
}
