<?php

if (!defined('ABSPATH')) {
	exit;
}

function p3_instagram_fetch() {
	
	$instagram_deets = get_option('pipdig_instagram');
	
	if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) { 
	
		$access_token = strip_tags($instagram_deets['access_token']);
		$userid = absint($instagram_deets['user_id']);
		
		if ( false === ( $result = get_transient( 'p3_instagram_feed' ) )) {
			$url = "https://api.instagram.com/v1/users/".$userid."/media/recent/?access_token=".$access_token."&count=20";
			$result = wp_remote_fopen($url);
			set_transient( 'p3_instagram_feed', $result, 30 * MINUTE_IN_SECONDS );
		}
		
		$result = json_decode($result);
		
		for ($i = 0; $i < 19; $i++) {
			$images[$i] = array (
				'src' => esc_url($result->data[$i]->images->standard_resolution->url),
				'link' => esc_url($result->data[$i]->link),
				'likes' => intval($result->data[$i]->likes->count),
				'comments' => intval($result->data[$i]->comments->count),
				'caption' => strip_tags($result->data[$i]->caption->text),
			);
		}
		
		return $images;
		
	} else {
		return false;
	}
}



function p3_instagram_footer() {
	
	$images = p3_instagram_fetch(); // grab images
		
	if ($images) {
	?>
		<div id="p3_instagram_footer">
		<?php for ($x = 0; $x <= 7; $x++) { ?>
			<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
				<span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span>
			</a>
		<?php } ?>
		</div>
		<div class="clearfix"></div>
		<?php
	} else { // no access token or user id, so error for admins:
		if (current_user_can('manage_options')) {
			echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'" rel="nofollow">this page</a>.</p>';
		}
	}
}
