<?php

if (!defined('ABSPATH')) die;

function p3_pinterest_hover_add_data($content) {
	
	$active = false;

	if ( (is_singular('post') && get_theme_mod('p3_pinterest_hover_enable_posts')) ) {
		$active = true;
	} elseif ( (is_page() && get_theme_mod('p3_pinterest_hover_enable_page')) ) {
		$active = true;
	} elseif ( ((is_home() || is_archive() || is_search()) && get_theme_mod('p3_pinterest_hover_enable_archives')) ) {
		$active = true;
	}
	
	if ($active) {
		$link = esc_url(get_the_permalink());
		$title = rawurldecode(get_the_title());
		$content = str_replace('<img','<img data-p3-pin-title="'.$title.'" data-p3-pin-link="'.$link.'"', $content);
	}
	
	return $content;
	
}
add_filter('the_content','p3_pinterest_hover_add_data');


function p3_pinterest_hover() {
		
	if (get_theme_mod('p3_pinterest_hover_enable')) {
		set_theme_mod('p3_pinterest_hover_enable_posts', 1);
		//set_theme_mod('p3_pinterest_hover_enable_archives', 1);
		//set_theme_mod('p3_pinterest_hover_enable_pages', 1);
		remove_theme_mod('p3_pinterest_hover_enable');
	}
	
	$active = false;

	if ( (is_singular('post') && get_theme_mod('p3_pinterest_hover_enable_posts')) ) {
		$active = true;
	} elseif ( (is_page() && get_theme_mod('p3_pinterest_hover_enable_page')) ) {
		$active = true;
	} elseif ( ((is_home() || is_archive() || is_search()) && get_theme_mod('p3_pinterest_hover_enable_archives')) ) {
		$active = true;
	}
	
	if (!$active) {
		return;
	}
	
	$margin = absint(get_theme_mod('p3_pinterest_hover_margin', 0));
	$position = esc_attr(get_theme_mod('p3_pinterest_hover_image_position', 'center'));
	$pin_img = esc_url(get_theme_mod('p3_pinterest_hover_image_file', 'https://assets.pinterest.com/images/pidgets/pin_it_button.png'));
	if (strlen($pin_img) < 5) {
		$pin_img = 'https://assets.pinterest.com/images/pidgets/pin_it_button.png';
	}
	$dec_prefix = '';
	if (get_theme_mod('p3_pinterest_hover_prefix_text')) {
		$dec_prefix = '%20'.esc_attr(get_theme_mod('p3_pinterest_hover_prefix_text'));
	}
	
	?>
	<style>
	.p3_pin_wrapper .left {left:<?php echo $margin; ?>px}
	.p3_pin_wrapper .right {right:<?php echo $margin; ?>px}
	.p3_pin_wrapper .bottom {bottom:<?php echo $margin; ?>px}
	.p3_pin_wrapper .top {top:<?php echo $margin; ?>px}
	</style>
	<script>
	(function($){
		$.fn.imgPin = function( options ) {
				var defaults = {
				pinImg : '<?php echo $pin_img; ?>',
				position: 'center',
			};
			var options = $.extend( {}, defaults, options );
				var url = encodeURIComponent(document.URL),
				pinImg = options.pinImg,
				position = '';
				this.each(function(){
				
				if ($(this).hasClass('p3_invisible')) {
					var src = $(this).data('p3-pin-img-src');
				} else {
					var src = $(this).attr('src');
				}
					
				var shareURL = $(this).data('p3-pin-link');
				// if data attribute not found
				if (typeof shareURL == 'undefined') {
					shareURL = window.location.href;
				}
				// account for floats
				var pin_positon = '';
				if ($(this).hasClass('alignleft')) {
					var pin_positon = 'pin_align_left';
				} else if ($(this).hasClass('alignright')) {
					var pin_positon = 'pin_align_right';
				} else if ($(this).hasClass('aligncenter')) {
					var pin_positon = 'pin_align_center';
				}
				
				var img = new Image();
				img.src = src;
				
				var description = $(this).data('p3-pin-title'),
				imgURL = encodeURIComponent(src);
					
				if (description == null){
					var description = $(this).attr("alt");
					if (description == null){
						var description = '<?php echo esc_attr(get_the_title()); ?>';
					}
				}

				var link = 'https://www.pinterest.com/pin/create/button/';
					link += '?url='+shareURL;
					link += '&media='+imgURL;
					link += '&description=<?php echo addslashes($dec_prefix).' '; ?>'+description;
					$(this).wrap('<div class="p3_pin_wrapper_outer '+pin_positon+'"><div class="p3_pin_wrapper">').after('<a href="'+link+'" class="pin <?php echo $position; ?>"><img src="'+pinImg+'" alt="<?php _e('Pin this image on Pinterest', 'p3'); ?>"/></a>');

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
	jQuery('.entry-content img:not(.wp-smiley, .nopin, .nopin img), .entry-summary img:not(.pipdig_p3_related_posts img)').imgPin();

	</script>
	<?php
}
add_action('wp_footer', 'p3_pinterest_hover', 999);


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
					'description'=> __( 'When you hover your mouse over an image in a post/page, a Pinterest "Pin it" button will appear.', 'p3' ). ' You can download some of our custom Pinterest Hover Images on <a href="https://www.dropbox.com/sh/k8myt2vd8lgoz6a/AAD4w2WGe99Nr9wXpJl5T-TQa?dl=0" target="_blank">this page</a>',
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 64,
				) 
			);

			// show on posts
			$wp_customize->add_setting('p3_pinterest_hover_enable_posts',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_enable_posts',
				array(
					'type' => 'checkbox',
					'label' => __('Display on posts', 'p3'),
					'section' => 'pipdig_pinterest_hover',
				)
			);
			
			// show on pages
			$wp_customize->add_setting('p3_pinterest_hover_enable_pages',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_enable_pages',
				array(
					'type' => 'checkbox',
					'label' => __('Display on pages', 'p3'),
					'section' => 'pipdig_pinterest_hover',
				)
			);
			
			// show on archives
			$wp_customize->add_setting('p3_pinterest_hover_enable_archives',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_enable_archives',
				array(
					'type' => 'checkbox',
					'label' => __('Display on categories/archives', 'p3'),
					'section' => 'pipdig_pinterest_hover',
				)
			);
			
			$pin_img = get_theme_mod('p3_pinterest_hover_image_file','https://assets.pinterest.com/images/pidgets/pin_it_button.png');
			
			// Image
			$wp_customize->add_setting('p3_pinterest_hover_image_file',
				array(
					'default' => $pin_img,
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
					 new WP_Customize_Image_Control(
						 $wp_customize,
						 'p3_pinterest_hover_image_file',
						 array(
							 'label' => __( 'Upload a custom image', 'p3' ),
							 'section' => 'pipdig_pinterest_hover',
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
			
			// preix description text
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
