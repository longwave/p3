<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('pipdig_stats_options_page')) {
	function pipdig_stats_options_page() {
		
	pipdig_p3_scrapey_scrapes();
	
	$total_followers = $twitter = $instagram = $facebook = $youtube = $google_plus = $soundcloud = $pinterest = $linkedin = $twitch = $tumblr = $linkedin = $vimeo = $bloglovin = '';

	$bloglovin = absint(get_option('p3_bloglovin_count'));
	$pinterest = absint(get_option('p3_pinterest_count'));
	$twitter = absint(get_option('p3_twitter_count'));
	$facebook = absint(get_option('p3_facebook_count'));
	$instagram = pipdig_strip(get_option('p3_instagram_count'));
	$youtube = absint(get_option('p3_youtube_count'));
	$google_plus = absint(get_option('p3_google_plus_count'));
	$twitch = absint(get_option('p3_twitch_count'));
	
	$total_followers = $twitter + $instagram + $facebook + $youtube + $google_plus + $soundcloud + $bloglovin + $pinterest + $twitch;
	
	?>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/amcharts.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/serial.js"></script>
	
	<div class="wrap">
		<h1>Social Stats</h1>
		<p><?php
			printf(__('This page will display your total social follower counts. Please add your links to <a href="%s">this page</a> first.', 'p3'), admin_url('admin.php?page=pipdig-links') ); ?>
		</p>
		<div class="card" style="max-width: 800px">
			<script>
				var chart;

				var chartData = [

				<?php if (!empty($twitter)) { ?>
					{channel: "Twitter", count: <?php echo $twitter; ?>, "color": "#5ea9dd"},
				<?php } ?>

				<?php if (!empty($instagram)) { ?>
					{channel: "Instagram", count: <?php echo $instagram; ?>, "color": "#447398"},
				<?php } ?>

				<?php if (!empty($pinterest)) { ?>
					{channel: "Pinterest", count: <?php echo $pinterest; ?>, "color": "#cb2027"},
				<?php } ?>

				<?php if (!empty($bloglovin)) { ?>
					{channel: "Bloglovin", count: <?php echo $bloglovin; ?>, "color": "#37aeed"},
				<?php } ?>

				<?php if (!empty($google_plus)) { ?>
					{channel: "Google+", count: <?php echo $google_plus; ?>, "color": "#dd4c39"},
				<?php } ?>

				<?php if (!empty($soundcloud)) { ?>
					{channel: "Soundcloud", count: <?php echo $soundcloud; ?>, "color": "#ff7200"},
				<?php } ?>

				<?php if (!empty($facebook)) { ?>
					{channel: "Facebook", count: <?php echo $facebook; ?>, "color": "#3b5998"},
				<?php } ?>

				<?php if (!empty($youtube)) { ?>
					{channel: "YouTube", count: <?php echo $youtube; ?>, "color": "#d11f1e"},
				<?php } ?>

				<?php if (!empty($tumblr)) { ?>
					{channel: "Tumblr", count: <?php echo $tumblr; ?>, "color": "#36465d"},
				<?php } ?>

				<?php if (!empty($linkedin)) { ?>
					{channel: "LinkedIn", count: <?php echo $linkedin; ?>, "color": "#0077b5"},
				<?php } ?>
				
				<?php if (!empty($twitch)) { ?>
					{channel: "Twitch", count: <?php echo $twitch; ?>, "color": "#6441a5"},
				<?php } ?>

				];


				AmCharts.ready(function() {

					chart = new AmCharts.AmSerialChart();
					chart.dataProvider = chartData;
					chart.categoryField = "channel";
					chart.startDuration = 1.4;

					var categoryAxis = chart.categoryAxis;
					categoryAxis.gridPosition = "start";

					var graph = new AmCharts.AmGraph();
					graph.valueField = "count";
					graph.colorField = "color"
					graph.balloonText = "[[category]]: [[value]]";
					graph.type = "column";
					graph.lineAlpha = 0;
					graph.fillAlphas = 0.85;
					chart.addGraph(graph);
					
					chart.addListener("clickGraphItem", function (event) {
						
					});

					chart.write("followers");
				});
			</script>
			<?php if ($total_followers != 0) {
				$height = 500;
			?>
				<h2><?php echo __('Total followers:', 'p3').' '.$total_followers; ?></h2>
			<?php } else {
				$height = 200;
			?>
				<h2><?php _e('Follower Stats', 'p3'); ?></h2>
			<?php } ?>
			<div id="followers"></div>
			<style scoped>
			#followers {
				width: 100%;
				height: <?php echo $height; ?>px;
			}
			.amcharts-chart-div a {
				font-size: 0!important;
			}
			</style>
			<p><a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>"><?php _e('Click here to add more accounts', 'p3'); ?></a>.</p>
			<p><?php _e('Stats are refreshed every 12 hours', 'p3'); ?>.</p>
		</div>
		
		<!--
		<div class="card">
			
			<?php
			/*
				$args = array (
					'posts_per_page'         => 5,
					'ignore_sticky_posts'    => true,
				);

				$recent_posts = new WP_Query( $args );

				if ( $recent_posts->have_posts() ) {
					$post_no = 1;
					while ( $recent_posts->have_posts() ) {
						$recent_posts->the_post();
						
						if ( false === ( $sharedcount = get_transient('p3_stats_sharedcount_post_'.$post_no) ) ) {
							//$url = 'http://www.inthefrow.com'; // just for testing
							$url = get_the_permalink();
							$sharedcount = wp_remote_fopen('http://free.sharedcount.com/?url='.$url.'&apikey=1df20257cbb86d10025467f15d61405e31fc98b3');
							$sharedcount = json_decode($sharedcount, true);
							
							set_transient('p3_stats_sharedcount_post_'.$post_no, $sharedcount, 2 * HOUR_IN_SECONDS);
						}
						$StumbleUpon = intval($sharedcount['StumbleUpon']);
						$Reddit = intval($sharedcount['Reddit']);
						$Delicious = intval($sharedcount['Delicious']);
						$Facebook = intval($sharedcount['Facebook']['total_count']);
						$google_plusOne = intval($sharedcount['google_plusOne']);
						$Twitter = intval($sharedcount['Twitter']);
						$Diggs = intval($sharedcount['Diggs']);
						$Pinterest = intval($sharedcount['Pinterest']);
						$LinkedIn = intval($sharedcount['LinkedIn']);
						?>
						<p><?php echo 'Post ' . $post_no.': '. $StumbleUpon; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Reddit; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Delicious; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $google_plusOne; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Twitter; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Diggs; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Pinterest; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $LinkedIn; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Diggs; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Facebook; ?></p>
						<?php
						sleep(0.1);
						$post_no++;
					}
				} else {
					_e('No posts found.', 'p3');
				}

				// Restore original Post Data
				wp_reset_postdata();
				*/
				/*
				if ( false === ( $sharedcount = get_transient('p3_stats_sharedcount_home') ) ) {
					$url = 'http://www.inthefrow.com'; // just for testing
					//$url = home_url();
					$sharedcount = wp_remote_fopen('http://free.sharedcount.com/?url='.$url.'&apikey=1df20257cbb86d10025467f15d61405e31fc98b3');
					$sharedcount = json_decode($sharedcount, true);
					
					set_transient('p3_stats_sharedcount_home', $sharedcount, 2 * HOUR_IN_SECONDS);
				}
				$StumbleUpon_shares = intval($sharedcount['StumbleUpon']);
				$Reddit_shares = intval($sharedcount['Reddit']);
				$Delicious_shares = intval($sharedcount['Delicious']);
				$Facebook_shares = intval($sharedcount['Facebook']['total_count']);
				$GooglePlusOne_shares = intval($sharedcount['GooglePlusOne']);
				$Twitter_shares = intval($sharedcount['Twitter']);
				$Diggs_shares = intval($sharedcount['Diggs']);
				$Pinterest_shares = intval($sharedcount['Pinterest']);
				$LinkedIn_shares = intval($sharedcount['LinkedIn']);
				*/
			?>

			<script>
				var chart;

				var chartData = [

				<?php if (!empty($StumbleUpon_shares)) { ?>
					{channel: "StumbleUpon", count: <?php echo $StumbleUpon_shares; ?>, "color": "#5ea9dd"},
				<?php } ?>

				<?php if (!empty($Reddit_shares)) { ?>
					{channel: "Reddit", count: <?php echo $Reddit_shares; ?>, "color": "#447398"},
				<?php } ?>

				<?php if (!empty($Delicious_shares)) { ?>
					{channel: "Delicious", count: <?php echo $Delicious_shares; ?>, "color": "#cb2027"},
				<?php } ?>

				<?php if (!empty($Facebook_shares)) { ?>
					{channel: "Facebook", count: <?php echo $Facebook_shares; ?>, "color": "#37aeed"},
				<?php } ?>

				<?php if (!empty($GooglePlusOne_shares)) { ?>
					{channel: "Google+", count: <?php echo $GooglePlusOne_shares; ?>, "color": "#dd4c39"},
				<?php } ?>

				<?php if (!empty($Twitter_shares)) { ?>
					{channel: "Twitter", count: <?php echo $Twitter_shares; ?>, "color": "#ff7200"},
				<?php } ?>

				<?php if (!empty($Diggs_shares)) { ?>
					{channel: "Diggs", count: <?php echo $Diggs_shares; ?>, "color": "#3b5998"},
				<?php } ?>

				<?php if (!empty($Pinterest_shares)) { ?>
					{channel: "Pinterest", count: <?php echo $Pinterest_shares; ?>, "color": "#d11f1e"},
				<?php } ?>

				<?php if (!empty($LinkedIn_shares)) { ?>
					{channel: "LinkedIn", count: <?php echo $LinkedIn_shares; ?>, "color": "#0077b5"},
				<?php } ?>

				];


				AmCharts.ready(function() {

					chart = new AmCharts.AmSerialChart();
					chart.dataProvider = chartData;
					chart.categoryField = "channel";
					chart.startDuration = 2.2;

					var categoryAxis = chart.categoryAxis;
					categoryAxis.gridPosition = "start";

					var graph = new AmCharts.AmGraph();
					graph.valueField = "count";
					graph.colorField = "color"
					graph.balloonText = "[[category]]: [[value]]";
					graph.type = "column";
					graph.lineAlpha = 0;
					graph.fillAlphas = 0.85;
					chart.addGraph(graph);
					
					chart.addListener("clickGraphItem", function (event) {
						
					});

					chart.write("shares");
				});
			</script>
			

			<h2><?php _e('Social Sharing Stats (Homepage only)', 'p3'); ?></h2>
			<div id="shares"></div>
			<style scoped>
			#shares {
				width: 100%;
				height: 300px;
			}
			.amcharts-chart-div a {
				font-size: 0!important;
			}
			</style>
		</div>
		-->
	</div>
	<?php

	}
}

