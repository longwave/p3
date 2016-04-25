<?php 

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('p3_full_screen_landing')) {
	function p3_full_screen_landing() {
		
		
		if (!get_theme_mod('p3_full_screen_landing_enable')) {
			return;
		}
		
		if (get_theme_mod('p3_full_screen_landing_home', 1) && (!is_front_page() && !is_home())) {
			return;
		}
		
		$title = sanitize_text_field(get_theme_mod('p3_full_screen_landing_title'));
		$summary = sanitize_text_field(get_theme_mod('p3_full_screen_landing_summary'));
		$link = esc_url(get_theme_mod('p3_full_screen_landing_link'));
		$color = sanitize_text_field(get_theme_mod('p3_full_screen_landing_text_color'));
		
		?>
		<style scoped>
			#p3_full_screen_landing {
				background-image: url(<?php echo esc_url(get_theme_mod('p3_full_screen_landing_image_file', 'https://i.imgur.com/dfg1HQN.jpg')); ?>);
				background-size: cover;
				position: relative;
				z-index: 99999999;
			}
			.p3_full_screen_landing_panel {
				position: absolute;
				top: 50%;
				text-align: center;
				width: 100%;
				color: <?php echo $color; ?>;
				font-size: 15px;
				-ms-transform: translate(0,-50%);
				-webkit-transform: translate(0,-50%);
				transform: translate(0,-50%);  
			}
			.p3_full_screen_landing_panel h1 {
				color: <?php echo $color; ?>;
			}
		</style>
		<div id="p3_full_screen_landing">
			<?php if (!empty($title)) { ?>
				<div class="p3_full_screen_landing_panel">
					<?php if (!empty($link)) { ?><a href="<?php echo $link; ?>"><?php } ?>
						<h1><?php echo $title; ?></h1>
					<?php if (!empty($link)) { ?></a><?php } ?>
					<?php if (!empty($summary)) { ?>
						<div><?php echo $summary; ?></div>
					<?php } ?>
					
					
				</div>
			<?php } ?>
		</div>
		<script>
		jQuery(document).ready(function($){

			// does the job
			function fullscreen(){
				jQuery('#p3_full_screen_landing').css({
					width: jQuery(window).width(),
					height: jQuery(window).height()
				});
			}
		  
			fullscreen();

			// run the function in case of window resize
			jQuery(window).resize(function() {
				fullscreen();       
			});
		});
		</script>

	<?php
	}
	add_action('before', 'p3_full_screen_landing', 1);
}





// customiser
if (!class_exists('p3_full_screen_landing_Customize')) {
	class p3_full_screen_landing_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_full_screen_landing', 
				array(
					'title' => __( 'Full Screen Landing', 'p3' ),
					'description'=> __( 'Use this option to display a single, full screen landing image at the top of your homepage.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 168,
				) 
			);
			
			// enable
			$wp_customize->add_setting('p3_full_screen_landing_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_enable',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable this feature', 'p3' ),
					'section' => 'p3_full_screen_landing',
				)
			);
			
			// homepage only?
			$wp_customize->add_setting('p3_full_screen_landing_home',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_home',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display on homepage only', 'p3' ),
					'section' => 'p3_full_screen_landing',
				)
			);
			
			// Image
			$wp_customize->add_setting('p3_full_screen_landing_image_file',
				array(
					'default' => 'https://i.imgur.com/dfg1HQN.jpg',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
					 new WP_Customize_Image_Control(
						 $wp_customize,
						 'p3_full_screen_landing_image_file',
						 array(
							 'label'			=> __( 'Upload a custom image', 'p3' ),
							 'section'		=> 'p3_full_screen_landing',
							 'settings'	 => 'p3_full_screen_landing_image_file',
						 )
					 )
			);
			
			// title
			$wp_customize->add_setting('p3_full_screen_landing_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_title',
				array(
					'type' => 'text',
					'label' => __( 'Title:', 'p3' ),
					'section' => 'p3_full_screen_landing',
					/*
					'input_attrs' => array(
						'placeholder' => __('You may also enjoy:', 'p3'),
					),
					*/
				)
			);
			
			// summary
			$wp_customize->add_setting('p3_full_screen_landing_summary',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_summary',
				array(
					'type' => 'text',
					'label' => __( 'Summary:', 'p3' ),
					'section' => 'p3_full_screen_landing',
				)
			);
			
			// link
			$wp_customize->add_setting('p3_full_screen_landing_link',
				array(
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_link',
				array(
					'type' => 'text',
					'label' => __( 'Link title to URL:', 'p3' ),
					'section' => 'p3_full_screen_landing',
					/*
					'input_attrs' => array(
						'placeholder' => __('You may also enjoy:', 'p3'),
					),
					*/
				)
			);
			
			
			// text color
			$wp_customize->add_setting('p3_full_screen_landing_text_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_full_screen_landing_text_color',
				array(
					'label' => __( 'Text color', 'pipdig-textdomain' ),
					'section' => 'p3_full_screen_landing',
					'settings' => 'p3_full_screen_landing_text_color',
				)
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'p3_full_screen_landing_Customize' , 'register' ) );
}
