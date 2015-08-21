<?php 

// [mosaic posts="13"]
function pipdig_p3_mosaic_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'posts' => '13',
		'category' => ''
	), $atts ) );
	
	wp_enqueue_script( 'masonry' );

	$output = '';
		
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$query = new WP_Query( array(
					//'meta_key'				=> '_thumbnail_id',
					//'showposts'				=> 30,
					'posts_per_page' => 15,
					//'category_name'			=> '',
					'ignore_sticky_posts'	=> true,
					'paged' => $paged,
					)
				);
				
	if ( $query->have_posts() ) {
		
	$output .= '<div class="grid js-masonry">';

				while ( $query->have_posts() ) : $query->the_post();
				
				$output .= '<div class="pipdig-masonry-post grid-item">';
					$output .= '<a href="'.get_the_permalink().'" title="'.the_title_attribute().'" class="masonry-hover" >';
							if (has_post_thumbnail() != '') { // if thumbnail is set in post
								$output .= the_post_thumbnail( 'full', array( 'data-pin-nopin' => 'true' ) );
							} else { // if not, let's use first
								$output .= '<img src="'.pipdig_catch_that_image().'" alt="" data-pin-nopin="true" />';
							}
						$output .= '</a>';
						$output .= '<div class="masonry-meta">';
							$output .= '<a href="'.get_the_permalink().'">';
							$output .= '<span class="date">';
								$output .= '<time itemprop="datePublished">'.get_the_date().'</time>';
							$output .= '</span>';
							$output .= '</a>';
							$output .= '<a href="'.get_the_permalink().'">';
								$output .= '<h3 class="title masonry-title" itemprop="name">'.get_the_title().'</h3>';
							$output .= '</a>';
						$output .= '</div>';
					$output .= '</div>';		

				endwhile;
			$output .= '</div>';
		
	$output .= '
	<style>
		.grid-item { width: 31%; margin: 1%; }
		.grid-item img {
			height: auto;
			max-width: 100%;
		}
		.grid-item .hentry {
		margin-bottom: 0;
		}
		.masonry-meta {
		position: absolute;
		bottom: 0;
		width: 100%;
		padding: 7px 7px 12px;
		background: #fff;
		background: rgba(255, 255, 255, .91);
		color: #000;
		opacity: 0;
		-moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out;
		}
		.masonry-title {
		margin: 0;
		letter-spacing: 0;
		line-height: 1.2;
		}
		.masonry-hover:hover~.masonry-meta, .masonry-meta:hover{
		opacity: 1;
		}
	</style>
	<script>
		(function($){
		var $container = $(".js-masonry");
		$container.imagesLoaded( function() {
		$container.masonry();
		});})(jQuery);
	</script>';
	
	}
	
	return $output;
}
add_shortcode( 'pipdig_mosaic', 'pipdig_p3_mosaic_shortcode' );