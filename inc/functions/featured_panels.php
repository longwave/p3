<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

if (p3_theme_enabled(array('hollyandweave', 'equinox', 'opulence', 'galvani'))) {
	
} else {
	return;
}

if (!function_exists('p3_featured_panels')) {
	function p3_featured_panels() {
		
		if (!is_home() && !is_front_page()) {
			return;
		}
		
		if (!get_theme_mod('p3_featured_panels_enable', p3_theme_enabled(array('hollyandweave', 'opulence')))) {
			return;
		}
		
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAGQAQMAAABI+4zbAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADRJREFUeNrtwQENAAAAwiD7p7bHBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgKQDdsAAAWZeCiIAAAAASUVORK5CYII='; // landscape
		
		$image_shape = get_theme_mod('p3_featured_panels_shape');
		
		if ($image_shape == 2) {
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
		} elseif ($image_shape == 3) {
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
		}
		
			$img_1 = $title_1 = $link_1 = $img_2 = $title_2 = $link_2 = $img_3 = $title_3 = $link_3 = '';
			
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
			
			$img_1 = get_theme_mod('p3_featured_panels_1_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
			$title_1 = get_theme_mod('p3_featured_panels_1_title', $default_title);
			$link_1 = get_theme_mod('p3_featured_panels_1_link', $default_link);
			
			$img_2 = get_theme_mod('p3_featured_panels_2_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
			$title_2 = get_theme_mod('p3_featured_panels_2_title', $default_title);
			$link_2 = get_theme_mod('p3_featured_panels_2_link', $default_link);
			
			$img_3 = get_theme_mod('p3_featured_panels_3_img', 'https://pipdigz.co.uk/p3/img/catch-placeholder.jpg');
			$title_3 = get_theme_mod('p3_featured_panels_3_title', $default_title);
			$link_3 = get_theme_mod('p3_featured_panels_3_link', $default_link);
			
			$sm = 'sm';
			if (get_theme_mod('disable_responsive')) {
				$sm = 'xs';
			}
			
			if ($show) {
			?>
			<div id="p3_featured_panels" class="row nopin">
				
				<?php if ($img_1 && $title_1 && $link_1) { ?>
				<div class="col-<?php echo $sm; ?>-4 p3_featured_panel">
					<a href="<?php echo esc_url($link_1); ?>">
						<div class="p3_cover_me" style="background-image:url(<?php echo esc_url($img_1); ?>)">
							<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_1); ?>" class="p3_invisible" />
						</div>
						<div class='p3_feature_panel_overlay'>
							<h3><?php echo esc_html($title_1); ?></h3>
						</div>
					</a>
				</div>
				<?php } ?>

				<?php if ($img_2 && $title_2 && $link_2) { ?>
				<div class="col-<?php echo $sm; ?>-4 p3_featured_panel">
					<a href="<?php echo esc_url($link_2); ?>">
						<div class="p3_cover_me" style="background-image:url(<?php echo esc_url($img_2); ?>)">
							<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_2); ?>" class="p3_invisible" />
						</div>
						<div class='p3_feature_panel_overlay'>
							<h3><?php echo esc_html($title_2); ?></h3>
						</div>
					</a>
				</div>
				<?php } ?>
				
				<?php if ($img_3 && $title_3 && $link_3) { ?>
				<div class="col-<?php echo $sm; ?>-4 p3_featured_panel">
					<a href="<?php echo esc_url($link_3); ?>">
						<div class="p3_cover_me" style="background-image:url(<?php echo esc_url($img_3); ?>)">
							<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title_3); ?>" class="p3_invisible" />
						</div>
						<div class='p3_feature_panel_overlay'>
							<h3><?php echo esc_html($title_3); ?></h3>
						</div>
					</a>
				</div>
				<?php } ?>
				
				<div class="clearfix"></div>

			</div>
			<?php
			} // endif $show
	}
	add_action('p3_top_site_main_container', 'p3_featured_panels', 4);
}

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
if (!class_exists('pipdig_p3_featured_panels_Customize')) {
	class pipdig_p3_featured_panels_Customize {
		
		public static function register ( $wp_customize ) {
			
			$wp_customize->add_section( 'p3_featured_panels_section', 
				array(
					'title' => __( 'Featured Image Panels', 'p3' ),
					'description'=> __( 'Display 3 image panels at te top of the homepage. Each panel can also be linked to anywhere you like. E.g. a post, category, page or even an external website.', 'p3' ),
					'capability' => 'edit_theme_options',
					//'panel' => 'pipdig_features',
					'priority' => 59,
				) 
			);
			
			// Enable feature
			$wp_customize->add_setting('p3_featured_panels_enable',
				array(
					'default' => p3_theme_enabled(array('hollyandweave', 'opulence')),
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
			
			for ($x = 1; $x <= 3; $x++) {
			
			// Image 1
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
			
			// Title 1
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
					'label' => 'Panel #'.$x.' Title Text field',
					'section' => 'p3_featured_panels_section'
				)
			);
			
			// Link 1
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

	
		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_featured_panels_Customize' , 'register' ) );
}
