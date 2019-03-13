<?php

if (!defined('ABSPATH')) die;

function p3_schema_publisher() {
	
	// Don't do anything when using Yoast on a single post
	/*
	if (is_single() && defined('WPSEO_FILE')) {
		return;
	}
	*/

	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
	if ($thumb) {
		$thumb_src = esc_url($thumb['0']);
		$thumb_width = intval($thumb['1']);
		$thumb_height = intval($thumb['2']);
	} else {
		$thumb_src = 'https://pipdigz.co.uk/p3/img/placeholder-square.png';
		$thumb_width = 500;
		$thumb_height = 500;
	}
	
	$body = sanitize_text_field(get_the_excerpt());
	
	if (get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true)) {
		$excerpt = esc_attr(get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true));
	} else {
		$excerpt = $body;
	}
	
	?>
	<!--noptimize-->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org", 
		"@type": "BlogPosting",
		"headline": "<?php the_title_attribute(); ?>",
		"image": {
			"@type": "imageObject",
			"url": "<?php echo $thumb_src; ?>",
			"height": "<?php echo $thumb_height; ?>",
			"width": "<?php echo $thumb_width; ?>"
		},
		"publisher": {
			"@type": "Organization",
			"name": "<?php echo esc_attr(get_bloginfo('name')); ?>",
			"logo": {
				"@type": "imageObject",
				"url": "https://pipdigz.co.uk/p3/img/placeholder-publisher.png"
			}
		},
		"mainEntityOfPage": "<?php the_permalink(); ?>",
		"url": "<?php the_permalink(); ?>",
		"datePublished": "<?php the_date('Y-m-d'); ?>",
		"dateModified": "<?php the_modified_date('Y-m-d'); ?>",
		"description": "<?php echo $excerpt; ?>",
		"articleBody": "<?php echo $body; ?>",
		"author": {
			"@type": "Person",
			"name": "<?php esc_attr(the_author()); ?>"
		}
	}
	</script>
	<!--/noptimize-->
	<?php
}
add_action('p3_content_end', 'p3_schema_publisher');
add_action('p3_summary_end', 'p3_schema_publisher');

function p3_declare_custom_logo_support() {
	add_theme_support( 'custom-logo' );
}
add_action('after_setup_theme', 'p3_declare_custom_logo_support');