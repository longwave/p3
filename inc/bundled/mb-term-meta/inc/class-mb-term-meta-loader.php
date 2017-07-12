<?php
/**
 * Loader for term meta.
 *
 * @package    Meta Box
 * @subpackage MB Term Meta
 * @author     Tran Ngoc Tuan Anh <rilwis@gmail.com>
 */

/**
 * Loader class
 */
class MB_Term_Meta_Loader {
	/**
	 * Meta boxes for terms only.
	 * Use static variable to be accessible outside the class (in MB Rest API plugin).
	 *
	 * @var array
	 */
	public static $meta_boxes = array();

	/**
	 * Run hooks to get meta boxes for terms and initialize them.
	 */
	public function init() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'filter' ), 999 );

		/**
		 * Initialize meta boxes for term.
		 * 'rwmb_meta_boxes' runs at priority 10, we use priority 20 to make sure self::$meta_boxes is set.
		 */
		add_action( 'init', array( $this, 'register' ), 20 );

		add_filter( 'rwmb_meta_type', array( $this, 'filter_meta_type' ), 10, 3 );
	}

	/**
	 * Filter meta boxes to get only meta boxes for terms and remove them from posts.
	 *
	 * @param array $meta_boxes List of meta boxes.
	 *
	 * @return array
	 */
	public function filter( $meta_boxes ) {
		foreach ( $meta_boxes as $k => $meta_box ) {
			if ( isset( $meta_box['taxonomies'] ) ) {
				self::$meta_boxes[] = $meta_box;
				unset( $meta_boxes[ $k ] );
			}
		}

		return $meta_boxes;
	}

	/**
	 * Register meta boxes for term, each meta box is a section
	 */
	public function register() {
		$field_meta     = new MB_Term_Meta_Field;
		$field_registry = rwmb_get_registry( 'field' );

		foreach ( self::$meta_boxes as $meta_box ) {
			$meta_box = new MB_Term_Meta_Box( $meta_box );
			$meta_box->set_field_meta_object( $field_meta );

			foreach ( $meta_box->fields as $field ) {
				foreach ( $meta_box->taxonomies as $taxonomy ) {
					$field_registry->add( $field, $taxonomy, 'term' );
				}
			}
		}
	}

	/**
	 * Filter meta type from object type and object id.
	 *
	 * @param string $type        Meta type get from object type and object id. Assert taxonomy name if object type is term.
	 * @param string $object_type Object type.
	 * @param int    $object_id   Object id.
	 *
	 * @return string
	 */
	public function filter_meta_type( $type, $object_type, $object_id ) {
		if ( 'term' !== $object_type ) {
			return $type;
		}

		$term = get_term( $object_id );
		return isset( $term->taxonomy ) ? $term->taxonomy : $type;
	}
}
