<?php

// If uninstall not called from WordPress exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || ! WP_UNINSTALL_PLUGIN || dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) ) ) {
    status_header( 404 );
    exit;
}

// delete transients
delete_transient( 'pipdig_random_posts_widget' );
delete_transient( 'pipdig_popular_posts_widget' );

// delete database entries
delete_option( 'pipdig_bloglovin_follower_count' );
delete_option( 'pipdig_theme_pinterest_count' );