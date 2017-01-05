<?php

if ( ! defined( 'ABSPATH' ) ) exit;


// function to fetch videos
function p3_youtube_fetch($channel_id) {
	
		$videos = array();
		
		$channel_id = trim($channel_id);
		
		// store user ids so we can clear transients in cron
		$youtube_channels = get_option('pipdig_youtube_channels');
			
		if (!empty($youtube_channels)) {
			if (is_array($youtube_channels)) {
				$youtube_channels = array_push($youtube_channels, $channel_id);
				update_option('pipdig_youtube_channels', $youtube_channels);
			}
		} else {
			$youtube_channels = array($channel_id);
			update_option('pipdig_youtube_channels', $youtube_channels);
		}
	
		$key = 'AIzaSyAttqQSW7MI7kKcdmrYL2jl1t9Shw1bMwE'; // red marker
		$key = 'AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c';
		
		if ( false === ( $videos = get_transient( 'p3_youtube_'.$channel_id ) )) {
			$url = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channel_id.'&key='.$key.'&maxResults=20';
			$args = array(
			    'timeout' => 30,
			);
			$response = wp_remote_get($url, $args);
				
			$code = intval(json_decode($response['response']['code']));
			
			if ($code === 200) {
				$response = json_decode($response['body']);
				//print_r($response);
				
				for ($i = 0; $i < 20; $i++) {
					if (isset($response->items[$i]->id->videoId)) {
						
						$id = strip_tags($response->items[$i]->id->videoId);
						
						/*
						$max_res_url = "https://img.youtube.com/vi/".$id."/maxresdefault.jpg";
						$max = get_headers($max_res_url);
						if (substr($max[0], 9, 3) !== '404') {
							$thumbnail = $max_res_url;   
						} else {
							$thumbnail = "https://img.youtube.com/vi/".$id."/mqdefault.jpg";
						}
						*/
						
						$thumbnail = "https://img.youtube.com/vi/".$id."/0.jpg";
						
						$videos[$i] = array (
							'id' => $id,
							'title' => strip_tags($response->items[$i]->snippet->title),
							'thumbnail' => esc_url($thumbnail),
							'link' => esc_url('https://www.youtube.com/watch?v='.$id),
						);
					}
				}
			}
			
			set_transient( 'p3_youtube_'.$channel_id, $videos, 60 * MINUTE_IN_SECONDS );
		}
		
		return $videos;

}
//add_action('login_footer', 'p3_youtube_fetch', 99); // push on login page to avoid cache