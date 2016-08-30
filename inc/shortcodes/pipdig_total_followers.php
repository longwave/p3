<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_total_followers]
function pipdig_total_followers_shortcode( $atts, $content = null ) {
	
	$bloglovin = absint(get_option('p3_bloglovin_count'));
	$pinterest = absint(get_option('p3_pinterest_count'));
	$twitter = absint(get_option('p3_twitter_count'));
	$facebook = absint(get_option('p3_facebook_count'));
	$instagram = absint(get_option('p3_instagram_count'));
	$youtube = absint(get_option('p3_youtube_count'));
	$google_plus = absint(get_option('p3_google_plus_count'));
	$twitch = absint(get_option('p3_twitch_count'));
	
	// scp
	$linkedin = absint(get_option('p3_linkedin_count'));
	$tumblr = absint(get_option('p3_tumblr_count'));
	$soundcloud = absint(get_option('p3_soundcloud_count'));
	
	
	$total = $bloglovin + $pinterest + $twitter + $facebook + $instagram + $youtube + $google_plus + $twitch + $linkedin + $tumblr + $soundcloud;
	
	return number_format_i18n($total);
	
}
add_shortcode( 'pipdig_total_followers', 'pipdig_total_followers_shortcode' );