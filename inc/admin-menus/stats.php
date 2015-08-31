<?php

if (!function_exists('pipdig_stats_options_page')) {
	function pipdig_stats_options_page() {
	
	$total_followers = $twitter = $instagram = $facebook = $youtube = $googleplus = $soundcloud = $pinterest = $linkedin = $twitch = $tumblr = $linkedin = $vimeo = $bloglovin = '';

	//$twitter = get_scp_twitter();
	//$instagram = get_scp_instagram();
	//$facebook = get_scp_facebook();
	//$youtube = get_scp_youtube();
	//$googleplus = get_scp_googleplus();
	//$soundcloud = get_scp_soundcloud();
	//$pinterest = get_scp_pinterest();
	//$linkedin = get_scp_linkedin();
	//$tumblr = get_scp_tumblr();
	//$linkedin = get_scp_linkedin();
	
	$bloglovin = get_option('p3_bloglovin_count');
	$pinterest = get_option('p3_pinterest_count');
	$twitter = get_option('p3_twitter_count');
	$facebook = get_option('p3_facebook_count');
	$instagram = get_option('p3_instagram_count');
	$youtube = get_option('p3_youtube_count');
	
	$total_followers = $twitter + $instagram + $facebook + $youtube + $googleplus + $soundcloud + $bloglovin + $pinterest;
	
	?>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/amcharts.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/serial.js"></script>
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/amcharts/3.13.0/themes/light.js"></script>-->
	
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

		<?php if (!empty($googleplus)) { ?>
			{channel: "Google Plus", count: <?php echo $googleplus; ?>, "color": "#dd4c39"},
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
			{channel: "tumblr", count: <?php echo $tumblr; ?>, "color": "#36465d"},
		<?php } ?>

		<?php if (!empty($linkedin)) { ?>
			{channel: "LinkedIn", count: <?php echo $linkedin; ?>, "color": "#0077b5"},
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
			graph.fillAlphas = 0.9;
			chart.addGraph(graph);
			
			chart.addListener("clickGraphItem", function (event) {
				
			});

			chart.write("followers");
		});
	</script>
	
	<div class="wrap">
		<h1>Social Stats</h1>
		<p>For example, when you add the <code>[gallery]</code> shortcode to a post, WordPress automatically replaces this with all of the code required to display an image gallery. Read more about this <a href="<?php echo esc_url('http://code.tutsplus.com/articles/the-wordpress-gallery-shortcode-a-comprehensive-overview--wp-23743'); ?>" target="_blank">here</a>.</p>
		
		<div class="card">
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
				font-size: 11px;
			}
			.amcharts-chart-div a {
				font-size: 0!important;
			}
			</style>
			<p><a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>"><?php _e('Click here to add more accounts', 'p3'); ?></a></p>
		</div>
		
		
		<div class="card">
			<h2><?php _e('Recent post share stats:', 'p3'); ?></h2>
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
						$GooglePlusOne = intval($sharedcount['GooglePlusOne']);
						$Twitter = intval($sharedcount['Twitter']);
						$Diggs = intval($sharedcount['Diggs']);
						$Pinterest = intval($sharedcount['Pinterest']);
						$LinkedIn = intval($sharedcount['LinkedIn']);
						?>
						<p><?php echo 'Post ' . $post_no.': '. $StumbleUpon; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Reddit; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $Delicious; ?></p>
						<p><?php echo 'Post ' . $post_no.': '. $GooglePlusOne; ?></p>
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
				if ( false === ( $sharedcount = get_transient('p3_stats_sharedcount_home') ) ) {
					$url = 'http://www.inthefrow.com'; // just for testing
					//$url = home_url();
					$sharedcount = wp_remote_fopen('http://free.sharedcount.com/?url='.$url.'&apikey=1df20257cbb86d10025467f15d61405e31fc98b3');
					$sharedcount = json_decode($sharedcount, true);
					
					set_transient('p3_stats_sharedcount_home', $sharedcount, 2 * HOUR_IN_SECONDS);
				}
				$StumbleUpon = intval($sharedcount['StumbleUpon']);
				$Reddit = intval($sharedcount['Reddit']);
				$Delicious = intval($sharedcount['Delicious']);
				$Facebook = intval($sharedcount['Facebook']['total_count']);
				$GooglePlusOne = intval($sharedcount['GooglePlusOne']);
				$Twitter = intval($sharedcount['Twitter']);
				$Diggs = intval($sharedcount['Diggs']);
				$Pinterest = intval($sharedcount['Pinterest']);
				$LinkedIn = intval($sharedcount['LinkedIn']);
			?>

			<p>Home: <?php echo $StumbleUpon; ?></p>
			<p>Home: <?php echo $Reddit; ?></p>
			<p>Home: <?php echo $Delicious; ?></p>
			<p>Home: <?php echo $GooglePlusOne; ?></p>
			<p>Home: <?php echo $Twitter; ?></p>
			<p>Home: <?php echo $Diggs; ?></p>
			<p>Home: <?php echo $Pinterest; ?></p>
			<p>Home: <?php echo $LinkedIn; ?></p>
			<p>Home: <?php echo $Diggs; ?></p>
			<p>Home: <?php echo $Facebook; ?></p>
		</div>
		
	</div>
	
	<?php

	}
}

