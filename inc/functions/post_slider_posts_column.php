<?php

if (!defined('ABSPATH')) die;

if (p3_theme_enabled(array('galvani', 'opulence', 'thegrid', 'blossom', 'crystal', 'maryline', 'amethyst'))) {
	return;
}

function p3_post_slider_posts_column() {
		
	if (is_paged() || !is_home()) {
		return;
	}
		
	if (!get_theme_mod('p3_post_slider_posts_column_enable')) {
		return;
	}
		
	$text_color_out = '';
	$text_bg_color_out = '';
	$text_bg_color = get_theme_mod('p3_post_slider_posts_column_text_bg_color');
	if ($text_bg_color) {
		$text_bg_color_out = 'background:'.$text_bg_color.';';
	}
	$text_color = get_theme_mod('p3_post_slider_posts_column_text_color');
	if ($text_color) {
		$text_color_out = 'color:'.$text_color.';';
	}
	$posts_num = intval(get_theme_mod('p3_post_slider_posts_column_number', 4));
	$title_trunc = intval(get_theme_mod('p3_post_slider_posts_column_title_truncate', 6));
	
	$instagram_compensate = '';
	if (get_theme_mod('body_instagram')) {
		$instagram_compensate = 'style="margin-bottom: 0;"';
	}
		
	wp_enqueue_script( 'pipdig-cycle' );
		
?>
<div id="p3_post_slider_posts_column" class="row" <?php echo $instagram_compensate; ?>>
	<div class="col-xs-12">
		<style scoped>
			.cycle-slideshow {height: auto} .cycle-slideshow li{display:none;width:100%}.cycle-slideshow li.first{display:block}
		</style>
			<div data-cycle-speed="1200" data-cycle-slides="li" data-cycle-swipe="true" data-cycle-swipe-fx="scrollHorz" data-cycle-manual-speed="700" class="cycle-slideshow nopin">
				<ul>
					<?php
						$post_cat_slider = get_theme_mod('p3_post_slider_posts_column_cat');
						$args = array(
							'showposts' => $posts_num,
							'cat' => $post_cat_slider,
						);
						$the_query = new WP_Query( $args );
							
						while ($the_query -> have_posts()) : $the_query -> the_post();

							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
							if ($thumb) {
								$bg = esc_url($thumb['0']);
							} else {
								$bg = pipdig_p3_catch_that_image();
							}
					?>
					<li>
						<a href="<?php the_permalink() ?>" class="p3_slide_img" style="background-image:url(<?php echo $bg; ?>);">
						<?php if (get_theme_mod('p3_post_slider_posts_column_display_title', 6)) { ?>
							<div class="p3_feature_slide" style="<?php echo $text_bg_color_out; echo $text_color_out; ?>">
								<span class="p3_slide_banner" style="<?php echo $text_bg_color_out; echo $text_color_out; ?>">
									<h2 class="p_post_titles_font" style="margin:0;<?php echo $text_color_out; ?>"><?php echo pipdig_p3_truncate(get_the_title(), $title_trunc); ?></h2>
								</span>
							</div>
						<?php } ?>
						</a>
					</li>
				<?php endwhile; wp_reset_query(); ?>
				</ul>
				<div class='cycle-prev'></div>
				<div class='cycle-next'></div>
			</div>
	</div>
</div>
	
<div class="clearfix"></div>
	
	
<?php
}
add_action('p3_posts_column_start', 'p3_post_slider_posts_column');



// customiser
class pipdig_post_slider_posts_column_Customize {
		
	public static function register ( $wp_customize ) {
			
		$wp_customize->add_section( 'p3_post_slider_posts_column_section', 
			array(
				'title' => __( 'Small Posts Slider', 'p3' ),
				'description'=> 'Display a slidre of recent posts at the top of your homepage posts section. Works best when there is also a sidebar on the homepage.',
				'capability' => 'edit_theme_options',
				//'panel' => 'pipdig_features',
				'priority' => 51,
			) 
		);
			
		// Enable feature
		$wp_customize->add_setting('p3_post_slider_posts_column_enable',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_post_slider_posts_column_enable',
			array(
				'type' => 'checkbox',
				'label' => __( 'Enable this feature', 'p3' ),
				'section' => 'p3_post_slider_posts_column_section',
			)
		);
			
		
		// Choose a category for slider
		$wp_customize->add_setting('p3_post_slider_posts_column_cat',
			array(
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Category_Control(
				$wp_customize,
				'p3_post_slider_posts_column_cat',
				array(
					'label'    => __('Display posts from:', 'p3'),
					'settings' => 'p3_post_slider_posts_column_cat',
					'section'  => 'p3_post_slider_posts_column_section'
				)
			)
		);
			
		// number of slides
		$wp_customize->add_setting('p3_post_slider_posts_column_number',
			array(
				'default' => 4,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_post_slider_posts_column_number',
			array(
				'type' => 'number',
				'label' => __( 'Number of posts', 'p3' ),
				'section' => 'p3_post_slider_posts_column_section',
				'input_attrs' => array(
					'min'   => 1,
					'max'   => 6,
					'step'  => 1,
					//'class' => 'test-class test',
					//'style' => 'color: #0a0',
				),
			)
		);
			
		// Enable feature
		$wp_customize->add_setting('p3_post_slider_posts_column_display_title',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_post_slider_posts_column_display_title',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display post title', 'p3' ),
				'section' => 'p3_post_slider_posts_column_section',
			)
		);
			
		// post title length
		$wp_customize->add_setting('p3_post_slider_posts_column_title_truncate',
			array(
				'default' => 6,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_post_slider_posts_column_title_truncate',
			array(
				'type' => 'number',
				'label' => __( 'Post title length (words)', 'p3' ),
				'section' => 'p3_post_slider_posts_column_section',
				'input_attrs' => array(
					'min'   => 1,
					'max'   => 20,
					'step'  => 1,
					//'class' => 'test-class test',
					//'style' => 'color: #0a0',
				),
			)
		);
		
		// title backgroud color
		$wp_customize->add_setting('p3_post_slider_posts_column_text_bg_color',
			array(
				'default' => '#ffffff',
				//'transport'=>'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_post_slider_posts_column_text_bg_color',
			array(
				'label' => __( 'Background color', 'p3' ),
				'settings' => 'p3_post_slider_posts_column_text_bg_color',
				'section' => 'p3_post_slider_posts_column_section',
			)
			)
		);
			
		// title color
		$wp_customize->add_setting('p3_post_slider_posts_column_text_color',
			array(
				'default' => '#000000',
				//'transport'=>'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_post_slider_posts_column_text_color',
			array(
				'label' => __( 'Title color', 'p3' ),
				'settings' => 'p3_post_slider_posts_column_text_color',
				'section' => 'p3_post_slider_posts_column_section',
			)
			)
		);


	}
}
add_action( 'customize_register' , array( 'pipdig_post_slider_posts_column_Customize' , 'register' ) );