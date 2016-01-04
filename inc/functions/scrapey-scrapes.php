<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('pipdig_p3_scrapey_scrapes')) {
function pipdig_p3_scrapey_scrapes() {
	
	if ( false === ( $value = get_transient('p3_stats_gen') ) ) {
	
		set_transient('p3_stats_gen', true, 12 * HOUR_IN_SECONDS);
		$links = get_option('pipdig_links');
		
		// Bloglovin --------------------
		$bloglovin_url = esc_url($links['bloglovin']);
		if($bloglovin_url) {
			$user_agent  = stream_context_create(array('http' => array('user_agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36')));
			$bloglovin = file_get_contents($bloglovin_url, false, $user_agent);
			$bloglovin_doc = new DOMDocument();
				libxml_use_internal_errors(true);
				if(!empty($bloglovin)){
					$bloglovin_doc->loadHTML($bloglovin);
					libxml_clear_errors();
					$bloglovin_xpath = new DOMXPath($bloglovin_doc);
					$bloglovin_row = $bloglovin_xpath->query('//div[@class="header-card"]/ol/li[2]');
					if($bloglovin_row->length > 0){
					foreach($bloglovin_row as $row){
						$followers = $row->nodeValue;
						$followers = str_replace(' ', '', $followers);
						$followers_int = intval($followers);
						update_option('p3_bloglovin_count', $followers_int);
					}
				}
			}
		} else {
			delete_option('p3_bloglovin_count');
		}
			
		// Facebook --------------------
		$facebook_url = esc_url($links['facebook']);
		if($facebook_url) {
			$facebook_id = parse_url($facebook_url, PHP_URL_PATH);
			$facebook_id = str_replace('/', '', $facebook_id);
			$appid = '7222'.'093312'.'18125';
			$apsec = '3f9d'.'971ecad0debb'.'c0b983b7af6fcf34';
			$json_url ='https://graph.facebook.com/'.$facebook_id.'?access_token='.$appid.'|'.$apsec.'&fields=likes';
			$json = wp_remote_fopen($json_url);
			$json_output = json_decode($json);
			if($json_output->likes){
				$likes = intval($json_output->likes);
				update_option('p3_facebook_count', $likes);
			}
		} else {
			delete_option('p3_facebook_count');
		}
		
		// Pinterest ---------------------
		$pinterest_url = esc_url($links['pinterest']);
		if($pinterest_url) {
			$pinterest_user = parse_url($pinterest_url, PHP_URL_PATH);
			$pinterest_user = str_replace('/', '', $pinterest_user);
			$json_url ='http://api.pinterest.com/v3/pidgets/users/'.$pinterest_user.'/pins/';
			$json = wp_remote_fopen($json_url);
			$json_output = json_decode($json);
			if($json_output->data->pins[0]->pinner->follower_count){
				$pinterest_followers = intval($json_output->data->pins[0]->pinner->follower_count);
				update_option('p3_pinterest_count', $pinterest_followers);
			}
		} else {
			delete_option('p3_pinterest_count');
		}
		// <meta property="pinterestapp:followers" name="pinterestapp:followers" content="106168" data-app>
		// SELECT * from html where url="https://www.pinterest.com/thelovecatsinc" AND xpath="//meta[@property='pinterestapp:followers']"
		/*
		$pinterest_url = esc_url($links['pinterest']);
		if ($pinterest_url) {
			$pinterest_url = rawurlencode($pinterest_url);
			$pinterest_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$pinterest_url."%22%20AND%20xpath%3D%22%2F%2Fmeta%5B%40property%3D'pinterestapp%3Afollowers'%5D%22&format=json", array( 'timeout' => 30 ));
			$pinterest_yql = json_decode($pinterest_yql);
			$pinterest_count = intval($pinterest_yql->query->results->meta->content);
			update_option('p3_pinterest_count', $pinterest_count);
		} else {
			delete_option('p3_pinterest_count');
		}
		*/
		
		
		
		// Twitter ---------------------
		$twitter_url = esc_url($links['twitter']);
		if ($twitter_url) {
			if ( false === ( $twitter_handle = get_transient( 'p3_twitter_handle' ) ) ) {
				$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
				$twitter_handle = str_replace('/', '', $twitter_handle);
				set_transient('p3_twitter_handle', $twitter_handle, 72 * HOUR_IN_SECONDS);
			}
			include_once('TwitterAPIExchange.php');
			$settings = array(
				'oauth_access_token' => '986760666-NQx9i4Xja2NWKoOdxnRHjs2EuVIhayV7EO8ydISP',
				'oauth_access_token_secret' => 'VM234GP3J4SnCocEPT1iEcqcTd2zprm0j5Mcw4htM196u',
				'consumer_key' => 'K4iBpRCBXll4LGbLXgG3xpMU9',
				'consumer_secret' => 'GE4p3rCPK93t4BD3i6YxTTPMCqyXYXc30XhXtZfW4Fh4TjwUdU'
			);
			$ta_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name='.$twitter_handle;
			$requestMethod = 'GET';
			$twitter = new TwitterAPIExchange($settings);
			$follow_count = $twitter->setGetfield($getfield)
			->buildOauth($ta_url, $requestMethod)
			->performRequest();
			$data = json_decode($follow_count, true);
			$followers_count = intval($data[0]['user']['followers_count']);
			update_option('p3_twitter_count', $followers_count);
		} else {
			delete_option('p3_twitter_count');
		}


		// Instagram ---------------------
		// SELECT * from html where url="http://instagram.com/inthefrow" AND xpath="//li[2]/span"
		$instagram_url = esc_url($links['instagram']);
		if ($instagram_url) {
			$instagram_deets = get_option('pipdig_instagram'); // from p3
			if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) { 
				$ig_token = strip_tags($instagram_deets['access_token']);
				$userid = intval($instagram_deets['user_id']);
			} else {
				$ig_token = '21659'.'12485'.'.'.'ee7687e'.'.'.'b66a7b'.'1e71c8'.'4d30ae087f'.'963c7a3aaa';
				// get the handle from url
				$instagram_handle = parse_url($instagram_url, PHP_URL_PATH);
				$instagram_handle = str_replace('/', '', $instagram_handle);
				//get the userid from json
				$userid = wp_remote_fopen('https://api.instagram.com/v1/users/search?q=%22'.$instagram_handle.'%22&access_token='.$ig_token, array( 'timeout' => 20 ));
				$userid = json_decode($userid);
				$userid = intval($userid->data[0]->id);
			}
			// use userid for second json
			$instagram_count = wp_remote_fopen('https://api.instagram.com/v1/users/'.$userid.'?access_token='.$ig_token, array( 'timeout' => 20 ));
			$instagram_count = json_decode($instagram_count);
			$instagram_count = $instagram_count->data->counts->followed_by;
			update_option('p3_instagram_count', $instagram_count);
		} else {
			delete_option('p3_instagram_count');
		}
			
		// YouTube ---------------------
		// SELECT * from html where url="https://www.youtube.com/user/inthefrow" AND xpath="/html/body/div[4]/div[4]/div/div[5]/div/div[1]/div/div[2]/div/div/div[2]/div/span/span[1]"
		$youtube_url = esc_url($links['youtube']);
		if ($youtube_url) {
			$youtube_url = rawurlencode($youtube_url);
			usleep(500);
			$youtube_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$youtube_url."%22%20AND%20xpath%3D%22%2Fhtml%2Fbody%2Fdiv%5B4%5D%2Fdiv%5B4%5D%2Fdiv%2Fdiv%5B5%5D%2Fdiv%2Fdiv%5B1%5D%2Fdiv%2Fdiv%5B2%5D%2Fdiv%2Fdiv%2Fdiv%5B2%5D%2Fdiv%2Fspan%2Fspan%5B1%5D%22&format=json", array( 'timeout' => 20 ));
			$youtube_yql = json_decode($youtube_yql);
			$youtube_count = $youtube_yql->query->results->span->title;
			$youtube_count = intval(str_replace(',', '', $youtube_count));
			update_option('p3_youtube_count', $youtube_count);
		} else {
			delete_option('p3_youtube_count');
		}
		/* non yql 
		$youtube_query = wp_remote_fopen('https://www.googleapis.com/youtube/v3/channels?part=statistics&id=CHANNEL_ID&key=API_KEY');
		$youtube_query = json_decode($youtube_query, true);
		$youtube_count = intval($youtube_query['items'][0]['statistics']['subscriberCount']);
		update_option('p3_youtube_count', $youtube_count);
		*/
			
		// Google Plus ---------------------
		// https://www.googleapis.com/plus/v1/people/102904094379339545145?key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c		OR YQL below:
		// SELECT * from html where url="https://plus.google.com/+Inthefrowpage/about" AND xpath="//div[@class='Zmjtc']/span"
		$google_plus_url = esc_url($links['google_plus']);
		if ($google_plus_url) {
			$google_plus_url = rawurlencode($google_plus_url);
			usleep(500);
			$google_plus_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$google_plus_url."%22%20AND%20xpath%3D%22%2F%2Fdiv%5B%40class%3D'Zmjtc'%5D%2Fspan%22&format=json", array( 'timeout' => 30 ));
			$google_plus_yql = json_decode($google_plus_yql);
			if ($google_plus_yql->query->results->span[0]->content) {
				$google_plus_count = $google_plus_yql->query->results->span[0]->content;
			}
			$google_plus_count = intval(str_replace(',', '', $google_plus_count));
			update_option('p3_google_plus_count', $google_plus_count);
		} else {
			delete_option('p3_google_plus_count');
		}
	
	}
	
}
}

// push scrape on login page to avoid cached pages
if (!function_exists('pipdig_p3_scrapey_scrapes_pusher')) {
	function pipdig_p3_scrapey_scrapes_pusher() {
		pipdig_p3_scrapey_scrapes();
	}
	add_action('login_footer', 'pipdig_p3_scrapey_scrapes_pusher', 99);
}