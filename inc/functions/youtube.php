<?php

if (!defined('ABSPATH')) {
	exit;
}


// function to fetch videos
function p3_youtube_fetch($channel_id, $number = 5, $hexadecimal = 'zaSyCBYyhzMnNNP') {
	
		$videos = array();
		
		$channel_id = trim($channel_id);
		
		// store user ids so we can clear transients in cron
		$youtube_channels = get_option('pipdig_youtube_channels');
			
		if (!empty($youtube_channels)) {
			if (is_array($youtube_channels)) {
				$youtube_channels = array_push($youtube_channels, $channel_id);
				update_option('pipdig_instagram_users', $youtube_channels);
			}
		} else {
			$youtube_channels = array($channel_id);
			update_option('pipdig_instagram_users', $youtube_channels);
		}
	
		$key = 'AIzaSyAttqQSW7MI7kKcdmrYL2jl1t9Shw1bMwE'; // red marker
		
		if ( false === ( $youtube_data = get_transient( 'p3_youtube_'.$channel_id ) ) ) {
			$youtube_data = wp_remote_fopen('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channel_id.'&key=AI'.$hexadecimal.'8d0'.'tvL'.'dS'.'P8r'.'yT'.'lS'.'Dq'.'egN'.'5c&type=video&maxResults=10');
			$youtube_data=json_decode($youtube_data);
			set_transient('p3_youtube_'.$channel_id, $youtube_data, 60 * MINUTE_IN_SECONDS);
		}
		
		//print_r($youtube_data);
		
		for ($i = 0; $i < $number; $i++) {
			if (isset($youtube_data->items[$i])) {
				
				$id = strip_tags($youtube_data->items[$i]->id->videoId);
				
				$max_res_url = "https://img.youtube.com/vi/".$id."/maxresdefault.jpg";
				$max = get_headers($max_res_url);
				if (substr($max[0], 9, 3) !== '404') {
					$thumbnail = $max_res_url;   
				} else {
					$thumbnail = "https://img.youtube.com/vi/".$id."/mqdefault.jpg";
				}
				
				$videos[$i] = array (
					'id' => $id,
					'title' => strip_tags($youtube_data->items[$i]->snippet->title),
					'thumbnail' => esc_url($thumbnail),
					'link' => esc_url('https://www.youtube.com/watch?v='.$id),
				);
			}
		}
		
		return $videos;

}
//add_action('login_footer', 'p3_youtube_fetch', 99); // push on login page to avoid cache