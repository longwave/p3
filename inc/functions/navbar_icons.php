<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('add_socialz_to_menu')) { // change this check to pipdig_p3_social_navbar by Dec 2015
	function pipdig_p3_social_navbar( $items, $args ) {
		
		$navbar_icons = '';
		
		$links = get_option('pipdig_links');
		
		$twitter = $instagram = $facebook = $bloglovin = $pinterest = $youtube = $tumblr = $linkedin = $soundcloud = $flickr = $vk = $email = $twitch = $google_plus ='';
		
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
		if (!empty($links['email'])) {
			$email = sanitize_email($links['email']);
		}

			if($twitter && get_theme_mod('p3_navbar_twitter', 1)) $navbar_icons .= '<a href="' . $twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
			if($instagram && get_theme_mod('p3_navbar_instagram', 1)) $navbar_icons .= '<a href="' . $instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
			if($facebook && get_theme_mod('p3_navbar_facebook', 1)) $navbar_icons .= '<a href="' . $facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
			if($bloglovin && get_theme_mod('p3_navbar_bloglovin', 1)) $navbar_icons .= '<a href="' . $bloglovin . '" target="_blank"><i class="fa fa-plus"></i></a>';
			if($pinterest && get_theme_mod('p3_navbar_pinterest', 1)) $navbar_icons .= '<a href="' . $pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
			if($youtube && get_theme_mod('p3_navbar_youtube', 1)) $navbar_icons .= '<a href="' . $youtube . '" target="_blank"><i class="fa fa-youtube-play"></i></a>';
			if($tumblr && get_theme_mod('p3_navbar_tumblr', 1)) $navbar_icons .= '<a href="' . $tumblr . '" target="_blank"><i class="fa fa-tumblr"></i></a>';
			if($linkedin && get_theme_mod('p3_navbar_linkedin', 1)) $navbar_icons .= '<a href="' . $linkedin . '" target="_blank"><i class="fa fa-linkedin"></i></a>';
			if($soundcloud && get_theme_mod('p3_navbar_soundcloud', 1)) $navbar_icons .= '<a href="' . $soundcloud . '" target="_blank"><i class="fa fa-soundcloud"></i></a>';
			if($flickr && get_theme_mod('p3_navbar_flickr', 1)) $navbar_icons .= '<a href="' . $flickr . '" target="_blank"><i class="fa fa-flickr"></i></a>';
			if($twitch && get_theme_mod('p3_navbar_twitch', 1)) $navbar_icons .= '<a href="' . $twitch . '" target="_blank"><i class="fa fa-twitch"></i></a>';
			if($vk && get_theme_mod('p3_navbar_vk', 1)) $navbar_icons .= '<a href="' . $vk . '" target="_blank"><i class="fa fa-vk"></i></a>';
			if($google_plus && get_theme_mod('p3_navbar_google_plus', 1)) $navbar_icons .= '<a href="' . $google_plus . '" target="_blank"><i class="fa fa-google-plus"></i></a>';
			if($email && get_theme_mod('p3_navbar_email', 1)) $navbar_icons .= '<a href="mailto:' . $email . '" target="_blank"><i class="fa fa-envelope"></i></a>';
		
		if(get_theme_mod('site_top_search')) $navbar_icons .= '<a class="toggle-search"><i class="fa fa-search"></i></a>'; // still need to p3 this.
		
		if (class_exists('Woocommerce') && get_theme_mod('p3_navbar_woocommerce')) {
			global $woocommerce;
			$navbar_icons .= '<a href="' . $woocommerce->cart->get_cart_url() . '" rel="nofollow"><i class="fa fa-shopping-cart"></i></a>';
		}
		
		if( $args->theme_location == 'primary' ) {
			if ($navbar_icons) {
				return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
			}
		}
		return $items;
	}
	add_filter('wp_nav_menu_items','pipdig_p3_social_navbar', 10, 2);
}




// customiser
if (!class_exists('pipdig_p3_navbar_icons_Customiser')) {
	class pipdig_p3_navbar_icons_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_navbar_icons_section', 
				array(
					'title' => __( 'Navbar Icons', 'p3' ),
					'description' => __( 'You can display your social icons in the navbar using these options. Select the social icons you would like to add from below.', 'p3' ).' <a href="//support.pipdig.co/articles/wordpress-how-to-add-social-icons-to-the-navbar/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'capability' => 'edit_theme_options',
					'priority' => 35,
				) 
			);
			
			// woocommerce
			if (class_exists('Woocommerce')) {
				$wp_customize->add_setting('p3_navbar_woocommerce',
					array(
						'default' => 1,
						'sanitize_callback' => 'absint',
					)
				);
				$wp_customize->add_control('p3_navbar_woocommerce',
					array(
						'type' => 'checkbox',
						'label' => 'WooCommerce Cart',
						'section' => 'p3_navbar_icons_section',
					)
				);
			}
			
			// twitter
			$wp_customize->add_setting('p3_navbar_twitter',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_twitter',
				array(
					'type' => 'checkbox',
					'label' => 'Twitter',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// instagram
			$wp_customize->add_setting('p3_navbar_instagram',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_instagram',
				array(
					'type' => 'checkbox',
					'label' => 'Instagram',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// Facebook
			$wp_customize->add_setting('p3_navbar_facebook',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_facebook',
				array(
					'type' => 'checkbox',
					'label' => 'Facebook',
					'section' => 'p3_navbar_icons_section',
				)
			);

			// email
			$wp_customize->add_setting('p3_navbar_email',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_email',
				array(
					'type' => 'checkbox',
					'label' => 'Email',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			
			// bloglovin
			$wp_customize->add_setting('p3_navbar_bloglovin',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_bloglovin',
				array(
					'type' => 'checkbox',
					'label' => 'Bloglovin',
					'section' => 'p3_navbar_icons_section',
				)
			);

			// pinterest
			$wp_customize->add_setting('p3_navbar_pinterest',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_pinterest',
				array(
					'type' => 'checkbox',
					'label' => 'Pinterest',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// tumblr
			$wp_customize->add_setting('p3_navbar_tumblr',
				array(
					'default' =>  1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_tumblr',
				array(
					'type' => 'checkbox',
					'label' => 'Tumblr',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// youtube
			$wp_customize->add_setting('p3_navbar_youtube',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_youtube',
				array(
					'type' => 'checkbox',
					'label' => 'YouTube',
					'section' => 'p3_navbar_icons_section',
				)
			);

			// linkedin
			$wp_customize->add_setting('p3_navbar_linkedin',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_linkedin',
				array(
					'type' => 'checkbox',
					'label' => 'LinkedIn',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// soundcloud
			$wp_customize->add_setting('p3_navbar_soundcloud',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_soundcloud',
				array(
					'type' => 'checkbox',
					'label' => 'SoundCloud',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// flickr
			$wp_customize->add_setting('p3_navbar_flickr',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_flickr',
				array(
					'type' => 'checkbox',
					'label' => 'Flickr',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// vk
			$wp_customize->add_setting('p3_navbar_vk',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_vk',
				array(
					'type' => 'checkbox',
					'label' => 'VK',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// google plus
			$wp_customize->add_setting('p3_navbar_google_plus',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_google_plus',
				array(
					'type' => 'checkbox',
					'label' => 'Google Plus',
					'section' => 'p3_navbar_icons_section',
				)
			);
			
			// twitch
			$wp_customize->add_setting('p3_navbar_twitch',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_navbar_twitch',
				array(
					'type' => 'checkbox',
					'label' => 'Twitch.tv',
					'section' => 'p3_navbar_icons_section',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_navbar_icons_Customiser' , 'register' ) );
}
