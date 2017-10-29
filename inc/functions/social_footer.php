<?php

if (!defined('ABSPATH')) die;

function pipdig_p3_social_footer() {
	
	$links = get_option('pipdig_links');
	
	pipdig_p3_scrapey_scrapes();
	
	$count = 0;
	$twitter_count = absint(get_option('p3_twitter_count'));
	$facebook_count = absint(get_option('p3_facebook_count'));
	$instagram_count = absint(get_option('p3_instagram_count'));
	$youtube_count = absint(get_option('p3_youtube_count'));
	$pinterest_count = absint(get_option('p3_pinterest_count'));
	$bloglovin_count = absint(get_option('p3_bloglovin_count'));
	$google_plus_count = absint(get_option('p3_google_plus_count'));
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}

	if ($twitter_count) {
		$count++;
	}
	
	if ($facebook_count) {
		$count++;
	}
	
	if ($instagram_count) {
		$count++;
	}
	
	if ($youtube_count) {
		$count++;
	}
	
	if ($pinterest_count) {
		$count++;
	}
	
	if ($bloglovin_count) {
		$count++;
	}
	
	$show_google = false;
	if ($google_plus_count && ($count < 6)) {
		$count++;
		$show_google = true;
	}

	$class = $colz = '';

	switch ($count) {
		case '1':
			$class = 'col-xs-12';
			break;
		case '2':
			$class = 'col-'.$sm.'-6';
			break;
		case '3':
			$class = 'col-'.$sm.'-4';
			break;
		case '4':
			$class = 'col-'.$sm.'-3';
			break;
		case '5':
			$class = 'col-'.$sm.'-5ths';
			break;
		case '6':
			$class = 'col-'.$md.'-2';
			break;
	}

	if ($class) {
		$colz = 'class="'.$class.'"';
	}

	$output = '<div class="clearfix extra-footer-outer social-footer-outer">';
	$output .= '<div class="container">';
	$output .= '<div class="row social-footer">';
	
	$total_count = $twitter_count + $facebook_count + $instagram_count + $youtube_count + $bloglovin_count + $pinterest_count + $google_plus_count;
	
	if ($total_count) {
	
		if (!empty($twitter_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['twitter']).'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> Twitter<span class="social-footer-counters"> | '.$twitter_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($facebook_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['facebook']).'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> Facebook<span class="social-footer-counters"> | '.$facebook_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($instagram_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['instagram']).'" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i> Instagram<span class="social-footer-counters"> | '.$instagram_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($youtube_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['youtube']).'" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i> YouTube<span class="social-footer-counters"> | '.$youtube_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($pinterest_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['pinterest']).'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i> Pinterest<span class="social-footer-counters"> | '.$pinterest_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($bloglovin_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['bloglovin']).'" target="_blank" rel="nofollow"><i class="fa fa-plus"></i> Bloglovin<span class="social-footer-counters"> | '.$bloglovin_count.'</span></a>';
		$output .= '</div>';
		}
		
		if(!empty($google_plus_count) && $show_google) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['google_plus']).'" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i> Google<span class="social-footer-counters"> | '.$google_plus_count.'</span></a>';
		$output .= '</div>';
		}
		
	}
		
	$output .= '</div>	
</div>
</div>
<style scoped>#instagramz{margin-top:0}</style>';
	
	echo $output;

}