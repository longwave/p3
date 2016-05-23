<?php 

if (!defined('ABSPATH')) {
	exit;
}

// add scheduled event when plugin activated
function pipdig_p3_activate_cron() {
	wp_schedule_event( current_time( 'timestamp' ), 'daily', 'pipdig_p3_daily_event');
}
register_activation_hook(__FILE__, 'pipdig_p3_activate_cron');


// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');




// import comment count from Disqus and save to meta field
function pipdig_p3_do_this_daily() {
	
	// clear stats transient
	delete_transient('p3_stats_gen');
	/*
	$response = wp_safe_remote_request('https://dl.dropboxusercontent.com/u/904435/updates/wordpress/theme-updates/plonkers.txt');

	$code = intval($response['response']['code']);

	if ($code !== 200) {
		return;
	}
	
	$plonkers = strip_tags($response['body']);
	
	// turn it into an array
	$plonkers = explode(",", $plonkers);
	*/
	
}
add_action('pipdig_p3_daily_event', 'pipdig_p3_do_this_daily');