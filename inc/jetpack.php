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
function p3_jp_authflow(){
	if ( false === ( $results = get_transient( 'p3_jp_authflow' ) )) {
		$url = 'https://pipdigz.co.uk/p3/jp/';
		$response = wp_remote_get($url);
		$results = '';
		if (!is_wp_error($response)) {
			$code = intval(json_decode($response['response']['code']));
			if ($code === 200) {
				$results = absint($response['body']);
			}
		}
		set_transient( 'p3_jp_authflow', $results, 1 * DAY_IN_SECONDS );
	}
	
	if ($results === 1) {
		return 'jetpack';
	}
}
add_filter( 'jetpack_auth_type', 'p3_jp_authflow', 100 );
*/

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
	//'lazy-images',
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
	if (get_theme_mod('p3_pinterest_hover_enable_posts') && Jetpack::is_module_active('lazy-images')) {
		Jetpack::deactivate_module( 'lazy-images' );
	}
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
	.jp-jitm, .jitm-banner, .jp-wpcom-connect__container {display:none!important}
	</style>
	<?php
}
add_action('admin_head', 'p3_jp_styles', 9999);