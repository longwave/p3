<?php 

if (!defined('ABSPATH')) die;

if (p3_theme_enabled(array('blossom'))) { // doesn't play nice with search feature
	return;
}

function p3_full_screen_landing_cookie() {
	
	if (!get_theme_mod('p3_full_screen_landing_enable')) {
		return;
	}
	if (get_theme_mod('p3_full_screen_landing_home', 1) && (!is_front_page() && !is_home())) {
		return;
	}
	
	if (get_theme_mod('p3_full_screen_landing_cookie') && !is_customize_preview()) {
		
		?>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js'></script>
		<script>
			jQuery(document).ready(function($) {
				
				if ($.cookie('p3_full_screen_landing')) {
					$('#p3_full_screen_landing').hide();
				}
				window.setInterval(function(){
					if ($.cookie('p3_full_screen_landing')) {
						$('#p3_full_screen_landing').hide();
					}
				}, 1000);

				$(window).scroll(function(){
					var e=0;
					var t=false;
					var n=$(window).scrollTop();
					if ($(".site-main").offset().top<n){
						$.cookie('p3_full_screen_landing', '1', { expires: 1 });
					}
				});
				
			});
		</script>
	<?php
	}
}
add_action( 'wp_footer', 'p3_full_screen_landing_cookie', 9999 );


if (!function_exists('p3_full_screen_landing')) {
	function p3_full_screen_landing() {
		
		if (!get_theme_mod('p3_full_screen_landing_enable')) {
			return;
		}
		
		if (get_theme_mod('p3_full_screen_landing_home', 1) && (!is_front_page() && !is_home())) {
			return;
		}

		$title = pipdig_strip(get_theme_mod('p3_full_screen_landing_title'));
		$summary = pipdig_strip(get_theme_mod('p3_full_screen_landing_summary'));
		$link = esc_url(get_theme_mod('p3_full_screen_landing_link'));
		$color = pipdig_strip(get_theme_mod('p3_full_screen_landing_text_color'));
		
		$scroll_text = __('Scroll down','p3');
		if (get_theme_mod('p3_full_screen_landing_scroll_text')) {
			$scroll_text = pipdig_strip(get_theme_mod('p3_full_screen_landing_scroll_text'));
		}
		$scroll_color = pipdig_strip(get_theme_mod('p3_full_screen_landing_scroll_color'));
		
		
		?>

		<style scoped>
			#p3_full_screen_landing {
				background-image: url(<?php echo esc_url(get_theme_mod('p3_full_screen_landing_image_file', 'https://i.imgur.com/dfg1HQN.jpg')); ?>);
				background-size: cover;
				background-repeat: no-repeat;
				background-position: center;
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
			.p3_full_screen_landing_panel_scroll {
				position: absolute;
				bottom: 50px;
				left: 0;
				width: 100%;
				text-align: center;
				font-size: 30px;
				line-height: 1;
				color: <?php echo $scroll_color; ?>;
			}
			.p3_full_screen_landing_panel_scroll .fa {
				display: block;
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
			<?php if (get_theme_mod('p3_full_screen_landing_scroll')) { ?>
				<div class="p3_full_screen_landing_panel_scroll"><i class="fa fa-chevron-down"></i><?php echo $scroll_text; ?></div>
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
					'priority' => 37,
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
			
			// cookie?
			$wp_customize->add_setting('p3_full_screen_landing_cookie',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_cookie',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display once per day', 'p3' ),
					'description' => __( 'The landing image will only appear once per person every 24 hours.', 'p3' ),
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
					'label' => __( 'Text color', 'p3' ),
					'section' => 'p3_full_screen_landing',
					'settings' => 'p3_full_screen_landing_text_color',
				)
				)
			);
			
			// scroll down button
			$wp_customize->add_setting('p3_full_screen_landing_scroll',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_scroll',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display "Scroll down" text at the bottom', 'p3' ),
					'section' => 'p3_full_screen_landing',
				)
			);
			
			// scroll down text
			$wp_customize->add_setting('p3_full_screen_landing_scroll_text',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_full_screen_landing_scroll_text',
				array(
					'type' => 'text',
					'label' => __( '"Scroll down" text:', 'p3' ),
					'section' => 'p3_full_screen_landing',
					'input_attrs' => array(
						'placeholder' => __('Scroll down', 'p3'),
					),
				)
			);
			
			// scroll color
			$wp_customize->add_setting('p3_full_screen_landing_scroll_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_full_screen_landing_scroll_color',
				array(
					'label' => __( 'Text color', 'p3' ),
					'section' => 'p3_full_screen_landing',
					'settings' => 'p3_full_screen_landing_scroll_color',
				)
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'p3_full_screen_landing_Customize' , 'register' ) );
}
