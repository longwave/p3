<?php

// social sharing
if (!function_exists('pipdig_p3_comment_count')) {
	function p3_social_shares() {
		
		if (get_the_post_thumbnail() != '') {
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id());
			$img = $thumb['0'];
		} else {
			$img = pipdig_p3_catch_that_image();
		}
		$link = rawurlencode(get_the_permalink());
		$title = urlencode(get_the_title());
		$summary = urlencode(get_the_excerpt());
		
		$twitter_handle = get_option('p3_twitter_handle');
		$via_handle = '';
		if (!empty($twitter_handle)) {
			$via_handle = '&via='.$twitter_handle;
		}
		
		$output = '';
		//$output .= '<a href="//www.facebook.com/sharer.php?u='.$link.'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>';
		$output .= '<a onClick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$title.'&amp;p[summary]='.$summary.'&amp;p[url]='.$link.'&amp;p[images][0]='.$img.'\',\'sharer\',\'toolbar=0,status=0,width=548,height=325\');" href="javascript: void(0)"><i class="fa fa-facebook"></i></a>';
		
		$output .= '<a href="//twitter.com/share?url='.$link.'&text='.$title.$via_handle.'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>';
		$output .= '<a href="//pinterest.com/pin/create/link/?url='.$link.'&media='.$img.'&description='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a>';
		$output .= '<a href="//plus.google.com/share?url='.$link.'" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a>';
		$output .= '<a href="//www.tumblr.com/widgets/share/tool?canonicalUrl='.$link.'&title='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-tumblr"></i></a>';
		//$output .= '<a href="//www.stumbleupon.com/submit?url='.$link.'&title='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-stumbleupon"></i></a>';
		
		echo '<div class="addthis_toolbox">'.__('Share:', 'p3').' '.$output.'</div>';
	}
}

// comments count
if (!function_exists('pipdig_p3_comment_count')) {
	function pipdig_p3_comment_count() {
		if (!post_password_required()) {
			$comment_count = get_comments_number();
			if ($comment_count == 1 ) {
				$comments_text = __('1 Comment', 'p3');
			} else {
				$comments_text = number_format_i18n($comment_count).' '.__('Comments', 'p3');
			}
			echo $comments_text;
		}
	}
}

// comments nav
if (!function_exists('pipdig_p3_comment_nav')) {
	function pipdig_p3_comment_nav() {
		echo '<div class="nav-previous">'.previous_comments_link('<i class="fa fa-arrow-left"></i> '.__('Older Comments', 'p3')).'</div>';
		echo '<div class="nav-next">'.next_comments_link(__('Newer Comments', 'p3').' <i class="fa fa-arrow-right"></i>').'</div>';
	}
}


//include_once('functions/related-posts.php');

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

/*
if (!function_exists('p3_instagram_css')) {
	function p3_instagram_css() {
		$output = '';
				
		echo $output;
	}
	add_action('wp_head', 'p3_instagram_css');
}

function pipdig_p3_instagram_feed() {
	if ( false === ( $result = get_transient( 'p3_instagram_feed' ) )) {
		$sb_options = get_option('sb_instagram_settings');
		if (!empty($sb_options['sb_instagram_at']) && !empty($sb_options['sb_instagram_user_id'])) {
			$accessToken = $sb_options['sb_instagram_at'];
			$userid = $sb_options['sb_instagram_user_id'];
		} else {
			$userid = '232484761';
			$accessToken = '232484761.97584da.04c923e84e0443a3a87b0016d43608a8';
		}
		$url = "https://api.instagram.com/v1/users/".$userid."/media/recent/?access_token=".$accessToken."&count=10";
		$result = wp_remote_fopen($url);
		set_transient( 'p3_instagram_feed', $result, 1 * HOUR_IN_SECONDS );
	}

	$result = json_decode($result);
	
	
	//print_r ($result);
	
	
	$img_1 = array (
		'src' => esc_url($result->data[0]->images->standard_resolution->url),
		'link' => esc_url($result->data[0]->link),
		'likes' => intval($result->data[0]->likes->count),
		'comments' => intval($result->data[0]->comments->count),
		'caption' => strip_tags($result->data[0]->caption->text),
	);
	$img_2 = array (
		'src' => esc_url($result->data[1]->images->standard_resolution->url),
		'link' => esc_url($result->data[1]->link),
		'likes' => intval($result->data[1]->likes->count),
		'comments' => intval($result->data[1]->comments->count),
		'caption' => strip_tags($result->data[1]->caption->text),
	);
	$img_3 = array (
		'src' => esc_url($result->data[2]->images->standard_resolution->url),
		'link' => esc_url($result->data[2]->link),
		'likes' => intval($result->data[2]->likes->count),
		'comments' => intval($result->data[2]->comments->count),
		'caption' => strip_tags($result->data[2]->caption->text),
	);
	$img_4 = array (
		'src' => esc_url($result->data[3]->images->standard_resolution->url),
		'link' => esc_url($result->data[3]->link),
		'likes' => intval($result->data[3]->likes->count),
		'comments' => intval($result->data[3]->comments->count),
		'caption' => strip_tags($result->data[3]->caption->text),
	);
	$img_5 = array (
		'src' => esc_url($result->data[4]->images->standard_resolution->url),
		'link' => esc_url($result->data[4]->link),
		'likes' => intval($result->data[4]->likes->count),
		'comments' => intval($result->data[4]->comments->count),
		'caption' => strip_tags($result->data[4]->caption->text),
	);
	$img_6 = array (
		'src' => esc_url($result->data[5]->images->standard_resolution->url),
		'link' => esc_url($result->data[5]->link),
		'likes' => intval($result->data[5]->likes->count),
		'comments' => intval($result->data[5]->comments->count),
		'caption' => strip_tags($result->data[5]->caption->text),
	);
	$img_7 = array (
		'src' => esc_url($result->data[6]->images->standard_resolution->url),
		'link' => esc_url($result->data[6]->link),
		'likes' => intval($result->data[6]->likes->count),
		'comments' => intval($result->data[6]->comments->count),
		'caption' => strip_tags($result->data[6]->caption->text),
	);
	$img_8 = array (
		'src' => esc_url($result->data[7]->images->standard_resolution->url),
		'link' => esc_url($result->data[7]->link),
		'likes' => intval($result->data[7]->likes->count),
		'comments' => intval($result->data[7]->comments->count),
		'caption' => strip_tags($result->data[7]->caption->text),
	);
	$img_9 = array (
		'src' => esc_url($result->data[8]->images->standard_resolution->url),
		'link' => esc_url($result->data[8]->link),
		'likes' => intval($result->data[8]->likes->count),
		'comments' => intval($result->data[8]->comments->count),
		'caption' => strip_tags($result->data[8]->caption->text),
	);
	$img_10 = array (
		'src' => esc_url($result->data[9]->images->standard_resolution->url),
		'link' => esc_url($result->data[9]->link),
		'likes' => intval($result->data[9]->likes->count),
		'comments' => intval($result->data[9]->comments->count),
		'caption' => strip_tags($result->data[9]->caption->text),
	);

	$images = array ($img_1, $img_2, $img_3, $img_4, $img_5, $img_6, $img_7, $img_8, $img_9, $img_10);
	
	?>
	<div id="p3_instagram_footer">
	<style scoped="scoped">
	.p3_instagram_post {width:10%;position:relative;display:block;float:left;background-size:cover;background-repeat:no-repeat;background-position:center;-moz-transition:all 0.2s ease-out;-webkit-transition:all 0.2s ease-out;transition:all 0.2s ease-out;text-align:center}
	#p3_instagram_footer .p3_instagram_post:hover {opacity:.63}
	#p3_instagram_footer .p3_instagram_post img {max-width:100%;height:auto;}
	#p3_instagram_footer .p3_instagram_post .p3_instagram_likes {color:#000;position:absolute;bottom:44%;width:100%;}
	#p3_instagram_footer .p3_instagram_post .p3_instagram_comments {color:#000;position:absolute;bottom:5%;left:5%}
	@media only screen and (max-width: 769px) {
		#p3_instagram_footer .p3_instagram_post {
			width: 25%;
		}
		#p3_instagram_post_4, #p3_instagram_post_5, #p3_instagram_post_6, #p3_instagram_post_7, #p3_instagram_post_8, #p3_instagram_post_9, #p3_instagram_post_10 {
			display: none;
		}
	}
	@media only screen and (max-width: 400px) {
		#p3_instagram_footer .p3_instagram_post {
			width: 50%;
		}
		#p3_instagram_post_2, #p3_instagram_post_3, #p3_instagram_post_4, #p3_instagram_post_5, #p3_instagram_post_6, #p3_instagram_post_7, #p3_instagram_post_8, #p3_instagram_post_9, #p3_instagram_post_10 {
			display: none;
		}
	}
	
.p3_instagram_likes {
	display: none;
}

.p3_instagram_square:hover~.p3_instagram_likes{
	display: block;
}
.p3_instagram_likes:hover {
	display: block;
}
	
	</style>
	<?php for ($x = 0; $x <= 9; $x++) { ?>
		<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
			<span class="p3_instagram_likes"><i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span>
		</a>
	<?php } ?>
	</div>
	<div class="clearfix"></div>
	<?php
}
*/

/* Add socialz, super search and cart to navbar -------------------------------------------------*/
if (!function_exists('add_socialz_to_menu')) { // change this check to pipdig_p3_social_navbar by Dec 2015
	function pipdig_p3_social_navbar( $items, $args ) {
		
		$navbar_icons = '';
		
		$links = get_option('pipdig_links');
		if (!empty($links)) {
			$twitter = $links['twitter'];
			$instagram = $links['instagram'];
			$facebook = $links['facebook'];
			$google = $links['google_plus'];
			$bloglovin = $links['bloglovin'];
			$pinterest = $links['pinterest'];
			$youtube = $links['youtube'];
			$tumblr = $links['tumblr'];
			$linkedin = $links['linkedin'];
			$soundcloud = $links['soundcloud'];
			$flickr = $links['flickr'];
			$email = $links['email'];
		}
		if(get_theme_mod('show_socialz_navbar')) {
			if($twitter) $navbar_icons .= '<a href="' . $twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
			if($instagram) $navbar_icons .= '<a href="' . $instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
			if($facebook) $navbar_icons .= '<a href="' . $facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
			if($google) $navbar_icons .= '<a href="' . $google . '" target="_blank"><i class="fa fa-google-plus"></i></a>';
			if($bloglovin) $navbar_icons .= '<a href="' . $bloglovin . '" target="_blank"><i class="fa fa-plus"></i></a>';
			if($pinterest) $navbar_icons .= '<a href="' . $pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
			if($youtube) $navbar_icons .= '<a href="' . $youtube . '" target="_blank"><i class="fa fa-youtube-play"></i></a>';
			if($tumblr) $navbar_icons .= '<a href="' . $tumblr . '" target="_blank"><i class="fa fa-tumblr"></i></a>';
			if($linkedin) $navbar_icons .= '<a href="' . $linkedin . '" target="_blank"><i class="fa fa-linkedin"></i></a>';
			if($soundcloud) $navbar_icons .= '<a href="' . $soundcloud . '" target="_blank"><i class="fa fa-soundcloud"></i></a>';
			if($flickr) $navbar_icons .= '<a href="' . $flickr . '" target="_blank"><i class="fa fa-flickr"></i></a>';
			if($email) $navbar_icons .= '<a href="mailto:' . $email . '" target="_blank"><i class="fa fa-envelope"></i></a>';
		}
		
		if(get_theme_mod('site_top_search')) $navbar_icons .= '<a class="toggle-search" href="#"><i class="fa fa-search"></i></a>';
		
		if (class_exists('Woocommerce')) {
			global $woocommerce;
			$navbar_icons .= '<a href="' . $woocommerce->cart->get_cart_url() . '" rel="nofollow"><i class="fa fa-shopping-cart"></i></a>';
		}
		
		if( $args->theme_location == 'primary' ) {
			return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
		}
		return $items;
	}
	add_filter('wp_nav_menu_items','pipdig_p3_social_navbar', 10, 2);
}

	