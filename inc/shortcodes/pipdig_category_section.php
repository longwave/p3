<?php 

if (!defined('ABSPATH')) die;

// [pipdig_category_section title="" category="slug" number="3"]
function pipdig_p3_cat_section_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'title_link' => '',
		'border' => '',
		'excerpt' => true,
		'excerpt_length' => '25',
		'category' => '',
		'shape' => '',
		'view_all_button' => '',
		'view_all_button_text' => '',
		'number' => '3',
		'columns' => '3',
		'location' => false,
		'link_titles' => false
	), $atts ) );
	
	$output = $border_class = $col_class = $title_link_start = $title_link_end = '';
	
	$border = filter_var( $border, FILTER_VALIDATE_BOOLEAN );
	$excerpt = filter_var( $excerpt, FILTER_VALIDATE_BOOLEAN );
	$view_all_button = filter_var( $view_all_button, FILTER_VALIDATE_BOOLEAN );
	$location = filter_var( $location, FILTER_VALIDATE_BOOLEAN );
	
	if ($columns == '2') {
		$col_class = '_2_cols';
	}
	
	$the_shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII='; // landscape 600x400
	
	if ($shape == 'portrait') {
		$the_shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
	} elseif ($shape == 'square') {
		$the_shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
	}
	
	$output .= '<div class="pipdig_category_section">';
		
		if ($title) {
			if ($border) {
				$border_class = 'class="pipdig_category_section_border"';
			}
			if ($title_link) {
				$title_link_start = '<a href="'.esc_url($title_link).'">';
				$title_link_end = '</a>';
			}
			$output .= '<h2 '.$border_class.'><span>'.$title_link_start . esc_html($title) . $title_link_end.'</span></h2>';
		}
		
		$query = new WP_Query(
			array(
				'posts_per_page' => $number,
				'category_name' => $category,
				'ignore_sticky_posts' => true,
			)
		);
		
		if ( $query->have_posts() ) {
			
			while ( $query->have_posts() ) : $query->the_post();
			
				$bg = p3_catch_image(get_the_ID(), 'p3_medium');
				
				$link = esc_url(get_the_permalink());
				
				$comment_count = get_comments_number();
				if ($comment_count == 0) {
					$comments_out = '';
				} else {
					$comments_out = '<i class="fa fa-comments"></i> '.$comment_count;
				}
				
				$output .= '<div class="pipdig_category_section_item'.$col_class.'">';
				
				$output .= '<a href="'.$link.'" class="p3_cover_me" style="background-image:url('.$bg.');"><img src="'.$the_shape.'" alt="'.esc_attr(get_the_title()).'" class="p3_invisible skip-lazy" data-pin-nopin="true"/></a>';
				
				
				if ($location) {
					$post_location = '';
					if (function_exists('rwmb_meta')) {
						$post_location = rwmb_meta('pipdig_meta_geographic_location');
					}
					if ($post_location) {
						$output .= '<div class="p_post_location"><i class="fa fa-map-marker"></i> '.strip_tags($post_location).'</div>';
					}
				}
				
				if ($link_titles) {
					$output .= '<a href="'.$link.'"><h3 class="pipdig_category_section_item_title p_post_titles_font">'.strip_tags(get_the_title()).'</h3></a>';
				} else {
					$output .= '<h3 class="pipdig_category_section_item_title p_post_titles_font">'.strip_tags(get_the_title()).'</h3>';
				}
				
				
				if ($excerpt) {
					$output .= '<div class="pipdig_category_section_item_summary">'.pipdig_truncate(strip_shortcodes(strip_tags(get_the_excerpt())), $excerpt_length).'</div>';
				}
				
				$output .= '</div>'; //.pipdig_category_section_item
				
				// clearfix and margin if 2 columns
				if (($columns == '2') && ($query->current_post % 2)) {
					$output .= '<div class="clearfix" style="margin-bottom: 20px;"></div>';
				}
				
			endwhile; wp_reset_query();
			
			$cat_link = esc_url(get_category_link(get_category_by_slug($category)));
			
			if ($view_all_button == 'yes' ) {
			
				$output .= '<div class="pipdig_category_section_button">';
					$output .= '<a class="more-link" href="'.$cat_link.'">';
						if ($view_all_button_text) {
							$output .= strip_tags($view_all_button_text);
						} else {
							$output .= __('View All', 'p3');
						}
						
					$output .= '</a>';
				$output .= '</div>';
			}
			
		}
	
	$output .= '</div>'; //.pipdig_category_section
	
	$output .= '<div class="clearfix"></div>';
	
	return $output;
}
add_shortcode( 'pipdig_category_section', 'pipdig_p3_cat_section_shortcode' );