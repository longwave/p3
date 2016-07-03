<?php
/**
 * Template Name: Image Gallery
 */
 
get_header();

wp_enqueue_script( 'masonry' );

$images = '';
if (function_exists('rwmb_meta')) {
	$images = rwmb_meta( 'pipdig_meta_gallery_images', 'type=image&size=full' );
}
?>

	<div id="" class="row">
		<div class="col-xs-12 content-area nopin" role="main">

		<?php if ($images) { ?>

			<div class="grid p3_grid_mosaic">
			
				<?php foreach ($images as $image) { ?>
				
					<div class="pipdig-masonry-post grid-item">
						<a href="<?php echo esc_url($image['url']); ?>" title="<?php echo esc_attr($image['title']); ?>" data-imagelightbox="g">
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>" />
						</a>
					</div>
					
				<?php } ?>
				
			</div>
			
		<?php } else { ?>

			No Images

		<?php } ?>

		<div class="clearfix"></div>

		</div><!-- .content-area -->
	</div>

<?php get_footer(); ?>