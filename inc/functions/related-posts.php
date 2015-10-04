<?php
function pipdig_p3_related_posts() {
	
	if (is_single() && get_theme_mod('hide_related_posts')) {
		return;
	}
	if (is_archive() && get_theme_mod('hide_related_posts_home')) {
		return;
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
	
				$output .= '<div class="pipdig_p3_related_posts">';
				$output .= '<h3><span>'.__('You may also enjoy:', 'p3').'</span></h3>';
				$output .= '<ul>';
				
				while( $query->have_posts() ) { $query->the_post();
					$title = get_the_title();
					$link = get_the_permalink();
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'pipdig-trending' );
					if ($thumb) {
						$bg = $thumb['0'];
					} else {
						$bg = pipdig_p3_catch_that_image();
					}
					$output .= '<li>';
						$output .= '<div class="pipdig_p3_related_thumb" style="background-image:url('.$bg.');">';
							$output .= '<a href="'.$link.'" title="'.$title.'"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII=" alt="'.$title.'" class="p3_invisible" data-pin-nopin="true"/></a>';
						$output .= '</div>';
						$output .= '<div class="pipdig_p3_related_content">';
							$output .= '<h4 class="pipdig-related-title"><a href="'.$link.'" title="'.$title.'">'.pipdig_p3_truncate($title, 5).'</a></h4>';
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

			// Hide related posts on home page
			$wp_customize->add_setting('hide_related_posts_home',
				array(
					'default' => 0,
					'sanitize_callback' => 'pipdig_sanitize_checkbox',
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
					'sanitize_callback' => 'pipdig_sanitize_checkbox',
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

		}
	}
	add_action( 'customize_register' , array( 'pipdig_related_Customize' , 'register' ) );
}
