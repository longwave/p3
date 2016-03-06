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
		<style>
		.p3_pin_wrapper .left {left:<?php echo intval($margin); ?>px}
		.p3_pin_wrapper .right {right:<?php echo intval($margin); ?>px}
		.p3_pin_wrapper .bottom {bottom:<?php echo intval($margin); ?>px}
		.p3_pin_wrapper .top {top:<?php echo intval($margin); ?>px}
		</style>
		<script>
		(function( $ ){
			$.fn.imgPin = function( options ) {

			var defaults = {
				pinImg : '<?php echo esc_url(get_theme_mod('p3_pinterest_hover_image_file', 'https://assets.pinterest.com/images/pidgets/pin_it_button.png')); ?>',
				position: 'center',
			};
			var options = $.extend( {}, defaults, options );

			var url = encodeURIComponent(document.URL),
				pinImg = options.pinImg,
				position = '';
			<?php $position = strip_tags(get_theme_mod('p3_pinterest_hover_image_position', 'center')); ?>

			this.each(function(){
				var src = $(this).attr('src'),
					shareURL = $(this).data('p3-pin-link');

				// get image dimensions - if < 500 then return
				var img = new Image();
				img.src = src;

				var description = $(this).data('p3-pin-title'),
					imgURL = encodeURIComponent(src);

				var link = 'https://www.pinterest.com/pin/create/button/';
					link += '?url='+shareURL;
					link += '&media='+imgURL;
					link += '&description=<?php echo addslashes(get_theme_mod('p3_pinterest_hover_prefix_text', '')); ?>%20'+description;

				$(this).wrap('<div class="p3_pin_wrapper_outer"><div class="p3_pin_wrapper">').after('<a href="'+link+'" class="pin <?php echo $position; ?>"><img src="'+pinImg+'" alt="<?php _e('Pin this image on Pinterest', 'p3'); ?>"/></a>');

				<?php if ($position == 'center') { ?>
				var img = new Image();
				img.onload = function() {
					var w = this.width;
					h = this.height;
					$('.p3_pin_wrapper .pin.center').css('margin-left', -w/2).css('margin-top', -h/2);
				}
				img.src = pinImg;
				<?php } ?>


				//set click events
				$('.p3_pin_wrapper .pin').click(function(){
				var w = 700, h = 400;
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				var imgPinWindow = window.open(this.href,'imgPngWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=700, height=400');
				imgPinWindow.moveTo(left, top);
				return false;
				});

			});

			}
			
		})(jQuery);

		jQuery('.entry-content p img:not(.wp-smiley), .entry-content .alignnone, .wp-post-image, .entry-content .separator img').imgPin();

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
