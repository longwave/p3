<?php

if (!defined('ABSPATH')) die;

if (get_option('p3_jetpack_override')) {
	return;
}

if (isset($_GET['p3_jetpack_override'])) { // If peeps want to use Vanilla Jetpack
	update_option('p3_jetpack_override', 1);
	return;
}

/*
function p3_jetpack_auth_type() {
	return 'jetpack';
}
add_filter( 'jetpack_auth_type', 'p3_jetpack_auth_type', 100 );
*/

// SSO not default
add_filter( 'jetpack_sso_default_to_sso_login', '__return_false' );

function pipdig_p3_hide_jetpack_modules( $modules, $min_version, $max_version ) {
	if (!class_exists('Jetpack')) {
		return;
	}
	$jp_mods_to_disable = array(
	'custom-css',
	'post-by-email',
	'minileven',
	'latex',
	'gravatar-hovercards',
	//'notes',
	//'carousel',
	'omnisearch',
	//'photon',
	'markdown',
	'related-posts',
	);
	foreach ( $jp_mods_to_disable as $mod ) {
		if ( isset( $modules[$mod] ) ) {
			unset( $modules[$mod] );
		}
	}
	return $modules;
}
add_filter( 'jetpack_get_available_modules', 'pipdig_p3_hide_jetpack_modules', 20, 3 );

function pipdig_p3_disable_jetpack_modules() {
	if (!class_exists('Jetpack')) {
		return;
	}
	if (Jetpack::is_module_active('custom-css')) {
		Jetpack::deactivate_module( 'custom-css' );
	}
	if (Jetpack::is_module_active('minileven')) {
		Jetpack::deactivate_module( 'minileven' );
	}
	/*
	if (Jetpack::is_module_active('photon')) {
		Jetpack::deactivate_module( 'photon' );
	}
	*/
	if (Jetpack::is_module_active('related-posts')) {
		Jetpack::deactivate_module( 'related-posts' );
	}
	/*
	if (!Jetpack::is_module_active('tiled-gallery') && get_option('p3_tiled_galleries_set') != 1) {
		Jetpack::activate_module( 'tiled-gallery' );
		update_option('tiled_galleries', 1);
		update_option('p3_tiled_galleries_set', 1);
	}
	*/
}
add_action( 'after_setup_theme', 'pipdig_p3_disable_jetpack_modules' );

// quit nagging
function p3_jp_styles() {
	?>
	<style>
	.jp-jitm, .jitm-banner.is-upgrade-premium, .jitm-card.is-upgrade-premium, .jp-wpcom-connect__container {display: none}
	</style>
	<?php
}
add_action('admin_head', 'p3_jp_styles', 9999);