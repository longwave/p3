<?php

if (!defined('ABSPATH')) {
	exit;
}
if (!function_exists('p3_instagram_feeds') && pipdig_plugin_check('instagram-feed/instagram-feed.php')) {
	function p3_instagram_feeds() {
		
		$bg = get_theme_mod('content_background_color', '#ffffff');
		$num = get_theme_mod('footer_instagram_num', 8);
		if ($num <= 6) {
			$res = 'full';
		} else {
			$res = 'medium';
		}
		
		$output = '';
		$output .= '<div id="instagramz" class="nopin">';
		$output .= do_shortcode( '[instagram-feed width=100 height=100 widthunit=% heightunit=% background='.$bg.' imagepadding=1 imagepaddingunit=px class=instagramhome num='.$num.' cols='.$num.' imageres='.$res.' disablemobile=true showheader=false showbutton=false showfollow=false]' );
		$output .= '</div>';

		echo $output;

	}
	//function p3_instagram_feeds_4_smash() {
		if (get_theme_mod('header_instagram')) {
			add_action('p3_top_site_main_outside_container', 'p3_instagram_feeds');
		}
		if (get_theme_mod('footer_instagram')) {
			add_action('p3_bottom_site_main_outside_container', 'p3_instagram_feeds');
		}
	//}
	//add_action('plugins_loaded', 'p3_instagram_feeds_4_smash');
}


// customiser
if (!class_exists('p3_instagram_feeds_Customize')) {
	class p3_instagram_feeds_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_instagram_section', 
				array(
					'title' => __( 'Instagram Feeds', 'p3' ),
					'description' => sprintf(__('Options to display your Instagram feed. You will need to allow access to your Instagram account with %sthis plugin%s first.', 'p3'), '<a href="'.admin_url( 'admin.php?page=sb-instagram-feed' ).'">', '</a>'),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 78,
				) 
			);

			// header feed
			$wp_customize->add_setting('header_instagram',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
					'transport' => 'refresh'
				)
			);
			$wp_customize->add_control(
				'header_instagram',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display across header', 'p3' ),
					'section' => 'p3_instagram_section',
				)
			);


			// footer feed
			$wp_customize->add_setting('footer_instagram',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
					'transport' => 'refresh'
				)
			);
			$wp_customize->add_control(
				'footer_instagram',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display across footer', 'p3' ),
					'section' => 'p3_instagram_section',
				)
			);
			
			// Number of images to display in instagram feed
			$wp_customize->add_setting( 'footer_instagram_num', array(
				'default' => 8,
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control( 'footer_instagram_num', array(
				'type' => 'number',
				'label' => __('Number of images to display:', 'pipdig-arubanights'),
				'section' => 'p3_instagram_section',
				'input_attrs' => array(
					'min' => 4,
					'max' => 10,
					'step' => 1,
					),
				)
			);
			
		}
	}
	add_action( 'customize_register' , array( 'p3_instagram_feeds_Customize' , 'register' ) );
}
