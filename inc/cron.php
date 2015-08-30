<?php

//require_once('widgets/bloglovin.php'); // add widget
if (!function_exists('pipdig_event_setup_schedule')) {
	function pipdig_event_setup_schedule() {
		if ( ! wp_next_scheduled( 'pipdig_p3_daily_event' ) ) {
			wp_schedule_event( time(), 'daily', 'pipdig_p3_daily_event'); //hourly, twicedaily or daily
		}
	}
	add_action( 'wp', 'pipdig_event_setup_schedule' );
}


if (!function_exists('pipdig_p3_do_this_daily')) {
	function pipdig_p3_do_this_daily() {
			
		//bloglovin' --------------------
		$bloglovin_url = get_theme_mod('socialz_bloglovin');
		if($bloglovin_url) {
			$bloglovin = wp_remote_fopen($bloglovin_url); //get the html returned from the following url (was file_get_contents)
			$bloglovin_doc = new DOMDocument();
				libxml_use_internal_errors(TRUE); //disable libxml errors
				if(!empty($bloglovin)){ //if any html is actually returned
					$bloglovin_doc->loadHTML($bloglovin);
				libxml_clear_errors(); //remove errors for yucky html
					$bloglovin_xpath = new DOMXPath($bloglovin_doc);
					$bloglovin_row = $bloglovin_xpath->query('//div[@class="num"]');
					if($bloglovin_row->length > 0){
					foreach($bloglovin_row as $row){
						$followers = $row->nodeValue;
						$followers = str_replace(' ', '', $followers);
						$followers_int = intval( $followers );
						update_option('p3_bloglovin_count', $followers_int);
					}
				}
			}
		}
	}
	add_action( 'pipdig_p3_daily_event', 'pipdig_p3_do_this_daily' );
}
