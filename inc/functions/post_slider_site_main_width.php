<?php

if (!defined('ABSPATH')) die;

if (p3_theme_enabled(array('hollyandweave', 'crystal', 'galvani', 'blossom', 'willow'))) {
	return;
}

function p3_full_width_slider_site_main() {
	
	if (!get_theme_mod('p3_full_width_slider_site_main_enable', p3_theme_enabled(array('opulence')))) {
		return;
	}
	if (!is_front_page() && get_theme_mod('p3_full_width_slider_site_main_home', 1)) {
		return;
	}
	$text_color_out = '';
	$text_bg_color_out = '';
	$text_bg_color = get_theme_mod('p3_full_width_slider_site_main_text_bg_color');
	if ($text_bg_color) {
		$text_bg_color_out = 'background:'.sanitize_hex_color($text_bg_color).';';
	}
	$text_color = get_theme_mod('p3_full_width_slider_site_main_text_color');
	if ($text_color) {
		$text_color_out = 'color:'.sanitize_hex_color($text_color).';';
	}
	
	$num_posts = absint(get_theme_mod('p3_full_width_slider_site_main_slider_num', 4));
	$post_cat = get_theme_mod('p3_full_width_slider_site_main_slider_cat');
	
	$args = array(
		'showposts' => $num_posts,
	);
	
	if ($post_cat) {
		$args['cat'] = $post_cat;
	}
	
	$the_query = new WP_Query( $args );
	if (!$the_query->have_posts()){
		return;
	}
	wp_enqueue_script( 'pipdig-cycle' );
?>
<div id="p3_full_width_slider_site_main" class="row">
	<div class="col-xs-12">
		<style scoped>
			.cycle-slideshow {height: auto} .cycle-slideshow li{display:none;width:100%}.cycle-slideshow li.first{display:block}
		</style>
		<div data-cycle-speed="1200" data-cycle-slides="li" data-cycle-manual-speed="700" class="cycle-slideshow nopin">
			<ul>
				<?php					
				while ($the_query -> have_posts()) : $the_query -> the_post();

					$images = '';
					if (function_exists('rwmb_meta')) {
						$images = rwmb_meta( 'pipdig_meta_rectangle_slider_image', 'type=image&size=full' );
					}
					if ($images){
						foreach ( $images as $image ) {
							$bg = esc_url($image['url']);
						}
					} else {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
						if ($thumb) {
							$bg = esc_url($thumb['0']);
						} else {
							$bg = pipdig_catch_that_image();
						}
					}
				?>
				<li>
					<a href="<?php the_permalink() ?>" class="p3_slide_img" style="background-image:url(<?php echo $bg; ?>);">
						<div class="p3_feature_slide" style="<?php echo $text_bg_color_out; echo $text_color_out; ?>">
							<span class="p3_slide_banner" style="<?php echo $text_bg_color_out; echo $text_color_out; ?>">
								<h2 class="p_post_titles_font" style="<?php echo $text_color_out; ?>"><?php echo pipdig_p3_truncate(get_the_title(), 15); ?></h2>
							</span>
						</div>
					</a>
				</li>
			<?php endwhile; wp_reset_query(); ?>
			</ul>
			<?php if ($num_posts > 1) { ?>
			<div class='cycle-prev'></div>
			<div class='cycle-next'></div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
}
add_action('p3_top_site_main_container', 'p3_full_width_slider_site_main', 1);


// add class to body for styling .p3_full_width_slider_site_main_home_false .site-main .container
function p3_full_width_slider_site_main_home_body_class($classes) {
	if (get_theme_mod('p3_full_width_slider_site_main_home', 1) == false) {
		return array_merge( $classes, array( 'p3_full_width_slider_site_main_home_false' ) );
	}
	return $classes;
}
add_filter( 'body_class', 'p3_full_width_slider_site_main_home_body_class' );


// customiser
class pipdig_full_width_slider_site_main_Customize {
	
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_section( 'p3_full_width_slider_site_main_section', 
			array(
				'title' => __( 'Large Rectangle Slider', 'p3' ),
				//'description'=> __( 'Display recent/popular posts at the top of your site.', 'p3' ),
				'capability' => 'edit_theme_options',
				//'panel' => 'pipdig_features',
				'priority' => 52,
			) 
		);
			
		// Enable feature
		$wp_customize->add_setting('p3_full_width_slider_site_main_enable',
			array(
				'default' => p3_theme_enabled(array('opulence')),
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_full_width_slider_site_main_enable',
			array(
				'type' => 'checkbox',
				'label' => __( 'Enable this feature', 'p3' ),
				'section' => 'p3_full_width_slider_site_main_section',
			)
		);
			
		// homepage only
		$wp_customize->add_setting('p3_full_width_slider_site_main_home',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_full_width_slider_site_main_home',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display on homepage only', 'p3' ),
				'description' => '<hr>',
				'section' => 'p3_full_width_slider_site_main_section',
			)
		);
			
			
		// Number of images to display in slider
		$wp_customize->add_setting('p3_full_width_slider_site_main_slider_num',
			array(
				'default' => 4,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_full_width_slider_site_main_slider_num',
			array(
				'type' => 'number',
				'label' => __('Number of posts to show in the slider', 'p3'),
				'section' => 'p3_full_width_slider_site_main_section',
			)
		);
			
		// Choose a category for slider
		$wp_customize->add_setting('p3_full_width_slider_site_main_slider_cat',
			array(
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_full_width_slider_site_main_slider_cat',
			array(
				'type' => 'select',
				'label' => __('Only include posts from:', 'p3'),
				'section' => 'p3_full_width_slider_site_main_section',
				'choices' => p3_get_cats(),
			)
		);
		
		// title backgroud color
		$wp_customize->add_setting('p3_full_width_slider_site_main_text_bg_color',
			array(
				'default' => '#ffffff',
				//'transport'=>'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_full_width_slider_site_main_text_bg_color',
			array(
				'label' => __( 'Background color', 'p3' ),
				'settings' => 'p3_full_width_slider_site_main_text_bg_color',
				'section' => 'p3_full_width_slider_site_main_section',
			)
			)
		);
			
		// title color
		$wp_customize->add_setting('p3_full_width_slider_site_main_text_color',
			array(
				'default' => '#000000',
				//'transport'=>'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_full_width_slider_site_main_text_color',
			array(
				'label' => __( 'Title color', 'p3' ),
				'settings' => 'p3_full_width_slider_site_main_text_color',
				'section' => 'p3_full_width_slider_site_main_section',
			)
			)
		);

	}
}
add_action('customize_register', array('pipdig_full_width_slider_site_main_Customize', 'register'));