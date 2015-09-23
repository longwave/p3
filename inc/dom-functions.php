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
		
		$twitter_handle = get_option('p3_twitter_handle');
		$via_handle = '';
		if (!empty($twitter_handle)) {
			$via_handle = '&via='.$twitter_handle;
		}
		
		$output = '';
		$output .= '<a href="//www.facebook.com/sharer.php?u='.$link.'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>';
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