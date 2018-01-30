<?php
/**
 * Term storage
 *
 * @package    Meta Box
 * @subpackage MB Term Meta
 */

if ( class_exists( 'RWMB_Base_Storage' ) ) {
	/**
	 * Class RWMB_Term_Storage
	 */
	class RWMB_Term_Storage extends RWMB_Base_Storage {

		/**
		 * Object type.
		 *
		 * @var string
		 */
		protected $object_type = 'term';
	}
}
