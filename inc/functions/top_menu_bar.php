<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

if (p3_theme_enabled(array('aquae', 'galvani', 'venture', 'arubanights', 'styleandlight', 'tundra', 'ghostshell', 'kensington', 'ladygreys', 'firefly', 'cultureshock', 'willow', 'hollyandweave', 'opulence', 'crystal'))) {
	return;
}


if (get_theme_mod('p3_top_bar_enable')) {

	register_nav_menus( array(
		'top_bar' => __( 'Top Menu Bar', 'p3' ),
	) );

	function pipdig_p3_top_menu_bar() {
		?>
		<div id="p3_top_menu_bar" class="site-top">
			<div class="clearfix container">
				<nav class="site-menu" role="navigation">
					<?php wp_nav_menu( array( 'container_class' => 'clearfix menu-bar', 'theme_location' => 'top_bar' ) ); ?>
				</nav>
			</div>
		</div>
	<?php
	}
	add_action('before','pipdig_p3_top_menu_bar');
	
}

// customiser
if (!class_exists('pipdig_top_menu_bar_Customize')) {
	class pipdig_top_menu_bar_Customize {
		public static function register ( $wp_customize ) {

			// Enable
			$wp_customize->add_setting('p3_top_bar_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_top_bar_enable',
				array(
					'type' => 'checkbox',
					'label' => __( 'Add an extra menu to the top', 'p3' ),
					'description' => __( 'Use this option to add an extra menu across the top of your site. ', 'p3' ).'<a href="//support.pipdig.co/articles/wordpress-how-to-add-an-extra-top-menu-navbar/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'section' => 'pipdig_layout',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_top_menu_bar_Customize' , 'register' ) );
}
