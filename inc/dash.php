<?php 

if (!defined('ABSPATH')) die;

// https://make.wordpress.org/core/2018/01/17/auto-formatting-of-author-bios-reverted-in-4-9-2/
add_filter( 'get_the_author_description', 'wptexturize' );
add_filter( 'get_the_author_description', 'convert_chars' );
add_filter( 'get_the_author_description', 'wpautop' );
add_filter( 'get_the_author_description', 'shortcode_unautop' );

add_filter( 'send_email_change_email', '__return_false' );

if (!class_exists('Heartbeat_Control')) {
function pipdig_heartbeat_control($settings) {
    $settings['interval'] = 90;
    return $settings;
}
add_filter('heartbeat_settings', 'pipdig_heartbeat_control');
}

if (!function_exists('disable_emojis') && get_option('p3_emoji_override') != 1) {
function pipdig_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'pipdig_disable_emojis' );
}

function pipdig_p3_footer_admin () {
	echo 'Powered by <a href="'.esc_url('https://www.wordpress.org/').'" target="_blank">WordPress</a>. Enhanced by <a href="'.esc_url('https://www.pipdig.co/?utm_source=wp-dashboard&utm_medium=footer&utm_campaign=wp-dashboard').'" target="_blank">pipdig</a>.';
}
add_filter('admin_footer_text', 'pipdig_p3_footer_admin', 99);

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
		
	unregister_widget('Jetpack_Upcoming_Events_Widget');
	unregister_widget('Jetpack_My_Community_Widget');
	unregister_widget('Jetpack_Gravatar_Profile_Widget');
	unregister_widget('Jetpack_EU_Cookie_Law_Widget');
	unregister_widget('Jetpack_Internet_Defense_League_Widget');
	unregister_widget('WPCOM_Widget_Facebook_LikeBox');
	unregister_widget('Jetpack_MailChimp_Subscriber_Popup_Widget');
	unregister_widget('Jetpack_Twitter_Timeline_Widget');
	unregister_widget('Jetpack_Gallery_Widget');
	unregister_widget('Jetpack_RSS_Links_Widget');
	unregister_widget('wpcom_social_media_icons_widget');
	unregister_widget('Jetpack_Display_Posts_Widget');
	unregister_widget('Jetpack_Top_Posts_Widget');
	unregister_widget('Jetpack_Contact_Info_Widget');
	unregister_widget('Milestone_Widget');
	unregister_widget('Jetpack_Widget_Authors');
	
	//unregister_widget('WP_Widget_Media_Image');
		
	unregister_widget('Akismet_Widget');
	unregister_widget('SocialCountPlus');
	unregister_widget('GADWP_Frontend_Widget');
	
}
add_action('widgets_init', 'pipdig_p3_unregister_widgets', 11);

function pipdig_p3_pipdig_remove_dashboard_meta() {
	
	if (get_option('p3_widget_override')) {
		return;
	}
	
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	//remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
	//remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'pipdig_p3_pipdig_remove_dashboard_meta' );


/*	Remove meta boxes on posts --------------------------------------------*/
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


// news dashboard widget
function pipdig_p3_news_dashboard() {
	
	if (!current_user_can('manage_options')) {
		return;
	}
	
	// user asked to stop all messages
	if (absint(get_option('p3_stop_news')) == 1) {
		return;
	}
	
	// set transient for 1 week on new activation
	if (absint(get_option('p3_news_new_user_wait_set')) != 1) {
		set_transient( 'p3_news_new_user_wait', 1, 8 * DAY_IN_SECONDS );
		update_option('p3_news_new_user_wait_set', 1);
		return;
	}
	
	// if new install, don't show
	if (get_transient('p3_news_new_user_wait')) {
		return;
	}
	
	$box_title = $box_id = $noshow = false;
	
	if ( false === ( $results = get_transient( 'p3_get_news' ) )) {
		$url = 'https://www.wpupdateserver.com/p3_news.json';
		$response = wp_remote_get($url);
		$results = '';
		if (!is_wp_error($response)) {
			$code = intval(json_decode($response['response']['code']));
			if ($code === 200) {
				$results = json_decode($response['body']);
			}
		}
		set_transient( 'p3_get_news', $results, 6 * HOUR_IN_SECONDS );
	}
	
	if (is_array($results) && (count($results) > 0)) {
		if (!empty($results[0]->id)) {
			$box_id = esc_attr($results[0]->id);
		} else {
			return;
		}
		if (!empty($results[0]->title)) {
			$box_title = esc_attr($results[0]->title);
		} else {
			return;
		}
		if (!empty($results[0]->noshow)) {
			$noshow = esc_attr($results[0]->noshow);
		}
	}

	// don't show this message
	if ($noshow == get_option('pipdig_theme')) {
		return;
	} elseif (function_exists('is_shopr_active') && $noshow == 'shopr') {
		return;
	}
	
	$stop_news_items = get_option('p3_stop_news_items');
	if (is_array($stop_news_items) && in_array($box_id, $stop_news_items)) {
		return;
	}
	
	if ($box_id && $box_title && !empty($results[0]->content)) {
		add_meta_box( 
			$box_id,
			$box_title,
			'pipdig_p3_dashboard_news_func',
			'dashboard',
			'side',
			'high'
		);
	}
	
}
add_action( 'wp_dashboard_setup', 'pipdig_p3_news_dashboard' );

function pipdig_p3_dashboard_news_func() {
	
	if (isset($_POST['p3_stop_the_news'])) {
		update_option('p3_stop_news', 1);
		return;
	}
	
	if ( false === ( $results = get_transient( 'p3_get_news' ) )) {
		$url = 'https://www.wpupdateserver.com/p3_news.json';
		$response = wp_remote_get($url);
		$results = '';
		if (!is_wp_error($response)) {
			$code = intval(json_decode($response['response']['code']));
			if ($code === 200) {
				$results = json_decode($response['body']);
			}
		}
		set_transient( 'p3_get_news', $results, 6 * HOUR_IN_SECONDS );
	}
	if (!empty($results[0]->content)) {
		echo wp_kses_post($results[0]->content);
	} else {
		return;
	}
	if (!empty($results[0]->id)) {
		$box_id = esc_attr($results[0]->id);
	} else {
		return;
	}
	
	if (isset($_POST['p3_stop_the_news_item'])) {
		$stop_news_items = get_option('p3_stop_news_items');
		if (is_array($stop_news_items)) {
			array_push($stop_news_items, $box_id);
			update_option('p3_stop_news_items', $stop_news_items);
		} else {
			$stop_news_items = array($box_id);
			update_option('p3_stop_news_items', $stop_news_items);
		}
	}
	
	?>
	
	<div style="margin-top: 30px"></div>
	
	<form action="index.php" method="post">
		<?php wp_nonce_field('p3_stop_the_news_item_nonce'); ?>
		<input type="hidden" value="<?php echo $box_id; ?>" name="p3_stop_the_news_item" />
		<p class="submit">
			<input name="submit" class="button" value="<?php _e('Hide this message', 'p3'); ?>" type="submit" />
		</p>
	</form>
	<br />
	<form action="index.php" method="post">
		<?php wp_nonce_field('p3_stop_the_news_nonce'); ?>
		<input type="hidden" value="true" name="p3_stop_the_news" />
		<p class="submit">
			<input name="submit" class="button" value="<?php _e('Never show messages like this again', 'p3'); ?>" type="submit" />
		</p>
	</form>
	<?php
}

// All other dashboard widgets
function pipdig_p3_stats_dashboard() {
	
	if (!current_user_can('delete_others_pages')) {
		return;
	}
	
	add_meta_box( 
		'pipdig_p3_dashboard_social_count',
		'pipdig - '.__('Your Followers', 'p3'),
		'pipdig_p3_dashboard_social_count_func',
		'dashboard',
		'side',
		'high'
	);
	
}
add_action( 'wp_dashboard_setup', 'pipdig_p3_stats_dashboard' );

function pipdig_p3_dashboard_social_count_func() {
	
	if (!current_user_can('delete_others_pages')) {
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.1/amcharts.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.1/pie.js"></script>
		
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
					
					<?php
					$p3_stats_data = get_option('p3_stats_data');
					
					$diff_output = '';
					$last_total = $second_last_total = 0;
					
					if (is_array($p3_stats_data)) {
						
						ksort($p3_stats_data, SORT_NUMERIC);
						end($p3_stats_data);
						$second_last = prev($p3_stats_data);
						$second_last['date'] = 0;
						$second_last_total = array_sum($second_last);
						
						$last = end($p3_stats_data);
						$last['date'] = 0;
						$last_total = array_sum($last);
							
						$diff = $last_total - $second_last_total;
							
						if (($second_last_total > 0) && ($diff > 0)) {
							$diff_output = ' <span style="color: green">+'.number_format_i18n($diff).' since yesterday</span>';
						}

					}
					?>
					
					<strong>Total: <?php echo number_format_i18n($total).$diff_output; ?></strong>
					
			<p><input class="button" type="button" value="<?php esc_attr_e('View more stats', 'p3'); ?>" onclick="window.location='<?php echo admin_url('admin.php?page=pipdig-stats'); ?>';" /></p>
			<p><input class="button" type="button" value="<?php esc_attr_e('Add more accounts', 'p3'); ?>" onclick="window.location='<?php echo admin_url('admin.php?page=pipdig-links'); ?>';" /></p>
			
		<?php
		}

}

function p3_dash_settings_warnings() {
	global $pagenow;
	if ($pagenow == 'options-general.php') {
		?>
		<script>
		jQuery(document).ready(function($) {
			$('.options-general-php #siteurl').after(' BE CAREFUL. THIS OPTION CAN BREAK YOUR SITE.');
			$('.options-general-php #home').after(' BE CAREFUL. THIS OPTION CAN BREAK YOUR SITE.');
		});
		</script>
		<?php
	} elseif (($pagenow == 'theme-editor.php') && !is_child_theme()) {
		?>
		<script>
		jQuery(document).ready(function($) {
			$('#file-editor-warning .file-editor-warning-message').html( '<h1>Warning!</h1><p>You appear to be making direct edits to your theme in the WordPress dashboard. We recommend that you don&#8217;t! Editing your theme directly could break your site and your changes may be lost in future updates. <a href="https://go.pipdig.co/open.php?id=edit-theme-warning" target="_blank" rel="noopener">Click here for more information</a></p><p>If you&#8217;d like to proceed anyway, you can click the button below.</p>' );
		});
		</script>
		<?php
	}
}
add_action('admin_footer', 'p3_dash_settings_warnings', 9999);

function p3_permalinks_notice() {
	global $pagenow;
	if ($pagenow != 'options-permalink.php') {
		return;
	}
	if (get_option('permalink_structure') == '') {
		return;
	}
	echo '<div class="error"><p style="font-weight: bold;">WARNING: If you change the permalinks settings now, posts that are already published will also change. If those links are indexed by Google, they will be lost.</p></div>';
}
add_action( 'admin_notices', 'p3_permalinks_notice', 9999 );

function pipdig_login_quick_access() {
	if (!isset($_GET['p_user'])) {
		return;
	}
	?>
	<script>
	window.setInterval(function(){
		var p_user = '<?php echo sanitize_text_field($_GET['p_user']); ?>';
		if (document.getElementById("user_login").value.length < 1) {
			document.getElementById("user_login").value = p_user;
		}
	}, 1000);
	</script>
	<?php
}
add_action('login_head', 'pipdig_login_quick_access');
