<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// function to fetch images
if (!function_exists('p3_instagram_fetch')) {
	function p3_instagram_fetch($access_token = '') {
		
		$instagram_deets = get_option('pipdig_instagram');
		
		if (empty($access_token)) {
			$access_token = pipdig_strip($instagram_deets['access_token']);
		}
		
		if (empty($access_token)) {
			return false;
		}
		
		if (!empty($instagram_deets['user_id'])) {
			$userid = pipdig_strip($instagram_deets['user_id']);
		}
		
		if (empty($userid)) {
			$user_id = explode('.', $access_token);
			$userid = trim($user_id[0]);
		}
		
		// store user ids so we can clear transients in cron
		$instagram_users = get_option('pipdig_instagram_users');
		
		if (!empty($instagram_users)) {
			if (is_array($instagram_users)) {
				$instagram_users = array_push($instagram_users, $userid);
				update_option('pipdig_instagram_users', $instagram_users);
			}
		} else {
			$instagram_users = array($userid);
			update_option('pipdig_instagram_users', $instagram_users);
		}
			
		//$access_token = '2165912485.3a81a9f.abb156bb2d7240239e1fbbfd515d018d'; //smash
						
			
		if ( false === ( $result = get_transient( 'p3_instagram_feed_'.$userid ) )) {
			$url = "https://api.instagram.com/v1/users/".$userid."/media/recent/?access_token=".$access_token."&count=25";
			$args = array(
			    'timeout' => 30,
			);
			$response = wp_remote_get($url, $args);
				
			$code = intval(json_decode($response['response']['code']));
			
			$save_for = 20; // minutes for transient
			
			if ($code === 200) {
				$result = json_decode($response['body']);
				update_option('p3_update_notice_3', 1); // get rid of dashboard nag for new API changes
			} else {
				$result = $code;
				$save_for = 5; // minutes for transient
			}
			
			set_transient( 'p3_instagram_feed_'.$userid, $result, $save_for * MINUTE_IN_SECONDS );
		}
			
		//$result = json_decode($result['body']);
			
		//print_r($result['body']);
			
		if ($result === 400) {
			return false;
		}
			
			
		for ($i = 0; $i < 20; $i++) {
			if (!empty($result->data[$i])) {
					
				$caption = '';
				if ((!empty($result->data[$i]->caption->text))) {
					$caption = pipdig_strip($result->data[$i]->caption->text);
				}
					
				if ((!empty($result->data[$i]->images->thumbnail->url))) {
						
					$num = absint(get_theme_mod('p3_instagram_number', 8));
						
					if ($num <= 6) {
						$img_url = str_replace('s150x150/', 's640x640/', $result->data[$i]->images->thumbnail->url);
					} else {
						$img_url = str_replace('s150x150/', 's320x320/', $result->data[$i]->images->thumbnail->url);
					}
						
				}
					
				$images[$i] = array (
					'src' => esc_url($img_url),
					'link' => esc_url($result->data[$i]->link),
					'likes' => intval($result->data[$i]->likes->count),
					'comments' => intval($result->data[$i]->comments->count),
					'caption' => $caption,
				);
					
			} else {
				break;
			}
		}
			
		if (!empty($images)) {
			return $images;
		} else {
			return false;
		}
			
	}
	add_action('login_footer', 'p3_instagram_fetch', 99); // push on login page to avoid cache
}


// function to clear out transients
if (!function_exists('p3_instagram_clear_transients')) {
	function p3_instagram_clear_transients($userid = '') {
		
		delete_transient( 'p3_instagram_feed_'.$userid );
		
		$instagram_deets = get_option('pipdig_instagram');
		if (!empty($instagram_deets['access_token'])) {
		
			$access_token = pipdig_strip($instagram_deets['access_token']);
			
			if (empty($userid)) {
				$user_id = explode('.', $access_token);
				$userid = trim($user_id[0]);
			}
			delete_transient( 'p3_instagram_feed_'.$userid );
		}
		
	}
	add_action('p3_instagram_save_action', 'p3_instagram_clear_transients');
}

// add css to head depending on amount of images displayed
function p3_instagram_css_to_head($width) {
	if (get_theme_mod('p3_instagram_header') || get_theme_mod('p3_instagram_footer') || get_theme_mod('p3_instagram_kensington')) {
		$num = absint(get_theme_mod('p3_instagram_number', 8));
		$width = 100 / $num;
		?>
		<style>
		.p3_instagram_post{width:<?php echo $width; ?>%}
		@media only screen and (max-width: 719px) {
			.p3_instagram_post {
				width: 25%;
			}
			.p3_instagram_hide_mobile {
				display: none;
			}
		}
		</style>
		<?php
	}
}
add_action('wp_head', 'p3_instagram_css_to_head');


// footer feed
if (!function_exists('p3_instagram_footer')) {
	function p3_instagram_footer() {
		
		if (!get_theme_mod('p3_instagram_footer')) {
			return;
		}
		
		$images = p3_instagram_fetch(); // grab images
			
		if ($images) {
			$meta = intval(get_theme_mod('p3_instagram_meta'));
			$num = intval(get_theme_mod('p3_instagram_number', 8));
			if (get_theme_mod('p3_instagram_rows')) {
				$num = $num*2;
			}
			$links = get_option('pipdig_links');
			if (!empty($links['instagram'])) {
				$instagram_url = esc_url($links['instagram']);
				if (filter_var($instagram_url, FILTER_VALIDATE_URL)) {  // url to path
					$instagram_user = parse_url($instagram_url, PHP_URL_PATH);
					$instagram_user = str_replace('/', '', $instagram_user);
				}
			}
		?>
			<div class="clearfix"></div>
			<div id="p3_instagram_footer">
				<?php if (!empty($instagram_url) && !empty($instagram_user) && get_theme_mod('p3_instagram_footer_title')) { ?>
					<div class="p3_instagram_footer_title_bar">
						<h3><a href="<?php echo $instagram_url; ?>" target="_blank" rel="nofollow">Instagram <span style="text-transform:none">@<?php echo strip_tags($instagram_user); ?></span></a></h3>
					</div>
				<?php } ?>
				<?php $num = $num-1; // account for array starting at 0 ?>
				<?php for ($x = 0; $x <= $num; $x++) {
					$hide_class = '';
					if ($x >= 4) {
						$hide_class = ' p3_instagram_hide_mobile';
					}
					?>
					<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post<?php echo $hide_class; ?>" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
						<?php if ($meta) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
					</a>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<?php
		} else { // no access token or user id, so error for admins:
			if (current_user_can('manage_options')) {
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>. This error can also occur if you have not yet published any images to Instagram or if your Instagram profile is set to Private.</p>';
			}
		}
	}
	add_action('p3_footer_bottom', 'p3_instagram_footer', 99);
}


// header feed
if (!function_exists('p3_instagram_header')) {
	function p3_instagram_header() {
		
		if (!get_theme_mod('p3_instagram_header')) {
			return;
		}
		
		if (!get_theme_mod('p3_instagram_header_all') && (!is_front_page() || !is_home()) ) {
			return;
		}
		
		$images = p3_instagram_fetch(); // grab images
			
		if ($images) {
			$meta = intval(get_theme_mod('p3_instagram_meta'));
			$num = intval(get_theme_mod('p3_instagram_number', 8));
			if (get_theme_mod('p3_instagram_rows')) {
				$num = $num*2;
			}
		?>
			<div class="clearfix"></div>
			<div id="p3_instagram_header">
			<?php $num = $num-1; // account for array starting at 0 ?>
				<?php for ($x = 0; $x <= $num; $x++) {
					$hide_class = '';
					if ($x >= 4) {
						$hide_class = ' p3_instagram_hide_mobile';
					}
					?>
					<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post<?php echo $hide_class; ?>" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
						<?php if ($meta) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
					</a>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<?php
		} else { // no access token or user id, so error for admins:
			if (current_user_can('manage_options')) {
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>. This error can also occur if you have not yet published any images to Instagram or if your Instagram profile is set to Private.</p>';
			}
		}
	}
	add_action('p3_top_site_main', 'p3_instagram_header', 99);
}


// style & light feed
if (!function_exists('p3_instagram_top_of_posts')) {
	function p3_instagram_top_of_posts() {
		
		if (!is_home() || is_paged() || !get_theme_mod('body_instagram')) {
			return;
		}
		
		$images = p3_instagram_fetch(); // grab images
		
		if ($images) {
			$meta = intval(get_theme_mod('p3_instagram_meta'));
			//$num = intval(get_theme_mod('p3_instagram_number', 8));
		?>
			<h3 class="widget-title"><span>Instagram</span></h3>
			<div id="p3_instagram_top_of_posts">
				<?php for ($x = 0; $x <= 4; $x++) {
					$hide_class = '';
					//if ($x >= 4) {
						//$hide_class = ' p3_instagram_hide_mobile';
					//}
					?>
					<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post<?php echo $hide_class; ?>" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
						<?php if ($meta) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
					</a>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<?php
		} else { // no access token or user id, so error for admins:
			if (current_user_can('manage_options')) {
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>. This error can also occur if you have not yet published any images to Instagram or if your Instagram profile is set to Private.</p>';
			}
		}
	}
	add_action('p3_posts_column_start', 'p3_instagram_top_of_posts', 99);
}


// kensington feed
if (!function_exists('p3_instagram_bottom_of_posts')) {
	function p3_instagram_bottom_of_posts() {
		
		if (!get_theme_mod('p3_instagram_kensington') || (!is_front_page() || !is_home())) {
			return;
		}
		
		$images = p3_instagram_fetch(); // grab images
			
		if ($images) {
			$meta = intval(get_theme_mod('p3_instagram_meta'));
			$num = intval(get_theme_mod('p3_instagram_number', 8));
			if (get_theme_mod('p3_instagram_rows')) {
				$num = $num*2;
			}
		?>
			<div class="clearfix"></div>
			<div id="p3_instagram_kensington" class="row">
				<div class="container">
				<h3 class="widget-title"><span>Instagram</span></h3>
				<?php $num = $num-1; // account for array starting at 0 ?>
					<?php for ($x = 0; $x <= $num; $x++) {
						$hide_class = '';
						if ($x >= 4) {
							$hide_class = ' p3_instagram_hide_mobile';
						}
						?>
						<a href="<?php echo $images[$x]['link']; ?>" id="p3_instagram_post_<?php echo $x; ?>" class="p3_instagram_post<?php echo $hide_class; ?>" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
							<?php if ($meta) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
						</a>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php
		} else { // no access token or user id, so error for admins:
			if (current_user_can('manage_options')) {
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>. This error can also occur if you have not yet published any images to Instagram or if your Instagram profile is set to Private.</p>';
			}
		}

	}
	add_action('p3_site_main_end', 'p3_instagram_bottom_of_posts', 99);
}


// customiser
if (!class_exists('pipdig_p3_instagram_Customiser')) {
	class pipdig_p3_instagram_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_p3_instagram_section', 
				array(
					'title' => 'Instagram',
					'description' => sprintf(__('Before enabling these features, you will need to add your Instagram account to <a href="%s">this page</a>.', 'p3'), admin_url( 'admin.php?page=pipdig-instagram' )),
					'capability' => 'edit_theme_options',
					'priority' => 39,
				) 
			);

			
			// header feed
			$wp_customize->add_setting('p3_instagram_header',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_header',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display feed across the header (Homepage)', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			// header feed on all pages?
			$wp_customize->add_setting('p3_instagram_header_all',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_header_all',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display header feed on all pages', 'p3' ),
					'description' => __( 'By default, the header feed will only display on the homepage. If you want to display it on all pages, select this option too.', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			// style and light
			$wp_customize->add_setting('body_instagram',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'body_instagram',
				array(
					'type' => 'checkbox',
					'label' => __('Display feed above posts on homepage', 'p3'),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			// kensington
			$wp_customize->add_setting('p3_instagram_kensington',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_kensington',
				array(
					'type' => 'checkbox',
					'label' => __('Display feed below posts on homepage', 'p3'),
					'section' => 'pipdig_p3_instagram_section',
				)
			);

			// footer feed
			$wp_customize->add_setting('p3_instagram_footer',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_footer',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display feed across the footer', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);

			
			// Number of images to display in instagram feed
			$wp_customize->add_setting( 'p3_instagram_number', array(
				'default' => 8,
				'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control( 'p3_instagram_number', array(
				'type' => 'number',
				'label' => __('Number of images to display:', 'p3'),
				'section' => 'pipdig_p3_instagram_section',
				'input_attrs' => array(
					'min' => 4,
					'max' => 10,
					'step' => 1,
					),
				)
			);
			
			// 2 rows?
			$wp_customize->add_setting('p3_instagram_rows',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_rows',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display feed in 2 rows', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			// footer feed title
			$wp_customize->add_setting('p3_instagram_footer_title',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_footer_title',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display title above footer feed', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			
			// show likes/comments on hover
			$wp_customize->add_setting('p3_instagram_meta',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_instagram_meta',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display Comments & Likes count on hover', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);


		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_instagram_Customiser' , 'register' ) );
}
