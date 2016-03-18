<?php

//add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

// enqueue scripts and styles
function pipdig_p3_scripts_styles() {
	wp_enqueue_style( 'p3-core', plugin_dir_url(__FILE__).'assets/css/core.css', array(), PIPDIG_P3_V );
	if (!get_theme_mod('disable_responsive')) { wp_enqueue_style( 'p3-responsive', plugin_dir_url(__FILE__).'assets/css/responsive.css', array(), PIPDIG_P3_V ); }
	
	//wp_register_script( 'imagesloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js', array('jquery'), false ); // I know, I know :(
	//wp_register_script( 'bxslider', '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js', array('jquery'), false );
	wp_register_script( 'pipdig-cycle', '//cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js', array('jquery'), null, false );
	wp_register_script( 'owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', array('jquery'), null, false );
	wp_register_script( 'backstretch', '//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), null, false );
	wp_register_script( 'stellar', '//cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js', array('jquery'), null, true );
	wp_register_script( 'rateyo', plugin_dir_url(__FILE__).'assets/js/rateyo.js', array('jquery'), null, true );
	wp_enqueue_script( 'pipdig-fitvids', '//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'pipdig-mixitup', '//cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', array( 'jquery' ), null, true );
	
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'pipdig_p3_scripts_styles');


// functions
require_once('inc/functions.php');

// admin menus
require_once('inc/admin-menus.php');

// meta boxes
require_once('inc/meta.php');

// dashboard enhancements
require_once('inc/dash.php');

// widgets
require_once('inc/widgets.php');

// shortcodes
require_once('inc/shortcodes.php');

if (!function_exists('sar_block_xmlrpc_attacks')) {
	function p3_block_xmlrpc_attacks( $methods ) {
	   unset( $methods['pingback.ping'] );
	   unset( $methods['pingback.extensions.getPingbacks'] );
	   unset( $methods['system.multicall'] );
	   return $methods;
	}
	add_filter( 'xmlrpc_methods', 'p3_block_xmlrpc_attacks' );
}

if (!function_exists('sar_remove_x_pingback_header')) {
	function p3_remove_x_pingback_header( $headers ) {
	   unset( $headers['X-Pingback'] );
	   return $headers;
	}
	add_filter( 'wp_headers', 'p3_remove_x_pingback_header' );
}
