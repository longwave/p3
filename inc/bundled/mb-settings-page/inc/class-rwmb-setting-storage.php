<?php
/**
 * Option storage
 *
 * @package    Meta Box
 * @subpackage MB Term Meta
 */

if ( ! interface_exists( 'RWMB_Storage_Interface' ) ) {
	return;
}

/**
 * Class RWMB_Setting_Storage
 */
class RWMB_Setting_Storage implements RWMB_Storage_Interface {

	/**
	 * Get value from storage.
	 *
	 * @param  int    $object_id Object id. Use option name in this case.
	 * @param  string $name      Field name.
	 * @param  array  $args      Custom arguments.
	 *
	 * @return mixed
	 */
	public function get( $object_id, $name, $args = array() ) {
		$options = get_option( $object_id, array() );
		return isset( $options[ $name ] ) ? $options[ $name ] : '';
	}
}
