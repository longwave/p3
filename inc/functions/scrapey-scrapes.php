<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('pipdig_p3_scrapey_scrapes')) {
function pipdig_p3_scrapey_scrapes() {
	
	if ( false === ( $value = get_transient('p3_stats_gen') ) ) {
		
		delete_option('jpibfi_pro_ad');
		set_transient('p3_stats_gen', true, 12 * HOUR_IN_SECONDS);
		
		$links = get_option('pipdig_links');
		
		$args = array(
			'timeout' => 30,
			'headers' => array('user_agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'),
		);
		
		
		// Facebook --------------------
		$facebook_url = esc_url($links['facebook']);
		if($facebook_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('facebook')) {
				$likes = absint(get_scp_counter('facebook'));
				update_option('p3_facebook_count', $likes);
			} else {
				$facebook_id = parse_url($facebook_url, PHP_URL_PATH);
				$facebook_id = str_replace('/', '', $facebook_id);
				$appid = '7222'.'093312'.'18125';
				$apsec = '3f9d'.'971ecad0debb'.'c0b983b7af6fcf34';
				$json_url ='https://graph.facebook.com/'.$facebook_id.'?access_token='.$appid.'|'.$apsec.'&fields=likes';
				$json = wp_remote_fopen($json_url, $args);
				$json_output = json_decode($json);
				if(!empty($json_output->likes)){
					$likes = absint($json_output->likes);
					update_option('p3_facebook_count', $likes);
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
				$pinterest_user = parse_url($pinterest_url, PHP_URL_PATH);
				$pinterest_user = str_replace('/', '', $pinterest_user);
				$json_url ='http://api.pinterest.com/v3/pidgets/users/'.$pinterest_user.'/pins/';
				$json = wp_remote_fopen($json_url, $args);
				$json_output = json_decode($json);
				if(!empty($json_output->data->pins[0]->pinner->follower_count)){
					$pinterest_followers = absint($json_output->data->pins[0]->pinner->follower_count);
					update_option('p3_pinterest_count', $pinterest_followers);
				}
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
			$pinterest_count = absint($pinterest_yql->query->results->meta->content);
			update_option('p3_pinterest_count', $pinterest_count);
		} else {
			delete_option('p3_pinterest_count');
		}
		*/
		
		// Bloglovin --------------------
		$bloglovin_url = esc_url($links['bloglovin']);
		if($bloglovin_url) {
			$bloglovin = wp_remote_fopen($bloglovin_url, $args);
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
							$followers_int = absint($followers);
							update_option('p3_bloglovin_count', $followers_int);
						}
					}
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
				//if ( false === ( $twitter_handle = get_transient( 'p3_twitter_handle' ) ) ) {
					$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
					$twitter_handle = str_replace('/', '', $twitter_handle);
					//set_transient('p3_twitter_handle', $twitter_handle, 72 * HOUR_IN_SECONDS);
				//}
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
				if (!empty($data)) {
					$followers_count = absint($data[0]['user']['followers_count']);
					update_option('p3_twitter_count', $followers_count);
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
				if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) { 
					$ig_token = trim($instagram_deets['access_token']);
					$userid = trim($instagram_deets['user_id']);
				} else {
					$ig_token = '344758425.3a81a9f.e786d137eb5746b7b007bae026bdcb65';
					// get the handle from url
					$instagram_handle = parse_url($instagram_url, PHP_URL_PATH);
					$instagram_handle = str_replace('/', '', $instagram_handle);
					//get the userid from json
					$userid = wp_remote_fopen('https://api.instagram.com/v1/users/search?q=%22'.$instagram_handle.'%22&access_token='.$ig_token, $args);
					$userid = json_decode($userid);
					$userid = sanitize_text_field($userid->data[0]->id);
				}
				// use userid for second json
				$instagram_count = wp_remote_fopen('https://api.instagram.com/v1/users/'.$userid.'?access_token='.$ig_token, $args);
				$instagram_count = json_decode($instagram_count);
				if (!empty($instagram_count->data->counts->followed_by)) {
					$instagram_count = absint($instagram_count->data->counts->followed_by);
					update_option('p3_instagram_count', $instagram_count);
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
				$youtube_url = rawurlencode($youtube_url);
				$youtube_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$youtube_url."%22%20AND%20xpath%3D%22%2Fhtml%2Fbody%2Fdiv%5B4%5D%2Fdiv%5B4%5D%2Fdiv%2Fdiv%5B5%5D%2Fdiv%2Fdiv%5B1%5D%2Fdiv%2Fdiv%5B2%5D%2Fdiv%2Fdiv%2Fdiv%5B2%5D%2Fdiv%2Fspan%2Fspan%5B1%5D%22&format=json");
				$youtube_yql = json_decode($youtube_yql);
				if (!empty($youtube_yql->query->results->span->title)) {
					$youtube_count = $youtube_yql->query->results->span->title;
					$youtube_count = absint(str_replace(',', '', $youtube_count));
					update_option('p3_youtube_count', $youtube_count);
				}
			}
		} else {
			delete_option('p3_youtube_count');
		}
		
		/* non yql 
		get channel id using? https://www.googleapis.com/youtube/v3/channels?key=AIzaSyAFwqQSW7MI7kKHQmrYL2jl1v9Shw1bMwE&forUsername=pipdigtv&part=id
		$youtube_query = wp_remote_fopen('https://www.googleapis.com/youtube/v3/channels?part=statistics&id=CHANNEL_ID&key=AIzaSyAFwqQSW7MI7kKHQmrYL2jl1v9Shw1bMwE'); // uses lemsey
		$youtube_query = json_decode($youtube_query, true);
		$youtube_count = absint($youtube_query['items'][0]['statistics']['subscriberCount']);
		update_option('p3_youtube_count', $youtube_count);
		*/
			
		// Google Plus ---------------------
		// https://www.googleapis.com/plus/v1/people/102904094379339545145?key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c		OR YQL below:
		// SELECT * from html where url="https://plus.google.com/+Inthefrowpage/about" AND xpath="//div[@class='Zmjtc']/span"
		$google_plus_url = esc_url($links['google_plus']);
		if ($google_plus_url) {
			if (function_exists('get_scp_counter') && get_scp_counter('googleplus')) {
				$google_plus_count = absint(get_scp_counter('googleplus'));
				update_option('p3_google_plus_count', $google_plus_count);
			} else {
				$google_plus_url = rawurlencode($google_plus_url);
				$google_plus_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$google_plus_url."%22%20AND%20xpath%3D%22%2F%2Fdiv%5B%40class%3D'Zmjtc'%5D%2Fspan%22&format=json");
				$google_plus_yql = json_decode($google_plus_yql);
				if (!empty($google_plus_yql->query->results->span[0]->content)) {
					$google_plus_count = $google_plus_yql->query->results->span[0]->content;
					$google_plus_count = absint(str_replace(',', '', $google_plus_count));
					update_option('p3_google_plus_count', $google_plus_count);
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
				$twitch_user = parse_url($twitch_url, PHP_URL_PATH);
				$twitch_user = str_replace('/', '', $twitch_user);
				$twitch_request = wp_remote_fopen("https://api.twitch.tv/kraken/channels/".$twitch_user."/follows?limit=5");
				$twitch_request = json_decode($twitch_request);
				if (!empty($twitch_request->_total)) {
					$twitch_count = absint($twitch_request->_total);
					update_option('p3_twitch_count', $twitch_count);
				}
			}
		} else {
			delete_option('p3_twitch_count');
		}
		
		
		// backups...
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
