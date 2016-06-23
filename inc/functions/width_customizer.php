<?php 

if (!defined('ABSPATH')) {
	exit;
}


if (!function_exists('p3_width_customizer_styles')) {
	function p3_width_customizer_styles() {
		
		$main = intval(get_theme_mod( 'p3_width_customizer', 72));
		
		if ($main === 72) {
			return;
		}
		
		$side = 100 - $main;
		
		?>
		<!-- p3 width customizer START -->
		<style>
			.site-main .col-xs-8 {
				width: <?php echo $main; ?>%;
			}
			.site-main .col-xs-pull-8 {
				right: <?php echo $main; ?>%;
			}
			.site-main .col-xs-push-8 {
				left: <?php echo $main; ?>%;
			}
			.site-main .col-xs-offset-8 {
				margin-left: <?php echo $main; ?>%;
			}
			
			.site-main .col-xs-4 {
				width: <?php echo $side; ?>%;
			}
			.site-main .col-xs-pull-4 {
				right: <?php echo $side; ?>%;
			}
			.site-main .col-xs-push-4 {
				left: <?php echo $side; ?>%;
			}
			.site-main .col-xs-offset-4 {
				margin-left: <?php echo $side; ?>%;
			}
			
			
			
			@media (min-width: 768px) { 
			
				.site-main .col-sm-8 {
					width: <?php echo $main; ?>%;
				}
				.site-main .col-sm-pull-8 {
					right: <?php echo $main; ?>%;
				}
				.site-main .col-sm-push-8 {
					left: <?php echo $main; ?>%;
				}
				.site-main .col-sm-offset-8 {
					margin-left: <?php echo $main; ?>%;
				}
				
				.site-main .col-sm-4 {
					width: <?php echo $side; ?>%;
				}
				.site-main .col-sm-pull-4 {
					right: <?php echo $side; ?>%;
				}
				.site-main .col-sm-push-4 {
					left: <?php echo $side; ?>%;
				}
				.site-main .col-sm-offset-4 {
					margin-left: <?php echo $side; ?>%;
				}
				
			}
			
			@media (min-width: 992px) {
				.site-main .col-md-8 {
					width: <?php echo $main; ?>%;
				}
				.site-main .col-md-pull-8 {
					right: <?php echo $main; ?>%;
				}
				.site-main .col-md-push-8 {
					left: <?php echo $main; ?>%;
				}
				.site-main .col-md-offset-8 {
					margin-left: <?php echo $main; ?>%;
				}
				
				.site-main .col-md-4 {
					width: <?php echo $side; ?>%;
				}
				.site-main .col-md-pull-4 {
					right: <?php echo $side; ?>%;
				}
				.site-main .col-md-push-4 {
					left: <?php echo $side; ?>%;
				}
				.site-main .col-md-offset-4 {
					margin-left: <?php echo $side; ?>%;
				}
			}
			
			@media (min-width: 1200px) {
				.site-main .col-lg-8 {
					width: <?php echo $main; ?>%;
				}
				.site-main .col-lg-pull-8 {
					right: <?php echo $main; ?>%;
				}
				.site-main .col-lg-push-8 {
					left: <?php echo $main; ?>%;
				}
				.site-main .col-lg-offset-8 {
					margin-left: <?php echo $main; ?>%;
				}
				
				.site-main .col-lg-4 {
					width: <?php echo $side; ?>%;
				}
				.site-main .col-lg-pull-4 {
					right: <?php echo $side; ?>%;
				}
				.site-main .col-lg-push-4 {
					left: <?php echo $side; ?>%;
				}
				.site-main .col-lg-offset-4 {
					margin-left: <?php echo $side; ?>%;
				}
			}
			
		</style>
		<!-- p3 width customizer END -->
		<?php
	}
	add_action( 'wp_head', 'p3_width_customizer_styles', 999 );
}



// customiser
if (!class_exists('p3_width_customizer_Customize')) {
	class p3_width_customizer_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_setting('p3_width_customizer',
				array(
					'default' => 72,
					'sanitize_callback' => 'pipdig_strip',
				)
			);
			$wp_customize->add_control( 'p3_width_customizer', array(
				'type' => 'range',
				'section' => 'pipdig_layout',
				'label' => __( 'Main blog posts column width', 'p3' ),
				'input_attrs' => array(
					'min' => 60,
					'max' => 80,
					'step' => 1,
					),
				)
			);


		}
	}
	add_action( 'customize_register' , array( 'p3_width_customizer_Customize' , 'register' ) );
}
