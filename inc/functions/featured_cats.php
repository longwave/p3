<?php 

if (!defined('ABSPATH')) die;


function p3_featured_cats_puller($category, $col = 3) {
	
	$the_shape = absint(get_theme_mod('p3_featured_cats_shape'));
	
	$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
	
	if ($the_shape == 2) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC'; // landscape
	} elseif ($the_shape == 3) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
	}
	
	$query = new WP_Query( array(
		'post_type'				=> 'post',
		'showposts'				=> 1,
		'ignore_sticky_posts'	=> true,
		'cat'					=> $category,
		)
	);
	
	$bg = '';
	$cat_img = get_term_meta( $category, 'cat_image', true);
	if ($cat_img) {
		$img_src = wp_get_attachment_image_src($cat_img, 'p3_medium');
		if ($img_src) {
			$bg = esc_url(reset($img_src));
		}
	}

	while ( $query->have_posts() ): $query->the_post();
		
		if (!$bg) {
			$bg = p3_catch_image(get_the_ID(), 'p3_medium');
		}
		
		if (get_theme_mod('p3_featured_cats_link2cat')) {
			$the_link = get_category_link($category);
		} else {
			$the_link = get_permalink();
		}
		
		?>
		<div class="col-sm-<?php echo strip_tags($col); ?> p3_featured_cat">
			<h3 class="widget-title"><span><?php echo strip_tags(get_cat_name($category)); ?></span></h3>
			<a href="<?php echo esc_url($the_link); ?>" class="p3_cover_me" style="background-image:url(<?php echo $bg; ?>);">
				<img src="<?php echo $shape; ?>" class="p3_invisible" />
			</a>
			<?php if (get_theme_mod('p3_featured_cats_show_dates', 1)) { ?>
			<div class="entry-meta">
				<?php echo apply_filters('the_date', get_the_date(), get_option('date_format'), '', ''); ?>
			</div>
			<?php } ?>
			<?php if (get_theme_mod('p3_featured_cats_show_title', 1)) { ?>
			<h4 class="p_post_titles_font"><?php the_title(); ?></h4>
			<?php } ?>
		</div>

	<?php
	endwhile; wp_reset_query();
}


function p3_featured_cats() {
		
	if (!is_home() && !is_front_page()) {
		return;
	}
		
	if (is_paged()) {
		return;
	}
		
	if (!get_theme_mod('p3_featured_cats_enable')) {
		return;
	}
		
	$post_cat_1 = get_theme_mod('p3_featured_cats_cat_1');
	$post_cat_2 = get_theme_mod('p3_featured_cats_cat_2');
	$post_cat_3 = get_theme_mod('p3_featured_cats_cat_3');
	$post_cat_4 = get_theme_mod('p3_featured_cats_cat_4');
	$post_cat_5 = get_theme_mod('p3_featured_cats_cat_5');

	$text_color = get_theme_mod('p3_featured_cats_text_color', '#000');
	$text_bg_color = get_theme_mod('p3_featured_cats_text_bg_color', '#fff');
		
	$count = 0;
	if (!empty($post_cat_1)) {
		$count++;
	}
	if (!empty($post_cat_2)) {
		$count++;
	}
	if (!empty($post_cat_3)) {
		$count++;
	}
	if (!empty($post_cat_4)) {
		$count++;
	}
	if (!empty($post_cat_5)) {
		$count++;
	}
	
	switch ( $count ) {
		case 1:
			$col = '12';
			break;
		case 2:
			$col = '6';
			break;
		case 3:
			$col = '4';
			break;
		case 4:
			$col = '3';
			break;
		case 5:
			$col = '5ths';
			break;
	}
	
	$mobile_class = '';
	if (!get_theme_mod('p3_featured_cats_mobile', 1)) {
		$mobile_class = 'p3_featured_cats_no_mobile';
	}
	
	?>
	<div id="p3_featured_cats" class="row nopin <?php echo $mobile_class; ?>">
			
		<?php
		if (!empty($post_cat_1)) {
			p3_featured_cats_puller($post_cat_1, $col);
		}
		if (!empty($post_cat_2)) {
			p3_featured_cats_puller($post_cat_2, $col);
		}
		if (!empty($post_cat_3)) {
			p3_featured_cats_puller($post_cat_3, $col);
		}
		if (!empty($post_cat_4)) {
			p3_featured_cats_puller($post_cat_4, $col);
		}
		if (!empty($post_cat_5)) {
			p3_featured_cats_puller($post_cat_5, $col);
		}
		?>
		
		<div class="clearfix"></div>
	</div>
<?php
}
add_action('p3_top_site_main_container', 'p3_featured_cats', 4);


// customiser
if (!class_exists('pipdig_p3_featured_cats_Customize')) {
	class pipdig_p3_featured_cats_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_featured_cats_section', 
				array(
					'title' => __( 'Featured Categories', 'p3' ),
					'description'=> __( 'Display 4 featured post categories at the top of your homepage. Each category will display the latest post from that topic.', 'p3' ).' <a href="https://support.pipdig.co/articles/wordpress-featured-categories/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 59,
				) 
			);
			
			// Enable feature
			$wp_customize->add_setting('p3_featured_cats_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_featured_cats_enable',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable this feature', 'p3' ),
					'description' => "Please note, you must select at least one category below",
					'section' => 'p3_featured_cats_section',
				)
			);
			
			// on mobile?
			$wp_customize->add_setting('p3_featured_cats_mobile',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_featured_cats_mobile',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable on mobile', 'p3' ),
					'section' => 'p3_featured_cats_section',
				)
			);
			
			// image shape
			$wp_customize->add_setting('p3_featured_cats_shape',
				array(
					'default' => '1',
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_featured_cats_shape',
				array(
					'type' => 'radio',
					'label' => __('Image shape', 'p3'),
					'section' => 'p3_featured_cats_section',
					'choices' => array(
						'1' => 'Portait',
						'2' => 'Landscape',
						'3' => 'Square',
					),
				)
			);
			
			// Enable feature
			$wp_customize->add_setting('p3_featured_cats_link2cat',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_featured_cats_link2cat',
				array(
					'type' => 'checkbox',
					'label' => 'Link to the post category rather than the latest post directly',
					'section' => 'p3_featured_cats_section',
				)
			);
			
			// Display post dates
			$wp_customize->add_setting('p3_featured_cats_show_dates',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_featured_cats_show_dates',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display post date', 'p3' ),
					'section' => 'p3_featured_cats_section',
				)
			);
			
			// Display post dates
			$wp_customize->add_setting('p3_featured_cats_show_title',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_featured_cats_show_title',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display post title', 'p3' ),
					'section' => 'p3_featured_cats_section',
				)
			);

			// Choose category 1
			$wp_customize->add_setting('p3_featured_cats_cat_1',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_featured_cats_cat_1',
					array(
						'label' => __('Category').' 1',
						'settings' => 'p3_featured_cats_cat_1',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
			// Choose category 2
			$wp_customize->add_setting('p3_featured_cats_cat_2',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_featured_cats_cat_2',
					array(
						'label' => __('Category').' 2',
						'settings' => 'p3_featured_cats_cat_2',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
			// Choose category 3
			$wp_customize->add_setting('p3_featured_cats_cat_3',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_featured_cats_cat_3',
					array(
						'label' => __('Category').' 3',
						'settings' => 'p3_featured_cats_cat_3',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
			// Choose category 4
			$wp_customize->add_setting('p3_featured_cats_cat_4',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_featured_cats_cat_4',
					array(
						'label' => __('Category').' 4',
						'settings' => 'p3_featured_cats_cat_4',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
			// Choose category 5
			$wp_customize->add_setting('p3_featured_cats_cat_5',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_featured_cats_cat_5',
					array(
						'label' => __('Category').' 5',
						'settings' => 'p3_featured_cats_cat_5',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
	
		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_featured_cats_Customize' , 'register' ) );
}
