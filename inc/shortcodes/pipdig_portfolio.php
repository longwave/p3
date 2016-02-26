<?php 

if (!defined('ABSPATH')) {
	exit;
}

// [pipdig_mosaic number="30" columns="3" type="slug" layout="mosaic"]
function pipdig_p3_portfolio_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'number' => '30',
		'columns' => '3',
		'type' => '',
		'layout' => '',
		//'comments' => 'yes'
	), $atts ) );
	
	$output = $percent = $our_tax_query = '';
	
	// built the query first
	if ($type) { // if a type (category) has been selected lets set the tax
	
		$our_tax_query = array(
							array(
								'taxonomy' => 'jetpack-portfolio-type',
								'field'    => 'slug',
								'terms'    => $type,
							)
						);
	}
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$query = new WP_Query( array(
			//'meta_key' => '_thumbnail_id',
			//'showposts' => 30,
			'post_type' => 'jetpack-portfolio',
			'post_status' => 'publish',
			'posts_per_page' => $number,
			'tax_query' => $our_tax_query,
			'ignore_sticky_posts' => true,
			'pagination' => true,
			'paged' => $paged,
			)
		);
		
			
	if ( $query->have_posts() ) {
	
	if ($layout == 'mosaic') {
		$output .= '<div class="grid p3_grid_mosaic">';
	} else {
		$output .= '<div class="grid p3_grid_portfolio">';
	}
				while ( $query->have_posts() ) : $query->the_post();
				
					if (has_post_thumbnail() != '') {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'p3_large');
						$img = $thumb['0'];
					} else {
						$img = pipdig_p3_catch_that_image();
					}
					$link = get_the_permalink();
					if ($layout != 'mosaic') { // grid layout:
						$output .= '<div class="pipdig-portfolio-grid-item">';
							$output .= '<a href="'.$link.'" class="p3_slide_img" style="display: block; width: 100%; height: 100%;background-image:url('.$img.');">';
								$output .= '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" alt="" class="p3_invisible" data-pin-nopin="true"/>';
								$output .= '<h2 class="title pipdig-grid-title" itemprop="name">'.get_the_title().'</h2>';
							$output .= '</a>';
						$output .= '</div>';
					} else  { // mosaic layout:
						$output .= '<div class="pipdig-masonry-post grid-item">';
							$output .= '<img src="'.$img.'" alt="" />';
							$output .= '<a href="'.$link.'" class="mosaic-meta">';
								$output .= '<span class="date"><time itemprop="datePublished">'.get_the_date().'</time></span>';
								$output .= '<h2 class="title moasic-title" itemprop="name">'.get_the_title().'</h2>';
							$output .= '</a>';
						$output .= '</div>';
					}
	

				endwhile; wp_reset_query();
			$output .= '</div>';
			
			$output .= '<nav id="mosaic-nav" class="clearfix" role="navigation">';
			
			if (get_next_posts_link('',$query->max_num_pages) ) {
				$output .= '<div class="nav-previous">'.get_next_posts_link( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> '.__( 'Older projects', 'p3' ), $query->max_num_pages ).'</div>';
			}

			if ( get_previous_posts_link() ) {
				$output .= '<div class="nav-next">'.get_previous_posts_link(__( 'Newer projects', 'p3' ).' <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>').'</div>';
			}
			
			$output .= '</nav>';
	
		if ($layout == 'mosaic') {
		
			wp_enqueue_script( 'masonry' );
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
			$output .= '
			<style>
				.grid-item { width: '.$percent.'%; margin: 1%; }
				.grid-item img {max-width: 100%; height: auto;}
				.grid-item .hentry {margin-bottom: 0;}
				.mosaic-meta {
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
				.moasic-title {margin: 0; letter-spacing: 0; line-height: 1.2;}
				.mosaic-comments {position: absolute; bottom: 5%;}
				.mosaic-meta:hover{opacity: 1;}
				#mosaic-nav .nav-previous {
				float: left;
				text-align: center;
				width: 50%;
				}
				#mosaic-nav .nav-next {
				float: right;
				text-align: center;
				width: 50%;
				}
				@media screen and (max-width: 769px) {
					.grid-item {width: 48%}
				}
			</style>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js"></script>
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
		
	}

	
	return $output;
}
add_shortcode( 'pipdig_portfolio', 'pipdig_p3_portfolio_shortcode' );