<?php

if (!defined('ABSPATH')) die;

// used in image, profile and snapcode widget
function pipdig_image_upload_script() {
	global $pagenow, $wp_customize;
	if ('widgets.php' === $pagenow || isset($wp_customize)) {
		wp_enqueue_media();
		wp_enqueue_script('pipdig-image-upload', plugin_dir_url( __FILE__ ) . '../assets/js/image-upload.js', array('jquery'));
	}
}
add_action('admin_enqueue_scripts', 'pipdig_image_upload_script');

include('widgets/bloglovin.php');
include('widgets/socialz.php');
include('widgets/pinterest.php');
include('widgets/youtube.php');
include('widgets/profile.php');
include('widgets/facebook.php');
include('widgets/instagram.php');
include('widgets/clw.php');
include('widgets/popular-posts.php');
include('widgets/random-posts.php');
include('widgets/subscribe.php');
include('widgets/snapcode.php');
include('widgets/post-slider.php');
include('widgets/twitter.php');
include('widgets/we-heart-it.php');
include('widgets/image.php');
include('widgets/goodreads.php');
include('widgets/featured-post.php');
include('widgets/google-adsense.php');
include('widgets/spotify.php');

function p3_register_widgets() {
	register_widget('pipdig_widget_facebook');
	register_widget('pipdig_widget_latest_youtube');
	register_widget('pipdig_widget_spotify');
	register_widget('pipdig_widget_weheartit');
	register_widget('pipdig_theme_bloglovin_widget');
	register_widget('pipdig_widget_clw');
	register_widget('pipdig_widget_weheartit');
	register_widget('pipdig_widget_featured_post_function');
	register_widget('pipdig_widget_google_adsense');
	register_widget('pipdig_Image_Widget');
	register_widget('pipdig_widget_instagram');
	register_widget('pipdig_widget_pinterest');
	register_widget('pipdig_widget_twitter');
	register_widget('pipdig_widget_subscribe');
	register_widget('pipdig_widget_popular_posts');
	register_widget('pipdig_widget_post_slider');
	register_widget('pipdig_widget_profile_function');
	register_widget('pipdig_widget_random_posts');
	register_widget('pipdig_p3_snapchat_snapcode');
	register_widget('pipdig_widget_social_icons');
}
add_action('widgets_init', 'p3_register_widgets');