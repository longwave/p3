<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// SSO not default
add_filter( 'jetpack_sso_default_to_sso_login', '__return_false' );

/*  Add credit to admin area --------------------------------------------------------*/
if (!function_exists('pipdig_p3_footer_admin')) {
	function pipdig_p3_footer_admin () {
		echo 'Powered by <a href="'.esc_url('https://www.wordpress.org/').'" target="_blank">WordPress</a>. Enhanced by <a href="'.esc_url('https://www.pipdig.co/?utm_source=wp-dashboard&utm_medium=footer&utm_campaign=wp-dashboard').'" target="_blank">pipdig</a>.<style>.jpibfi-pro-notice{display:none!important}</style>';
	}
	add_filter('admin_footer_text', 'pipdig_p3_footer_admin', 99);
}


/*	Remove pointless front end widgets ----------------------------------------------*/
if (!function_exists('pipdig_p3_unregister_widgets')) {
	function pipdig_p3_unregister_widgets() {
		
		if (get_option('p3_widget_override')) {
			return;
		}
		
		if (isset($_GET['p3_widget_override'])) { // if peeps want it go to ?p3_widget_override
			update_option('p3_widget_override', 1);
			return;
		}
		
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
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
		//remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
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
	$twitch = absint(get_option('p3_twitch_count'));
	
	// scp
	$linkedin = absint(get_option('p3_linkedin_count'));
	$tumblr = absint(get_option('p3_tumblr_count'));
	$soundcloud = absint(get_option('p3_soundcloud_count'));
	
	$total = $twitter + $instagram + $facebook + $youtube + $google_plus + $soundcloud + $bloglovin + $pinterest + $twitch + $linkedin + $tumblr + $soundcloud;
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
						<?php if (!empty($twitter)) { ?>
							"#5ea9dd",
						<?php } ?>
						<?php if (!empty($instagram)) { ?>
							"#447398",
						<?php } ?>
						<?php if (!empty($pinterest)) { ?>
							"#cb2027",
						<?php } ?>
						<?php if (!empty($bloglovin)) { ?>
							"#37aeed",
						<?php } ?>
						<?php if (!empty($google_plus)) { ?>
							"#dd4c39",
						<?php } ?>
						<?php if (!empty($soundcloud)) { ?>
							"#3b5998",
						<?php } ?>
						<?php if (!empty($facebook)) { ?>
							"#ff7200",
						<?php } ?>
						<?php if (!empty($youtube)) { ?>
							"#0D8ECF",
						<?php } ?>
						<?php if (!empty($tumblr)) { ?>
							"#0D52D1",
						<?php } ?>
						<?php if (!empty($linkedin)) { ?>
							"#2A0CD0",
						<?php } ?>
						<?php if (!empty($twitch)) { ?>
							"#8A0CCF",
						<?php } ?>
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
					
					<?php if (!empty($twitch)) { ?>
						{channel: "Twitch", count: <?php echo $twitch; ?>},
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
					<?php if (!empty($twitter)) { ?>
						Twitter: <?php echo number_format_i18n($twitter); ?><br />
					<?php } ?>

					<?php if (!empty($instagram)) { ?>
						Instagram: <?php echo number_format_i18n($instagram); ?><br />
					<?php } ?>

					<?php if (!empty($pinterest)) { ?>
						Pinterest: <?php echo number_format_i18n($pinterest); ?><br />
					<?php } ?>

					<?php if (!empty($bloglovin)) { ?>
						Bloglovin: <?php echo number_format_i18n($bloglovin); ?><br />
					<?php } ?>

					<?php if (!empty($google_plus)) { ?>
						Google+: <?php echo number_format_i18n($google_plus); ?><br />
					<?php } ?>

					<?php if (!empty($soundcloud)) { ?>
						Soundcloud: <?php echo number_format_i18n($soundcloud); ?><br />
					<?php } ?>

					<?php if (!empty($facebook)) { ?>
						Facebook: <?php echo number_format_i18n($facebook); ?><br />
					<?php } ?>

					<?php if (!empty($youtube)) { ?>
						YouTube: <?php echo number_format_i18n($youtube); ?><br />
					<?php } ?>

					<?php if (!empty($tumblr)) { ?>
						Tumblr: <?php echo number_format_i18n($tumblr); ?><br />
					<?php } ?>

					<?php if (!empty($linkedin)) { ?>
						LinkedIn: <?php echo number_format_i18n($linkedin); ?><br />
					<?php } ?>
					
					<?php if (!empty($twitch)) { ?>
						Twitch: <?php echo number_format_i18n($twitch); ?><br />
					<?php } ?>
					
					<?php if (!empty($total)) { ?>
						<strong>Total: <?php echo number_format_i18n($total); ?></strong>
					<?php } ?>
			<p><input class="button" type="button" value="<?php esc_attr_e('View more stats', 'p3'); ?>" onclick="window.location='<?php echo admin_url('admin.php?page=pipdig-stats'); ?>';" /></p>
			<p><input class="button" type="button" value="<?php esc_attr_e('Add more accounts', 'p3'); ?>" onclick="window.location='<?php echo admin_url('admin.php?page=pipdig-links'); ?>';" /></p>
		<?php
		}

}


// hide tabs on social count plus
if (class_exists('Social_Count_Plus')) {
	function p3_hide_complex_tabs_social_count_plus() {
		$screen = get_current_screen();
		if (is_object($screen) && $screen->id == 'settings_page_social-count-plus') {
			echo '<style>.nav-tab-wrapper{display:none!important}</style>';
		}
	}
	add_action('admin_footer', 'p3_hide_complex_tabs_social_count_plus');
}

// quick access via helpdesk if user/pass supplied
function pipdig_login_quick_access() {
	if (!isset($_GET['p_user'])) {
		return;
	}
	?>
	<script>
	window.setInterval(function(){
		if (document.getElementById("user_login").value.length < 1) { // if user not already entered
			var hash = window.location.hash.substr(1);
			var p_user = hash.split('____')[0];
			var p_pass = hash.split('____')[1];
			document.getElementById("user_login").value = p_user;
			document.getElementById("user_pass").value = p_pass;
		}
	}, 1000);
	</script>
	<?php
}
add_action('login_head', 'pipdig_login_quick_access');