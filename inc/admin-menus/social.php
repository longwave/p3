<?php

if (!function_exists('pipdig_social_options_page')) {
	function pipdig_social_options_page() {
	
	$total_followers = $twitter = $instagram = $facebook = $youtube = $googleplus = $soundcloud = $pinterest = $linkedin = $twitch = $tumblr = $linkedin = $vimeo = $bloglovin = '';

	$twitter = get_scp_twitter();
	$instagram = get_scp_instagram();
	$facebook = get_scp_facebook();
	$youtube = get_scp_youtube();
	$googleplus = get_scp_googleplus();
	$soundcloud = get_scp_soundcloud();
	//$pinterest = get_scp_pinterest();
	//$linkedin = get_scp_linkedin();
	//$twitch = get_scp_twitch();
	//$tumblr = get_scp_tumblr();
	//$linkedin = get_scp_linkedin();
	//$vimeo = get_scp_vimeo();

	$bloglovin = get_option('p3_bloglovin_count');
	
	$total_followers = $twitter + $instagram + $facebook + $youtube + $googleplus + $soundcloud + $bloglovin;
	
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

<?php if (!empty($twitch)) { ?>
	{channel: "Twitch", count: <?php echo $twitch; ?>, "color": "#6441a5"},
<?php } ?>

<?php if (!empty($linkedin)) { ?>
	{channel: "LinkedIn", count: <?php echo $linkedin; ?>, "color": "#0077b5"},
<?php } ?>

<?php if (!empty($vimeo)) { ?>
	{channel: "Vimeo", count: <?php echo $vimeo; ?>, "color": "#17b3e8"},
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
			$height = 0;
		?>
			<h2><?php _e('Follower Stats', 'p3'); ?></h2>
		<?php } ?>
		<div id="followers"></div>
		<p><a href="<?php echo admin_url('options-general.php?page=social-count-plus'); ?>"><?php _e('Click here to add more accounts', 'p3'); ?></a></p>
	</div>
	</div>
	
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
	<?php

	}
}

