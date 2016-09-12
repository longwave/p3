<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_p3_social_sidebar')) {
	function pipdig_p3_social_sidebar() {
		
		if (!get_theme_mod('p3_social_sidebar_enable')) {
			return;
		}
		
		$social_sidebar = $position_class = '';
		
		if (absint(get_theme_mod('p3_social_sidebar_position', 1)) === 2) {
			$position_class = 'p3_social_sidebar_right';
		}
		
		$links = get_option('pipdig_links');
		
		$twitter = $instagram = $facebook = $bloglovin = $pinterest = $youtube = $tumblr = $linkedin = $soundcloud = $flickr = $snapchat = $vk = $email = $twitch = $google_plus = $stumbleupon = '';
		
		if (!empty($links['twitter'])) {
			$twitter = esc_url($links['twitter']);
		}
		if (!empty($links['instagram'])) {
			$instagram = esc_url($links['instagram']);
		}
		if (!empty($links['facebook'])) {
			$facebook = esc_url($links['facebook']);
		}
		if (!empty($links['bloglovin'])) {
			$bloglovin = esc_url($links['bloglovin']);
		}
		if (!empty($links['pinterest'])) {
			$pinterest = esc_url($links['pinterest']);
		}
		if (!empty($links['snapchat'])) {
			$snapchat = esc_url($links['snapchat']);
		}
		if (!empty($links['youtube'])) {
			$youtube = esc_url($links['youtube']);
		}
		if (!empty($links['tumblr'])) {
			$tumblr = esc_url($links['tumblr']);
		}
		if (!empty($links['linkedin'])) {
			$linkedin = esc_url($links['linkedin']);
		}
		if (!empty($links['soundcloud'])) {
			$soundcloud = esc_url($links['soundcloud']);
		}
		if (!empty($links['flickr'])) {
			$flickr = esc_url($links['flickr']);
		}
		if (!empty($links['vk'])) {
			$vk = esc_url($links['vk']);
		}
		if (!empty($links['google_plus'])) {
			$google_plus = esc_url($links['google_plus']);
		}
		if (!empty($links['twitch'])) {
			$twitch = esc_url($links['twitch']);
		}
		if (!empty($links['stumbleupon'])) {
			$stumbleupon = esc_url($links['stumbleupon']);
		}
		if (!empty($links['email'])) {
			$email = sanitize_email($links['email']);
		}
		
		if ($twitter || $instagram || $facebook || $bloglovin || $pinterest || $youtube || $tumblr || $linkedin || $soundcloud || $flickr || $snapchat || $vk || $email || $twitch || $google_plus || $stumbleupon) {
			
			$social_sidebar .= '<div id="p3_social_sidebar" class="'.$position_class.'">';
			
			if (get_theme_mod('p3_social_sidebar_icon_color')) {
				$social_sidebar .= '<style scoped>#p3_social_sidebar a {color:'.get_theme_mod('p3_social_sidebar_icon_color').'}</style>';
			}
			
			if($twitter && get_theme_mod('p3_social_sidebar_twitter', 1)) $social_sidebar .= '<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
			if($instagram && get_theme_mod('p3_social_sidebar_instagram', 1)) $social_sidebar .= '<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
			if($facebook && get_theme_mod('p3_social_sidebar_facebook', 1)) $social_sidebar .= '<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
			if($bloglovin && get_theme_mod('p3_social_sidebar_bloglovin', 1)) $social_sidebar .= '<a href="'.$bloglovin.'" target="_blank"><i class="fa fa-plus"></i></a>';
			if($pinterest && get_theme_mod('p3_social_sidebar_pinterest', 1)) $social_sidebar .= '<a href="'.$pinterest.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
			if($snapchat && get_theme_mod('p3_social_sidebar_snapchat', 1)) $social_sidebar .= '<a href="'.$snapchat.'" target="_blank"><i class="fa fa-snapchat-ghost"></i></a>';
			if($youtube && get_theme_mod('p3_social_sidebar_youtube', 1)) $social_sidebar .= '<a href="'.$youtube.'" target="_blank"><i class="fa fa-youtube-play"></i></a>';
			if($tumblr && get_theme_mod('p3_social_sidebar_tumblr', 1)) $social_sidebar .= '<a href="'.$tumblr.'" target="_blank"><i class="fa fa-tumblr"></i></a>';
			if($linkedin && get_theme_mod('p3_social_sidebar_linkedin', 1)) $social_sidebar .= '<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
			if($soundcloud && get_theme_mod('p3_social_sidebar_soundcloud', 1)) $social_sidebar .= '<a href="'.$soundcloud.'" target="_blank"><i class="fa fa-soundcloud"></i></a>';
			if($flickr && get_theme_mod('p3_social_sidebar_flickr', 1)) $social_sidebar .= '<a href="'.$flickr.'" target="_blank"><i class="fa fa-flickr"></i></a>';
			if($twitch && get_theme_mod('p3_social_sidebar_twitch', 1)) $social_sidebar .= '<a href="'.$twitch.'" target="_blank"><i class="fa fa-twitch"></i></a>';
			if($stumbleupon && get_theme_mod('p3_social_sidebar_stumbleupon', 1)) $social_sidebar .= '<a href="'.$stumbleupon.'" target="_blank"><i class="fa fa-stumbleupon"></i></a>';
			if($vk && get_theme_mod('p3_social_sidebar_vk', 1)) $social_sidebar .= '<a href="'.$vk.'" target="_blank"><i class="fa fa-vk"></i></a>';
			if($google_plus && get_theme_mod('p3_social_sidebar_google_plus', 1)) $social_sidebar .= '<a href="'.$google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
			if($email && get_theme_mod('p3_social_sidebar_email', 1)) $social_sidebar .= '<a href="mailto:'.$email.'" target="_blank"><i class="fa fa-envelope"></i></a>';
		
			$social_sidebar .= '</div>';
		
		}
		
		echo $social_sidebar;
		
	}
	add_action('before', 'pipdig_p3_social_sidebar');
}




// customiser
if (!class_exists('pipdig_p3_sidebar_icons_Customiser')) {
	class pipdig_p3_sidebar_icons_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_social_sidebar_section', 
				array(
					'title' => __( 'Social Sidebar', 'p3' ),
					'description' => __( 'This feature will display a social follow section to the left/right of your site. Select the social icons you would like to add from below.', 'p3' ).' <a href="https://support.pipdig.co/articles/wordpress-social-sidebar/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'capability' => 'edit_theme_options',
					'priority' => 37,
				) 
			);
			
			// enable
			$wp_customize->add_setting('p3_social_sidebar_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_enable',
				array(
					'type' => 'checkbox',
					'label' => __('Enable this feature', 'p3'),
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// position
			$wp_customize->add_setting('p3_social_sidebar_position',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_position',
				array(
					'type' => 'select',
					'label' => __('Position', 'pipdig-textdomain'),
					'section' => 'p3_social_sidebar_section',
					'choices' => array(
						1 => __('Left', 'p3'),
						2 => __('Right', 'p3'),
					),
				)
			);
			
			// icon color
			$wp_customize->add_setting('p3_social_sidebar_icon_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_social_sidebar_icon_color',
				array(
					'label' => __( 'Icon color', 'p3' ),
					'settings' => 'p3_social_sidebar_icon_color',
					'section' => 'p3_social_sidebar_section',
				)
				)
			);
			
			/*
			// icon size
			$wp_customize->add_setting('p3_social_sidebar_icon_size',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_sidebar_icon_size',
				array(
					'type' => 'number',
					'label' => __( 'Icon size', 'p3' ),
					'section' => 'p3_social_sidebar_section',
				)
			);
			*/
			
			// twitter
			$wp_customize->add_setting('p3_social_sidebar_twitter',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_twitter',
				array(
					'type' => 'checkbox',
					'label' => 'Twitter',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// instagram
			$wp_customize->add_setting('p3_social_sidebar_instagram',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_instagram',
				array(
					'type' => 'checkbox',
					'label' => 'Instagram',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// Facebook
			$wp_customize->add_setting('p3_social_sidebar_facebook',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_facebook',
				array(
					'type' => 'checkbox',
					'label' => 'Facebook',
					'section' => 'p3_social_sidebar_section',
				)
			);

			// email
			$wp_customize->add_setting('p3_social_sidebar_email',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_email',
				array(
					'type' => 'checkbox',
					'label' => 'Email',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			
			// bloglovin
			$wp_customize->add_setting('p3_social_sidebar_bloglovin',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_bloglovin',
				array(
					'type' => 'checkbox',
					'label' => 'Bloglovin',
					'section' => 'p3_social_sidebar_section',
				)
			);

			// pinterest
			$wp_customize->add_setting('p3_social_sidebar_pinterest',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_pinterest',
				array(
					'type' => 'checkbox',
					'label' => 'Pinterest',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// tumblr
			$wp_customize->add_setting('p3_social_sidebar_tumblr',
				array(
					'default' =>  1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_tumblr',
				array(
					'type' => 'checkbox',
					'label' => 'Tumblr',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// snapchat
			$wp_customize->add_setting('p3_social_sidebar_snapchat',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_snapchat',
				array(
					'type' => 'checkbox',
					'label' => 'Snapchat',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// youtube
			$wp_customize->add_setting('p3_social_sidebar_youtube',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_youtube',
				array(
					'type' => 'checkbox',
					'label' => 'YouTube',
					'section' => 'p3_social_sidebar_section',
				)
			);

			// linkedin
			$wp_customize->add_setting('p3_social_sidebar_linkedin',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_linkedin',
				array(
					'type' => 'checkbox',
					'label' => 'LinkedIn',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// soundcloud
			$wp_customize->add_setting('p3_social_sidebar_soundcloud',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_soundcloud',
				array(
					'type' => 'checkbox',
					'label' => 'SoundCloud',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// flickr
			$wp_customize->add_setting('p3_social_sidebar_flickr',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_flickr',
				array(
					'type' => 'checkbox',
					'label' => 'Flickr',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// vk
			$wp_customize->add_setting('p3_social_sidebar_vk',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_vk',
				array(
					'type' => 'checkbox',
					'label' => 'VK',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// google plus
			$wp_customize->add_setting('p3_social_sidebar_google_plus',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_google_plus',
				array(
					'type' => 'checkbox',
					'label' => 'Google Plus',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// twitch
			$wp_customize->add_setting('p3_social_sidebar_twitch',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_twitch',
				array(
					'type' => 'checkbox',
					'label' => 'Twitch.tv',
					'section' => 'p3_social_sidebar_section',
				)
			);
			
			// stumbleupon
			$wp_customize->add_setting('p3_social_sidebar_stumbleupon',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_social_sidebar_stumbleupon',
				array(
					'type' => 'checkbox',
					'label' => 'Stumbleupon',
					'section' => 'p3_social_sidebar_section',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_sidebar_icons_Customiser' , 'register' ) );
}
