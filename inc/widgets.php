<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

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
//include('widgets/depop.php');
include('widgets/image.php');
//include('widgets/goodreads.php');
include('widgets/featured-post.php');