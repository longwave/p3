<?php

if (!defined('ABSPATH')) {
	exit;
}

// function to fetch images
if (!function_exists('p3_instagram_fetch')) {
	function p3_instagram_fetch() {
		
		$instagram_deets = get_option('pipdig_instagram');
		
		if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) { 
		
			$access_token = strip_tags($instagram_deets['access_token']);
			$userid = absint($instagram_deets['user_id']);
			
			if ( false === ( $result = get_transient( 'p3_instagram_feed' ) )) {
				$url = "https://api.instagram.com/v1/users/".$userid."/media/recent/?access_token=".$access_token."&count=30";
				$result = wp_remote_fopen($url);
				set_transient( 'p3_instagram_feed', $result, 20 * MINUTE_IN_SECONDS );
			}
			
			$result = json_decode($result);
			
			//print_r($result);
			
			for ($i = 0; $i < 29; $i++) {
				if (isset($result->data[$i])) {
					$images[$i] = array (
						'src' => esc_url($result->data[$i]->images->standard_resolution->url),
						'link' => esc_url($result->data[$i]->link),
						'likes' => intval($result->data[$i]->likes->count),
						'comments' => intval($result->data[$i]->comments->count),
						'caption' => strip_tags($result->data[$i]->caption->text),
					);
				}
			}
			
			return $images;
			
		} else {
			return false;
		}
	}
	add_action('login_footer', 'p3_instagram_fetch', 99); // push on login page to avoid cache
}

// add css to head depending on amount of images displayed
function p3_instagram_css_to_head($width) {
	if (get_theme_mod('p3_instagram_header') || get_theme_mod('p3_instagram_footer')) {
		$num = intval(get_theme_mod('p3_instagram_number', 8));
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
		?>
			<div class="clearfix"></div>
			<div id="p3_instagram_footer">
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
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>.</p>';
			}
		}
	}
	add_action('p3_footer_bottom', 'p3_instagram_footer', 99);
}


// header feed
if (!function_exists('p3_instagram_header')) {
	function p3_instagram_header() {
		
		if (!get_theme_mod('p3_instagram_header') || !is_front_page() || is_paged()) {
			return;
		}
		
		$images = p3_instagram_fetch(); // grab images
			
		if ($images) {
			$meta = intval(get_theme_mod('p3_instagram_meta'));
			$num = intval(get_theme_mod('p3_instagram_number', 8));
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
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>.</p>';
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
				echo '<p style="text-align:center">Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>.</p>';
			}
		}
	}
	add_action('p3_posts_column_start', 'p3_instagram_top_of_posts', 99);
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
					'priority' => 111,
				) 
			);

			
			// header feed
			$wp_customize->add_setting('p3_instagram_header',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
					'transport' => 'refresh'
				)
			);
			$wp_customize->add_control(
				'p3_instagram_header',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display feed in the header', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			// Instagram footer
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

			// footer feed
			$wp_customize->add_setting('p3_instagram_footer',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
					'transport' => 'refresh'
				)
			);
			$wp_customize->add_control(
				'p3_instagram_footer',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display feed in the footer', 'p3' ),
					'section' => 'pipdig_p3_instagram_section',
				)
			);
			
			
			// Number of images to display in instagram feed
			$wp_customize->add_setting( 'p3_instagram_number', array(
				'default' => 8,
				'capability' => 'edit_theme_options',
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
