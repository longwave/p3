<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('pipdig_add_admin_menu')) {
	function pipdig_add_admin_menu() {
	
		global $submenu;
		add_menu_page( 'pipdig', 'pipdig', 'manage_options', 'pipdig', 'pipdig_updates_options_page', 'dashicons-star-filled' );
		add_submenu_page( 'pipdig', 'Shortcodes', 'Shortcodes', 'manage_options', 'pipdig-shortcodes', 'pipdig_shortcodes_options_page' );
		add_submenu_page( 'pipdig', __('Social Stats', 'p3'), __('Social Stats', 'p3'), 'manage_options', 'pipdig-stats', 'pipdig_stats_options_page' );
		add_submenu_page( 'pipdig', __('Social Links', 'p3'), __('Social Links', 'p3'), 'manage_options', 'pipdig-links', 'pipdig_links_options_page' );
		//add_submenu_page( 'pipdig', 'Instagram', 'Instagram', 'manage_options', 'pipdig-instagram', 'pipdig_instagram_options_page' );
		add_submenu_page( 'pipdig', __('Custom CSS', 'p3'), __('Custom CSS', 'p3'), 'manage_options', 'pipdig-css', 'pipdig_css_options_page' );
		add_submenu_page( 'pipdig', __('Theme', 'p3').' Hooks', __('Theme', 'p3').' Hooks', 'manage_options', 'pipdig-hooks', 'pipdig_hooks_options_page' );
		$submenu['pipdig'][0][0] = __('Updates', 'p3'); // http://wordpress.stackexchange.com/questions/98226/admin-menus-name-menu-different-from-first-submenu
	}
	add_action( 'admin_menu', 'pipdig_add_admin_menu' );
}

require_once('admin-menus/updates.php');
require_once('admin-menus/shortcodes.php');
require_once('admin-menus/css.php');
require_once('admin-menus/hooks.php');
require_once('admin-menus/stats.php');
require_once('admin-menus/links.php');
//require_once('admin-menus/instagram.php');