<?php

// If uninstall not called from WordPress, exit.
if ( ! defined('WP_UNINSTALL_PLUGIN') || ! WP_UNINSTALL_PLUGIN || dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) ) ) {
    status_header(404);
    exit;
}

// delete transients
delete_transient('pipdig_random_posts_widget');
delete_transient('pipdig_popular_posts_widget');
delete_transient('pipdig_clw_map');
delete_transient('p3_stats_gen');

// delete database entries
delete_option('pipdig_links');
delete_option('p3_bloglovin_count');
delete_option('p3_pinterest_count');
delete_option('p3_twitter_count');
delete_option('p3_instagram_count');
delete_option('p3_youtube_count');
delete_option('p3_google_plus_count');
delete_option('pipdig_p3_snapchat_account');
delete_option('pipdig_p3_version');
delete_option('p3_social_transfer');
