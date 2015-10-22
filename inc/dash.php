<?php 

if (!defined('ABSPATH')) {
	exit;
}

/*  Add credit to admin area --------------------------------------------------------*/
function pipdig_footer_admin () {
	echo 'Powered by <a href="'.esc_url('http://www.wordpress.org/').'" target="_blank">WordPress</a>. Enhancements by <a href="'.esc_url('http://www.pipdig.co/?utm_source=wp-dashboard&utm_medium=footer&utm_campaign=wp-dashboard').'" target="_blank">pipdig</a>.';
}
add_filter('admin_footer_text', 'pipdig_footer_admin');

/*  Dashboard widgets ----------------------------------------------------------------*/
function pipdig_p3_dashboard_widgets() {
	add_meta_box( 
		'pipdig_p3_dashboard_social_count',
		'pipdig - '.__('Social Stats', 'p3'),
		'pipdig_p3_dashboard_social_count_func',
		'dashboard',
		'side',
		'high'
	);
}
add_action( 'wp_dashboard_setup', 'pipdig_p3_dashboard_widgets' );

function pipdig_p3_dashboard_social_count_func() {
	$bloglovin = get_option('p3_bloglovin_count');
	$pinterest = get_option('p3_pinterest_count');
	$twitter = get_option('p3_twitter_count');
	$facebook = get_option('p3_facebook_count');
	$instagram = get_option('p3_instagram_count');
	$youtube = get_option('p3_youtube_count');
	$google_plus = get_option('p3_google_plus_count');
	?>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/amcharts.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/pie.js"></script>
	
		<script type="text/javascript">
			AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"balloonText": "",
					"labelRadius": 6,
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
					"fontSize": 12,
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