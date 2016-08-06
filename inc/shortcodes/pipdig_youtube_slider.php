<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// [pipdig_youtube_slider]
function pipdig_p3_youtube_slider_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'channel' => '',
		'number' => '6',
		'columns' => '3',
		'title' => '',
		'title_link' => '',
	), $atts));
	
	$output = $title_link_start = $title_link_end = '';
	if ($channel == '') {
		$output = 'No YouTube channel set in shortcode.';
	} else {
	
		wp_enqueue_script( 'pipdig-owl' );
		
		$videos = p3_youtube_fetch($channel); // grab videos
		
		if ($videos) {
			
			if ($title) {
				if ($title_link) {
					$title_link_start = '<a href="'.esc_url($title_link).'">';
					$title_link_end = '</a>';
				}
				$output .= '<h2 class="p3_youtube_slider_shortcode_title"><span>'.$title_link_start . esc_html($title) . $title_link_end.'</span></h2>';
			}
		
			$output .= '<div id="p3_youtube_slider_shortcode">';
			
			for ($x = 0; $x <= $number; $x++) {
				if (!empty($videos[$x]['thumbnail'])) {
					$output .= '<div class="p3_cover_me" style="background-image:url('.$videos[$x]['thumbnail'].');">';
						$output .= '<a href="'.$videos[$x]['link'].'" target="_blank" rel="nofollow">';
							$output .= '<img class="p3_invisible" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABQAAAALQAQMAAAD1s08VAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJRJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9eeMAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKsAxN8AAX2oznYAAAAASUVORK5CYII=" alt="'.$videos[$x]['title'].'"/>';
						$output .= '</a>';
					$output .= '</div>';
				}
			}
				
			$output .= '<script>
				jQuery(document).ready(function($) {
					$("#p3_youtube_slider_shortcode").owlCarousel({
						items: '.$columns.',
						slideSpeed: 500,
						pagination: false,
						rewindSpeed: 600,
						autoPlay: true,
						baseClass: "owl-carousel",
						theme: "owl-theme",
						lazyLoad: false,
					})
				});
			</script>
			
			</div>';
		}
	}

	return $output;
	
}
add_shortcode('pipdig_youtube_slider', 'pipdig_p3_youtube_slider_shortcode');