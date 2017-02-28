<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_p3_scrapey_scrapes')) {
function pipdig_p3_scrapey_scrapes() {
	
	$links = get_option('pipdig_links');
	
	if (empty($links)) {
		return;
	}
	
	if ( false === ( $value = get_transient('p3_stats_gen') ) ) {
		
		set_transient('p3_stats_gen', true, 24 * HOUR_IN_SECONDS);
		
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
				$bloglovin_url_path = parse_url($bloglovin_url, PHP_URL_PATH);
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

		if (!empty($request_array)) {
			
			$request_array['site_url'] = get_site_url();
			$request_array['tempToken'] = 'dcx15';
			
			$url = add_query_arg($request_array, 'https://pipdig.rocks/c');
			
			$args = array(
				//'body' => json_encode($request_array),
				'timeout' => '28',
				'redirection' => '5',
				//'httpversion' => '1.0',
				'blocking' => true,
			);

			$response = wp_remote_get( $url, $args );

			$response_body = wp_remote_retrieve_body($response);

			if ($response_body == "500 error") {
				// 500, let's try again in 3 seconds
				sleep(3);
				$response = wp_remote_get( $url, $args );
				$response_body = wp_remote_retrieve_body($response);
			}
			
			if (!is_wp_error($response)) {
				
				$response_data = json_decode($response_body);
			
				if (isset($response_data->items->pinterest)) {
					update_option('p3_pinterest_count', $response_data->items->pinterest);
				}
				if (isset($response_data->items->facebook)) {
					update_option('p3_facebook_count', $response_data->items->facebook);
				}
				if (isset($response_data->items->twitter)) {
					update_option('p3_twitter_count', $response_data->items->twitter);
				}
				if (isset($response_data->items->instagram)) {
					update_option('p3_instagram_count', $response_data->items->instagram);
				}
				if (isset($response_data->items->youtube)) {
					update_option('p3_youtube_count', $response_data->items->youtube);
				}
				if (isset($response_data->items->bloglovin)) {
					update_option('p3_bloglovin_count', $response_data->items->bloglovin);
				}
				
			}
		}


		// need to add gplus and twitch...
		
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
		
		$today = array();
		
		if (get_option('p3_pinterest_count')) {
			$today['pinterest'] = absint(get_option('p3_pinterest_count'));
		}
		if (get_option('p3_twitter_count')) {
			$today['twitter'] = absint(get_option('p3_twitter_count'));
		}
		if (get_option('p3_facebook_count')) {
			$today['facebook'] = absint(get_option('p3_facebook_count'));
		}
		if (get_option('p3_instagram_count')) {
			$today['instagram'] = absint(get_option('p3_instagram_count'));
		}
		if (get_option('p3_youtube_count')) {
			$today['youtube'] = absint(get_option('p3_youtube_count'));
		}
		if (get_option('p3_google_plus_count')) {
			$today['google_plus'] = absint(get_option('p3_google_plus_count'));
		}
		if (get_option('p3_twitch_count')) {
			$today['twitch'] = absint(get_option('p3_twitch_count'));
		}
		
		// scp
		if (get_option('p3_linkedin_count')) {
			$today['linkedin'] = absint(get_option('p3_linkedin_count'));
		}
		if (get_option('p3_tumblr_count')) {
			$today['tumblr'] = absint(get_option('p3_tumblr_count'));
		}
		if (get_option('p3_soundcloud_count')) {
			$today['soundcloud'] = absint(get_option('p3_soundcloud_count'));
		}
		
		
		if (empty($today)) {
			return;
		}
		
		if (is_array(get_option('p3_stats_data'))) {
			$p3_stats_data = get_option('p3_stats_data');
		} else {
			$p3_stats_data = array();
		}
		
		$todays_date = date('Ymd'); // http://codepad.org/PYcR13C2
		$p3_stats_data[$todays_date] = $today;
		$today['date'] = $todays_date;
		update_option('p3_stats_data', $p3_stats_data);
	
	}
	
}
add_action('login_footer', 'pipdig_p3_scrapey_scrapes', 99); // push on login page to avoid cache
}
