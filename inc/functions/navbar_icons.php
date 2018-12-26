<?php

if (!defined('ABSPATH')) die;

function p3_slicknav_brand($limit = 6) {
	
	$links = get_option('pipdig_links');
	$brand = '';
	$count = 0;
	
	if (function_exists('wc_get_cart_url') && get_theme_mod('p3_navbar_woocommerce', 1)) {
		global $woocommerce;
		$brand .= '<a href="'.wc_get_cart_url().'" rel="nofollow noopener" aria-label="Shopping cart" title="Shopping cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span id="p3_navbar_cart_count"> '.$woocommerce->cart->cart_contents_count.'</span></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['shop']) && get_theme_mod('p3_navbar_shop', 1)) {
		$brand .= '<a href="'.esc_url($links['shop']).'" rel="nofollow"><i class="fa fa-shopping-bag"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['twitter']) && get_theme_mod('p3_navbar_twitter', 1)) {
		$brand .= '<a href="'.esc_url($links['twitter']).'" target="_blank" rel="nofollow noopener" aria-label="twitter" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['instagram']) && get_theme_mod('p3_navbar_instagram', 1)) {
		$brand .= '<a href="'.esc_url($links['instagram']).'" target="_blank" rel="nofollow noopener" aria-label="instagram" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['facebook']) && get_theme_mod('p3_navbar_facebook', 1)) {
		$brand .= '<a href="'.esc_url($links['facebook']).'" target="_blank" rel="nofollow noopener" aria-label="facebook" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['pinterest']) && get_theme_mod('p3_navbar_pinterest', 1)) {
		$brand .= '<a href="'.esc_url($links['pinterest']).'" target="_blank" rel="nofollow noopener" aria-label="pinterest" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['youtube']) && get_theme_mod('p3_navbar_youtube', 1)) {
		$brand .= '<a href="'.esc_url($links['youtube']).'" target="_blank" rel="nofollow noopener" aria-label="youtube" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['bloglovin']) && get_theme_mod('p3_navbar_bloglovin', 1)) {
		$brand .= '<a href="'.esc_url($links['bloglovin']).'" target="_blank" rel="nofollow noopener" aria-label="bloglovin" title="bloglovin"><i class="fa fa-plus" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['snapchat']) && get_theme_mod('p3_navbar_snapchat', 1)) {
		$brand .= '<a href="'.esc_url($links['snapchat']).'" target="_blank" rel="nofollow noopener" aria-label="snapchat" title="snapchat"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['tumblr']) && get_theme_mod('p3_navbar_tumblr', 1)) {
		$brand .= '<a href="'.esc_url($links['tumblr']).'" target="_blank" rel="nofollow noopener" aria-label="tumblr" title="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['linkedin']) && get_theme_mod('p3_navbar_linkedin', 1)) {
		$brand .= '<a href="'.esc_url($links['linkedin']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-linkedin"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['soundcloud']) && get_theme_mod('p3_navbar_soundcloud', 1)) {
		$brand .= '<a href="'.esc_url($links['soundcloud']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-soundcloud"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['spotify']) && get_theme_mod('p3_navbar_spotify', 1)) {
		$brand .= '<a href="'.esc_url($links['spotify']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-spotify"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['itunes']) && get_theme_mod('p3_navbar_itunes', 1)) {
		$brand .= '<a href="'.esc_url($links['itunes']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-apple"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['flickr']) && get_theme_mod('p3_navbar_flickr', 1)) {
		$brand .= '<a href="'.esc_url($links['flickr']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-flickr"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['vk']) && get_theme_mod('p3_navbar_vk', 1)) {
		$brand .= '<a href="'.esc_url($links['vk']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-vk"></i></a>';
		$count++;
	}
	/*
	if (($count < $limit) && !empty($links['google_plus'])) {
		$brand .= '<a href="'.esc_url($links['google_plus']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-google-plus"></i></a>';
		$count++;
	}
	*/
	if (($count < $limit) && !empty($links['twitch']) && get_theme_mod('p3_navbar_twitch', 1)) {
		$brand .= '<a href="'.esc_url($links['twitch']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-twitch"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['stumbleupon']) && get_theme_mod('p3_navbar_stumbleupon', 1)) {
		$brand .= '<a href="'.esc_url($links['stumbleupon']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-stumbleupon"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['etsy']) && get_theme_mod('p3_navbar_etsy', 1)) {
		$brand .= '<a href="'.esc_url($links['etsy']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-etsy"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['reddit']) && get_theme_mod('p3_navbar_redit', 1)) {
		$brand .= '<a href="'.esc_url($links['reddit']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-reddit"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['digg']) && get_theme_mod('p3_navbar_digg', 1)) {
		$brand .= '<a href="'.esc_url($links['digg']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-digg"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['houzz']) && get_theme_mod('p3_navbar_houzz', 1)) {
		$brand .= '<a href="'.esc_url($links['houzz']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-houzz"></i></a>';
		$count++;
	}
	if (($count < $limit) && !empty($links['email']) && get_theme_mod('p3_navbar_email', 1)) {
		$brand .= '<a href="mailto:'.sanitize_email($links['email']).'" target="_blank" rel="nofollow noopener" aria-label="Email" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
		$count++;
	}

	/*
	if (empty($brand)) {
		$brand = esc_attr(get_bloginfo());
	}
	*/

	return $brand;
}

function pipdig_p3_social_navbar( $items, $args ) {
	
	if ($args->theme_location != 'primary') {
		return $items;
	}
	
	$navbar_icons = p3_slicknav_brand(999);
	
	if (get_theme_mod('site_top_search')) $navbar_icons .= '<a id="p3_search_btn" class="toggle-search" aria-label="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i></a>'; // still need to p3 this.
	
	if ($navbar_icons) {
		return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
	}
	
	return $items;
}
add_filter('wp_nav_menu_items', 'pipdig_p3_social_navbar', 10, 2);

function pipdig_p3_social_navbar_styles() {
	
	$size = absint(get_theme_mod( 'p3_navbar_icon_size'));
	
	if ($size < 11) {
		return;
	}
	
	?>
	<!-- p3 navbar icon size -->
	<style>
		.menu-bar ul li.top-socialz a { font-size: <?php echo $size; ?>px !important }
	</style>
	<!-- p3 navbar icon size END -->
	<?php
}
add_action( 'wp_head', 'pipdig_p3_social_navbar_styles', 99999 );

// customiser
class pipdig_p3_navbar_icons_Customiser {
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_section( 'p3_navbar_icons_section', 
			array(
				'title' => __( 'Navbar Icons', 'p3' ),
				'description' => __( 'You can display your social icons in the navbar using these options. Select the social icons you would like to add from below.', 'p3' ).' <a href="https://support.pipdig.co/articles/wordpress-how-to-add-social-icons-to-the-navbar/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
				'capability' => 'edit_theme_options',
				'priority' => 35,
			) 
		);
		
		// icon size
		$wp_customize->add_setting('p3_navbar_icon_size',
			array(
				'default' => 10,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_navbar_icon_size',
			array(
				'type' => 'range',
				'label' => __( 'Icon size', 'p3' ),
				'section' => 'p3_navbar_icons_section',
				'priority' => 1,
				'input_attrs' => array(
					'min' => 10,
					'max' => 35,
					'step' => 1,
				),
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
					'priority' => 2,
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
			
		// snapchat
		$wp_customize->add_setting('p3_navbar_snapchat',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_snapchat',
			array(
				'type' => 'checkbox',
				'label' => 'Snapchat',
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
			
		// spotify
		$wp_customize->add_setting('p3_navbar_spotify',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_spotify',
			array(
				'type' => 'checkbox',
				'label' => 'Spotify',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// itunes
		$wp_customize->add_setting('p3_navbar_itunes',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_itunes',
			array(
				'type' => 'checkbox',
				'label' => 'iTunes',
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
			
		// stumbleupon
		$wp_customize->add_setting('p3_navbar_stumbleupon',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_stumbleupon',
			array(
				'type' => 'checkbox',
				'label' => 'Stumbleupon',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// Goodreads
		$wp_customize->add_setting('p3_navbar_goodreads',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_goodreads',
			array(
				'type' => 'checkbox',
				'label' => 'Goodreads',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// etsy
		$wp_customize->add_setting('p3_navbar_etsy',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_etsy',
			array(
				'type' => 'checkbox',
				'label' => 'Etsy',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// reddit
		$wp_customize->add_setting('p3_navbar_reddit',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_reddit',
			array(
				'type' => 'checkbox',
				'label' => 'Reddit',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// digg
		$wp_customize->add_setting('p3_navbar_digg',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_digg',
			array(
				'type' => 'checkbox',
				'label' => 'Digg',
				'section' => 'p3_navbar_icons_section',
			)
		);
			
		// houzz
		$wp_customize->add_setting('p3_navbar_houzz',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_houzz',
			array(
				'type' => 'checkbox',
				'label' => 'Houzz',
				'section' => 'p3_navbar_icons_section',
			)
		);
		
		// shop
		$wp_customize->add_setting('p3_navbar_shop',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_shop',
			array(
				'type' => 'checkbox',
				'label' => 'Shop',
				'section' => 'p3_navbar_icons_section',
			)
		);
		
		// rss
		$wp_customize->add_setting('p3_navbar_rss',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_navbar_rss',
			array(
				'type' => 'checkbox',
				'label' => 'RSS Feed',
				'section' => 'p3_navbar_icons_section',
			)
		);

	}
}
add_action( 'customize_register' , array( 'pipdig_p3_navbar_icons_Customiser' , 'register' ) );