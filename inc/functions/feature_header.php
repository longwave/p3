<?php 

if (!defined('ABSPATH')) die;

function p3_feature_header() {
	
	if (!get_theme_mod('p3_feature_header_enable')) {
		return;
	}
	if (!is_front_page() && get_theme_mod('p3_feature_header_home', 1)) {
		return;
	}
	
	$class_1 = 'col-sm-6';
	$class_2 = 'col-sm-6';
	
	if (get_theme_mod('p3_feature_header_swap')) {
		$class_1 = 'col-sm-6 col-sm-push-6';
		$class_2 = 'col-sm-6 col-sm-pull-6';
	}
	
	$post_cat_trending = absint(get_theme_mod('p3_feature_header_trending_cat'));
	$post_cat_slider = intval(get_theme_mod('p3_feature_header_slider_cat'));
	$big_this_month_title = strip_tags(get_theme_mod('p3_feature_header_pop_title'));
	if (empty($big_this_month_title)) {
		$big_this_month_title = __('Big this Month', 'p3');
	}
	$recent_posts_title = strip_tags(get_theme_mod('p3_feature_header_slider_title'));
	if (empty($recent_posts_title)) {
		$recent_posts_title = __('Recent Posts', 'p3');
	}
	$date_range = get_theme_mod('p3_feature_header_trending_dates', '3 months ago');
	$text_color = strip_tags(get_theme_mod('p3_feature_header_text_color', '#000'));
	$text_bg_color = strip_tags(get_theme_mod('p3_feature_header_text_bg_color', '#fff'));
	
	$truncate_title = absint(get_theme_mod('p3_feature_header_title_truncate', 7));
	
	wp_enqueue_script( 'jquery-cycle' );
	?>
	<div id="p3_feature_header" class="row nopin">
		<style scoped>
			.feature-header-cycle {height: auto} .cycle-slideshow li{display:none}.cycle-slideshow li.first{display:block}
			#p3_feature_header .p3_trending_panel h4, #p3_feature_header .p3_feature_slide_banner, #p3_feature_header .p3_feature_slide_banner h2 {background:<?php echo esc_attr($text_bg_color); ?>;color:<?php echo esc_attr($text_color); ?>;}
		</style>
		<div id="p3_feature_header_big_this_month" class="<?php echo $class_1; ?>">

			<div id="p3_big_this" class="nopin">
				<h3 class="widget-title"><span><?php echo $big_this_month_title; ?></span></h3>
				<?php
			
				$traditional = true;
				$jp_top_posts = '';
				$trans_prefix = 'all';
				if (function_exists('stats_get_csv') && !$post_cat_trending) {
					
					if ($date_range == '1 week ago') {
						$days = '7';
						$trans_prefix = $days;
					} elseif ($date_range == '1 month ago') {
						$days = '30';
						$trans_prefix = $days;
					} elseif ($date_range == '3 months ago') {
						$days = '90';
						$trans_prefix = $days;
					} elseif ($date_range == '6 months ago') {
						$days = '180';
						$trans_prefix = $days;
					} elseif ($date_range == '1 year ago') {
						$days = '365';
						$trans_prefix = $days;
					} else {
						$days = '-1';
					}
					
					if ( false === ( $post_view_ids = get_transient( 'p3_jp_pop_days_'.$trans_prefix ) )) {
						$jp_top_posts = stats_get_csv( 'postviews', array( 'days' => $days, 'limit' => 500 ) );
						$post_view_ids = wp_list_pluck($jp_top_posts, 'post_id');
						set_transient( 'p3_jp_pop_days_'.$trans_prefix, $post_view_ids, 30 * MINUTE_IN_SECONDS );
					}
					
					if (is_array($post_view_ids) && count($post_view_ids) > 4) {
						
						$args = array(
							'ignore_sticky_posts' => true,
							'showposts' => 4,
							'post__in' => $post_view_ids
						);
						
						$traditional = false;
						
					}
					
				}
					
				if ($traditional) {
					$args = array(
						'cat' => $post_cat_trending,
						'showposts' => 4,
						'ignore_sticky_posts' => true,
						'orderby' => 'comment_count',
						'order' => 'dsc',
						'date_query' => array(
							array(
								'after' => $date_range,
							),
						),
					);
				}
				
				$popular = new WP_Query($args);
				
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
					
					$bg = p3_catch_image(get_the_ID(), 'p3_medium');
				?>
				<div class="p3_trending_panel" <?php echo $panel_margins; ?>>
					<a href="<?php the_permalink() ?>">
						<div class="p3_cover_me" style="background-image:url(<?php echo $bg; ?>);">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
						</div>
						<h4 class="p_post_titles_font"><?php echo pipdig_p3_truncate(get_the_title(), $truncate_title); ?></h4>
					</a>
				</div>
				<?php endwhile; ?>
				<div class="clearfix"></div>
			</div>
		</div>
			
		<div id="p3_feature_header_recent_posts" class="<?php echo $class_2; ?>">
			<h3 class="widget-title"><span><?php echo $recent_posts_title; ?></span></h3>
			<div data-starting-slide="1" data-cycle-speed="1300" data-cycle-slides="li" data-cycle-manual-speed="700" class="cycle-slideshow feature-header-cycle nopin">
				<ul>
					<?php
						$args = array(
							'showposts' => absint(get_theme_mod('p3_feature_header_slider_num', 4)),
							'cat' => $post_cat_slider,
						);
						$the_query = new WP_Query( $args );
						
						while ($the_query -> have_posts()) : $the_query -> the_post();

							$bg = p3_catch_image(get_the_ID(), 'p3_medium');
							?>
							<li>
								<div class="p3_cover_me" style="background-image:url(<?php echo $bg; ?>);">
									<div class="p3_feature_slide">
										<span class="p3_feature_slide_banner">
											<h2 class="p_post_titles_font"><?php echo pipdig_p3_truncate(get_the_title(), 12); ?></h2>
										</span>
										<a href="<?php the_permalink() ?>" style="display: block; width: 100%; height: 100%;">												<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAAHCAQMAAAAtrT+LAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAENJREFUeNrtwYEAAAAAw6D7U19hANUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIDsYoAAZ9qTLEAAAAASUVORK5CYII=" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
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


// customiser
class pipdig_feature_header_Customize {
	
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_section( 'p3_feature_header_section', 
			array(
				'title' => __( 'Feature Header', 'p3' ),
				'description'=> __( 'Display recent/popular posts at the top of your site.', 'p3' ).' <a href="https://support.pipdig.co/articles/wordpress-feature-header/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
				'capability' => 'edit_theme_options',
				//'panel' => 'pipdig_features',
				'priority' => 58,
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
				//'description' => '<hr>',
				'section' => 'p3_feature_header_section',
			)
		);
		
		// swap sides
		$wp_customize->add_setting('p3_feature_header_swap',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_feature_header_swap',
			array(
				'type' => 'checkbox',
				'label' => __( 'Switch sides', 'p3' ),
				'description' => '<hr style="margin-top: 20px;">',
				'section' => 'p3_feature_header_section',
			)
		);
		
		// Date range for popular/trending posts
		$wp_customize->add_setting('p3_feature_header_trending_dates',
			array(
				'default' => '3 months ago',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control('p3_feature_header_trending_dates',
			array(
				'type' => 'select',
				'label' => __('Date range for "Big this Month":', 'p3'),
				'section' => 'p3_feature_header_section',
				'choices' => array(
					'1 week ago' => __('1 Week', 'p3'),
					'1 month ago' => __('1 Month', 'p3'),
					'3 months ago' => __('3 Months', 'p3'),
					'6 months ago' => __('6 Months', 'p3'),
					'1 year ago' => __('1 Year', 'p3'),
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
			
		// number of slides
		$wp_customize->add_setting('p3_feature_header_slider_num',
			array(
				'default' => 4,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_feature_header_slider_num',
			array(
				'type' => 'number',
				'label' => __( 'Number of slides for "Recent Posts"', 'p3' ),
				'section' => 'p3_feature_header_section',
				'input_attrs' => array(
					'min' => 2,
					'max' => 10,
					'step' => 1,
				),
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
				'label' => __( 'Limit post title length (words)', 'p3' ),
				'section' => 'p3_feature_header_section',
				'input_attrs' => array(
					'min' => 1,
					'max' => 20,
					'step' => 1,
					//'class' => 'test-class test',
					//'style' => 'color: #0a0',
				),
			)
		);
	}
}
add_action('customize_register', array('pipdig_feature_header_Customize', 'register'));