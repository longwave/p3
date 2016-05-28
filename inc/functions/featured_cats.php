<?php 

if (!defined('ABSPATH')) {
	exit;
}


function p3_featured_cats_puller($category) {
	
	$the_shape = intval(get_theme_mod('p3_featured_cats_shape'));
	
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

	while ( $query->have_posts() ): $query->the_post();

		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$bg = esc_url($thumb['0']);
		} else {
			$bg = pipdig_p3_catch_that_image();
		}
		$post_cat = get_the_category();
		if ($post_cat) {
			$post_cat = $post_cat[0]->name;
		} else {
			$post_cat = '';
		}
		?>
		<div class="col-sm-3">
			<h3 class="widget-title"><?php echo get_cat_name($category); ?></h3>
			<a href="<?php the_permalink(); ?>" class="p3_cover_me" style="background-image:url(<?php echo $bg; ?>);">
				<img src="<?php echo $shape; ?>" class="p3_invisible" />
			</a>
			<div class="entry-meta">
				<?php the_date(); ?>
			</div>
			<h4><?php the_title(); ?></h4>
		</div>

	<?php
	endwhile; wp_reset_query();
}


if (!function_exists('p3_featured_cats')) {
	function p3_featured_cats() {
		
		if (!is_home() || !is_front_page()) {
			return;
		}
		
		if (!get_theme_mod('p3_featured_cats_enable')) {
			return;
		}
		
		$post_cat_1 = get_theme_mod('p3_featured_cats_cat_1');
		$post_cat_2 = get_theme_mod('p3_featured_cats_cat_2');
		$post_cat_3 = get_theme_mod('p3_featured_cats_cat_3');
		$post_cat_4 = get_theme_mod('p3_featured_cats_cat_4');

		$text_color = get_theme_mod('p3_featured_cats_text_color', '#000');
		$text_bg_color = get_theme_mod('p3_featured_cats_text_bg_color', '#fff');
		
		?>
		<div id="p3_featured_cats" class="row nopin">
			
			<?php p3_featured_cats_puller($post_cat_1); ?>
			<?php p3_featured_cats_puller($post_cat_2); ?>
			<?php p3_featured_cats_puller($post_cat_3); ?>
			<?php p3_featured_cats_puller($post_cat_4); ?>
			
			<div class="clearfix"></div>

		</div>
	<?php
	}
	add_action('p3_top_site_main_container', 'p3_featured_cats', 4);
}

// customiser
if (!class_exists('pipdig_p3_featured_cats_Customize')) {
	class pipdig_p3_featured_cats_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_featured_cats_section', 
				array(
					'title' => __( 'Featured Categories', 'p3' ),
					'description'=> __( 'Display 4 featured post categories at the top of your homepage. Each category will display the latest post from that topic.', 'p3' ),
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
					'section' => 'p3_featured_cats_section',
				)
			);
			
			// Number of images to display in slider
			$wp_customize->add_setting('p3_featured_cats_shape',
				array(
					'default' => '1',
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control('p3_featured_cats_shape',
				array(
					'type' => 'select',
					'label' => __('Image shape', 'p3'),
					'section' => 'p3_featured_cats_section',
					'choices' => array(
						'1' => 'Portait',
						'2' => 'Landscape',
						'3' => 'Square',
					),
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
						'description' => __('Only display posts from:', 'p3'),
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
						'description' => __('Only display posts from:', 'p3'),
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
						'description' => __('Only display posts from:', 'p3'),
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
						'description' => __('Only display posts from:', 'p3'),
						'settings' => 'p3_featured_cats_cat_4',
						'section'  => 'p3_featured_cats_section'
					)
				)
			);
			
	
		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_featured_cats_Customize' , 'register' ) );
}
