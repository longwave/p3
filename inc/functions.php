<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


// load plugin check function, just in case theme hasn't
if ( !function_exists( 'pipdig_plugin_check' ) ) {
	function pipdig_plugin_check( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active($plugin_name) ) {
			return true;
		} else {
			return false;
		}
	}
}



/*
if (!function_exists('pipdig_p3_mobile_detect')) {
	function pipdig_p3_mobile_detect() {
		if (!get_theme_mod('disable_responsive')) { // Check if responsive layout has been disabled in cust. If so, let's continue:
			if (pipdig_plugin_check('wp-super-cache/wp-cache.php') || pipdig_plugin_check('w3-total-cache/w3-total-cache.php') || pipdig_plugin_check('quick-cache/quick-cache.php') || pipdig_plugin_check('wp-fastest-cache/wpFastestCache.php') || pipdig_plugin_check('hyper-cache/plugin.php')) {
				// If there is a cache plugin active, let's jump ship:
				return false;
			} else {
				// No obvious cache plugin, so let's check if it's a mobile:
				require_once(dirname(__FILE__).'/third/Mobile_Detect.php');
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
}
*/



// load image catch function, just in case theme hasn't
if (!function_exists('pipdig_p3_catch_that_image')) {
	function pipdig_p3_catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(empty($output)){
			return '//pipdigz.co.uk/p3/img/catch-placeholder.jpg';
		}
		$first_img = $matches [1] [0];
		return $first_img;
	}
}

// use public CDNs for jquery
if (!class_exists('JCP_UseGoogleLibraries') && !function_exists('pipdig_p3_cdn')) {
	function pipdig_p3_cdn() {global $wp_scripts;
		if (!is_admin()) {
			$jquery_ver = $wp_scripts->registered['jquery']->ver;
			$jquery_migrate_ver = $wp_scripts->registered['jquery-migrate']->ver;
			wp_deregister_script('jquery');
			wp_deregister_script('jquery-migrate');
			wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/'.$jquery_ver.'/jquery.min.js', false, null, false);
			wp_enqueue_script('jquery-migrate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'.$jquery_migrate_ver.'/jquery-migrate.min.js', false, null, false);
		}
	}
	add_action('wp_enqueue_scripts', 'pipdig_p3_cdn', 9999);
}

// comments count
if (!function_exists('pipdig_p3_comment_count')) {
	function pipdig_p3_comment_count() {
		if (!post_password_required()) {
			$comment_count = get_comments_number();
			if ($comment_count < 2 ) {
				$comments_text = __('Comments', 'p3');
			} else {
				$comments_text = number_format_i18n($comment_count).' '.__('Comments', 'p3');
			}
			echo $comments_text;
		}
	}
}

// comments nav
if (!function_exists('pipdig_p3_comment_nav')) {
	function pipdig_p3_comment_nav() {
		echo '<div class="nav-previous">'.previous_comments_link('<i class="fa fa-arrow-left"></i> '.__('Older Comments', 'p3')).'</div>';
		echo '<div class="nav-next">'.next_comments_link(__('Newer Comments', 'p3').' <i class="fa fa-arrow-right"></i>').'</div>';
	}
}




function pipdig_p3_scrapey_scrapes() {
		
	$links = get_option('pipdig_links');
			
	// Bloglovin --------------------
	$bloglovin_url = $links['bloglovin'];
	if($bloglovin_url) {
		$bloglovin = wp_remote_fopen($bloglovin_url, array( 'timeout' => 10 ));
		$bloglovin_doc = new DOMDocument();
			libxml_use_internal_errors(true); //disable libxml errors
			if(!empty($bloglovin)){ //if any html is actually returned
				$bloglovin_doc->loadHTML($bloglovin);
				libxml_clear_errors(); //remove errors for yucky html
				$bloglovin_xpath = new DOMXPath($bloglovin_doc);
				$bloglovin_row = $bloglovin_xpath->query('//div[@class="num"]');
				if($bloglovin_row->length > 0){
				foreach($bloglovin_row as $row){
					$followers = $row->nodeValue;
					$followers = str_replace(' ', '', $followers);
					$followers_int = intval($followers);
					update_option('p3_bloglovin_count', $followers_int);
				}
			}
		}
	} else {
		delete_option('p3_bloglovin_count');
	}
		
	// Facebook --------------------
	$facebook_url = $links['facebook'];
	if($facebook_url) {
		usleep(500);
		$facebook_id = parse_url($facebook_url, PHP_URL_PATH);
		$facebook_id = str_replace('/', '', $facebook_id);
		$appid = '7222'.'093312'.'18125';
		$apsec = '3f9d'.'971ecad0debb'.'c0b983b7af6fcf34';
		$json_url ='https://graph.facebook.com/'.$facebook_id.'?access_token='.$appid.'|'.$apsec.'&fields=likes';
		$json = wp_remote_fopen($json_url);
		$json_output = json_decode($json);
		if($json_output->likes){
			$likes = intval($json_output->likes);
			update_option('p3_facebook_count', $likes);
		}
	} else {
		delete_option('p3_facebook_count');
	}
	
	// Pinterest ---------------------
	// <meta property="pinterestapp:followers" name="pinterestapp:followers" content="106168" data-app>
	// SELECT * from html where url="https://www.pinterest.com/thelovecatsinc" AND xpath="//meta[@property='pinterestapp:followers']"
	$pinterest_url = $links['pinterest'];
	if ($pinterest_url) {
		$pinterest_url = rawurlencode($pinterest_url);
		usleep(500);
		$pinterest_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$pinterest_url."%22%20AND%20xpath%3D%22%2F%2Fmeta%5B%40property%3D'pinterestapp%3Afollowers'%5D%22&format=json", array( 'timeout' => 10 ));
		$pinterest_yql = json_decode($pinterest_yql);
		$pinterest_count = intval($pinterest_yql->query->results->meta->content);
		update_option('p3_pinterest_count', $pinterest_count);
	} else {
		delete_option('p3_pinterest_count');
	}
	
	
	
	
	// Twitter ---------------------
	$twitter_url = $links['twitter'];
	if ($twitter_url) {
		usleep(500);
		$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
		$twitter_handle = str_replace('/', '', $twitter_handle);
		require_once('TwitterAPIExchange.php');
		$settings = array(
			'oauth_access_token' => '331530555'.'-'.'BYUS6g6XsQfjRn'.'l1gmnGGl3oLao4I3CIMVYonm31',
			'oauth_access_token_secret' => 'pugNxZDRn8ds3'.'TAladgVC6bpyxHb'.'n1nYJRDJFYizbR0vf',
			'consumer_key' => '1FDHA'.'vyiq7OToA'.'kxUuYkY9n'.'x1',
			'consumer_secret' => 'fK'.'E9GTb4JW6UUUfUxv'.'83ghO5MOMdEb4F0tzrtHzBlQWXQyK'.'G'.'be'
		);
		$ta_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name='.$twitter_handle;
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$follow_count = $twitter->setGetfield($getfield)
		->buildOauth($ta_url, $requestMethod)
		->performRequest();
		$data = json_decode($follow_count, true);
		$followers_count = intval($data[0]['user']['followers_count']);
		update_option('p3_twitter_count', $followers_count);
	} else {
		delete_option('p3_twitter_count');
	}


	// Instagram ---------------------
	// <span data-reactid=".0.1.0.0:0.1.3.1.0.1" title="476,475" class="-cx-PRIVATE-FollowedByStatistic__count">476k</span>
	// SELECT * from html where url="http://instagram.com/inthefrow" AND xpath="//li[2]/span"
	$instagram_url = $links['instagram'];
	if ($instagram_url) {
		$instagram_url = rawurlencode($instagram_url);
		usleep(4000);
		$instagram_yql = wp_remote_fopen("http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$instagram_url."%22%20AND%20xpath%3D%22%2F%2Fli%5B2%5D%2Fspan%22&format=json", array( 'timeout' => 10 ));
		$instagram_yql = json_decode($instagram_yql);
		$instagram_count = $instagram_yql->query->results->span->span[1]->title;
		$instagram_count = intval(str_replace(',', '', $instagram_count));
		update_option('p3_instagram_count', $instagram_count);
	} else {
		delete_option('p3_instagram_count');
	}
		
	// YouTube ---------------------
	// SELECT * from html where url="https://www.youtube.com/user/inthefrow" AND xpath="//span[@class='yt-subscription-button-subscriber-count-branded-horizontal yt-uix-tooltip']"
	$youtube_url = $links['youtube'];
	if ($youtube_url) {
		$youtube_url = rawurlencode($youtube_url);
		usleep(5000);
		$youtube_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$youtube_url."%22%20AND%20xpath%3D%22%2F%2Fspan%5B%40class%3D'yt-subscription-button-subscriber-count-branded-horizontal%20yt-uix-tooltip'%5D%22&format=json", array( 'timeout' => 10 ));
		$youtube_yql = json_decode($youtube_yql);
		$youtube_count = $youtube_yql->query->results->span->title;
		$youtube_count = intval(str_replace(',', '', $youtube_count));
		update_option('p3_youtube_count', $youtube_count);
	} else {
		delete_option('p3_youtube_count');
	}
		
	// Google Plus ---------------------
	// https://www.googleapis.com/plus/v1/people/102904094379339545145?key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c    OR YQL below:
	// SELECT * from html where url="https://plus.google.com/+Inthefrowpage/about" AND xpath="//div[@class='Zmjtc']/span"
	$google_plus_url = $links['google_plus'];
	if ($google_plus_url) {
		$google_plus_url = rawurlencode($google_plus_url);
		usleep(5000);
		$google_plus_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$google_plus_url."%22%20AND%20xpath%3D%22%2F%2Fdiv%5B%40class%3D'Zmjtc'%5D%2Fspan%22&format=json&diagnostics=true", array( 'timeout' => 10 ));
		$google_plus_yql = json_decode($google_plus_yql);
		$google_plus_count = $google_plus_yql->query->results->span[0]->content;
		$google_plus_count = intval(str_replace(',', '', $google_plus_count));
		update_option('p3_google_plus_count', $google_plus_count);
	} else {
		delete_option('p3_google_plus_count');
	}
	
}

	
function pipdig_p3_social_footer() {
	
	$links = get_option('pipdig_links');
	
	if(!empty($links)) {
		if ( !get_transient('p3_stats_gen') ) {
			pipdig_p3_scrapey_scrapes();
			set_transient('p3_stats_gen', true, 6 * HOUR_IN_SECONDS);
		}
	}
	
	$count = 0;
	$twitter_count = get_option('p3_twitter_count');
	$facebook_count = get_option('p3_facebook_count');
	$instagram_count = get_option('p3_instagram_count');
	$youtube_count = get_option('p3_youtube_count');
	$pinterest_count = get_option('p3_pinterest_count');
	$bloglovin_count = get_option('p3_bloglovin_count');
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}

	if ( $twitter_count )
		$count++;

	if ( $facebook_count )
		$count++;

	if ( $instagram_count )
		$count++;

	if ( $youtube_count )
		$count++;
	
	if ( $pinterest_count )
		$count++;
	
	if ( $bloglovin_count )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'col-xs-12';
			break;
		case '2':
			$class = 'col-'.$sm.'-6';
			break;
		case '3':
			$class = 'col-'.$md.'-4';
			break;
		case '4':
			$class = 'col-'.$md.'-3';
			break;
		case '5':
			$class = 'col-'.$md.'-5ths';
			break;
		case '6':
			$class = 'col-'.$md.'-2';
			break;
	}

	if ( $class ) {
		$colz = 'class="' . $class . '"';
	}

	$output = '<div class="clearfix extra-footer-outer social-footer-outer">';
	$output .= '<div class="container">';
	$output .= '<div class="row social-footer">';
	
	$total_count = $twitter_count + $facebook_count + $instagram_count + $youtube_count + $bloglovin_count + $pinterest_count;
	
	if ($total_count) {
	
		if(!empty($twitter_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['twitter'].'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> Twitter | '.$twitter_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($facebook_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['facebook'].'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> Facebook | '.$facebook_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($instagram_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['instagram'].'" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i> Instagram | '.$instagram_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($youtube_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['youtube'].'" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i> YouTube | '.$youtube_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($pinterest_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['pinterest'].'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i> Pinterest | '.$pinterest_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($bloglovin_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['bloglovin'].'" target="_blank" rel="nofollow"><i class="fa fa-plus"></i> Bloglovin | '.$bloglovin_count.'</a>';
		$output .= '</div>';
		}
		
	}
		
	$output .= '</div>	
</div>
</div>
<style scoped>#instagramz{margin-top:0}</style>';
	
	echo $output;

}


/* Add socialz, super search and cart to navbar -------------------------------------------------*/
if (!function_exists('add_socialz_to_menu')) { // change this check to pipdig_p3_social_navbar by Dec 2015
	function pipdig_p3_social_navbar( $items, $args ) {
		$links = get_option('pipdig_links');
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

	
	
/* Add Featured Image to feed -------------------------------------------------------*/
if (!function_exists('pipdig_rss_post_thumbnail')) {
	function pipdig_p3_rss_post_thumbnail($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . get_the_excerpt();
		} elseif (pipdig_p3_catch_that_image()) {
			$content = '<p><img src="'.pipdig_p3_catch_that_image().'" alt=""/></p>' . get_the_excerpt();
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'pipdig_p3_rss_post_thumbnail');
	add_filter('the_content_feed', 'pipdig_p3_rss_post_thumbnail');
}



// remove mojo crap
if (function_exists('mm_load_updater')) {
	function pipdig_p3_bad_mojo() {
		remove_action( 'admin_menu', 'mm_main_menu' ); // remove mojo menu
		remove_action( 'widgets_init', 'mm_register_widget' ); // remove mojo widget
		remove_action( 'admin_head-themes.php', 'mm_add_theme_button' ); // remove mojo theme menu item
		remove_action( 'admin_menu', 'mm_add_theme_page' ); // remove mojo themes link
	}
	add_action('plugins_loaded','pipdig_p3_bad_mojo');
}



// add pipdig link to themes section
function pipdig_p3_themes_top_link() {
	if(!isset($_GET['page'])) {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.add-new-h2').before('<a class="add-new-h2" href="http://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig <?php _e('Themes', 'p3'); ?></a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' );



function pipdig_p3_emmmm_heeey() {
	?>
	<script>	
	jQuery(document).ready(function($) {
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			   $("#cookie-law-info-bar,.cc_container").slideUp();
		   } else {
			   $("#cookie-law-info-bar,.cc_container").slideDown()
		   }
		});
	});
	</script>
	<?php
}
add_action('wp_footer','pipdig_p3_emmmm_heeey');


/*  Remove pointless front end widgets ----------------------------------------------*/
function pipdig_p3_unregister_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');

	unregister_widget('Jetpack_Gravatar_Profile_Widget');
	unregister_widget('WPCOM_Widget_Facebook_LikeBox');
	unregister_widget('Jetpack_Gallery_Widget');
	unregister_widget('Jetpack_RSS_Links_Widget');
	unregister_widget('wpcom_social_media_icons_widget');
	unregister_widget('Jetpack_Display_Posts_Widget');
	unregister_widget('Jetpack_Top_Posts_Widget');
	
	unregister_widget('Akismet_Widget');
	unregister_widget('SocialCountPlus');
	unregister_widget('GADWP_Frontend_Widget');
	
	
}
add_action('widgets_init', 'pipdig_p3_unregister_widgets', 11);



/*  Remove pointless dashboard widgets ----------------------------------------------*/
function pipdig_p3_pipdig_remove_dashboard_meta() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'pipdig_p3_pipdig_remove_dashboard_meta' );



/*  Remove pointless meta boxes on posts --------------------------------------------*/
function pipdig_p3_remove_default_post_metaboxes() {
	remove_meta_box( 'trackbacksdiv','post','normal' );
	remove_meta_box( 'slugdiv','post','normal' );
	remove_meta_box( 'revisionsdiv','post','normal' );
}
add_action('admin_menu','pipdig_p3_remove_default_post_metaboxes');



/*  Remove pointless meta boxes on pages --------------------------------------------*/
function pipdig_p3_remove_default_page_metaboxes() {
	remove_meta_box( 'postexcerpt','page','normal' );
	if (get_theme_mod('page_comments')){ remove_meta_box( 'commentstatusdiv','page','normal' ); }
	remove_meta_box( 'trackbacksdiv','page','normal' );
	remove_meta_box( 'slugdiv','page','normal' );
	remove_meta_box( 'revisionsdiv','page','normal' );
}
add_action('admin_menu','pipdig_p3_remove_default_page_metaboxes');



// Heartbeat rate
if ( !function_exists( 'heartbeat_control_menu' ) ) {
	function pipdig_p3_heartbeat_settings( $settings ) {
		$settings['interval'] = 45; // anything between 15-60
		return $settings;
	}
	add_filter( 'heartbeat_settings', 'pipdig_p3_heartbeat_settings' );
}


// hide tabs on social count plus
/*
if (pipdig_plugin_check('social-count-plus/social-count-plus.php')) {
	function hide_complex_tabs_social_count_plus() {
		$screen = get_current_screen();
		if (is_object($screen) && $screen->id == 'settings_page_social-count-plus') {
			echo '<style>.nav-tab-wrapper{display:none!important}</style>';
		}
	}
	add_action('admin_footer', 'hide_complex_tabs_social_count_plus');
}
*/

function p3_flush_htacess() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function p3_htaccess_edit($rules) {
$p3_rules = "
# p3 gzip
<ifmodule mod_deflate.c>
AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript text/javascript
</ifmodule>
# /p3 gzip

# p3 Blogger
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{QUERY_STRING} ^m=1$
RewriteRule ^(.*)$ /$1? [R=301,L]
</IfModule>
# /p3 Blogger

";
return $p3_rules . $rules;
}
add_filter('mod_rewrite_rules', 'p3_htaccess_edit');