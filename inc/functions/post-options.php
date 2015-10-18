<?php

if (!defined('ABSPATH')) {
	exit;
}

function p3_display_featured_image_in_post() {
	if (get_the_post_thumbnail() != '' && get_theme_mod('display_featured_image')) { // if thumbnail is set in post
	echo '<div style="text-align:center">';
		the_post_thumbnail();
	echo '</div>';
}

}
add_action('p3_content_start', 'p3_display_featured_image_in_post');



// customiser
if (!class_exists('pipdig_p3_post_options_Customiser')) {
	class pipdig_p3_post_options_Customiser {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_posts', 
				array(
					'title' => __( 'Blog Post Options', 'p3' ),
					'priority' => 70,
					'capability' => 'edit_theme_options',
				) 
			);
			
			// add featurd image to post
			$wp_customize->add_setting('display_featured_image',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'display_featured_image',
				array(
					'type' => 'checkbox',
					'label' => __( 'Add Featured Image to content', 'p3' ),
					'description' => __( 'Select this option to display the selected Featured Image at the top of the post.', 'p3' ),
					'section' => 'pipdig_posts',
				)
			);
			/*
			// Signature image
			$wp_customize->add_setting('post_signature_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'signature_image',
					array(
						'label' => __( 'Post signature image', 'p3' ),
						'description' => __( 'This image will be shown in the footer of your posts', 'p3' ),
						'section' => 'pipdig_posts',
						'settings' => 'post_signature_image',
					)
				)
			);
			*/

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_post_options_Customiser' , 'register' ) );
}
