<?php

if (!defined('ABSPATH')) die;

// function to fetch videos
function p3_youtube_fetch($channel_id) {
	
		$videos = array();
		
		$channel_id = trim($channel_id);
		
		$transient_id = substr($channel_id, 0, 15);
		
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
		
		if ( false === ( $videos = get_transient( 'p3_youtube_'.$transient_id ) )) {
			$url = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&type=video&channelId=UCYy8vp5OELC4WPv9DMIATeg&key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c&maxResults=20';
			$args = array(
			    'timeout' => 9,
			);
			$response = wp_remote_get($url, $args);
			
			$code = absint(wp_remote_retrieve_response_code($response));
			
			if ($code === 200) {
				$response = json_decode(wp_remote_retrieve_body($response));
				//print_r($response);
				
				for ($i = 0; $i < 20; $i++) {
					if (isset($response->items[$i]->id->videoId)) {
						
						$id = strip_tags($response->items[$i]->id->videoId);
						
						$thumbnail = "https://img.youtube.com/vi/".$id."/0.jpg";
						
						if ($i < 5) { // First vids get special treatment. Roll out the red carpet.
						
							// Get extended information from video endpoint
							$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$id.'&key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c';
							$video_response = wp_remote_get($url, $args);
							if (!is_wp_error($video_response)) {
								
								$video_response = json_decode(wp_remote_retrieve_body($video_response));
								
								// Only use YT's thumb if the user hasn't chosen to overwrite it
								if (isset($video_response->items[0]->snippet->thumbnails->maxres->url)) {
									$thumbnail = $video_response->items[0]->snippet->thumbnails->maxres->url;
								}
								
								if (isset($video_response->items[0]->snippet->description)) {
									$desc = $video_response->items[0]->snippet->description;
								}
								
							}
							
						}
						
						$videos[] = array (
							'id' => $id,
							'title' => strip_tags($response->items[$i]->snippet->title),
							'thumbnail' => esc_url($thumbnail),
							'link' => esc_url('https://www.youtube.com/watch?v='.$id),
						);
					}
				}
			} else {
				return;
			}
			
			set_transient( 'p3_youtube_'.$transient_id, $videos, 60 * MINUTE_IN_SECONDS );
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
		
		if ( false === ( $videos = get_transient( 'p3_youtube_'.$playlist_id ) )) {
			$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet%2C+id&playlistId='.$playlist_id.'&key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c&type=video&maxResults=12';
			$args = array(
			    'timeout' => 9,
			);
			$response = wp_remote_get($url, $args);
				
			$code = absint(wp_remote_retrieve_response_code($response));
			
			if ($code === 200) {
				$response = json_decode(wp_remote_retrieve_body($response));
				//print_r($response);
				
				for ($i = 0; $i < 12; $i++) {
					if (isset($response->items[$i]->snippet->resourceId->videoId)) {
						
						$id = strip_tags($response->items[$i]->snippet->resourceId->videoId);
						
						$thumbnail = "https://img.youtube.com/vi/".$id."/0.jpg";
						
						if ($i < 5) { // First vids get special treatment. Roll out the red carpet.
						
							// Get extended information from video endpoint
							$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$id.'&key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c';
							$video_response = wp_remote_get($url, $args);
							if (!is_wp_error($video_response)) {
								
								$video_response = json_decode(wp_remote_retrieve_body($video_response));
								
								// Only use YT's thumb if the user hasn't chosen to overwrite it
								if (isset($video_response->items[0]->snippet->thumbnails->maxres->url)) {
									$thumbnail = $video_response->items[0]->snippet->thumbnails->maxres->url;
								}
								
								if (isset($video_response->items[0]->snippet->description)) {
									$desc = $video_response->items[0]->snippet->description;
								}
								
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