<?php 

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('p3_trending_bar')) {
	function p3_trending_bar() {
		
		// copy old options - remove at end of jan
		
		if (get_theme_mod('show_trending')) {
			set_theme_mod('p3_trending_bar_enable', 1);
		}
		if (get_theme_mod('trending_section_title')) {
			set_theme_mod('p3_trending_bar_slider_title', get_theme_mod('trending_section_title'));
		}
		if (get_theme_mod('trending_dates')) {
			set_theme_mod('p3_trending_bar_trending_dates', get_theme_mod('trending_dates'));
		}
		
		// ----
		
		if (!get_theme_mod('p3_trending_bar_enable')) {
			return;
		}
		if (!is_front_page() && get_theme_mod('p3_trending_bar_home', 1)) {
			return;
		}
		$popular_title = strip_tags(get_theme_mod('p3_trending_bar_slider_title'));
		if (empty($popular_title)) {
			$popular_title = __('Popular Posts', 'p3');
		}
		$post_cat_trending = get_theme_mod('p3_trending_bar_trending_cat');
		$big_this_month_title = get_theme_mod('p3_trending_bar_pop_title');
		$date_range = get_theme_mod( 'p3_trending_bar_trending_dates', '1 month ago' );
		$text_color = get_theme_mod('p3_trending_bar_text_color', '#000');
		$text_bg_color = get_theme_mod('p3_trending_bar_text_bg_color', '#fff');

		?>
		<div id="p3_trending_bar" class="row nopin">
			<style scoped>
				.p3_trending_panel h4 {background:<?php echo esc_attr($text_bg_color); ?>;color:<?php echo esc_attr($text_color); ?>;}
			</style>
			<div class="col-xs-12">

				<div id="p3_big_this" class="nopin">
					<h3 class="widget-title"><span><?php echo $popular_title; ?></span></h3>
					<?php
						$popular = new WP_Query( array(
							'cat'                   => $post_cat_trending,
							'showposts'             => 5,
							'ignore_sticky_posts'   => true,
							'orderby'               => 'comment_count',
							'order'                 => 'dsc',
							'date_query' => array(
								array(
									'after' => $date_range,
								),
							),
						) );
					?>
					<?php while ( $popular->have_posts() ): $popular->the_post();			
						if(has_post_thumbnail()){
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_small' ); // 640 x 360
							$bg = esc_url($thumb['0']);
						} else {
							$bg = pipdig_p3_catch_that_image();
						}
					?>
					<div class="p3_trending_panel">
						<a href="<?php the_permalink() ?>">
							<div class="p3_slide_img" style="background-image:url(<?php echo $bg; ?>);">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
							</div>
							<h4><?php echo pipdig_p3_truncate(get_the_title(), 7); ?></h4>
						</a>
					</div>
					<?php endwhile;?>

				</div>
			</div>
			
		</div>
	<?php
	}
	add_action('p3_top_site_main', 'p3_trending_bar');
}

// customiser
if (!class_exists('p3_trending_bar_Customize')) {
	class p3_trending_bar_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'pipdig_trending_section', 
				array(
					'title' => __( 'Popular Posts Bar', 'p3' ),
					'description'=> __( 'Display popular posts across the top of your site.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 113,
				) 
			);
			
			// Enable feature
			$wp_customize->add_setting('p3_trending_bar_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_trending_bar_enable',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable this feature', 'p3' ),
					'section' => 'pipdig_trending_section',
				)
			);
			
			// homepage only
			$wp_customize->add_setting('p3_trending_bar_home',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_trending_bar_home',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display on homepage only', 'p3' ),
					'description' => '<hr>',
					'section' => 'pipdig_trending_section',
				)
			);

			
			$wp_customize->add_setting('p3_trending_bar_slider_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_trending_bar_slider_title',
				array(
					'type' => 'text',
					'label' => __( 'Feature title', 'p3' ),
					'section' => 'pipdig_trending_section',
					'input_attrs' => array(
					'placeholder' => __( 'Popular Posts', 'p3' ),
					),
				)
			);

			
			// Date range for popular/trending posts
			$wp_customize->add_setting('p3_trending_bar_trending_dates',
				array(
					'default' => '1 month ago',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control('p3_trending_bar_trending_dates',
				array(
					'type' => 'select',
					'label' => __('Date range for posts:', 'p3'),
					'section' => 'pipdig_trending_section',
					'choices' => array(
						'1 year ago' => __('1 Year', 'p3'),
						'1 month ago' => __('1 Month', 'p3'),
						'1 week ago' => __('1 Week', 'p3'),
						'' => __('All Time', 'p3'),
					),
				)
			);
			
			// Choose a category for trending
			$wp_customize->add_setting('p3_trending_bar_trending_cat',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_trending_bar_trending_cat',
					array(
						'label' => __('Category for "Big this Month":', 'p3'),
						'description' => __('Only display posts from:', 'p3'),
						'settings' => 'p3_trending_bar_trending_cat',
						'section'  => 'pipdig_trending_section'
					)
				)
			);
			
			
			// title backgroud color
			$wp_customize->add_setting('p3_trending_bar_text_bg_color',
				array(
					'default' => '#ffffff',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_trending_bar_text_bg_color',
				array(
					'label' => __( 'Background color', 'p3' ),
					'settings' => 'p3_trending_bar_text_bg_color',
					'section' => 'pipdig_trending_section',
				)
				)
			);
			
			// title color
			$wp_customize->add_setting('p3_trending_bar_text_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_trending_bar_text_color',
				array(
					'label' => __( 'Title color', 'p3' ),
					'settings' => 'p3_trending_bar_text_color',
					'section' => 'pipdig_trending_section',
				)
				)
			);



		}
	}
	add_action( 'customize_register' , array( 'p3_trending_bar_Customize' , 'register' ) );
}
