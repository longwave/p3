<?php
// create admin menus

if (!function_exists('pipdig_add_admin_menu')) {
	function pipdig_add_admin_menu() {
	
		global $submenu;
		add_menu_page( 'pipdig', 'pipdig', 'manage_options', 'pipdig', 'pipdig_main_options_page', 'dashicons-star-filled' );
		add_submenu_page( 'pipdig', __('Custom CSS', 'p3'), __('Custom CSS', 'p3'), 'manage_options', 'pipdig-css', 'pipdig_css_options_page' );
		add_submenu_page( 'pipdig', __('Theme Hooks', 'p3'), __('Theme Hooks', 'p3'), 'manage_options', 'pipdig-hooks', 'pipdig_hooks_options_page' );
		$submenu['pipdig'][0][0] = 'Guides'; // http://wordpress.stackexchange.com/questions/98226/admin-menus-name-menu-different-from-first-submenu
		
	}
	add_action( 'admin_menu', 'pipdig_add_admin_menu' );
}

require_once('admin-menus/guides.php'); // guides
require_once('admin-menus/css.php'); // css
require_once('admin-menus/hooks.php'); // hooks