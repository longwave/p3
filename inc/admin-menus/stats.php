<?php

if (!defined('ABSPATH')) die;

if ( !function_exists( 'pipdig_multiKeyExists' ) ) {
function pipdig_multiKeyExists(array $arr, $key) {

    // is in base array?
    if (array_key_exists($key, $arr)) {
        return true;
    }

    // check arrays contained in this array
    foreach ($arr as $element) {
        if (is_array($element)) {
            if (pipdig_multiKeyExists($element, $key)) {
                return true;
            }
        }

    }

    return false;
}
}

if (!function_exists('pipdig_stats_options_page')) {
function pipdig_stats_options_page() {
	
	pipdig_p3_scrapey_scrapes();
	
	$p3_stats_data = get_option('p3_stats_data');
	
	if (empty($p3_stats_data)) {
		echo '<h1>No stats yet!</h1>';
		echo '<p>Be sure to add your soclail links to <a href="'.admin_url('admin.php?page=pipdig-links').'">this page</a> and allow a few days for the stats to generate.<p>';
		return;
	}
	
	//echo '<pre>';
	//print_r($p3_stats_data);
	//echo '</pre>';
	?>
	
	<h1>Social Media Stats</h1>
	
	<p>This page is experimental and may include some bugs. You're welcome to send us any feedback :)</p>
	
	<style>
	#chartdiv {
		margin-top: 40px;
		width: 90%;
		height: 500px;
		font-size: 12px;
	}
	#chartdiv .fa {
		font-size: 22px;
		margin-right: 2px;
	}
	</style>

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<script>
	var chart = AmCharts.makeChart("chartdiv", {
		"type": "serial",
		"theme": "light",
		"marginRight": 20,
		"fileName": "Follower Stats",
		"legend": {
			"equalWidths": false,
			//"periodValueText": "[[value.sum]]",
			"position": "left",
			"valueAlign": "left",
			"valueWidth": 50
		},
		"dataProvider": [
		
		<?php
		ksort($p3_stats_data, SORT_NUMERIC);
		foreach ($p3_stats_data as $item) {
			$item['date'] = date('d F Y', strtotime(key($p3_stats_data)));
			echo json_encode($item).',';
		}
		?>
		
		],
		"valueAxes": [{
			"stackType": "regular",
			"gridAlpha": 0.07,
			"position": "left",
			"title": "Followers"
		}],
		"graphs": [
		{
			"balloonText": "<i class='fa fa-twitter'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Twitter",
			"valueField": "twitter",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'twitter')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-instagram'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Instagram",
			"valueField": "instagram",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'instagram')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-plus'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Bloglovin",
			"valueField": "bloglovin",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'bloglovin')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-pinterest'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Pinterest",
			"valueField": "pinterest",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'pinterest')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-facebook'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Facebook",
			"valueField": "facebook",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'facebook')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-youtube-play'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "YouTube",
			"valueField": "youtube",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'youtube')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-tumblr'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Tumblr",
			"valueField": "tumblr",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'tumblr')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-linkedin'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "LinkedIn",
			"valueField": "linkedin",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'linkedin')) { ?>
			"hidden": true
			<?php } ?>
		},
		{
			"balloonText": "<i class='fa fa-soundcloud'></i> <span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>",
			"fillAlphas": 0.5,
			"lineAlpha": 0.4,
			"title": "Soundcloud",
			"valueField": "soundcloud",
			<?php if (!pipdig_multiKeyExists($p3_stats_data, 'soundcloud')) { ?>
			"hidden": true
			<?php } ?>
		},
		],
		"plotAreaBorderAlpha": 0,
		"marginTop": 10,
		"marginLeft": 0,
		"marginBottom": 0,
		"chartScrollbar": {},
		"chartCursor": {
			"cursorAlpha": 0
		},
		"categoryField": "date",
		"categoryAxis": {
			"startOnAxis": true,
			"axisColor": "#dddddd",
			"gridAlpha": 0,
			"title": "Date",
			"gridPosition": "start",
			"labelRotation": 45,
		},
		"export": {
			"enabled": false
		 }
	});
	</script>

	<div id="chartdiv"></div>
	
	<?php
}
}

