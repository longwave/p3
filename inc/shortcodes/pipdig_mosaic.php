<?php 

if (!defined('ABSPATH')) die;

// [pipdig_mosaic number="30" columns="3" category="slug"]
function pipdig_p3_mosaic_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'number' => '30',
		'columns' => '3',
		'category' => '',
		'type' => 'post',
		'layout' => '',
		'style' => '1',
		'show_date' => '1',
		'show_comments' => '1'
	), $atts ) );
	
	wp_enqueue_script( 'pipdig-imagesloaded' );
	wp_enqueue_script( 'pipdig-masonry' );
	
	$percent = '47';
	
	switch ($columns) {
		case '5':
			$percent = '18';
		break;
		case '4':
			$percent = '23';
		break;
		case '3':
			$percent = '31';
		break;
		case '2':
			$percent = '47';
		break;
	}
	
	// http://wordpress.stackexchange.com/questions/119294/pass-boolean-value-in-shortcode
	$show_date = filter_var( $show_date, FILTER_VALIDATE_BOOLEAN );
	$show_comments = filter_var( $show_comments, FILTER_VALIDATE_BOOLEAN );
	
	$output = '';
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	// use $paged = (get_query_var('page')) ? get_query_var('page') : 1; if this feature is ona  static homepage https://wordpress.org/support/topic/get_query_varpaged-doesnt-seem-to-work-on-page-templates
	
	$query = new WP_Query( array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $number,
		'category_name' => $category,
		'ignore_sticky_posts' => true,
		'pagination' => true,
		'paged' => $paged,
		)
	);
	
	if ( $query->have_posts() ) {
		
	$output .= '<div class="grid p3_grid_mosaic">';

				while ( $query->have_posts() ) : $query->the_post();
					$img = p3_catch_image(get_the_ID(), 'p3_medium');
					$link = get_the_permalink();
					$comment_count = get_comments_number();
					if ($comment_count == 0) {
						$comments_out = '';
					} else {
						$comments_out = '<i class="fa fa-comments"></i> '.$comment_count;
					}
				$output .= '<div class="pipdig-masonry-post grid-item">';
					//$output .= '<a href="'.$link.'" class="moasic-hover" >';
						if ($layout == 'grid') {
							$output .= '<div class="p3_cover_me" style="background-image:url('.$img.')"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC" class="p3_invisible skip-lazy" alt="" /></div>';
						} else {
							$output .= '<img src="'.$img.'" alt="" />';
						}
						//$output .= '</a>';
						
						$output .= '<a href="'.$link.'" class="mosaic-meta">';
							if (absint($style) === 2) {
								$output .= '<div class="pipdig-masonry-post-style-2">';
							} else {
								$output .= '<div>';
							}
								if ($show_date) {
									$output .= '<span class="date"><time itemprop="datePublished">'.esc_html(get_the_date()).'</time></span>';
								}
								$output .= '<h2 class="title moasic-title p_post_titles_font" itemprop="name">'.esc_html(get_the_title()).'</h2>';
								if ($show_comments) {
									$output .= '<div class="mosaic-comments">'.$comments_out.'</div>';
								}
							$output .= '</div>';
						$output .= '</a>';
						
					$output .= '</div>';		

				endwhile; wp_reset_query();
			$output .= '</div>';
			
			$output .= '<nav id="mosaic-nav" class="clearfix" role="navigation">';
			
			if (get_next_posts_link('',$query->max_num_pages) ) {
				$output .= '<div class="nav-previous">'.get_next_posts_link( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> '.__( 'Older posts', 'p3' ), $query->max_num_pages ).'</div>';
			}

			if ( get_previous_posts_link() ) {
				$output .= '<div class="nav-next">'.get_previous_posts_link(__( 'Newer posts', 'p3' ).' <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>').'</div>';
			}
			
			$output .= '</nav>';
		
	$output .= '
	<style>
		.grid-item { width: '.$percent.'%; margin: 1%; }
		.grid-item img {max-width: 100%; height: auto;}
		.grid-item .hentry {margin-bottom: 0;}
		.entry-content .mosaic-meta {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		width: 100%;
		padding: 7px 7px 12px;
		background: rgba(255, 255, 255, .75);
		color: #000;
		opacity: 0;
		-moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out;
		}
		.entry-content .mosaic-meta:hover{opacity: 1;}
		.entry-content .mosaic-meta .date, .entry-content .mosaic-meta .mosaic-comments {font: 11px Montserrat, sans-serif; text-transform:uppercase;letter-spacing:1px;}
		.moasic-title {margin: 0; letter-spacing: 0; line-height: 1.2;}
		.mosaic-comments {position: absolute; bottom: 5%;}
		@media screen and (max-width: 769px) {
			.grid-item {width: 48%}
		}
	</style>
	<script>
	jQuery(document).ready(function($) {
		$(".entry-content").imagesLoaded( function(){
			jQuery(".p3_grid_mosaic").masonry({
				itemSelector: ".pipdig-masonry-post",
			});
		});
	});
	</script>';
	}
	
	return $output;
}
add_shortcode( 'pipdig_mosaic', 'pipdig_p3_mosaic_shortcode' );