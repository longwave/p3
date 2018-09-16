<?php

if (!defined('ABSPATH')) die;

// function to fetch images
function p3_pinterest_fetch($user, $board = 'feed') {
		
	if (!function_exists('simplexml_load_string')) {
		return false;
	}
		
	if (empty($user)) {
		return false;
	}
		
	if (empty($board)) {
		$board = 'feed';
	}
		
	$feed_id = $user;
	if ($board != 'feed') {
		$feed_id .= '_'.$board;
	}
	
	// store user ids so we can clear transients in cron
	$pinterest_users = get_option('pipdig_pinterest_users');
	
	if (!empty($pinterest_users)) {
		if (is_array($pinterest_users)) {
			$pinterest_users = array_push($pinterest_users, $feed_id);
			update_option('pipdig_pinterest_users', $pinterest_users);
		}
	} else {
		$pinterest_users = array($user);
		update_option('pipdig_pinterest_users', $pinterest_users);
	}
	
	
	if ( false === ( $body = get_transient( 'p3_pinterest_feed_'.$feed_id ) )) {
		$url = "https://www.pinterest.com/".$user."/".$board.".rss/";
		$args = array(
		    'timeout' => 9,
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
			
		set_transient( 'p3_pinterest_feed_'.$feed_id, $body, 20 * MINUTE_IN_SECONDS );
	}
	
	
	if ($body === 400) {
		return false;
	}
	
	libxml_use_internal_errors(true);
	
	$xml = simplexml_load_string($body);
	
	$images = array();
	
	for ($i = 0; $i < 20; $i++) {
		
		if (empty($xml->channel->item[$i]->description)) {
			break;
		}
		
		$img_url = '';				
		$pin_desc = $xml->channel->item[$i]->description;
		preg_match('@src="([^"]+)"@' , $pin_desc, $match);
		$img_url = array_pop($match);
			
		$large_img = str_replace('236x', '736x', $img_url);

		$images[$i] = array (
			'src' => esc_url($img_url),
			'large' => esc_url($large_img),
			'link' => esc_url($xml->channel->item[$i]->link),
			'title' => strip_tags($xml->channel->item[$i]->title),
		);
		
	}
	
	if ($images) {
		return $images;
	} else {
		return false;
	}
}	
add_action('login_footer', 'p3_pinterest_fetch', 99); // push on login page to avoid cache