<?php 

if (!defined('ABSPATH')) {
	exit;
}

/*  Add credit to admin area --------------------------------------------------------*/
if (!function_exists('pipdig_footer_admin')) {
	function pipdig_footer_admin () {
		echo 'Powered by <a href="'.esc_url('http://www.wordpress.org/').'" target="_blank">WordPress</a>. Enhanced by <a href="'.esc_url('http://www.pipdig.co/?utm_source=wp-dashboard&utm_medium=footer&utm_campaign=wp-dashboard').'" target="_blank">pipdig</a>.';
	}
	add_filter('admin_footer_text', 'pipdig_footer_admin');
}



/*	Remove pointless front end widgets ----------------------------------------------*/
if (!function_exists('pipdig_p3_unregister_widgets')) {
	function pipdig_p3_unregister_widgets() {
		unregister_widget('WP_Widget_Pages');
		unregister_widget('WP_Widget_Links');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_Recent_Posts');
		unregister_widget('WP_Widget_Recent_Comments');

		unregister_widget('Jetpack_Gravatar_Profile_Widget');
		unregister_widget('WPCOM_Widget_Facebook_LikeBox');
		unregister_widget('Jetpack_Gallery_Widget');
		unregister_widget('Jetpack_RSS_Links_Widget');
		unregister_widget('wpcom_social_media_icons_widget');
		unregister_widget('Jetpack_Display_Posts_Widget');
		unregister_widget('Jetpack_Top_Posts_Widget');
		unregister_widget('Jetpack_Contact_Info_Widget');
		
		unregister_widget('Akismet_Widget');
		unregister_widget('SocialCountPlus');
		unregister_widget('GADWP_Frontend_Widget');
		
	}
	add_action('widgets_init', 'pipdig_p3_unregister_widgets', 11);
}


/*	Remove pointless dashboard widgets ----------------------------------------------*/
if (!function_exists('pipdig_p3_pipdig_remove_dashboard_meta')) {
	function pipdig_p3_pipdig_remove_dashboard_meta() {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	}
	add_action( 'admin_init', 'pipdig_p3_pipdig_remove_dashboard_meta' );
}


/*	Remove pointless meta boxes on posts --------------------------------------------*/
function pipdig_p3_remove_default_metaboxes() {
	// posts:
	remove_meta_box( 'trackbacksdiv','post','normal' );
	//remove_meta_box( 'slugdiv','post','normal' );
	remove_meta_box( 'revisionsdiv','post','normal' );
	// pages:
	remove_meta_box( 'postexcerpt','page','normal' );
	if (get_theme_mod('page_comments')){ remove_meta_box( 'commentstatusdiv','page','normal' ); }
	remove_meta_box( 'trackbacksdiv','page','normal' );
	//remove_meta_box( 'slugdiv','page','normal' );
	remove_meta_box( 'revisionsdiv','page','normal' );
}
add_action('admin_menu','pipdig_p3_remove_default_metaboxes');



/*  Dashboard widgets ----------------------------------------------------------------*/
function pipdig_p3_dashboard_widgets() {
	add_meta_box( 
		'pipdig_p3_dashboard_social_count',
		'pipdig - '.__('Your Followers', 'p3'),
		'pipdig_p3_dashboard_social_count_func',
		'dashboard',
		'side',
		'high'
	);
}
add_action( 'wp_dashboard_setup', 'pipdig_p3_dashboard_widgets' );

function pipdig_p3_dashboard_social_count_func() {
	if (!is_admin()) {
		return;
	}
	pipdig_p3_scrapey_scrapes();
	$bloglovin = absint(get_option('p3_bloglovin_count'));
	$pinterest = absint(get_option('p3_pinterest_count'));
	$twitter = absint(get_option('p3_twitter_count'));
	$facebook = absint(get_option('p3_facebook_count'));
	$instagram = absint(get_option('p3_instagram_count'));
	$youtube = absint(get_option('p3_youtube_count'));
	$google_plus = absint(get_option('p3_google_plus_count'));
	$total = $bloglovin + $pinterest + $twitter + $facebook + $instagram + $youtube + $google_plus;
	if ($total < 1) {
		?><p>This widget will display social media follower stats for any links added to <a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>">this page</a>.</p><?php
	} else {
	?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/amcharts.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/pie.js"></script>
		
			<script type="text/javascript">
				AmCharts.makeChart("chartdiv",
					{
						"type": "pie",
						"balloonText": "",
						"labelRadius": 5,
						"startRadius": "25%",
						"colors": [
							"#5ea9dd",
							"#447398",
							"#cb2027",
							"#37aeed",
							"#dd4c39",
							"#3b5998",
							"#ff7200",
							"#0D8ECF",
							"#0D52D1",
							"#2A0CD0",
							"#8A0CCF",
							"#CD0D74",
							"#754DEB",
							"#DDDDDD",
							"#999999",
							"#333333",
							"#000000",
							"#57032A",
							"#CA9726",
							"#990000",
							"#4B0C25"
						],
						"hoverAlpha": 0.74,
						"sequencedAnimation": false,
						"startDuration": 0,
						"startEffect": "easeOutSine",
						"titleField": "channel",
						"urlTarget": "_blank",
						"valueField": "count",
						"fontFamily": "Open Sans, sans-serif",
						"fontSize": 11,
						"handDrawn": true,
						"handDrawThickness": 2,
						"hideBalloonTime": 120,
						"percentPrecision": 0,
						"theme": "default",
						"allLabels": [],
						"balloon": {},
						"titles": [],
						"dataProvider": [

					<?php if (!empty($twitter)) { ?>
						{channel: "Twitter", count: <?php echo $twitter; ?>},
					<?php } ?>

					<?php if (!empty($instagram)) { ?>
						{channel: "Instagram", count: <?php echo $instagram; ?>},
					<?php } ?>

					<?php if (!empty($pinterest)) { ?>
						{channel: "Pinterest", count: <?php echo $pinterest; ?>},
					<?php } ?>

					<?php if (!empty($bloglovin)) { ?>
						{channel: "Bloglovin", count: <?php echo $bloglovin; ?>},
					<?php } ?>

					<?php if (!empty($google_plus)) { ?>
						{channel: "Google+", count: <?php echo $google_plus; ?>},
					<?php } ?>

					<?php if (!empty($soundcloud)) { ?>
						{channel: "Soundcloud", count: <?php echo $soundcloud; ?>},
					<?php } ?>

					<?php if (!empty($facebook)) { ?>
						{channel: "Facebook", count: <?php echo $facebook; ?>},
					<?php } ?>

					<?php if (!empty($youtube)) { ?>
						{channel: "YouTube", count: <?php echo $youtube; ?>},
					<?php } ?>

					<?php if (!empty($tumblr)) { ?>
						{channel: "Tumblr", count: <?php echo $tumblr; ?>},
					<?php } ?>

					<?php if (!empty($linkedin)) { ?>
						{channel: "LinkedIn", count: <?php echo $linkedin; ?>},
					<?php } ?>
						]
					}
				);
			</script>

			<div id="chartdiv" style="width: 100%; height: 300px;" ></div>
			<style scoped>
			.amcharts-chart-div a {
				font-size: 0!important;
			}
			</style>
			<p><a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>"><?php _e('Click here to add more accounts', 'p3'); ?></a>.</p>
		<?php
		}

}