<?php

if (!defined('ABSPATH')) {
	exit;
}
/*
function p3_pinterest_hover_add_data_tags($content) {
     $dom = new DOMDocument();
     @$dom->loadHTML($content);

     foreach ($dom->getElementsByTagName('img') as $node) {
         $node->setAttribute("data-original", 'poop' );
     }
     $newHtml = $dom->saveHtml();
     return $newHtml;
}
add_filter('the_content', 'p3_pinterest_hover_add_data_tags');
*/

if (!function_exists('p3_pinterest_hover')) {
	function p3_pinterest_hover() {
		
		
		
		?>
		<style>
		.imgPinWrap {
		  position: relative;
		  display: inline-block;
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
		  top:50%;
		}
		</style>
		<script>
		(function( $ ){
  $.fn.imgPin = function( options ) {


    // Extend our default options with those provided.
    // Note that the first argument to extend is an empty
    // object – this is to keep from overriding our "defaults" object.
    var defaults = {
      pinImg : 'https://assets.pinterest.com/images/pidgets/pin_it_button.png',
      position: 1, // Display default header
    };
    var options = $.extend( {}, defaults, options );

    var url = encodeURIComponent(document.URL),
        pinImg = options.pinImg,
        position = '';

    switch (options.position) {
      case 1:
        position = 'top left'; break;
      case 2:
        position = 'top right'; break;
      case 3:
        position = 'bottom right'; break;
      case 4:
        position = 'bottom left'; break;
      case 5:
        position = 'center'; break;
    }

    this.each(function(){ // add Pin buttons to all images
      var src = $(this).attr('src'),
          shareURL = url;

      // get image dimensions - if < 500 then return
      var img = new Image();
      img.src = src;

      // Get Title and img to pin - encode them
      var description = '<?php the_title(); ?>',
          imgURL = encodeURIComponent(src);

      // Generate link
      var link = 'https://www.pinterest.com/pin/create/button/';
          link += '?url='+shareURL;
          link += '&media='+imgURL;
          link += '&description='+description;

      //add wrappers
      $(this).wrap('<div class="imgPinWrap">').after('<a href="'+link+'" class="pin '+position+'"><img src="'+pinImg+'" alt="Pin this!"/></a>');

      //position center
      if (options.position == 5) {
        var img = new Image();
        img.onload = function() {
          var w = this.width;
          h = this.height;
          $('.imgPinWrap .pin.center').css('margin-left', -w/2).css('margin-top', -h/2);
        }
        img.src = pinImg;
      }


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
					'priority' => 74,
				) 
			);

			// Pinterest Hover
			$wp_customize->add_setting('pinterest_hover_image_active',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('pinterest_hover_image_active',
				array(
					'type' => 'checkbox',
					'label' => __('Enable this feature', 'p3'),
					'section' => 'pipdig_pinterest_hover',
				)
			);
			
			// Date range for related posts
			/*
			$wp_customize->add_setting('related_posts_date',
				array(
					'default' => '1 year ago',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control('related_posts_date',
				array(
					'type' => 'select',
					'label' => __('Date range for posts:', 'p3'),
					'section' => 'pipdig_pinterest_hover',
					'choices' => array(
						'1 year ago' => __('1 Year', 'p3'),
						'1 month ago' => __('1 Month', 'p3'),
						'1 week ago' => __('1 Week', 'p3'),
						'' => __('All Time', 'p3'),
					),
				)
			);
			*/

		}
	}
	add_action( 'customize_register' , array( 'pipdig_pinterest_hover_Customize' , 'register' ) );
}
