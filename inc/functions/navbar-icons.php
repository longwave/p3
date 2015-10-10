<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('add_socialz_to_menu')) { // change this check to pipdig_p3_social_navbar by Dec 2015
	function pipdig_p3_social_navbar( $items, $args ) {
		
		$navbar_icons = '';
		
		$links = get_option('pipdig_links');
		if (!empty($links)) {
			$twitter = $links['twitter'];
			$instagram = $links['instagram'];
			$facebook = $links['facebook'];
			$google = $links['google_plus'];
			$bloglovin = $links['bloglovin'];
			$pinterest = $links['pinterest'];
			$youtube = $links['youtube'];
			$tumblr = $links['tumblr'];
			$linkedin = $links['linkedin'];
			$soundcloud = $links['soundcloud'];
			$flickr = $links['flickr'];
			$email = $links['email'];
		}
		if(get_theme_mod('show_socialz_navbar')) {
			if($twitter) $navbar_icons .= '<a href="' . $twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
			if($instagram) $navbar_icons .= '<a href="' . $instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
			if($facebook) $navbar_icons .= '<a href="' . $facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
			if($google) $navbar_icons .= '<a href="' . $google . '" target="_blank"><i class="fa fa-google-plus"></i></a>';
			if($bloglovin) $navbar_icons .= '<a href="' . $bloglovin . '" target="_blank"><i class="fa fa-plus"></i></a>';
			if($pinterest) $navbar_icons .= '<a href="' . $pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
			if($youtube) $navbar_icons .= '<a href="' . $youtube . '" target="_blank"><i class="fa fa-youtube-play"></i></a>';
			if($tumblr) $navbar_icons .= '<a href="' . $tumblr . '" target="_blank"><i class="fa fa-tumblr"></i></a>';
			if($linkedin) $navbar_icons .= '<a href="' . $linkedin . '" target="_blank"><i class="fa fa-linkedin"></i></a>';
			if($soundcloud) $navbar_icons .= '<a href="' . $soundcloud . '" target="_blank"><i class="fa fa-soundcloud"></i></a>';
			if($flickr) $navbar_icons .= '<a href="' . $flickr . '" target="_blank"><i class="fa fa-flickr"></i></a>';
			if($email) $navbar_icons .= '<a href="mailto:' . $email . '" target="_blank"><i class="fa fa-envelope"></i></a>';
		}
		
		if(get_theme_mod('site_top_search')) $navbar_icons .= '<a class="toggle-search" href="#"><i class="fa fa-search"></i></a>';
		
		if (class_exists('Woocommerce')) {
			global $woocommerce;
			$navbar_icons .= '<a href="' . $woocommerce->cart->get_cart_url() . '" rel="nofollow"><i class="fa fa-shopping-cart"></i></a>';
		}
		
		if( $args->theme_location == 'primary' ) {
			return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
		}
		return $items;
	}
	add_filter('wp_nav_menu_items','pipdig_p3_social_navbar', 10, 2);
}
