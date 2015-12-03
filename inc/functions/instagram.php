<?php

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_p3_instagram_feed() {
	$instagram_deets = get_option('pipdig_instagram');
	if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) { 
		$access_token = strip_tags($instagram_deets['access_token']);
		$userid = intval($instagram_deets['user_id']);
		if ( false === ( $result = get_transient( 'p3_instagram_feed' ) )) {
			$url = "https://api.instagram.com/v1/users/".$userid."/media/recent/?access_token=".$access_token."&count=10";
			$result = wp_remote_fopen($url);
			set_transient( 'p3_instagram_feed', $result, 30 * MINUTE_IN_SECONDS );
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
		<?php for ($x = 0; $x <= 9; $x++) { ?>
			<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
				<span class="p3_instagram_likes"><i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span>
			</a>
		<?php } ?>
		</div>
		<div class="clearfix"></div>
		<?php
	} else { // no access token or user id, so error for admins:
		if (current_user_can('manage_options')) {
			echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'" rel="nofollow">this page</a>.</p>';
		}
	} // endif no user_id or AT
}
