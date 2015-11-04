<?php 

if (!defined('ABSPATH')) {
	exit;
}
$theme = get_option('pipdig_theme');
if (($theme == 'aquae') || ($theme == 'venture') || ($theme == 'arubanights') || ($theme == 'styleandlight') || ($theme == 'tundra') || ($theme == 'ghostshell') || ($theme == 'kensington') || ($theme == 'ladygreys') || ($theme == 'firefly') || ($theme == 'cultureshock')) {
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
	class pipdig_related_Customize {
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
					'description' => __( 'Use this option to add an extra menu across the top of your site. ', 'p3' ).'<a href="https://goo.gl/wp9FYY" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'section' => 'pipdig_layout',
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_related_Customize' , 'register' ) );
}
