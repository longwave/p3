<?php
/**
 * Handle field actions for terms.
 *
 * @package    Meta Box
 * @subpackage MB Term Meta
 */

/**
 * Field class.
 */
class MB_Term_Meta_Field {
	/**
	 * Add hooks for fields edit screen.
	 */
	public function init() {
		// Change field meta.
		add_filter( 'rwmb_field_meta', array( $this, 'meta' ), 10, 3 );
	}

	/**
	 * Get field meta value
	 *
	 * @param mixed $meta  Meta value.
	 * @param array $field Field parameters.
	 * @param bool  $saved Is meta box saved.
	 *
	 * @return mixed
	 */
	public function meta( $meta, $field, $saved ) {
		$term_id = filter_input( INPUT_GET, 'tag_ID', FILTER_SANITIZE_NUMBER_INT );

		$single = $field['clone'] || ! $field['multiple'];
		$meta   = get_term_meta( $term_id, $field['id'], $single );

		// For taxonomy advanced: ignore "multiple" as values are saved in 1 row.
		if ( 'taxonomy_advanced' === $field['type'] ) {
			$meta = get_term_meta( $term_id, $field['id'], true );
			$meta = wp_parse_id_list( $meta );
			$meta = array_filter( $meta );
		}

		// Use $field['std'] only when the meta box hasn't been saved (i.e. the first time we run).
		$meta = ( ! $saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

		// Escape attributes.
		$meta = RWMB_Field::call( $field, 'esc_meta', $meta );

		// Make sure meta value is an array for clonable and multiple fields.
		if ( $field['clone'] || $field['multiple'] ) {
			if ( empty( $meta ) || ! is_array( $meta ) ) {
				/**
				 * Note: if field is clonable, $meta must be an array with values
				 * so that the foreach loop in self::show() runs properly
				 *
				 * @see self::show()
				 */
				$meta = $field['clone'] ? array( '' ) : array();
			}
		}

		return $meta;
	}
}
