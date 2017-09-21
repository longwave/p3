<?php

if (!defined('ABSPATH')) die;


// function to fetch videos
function p3_youtube_fetch($channel_id) {
	
		$videos = array();
		
		$channel_id = trim($channel_id);
		
		// store ids so we can clear transients in cron
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
	
		$key = 'AIzaSyAttqQSW7MI7kKcdmrYL2jl1t9Shw1bMwE'; // red marker for interna use
		$key = 'AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c'; // blue marker
		
		if ( false === ( $videos = get_transient( 'p3_youtube_'.$channel_id ) )) {
			$url = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channel_id.'&key='.$key.'&maxResults=20';
			$args = array(
			    'timeout' => 15,
			);
			$response = wp_remote_get($url, $args);
			
			if (is_wp_error($response)) {
				return false;
			}
				
			$code = intval(json_decode($response['response']['code']));
			
			if ($code === 200) {
				$response = json_decode($response['body']);
				//print_r($response);
				
				for ($i = 0; $i < 20; $i++) {
					if (isset($response->items[$i]->id->videoId)) {
						
						$id = strip_tags($response->items[$i]->id->videoId);
						
						$thumbnail = "https://img.youtube.com/vi/".$id."/0.jpg";
						
						if ($i < 4) { // First few get special treatment. Open the red carpet.
							$max_res_url = "https://img.youtube.com/vi/".$id."/maxresdefault.jpg";
							if (@getimagesize($max_res_url)) {
								$thumbnail = $max_res_url;
							}
						}
						
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


// fetch playlist
function p3_youtube_fetch_playlist($playlist_id) {
		
		if (empty($playlist_id)) {
			return;
		}
	
		$videos = array();
		
		$playlist_id = trim($playlist_id);
		
		// store ids so we can clear transients in cron
		$youtube_channels = get_option('pipdig_youtube_channels');
			
		if (!empty($youtube_channels)) {
			if (is_array($youtube_channels)) {
				$youtube_channels = array_push($youtube_channels, $playlist_id);
				update_option('pipdig_youtube_channels', $youtube_channels);
			}
		} else {
			$youtube_channels = array($playlist_id);
			update_option('pipdig_youtube_channels', $youtube_channels);
		}
		
		$key = 'AIzaSyAttqQSW7MI7kKcdmrYL2jl1t9Shw1bMwE'; // red marker for internal use
		$key = 'AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c'; // blue marker
		
		if ( false === ( $videos = get_transient( 'p3_youtube_'.$playlist_id ) )) {
			$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet%2C+id&maxResults=20&playlistId='.$playlist_id.'&key='.$key.'&type=video&maxResults=12';
			$args = array(
			    'timeout' => 15,
			);
			$response = wp_remote_get($url, $args);
				
			$code = intval(json_decode($response['response']['code']));
			
			if ($code === 200) {
				$response = json_decode($response['body']);
				//print_r($response);
				
				for ($i = 0; $i < 12; $i++) {
					if (isset($response->items[$i]->snippet->resourceId->videoId)) {
						
						$id = strip_tags($response->items[$i]->snippet->resourceId->videoId);
						
						$thumbnail = "https://img.youtube.com/vi/".$id."/0.jpg";
						
						if ($i < 4) { // First few get special treatment. Open the red carpet.
							$max_res_url = "https://img.youtube.com/vi/".$id."/maxresdefault.jpg";
							$max = get_headers($max_res_url);
							if (substr($max[0], 9, 3) !== '404') {
								$thumbnail = $max_res_url;
							}
						}
						
						$videos[$i] = array (
							'id' => $id,
							'title' => strip_tags($response->items[$i]->snippet->title),
							'thumbnail' => esc_url($thumbnail),
							'link' => esc_url('https://www.youtube.com/watch?v='.$id),
						);
						
					}
				}
			}
			
			set_transient( 'p3_youtube_'.$playlist_id, $videos, 60 * MINUTE_IN_SECONDS );
		}
		
		return $videos;

}