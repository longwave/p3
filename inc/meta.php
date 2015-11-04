<?php 

if (!defined('ABSPATH')) {
	exit;
}

/*
if (pipdig_plugin_check('rewardstyle-widgets/rewardstyle-widgets.php')) { 
	include_once('meta/rewardstyle.php');
}
*/

if (get_theme_mod('p3_full_width_slider_site_main_enable')) {
	include_once('meta/full_width_slider.php');
}
