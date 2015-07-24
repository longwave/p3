<?php

/* Returns a "Continue Reading" link for excerpts. -------------------------*/
function pipdig_continue_reading_link() {
	return '<a href="'. esc_url( get_permalink() ) . '" class="more-link">' . __( 'View Post', 'pipdig-textdomain' ) . '</a>';
}



/* Numbered Pagination -------------------------------------------------*/
if (!function_exists('pipdig_pagination')) {
	function pipdig_pagination() {
		
		$prev_arrow = is_rtl() ? '&rarr;' : '&larr;';
		$next_arrow = is_rtl() ? '&larr;' : '&rarr;';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // crazy high integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> '<i class="fa fa-chevron-left"></i> ' . __( 'Newer Posts', 'pipdig-textdomain'),
				'next_text'		=> __( 'Older Posts', 'pipdig-textdomain') . ' <i class="fa fa-chevron-right"></i>',
			 ) );
		}
	}
}

/* Add Featured Image to feed -------------------------------------------------------*/
if (!function_exists('pipdig_rss_post_thumbnail')) {
	function pipdig_rss_post_thumbnail($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . get_the_excerpt();
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'pipdig_rss_post_thumbnail');
	add_filter('the_content_feed', 'pipdig_rss_post_thumbnail');
}



/* Add socialz, super search and cart to navbar -------------------------------------------------*/
if (!function_exists('add_socialz_to_menu')) {
	function add_socialz_to_menu( $items, $args ) {
		$twitter = get_theme_mod('socialz_twitter');
		$instagram = get_theme_mod('socialz_instagram');
		$facebook = get_theme_mod('socialz_facebook');
		$google = get_theme_mod('socialz_google_plus');
		$bloglovin = get_theme_mod('socialz_bloglovin');
		$pinterest = get_theme_mod('socialz_pinterest');
		$youtube = get_theme_mod('socialz_youtube');
		$tumblr = get_theme_mod('socialz_tumblr');
		$linkedin = get_theme_mod('socialz_linkedin');
		$soundcloud = get_theme_mod('socialz_soundcloud');
		$flickr = get_theme_mod('socialz_flickr');
		$email = get_theme_mod('socialz_email');
		$navbar_icons = '';
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
			if($email) $navbar_icons .= '<a href="' . $email . '" target="_blank"><i class="fa fa-envelope"></i></a>';
		}
		if(get_theme_mod('site_top_search')) $navbar_icons .= '<a class="toggle-search" href="#"><i class="fa fa-search"></i></a>';
		
		if (pipdig_woocommerce_activated()) {
			global $woocommerce;
			$navbar_icons .= '<a href="' . $woocommerce->cart->get_cart_url() . '" rel="nofollow"><i class="fa fa-shopping-cart"></i></a>';
		}
		
		if( $args->theme_location == 'primary' ) {
			return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
		}
		return $items;
	}
	add_filter('wp_nav_menu_items','add_socialz_to_menu', 10, 2);
}


/* Add search field to navbar ------------------------------------------
add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu($items, $args) {

        ob_start();
        get_search_form();
        $searchform = ob_get_contents();
        ob_end_clean();

        $items .= '<li>' . $searchform . '</li>';

    return $items;
}
*/




/* Show a home link. ----------------------------------------------------------------*/
function pipdig_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'clearfix menu-bar';
	return $args;
}
add_filter( 'wp_page_menu_args', 'pipdig_page_menu_args' );





/* Add custom class to comment avatar. ---------------------------------------*/
function pipdig_avatar_class($class) {
	$class = str_replace("class='avatar", "class='comment-avatar ", $class) ;
	return $class;
}
add_filter( 'get_avatar', 'pipdig_avatar_class' );




/* Open Graph stuff ----------------------------------------------------------*/
if (!pipdig_plugin_check('wordpress-seo/wp-seo.php')) {
	add_filter('language_attributes', 'add_og_xml_ns');
	function add_og_xml_ns($content) {
		return $content . ' prefix="og: http://ogp.me/ns#"';
	}
}




// stop jetpack from adding OG tags http://jetpack.me/2013/05/03/remove-open-graph-meta-tags/
add_filter( 'jetpack_enable_open_graph', '__return_false' );




/*
function pipdig_mobile_detect() {
	if (!get_theme_mod('disable_responsive')) { // Check if responsive layout has been disabled in cust. If so, let's continue:
		if (pipdig_plugin_check('wp-super-cache/wp-cache.php') || pipdig_plugin_check('w3-total-cache/w3-total-cache.php') || pipdig_plugin_check('quick-cache/quick-cache.php') || pipdig_plugin_check('wp-fastest-cache/wpFastestCache.php') || pipdig_plugin_check('hyper-cache/plugin.php')) {
			// If there is a cache plugin active, let's jump ship:
			return false;
		} else {
			// No obvious cache plugin, so let's check if it's a mobile:
			require_once('inc/mobile_detect.php');
			$detect = new Mobile_Detect();
			if($detect->isMobile() && !$detect->isTablet()) {
				return true;
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}
*/


/*-----------------------------------------------------------------------------------*/
/*  Remove #more-link on manually added read more buttons
/* ----------------------------------------------------------------------------------*/

function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );



/*-----------------------------------------------------------------------------------*/
/*  Link images to post rather than image.  Except on posts themselves.
/* ----------------------------------------------------------------------------------*/

// function pipdig_image_permalink($content){

//	$format = get_post_format();
//	$searchfor = '/(<img[^>]*\/>)/';
//	$replacewith = '<a href="'.get_permalink().'">$1</a>';

//	if (is_archive() === true){
//		$content = preg_replace($searchfor, $replacewith, $content); // $content = preg_replace($searchfor, $replacewith, $content, 1) FOR FIRST IMAGE ONLY
//	}
//	return $content;
// }
// add_filter('the_content', 'pipdig_image_permalink');



