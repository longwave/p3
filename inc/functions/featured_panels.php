<?php 

if (!defined('ABSPATH')) die;

/*
if (p3_theme_enabled(array('hollyandweave', 'equinox', 'opulence', 'galvani', 'blossom', 'maryline', 'venture', 'styleandlight', 'firefly', 'arubanights', 'sartorial', 'etoile', 'tundra', 'lavoie'))) {
	
} else {
	return;
}
*/

// Deal with Polylang differently
// https://wordpress.org/support/topic/polylang-and-wp-customizer-options/
// https://theme.co/apex/forums/topic/how-to-translate-footer-content-in-customizer/#post-62545
function p3_featured_panels_polylang() {
	if (function_exists('pll_register_string')) { // needs to be inside function
		pll_register_string('Featured Panel 1 Title', get_theme_mod('p3_featured_panels_1_title'), true);
		pll_register_string('Featured Panel 2 Title', get_theme_mod('p3_featured_panels_2_title'), true);
		pll_register_string('Featured Panel 3 Title', get_theme_mod('p3_featured_panels_3_title'), true);
		pll_register_string('Featured Panel 4 Title', get_theme_mod('p3_featured_panels_4_title'), true);
		pll_register_string('Featured Panel 1 Link', get_theme_mod('p3_featured_panels_1_link'), true);
		pll_register_string('Featured Panel 2 Link', get_theme_mod('p3_featured_panels_2_link'), true);
		pll_register_string('Featured Panel 3 Link', get_theme_mod('p3_featured_panels_3_link'), true);
		pll_register_string('Featured Panel 4 Link', get_theme_mod('p3_featured_panels_4_link'), true);
	}
}
add_action( 'after_setup_theme', 'p3_featured_panels_polylang', 9999);

function p3_featured_panels() {
	
	if (!get_theme_mod('p3_featured_panels_enable', p3_theme_enabled(array('hollyandweave')))) {
		return;
	}
	
	if (!is_front_page() && get_theme_mod('p3_featured_panels_homepage', 1)) {
		return;
	}
	
	$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII='; // landscape
	
	$image_shape = get_theme_mod('p3_featured_panels_shape');
	
	if ($image_shape == 2) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
	} elseif ($image_shape == 3) {
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
	}
	
	$img_1 = $title_1 = $link_1 = $img_2 = $title_2 = $link_2 = $img_3 = $title_3 = $link_3 = $img_4 = $title_4 = $link_4 = '';
	
	$show = true;
	
	if (is_customize_preview()) {
		$default_link = 'https://www.pipdig.co';
		$default_title = 'Title Text';
	} else {
		if (current_user_can('manage_options')) {
			$default_link = admin_url('customize.php?autofocus[section]=p3_featured_panels_section');
			$default_title = 'Click here to edit';
		} else {
			$default_link = 'https://www.pipdig.co';
			$default_title = 'Title Text';
			if (!get_theme_mod('p3_featured_panels_1_img')) {
				$show = false;
			}
		}
	}
	
	// Polylang
	if (function_exists('pll__')) {
		$title_1 = pll__(get_theme_mod('p3_featured_panels_1_title', $default_title));
		$title_2 = pll__(get_theme_mod('p3_featured_panels_2_title', $default_title));
		$title_3 = pll__(get_theme_mod('p3_featured_panels_3_title', $default_title));
		$title_4 = pll__(get_theme_mod('p3_featured_panels_4_title', $default_title));
		$link_1 = pll__(get_theme_mod('p3_featured_panels_1_link', $default_link));
		$link_2 = pll__(get_theme_mod('p3_featured_panels_2_link', $default_link));
		$link_3 = pll__(get_theme_mod('p3_featured_panels_3_link', $default_link));
		$link_4 = pll__(get_theme_mod('p3_featured_panels_4_link', $default_link));
	} else {
		$title_1 = get_theme_mod('p3_featured_panels_1_title', $default_title);
		$title_2 = get_theme_mod('p3_featured_panels_2_title', $default_title);
		$title_3 = get_theme_mod('p3_featured_panels_3_title', $default_title);
		$title_4 = get_theme_mod('p3_featured_panels_4_title', $default_title);
		$link_1 = get_theme_mod('p3_featured_panels_1_link', $default_link);
		$link_2 = get_theme_mod('p3_featured_panels_2_link', $default_link);
		$link_3 = get_theme_mod('p3_featured_panels_3_link', $default_link);
		$link_4 = get_theme_mod('p3_featured_panels_4_link', $default_link);
	}
	$img_1 = get_theme_mod('p3_featured_panels_1_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
	$img_2 = get_theme_mod('p3_featured_panels_2_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
	$img_3 = get_theme_mod('p3_featured_panels_3_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
	$img_4 = get_theme_mod('p3_featured_panels_4_img');
	
	$sm = 'sm';
	$col = '4';
	if (get_theme_mod('disable_responsive')) {
		$sm = 'xs';
	}
	
	$count = 0;
	if (!empty($img_1)) {
		$count++;
	}
	if (!empty($img_2)) {
		$count++;
	}
	if (!empty($img_3)) {
		$count++;
	}
	if (!empty($img_4)) {
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
	}
		
	$style = '';
	if (absint(get_theme_mod('p3_featured_panels_mobile'))) {
		$style = 'style="display:block"';
	}
	
	if ($show) {
		
		$bg_color = get_theme_mod('p3_featured_panels_bg_col');
		$title_color = get_theme_mod('p3_featured_panels_text_col');
		
		if ($bg_color) {
			$bg_color = 'border: 0; background: '.$bg_color.';';
		}
		
		if ($title_color) {
			$title_color = 'color: '.$title_color.';';
		}
		
		?>
		<div id="p3_featured_panels" class="row nopin" <?php echo $style; ?>>
			
			<?php if ($img_1 && $link_1) { ?>
			<div class="col-<?php echo $sm; ?>-<?php echo $col; ?> p3_featured_panel">
				<a href="<?php echo esc_url($link_1); ?>">
					<div class="p3_cover_me" style="background-image:url(<?php echo str_replace('http:', '', esc_url($img_1) ); ?>)">
						<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_1); ?>" class="p3_invisible" />
					</div>
					<?php if (!empty($title_1)) { ?>
					<div class="p3_feature_panel_overlay" style="<?php echo strip_tags($bg_color); ?>">
						<h3 style="<?php echo strip_tags($title_color); ?>"><?php echo strip_tags($title_1); ?></h3>
					</div>
					<?php } ?>
				</a>
			</div>
			<?php } ?>
			
			<?php if ($img_2 && $link_2) { ?>
			<div class="col-<?php echo $sm; ?>-<?php echo $col; ?> p3_featured_panel">
				<a href="<?php echo esc_url($link_2); ?>">
					<div class="p3_cover_me" style="background-image:url(<?php echo str_replace('http:', '', esc_url($img_2) ); ?>)">
						<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_2); ?>" class="p3_invisible" />
					</div>
					<?php if (!empty($title_2)) { ?>
					<div class="p3_feature_panel_overlay" style="<?php echo strip_tags($bg_color); ?>">
						<h3 style="<?php echo strip_tags($title_color); ?>"><?php echo strip_tags($title_2); ?></h3>
					</div>
					<?php } ?>
				</a>
			</div>
			<?php } ?>
			
			<?php if ($img_3 && $link_3) { ?>
			<div class="col-<?php echo $sm; ?>-<?php echo $col; ?> p3_featured_panel">
				<a href="<?php echo esc_url($link_3); ?>">
					<div class="p3_cover_me" style="background-image:url(<?php echo str_replace('http:', '', esc_url($img_3) ); ?>)">
						<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_3); ?>" class="p3_invisible" />
					</div>
					<?php if (!empty($title_3)) { ?>
					<div class="p3_feature_panel_overlay" style="<?php echo strip_tags($bg_color); ?>">
						<h3 style="<?php echo strip_tags($title_color); ?>"><?php echo strip_tags($title_3); ?></h3>
					</div>
					<?php } ?>
				</a>
			</div>
			<?php } ?>
			
			<?php if ($img_4 && $link_4) { ?>
			<div class="col-<?php echo $sm; ?>-<?php echo $col; ?> p3_featured_panel">
				<a href="<?php echo esc_url($link_4); ?>">
					<div class="p3_cover_me" style="background-image:url(<?php echo str_replace('http:', '', esc_url($img_4) ); ?>)">
						<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_4); ?>" class="p3_invisible" />
					</div>
					<?php if (!empty($title_4)) { ?>
					<div class="p3_feature_panel_overlay" style="<?php echo strip_tags($bg_color); ?>">
						<h3 style="<?php echo strip_tags($title_color); ?>"><?php echo strip_tags($title_4); ?></h3>
					</div>
					<?php } ?>
				</a>
			</div>
			<?php } ?>
				
			<div class="clearfix"></div>

		</div>
		<?php
		} // endif $show
}
add_action('p3_top_site_main_container', 'p3_featured_panels', 4);

function p3_featured_panels_customizer_styles() { ?>
    <style>
		#customize-control-p3_featured_panels_1_img, #customize-control-p3_featured_panels_2_img, #customize-control-p3_featured_panels_3_img, #customize-control-p3_featured_panels_4_img {
			margin-top: 20px;
			padding-top: 30px;
			border-top: 2px solid #bbb;
		}
    </style>
    <?php
}
add_action( 'customize_controls_print_styles', 'p3_featured_panels_customizer_styles', 999 );

// customiser
class pipdig_p3_featured_panels_Customize {
		
	public static function register ( $wp_customize ) {
			
		$wp_customize->add_section( 'p3_featured_panels_section', 
			array(
				'title' => __( 'Featured Image Panels', 'p3' ),
				'description'=> 'Display up to 4 image panels at the top of the homepage. Each panel can also be linked to anywhere you like. E.g. a post, category, page or even an external website. <a href="https://support.pipdig.co/articles/wordpress-featured-image-panels/?utm_source=wordpress&utm_medium=p3&utm_campaign=customizer" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a>.',
				'capability' => 'edit_theme_options',
				//'panel' => 'pipdig_features',
				'priority' => 59,
			) 
		);
			
		// Enable feature
		$wp_customize->add_setting('p3_featured_panels_enable',
			array(
				'default' => p3_theme_enabled(array('hollyandweave')),
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_enable',
			array(
				'type' => 'checkbox',
				'label' => __( 'Enable this feature', 'p3' ),
				'section' => 'p3_featured_panels_section',
			)
		);
			
		// on mobile?
		$wp_customize->add_setting('p3_featured_panels_mobile',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_mobile',
			array(
				'type' => 'checkbox',
				'label' => __( 'Enable on mobile', 'p3' ),
				'section' => 'p3_featured_panels_section',
			)
		);
		
		// homepage only?
		$wp_customize->add_setting('p3_featured_panels_homepage',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_homepage',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display on homepage only', 'p3' ),
				'section' => 'p3_featured_panels_section',
			)
		);
		
		// image shape
		$wp_customize->add_setting('p3_featured_panels_shape',
			array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control('p3_featured_panels_shape',
			array(
				'type' => 'select',
				'label' => __('Image shape', 'p3'),
				'section' => 'p3_featured_panels_section',
				'choices' => array(
					1 => 'Landscape',
					2 => 'Portait',
					3 => 'Square',
				),
			)
		);
		
		// Title background color
		$wp_customize->add_setting('p3_featured_panels_bg_col',
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_featured_panels_bg_col',
			array(
				'label' => 'Title background color',
				'section' => 'p3_featured_panels_section',
				'settings' => 'p3_featured_panels_bg_col',
			))
		);
		
		// Title text color
		$wp_customize->add_setting('p3_featured_panels_text_col',
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'p3_featured_panels_text_col',
			array(
				'label' => 'Title text color',
				'section' => 'p3_featured_panels_section',
				'settings' => 'p3_featured_panels_text_col',
			))
		);
		
		for ($x = 1; $x <= 3; $x++) {
		
		// Image
		$wp_customize->add_setting('p3_featured_panels_'.$x.'_img',
			array(
				'default' => 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'p3_featured_panels_'.$x.'_img',
					array(
						'label' => 'Panel #'.$x.' Image',
						'section' => 'p3_featured_panels_section',
						'settings' => 'p3_featured_panels_'.$x.'_img',
					)
				)
		);
			
		// Title
		$wp_customize->add_setting('p3_featured_panels_'.$x.'_title',
			array(
				'default' => 'Title text',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_'.$x.'_title',
			array(
				'type' => 'text',
				'label' => 'Panel #'.$x.' Title',
				'section' => 'p3_featured_panels_section'
			)
		);
			
		// Link
		$wp_customize->add_setting('p3_featured_panels_'.$x.'_link',
			array(
				'default' => 'https://www.pipdig.co',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_'.$x.'_link',
			array(
				'type' => 'text',
				'label' => 'Panel #'.$x.' Link',
				'section' => 'p3_featured_panels_section'
			)
		);
			
		} // close loop
			
		
		// Image 4
		$wp_customize->add_setting('p3_featured_panels_4_img',
			array(
				'default' => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'p3_featured_panels_4_img',
					array(
						'label' => 'Panel #4 Image',
						'section' => 'p3_featured_panels_section',
						'settings' => 'p3_featured_panels_4_img',
					)
				)
		);
			
		// Title 4
		$wp_customize->add_setting('p3_featured_panels_4_title',
			array(
				'default' => 'Title text',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_4_title',
			array(
				'type' => 'text',
				'label' => 'Panel #4 Title Text field',
				'section' => 'p3_featured_panels_section'
			)
		);
			
		// Link 4
		$wp_customize->add_setting('p3_featured_panels_4_link',
			array(
				'default' => 'https://www.pipdig.co',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'p3_featured_panels_4_link',
			array(
				'type' => 'text',
				'label' => 'Panel #4 Link',
				'section' => 'p3_featured_panels_section'
			)
		);

	
	}
}
add_action( 'customize_register' , array( 'pipdig_p3_featured_panels_Customize' , 'register' ) );