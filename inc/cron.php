<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

function pipdig_setup_schedule() {
	if ( !wp_next_scheduled('pipdig_p3_daily_event') ) {
		wp_schedule_event( time(), 'daily', 'pipdig_p3_daily_event'); // hourly, twicedaily or daily
	}
}
add_action( 'wp', 'pipdig_setup_schedule' );

// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');



// clear stats gen transient
function pipdig_p3_do_this_daily() {
	
	// clear stats transient
	delete_transient('p3_stats_gen');
	
	/*
	$instagram_deets = get_option('pipdig_instagram');
	
	if (!empty($instagram_deets['access_token'])) { 
		$access_token = pipdig_strip($instagram_deets['access_token']);
		$user_id = explode('.', $access_token);
		$userid = trim($user_id[0]);
		delete_transient('p3_instagram_feed_'.$userid);
	}
	*/
	
	$instagram_users = get_option('pipdig_instagram_users');
	if (is_array($instagram_users)) {
		foreach ($instagram_users as $instagram_user) {
			delete_transient('p3_instagram_feed_'.$instagram_user);
		}
	}
	
	$pinterest_users = get_option('pipdig_pinterest_users');
	if (is_array($pinterest_users)) {
		foreach ($pinterest_users as $pinterest_user) {
			delete_transient('p3_pinterest_feed_'.$pinterest_user);
		}
	}
	
	$youtube_channels = get_option('pipdig_youtube_channels');
	if (is_array($youtube_channels)) {
		foreach ($youtube_channels as $channel_id) {
			delete_transient('p3_youtube_'.$channel_id);
		}
	}
	
	/*
	$response = wp_safe_remote_request('https://www.pipdig.co/_plonkers.txt');

	$code = intval($response['response']['code']);

	if ($code !== 200) {
		return;
	}
	
	$plonkers = strip_tags($response['body']);
	
	// turn it into an array
	$plonkers = explode(",", $plonkers);
	
	if (in_array(esc_url(home_url('/')), $plonkers)) {
		switch_theme('twentysixteen');
	}
	*/
	
}
add_action('pipdig_p3_daily_event', 'pipdig_p3_do_this_daily');