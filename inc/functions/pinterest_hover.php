<?php

if (!defined('ABSPATH')) {
	exit;
}


function new_content($content) {
	
	if (get_theme_mod('p3_pinterest_hover_enable')) {
		$link = esc_url(get_the_permalink());
		$title = esc_attr(get_the_title());
		//$summary = esc_attr(get_the_excerpt());
		$content = str_replace('<img','<img data-p3-pin-title="'.$title.'" data-p3-pin-link="'.$link.'"', $content);
	}

	return $content;
}

add_filter('the_content','new_content');


if (!function_exists('p3_pinterest_hover')) {
	function p3_pinterest_hover() {
		if (!get_theme_mod('p3_pinterest_hover_enable')) {
			return;
		}
		?>
		<style>
		.imgPinWrap {
		  position: relative;
		  /* display: inline-block; commented out to stop images going over div */
		}

		.imgPinWrap .pin {
		  opacity: 0;
		  position: absolute;
		  display: block;
		  -webkit-transition:all .25s ease-in-out;
		  -moz-transition:all .25s ease-in-out;
		  -o-transition:all .25s ease-in-out;
		  transition:all .25s ease-in-out;
		}
		.imgPinWrap .pin img {
		  display: block;
		}
		.imgPinWrap .pin:hover {
		  box-shadow: 0 0 5px #fff;
		}

		.imgPinWrap:hover .pin {
		  opacity: 1;
		}

		.imgPinWrap .left { left: 15px; }
		.imgPinWrap .right { right: 15px; }
		.imgPinWrap .bottom { bottom: 15px; }
		.imgPinWrap .top { top: 15px; }
		.imgPinWrap .center {
		  left: 50%;
		  top: 50%;
		}
		</style>
		<script>
		(function( $ ){
  $.fn.imgPin = function( options ) {


    // Extend our default options with those provided.
    // Note that the first argument to extend is an empty
    // object – this is to keep from overriding our "defaults" object.
    var defaults = {
      pinImg : '<?php echo esc_url(get_theme_mod('p3_pinterest_hover_image_file', 'https://assets.pinterest.com/images/pidgets/pin_it_button.png')); ?>',
      position: 'center',
    };
    var options = $.extend( {}, defaults, options );

    var url = encodeURIComponent(document.URL),
        pinImg = options.pinImg,
        position = '';
	<?php $position = get_theme_mod('p3_pinterest_hover_image_position', 'center'); ?>

    this.each(function(){ // add Pin buttons to all images
      var src = $(this).attr('src'),
          shareURL = $(this).data('p3-pin-link');

      // get image dimensions - if < 500 then return
      var img = new Image();
      img.src = src;

      // Get Title and img to pin - encode them
      var description = $(this).data('p3-pin-title'),
          imgURL = encodeURIComponent(src);

      // Generate link
      var link = 'https://www.pinterest.com/pin/create/button/';
          link += '?url='+shareURL;
          link += '&media='+imgURL;
          link += '&description='+description;

      //add wrappers
      $(this).wrap('<div class="imgPinWrap">').after('<a href="'+link+'" class="pin <?php echo $position; ?>"><img src="'+pinImg+'" alt="<?php _e('Pin this image on Pinterest', 'p3'); ?>"/></a>');

      //position center
      <?php if ($position == 'center') { ?>
        var img = new Image();
        img.onload = function() {
          var w = this.width;
          h = this.height;
          $('.imgPinWrap .pin.center').css('margin-left', -w/2).css('margin-top', -h/2);
        }
        img.src = pinImg;
      <?php } ?>


      //set click events
      $('.imgPinWrap .pin').click(function(){
        var w = 700,
          h = 400;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var imgPinWindow = window.open(this.href,'imgPngWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=700, height=400');
        imgPinWindow.moveTo(left, top);
        return false;
      });

    });


  }


})( jQuery );


jQuery('.entry-content img').imgPin();

		</script>
		<?php
	}
	add_action('wp_footer', 'p3_pinterest_hover', 999);
}


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
			
			// Date range for related posts
			
			$wp_customize->add_setting('p3_pinterest_hover_image_position',
				array(
					'default' => 'center',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control('p3_pinterest_hover_image_position',
				array(
					'type' => 'select',
					'label' => __('Image position:', 'p3'),
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
			
			// Header image
			$wp_customize->add_setting('p3_pinterest_hover_image_file',
				array(
					'default' => 'https://assets.pinterest.com/images/pidgets/pin_it_button.png',
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				   new WP_Customize_Image_Control(
					   $wp_customize,
					   'p3_pinterest_hover_image_file',
					   array(
						   'label'      => __( 'Upload a header image', 'p3' ),
						   'section'    => 'pipdig_pinterest_hover',
						   'settings'   => 'p3_pinterest_hover_image_file',
					   )
				   )
			);
			

		}
	}
	add_action( 'customize_register' , array( 'pipdig_pinterest_hover_Customize' , 'register' ) );
}
