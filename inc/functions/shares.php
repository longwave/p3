<?php

if (!defined('ABSPATH')) die;

function pipdig_p3_social_shares() {
	
	if (get_theme_mod('hide_social_sharing')) {
		return;
	}
	
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	if ($thumb) {
		$img = $thumb['0'];
	} else {
		$img = pipdig_p3_catch_that_image();
	}
	$link = get_the_permalink();
	$title = get_the_title();
	$summary = strip_shortcodes(strip_tags(get_the_excerpt()));
	
	$links = get_option('pipdig_links');
	$twitter_url = $links['twitter'];
	$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
	$twitter_handle = str_replace('/', '', $twitter_handle);
	$via_handle = '';
	if (!empty($twitter_handle)) {
		$via_handle = '&via='.$twitter_handle;
	}
	
	$output = '';
	
	if (get_theme_mod('p3_share_email')) {
		$output .= '<a href="'.esc_url('mailto:?subject=Shared: '.$title.'&body=I thought you might like this '.$link).'" target="_blank" rel="nofollow"><i class="fa fa-envelope"></i></a>';
	}
	if (get_theme_mod('p3_share_facebook', 1)) {
		$output .= '<a href="'.esc_url('https://www.facebook.com/sharer.php?u='.$link).'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>';
	}
	if (get_theme_mod('p3_share_twitter', 1)) {
		$output .= '<a href="'.esc_url('https://twitter.com/share?url='.$link.'&text='.$title.$via_handle).'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>';
	}
	if (get_theme_mod('p3_share_pinterest', 1)) {
		$output .= '<a href="'.esc_url('https://pinterest.com/pin/create/link/?url='.$link.'&media='.$img.'&description='.$title).'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a>';
	}
	if (get_theme_mod('p3_share_tumblr', 1)) {
		$output .= '<a href="'.esc_url('https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$link.'&title='.$title).'" target="_blank" rel="nofollow"><i class="fa fa-tumblr"></i></a>';
	}
	// no https support yet
	if (get_theme_mod('p3_share_weibo')) {
		$output .= '<a href="'.esc_url('http://service.weibo.com/share/share.php?'.$link.'&title='.$title.'&pic='.$img).'" target="_blank" rel="nofollow"><i class="fa fa-weibo"></i></a>';
	}
	if (get_theme_mod('p3_share_whatsapp')) {
		$output .= '<a href="'.esc_url('whatsapp://send?text='.$link).'" target="_blank" rel="nofollow" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i></a>';
	}
	if (get_theme_mod('p3_share_vk')) {
		$output .= '<a href="'.esc_url('https://vk.com/share.php?url='.$link.'&title='.$title.'&image='.$img.'&description='.$summary).'" target="_blank" rel="nofollow"><i class="fa fa-vk"></i></a>';
	}
	if (get_theme_mod('p3_share_google_plus')) {
		$output .= '<a href="'.esc_url('https://plus.google.com/share?url='.$link).'" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a>';
	}
	if (get_theme_mod('p3_share_linkedin')) {
		$output .= '<a href="'.esc_url('https://www.linkedin.com/shareArticle?mini=true&amp;url='.$link).'" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a>';
	}
	if (get_theme_mod('p3_share_stumbleupon')) {
		$output .= '<a href="'.esc_url('https://www.stumbleupon.com/submit?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow"><i class="fa fa-stumbleupon"></i></a>';
	}
	if (get_theme_mod('p3_share_reddit')) {
		$output .= '<a href="'.esc_url('https://reddit.com/submit?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow"><i class="fa fa-reddit"></i></a>';
	}
	if (get_theme_mod('p3_share_digg')) {
		$output .= '<a href="'.esc_url('https://www.digg.com/submit?url='.$link).'" target="_blank" rel="nofollow"><i class="fa fa-digg"></i></a>';
	}
	if (get_theme_mod('p3_share_pocket')) {
		$output .= '<a href="'.esc_url('https://getpocket.com/save?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow"><i class="fa fa-get-pocket"></i></a>';
	}
	if (get_theme_mod('p3_share_wordpress')) {
		$output .= '<a href="'.esc_url('https://wordpress.com/press-this.php?u='.$link.'&t='.$title.'&s='.$summary).'" target="_blank" rel="nofollow"><i class="fa fa-wordpress"></i></a>';
	}
	
	$share_title = __('Share:', 'p3');
	if (get_theme_mod('p3_share_title')) {
		$share_title = pipdig_strip(get_theme_mod('p3_share_title'));
	}
	
	echo '<div class="addthis_toolbox"><span class="p3_share_title">'.$share_title.' </span>'.$output.'</div>';
}




// customiser
if (!class_exists('pipdig_p3_social_shares_Customiser')) {
	class pipdig_p3_social_shares_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_p3_shares_section', 
				array(
					'title' => __( 'Sharing Icons', 'p3' ),
					'description'=> __( 'Use these options to control which social sharing icons should be displayed.', 'p3' ),
					'capability' => 'edit_theme_options',
					'priority' => 116,
				) 
			);

			// Hide social sharing icons
			$wp_customize->add_setting('hide_social_sharing',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('hide_social_sharing',
				array(
					'type' => 'checkbox',
					'label' => __( 'Disable all icons', 'p3' ),
					'description' => __( 'Select this option to completely remove this feature.', 'p3' ),
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_share_title',
				array(
					'type' => 'text',
					'label' => __('Title:'),
					'section' => 'pipdig_p3_shares_section',
					'input_attrs' => array(
						'placeholder' => __('Share:', 'p3'),
					),
				)
			);
			
			// Facebook
			$wp_customize->add_setting('p3_share_facebook',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_facebook',
				array(
					'type' => 'checkbox',
					'label' => 'Facebook',
					'section' => 'pipdig_p3_shares_section',
				)
			);

			// twitter
			$wp_customize->add_setting('p3_share_twitter',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_twitter',
				array(
					'type' => 'checkbox',
					'label' => 'Twitter',
					'section' => 'pipdig_p3_shares_section',
				)
			);

			// tumblr
			
			$wp_customize->add_setting('p3_share_tumblr',
				array(
					'default' =>  1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_tumblr',
				array(
					'type' => 'checkbox',
					'label' => 'Tumblr',
					'section' => 'pipdig_p3_shares_section',
				)
			);

			// pinterest
			$wp_customize->add_setting('p3_share_pinterest',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_pinterest',
				array(
					'type' => 'checkbox',
					'label' => 'Pinterest',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			// whatsapp
			$wp_customize->add_setting('p3_share_whatsapp',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_whatsapp',
				array(
					'type' => 'checkbox',
					'label' => 'Whatsapp',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			// pinterest
			$wp_customize->add_setting('p3_share_vk',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_vk',
				array(
					'type' => 'checkbox',
					'label' => 'VKontakte (VK)',
					'section' => 'pipdig_p3_shares_section',
				)
			);

			// google_plus
			$wp_customize->add_setting('p3_share_google_plus',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_google_plus',
				array(
					'type' => 'checkbox',
					'label' => 'Google Plus',
					'section' => 'pipdig_p3_shares_section',
				)
			);

			// linkedin
			$wp_customize->add_setting('p3_share_linkedin',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_linkedin',
				array(
					'type' => 'checkbox',
					'label' => 'Linkedin',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			// stumbleupon
			$wp_customize->add_setting('p3_share_stumbleupon',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_stumbleupon',
				array(
					'type' => 'checkbox',
					'label' => 'Stumbleupon',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_reddit',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_reddit',
				array(
					'type' => 'checkbox',
					'label' => 'Reddit',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_weibo',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_weibo',
				array(
					'type' => 'checkbox',
					'label' => 'Weibo',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_digg',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_digg',
				array(
					'type' => 'checkbox',
					'label' => 'Digg',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_wordpress',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_wordpress',
				array(
					'type' => 'checkbox',
					'label' => 'WordPress.com',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_pocket',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_pocket',
				array(
					'type' => 'checkbox',
					'label' => 'Pocket',
					'section' => 'pipdig_p3_shares_section',
				)
			);
			
			$wp_customize->add_setting('p3_share_email',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_share_email',
				array(
					'type' => 'checkbox',
					'label' => 'Email',
					'section' => 'pipdig_p3_shares_section',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_social_shares_Customiser' , 'register' ) );
}
