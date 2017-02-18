<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// function to fetch images
if (!function_exists('p3_pinterest_fetch')) {
	function p3_pinterest_fetch($user) {
		
		if (!function_exists('simplexml_load_string')) {
			return false;
		}
		
		if (empty($user)) {
			return false;
		}
		
		// store user ids so we can clear transients in cron
		$pinterest_users = get_option('pipdig_pinterest_users');
		
		if (!empty($pinterest_users)) {
			if (is_array($pinterest_users)) {
				$pinterest_users = array_push($pinterest_users, $user);
				update_option('pipdig_pinterest_users', $pinterest_users);
			}
		} else {
			$pinterest_users = array($user);
			update_option('pipdig_pinterest_users', $pinterest_users);
		}
			
		
		if ( false === ( $body = get_transient( 'p3_pinterest_feed_'.$user ) )) {
			$url = "https://uk.pinterest.com/".$user."/feed.rss/";
			$args = array(
			    'timeout' => 20,
			);
			$response = wp_remote_get($url, $args);
			
			if (is_wp_error($response)) {
				return false;
			}
			
			$code = intval(json_decode($response['response']['code']));
			
			if ($code === 200) {
				$body = wp_remote_retrieve_body($response);
			} else {
				$body = $code;
			}
			
			set_transient( 'p3_pinterest_feed_'.$user, $body, 20 * MINUTE_IN_SECONDS );
		}
			
		//$body = json_decode($result['body']);
			
		//print_r($result['body']);
			
		if ($body === 400) {
			return false;
		}
		
		$xml = simplexml_load_string($body);
		
		for ($i = 0; $i < 20; $i++) {
			
			if (empty($xml->channel->item[$i]->description)) {
				break;
			}
					
			$img_url = '';				
			$pin_desc = $xml->channel->item[$i]->description;
			preg_match('@src="([^"]+)"@' , $pin_desc, $match);
			$img_url = array_pop($match);

			$images[$i] = array (
				'src' => esc_url($img_url),
				'link' => esc_url($xml->channel->item[$i]->link),
				'title' => strip_tags($xml->channel->item[$i]->title),
			);
			
		}
			
		if (!empty($images)) {
			return $images;
		} else {
			return false;
		}
			
	}
	add_action('login_footer', 'p3_pinterest_fetch', 99); // push on login page to avoid cache
}