<?php

//require_once('widgets/bloglovin.php'); // add widget
if (!function_exists('pipdig_event_setup_schedule')) {
	function pipdig_event_setup_schedule() {
		if ( ! wp_next_scheduled( 'pipdig_p3_daily_event' ) ) {
			wp_schedule_event( time(), 'twicedaily', 'pipdig_p3_daily_event'); //hourly, twicedaily or daily
		}
	}
	add_action( 'wp', 'pipdig_event_setup_schedule' );
}


if (!function_exists('pipdig_p3_do_this_daily')) {
	function pipdig_p3_do_this_daily() {
		
		$links = get_option('pipdig_links');
			
		// Bloglovin --------------------
		$bloglovin_url = $links['bloglovin'];
		if($bloglovin_url) {
			$bloglovin = wp_remote_fopen($bloglovin_url, array( 'timeout' => 10 ));
			$bloglovin_doc = new DOMDocument();
				libxml_use_internal_errors(true); //disable libxml errors
				if(!empty($bloglovin)){ //if any html is actually returned
					$bloglovin_doc->loadHTML($bloglovin);
					libxml_clear_errors(); //remove errors for yucky html
					$bloglovin_xpath = new DOMXPath($bloglovin_doc);
					$bloglovin_row = $bloglovin_xpath->query('//div[@class="num"]');
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
		$facebook_url = $links['facebook'];
		if($facebook_url) {
			// get page id from scrape first
			//<meta property="al:android:url" content="fb://page/?id=390642081017203" />
			$facebook = wp_remote_fopen($facebook_url, array( 'timeout' => 10 ));
			$facebook_doc = new DOMDocument();
			libxml_use_internal_errors(TRUE); //disable libxml errors
			if(!empty($facebook)){ //if any html is actually returned
				$facebook_doc->loadHTML($facebook);
				libxml_clear_errors(); //remove errors for yucky html
				$facebook_xpath = new DOMXPath($facebook_doc);
				$nodes = $facebook_xpath->query("//meta[@property='al:android:url']");
				foreach($nodes as $node){
				  $page_id = $node->getAttribute('content');
				  $page_id = preg_replace('/[^0-9.]+/', '', $page_id);
				}
			}
			$appid = '722209331218125';
			$appsecret = '3f9d971ecad0debbc0b983b7af6fcf34';
			$json_url ='https://graph.facebook.com/'.$page_id.'?access_token='.$appid.'|'.$appsecret.'&fields=likes';
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
		// <meta property="pinterestapp:followers" name="pinterestapp:followers" content="106168" data-app>
		// SELECT * from html where url="https://www.pinterest.com/thelovecatsinc" AND xpath="//meta[@property='pinterestapp:followers']"
		$pinterest_url = $links['pinterest'];
		if ($pinterest_url) {
			$pinterest_url = rawurlencode($pinterest_url);
			usleep(50000);
			$pinterest_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$pinterest_url."%22%20AND%20xpath%3D%22%2F%2Fmeta%5B%40property%3D'pinterestapp%3Afollowers'%5D%22&format=json", array( 'timeout' => 10 ));
			$pinterest_yql = json_decode($pinterest_yql);
			$pinterest_count = intval($pinterest_yql->query->results->meta->content);
			update_option('p3_pinterest_count', $pinterest_count);
		} else {
			delete_option('p3_pinterest_count');
		}
		
		// Twitter ---------------------
		// <li class="ProfileNav-item ProfileNav-item--followers"> (title tag of link element inside)
		// SELECT * from html where url="http://twitter.com/pipdig" AND xpath="//li[3]/a[@data-nav='followers']"
		$twitter_url = $links['twitter'];
		if ($twitter_url) {
			$twitter_url = rawurlencode($twitter_url);
			usleep(50000);
			$twitter_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$twitter_url."%22%20AND%20xpath%3D%22%2F%2Fli%5B3%5D%2Fa%5B%40data-nav%3D'followers'%5D%22&format=json&callback=", array( 'timeout' => 10 ));
			//$twitter_yql = utf8_encode($twitter_yql);
			$twitter_yql = json_decode($twitter_yql);
			$twitter_count = $twitter_yql->query->results->a->title;
			$twitter_count = str_replace(',', '', $twitter_count);
			$twitter_count = intval(str_replace('.', '', $twitter_count));
			update_option('p3_twitter_count', $twitter_count);
		} else {
			delete_option('p3_twitter_count');
		}
		
		// Instagram ---------------------
		// <span data-reactid=".0.1.0.0:0.1.3.1.0.1" title="476,475" class="-cx-PRIVATE-FollowedByStatistic__count">476k</span>
		// SELECT * from html where url="http://instagram.com/inthefrow" AND xpath="//li[2]/span"
		$instagram_url = $links['instagram'];
		if ($instagram_url) {
			$instagram_url = rawurlencode($instagram_url);
			usleep(50000);
			$instagram_yql = wp_remote_fopen("http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$instagram_url."%22%20AND%20xpath%3D%22%2F%2Fli%5B2%5D%2Fspan%22&format=json", array( 'timeout' => 10 ));
			$instagram_yql = json_decode($instagram_yql);
			$instagram_count = $instagram_yql->query->results->span->span[1]->title;
			$instagram_count = intval(str_replace(',', '', $instagram_count));
			update_option('p3_instagram_count', $instagram_count);
		} else {
			delete_option('p3_instagram_count');
		}
		
		// YouTube ---------------------
		// SELECT * from html where url="https://www.youtube.com/user/inthefrow" AND xpath="//span[@class='yt-subscription-button-subscriber-count-branded-horizontal yt-uix-tooltip']"
		$youtube_url = $links['youtube'];
		if ($youtube_url) {
			$youtube_url = rawurlencode($youtube_url);
			usleep(50000);
			$youtube_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$youtube_url."%22%20AND%20xpath%3D%22%2F%2Fspan%5B%40class%3D'yt-subscription-button-subscriber-count-branded-horizontal%20yt-uix-tooltip'%5D%22&format=json", array( 'timeout' => 10 ));
			$youtube_yql = json_decode($youtube_yql);
			$youtube_count = $youtube_yql->query->results->span->title;
			$youtube_count = intval(str_replace(',', '', $youtube_count));
			update_option('p3_youtube_count', $youtube_count);
		} else {
			delete_option('p3_youtube_count');
		}
		
		// Google Plus ---------------------
		// https://www.googleapis.com/plus/v1/people/102904094379339545145?key=AIzaSyCBYyhzMnNNP8d0tvLdSP8ryTlSDqegN5c    OR YQL below:
		// SELECT * from html where url="https://plus.google.com/+Inthefrowpage/about" AND xpath="//div[@class='Zmjtc']/span"
		$google_plus_url = $links['google_plus'];
		if ($google_plus_url) {
			$google_plus_url = rawurlencode($google_plus_url);
			usleep(50000);
			$google_plus_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22".$google_plus_url."%22%20AND%20xpath%3D%22%2F%2Fdiv%5B%40class%3D'Zmjtc'%5D%2Fspan%22&format=json&diagnostics=true", array( 'timeout' => 10 ));
			$google_plus_yql = json_decode($google_plus_yql);
			$google_plus_count = $google_plus_yql->query->results->span[0]->content;
			$google_plus_count = intval(str_replace(',', '', $google_plus_count));
			update_option('p3_google_plus_count', $google_plus_count);
		} else {
			delete_option('p3_google_plus_count');
		}
		
	}
	add_action( 'pipdig_p3_daily_event', 'pipdig_p3_do_this_daily' );
}
