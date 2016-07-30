<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('p3_popup_modal')) {
	function p3_popup_modal() {
		
		if (!get_theme_mod('p3_popup_enable')) {
			return;
		}
		
		$img = esc_url(get_theme_mod('p3_popup_image'));
		$link = esc_url(get_theme_mod('p3_popup_link', 'https://twitter.com/pipdig'));
		
		if (!$img || !$link) {
			return;
		}
		
		?>
		
		<div id="p3_modal">
			<a href="<?php echo $link; ?>" target="_blank" rel="nofollow"><img src="<?php echo $img; ?>" alt="" width="400" /></a>
		</div>
		
		
		<style>
			#p3_modal {
				position: fixed;
				height: 100%;
				width: 100%;
				text-align: center;
				left: 0;
				top: 0;
				z-index: 999999;
				background: rgba(255,255,255,.95);
			}
			#p3_modal img {
				margin-top: 100px;
				box-shadow: 0 0 20px rgba(0,0,0, .35);
			}
			#p3_modal {display: none;}
		</style>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.11/ouibounce.min.js"></script>
		<script>
		jQuery(document).ready(function($) {
			
			//if (document.documentElement.clientWidth > 719 ) { // not on mobiles
				
				<?php if (is_front_page() || is_home()) { // show popup automatically on homepage and blog page ?>
				
				// show popup after 6 secs
				setTimeout(function() {
					$('#p3_modal').fadeIn('fast');
				}, 6000);
				
				<?php } ?>
				
				// activate viewport modal
				ouibounce(document.getElementById('p3_modal'), { aggressive: true, sensitivity: 90 });
				
				// click anywhere to hide
				$("#p3_modal").click(function(){
					$("#p3_modal").fadeOut(400);
				}).children().click(function(e) {
					return false;
				});
			
			//}
			
		});
		</script>
		
		<?php
	}
	add_action('wp_footer', 'p3_popup_modal', 999);
}


// customiser
if (!class_exists('pipdig_popup_Customize')) {
	class pipdig_popup_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_p3_popup', 
				array(
					'title' => __( 'Popup Modal', 'p3' ),
					'description'=> __( 'When you hover your mouse over an image in a post/page, a Pinterest "Pin it" button will appear.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 64,
				) 
			);

			// popup
			$wp_customize->add_setting('p3_popup_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_popup_enable',
				array(
					'type' => 'checkbox',
					'label' => __('Enable this feature', 'p3'),
					'section' => 'pipdig_p3_popup',
				)
			);
			
			// Image
			$wp_customize->add_setting('p3_popup_image',
				array(
					'default' => 'https://twitter.com/pipdig',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
					 new WP_Customize_Image_Control(
						 $wp_customize,
						 'p3_popup_image',
						 array(
							 'label' => __( 'Popup image', 'p3' ),
							 'section' => 'pipdig_p3_popup',
							 'settings' => 'p3_popup_image',
						 )
					 )
			);

			
			$wp_customize->add_setting('p3_popup_link',
				array(
					'default' => 'https://twitter.com/pipdig',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				'p3_popup_link',
				array(
					'type' => 'url',
					'label' => __( 'URL the popup should link to', 'p3' ),
					'section' => 'pipdig_p3_popup'
				)
			);


		}
	}
	add_action( 'customize_register' , array( 'pipdig_popup_Customize' , 'register' ) );
}
