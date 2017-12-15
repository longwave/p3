<?php
if (!defined('ABSPATH')) die;

function p3_display_featured_image_in_post() {
	if (get_theme_mod('display_featured_image')) {
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		if ($thumb) { // if thumbnail is set in post
			$img = esc_url($thumb['0']);
			echo '<img src="'.$img.'" data-p3-pin-title="'.rawurldecode(get_the_title()).'" data-p3-pin-link="'.esc_url(get_the_permalink()).'" alt="'.esc_attr(get_the_title()).'" class="aligncenter" />';
		}
	}
}
add_action('p3_content_start', 'p3_display_featured_image_in_post');

function p3_author_bio() {
	if (!get_theme_mod('p3_show_author_bio')) {
		return;
	}
	?>
	<div class="clearfix"></div>
	<div class="p3_author_bio">
		<?php echo get_avatar(get_the_author_meta('ID'), 200); ?>
		<div class="p3_author_name"><?php echo esc_html(get_the_author_meta('display_name')); ?></div>
		<?php echo wpautop(get_the_author_meta('description')); ?>
		<div class="clearfix"></div>
	</div>
	<?php
}
add_action('p3_content_end', 'p3_author_bio', 1);

// customiser
class pipdig_p3_post_options_Customiser {
	public static function register ( $wp_customize ) {
		
		$wp_customize->add_section( 'pipdig_posts', 
			array(
				'title' => __( 'Blog Post Options', 'p3' ),
				'priority' => 70,
				'capability' => 'edit_theme_options',
			) 
		);
			
		// add featurd image to post
		$wp_customize->add_setting('display_featured_image',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'display_featured_image',
			array(
				'type' => 'checkbox',
				'label' => __( 'Add Featured Image to content', 'p3' ),
				'description' => __( 'Select this option to display the selected Featured Image at the top of the post.', 'p3' ),
				'section' => 'pipdig_posts',
			)
		);
			
		// Show author bio
		$wp_customize->add_setting('p3_show_author_bio',
			array(
				'default' => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'p3_show_author_bio',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display author bio in the footer', 'p3' ),
				'description' => 'You can edit the description text and author name on <a href="'.admin_url('profile.php').'" target="_blank">this page</a>',
				'section' => 'pipdig_posts',
			)
		);

	}
}
add_action( 'customize_register' , array( 'pipdig_p3_post_options_Customiser' , 'register' ) );