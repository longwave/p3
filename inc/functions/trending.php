<?php 

if (!defined('ABSPATH')) die;

/*
$theme = get_option('pipdig_theme');
if ($theme == 'londoncalling') {
	return;
}
*/

function p3_trending_bar() {
		
	if (!get_theme_mod('p3_trending_bar_enable')) {
		return;
	}
	if (!is_front_page() && get_theme_mod('p3_trending_bar_home', 1)) {
		return;
	}
		
	$the_shape = absint(get_theme_mod('p3_trending_bar_shape'));
		
	$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC'; // landscape
		
	if ($the_shape == 2) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
	} elseif ($the_shape == 3) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
	}
		
	$truncate_title = absint(get_theme_mod('p3_trending_bar_title_truncate', 7));
		
	$popular_title = strip_tags(get_theme_mod('p3_trending_bar_slider_title'));
	if (empty($popular_title)) {
		$popular_title = __('Popular Posts', 'p3');
	}
	$post_cat_trending = get_theme_mod('p3_trending_bar_trending_cat');
	$big_this_month_title = get_theme_mod('p3_trending_bar_pop_title');
	$order_by = get_theme_mod( 'p3_trending_bar_orderby', 1 );
	$date_range = get_theme_mod( 'p3_trending_bar_trending_dates', '1 month ago' );
	$text_color = get_theme_mod('p3_trending_bar_text_color', '#000');
	$text_bg_color = get_theme_mod('p3_trending_bar_text_bg_color', '#fff');
		
	if ($order_by == 1) {
		$orderby = 'comment_count';
	} elseif ($order_by == 2) {
		$orderby = 'rand';
	} else {
		$orderby = 'date';
	}
		
	$overlay = '';
	if (!get_theme_mod('p3_trending_bar_overlay', 1)) {
		$overlay = 'position:relative';
	}
		
	?>
	<style scoped>
		#p3_trending_bar .p3_trending_panel h4 {background:<?php echo esc_attr($text_bg_color); ?>;color:<?php echo esc_attr($text_color); ?>;<?php echo $overlay; ?>}
	</style>
	<div id="p3_trending_bar" class="clearfix nopin">
			
		<div class="col-xs-12">

			<div id="p3_big_this" class="nopin">
				
				<h3 class="widget-title"><span><?php echo $popular_title; ?></span></h3>
					
				<?php
					$popular = new WP_Query( array(
						'cat'                   => $post_cat_trending,
						'showposts'             => 5,
						'ignore_sticky_posts'   => true,
						'orderby'               => $orderby,
						'order'                 => 'dsc',
						'date_query' => array(
							array(
								'after' => $date_range,
							),
						),
					) );
				?>
				<?php while ( $popular->have_posts() ): $popular->the_post();			
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
					if ($thumb) {
						$bg = esc_url($thumb['0']);
					} else {
						$bg = pipdig_p3_catch_that_image();
					}
					?>
					<div class="p3_trending_panel">
						<a href="<?php the_permalink() ?>">
							<div class="p3_cover_me" style="background-image:url(<?php echo $bg; ?>);">
								<img src="<?php echo $shape; ?>" alt="<?php the_title_attribute(); ?>" class="p3_invisible" data-pin-nopin="true"/>
							</div>
							<h4><?php echo pipdig_p3_truncate(get_the_title(), $truncate_title); ?></h4>
						</a>
					</div>
				<?php endwhile;?>

			</div>
		</div>
		
	</div>
<?php
}
add_action('p3_top_site_main_container', 'p3_trending_bar');

// customiser
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
			
		// image shape
		$wp_customize->add_setting('p3_trending_bar_shape',
			array(
				'default' => '1',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_trending_bar_shape',
			array(
				'type' => 'select',
				'label' => __('Image shape', 'p3'),
				'section' => 'pipdig_trending_section',
				'choices' => array(
					1 => 'Landscape',
					2 => 'Portait',
					3 => 'Square',
				),
			)
		);
			
		// popular or random
		$wp_customize->add_setting('p3_trending_bar_orderby',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_trending_bar_orderby',
			array(
				'type' => 'radio',
				'label' => __('Type of posts', 'p3'),
				'section' => 'pipdig_trending_section',
				'description' => __('If you use Disqus comments then you may need to change this to Random/Recent.', 'p3'),
				'choices' => array(
					1 => __('Popular', 'p3'),
					2 => __('Random', 'p3'),
					3 => __('Recent', 'p3'),
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
					'label' => __('Only include posts from:', 'p3'),
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
		
		// overlay title text?
		$wp_customize->add_setting('p3_trending_bar_overlay',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_trending_bar_overlay',
			array(
				'type' => 'checkbox',
				'label' => __( 'Overlay the post titles', 'p3' ),
				'section' => 'pipdig_trending_section',
			)
		);
		
		// post title length
		$wp_customize->add_setting('p3_trending_bar_title_truncate',
			array(
				'default' => 7,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_trending_bar_title_truncate',
			array(
				'type' => 'number',
				'label' => __( 'Post title length (words)', 'p3' ),
				'section' => 'pipdig_trending_section',
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
add_action( 'customize_register' , array( 'p3_trending_bar_Customize' , 'register' ) );