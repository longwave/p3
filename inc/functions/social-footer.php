<?php
function pipdig_p3_social_footer() {
	
	$links = get_option('pipdig_links');
	
	pipdig_p3_scrapey_scrapes();
	
	$count = 0;
	$twitter_count = get_option('p3_twitter_count');
	$facebook_count = get_option('p3_facebook_count');
	$instagram_count = get_option('p3_instagram_count');
	$youtube_count = get_option('p3_youtube_count');
	$pinterest_count = get_option('p3_pinterest_count');
	$bloglovin_count = get_option('p3_bloglovin_count');
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}

	if ( $twitter_count )
		$count++;

	if ( $facebook_count )
		$count++;

	if ( $instagram_count )
		$count++;

	if ( $youtube_count )
		$count++;
	
	if ( $pinterest_count )
		$count++;
	
	if ( $bloglovin_count )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'col-xs-12';
			break;
		case '2':
			$class = 'col-'.$sm.'-6';
			break;
		case '3':
			$class = 'col-'.$sm.'-4';
			break;
		case '4':
			$class = 'col-'.$sm.'-3';
			break;
		case '5':
			$class = 'col-'.$sm.'-5ths';
			break;
		case '6':
			$class = 'col-'.$md.'-2';
			break;
	}

	if ( $class ) {
		$colz = 'class="' . $class . '"';
	}

	$output = '<div class="clearfix extra-footer-outer social-footer-outer">';
	$output .= '<div class="container">';
	$output .= '<div class="row social-footer">';
	
	$total_count = $twitter_count + $facebook_count + $instagram_count + $youtube_count + $bloglovin_count + $pinterest_count;
	
	if ($total_count) {
	
		if(!empty($twitter_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['twitter'].'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> Twitter | '.$twitter_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($facebook_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['facebook'].'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> Facebook | '.$facebook_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($instagram_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['instagram'].'" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i> Instagram | '.$instagram_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($youtube_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['youtube'].'" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i> YouTube | '.$youtube_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($pinterest_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['pinterest'].'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i> Pinterest | '.$pinterest_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($bloglovin_count)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.$links['bloglovin'].'" target="_blank" rel="nofollow"><i class="fa fa-plus"></i> Bloglovin | '.$bloglovin_count.'</a>';
		$output .= '</div>';
		}
		
	}
		
	$output .= '</div>	
</div>
</div>
<style scoped>#instagramz{margin-top:0}</style>';
	
	echo $output;

}