<?php 

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_p3_favicon() {
	$output = '';
	$favicon = esc_url(get_theme_mod('pipdig_favicon'));
	if($favicon) {
		$output = '<link rel="shortcut icon" href="'.$favicon.'" />';
	}
	echo $output;
}
add_action('wp_head','pipdig_p3_favicon', 2);


// customiser
if (!class_exists('pipdig_p3_favicon_Customize')) {
	class pipdig_p3_favicon_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_favicon_section' , array(
					'title'      => __( 'Favicon', 'p3' ),
					'description'=> __( 'Add a Favicon to your site. This is the icon that is displayed in your browser tabs. <a href="http://www.favicon.co.uk/whatisfavicon.php" target="_blank">Click here</a> for more information. The icon should be no larger than 32 x 32 pixels in size.', 'p3' ),
				)
			);

			$wp_customize->add_setting('pipdig_favicon',
				array(
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'upload_favicon',
					array(
						'label'      => __( 'Upload a Favicon', 'pipdig-arubanights' ),
						'section'    => 'pipdig_favicon_section',
						'settings'   => 'pipdig_favicon',
					)
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_favicon_Customize' , 'register' ) );
}
