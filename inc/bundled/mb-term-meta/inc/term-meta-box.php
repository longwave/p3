<?php
/**
 * The main class of the plugin which handle show, edit, save custom fields (meta data) for terms.
 * @package    Meta Box
 * @subpackage MB Term Meta
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Class for handling custom fields (meta data) for terms.
 */
class MB_Term_Meta_Box extends RW_Meta_Box
{
	/**
	 * Constructor
	 * Call parent constructor and add specific hooks
	 * @param array $meta_box
	 */
	public function __construct( $meta_box )
	{
		// Allow to set 'taxonomies' param by string
		if ( isset( $meta_box['taxonomies'] ) && is_string( $meta_box['taxonomies'] ) )
		{
			$meta_box['taxonomies'] = array( $meta_box['taxonomies'] );
		}
		parent::__construct( $meta_box );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		// Prevent adding meta box to post
		$this->meta_box['post_types'] = $this->meta_box['pages'] = array();
		remove_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		remove_action( 'save_post_post', array( $this, 'save_post' ) );

		// Add meta fields to edit term page
		add_action( 'load-edit-tags.php', array( $this, 'add' ) );
		add_action( 'load-term.php', array( $this, 'add' ) );

		// Save term meta
		foreach ( $this->meta_box['taxonomies'] as $taxonomy )
		{
			add_action( "edited_$taxonomy", array( $this, 'save' ) );
		}
	}

	/**
	 * Add meta box to term edit form, each meta box is a section.
	 */
	public function add()
	{
		if ( ! $this->is_edit_screen() )
		{
			return;
		}

		// Add meta box
		foreach ( $this->meta_box['taxonomies'] as $taxonomy )
		{
			add_action( $taxonomy . '_edit_form', array( $this, 'show' ), 10, 2 );
		}

		// Filter field meta (saved value)
		add_filter( 'rwmb_field_meta', array( $this, 'field_meta' ), 10, 2 );
	}

	/**
	 * Enqueue styles for term meta.
	 */
	public function enqueue()
	{
		if ( ! $this->is_edit_screen() )
			return;

		// Backward compatibility
		if ( method_exists( $this, 'admin_enqueue_scripts' ) )
		{
			parent::admin_enqueue_scripts();
		}
		else
		{
			parent::enqueue();
		}
		list( , $url ) = RWMB_Loader::get_path( dirname( dirname( __FILE__ ) ) );
		wp_enqueue_style( 'mb-term-meta', $url . 'css/style.css', '', '1.0.2' );
	}

	/**
	 * Get field meta value
	 * @param mixed $meta  Meta value
	 * @param array $field Field parameters
	 * @return mixed
	 */
	public function field_meta( $meta, $field )
	{
		if ( empty( $_GET['tag_ID'] ) )
		{
			return $meta;
		}
		$term_id = intval( $_GET['tag_ID'] );

		$single = $field['clone'] || ! $field['multiple'];
		$meta   = get_term_meta( $term_id, $field['id'], $single );

		// Use $field['std'] only when the meta box hasn't been saved (i.e. the first time we run)
		$meta = ( ! $this->is_saved() && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

		// Escape attributes
		$meta = call_user_func( array( RW_Meta_Box::get_class_name( $field ), 'esc_meta' ), $meta );

		// Make sure meta value is an array for clonable and multiple fields
		if ( $field['clone'] || $field['multiple'] )
		{
			if ( empty( $meta ) || ! is_array( $meta ) )
			{
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
	 * Save meta fields for terms
	 * @param int $term_id
	 */
	public function save( $term_id )
	{
		// Check whether form is submitted properly
		$nonce = (string) filter_input( INPUT_POST, "nonce_{$this->meta_box['id']}" );
		if ( ! wp_verify_nonce( $nonce, "rwmb-save-{$this->meta_box['id']}" ) )
			return;

		foreach ( $this->fields as $field )
		{
			$name   = $field['id'];
			$single = $field['clone'] || ! $field['multiple'];
			$old    = get_term_meta( $term_id, $name, $single );
			$new    = isset( $_POST[$name] ) ? $_POST[$name] : ( $single ? '' : array() );

			// Allow field class change the value
			$new = call_user_func( array( self::get_class_name( $field ), 'value' ), $new, $old, 0, $field );
			$this->save_field( $new, $old, $term_id, $field );
		}
	}

	/**
	 * Save meta value.
	 *
	 * @param $new
	 * @param $old
	 * @param $term_id
	 * @param $field
	 */
	public function save_field( $new, $old, $term_id, $field )
	{
		$name = $field['id'];

		// Media fields: remove term meta to save order.
		if ( in_array( $field['type'], array( 'media', 'file_advanced', 'file_upload', 'image_advanced', 'image_upload' ) ) )
		{
			$old = array();
			delete_term_meta( $term_id, $name );
		}

		// Remove term meta if it's empty
		if ( '' === $new || array() === $new )
		{
			delete_term_meta( $term_id, $name );
			return;
		}

		// If field is cloneable, value is saved as a single entry in the database
		if ( $field['clone'] )
		{
			$new = (array) $new;
			foreach ( $new as $k => $v )
			{
				if ( '' === $v )
					unset( $new[$k] );
			}
			update_term_meta( $term_id, $name, $new );
			return;
		}

		// If field is multiple, value is saved as multiple entries in the database (WordPress behaviour)
		if ( $field['multiple'] )
		{
			foreach ( $new as $new_value )
			{
				if ( ! in_array( $new_value, $old ) )
					add_term_meta( $term_id, $name, $new_value, false );
			}
			foreach ( $old as $old_value )
			{
				if ( ! in_array( $old_value, $new ) )
					delete_term_meta( $term_id, $name, $old_value );
			}
			return;
		}

		// Default: just update term meta
		update_term_meta( $term_id, $name, $new );
	}

	/**
	 * Check if term meta is saved.
	 * @return bool
	 */
	public function is_saved()
	{
		if ( empty( $_GET['tag_ID'] ) )
		{
			return false;
		}
		$term_id = intval( $_GET['tag_ID'] );

		foreach ( $this->fields as $field )
		{
			$value = get_term_meta( $term_id, $field['id'], ! $field['multiple'] );
			if (
				( ! $field['multiple'] && '' !== $value )
				|| ( $field['multiple'] && array() !== $value )
			)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if we're on the right edit screen.
	 * @param WP_Screen $screen Screen object. Optional. Use current screen object by default.
	 * @return bool
	 */
	public function is_edit_screen( $screen = null )
	{
		$screen = get_current_screen();
		return
			( 'edit-tags' == $screen->base || 'term' == $screen->base )
			&& in_array( $screen->taxonomy, $this->meta_box['taxonomies'] );
	}
}
