<?php

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_p3_social_footer() {
	
	$links = get_option('pipdig_links');
	
	pipdig_p3_scrapey_scrapes();
	
	$count = 0;
	$twitter_count = intval(get_option('p3_twitter_count'));
	$facebook_count = intval(get_option('p3_facebook_count'));
	$instagram_count = intval(get_option('p3_instagram_count'));
	$youtube_count = intval(get_option('p3_youtube_count'));
	$pinterest_count = intval(get_option('p3_pinterest_count'));
	$bloglovin_count = intval(get_option('p3_bloglovin_count'));
	
	if (get_theme_mod('disable_responsive')) {
		$sm = $md = 'xs';
	} else {
		$sm = 'sm';
		$md = 'md';
	}

	if ( $twitter_count )
		$count++;

	if ( $facebook_count )
		$count++;

	if ( $instagram_count )
		$count++;

	if ( $youtube_count )
		$count++;
	
	if ( $pinterest_count )
		$count++;
	
	if ( $bloglovin_count )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'col-xs-12';
			break;
		case '2':
			$class = 'col-'.$sm.'-6';
			break;
		case '3':
			$class = 'col-'.$sm.'-4';
			break;
		case '4':
			$class = 'col-'.$sm.'-3';
			break;
		case '5':
			$class = 'col-'.$sm.'-5ths';
			break;
		case '6':
			$class = 'col-'.$md.'-2';
			break;
	}

	if ( $class ) {
		$colz = 'class="' . $class . '"';
	}

	$output = '<div class="clearfix extra-footer-outer social-footer-outer">';
	$output .= '<div class="container">';
	$output .= '<div class="row social-footer">';
	
	$total_count = $twitter_count + $facebook_count + $instagram_count + $youtube_count + $bloglovin_count + $pinterest_count;
	
	if ($total_count) {
	
		if (!empty($twitter_count) && get_theme_mod('p3_social_footer_twitter', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['twitter']).'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> Twitter | '.$twitter_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($facebook_count) && get_theme_mod('p3_social_footer_facebook', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['facebook']).'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> Facebook | '.$facebook_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($instagram_count) && get_theme_mod('p3_social_footer_instagram', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['instagram']).'" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i> Instagram | '.$instagram_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($youtube_count) && get_theme_mod('p3_social_footer_youtube', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['youtube']).'" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i> YouTube | '.$youtube_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($pinterest_count) && get_theme_mod('p3_social_footer_pinterest', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['pinterest']).'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i> Pinterest | '.$pinterest_count.'</a>';
		$output .= '</div>';
		}
		
		if(!empty($bloglovin_count) && get_theme_mod('p3_social_footer_bloglovin', 1)) {
		$output .='<div '.$colz.'>';
		$output .= '<a href="'.esc_url($links['bloglovin']).'" target="_blank" rel="nofollow"><i class="fa fa-plus"></i> Bloglovin | '.$bloglovin_count.'</a>';
		$output .= '</div>';
		}
		
	}
		
	$output .= '</div>	
</div>
</div>
<style scoped>#instagramz{margin-top:0}</style>';
	
	echo $output;

}


// customiser
/*
if (!class_exists('pipdig_p3_social_footer_Customiser')) {
	class pipdig_p3_social_footer_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_social_footer_section', 
				array(
					'title' => __( 'Social Footer', 'p3' ),
					'description' => __( 'Use these options to disaplay social follow icons across the footer of your site. You can also enable/disable the display of social follow counters.', 'p3' ).' <a href="//support.pipdig.co/articles/wordpress-how-to-add-social-icons-to-the-footer/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'capability' => 'edit_theme_options',
					'priority' => 86,
				) 
			);

			$wp_customize->add_setting('social_count_footer',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'social_count_footer',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable social footer', 'pipdig-arubanights' ),
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('social_count_footer_counts',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'social_count_footer_counts',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display counter stats', 'pipdig-arubanights' ),
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_twitter',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_twitter',
				array(
					'type' => 'checkbox',
					'label' => 'Twitter',
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_facebook',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_facebook',
				array(
					'type' => 'checkbox',
					'label' => 'Facebook',
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_instagram',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_instagram',
				array(
					'type' => 'checkbox',
					'label' => 'Instagram',
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_youtube',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_youtube',
				array(
					'type' => 'checkbox',
					'label' => 'YouTube',
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_pinterest',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_pinterest',
				array(
					'type' => 'checkbox',
					'label' => 'Pinterest',
					'section' => 'p3_social_footer_section',
				)
			);
			
			$wp_customize->add_setting('p3_social_footer_bloglovin',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_social_footer_bloglovin',
				array(
					'type' => 'checkbox',
					'label' => 'Bloglovin',
					'section' => 'p3_social_footer_section',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_social_footer_Customiser' , 'register' ) );
}
*/
