<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

/*
include_once (ABSPATH.'wp-admin/includes/plugin.php');
if (!is_plugin_active('beaver-builder-lite-version/fl-builder.php')) {
	return;
}
*/

function pipdig_beaver_post_types( $post_types ) {
    $post_types[] = 'post';
    return $post_types;
}
add_filter( 'fl_builder_post_types', 'pipdig_beaver_post_types' );


function pipdig_beaver_modules( $enabled, $instance ) {

    $disable = array( 'sidebar', 'widget' );

    if ( in_array( $instance->slug, $disable ) ) {
        return false;
    }

    return $enabled;
}
add_filter( 'fl_builder_register_module', 'pipdig_beaver_modules', 10, 2 );