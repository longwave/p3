<?php 

if (!defined('ABSPATH')) {
	exit;
}




// [pipdig_portfolio number="30" columns="3" type="slug" layout="mosaic"]
function pipdig_p3_portfolio_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'number' => '30',
		'columns' => '3',
		'type' => '',
		'layout' => '',
		//'comments' => 'yes'
	), $atts));
	
	$output = '';
	
	wp_enqueue_script('pipdig-mixitup');
	
	// filters for categories (types)
	$output .= '<div id="pipdig_portfolio_filters">';
		//$output .= '<ul>';
			$output .= '<h6 id="filter--all" class="filter active" data-filter="*">'.__('View All', 'p3').'</h6>';
				$tax_terms = get_terms('jetpack-portfolio-type');
				foreach ($tax_terms as $tax_term) {
					$output .= '<h6 class="filter" data-filter=".'. $tax_term->slug.'">' . $tax_term->slug .'</h6>';
				}
		//$output .= '</ul>';
	$output .= '</div>';
	
	
	// project items
	$output .= '<div id="pipdig_portfolio">';
		
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = -1;
		}
	 
		$posts_per_page = get_option('jetpack_portfolio_posts_per_page', '-1');
	
		$args = array(
			'post_type' => 'jetpack-portfolio',
			'paged' => $paged,
			'posts_per_page' => $posts_per_page,
		);

		$project_query = new WP_Query ($args);
	 
		if (post_type_exists('jetpack-portfolio') && $project_query -> have_posts()) {
	 
			while ($project_query -> have_posts()) : $project_query -> the_post();
			
				global $post;
				$terms = get_the_terms( $post->ID, 'jetpack-portfolio-type' );
                        
				if ( $terms && ! is_wp_error( $terms ) ) {
				 
					$filtering_links = array();
				 
					foreach ( $terms as $term ) {
						$filtering_links[] = $term->slug;
					}
										
					$filtering = join( " ", $filtering_links );
				
					if (has_post_thumbnail() != '') {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'p3_medium');
						$img = $thumb['0'];
					} else {
						$img = pipdig_p3_catch_that_image();
					}
					$link = get_the_permalink();
					
					$output .= '<div class="pipdig_portfolio_grid_item mix '.$filtering.'">';
						$output .= '<a href="'.$link.'" class="p3_slide_img" style="display: block; width: 100%; height: 100%;background-image:url('.$img.');">';
							$output .= '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" alt="" class="p3_invisible" data-pin-nopin="true"/>';
							$output .= '<div class="pipdig_portfolio_grid_title_box">';
							$output .= '<h2 class="title" itemprop="name">'.get_the_title().'</h2>';
							$output .= '<div class="read_more">'.__('Click to view', 'p3').'</div>';
							$output .= '</div>';
						$output .= '</a>';
					$output .= '</div>';
				
				}			
				
			endwhile;
	 
			//wds_portfolio_paging_nav($project_query->max_num_pages);
			wp_reset_postdata();
	 
		} else {
		
			if (current_user_can('publish_posts')) {
				$output .= '<p>'.sprintf(__('Ready to publish your first project? <a href="%s">Get started here</a>.', 'p3'), esc_url(admin_url('post-new.php?post_type=jetpack-portfolio'))).'</p>';
			} else {
				$output .= '<p>'.__('No portfolio items found.', 'p3').'</p>';
			}
			
		}
		
		$output .= '</div><!--// #pipdig_portfolio -->';
		
		$output .= '
		<script>
		jQuery(document).ready(function($) {
			$("#pipdig_portfolio").mixItUp();
		});
		</script>
		';
	
	return $output;
	
}
add_shortcode('pipdig_portfolio', 'pipdig_p3_portfolio_shortcode');