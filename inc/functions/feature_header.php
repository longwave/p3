<?php 

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('p3_feature_header')) {
	function p3_feature_header() {
		
		if (!get_theme_mod('p3_feature_header_enable')) {
			return;
		}
		if (!is_front_page() && get_theme_mod('p3_feature_header_home', 1)) {
			return;
		}
		
		$post_cat_trending = get_theme_mod('p3_feature_header_trending_cat');
		$post_cat_slider = get_theme_mod('p3_feature_header_slider_cat');
		$big_this_month_title = strip_tags(get_theme_mod('p3_feature_header_pop_title'));
		if (empty($big_this_month_title)) {
			$big_this_month_title = __('Big this Month', 'p3');
		}
		$recent_posts_title = strip_tags(get_theme_mod('p3_feature_header_slider_title'));
		if (empty($recent_posts_title)) {
			$recent_posts_title = __('Recent Posts', 'p3');
		}
		$date_range = get_theme_mod( 'p3_feature_header_trending_dates', '1 month ago' );
		$text_color = get_theme_mod('p3_feature_header_text_color', '#000');
		$text_bg_color = get_theme_mod('p3_feature_header_text_bg_color', '#fff');
		
		$truncate_title = absint(get_theme_mod('p3_feature_header_title_truncate', 7));
		
		wp_enqueue_script( 'pipdig-cycle' );
		?>
		<div id="p3_feature_header" class="row nopin">
			<style scoped>
				.cycle-slideshow {height: auto} .cycle-slideshow li{display:none}.cycle-slideshow li.first{display:block}
				#p3_feature_header .p3_trending_panel h4, #p3_feature_header .p3_feature_slide_banner, #p3_feature_header .p3_feature_slide_banner h2 {background:<?php echo esc_attr($text_bg_color); ?>;color:<?php echo esc_attr($text_color); ?>;}
			</style>
			<div id="p3_feature_header_big_this_month" class="col-sm-6">

				<div id="p3_big_this" class="nopin">
					<h3 class="widget-title"><span><?php echo $big_this_month_title; ?></span></h3>
					<?php
						$popular = new WP_Query( array(
							'cat'                   => $post_cat_trending,
							'showposts'             => 4,
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
						
						$this_post = $popular->current_post;

						$panel_margins = '';
						
						switch ($this_post) {
							case 0:
								$panel_margins = 'style="margin:0 .5% .5%"';
								break;
							case 1:
								$panel_margins = 'style="margin:0 .5% .5%"';
								break;
							case 2:
								$panel_margins = 'style="margin:.5% .5% 0"';
								break;
							case 3:
								$panel_margins = 'style="margin:.5% .5% 0"';
								break;
						}
						
						if(has_post_thumbnail()){
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_small' ); // 640 x 360
							$bg = esc_url($thumb['0']);
						} else {
							$bg = pipdig_p3_catch_that_image();
						}
					?>
					<div class="p3_trending_panel" <?php echo $panel_margins; ?>>
						<a href="<?php the_permalink() ?>">
							<div class="p3_slide_img" style="background-image:url(<?php echo $bg; ?>);">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
							</div>
							<h4><?php echo pipdig_p3_truncate(get_the_title(), $truncate_title); ?></h4>
						</a>
					</div>
					<?php endwhile;?>
					<div class="clearfix"></div>
				</div>
			</div>
			
			<div id="p3_feature_header_recent_posts" class="col-sm-6">
				<h3 class="widget-title"><span><?php echo $recent_posts_title; ?></span></h3>
				<div data-starting-slide="1" data-cycle-speed="1200" data-cycle-slides="li" data-cycle-manual-speed="700" class="cycle-slideshow nopin">
					<ul>
						<?php
							$args = array(
								'showposts' => 4,
								'cat' => $post_cat_slider,
							);
							$the_query = new WP_Query( $args );
								
							while ($the_query -> have_posts()) : $the_query -> the_post();

								if(has_post_thumbnail()){
									$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'p3_medium' ); // 800 x 450
									$bg = esc_url($thumb['0']);
								} else {
									$bg = pipdig_p3_catch_that_image();
								}
						?>
						<li>
							<div class="p3_slide_img" style="background-image:url(<?php echo $bg; ?>);">
								<div class="p3_feature_slide">
									<span class="p3_feature_slide_banner">
										<h2><?php echo pipdig_p3_truncate(get_the_title(), 12); ?></h2>
									</span>
									<a href="<?php the_permalink() ?>" style="display: block; width: 100%; height: 100%;">
										<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
									</a>
								</div>
							</div>
						</li>
					<?php endwhile;?>
					</ul>
					<div class='cycle-prev'></div>
					<div class='cycle-next'></div>
				</div>
			</div>
			
		</div>
	<?php
	}
	add_action('p3_top_site_main_container', 'p3_feature_header', 2);
}

// customiser
if (!class_exists('pipdig_feature_header_Customize')) {
	class pipdig_feature_header_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_feature_header_section', 
				array(
					'title' => __( 'Feature Header', 'p3' ),
					//'description'=> __( 'Display recent/popular posts at the top of your site.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 114,
				) 
			);
			
			// Enable feature
			$wp_customize->add_setting('p3_feature_header_enable',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_feature_header_enable',
				array(
					'type' => 'checkbox',
					'label' => __( 'Enable this feature', 'p3' ),
					'section' => 'p3_feature_header_section',
				)
			);
			
			// homepage only
			$wp_customize->add_setting('p3_feature_header_home',
				array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_feature_header_home',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display on homepage only', 'p3' ),
					'description' => '<hr>',
					'section' => 'p3_feature_header_section',
				)
			);

			// Date range for popular/trending posts
			$wp_customize->add_setting('p3_feature_header_trending_dates',
				array(
					'default' => '1 month ago',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control('p3_feature_header_trending_dates',
				array(
					'type' => 'select',
					'label' => __('Date range for "Big this Month":', 'p3'),
					'description' => __("This won't effect the Recent Posts section.", 'p3'),
					'section' => 'p3_feature_header_section',
					'choices' => array(
						'1 year ago' => __('1 Year', 'p3'),
						'1 month ago' => __('1 Month', 'p3'),
						'1 week ago' => __('1 Week', 'p3'),
						'' => __('All Time', 'p3'),
					),
				)
			);
			
			// Choose a category for trending
			$wp_customize->add_setting('p3_feature_header_trending_cat',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_feature_header_trending_cat',
					array(
						'label' => __('Category for "Big this Month":', 'p3'),
						'description' => __('Only display posts from:', 'p3'),
						'settings' => 'p3_feature_header_trending_cat',
						'section'  => 'p3_feature_header_section'
					)
				)
			);
			
			// Choose a category for slider
			$wp_customize->add_setting('p3_feature_header_slider_cat',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Category_Control(
					$wp_customize,
					'p3_feature_header_slider_cat',
					array(
						'label'    => __('Category for "Recent Posts":', 'p3'),
						'settings' => 'p3_feature_header_slider_cat',
						'section'  => 'p3_feature_header_section'
					)
				)
			);
			
			// title backgroud color
			$wp_customize->add_setting('p3_feature_header_text_bg_color',
				array(
					'default' => '#ffffff',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_feature_header_text_bg_color',
				array(
					'label' => __( 'Background color', 'p3' ),
					'settings' => 'p3_feature_header_text_bg_color',
					'section' => 'p3_feature_header_section',
				)
				)
			);
			
			// title color
			$wp_customize->add_setting('p3_feature_header_text_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_feature_header_text_color',
				array(
					'label' => __( 'Title color', 'p3' ),
					'settings' => 'p3_feature_header_text_color',
					'section' => 'p3_feature_header_section',
				)
				)
			);
			
			
			$wp_customize->add_setting('p3_feature_header_pop_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_feature_header_pop_title',
				array(
					'type' => 'text',
					'label' => __( '"Big this Month" title', 'p3' ),
					'section' => 'p3_feature_header_section',
					'input_attrs' => array(
					'placeholder' => __('Big this Month', 'p3'),
					),
				)
			);
			
			$wp_customize->add_setting('p3_feature_header_slider_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'p3_feature_header_slider_title',
				array(
					'type' => 'text',
					'label' => __( '"Recent Posts" title', 'p3' ),
					'section' => 'p3_feature_header_section',
					'input_attrs' => array(
					'placeholder' => __('Recent Posts', 'p3'),
					),
				)
			);
			
			// post title length
			$wp_customize->add_setting('p3_feature_header_title_truncate',
				array(
					'default' => 7,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_feature_header_title_truncate',
				array(
					'type' => 'number',
					'label' => __( 'Post title length (words)', 'p3' ),
					'section' => 'p3_feature_header_title_truncate',
					'input_attrs' => array(
						'min'   => 1,
						'max'   => 20,
						'step'  => 1,
						//'class' => 'test-class test',
						//'style' => 'color: #0a0',
					),
				)
			);


		}
	}
	add_action( 'customize_register' , array( 'pipdig_feature_header_Customize' , 'register' ) );
}
