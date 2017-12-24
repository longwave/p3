<?php 

if (!defined('ABSPATH')) die;

if (p3_theme_enabled(array('opulence', 'blossom', 'maryline'))) {
	return;
}

function p3_header_customizer_styles() {
	if (!get_theme_mod( 'p3_header_section_width')) {
		return;
	}
	?>
	<!-- p3 header customizer START -->
	<style>
		.site-header .container {
			max-width: 100%;
			padding-left: 0;
			padding-right: 0;
		}
	</style>
	<!-- p3 header customizer END -->
	<?php
}
add_action( 'wp_head', 'p3_header_customizer_styles', 999 );



// customiser
class p3_header_customizer_Customize {
	
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_setting('p3_header_section_width',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control( 'p3_header_section_width', array(
			'type' => 'checkbox',
			'section' => 'pipdig_header',
			'priority' => 15,
			'label' => 'Allow image to span 100% width of the screen',
			'description' => 'Note: if you would like the image to touch the edges of the screen, you may need to upload a large image (e.g. 2048px wide). If you see space to the left/right of the image, this is because the image is too small.',
			)
		);
	}
}
add_action( 'customize_register' , array( 'p3_header_customizer_Customize' , 'register' ) );