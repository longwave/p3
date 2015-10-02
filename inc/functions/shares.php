<?php
if (!function_exists('p3_social_shares')) {
	function p3_social_shares() {
		
		if (get_the_post_thumbnail() != '') {
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id());
			$img = $thumb['0'];
		} else {
			$img = pipdig_p3_catch_that_image();
		}
		$link = rawurlencode(get_the_permalink());
		$title = rawurlencode(get_the_title());
		$summary = rawurlencode(get_the_excerpt());
		
		$twitter_handle = get_option('p3_twitter_handle');
		$via_handle = '';
		if (!empty($twitter_handle)) {
			$via_handle = '&via='.$twitter_handle;
		}
		
		$output = '';
		$output .= '<a href="//www.facebook.com/sharer.php?u='.$link.'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>';
		//$output .= '<a onClick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$title.'&amp;p[summary]='.$summary.'&amp;p[url]='.$link.'&amp;p[images][0]='.$img.'\',\'sharer\',\'toolbar=0,status=0,width=548,height=325\');" href="javascript: void(0)"><i class="fa fa-facebook"></i></a>';
		
		$output .= '<a href="//twitter.com/share?url='.$link.'&text='.$title.$via_handle.'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>';
		$output .= '<a href="//pinterest.com/pin/create/link/?url='.$link.'&media='.$img.'&description='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a>';
		$output .= '<a href="//plus.google.com/share?url='.$link.'" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a>';
		$output .= '<a href="//www.tumblr.com/widgets/share/tool?canonicalUrl='.$link.'&title='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-tumblr"></i></a>';
		//$output .= '<a href="//www.stumbleupon.com/submit?url='.$link.'&title='.$title.'" target="_blank" rel="nofollow"><i class="fa fa-stumbleupon"></i></a>';
		
		echo '<div class="addthis_toolbox">'.__('Share:', 'p3').' '.$output.'</div>';
	}
}