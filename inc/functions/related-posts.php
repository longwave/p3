<?php

if (!defined('ABSPATH')) {
	exit;
}
if (!function_exists('p3_related_posts')) {
	function p3_related_posts() {
		
		if (is_single() && get_theme_mod('hide_related_posts')) {
			return;
		}
		if ((is_home() || is_archive()) && get_theme_mod('hide_related_posts_home')) {
			return;
		}
		
		$the_shape = absint(get_theme_mod('p3_related_posts_shape'));
		
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC'; // landscape
	
		
		if ($the_shape == 2) {
			
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
			
		} elseif ($the_shape == 3) {
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
		}
		
		$section_title = strip_tags(get_theme_mod('p3_related_posts_title'));
		if (empty($section_title)) {
			$section_title = __('You may also enjoy:', 'p3');
		}
		
		$output = '';
		global $post;
		$date_range = get_theme_mod( 'related_posts_date', '1 year ago' );
		$orig_post = $post;
		$categories = get_the_category($post->ID);
		if ($categories) {
			switch ($date_range) { //used to suffix transient id...
				case '1 year ago':
					$range = 'yr';
					break;
				case '1 month ago':
					$range = 'mth';
					break;
				case '1 week ago':
					$range = 'wk';
					break;
				case '':
					$range = 'all';
					break;
			}
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
			$post_id = get_the_ID(); //used to suffix transient id...
			//if ( false === ( $query = get_transient( 'pipdig_related_posts_'.$post_id.'_'.$range ) ) ) { // transient
				$query = new wp_query( array(
					'category__in' => $category_ids,
					'post__not_in' => array($post_id),
					'posts_per_page'=> 4,
					'orderby' => 'rand',
					'date_query' => array(
						array(
							'after' => $date_range,
						),
					),
					)
				);
				//set_transient( 'pipdig_related_posts_'.$post_id.'_'.$range, $query, 12 * HOUR_IN_SECONDS );
			//}
			if( $query->have_posts() ) {
		
				$output .= '<div class="clearfix"></div>';
		
					$output .= '<div class="pipdig_p3_related_posts nopin">';
					$output .= '<h3><span>'.$section_title.'</span></h3>';
					$output .= '<ul>';
					
					while( $query->have_posts() ) { $query->the_post();
						$title_attr = esc_attr(get_the_title());
						$link = esc_url(get_the_permalink());
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_small' );
						if ($thumb) {
							$bg = esc_url($thumb['0']);
						} else {
							$bg = pipdig_p3_catch_that_image();
						}
						$output .= '<li>';
							$output .= '<div class="pipdig_p3_related_thumb" style="background-image:url('.$bg.');">';
								$output .= '<a href="'.$link.'" title="'.$title_attr.'"><img src="'.$shape.'" alt="'.$title_attr.'" class="p3_invisible" data-pin-nopin="true"/></a>';
							$output .= '</div>';
							$output .= '<div class="pipdig_p3_related_content">';
								$truncate_title = absint(get_theme_mod('p3_related_posts_post_title_limit', 7));
								$output .= '<h4 class="pipdig_p3_related_title"><a href="'.$link.'" title="'.$title_attr.'">'.pipdig_p3_truncate(get_the_title(), $truncate_title).'</a></h4>';
							$output .= '</div>';
						$output .= '</li>';
					} //endwhile 
				$output .= '</ul>';
				$output .= '</div>';
				
				$output .= '<div class="clearfix"></div>';
				
			}
		}
		$post = $orig_post;
		wp_reset_query();
		
		echo $output;

	}
	add_action('p3_content_end', 'p3_related_posts');
}


// customiser
if (!class_exists('pipdig_related_Customize')) {
	class pipdig_related_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_related_posts_pop', 
				array(
					'title' => __( 'Related Posts', 'p3' ),
					'description'=> __( 'Related Posts are displayed from the same category.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 95,
				) 
			);


			// Date range for related posts
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
					'section' => 'pipdig_related_posts_pop',
					'choices' => array(
						'1 year ago' => __('1 Year', 'p3'),
						'1 month ago' => __('1 Month', 'p3'),
						'1 week ago' => __('1 Week', 'p3'),
						'' => __('All Time', 'p3'),
					),
				)
			);
			
			// image shape
			$wp_customize->add_setting('p3_related_posts_shape',
				array(
					'default' => '1',
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_related_posts_shape',
				array(
					'type' => 'select',
					'label' => __('Image shape', 'p3'),
					'section' => 'pipdig_related_posts_pop',
					'choices' => array(
						'1' => 'Landscape',
						'2' => 'Portait',
						'3' => 'Square',
					),
				)
			);
			
			// post title length
			$wp_customize->add_setting('p3_related_posts_post_title_limit',
				array(
					'default' => 7,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_related_posts_post_title_limit',
				array(
					'type' => 'number',
					'label' => __( 'Post title length (words)', 'p3' ),
					'section' => 'pipdig_related_posts_pop',
					'input_attrs' => array(
						'min'   => 1,
						'max'   => 50,
						'step'  => 1,
					),
				)
			);

			// Hide related posts on home page
			$wp_customize->add_setting('hide_related_posts_home',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'hide_related_posts_home',
				array(
					'type' => 'checkbox',
					'label' => __( "Don't display on homepage", 'p3' ),
					'section' => 'pipdig_related_posts_pop',
				)
			);

			// Hide related posts on single posts
			$wp_customize->add_setting('hide_related_posts',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'hide_related_posts',
				array(
					'type' => 'checkbox',
					'label' => __( "Don't display on posts", 'p3' ),
					'section' => 'pipdig_related_posts_pop',
				)
			);
			
			$wp_customize->add_setting('p3_related_posts_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_related_posts_title',
				array(
					'type' => 'text',
					'label' => __( 'Title:', 'p3' ),
					'section' => 'pipdig_related_posts_pop',
					'input_attrs' => array(
						'placeholder' => __('You may also enjoy:', 'p3'),
					),
				)
			);

		}
	}
	add_action( 'customize_register' , array( 'pipdig_related_Customize' , 'register' ) );
}
