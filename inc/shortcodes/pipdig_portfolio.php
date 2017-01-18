<?php 

if ( ! defined( 'ABSPATH' ) ) exit;




// [pipdig_portfolio number="30" columns="3" filters="" shape="square/landscape/portrait"]
function pipdig_p3_portfolio_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'number' => '18',
		'columns' => '3',
		'filters' => '',
		'filters_title' => '',
		'shape' => 'square',
		//'lightbox' => 'no'
	), $atts));
	
	$output = '';
	
	if ($shape == 'square') {
		$shape_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC';
	} elseif ($shape == 'portrait') {
		$shape_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC';
	} elseif ($shape == 'landscape') {
		$shape_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC';
	} else { // defailt to square
		$shape_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC';
	}
	
	
	// filters for categories (types) only if shortcode is not set to filsters="no"
	if ($filters != 'no') {
	
		wp_enqueue_script('pipdig-mixitup');
		
		$output .= '<div id="pipdig_portfolio_filters">';
			if ($filters_title) {
				$output .= '<h6 style="background: none; color: #000;">'.$filters_title.'</h6>';
			}
			$output .= '<h6 id="filter--all" class="filter active" data-filter="*">'.__('View All', 'p3').'</h6>';
			$tax_terms = get_terms('jetpack-portfolio-type');
			foreach ($tax_terms as $tax_term) {
				$output .= '<h6 class="filter" data-filter=".pipdig_portfolio_filter-'. $tax_term->slug.'">' . $tax_term->slug .'</h6>';
			}
		$output .= '</div>';
		
		$output .= '<style scoped>#pipdig_portfolio .mix{display: none;}</style>';
	
	}
	
	
	// project items
	$output .= '<div id="pipdig_portfolio">';
	
		
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = -1;
		}
		
		if ($number) {
			$posts_per_page = absint($number);
		} else {
			$posts_per_page = get_option('jetpack_portfolio_posts_per_page', '-1');
		}
		
	
		$args = array(
			'post_type' => 'jetpack-portfolio',
			'paged' => $paged,
			'posts_per_page' => $posts_per_page,
		);

		$project_query = new WP_Query($args);
	 
		if (post_type_exists('jetpack-portfolio') && $project_query -> have_posts()) {
	 
			while ($project_query -> have_posts()) : $project_query -> the_post();
			
				global $post;
				$terms = get_the_terms( $post->ID, 'jetpack-portfolio-type' );
                        
				if ( $terms && ! is_wp_error( $terms ) ) {
				 
					$filtering_links = array();
				 
					foreach ( $terms as $term ) {
						$filtering_links[] = 'pipdig_portfolio_filter-'.$term->slug;
					}
										
					$filtering = join( " ", $filtering_links );
				
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
					if ($thumb) {
						$bg = esc_url($thumb['0']);
					} else {
						$bg = pipdig_p3_catch_that_image();
					}
					$link = get_the_permalink();
					
					
					$output .= '<div class="pipdig_portfolio_grid_item mix '.$filtering.'">';
						$output .= '<a href="'.$link.'" class="p3_cover_me" style="display: block; width: 100%; height: 100%;background-image:url('.$bg.');">';
							$output .= '<img src="'.$shape_img.'" alt="" class="p3_invisible" data-pin-nopin="true"/>';
							$output .= '<div class="pipdig_portfolio_grid_title_box">';
							$output .= '<h2 class="title">'.get_the_title().'</h2>';
							$output .= '<div class="read_more">'.__('Click to view', 'p3').'</div>';
							$output .= '</div>';
						$output .= '</a>';
					$output .= '</div>';

				}
				
			endwhile;
			
			$output .= '<div class="clearfix"></div>';
			
			$output .= '<nav id="mosaic-nav" class="clearfix" role="navigation">';
			
			if (get_next_posts_link('',$project_query->max_num_pages) ) {
				$output .= '<div class="nav-previous">'.get_next_posts_link( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> '.__( 'Older projects', 'p3' ), $project_query->max_num_pages ).'</div>';
			}

			if ( get_previous_posts_link() ) {
				$output .= '<div class="nav-next">'.get_previous_posts_link(__( 'Newer projects', 'p3' ).' <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>').'</div>';
			}
			
			$output .= '</nav>';
	 
			wp_reset_postdata();
	 
		} else {
		
			if (current_user_can('publish_posts')) {
				$output .= '<p>'.sprintf(__('Ready to publish your first project? <a href="%s">Get started here</a>.', 'p3'), esc_url(admin_url('post-new.php?post_type=jetpack-portfolio'))).'</p>';
			} else {
				$output .= '<p>'.__('No portfolio items found.', 'p3').'</p>';
			}
			
		}
		
		$output .= '</div><!--// #pipdig_portfolio -->';
		
	
		if ($filters != 'no') {
			$output .= '
				<script>
				jQuery(document).ready(function($) {
					$("#pipdig_portfolio").mixItUp({
						animation: {
							animateResizeContainer: false,
							effects: "fade rotateX(-10deg) translateY(-3%)"
						}
					});
				});
				</script>
				';
		}
		
	return $output;
	
}
add_shortcode('pipdig_portfolio', 'pipdig_p3_portfolio_shortcode');