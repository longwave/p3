<?php

if (!defined('ABSPATH')) die;

function pipdig_p3_social_shares() {
	
	if (get_theme_mod('hide_social_sharing')) {
		return;
	}
	
	$img = p3_catch_image(get_the_ID(), 'full');
	$link = get_the_permalink();
	$title = rawurlencode(get_the_title());
	$summary = rawurlencode(strip_shortcodes(strip_tags(get_the_excerpt())));
	
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
		$output .= '<a href="'.esc_url('mailto:?subject=Shared: '.$title.'&body=I thought you might like this '.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share via email" title="Share via email"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_facebook', 1)) {
		$output .= '<a href="'.esc_url('https://www.facebook.com/sharer.php?u='.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share on Facebook" title="Share on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_twitter', 1)) {
		$output .= '<a href="'.esc_url('https://twitter.com/share?url='.$link.'&text='.$title.$via_handle).'" target="_blank" rel="nofollow noopener" aria-label="Share on Twitter" title="Share on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_pinterest', 1)) {
		$output .= '<a href="'.esc_url('https://pinterest.com/pin/create/link/?url='.$link.'&media='.$img.'&description='.$title).'" target="_blank" rel="nofollow noopener" aria-label="Share on Pinterest" title="Share on Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_tumblr', 1)) {
		$output .= '<a href="'.esc_url('https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$link.'&title='.$title).'" target="_blank" rel="nofollow noopener" aria-label="Share on tumblr" title="Share on tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>';
	}
	// no https support yet
	if (get_theme_mod('p3_share_weibo')) {
		$output .= '<a href="'.esc_url('http://service.weibo.com/share/share.php?url='.$link.'&title='.$title.'&pic='.$img).'" target="_blank" rel="nofollow noopener" aria-label="Share on Weibo" title="Share on Weibo"><i class="fa fa-weibo" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_whatsapp')) {
		$output .= '<a href="'.esc_url('https://api.whatsapp.com/send?text='.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share on whatsapp" title="Share on whatsapp" data-action="share/whatsapp/share"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_vk')) {
		$output .= '<a href="'.esc_url('https://vk.com/share.php?url='.$link.'&title='.$title.'&image='.$img.'&description='.$summary).'" target="_blank" rel="nofollow noopener" aria-label="Share on VK" title="Share on VK"><i class="fa fa-vk" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_google_plus')) {
		$output .= '<a href="'.esc_url('https://plus.google.com/share?url='.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share on google plus" title="Share on google plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_linkedin')) {
		$output .= '<a href="'.esc_url('https://www.linkedin.com/shareArticle?mini=true&amp;url='.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share on linkedin" title="Share on linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_stumbleupon')) {
		$output .= '<a href="'.esc_url('https://www.stumbleupon.com/submit?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow noopener" aria-label="Share on stumbleupon" title="Share on stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_reddit')) {
		$output .= '<a href="'.esc_url('https://reddit.com/submit?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow noopener" aria-label="Share on reddit" title="Share on reddit"><i class="fa fa-reddit" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_digg')) {
		$output .= '<a href="'.esc_url('https://www.digg.com/submit?url='.$link).'" target="_blank" rel="nofollow noopener" aria-label="Share on digg" title="Share on digg"><i class="fa fa-digg" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_pocket')) {
		$output .= '<a href="'.esc_url('https://getpocket.com/save?url='.$link.'&title='.$title).'" target="_blank" rel="nofollow noopener" aria-label="Save to Pocket" title="Save to Pocket"><i class="fa fa-get-pocket" aria-hidden="true"></i></a>';
	}
	if (get_theme_mod('p3_share_wordpress')) {
		$output .= '<a href="'.esc_url('https://wordpress.com/press-this.php?u='.$link.'&t='.$title.'&s='.$summary).'" target="_blank" rel="nofollow noopener" aria-label="Share on wp.com" title="Share on wp.com"><i class="fa fa-wordpress" aria-hidden="true"></i></a>';
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
