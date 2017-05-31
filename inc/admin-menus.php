<?php

if (!defined('ABSPATH')) die;

if (!function_exists('pipdig_add_admin_menu')) {
	function pipdig_add_admin_menu() {
	
		global $submenu;
		add_menu_page( 'pipdig', 'pipdig', 'delete_others_pages', 'pipdig', 'pipdig_help_options_page', 'dashicons-star-filled' );
		//add_submenu_page( 'pipdig', __('Help / Support', 'p3'), __('Help / Support', 'p3'), 'delete_others_pages', 'pipdig-help', 'pipdig_help_options_page' );
		add_submenu_page( 'pipdig', 'WP101 Videos', 'WP101 Videos', 'delete_others_pages', 'pipdig-wp101', 'pipdig_wp101_options_page' );
		add_submenu_page( 'pipdig', __('Social Stats', 'p3'), __('Social Stats', 'p3'), 'delete_others_pages', 'pipdig-stats', 'pipdig_stats_options_page' );
		add_submenu_page( 'pipdig', __('Social Links', 'p3'), __('Social Links', 'p3'), 'delete_others_pages', 'pipdig-links', 'pipdig_links_options_page' );
		add_submenu_page( 'pipdig', 'Instagram', 'Instagram', 'manage_options', 'pipdig-instagram', 'pipdig_instagram_options_page' );
		add_submenu_page( 'pipdig', __('Custom CSS', 'p3'), __('Custom CSS', 'p3'), 'manage_options', 'pipdig-css', 'pipdig_css_options_page' );
		add_submenu_page( 'pipdig', __('Theme').' Hooks', __('Theme').' Hooks', 'manage_options', 'pipdig-hooks', 'pipdig_hooks_options_page' );
		
		if (current_user_can('delete_others_pages')) {
			$submenu['pipdig'][0][0] = __('Help / Support', 'p3'); // http://wordpress.stackexchange.com/questions/98226/admin-menus-name-menu-different-from-first-submenu
		}
		
	}
	add_action( 'admin_menu', 'pipdig_add_admin_menu' );
}

require_once('admin-menus/help.php');
require_once('admin-menus/css.php');
require_once('admin-menus/hooks.php');
require_once('admin-menus/stats.php');
require_once('admin-menus/links.php');
require_once('admin-menus/instagram.php');

function pipdig_wp101_options_page() { 
	?>
	<script>
		window.location.replace("https://go.pipdig.co/open.php?id=wp101videos");
	</script>
	<h1>WP101 Video Tutorials</h1>
	<p><a href="https://go.pipdig.co/open.php?id=wp101videos" target="_blank">Click here</a> if you are not automatically redirected within 5 seconds.</p
	<?php
}