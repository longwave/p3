<?php

if (!defined('ABSPATH')) die;

// function to fetch images
function p3_pinterest_fetch($user, $board = '') {
	
	$user = sanitize_text_field($user);
	$board = sanitize_text_field($board);
	
	$transient_id = substr($user.$board, 0, 39);
	
	if ( false === ( $images = get_transient( 'p3_p_'.$transient_id ) )) {
		
		if ($board) {
			$url = 'https://api.pinterest.com/v3/pidgets/boards/'.$user.'/'.$board.'/pins/';
		} else {
			$url = 'https://api.pinterest.com/v3/pidgets/users/'.$user.'/pins/';
		}
		
		$args = array(
		    'timeout' => 9,
		);
		$response = wp_safe_remote_get($url, $args);
		
		if (is_wp_error($response)) {
			return false;
		}
		
		$code = intval(json_decode($response['response']['code']));
		
		if ($code === 200) {
			$result = json_decode($response['body']);
		} else {
			return false;
		}
		
		$images = array();
		
		if (!isset($result->data->pins)) {
			return false;
		}
		
		foreach ($result->data->pins as $image) {
			$pin_img = $image->images->{'237x'}->url;
			$link = 'https://pinterest.com/'.$user;
			if (!empty($image->link)) {
				$link = esc_url($image->link);
			}
			$images[] = array (
				'src' => esc_url(str_replace("237x", "736x", $pin_img)),
				'src_low' => esc_url($pin_img),
				'link' => esc_url($link),
			);
		}
		
		set_transient( 'p3_p_'.$transient_id, $images, 30 * MINUTE_IN_SECONDS );
	}
	
	if (!empty($images)) {
		return $images;
	} else {
		return false;
	}
	
}