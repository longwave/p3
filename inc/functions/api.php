<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_p3_scrapey_scrapes')) {
function pipdig_p3_scrapey_scrapes() {
	
	$links = get_option('pipdig_links');
	
	if (empty($links)) {
		return;
	}
	
	if ( false === ( $value = get_transient('p3_stats_gen') ) ) {
		
		set_transient('p3_stats_gen', true, 12 * HOUR_IN_SECONDS);
		
		$request_array = array();
		
		// Facebook --------------------
		$facebook_url = esc_url($links['facebook']);
		if($facebook_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('facebook')) {
				$likes = absint(get_scp_counter('facebook'));
				update_option('p3_facebook_count', $likes);
			} else {
				$facebook_url_test = get_headers($facebook_url);
				if (substr($facebook_url_test[0], 9, 3) !== '404') {
					$facebook_id = parse_url($facebook_url, PHP_URL_PATH);
					$facebook_id = str_replace('/', '', $facebook_id);
					$request_array['facebook'] = $facebook_id;
				}
			}
		} else {
			delete_option('p3_facebook_count');
		}
		
		// Pinterest ---------------------
		$pinterest_url = esc_url($links['pinterest']);
		if($pinterest_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('pinterest')) {
				$pinterest_followers = absint(get_scp_counter('pinterest'));
				update_option('p3_pinterest_count', $pinterest_followers);
			} else {
				$pinterest_url_test = get_headers($pinterest_url);
				if (substr($pinterest_url_test[0], 9, 3) !== '404') {
					$pinterest_user = parse_url($pinterest_url, PHP_URL_PATH);
					$pinterest_user = str_replace('/', '', $pinterest_user);
					$request_array['pinterest'] = $pinterest_user;
				}
			}
		} else {
			delete_option('p3_pinterest_count');
		}

		// Bloglovin --------------------
		$bloglovin_url = esc_url($links['bloglovin']);
		if($bloglovin_url) {
			$bloglovin_url_test = get_headers($bloglovin_url);
			if (substr($bloglovin_url_test[0], 9, 3) !== '404') {
				// take path of url only (so we don't include the ?query args by accident in the split)
				$bloglovin_url_path = parse_url($bloglovin_url, PHP_URL_PATH);
				// split string by - char. Last entry is the bloglovin ID number
				$bloglovin_url_split = explode("-", $bloglovin_url_path);
				$bloglovin_id = end($bloglovin_url_split);
				$request_array['bloglovin'] = $bloglovin_id;
			}
		} else {
			delete_option('p3_bloglovin_count');
		}	
		
		// Twitter ---------------------
		$twitter_url = esc_url($links['twitter']);
		if ($twitter_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('twitter')) {
				$followers_count = absint(get_scp_counter('twitter'));
				update_option('p3_twitter_count', $followers_count);
			} else {
				$twitter_url_test = get_headers($twitter_url);
				if (substr($twitter_url_test[0], 9, 3) !== '404') {
					$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
					$twitter_handle = str_replace('/', '', $twitter_handle);
					$request_array['twitter'] = $twitter_handle;
				}
			}
		} else {
			delete_option('p3_twitter_count');
		}


		// Instagram ---------------------
		// SELECT * from html where url="http://instagram.com/inthefrow" AND xpath="//li[2]/span"
		$instagram_url = esc_url($links['instagram']);
		if ($instagram_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('instagram')) {
				$instagram_count = absint(get_scp_counter('instagram'));
				update_option('p3_instagram_count', $instagram_count);
			} else {
				$instagram_deets = get_option('pipdig_instagram'); // from p3
				if (!empty($instagram_deets['access_token'])) { 
					$ig_token = pipdig_strip($instagram_deets['access_token']);
					$request_array['instagram'] = $ig_token;
				}
			}
		} else {
			delete_option('p3_instagram_count');
		}
			
		// YouTube ---------------------
		// SELECT * from html where url="https://www.youtube.com/user/inthefrow" AND xpath="/html/body/div[4]/div[4]/div/div[5]/div/div[1]/div/div[2]/div/div/div[2]/div/span/span[1]"
		$youtube_url = esc_url($links['youtube']);
		if ($youtube_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('youtube')) {
				$youtube_count = absint(get_scp_counter('youtube'));
				update_option('p3_youtube_count', $youtube_count);
			} else {
				$youtube_url_test = get_headers($youtube_url);
				if (substr($youtube_url_test[0], 9, 3) !== '404') {
					$request_array['youtube'] = $youtube_url;
				}
			}
		} else {
			delete_option('p3_youtube_count');
		}

			
		// Google Plus ---------------------
		// https://www.googleapis.com/plus/v1/people/102904094379339545145?key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c		OR YQL below:
		// SELECT * from html where url="https://plus.google.com/+Inthefrowpage/about" AND xpath="//div[@class='Zmjtc']/span"
		$gplus_url = esc_url($links['google_plus']);
		if ($gplus_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('googleplus')) {
				$google_plus_count = absint(get_scp_counter('googleplus'));
				update_option('p3_google_plus_count', $google_plus_count);
			} else {
				$gplus_url_test = get_headers($gplus_url);
				if (substr($gplus_url_test[0], 9, 3) !== '404') {
					$request_array['gplus'] = $gplus_url;
				}
			}
		} else {
			delete_option('p3_google_plus_count');
		}
		
		
		$twitch_url = esc_url($links['twitch']);
		if ($twitch_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('twitch')) {
				$twitch_count = absint(get_scp_counter('twitch'));
				update_option('p3_twitch_count', $twitch_count);
			} else {
				$twitch_url_test = get_headers($twitch_url);
				if (substr($twitch_url_test[0], 9, 3) !== '404') {
					$request_array['twitch'] = $twitch_url;
				}
			}
		} else {
			delete_option('p3_twitch_count');
		}
		
		
		
		
		
		// backups
		$soundcloud_url = esc_url($links['soundcloud']);
		if ($soundcloud_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('soundcloud')) {
				$soundcloud_count = absint(get_scp_counter('soundcloud'));
				update_option('p3_soundcloud_count', $soundcloud_count);
			}
		} else {
			delete_option('p3_soundcloud_count');
		}
		
		$linkedin_url = esc_url($links['linkedin']);
		if ($linkedin_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('linkedin')) {
				$linkedin_count = absint(get_scp_counter('linkedin'));
				update_option('p3_linkedin_count', $linkedin_count);
			}
		} else {
			delete_option('p3_linkedin_count');
		}
		
		$tumblr_url = esc_url($links['tumblr']);
		if ($tumblr_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('tumblr')) {
				$tumblr_count = absint(get_scp_counter('tumblr'));
				update_option('p3_tumblr_count', $tumblr_count);
			}
		} else {
			delete_option('p3_tumblr_count');
		}
	
	}
	
}
add_action('login_footer', 'pipdig_p3_scrapey_scrapes', 99); // push on login page to avoid cache
}
