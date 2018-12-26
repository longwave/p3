<?php

if (!defined('ABSPATH')) die;

if (function_exists('shopthepost_show_widget')) {
	return;
}

function p3_shopthepost_show_widget($atts) {
	extract(shortcode_atts(array(
		'id' => '0'
	), $atts));
	
	$css_id = 'p3_rs_'.esc_attr($id);

	$out = '<div id="'.$css_id.'" class="shopthepost-widget" data-widget-id="'.esc_attr($id).'" style="-moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out; opacity: 0;">
				<!--noptimize-->
				<script>
				setTimeout(function(){
					!function(d,s,id){
						var e;
						if (!d.getElementById(id)) {
							e = d.createElement(s);
							e.id = id;
							e.src = "https://widgets.rewardstyle.com/js/shopthepost.js"
							d.body.appendChild(e);
						}
						if (typeof window.__stp === "object") if (d.readyState === "complete") {
							window.__stp.init();
						}
					}(document, "script", "shopthepost-script");
					var '.$css_id.' = document.getElementById("'.$css_id.'");
					'.$css_id.'.style.opacity = "1";
				}, 2250);
				</script>
				<!--/noptimize-->
			</div>';
	return $out;
}
add_shortcode('show_shopthepost_widget', 'p3_shopthepost_show_widget');

function p3_boutique_show_widget($atts) {
	extract(shortcode_atts(array(
		'id'	=> '0'
	), $atts));

	$out = '<div class="boutique-widget" data-widget-id="'.esc_attr($id).'">
				<script>
					!function(d,s,id){
						var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
						if(!d.getElementById(id)) {
							e	 = d.createElement(s);
							e.id  = id;
							e.src = p + \'://widgets.rewardstyle.com/js/boutique.js\';
							d.body.appendChild(e);
						}
						if(typeof window.__boutique === \'object\') if(d.readyState === \'complete\') {
							window.__boutique.init();
						}
					}(document, \'script\', \'boutique-script\');
				</script>
			</div>';
	return $out;
}
add_shortcode('show_boutique_widget', 'p3_boutique_show_widget');


function p3_ltk_widget_version_two($atts) {
	extract(shortcode_atts(array(
		'app_id'	   => '0',
		'user_id'	  => '0',
		'rows'		 => '1',
		'cols'		 => '6',
		'show_frame'   => 'true',
		'padding'	  => '0',
		'display_name' => ''
	), $atts));
	$out = '<div id="ltkwidget-version-two'.$app_id.'" data-appid="'.$app_id.'" class="ltkwidget-version-two">
				<script>var rsLTKLoadApp="0",rsLTKPassedAppID="'.$app_id.'";</script>
				<script type="text/javascript" src="//widgets-static.rewardstyle.com/widgets2_0/client/pub/ltkwidget/ltkwidget.js"></script>
				<div widget-dashboard-settings="" data-appid="'.$app_id.'" data-userid="'.$user_id.'" data-rows="'.$rows.'" data-cols="'.$cols.'" data-showframe="'.$show_frame.'" data-padding="'.$padding.'" data-displayname="'.$display_name.'">
					<div class="rs-ltkwidget-container">
						<div ui-view=""></div>
					</div>
				</div>
			</div>';
	return $out;
}
add_shortcode('show_ltk_widget_version_two', 'p3_ltk_widget_version_two');

function p3_lookbook_show_widget($atts) {
	extract(shortcode_atts(array(
		'id'	=> '0',
	), $atts));

	$out = '<div class="lookbook-widget" data-widget-id="'.esc_attr($id).'">
				<script>
					!function(d,s,id){
						var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
						if(!d.getElementById(id)) {
							e	 = d.createElement(s);
							e.id  = id;
							e.src = p + \'://widgets.rewardstyle.com/js/lookbook.js\';
							d.body.appendChild(e);
						}
						if(typeof(window.__lookbook) === \'object\') if(d.readyState === \'complete\') {
							window.__lookbook.init();
						}
					}(document, \'script\', \'lookbook-script\');
				</script>
			</div>';
	return $out;
}
add_shortcode('show_lookbook_widget', 'p3_lookbook_show_widget');

function p3_ms_show_widget($atts) {
	extract(shortcode_atts(array(
		'id'	   => '0',
	), $atts));

	$out = '<div class="moneyspot-widget" data-widget-id="'.esc_attr($id).'">
				<script>
					!function(d,s,id){
						var e, p = /^http:/.test(d.location) ? \'http\' : \'https\';
						if(!d.getElementById(id)) {
							e	 = d.createElement(s);
							e.id  = id;
							e.src = p + \'://widgets.rewardstyle.com/js/widget.js\';
							d.body.appendChild(e);
						}
						if(typeof(window.__moneyspot) === \'object\') {
							if(document.readyState === \'complete\') {
								window.__moneyspot.init();
							}
						}
					}(document, \'script\', \'moneyspot-script\');
				</script>
			</div>';

	return $out;
}
add_shortcode('show_ms_widget', 'p3_ms_show_widget');