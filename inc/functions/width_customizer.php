<?php 

if (!defined('ABSPATH')) die;


function p3_width_customizer_styles() {
	
	$main = intval(get_theme_mod( 'p3_width_customizer', 72));
	
	if ($main === 72) {
		return;
	}
	
	$side = 100 - $main;
	
	?>
	
	<!-- p3 width customizer START -->
	<style>
	.site-main .row > .col-xs-8 {
		width: <?php echo $main; ?>%;
	}
	.site-main .row > .col-xs-pull-8 {
		right: <?php echo $main; ?>%;
	}
	.site-main .row > .col-xs-push-8 {
		left: <?php echo $main; ?>%;
	}
	.site-main .row > .col-xs-offset-8 {
		margin-left: <?php echo $main; ?>%;
	}
		
	.site-main .row > .col-xs-4:not(.p3_featured_panel):not(.p3_featured_cat) {
		width: <?php echo $side; ?>%;
	}
	.site-main .row > .col-xs-pull-4:not(.p3_featured_panel):not(.p3_featured_cat) {
		right: <?php echo $side; ?>%;
	}
	.site-main .row > .col-xs-push-4:not(.p3_featured_panel):not(.p3_featured_cat) {
		left: <?php echo $side; ?>%;
	}
	.site-main .row > .col-xs-offset-4:not(.p3_featured_panel):not(.p3_featured_cat) {
		margin-left: <?php echo $side; ?>%;
	}
		
		
		
	@media (min-width: 768px) { 
		.site-main .row > .col-sm-8 {
			width: <?php echo $main; ?>%;
		}
		.site-main .row > .col-sm-pull-8 {
			right: <?php echo $main; ?>%;
		}
		.site-main .row > .col-sm-push-8 {
			left: <?php echo $main; ?>%;
		}
		.site-main .row > .col-sm-offset-8 {
			margin-left: <?php echo $main; ?>%;
		}
		
		.site-main .row > .col-sm-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			width: <?php echo $side; ?>%;
		}
		.site-main .row > .col-sm-pull-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			right: <?php echo $side; ?>%;
		}
		.site-main .row > .col-sm-push-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			left: <?php echo $side; ?>%;
		}
		.site-main .row > .col-sm-offset-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			margin-left: <?php echo $side; ?>%;
		}
	}
		
	@media (min-width: 992px) {
		.site-main .row > .col-md-8 {
			width: <?php echo $main; ?>%;
		}
		.site-main .row > .col-md-pull-8 {
			right: <?php echo $main; ?>%;
		}
		.site-main .row > .col-md-push-8 {
			left: <?php echo $main; ?>%;
		}
		.site-main .row > .col-md-offset-8 {
			margin-left: <?php echo $main; ?>%;
		}
		
		.site-main .row > .col-md-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			width: <?php echo $side; ?>%;
		}
		.site-main .row > .col-md-pull-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			right: <?php echo $side; ?>%;
		}
		.site-main .row > .col-md-push-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			left: <?php echo $side; ?>%;
		}
		.site-main .row > .col-md-offset-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			margin-left: <?php echo $side; ?>%;
		}
	}
		
	@media (min-width: 1200px) {
		.site-main .row > .col-lg-8 {
			width: <?php echo $main; ?>%;
		}
		.site-main .row > .col-lg-pull-8 {
			right: <?php echo $main; ?>%;
		}
		.site-main .row > .col-lg-push-8 {
			left: <?php echo $main; ?>%;
		}
		.site-main .row > .col-lg-offset-8 {
			margin-left: <?php echo $main; ?>%;
		}
		
		.site-main .row > .col-lg-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			width: <?php echo $side; ?>%;
		}
		.site-main .row > .col-lg-pull-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			right: <?php echo $side; ?>%;
		}
		.site-main .row > .col-lg-push-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			left: <?php echo $side; ?>%;
		}
		.site-main .row > .col-lg-offset-4:not(.p3_featured_panel):not(.p3_featured_cat) {
			margin-left: <?php echo $side; ?>%;
		}
	}
	</style>
	<!-- p3 width customizer END -->
	
	<?php
}
add_action( 'wp_head', 'p3_width_customizer_styles', 999 );



// customiser
class p3_width_customizer_Customize {
	
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_setting('p3_width_customizer',
			array(
				'default' => 72,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control( 'p3_width_customizer', array(
			'type' => 'range',
			'section' => 'pipdig_layout',
			'priority' => 11,
			'label' => __( 'Blog post width compared to sidebar', 'p3' ),
			'input_attrs' => array(
				'min' => 60,
				'max' => 80,
				'step' => 1,
			),
		)
		);
	}
}
add_action('customize_register', array('p3_width_customizer_Customize', 'register'));