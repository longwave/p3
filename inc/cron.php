<?php if (!defined('ABSPATH')) die;

if (!wp_next_scheduled('pipdig_p3_daily_event')) {
	wp_schedule_event( time(), 'daily', 'pipdig_p3_daily_event'); // hourly, twicedaily, daily
}
/*
if (!wp_next_scheduled('pipdig_p3_hourly_event')) {
	wp_schedule_event( time(), 'hourly', 'pipdig_p3_hourly_event');
}
*/

// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
	//wp_clear_scheduled_hook('pipdig_p3_hourly_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');

// Daily event
function p3_do_this_daily() {

	pipdig_p3_scrapey_scrapes();
	delete_transient('pipdig_fonts');
	update_option('link_manager_enabled', 0);
	
	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['user_id'])) {
		$instagram_user = sanitize_text_field($instagram_deets['user_id']);
		delete_transient('p3_instagram_feed_'.$instagram_user);
	}

}
add_action('pipdig_p3_daily_event', 'p3_do_this_daily');

// Hourly event
/*
function p3_do_this_hourly() {
	
}
add_action('pipdig_p3_hourly_event', 'p3_do_this_hourly');
*/