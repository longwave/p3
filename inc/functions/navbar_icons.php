<?php

if (!defined('ABSPATH')) die;

function p3_slicknav_brand() {
	$links = get_option('pipdig_links');
	$brand = '';
	$count = 0;

	if (function_exists('wc_get_cart_url') && get_theme_mod('p3_navbar_woocommerce', 1)) {
		$brand .= '<a href="'.wc_get_cart_url().'" rel="nofollow noopener"><i class="fa fa-shopping-cart"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['twitter']) && get_theme_mod('p3_navbar_twitter', 1)) {
		$brand .= '<a href="'.esc_url($links['twitter']).'" target="_blank" rel="nofollow noopener" aria-label="twitter" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['instagram']) && get_theme_mod('p3_navbar_instagram', 1)) {
		$brand .= '<a href="'.esc_url($links['instagram']).'" target="_blank" rel="nofollow noopener" aria-label="instagram" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['facebook']) && get_theme_mod('p3_navbar_facebook', 1)) {
		$brand .= '<a href="'.esc_url($links['facebook']).'" target="_blank" rel="nofollow noopener" aria-label="facebook" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['pinterest']) && get_theme_mod('p3_navbar_pinterest', 1)) {
		$brand .= '<a href="'.esc_url($links['pinterest']).'" target="_blank" rel="nofollow noopener" aria-label="pinterest" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['youtube']) && get_theme_mod('p3_navbar_youtube', 1)) {
		$brand .= '<a href="'.esc_url($links['youtube']).'" target="_blank" rel="nofollow noopener" aria-label="youtube" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['bloglovin']) && get_theme_mod('p3_navbar_bloglovin', 1)) {
		$brand .= '<a href="'.esc_url($links['bloglovin']).'" target="_blank" rel="nofollow noopener" aria-label="bloglovin" title="bloglovin"><i class="fa fa-plus" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['snapchat']) && get_theme_mod('p3_navbar_snapchat', 1)) {
		$brand .= '<a href="'.esc_url($links['snapchat']).'" target="_blank" rel="nofollow noopener" aria-label="snapchat" title="snapchat"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['tumblr']) && get_theme_mod('p3_navbar_tumblr', 1)) {
		$brand .= '<a href="'.esc_url($links['tumblr']).'" target="_blank" rel="nofollow noopener" aria-label="tumblr" title="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['linkedin']) && get_theme_mod('p3_navbar_linkedin', 1)) {
		$brand .= '<a href="'.esc_url($links['linkedin']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-linkedin"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['soundcloud']) && get_theme_mod('p3_navbar_soundcloud', 1)) {
		$brand .= '<a href="'.esc_url($links['soundcloud']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-soundcloud"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['spotify']) && get_theme_mod('p3_navbar_spotify', 1)) {
		$brand .= '<a href="'.esc_url($links['spotify']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-spotify"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['itunes']) && get_theme_mod('p3_navbar_itunes', 1)) {
		$brand .= '<a href="'.esc_url($links['itunes']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-apple"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['flickr']) && get_theme_mod('p3_navbar_flickr', 1)) {
		$brand .= '<a href="'.esc_url($links['flickr']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-flickr"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['vk']) && get_theme_mod('p3_navbar_vk', 1)) {
		$brand .= '<a href="'.esc_url($links['vk']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-vk"></i></a>';
		$count++;
	}
	/*
	if (($count < 6) && !empty($links['google_plus'])) {
		$brand .= '<a href="'.esc_url($links['google_plus']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-google-plus"></i></a>';
		$count++;
	}
	*/
	if (($count < 6) && !empty($links['twitch']) && get_theme_mod('p3_navbar_twitch', 1)) {
		$brand .= '<a href="'.esc_url($links['twitch']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-twitch"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['stumbleupon']) && get_theme_mod('p3_navbar_stumbleupon', 1)) {
		$brand .= '<a href="'.esc_url($links['stumbleupon']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-stumbleupon"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['etsy']) && get_theme_mod('p3_navbar_etsy', 1)) {
		$brand .= '<a href="'.esc_url($links['etsy']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-etsy"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['reddit']) && get_theme_mod('p3_navbar_redit', 1)) {
		$brand .= '<a href="'.esc_url($links['reddit']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-reddit"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['digg']) && get_theme_mod('p3_navbar_digg', 1)) {
		$brand .= '<a href="'.esc_url($links['digg']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-digg"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['houzz']) && get_theme_mod('p3_navbar_houzz', 1)) {
		$brand .= '<a href="'.esc_url($links['houzz']).'" target="_blank" rel="nofollow noopener"><i class="fa fa-houzz"></i></a>';
		$count++;
	}
	if (($count < 6) && !empty($links['email']) && get_theme_mod('p3_navbar_email', 1)) {
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
	
	$navbar_icons = '';
	
	$links = get_option('pipdig_links');
	
	$twitter = $instagram = $facebook = $bloglovin = $pinterest = $youtube = $tumblr = $linkedin = $soundcloud = $flickr = $snapchat = $vk = $email = $twitch = $google_plus = $stumbleupon = $rss = $etsy = $spotify = $itunes = $houzz = $digg = $reddit = $goodreads = $shop = '';
	
	if (!empty($links['email'])) {
		$email = sanitize_email($links['email']);
	}
	if (!empty($links['rss'])) {
		$rss = esc_url($links['rss']);
	}
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
	if (!empty($links['spotify'])) {
		$spotify = esc_url($links['spotify']);
	}
	if (!empty($links['itunes'])) {
		$itunes = esc_url($links['itunes']);
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
	if (!empty($links['etsy'])) {
		$etsy = esc_url($links['etsy']);
	}
	if (!empty($links['reddit'])) {
		$reddit = esc_url($links['reddit']);
	}
	if (!empty($links['digg'])) {
		$digg = esc_url($links['digg']);
	}
	if (!empty($links['houzz'])) {
		$houzz = esc_url($links['houzz']);
	}
	if (!empty($links['shop'])) {
		$shop = esc_url($links['shop']);
	}
	if (!empty($links['goodreads'])) {
		$goodreads = esc_url($links['goodreads']);
	}

	if($twitter && get_theme_mod('p3_navbar_twitter', 1)) $navbar_icons .= '<a href="'.$twitter.'" target="_blank" rel="nofollow noopener" aria-label="twitter" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
	if($instagram && get_theme_mod('p3_navbar_instagram', 1)) $navbar_icons .= '<a href="'.$instagram.'" target="_blank" rel="nofollow noopener" aria-label="instagram" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
	if($facebook && get_theme_mod('p3_navbar_facebook', 1)) $navbar_icons .= '<a href="'.$facebook.'" target="_blank" rel="nofollow noopener" aria-label="facebook" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
	if($pinterest && get_theme_mod('p3_navbar_pinterest', 1)) $navbar_icons .= '<a href="'.$pinterest.'" target="_blank" rel="nofollow noopener" aria-label="pinterest" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
	if($youtube && get_theme_mod('p3_navbar_youtube', 1)) $navbar_icons .= '<a href="'.$youtube.'" target="_blank" rel="nofollow noopener" aria-label="youtube" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
	if($bloglovin && get_theme_mod('p3_navbar_bloglovin', 1)) $navbar_icons .= '<a href="'.$bloglovin.'" target="_blank" rel="nofollow noopener" aria-label="bloglovin" title="bloglovin"><i class="fa fa-plus" aria-hidden="true"></i></a>';
	if($snapchat && get_theme_mod('p3_navbar_snapchat', 1)) $navbar_icons .= '<a href="'.$snapchat.'" target="_blank" rel="nofollow noopener" aria-label="snapchat" title="snapchat"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></a>';
	if($tumblr && get_theme_mod('p3_navbar_tumblr', 1)) $navbar_icons .= '<a href="'.$tumblr.'" target="_blank" rel="nofollow noopener" aria-label="tumblr" title="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>';
	if($linkedin && get_theme_mod('p3_navbar_linkedin', 1)) $navbar_icons .= '<a href="'.$linkedin.'" target="_blank" rel="nofollow noopener" aria-label="linkedin" title="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
	if($soundcloud && get_theme_mod('p3_navbar_soundcloud', 1)) $navbar_icons .= '<a href="'.$soundcloud.'" target="_blank" rel="nofollow noopener" aria-label="soundcloud" title="soundcloud"><i class="fa fa-soundcloud" aria-hidden="true"></i></a>';
	if($spotify && get_theme_mod('p3_navbar_spotify', 1)) $navbar_icons .= '<a href="'.$spotify.'" target="_blank" rel="nofollow noopener" aria-label="spotify" title="spotify"><i class="fa fa-spotify" aria-hidden="true"></i></a>';
	if($itunes && get_theme_mod('p3_navbar_itunes', 1)) $navbar_icons .= '<a href="'.$itunes.'" target="_blank" rel="nofollow noopener" aria-label="itunes" title="itunes"><i class="fa fa-apple" aria-hidden="true"></i></a>';
	if($flickr && get_theme_mod('p3_navbar_flickr', 1)) $navbar_icons .= '<a href="'.$flickr.'" target="_blank" rel="nofollow noopener" aria-label="flickr" title="flickr"><i class="fa fa-flickr" aria-hidden="true"></i></a>';
	if($twitch && get_theme_mod('p3_navbar_twitch', 1)) $navbar_icons .= '<a href="'.$twitch.'" target="_blank" rel="nofollow noopener" aria-label="twitch" title="twitch"><i class="fa fa-twitch" aria-hidden="true"></i></a>';
	if($stumbleupon && get_theme_mod('p3_navbar_stumbleupon', 1)) $navbar_icons .= '<a href="'.$stumbleupon.'" target="_blank" rel="nofollow noopener" aria-label="stumbleupon" title="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a>';
	if($etsy && get_theme_mod('p3_navbar_etsy', 1)) $navbar_icons .= '<a href="'.$etsy.'" target="_blank" rel="nofollow noopener" aria-label="etsy" title="etsy"><i class="fa fa-etsy" aria-hidden="true"></i></a>';
	if($goodreads && get_theme_mod('p3_navbar_goodreads', 1)) $navbar_icons .= '<a href="'.$goodreads.'" target="_blank" rel="nofollow noopener" aria-label="Goodreads" title="Goodreads"><i class="fa fa-book" aria-hidden="true"></i></a>';
	if($houzz && get_theme_mod('p3_navbar_houzz', 1)) $navbar_icons .= '<a href="'.$houzz.'" target="_blank" rel="nofollow noopener" aria-label="houzz" title="houzz"><i class="fa fa-houzz" aria-hidden="true"></i></a>';
	if($vk && get_theme_mod('p3_navbar_vk', 1)) $navbar_icons .= '<a href="'.$vk.'" target="_blank" rel="nofollow noopener" aria-label="VK" title="VK"><i class="fa fa-vk" aria-hidden="true"></i></a>';
	if($google_plus && get_theme_mod('p3_navbar_google_plus', 1)) $navbar_icons .= '<a href="'.$google_plus.'" target="_blank" rel="nofollow noopener" aria-label="Google Plus" title="Google Plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
	if($reddit && get_theme_mod('p3_navbar_reddit', 1)) $navbar_icons .= '<a href="'.$reddit.'" target="_blank" rel="nofollow noopener" aria-label="reddit" title="reddit"><i class="fa fa-reddit" aria-hidden="true"></i></a>';
	if($digg && get_theme_mod('p3_navbar_digg', 1)) $navbar_icons .= '<a href="'.$digg.'" target="_blank" rel="nofollow noopener" aria-label="digg" title="digg"><i class="fa fa-digg" aria-hidden="true"></i></a>';
	if($rss && get_theme_mod('p3_navbar_rss', 1)) $navbar_icons .= '<a href="'.$rss.'" target="_blank" rel="nofollow noopener" aria-label="RSS Feed" title="RSS Feed"><i class="fa fa-rss" aria-hidden="true"></i></a>';
	if($shop && get_theme_mod('p3_navbar_shop', 1)) $navbar_icons .= '<a href="'.$shop.'" rel="nofollow noopener" aria-label="Shop" title="Shop"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>';
	if($email && get_theme_mod('p3_navbar_email', 1)) $navbar_icons .= '<a href="mailto:'.$email.'" target="_blank" rel="nofollow noopener" aria-label="Email" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
	
	if (get_theme_mod('site_top_search')) $navbar_icons .= '<a id="p3_search_btn" class="toggle-search" aria-label="Search" title="Search"><i class="fa fa-search" aria-hidden="true"></i></a>'; // still need to p3 this.
		
	if (function_exists('wc_get_cart_url') && get_theme_mod('p3_navbar_woocommerce', 1)) {
		global $woocommerce;
		$navbar_icons .= '<a href="'.wc_get_cart_url().'" rel="nofollow noopener" aria-label="Shopping cart" title="Shopping cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span id="p3_navbar_cart_count"> '.$woocommerce->cart->cart_contents_count.'</span></a>';
	}
	
	if ($navbar_icons) {
		return $items.'<li class="socialz top-socialz">' . $navbar_icons . '</li>';
	}
	
	return $items;
}
add_filter('wp_nav_menu_items','pipdig_p3_social_navbar', 10, 2);

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