<?php 
// get rid of some bad jetpack smells
function pipdig_p3_kill_jetpack_modules( $modules, $min_version, $max_version ) {
        $jp_mods_to_disable = array(
        // 'shortcodes',
        // 'widget-visibility',
        // 'contact-form',
        // 'shortlinks',
         'infinite-scroll',
        // 'wpcc',
         'tiled-gallery',
         'json-api',
        // 'publicize',
        // 'vaultpress',
        // 'custom-css',
         'post-by-email',
        // 'widgets',
        // 'comments',
         'minileven',
         'latex',
         'gravatar-hovercards',
        // 'enhanced-distribution',
        // 'notes',
        // 'subscriptions',
        // 'stats',
        // 'after-the-deadline',
        // 'carousel',
         'photon',
         'sharedaddy',
         'omnisearch',
         'mobile-push',
        // 'likes',
        // 'videopress',
        // 'gplus-authorship',
        // 'sso',
         'monitor',
         'markdown',
        // 'manage',
        // 'verification-tools',
         'related-posts',
        // 'custom-content-types',
         'site-icon',
        // 'protect',
    );
    foreach ( $jp_mods_to_disable as $mod ) {
        if ( isset( $modules[$mod] ) ) {
            unset( $modules[$mod] );
        }
    }
    return $modules;
}
add_filter( 'jetpack_get_available_modules', 'pipdig_p3_kill_jetpack_modules', 20, 3 );

// remove cruddy jetpack widgets
function pipdig_p3_jetpack() {
	remove_action('widgets_init', 'jetpack_facebook_likebox_init');
	remove_action('widgets_init', 'wpcom_social_media_icons_widget_load_widget');
	remove_action('widgets_init', 'jetpack_top_posts_widget_init');
	remove_action('widgets_init', 'jetpack_display_posts_widget');
}
add_action('jetpack_modules_loaded','pipdig_p3_jetpack');

