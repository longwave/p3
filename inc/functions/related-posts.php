<?php

if (!defined('ABSPATH')) die;
	function p3_related_posts() {
	
	if (is_single() && get_theme_mod('hide_related_posts')) {
		return;
	}
	if ((is_home() || is_archive()) && get_theme_mod('hide_related_posts_home')) {
		return;
	}
	
	$number = absint(get_theme_mod('p3_related_posts_number', 4));
	if ($number > 4) {
		$number = 4;
	}
	
	$the_shape = absint(get_theme_mod('p3_related_posts_shape', 1));
	
	$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII='; // landscape
	
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
	$orig_post = $post;
	$posts_by = absint(get_theme_mod('p3_related_posts_by', 1));
	if ($posts_by == 2) {
		$categories = get_the_tags($post->ID);
	} else {
		$categories = get_the_category($post->ID);
	}
	
	if ($categories) {
		
		$category_ids = array();
		foreach ($categories as $individual_category) {
			$category_ids[] = $individual_category->term_id;
		}
		
		$args = array(
			'post__not_in' => array($post->ID),
			'cat' => '',
			'posts_per_page'=> $number,
			'orderby' => 'rand',
			'date_query' => array(
				array('after' => get_theme_mod( 'related_posts_date', '1 year ago' )),
			),
		);
		
		if ($posts_by == 2) {
			$args['tag__in'] = $category_ids;
		} else {
			$args['category__in'] = $category_ids;
		}
		
		$exclude_cat = absint(get_theme_mod('p3_related_posts_exclude_cat'));
		if ($exclude_cat) {
			$args['cat'] = '-'.$exclude_cat;
		}
		
		$query = new wp_query($args);
		
		$lazy = false;
		$lazy_class = '';
		if (is_pipdig_lazy()) {
			$lazy = true;
			$lazy_class = 'pipdig_lazy';
		}
		
		if( $query->have_posts() ) {
	
		$output .= '<div class="clearfix"></div>';
	
			$output .= '<div class="pipdig_p3_related_posts nopin">';
			$output .= '<h3><span>'.$section_title.'</span></h3>';
			$output .= '<ul>';
			
			while( $query->have_posts() ) { $query->the_post();
			$title_attr = esc_attr(get_the_title());
			$link = esc_url(get_the_permalink());
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
			if ($thumb) {
				$img = esc_url($thumb['0']);
			} else {
				$img = pipdig_p3_catch_that_image();
			}
			
			$image_src = 'style="background-image:url('.$img.');"';
			if ($lazy) {
				$image_src = 'data-src="'.$img.'"';
			}
			
			$output .= '<li>';
				$output .= '<div class="p3_cover_me pipdig_p3_related_thumb '.$lazy_class.'" '.$image_src.'>';
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
add_action('p3_summary_end', 'p3_related_posts');


// customiser
if (!class_exists('pipdig_related_Customize')) {
	class pipdig_related_Customize {
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_related_posts_pop', 
				array(
					'title' => __( 'Related Posts', 'p3' ),
					'description'=> __( 'Related Posts are displayed from the same category.', 'p3' ).' <a href="https://support.pipdig.co/articles/wordpress-how-to-display-related-posts/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 95,
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
						'1 month ago' => __('1 Month', 'p3'),
						'3 months ago' => __('3 Months', 'p3'),
						'6 months ago' => __('6 Months', 'p3'),
						'1 year ago' => __('1 Year', 'p3'),
						'' => __('All Time', 'p3'),
					),
				)
			);
			
			// tags or cats?
			$wp_customize->add_setting('p3_related_posts_by',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_related_posts_by',
				array(
					'type' => 'radio',
					'label' => 'Find related posts using:',
					'section' => 'pipdig_related_posts_pop',
					'choices' => array(
						1 => 'Post Categories',
						2 => 'Post Tags',
					),
				)
			);
			
			// exclude from category
			$wp_customize->add_setting('p3_related_posts_exclude_cat',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control_Exclude(
					$wp_customize,
					'p3_related_posts_exclude_cat',
					array(
						'label' => __('Exclude posts from:', 'p3'),
						'settings' => 'p3_related_posts_exclude_cat',
						'section'  => 'pipdig_related_posts_pop'
					)
				)
			);
			
			// number of posts
			$wp_customize->add_setting('p3_related_posts_number',
				array(
					'default' => 4,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_related_posts_number',
				array(
					'type' => 'number',
					'label' => __( 'Number of posts to display', 'p3' ),
					'description' => __( 'Maximum = 4', 'p3' ),
					'section' => 'pipdig_related_posts_pop',
					'input_attrs' => array(
						'min'   => 1,
						'max'   => 4,
						'step'  => 1,
					),
				)
			);
			
			// image shape
			$wp_customize->add_setting('p3_related_posts_shape',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_related_posts_shape',
				array(
					'type' => 'select',
					'label' => __('Image shape', 'p3'),
					'section' => 'pipdig_related_posts_pop',
					'choices' => array(
						1 => 'Landscape',
						2 => 'Portait',
						3 => 'Square',
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

		}
	}
	add_action( 'customize_register' , array( 'pipdig_related_Customize' , 'register' ) );
}
