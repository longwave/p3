<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_instagram_feed shape=""]
function pipdig_p3_instagram_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'shape' => '',
		'token' => '',
		//'comments' => 'yes',
	), $atts ) );
	
	//wp_enqueue_script( 'imagesloaded' ); // I know, I know :(
	wp_enqueue_script( 'masonry' );
	
	$output = '';
	
	$images = p3_instagram_fetch($token); // grab images
	
	if ($images) {
		$output .= '
		<style>
		.p3_instagram_feed_shortcode .p3_instagram_feed_shortcode_item {
			width: 23%;
			margin: 1%;
			line-height: 0;
			-moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out;
		}
		.p3_instagram_feed_shortcode .p3_instagram_feed_shortcode_item:hover {
			opacity: .7;
		}
		@media screen and (max-width: 769px) {
			.p3_instagram_feed_shortcode .p3_instagram_feed_shortcode_item {
				width: 48%;
			}
		}
		@media screen and (max-width: 400px) {
			.p3_instagram_feed_shortcode .p3_instagram_feed_shortcode_item {
				width: 100%;
				margin: 1% 0;
			}
		}
		</style>
		';
		$output .= '<div class="p3_instagram_feed_shortcode">';
			foreach ($images as $x) {
				$img = str_replace('/c0.134.1080.1080', '', $x['src']); // http://stackoverflow.com/questions/32260896/instagram-square-photos-api
				$output .= '<a href="'.esc_url($x['link']).'" target="_blank" title="'.esc_attr($x['caption']).'" class="p3_instagram_feed_shortcode_item">';
				if ($shape == 'original') {
					$output .= '<img src="'.esc_url($img).'" alt="" />';
				} else {
					$output .= '<div class="p3_cover_me" style="background-image:url('.esc_url($img).')"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_invisible" alt="" /></div>';
				}
				$output .= '</a>';
			}
		$output .= '</div>';
	}
	
	$output .= '
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js"></script>
	<script>
	jQuery(document).ready(function($) {
		$(".p3_instagram_feed_shortcode").imagesLoaded( function(){
			jQuery(".p3_instagram_feed_shortcode").masonry({
				itemSelector: ".p3_instagram_feed_shortcode_item",
			});
		});
	});
	</script>
	';
	
	return $output;
}
add_shortcode( 'pipdig_instagram_feed', 'pipdig_p3_instagram_shortcode' );