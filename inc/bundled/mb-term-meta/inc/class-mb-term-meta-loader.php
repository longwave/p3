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
		add_filter( 'rwmb_meta_box_class_name', array( $this, 'meta_box_class_name' ), 10, 2 );

		add_filter( 'rwmb_meta_type', array( $this, 'filter_meta_type' ), 10, 3 );

		add_filter( 'rwmb_meta_boxes', array( $this, 'load_meta_boxes_legacy' ), 9999 );
	}

	/**
	 * Filter meta box class name.
	 *
	 * @param  string $class_name Meta box class name.
	 * @param  array  $meta_box   Meta box data.
	 * @return string
	 */
	public function meta_box_class_name( $class_name, $meta_box ) {
		if ( isset( $meta_box['taxonomies'] ) ) {
			$class_name = 'MB_Term_Meta_Box';
		}

		return $class_name;
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

	/**
	 * Store meta boxes to static variable to make compatible with Admin Columns.
	 *
	 * @param  array $meta_boxes Array of meta boxes.
	 * @return array
	 */
	public function load_meta_boxes_legacy( $meta_boxes ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( ! isset( $meta_box['taxonomies'] ) ) {
				continue;
			}

			self::$meta_boxes[] = $meta_box;
		}

		return $meta_boxes;
	}
}
