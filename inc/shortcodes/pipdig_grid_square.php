<?php 

if (!defined('ABSPATH')) die;

// [pipdig_grid_square number="30" columns="3" category="slug"]
function pipdig_p3_grid_square_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'number' => '30',
		'columns' => '3',
		'category' => '',
		//'comments' => 'yes'
	), $atts ) );
	
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
	
	$output = '';
		
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$query = new WP_Query( array(
			//'meta_key'			=> '_thumbnail_id',
			//'showposts'			=> 30,
			'posts_per_page'		=> $number,
			'category_name'			=> $category,
			'ignore_sticky_posts'	=> true,
			'pagination'			=> true,
			'paged'					=> $paged,
			)
		);
				
	if ( $query->have_posts() ) {
		
	$output .= '<div class="grid js-masonry">';

				while ( $query->have_posts() ) : $query->the_post();
					if (has_post_thumbnail() != '') {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						$img = $thumb['0'];
					} else {
						$img = pipdig_p3_catch_that_image();
					}
					$link = get_the_permalink();
					$comment_count = get_comments_number();
					if ($comment_count == 0) {
						$comments_out = '';
					} else {
						$comments_out = '<i class="fa fa-comments"></i> '.$comment_count;
					}
					$output .= '<div class="pipdig-mosaic-post">';
					$output .= '<a class="post-btn overlay-btn mosaic_gridder" style="background-image:url('.$img.');" href="'.get_the_permalink().'">';
					$output .= '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" alt=""/>';
					$output .= '<div class="overlay">';
						$output .= '<header class="header post-header">';
							$output .= '<div class="meta">';
								$output .= '<span class="date"><time itemprop="datePublished">'.get_the_date().'</time></span>';
							$output .= '</div>';
							$output .= '<h3 class="title" itemprop="name">'.pipdig_p3_truncate(get_the_title(), 8).'</h3>';
							if ((get_comments_number() != 0) && function_exists('pipdig_p3_comment_count')) {
								$output .= '<div class="gridz-comments disqus-comment-count" data-disqus-url="'.get_the_permalink().'">'.pipdig_p3_comment_count().'</div>';
							}
					$output .= '</div>';
				$output .= '</a>';
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
	<style scoped>
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
	</style>
	';
	}
	
	return $output;
}
add_shortcode( 'pipdig_grid_square', 'pipdig_p3_grid_square_shortcode' );