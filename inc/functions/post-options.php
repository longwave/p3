<?php

if (!defined('ABSPATH')) die;

function p3_display_featured_image_in_post() {
	if (get_the_post_thumbnail() != '' && get_theme_mod('display_featured_image')) { // if thumbnail is set in post
	echo '<div style="text-align:center">';
		the_post_thumbnail();
	echo '</div>';
}

}
add_action('p3_content_start', 'p3_display_featured_image_in_post');

function p3_post_signature() {
	
	$links = get_option('pipdig_links');
	$twitter = $links['twitter'];
	$instagram = $links['instagram'];
	$facebook = $links['facebook'];
	$google = $links['google_plus'];
	$bloglovin = $links['bloglovin'];
	$pinterest = $links['pinterest'];
	$youtube = $links['youtube'];
	$tumblr = $links['tumblr'];
	$linkedin = $links['linkedin'];
	$soundcloud = $links['soundcloud'];
	$flickr = $links['flickr'];
	$snapchat = $links['snapchat'];
	
	?>
	<div class="pipdig-post-sig socialz nopin">
		<?php if(get_theme_mod('post_signature_image')) { ?>
			<img src="<?php echo esc_url(get_theme_mod('post_signature_image')); ?>" data-pin-nopin="true" alt="" />
		<?php } //endif ?>
		<?php if(get_theme_mod('p3_signature_socialz')){ ?>
			<h6><?php _e( 'Follow:', 'p3' ) ?></h6>
			<?php if($twitter) { ?><a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a> <?php } ?>
			<?php if($instagram) { ?><a href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a> <?php } ?>
			<?php if($facebook) { ?><a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a> <?php } ?>
			<?php if($google) { ?><a href="<?php echo esc_url($google); ?>" target="_blank"><i class="fa fa-google-plus"></i></a> <?php } ?>
			<?php if($bloglovin) { ?><a href="<?php echo esc_url($bloglovin); ?>" target="_blank"><i class="fa fa-plus"></i></a> <?php } ?>
			<?php if($pinterest) { ?><a href="<?php echo esc_url($pinterest); ?>" target="_blank"><i class="fa fa-pinterest"></i></a> <?php } ?>
			<?php if($youtube) { ?><a href="<?php echo esc_url($youtube); ?>" target="_blank"><i class="fa fa-youtube-play"></i></a> <?php } ?>
			<?php if($tumblr) { ?><a href="<?php echo esc_url($tumblr); ?>" target="_blank"><i class="fa fa-tumblr"></i></a> <?php } ?>
			<?php if($linkedin) { ?><a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a> <?php } ?>
			<?php if($soundcloud) { ?><a href="<?php echo esc_url($soundcloud); ?>" target="_blank"><i class="fa fa-soundcloud"></i></a> <?php } ?>
			<?php if($flickr) { ?><a href="<?php echo esc_url($flickr); ?>" target="_blank"><i class="fa fa-flickr"></i></a> <?php } ?>
			<?php if($snapchat) { ?><a href="<?php echo esc_url($snapchat); ?>" target="_blank"><i class="fa fa-snapchat-ghost"></i></a> <?php } ?>
		<?php } ?>
	</div>

	<?php
		
}
//add_action('p3_content_end', 'p3_post_signature');

// customiser
if (!class_exists('pipdig_p3_post_options_Customiser')) {
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
			/*
			// Show socialz in post signature?
			$wp_customize->add_setting('p3_signature_socialz',
				array(
					'default' => 0,
					'sanitize_callback' => 'absint',
				)
			);
			$wp_customize->add_control(
				'p3_signature_socialz',
				array(
					'type' => 'checkbox',
					'label' => __( 'Display social media follow icons', 'p3' ),
					'description' => 'Any links added to <a href="'.admin_url('admin.php?page=pipdig-links').'">this page</a> will be shown in the footer.',
					'section' => 'pipdig_posts',
				)
			);

			// Signature image
			$wp_customize->add_setting('post_signature_image',
				array(
					'sanitize_callback' => 'esc_url_raw',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'signature_image',
					array(
						'label' => __( 'Post signature image', 'p3' ),
						'description' => __( 'This image will be shown in the footer of your posts', 'p3' ),
						'section' => 'pipdig_posts',
						'settings' => 'post_signature_image',
					)
				)
			);
			*/

		}
	}
	add_action( 'customize_register' , array( 'pipdig_p3_post_options_Customiser' , 'register' ) );
}
