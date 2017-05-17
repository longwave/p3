<?php 
if (!defined('ABSPATH')) die;

if (!class_exists('FLBuilder')) {
	return;
}

function p3_beaver_post_types( $post_types ) {
    $post_types[] = 'post';
    return $post_types;
}
add_filter( 'fl_builder_post_types', 'p3_beaver_post_types' );


function p3_beaver_modules( $enabled, $instance ) {

    $disable = array( 'sidebar', 'widget' );

    if ( in_array( $instance->slug, $disable ) ) {
        return false;
    }

    return $enabled;
}
add_filter( 'fl_builder_register_module', 'p3_beaver_modules', 10, 2 );