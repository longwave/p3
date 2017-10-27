<?php 

if (!defined('ABSPATH')) die;

if ( !wp_next_scheduled('pipdig_p3_daily_event') ) {
	wp_schedule_event( time(), 'twicedaily', 'pipdig_p3_daily_event'); // hourly, twicedaily or daily
}


// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');



// clear stats gen transient
function pipdig_p3_do_this_daily() {
	
	delete_option('p3_update_notice_1');
	delete_option('p3_update_notice_2');
	delete_option('p3_update_notice_3');
	
	if (get_option('p3_endurance_cache_set') != 1) {
		update_option('endurance_cache_level', 0);
		update_option('p3_endurance_cache_set', 1);
	}
	
	// clear stats transient
	//delete_transient('p3_stats_gen');
	
	// do a scrape
	pipdig_p3_scrapey_scrapes();

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
	
	delete_option('jpibfi_pro_ad');
	
}
add_action('pipdig_p3_daily_event', 'pipdig_p3_do_this_daily');