<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('p3_pinterest_hover_add_data') && get_theme_mod('p3_pinterest_hover_enable')) {
	function p3_pinterest_hover_add_data($content) {
		
		$link = esc_url(get_the_permalink());
		$title = rawurldecode(get_the_title());
		$content = str_replace('<img','<img data-p3-pin-title="'.$title.'" data-p3-pin-link="'.$link.'"', $content);
		return $content;
		
	}
	add_filter('the_content','p3_pinterest_hover_add_data');
}

if (!function_exists('p3_pinterest_hover')) {
	function p3_pinterest_hover() {
		
		if (!get_theme_mod('p3_pinterest_hover_enable') || is_singular('jetpack-portfolio')) {
			return;
		}
		
		$margin = intval(get_theme_mod('p3_pinterest_hover_margin', 0));

		?>

	<script type="text/javascript">	
		
		(function( $ ) {
			$.fn.pinterest = function(options) {
				
				var settings = $.extend( {
					'button' : 'http://business.pinterest.com/assets/img/builder/builder_opt_1.png'
				}, options);
				
				function getUrl(src){
					var url = document.location.toString();
					var http = /^https?:\/\//i;
					if (!http.test(src)) {
						if(src[0] == '/'){
							url = url.substring(0, url.lastIndexOf('/')) + src;
						} else {
							url = url.substring(0, url.lastIndexOf('/')) + '/' + src;
						}
					} else {
						url = src;
					}
					
					return url;
				};
				
				function on_click () {
					img = $(this).siblings('img:first');
					description = img.attr('title');
					url = document.location;
					media = getUrl( img.attr('src') );
	
					var pin_url = 'http://pinterest.com/pin/create/button/?url=' + url +
						'&media=' + media +
						'&description=' + description;
					
					window.open(pin_url, 'Pin - ' + description, 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
					$(this).hide(1000);
				};
				
				function on_hover_in() {
					$(this).siblings('img:first').show(500);
				};
					
				return this.each(function() {    
					img = $(this);
					img.wrap('<span class="p3_pin_wrapper" />');
					img.parent('span.p3_pin_wrapper').append('<img src="' + settings.button + '" class="p3_pin_img" />');
					img.hover(on_hover_in);
					img.siblings('img:first').on('click', on_click);
				});

			};
		})( jQuery );
		
		jQuery(document).ready(function($) {
			$('.entry-content img').pinterest({ button: '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png'});
		});
		
	</script>	
		<?php
	}
	add_action('wp_footer', 'p3_pinterest_hover', 999);
}


// stop image from being 100% width of tab in cust
function p3_pinterest_hover_customizer_styles() { ?>
		<style>
			#customize-control-p3_pinterest_hover_image_file img {width: auto;}
		</style>
		<?php
}
add_action( 'customize_controls_print_styles', 'p3_pinterest_hover_customizer_styles', 999 );


// customiser
if (!class_exists('pipdig_pinterest_hover_Customize')) {
	class pipdig_pinterest_hover_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_pinterest_hover', 
				array(
					'title' => __( 'Pinterest Hover Button', 'p3' ),
					'description'=> __( 'When you hover your mouse over an image in a post/page, a Pinterest "Pin it" button will appear.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 64,
				) 
			);

			// Pinterest Hover
			$wp_customize->add_setting('p3_pinterest_hover_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_enable',
				array(
					'type' => 'checkbox',
					'label' => __('Enable this feature', 'p3'),
					'section' => 'pipdig_pinterest_hover',
				)
			);
			
			// Image
			$wp_customize->add_setting('p3_pinterest_hover_image_file',
				array(
					//'default' => 'https://assets.pinterest.com/images/pidgets/pin_it_button.png',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
					 new WP_Customize_Image_Control(
						 $wp_customize,
						 'p3_pinterest_hover_image_file',
						 array(
							 'label'			=> __( 'Upload a custom image', 'p3' ),
							 'section'		=> 'pipdig_pinterest_hover',
							 'settings'	 => 'p3_pinterest_hover_image_file',
						 )
					 )
			);
			
			// Position			
			$wp_customize->add_setting('p3_pinterest_hover_image_position',
				array(
					'default' => 'center',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_image_position',
				array(
					'type' => 'select',
					'label' => __('Image position', 'p3'),
					'section' => 'pipdig_pinterest_hover',
					'choices' => array(
						'center' => __('Center', 'p3'),
						'top left' => __('Top left', 'p3'),
						'top right' => __('Top right', 'p3'),
						'bottom right' => __('Bottom right', 'p3'),
						'bottom left' => __('Bottom left', 'p3'),
					),
				)
			);
			
			// Image margin top
			$wp_customize->add_setting( 'p3_pinterest_hover_margin', array(
				'default' => 0,
				'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control( 'p3_pinterest_hover_margin', array(
				'type' => 'number',
				'section' => 'pipdig_pinterest_hover',
				'label' => __( 'Image margin', 'p3' ),
				'input_attrs' => array(
					'min' => 0,
					'max' => 150,
					'step' => 1,
					),
				)
			);
			
			$wp_customize->add_setting('p3_pinterest_hover_prefix_text',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_pinterest_hover_prefix_text',
				array(
					'type' => 'text',
					'label' => __( 'Prefix for "Description" field', 'p3' ),
					'section' => 'pipdig_pinterest_hover'
				)
			);


		}
	}
	add_action( 'customize_register' , array( 'pipdig_pinterest_hover_Customize' , 'register' ) );
}
