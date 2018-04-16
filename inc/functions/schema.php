<?php

if (!defined('ABSPATH')) die;

function p3_schema_publisher() {

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
	
	$excerpt = esc_attr(get_the_excerpt());
	
	?>
	<script type="application/ld+json">
	{
		"@context": "http://schema.org", 
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
		"articleBody": "<?php echo $excerpt; ?>",
		"author": {
			"@type": "Person",
			"name": "<?php esc_attr(the_author()); ?>"
		}
	}
	</script>
	<?php
}
add_action('p3_content_end', 'p3_schema_publisher');
add_action('p3_summary_end', 'p3_schema_publisher');

function p3_declare_custom_logo_support() {
	add_theme_support( 'custom-logo' );
}
add_action('after_setup_theme', 'p3_declare_custom_logo_support');

/*
	if ( get_theme_mod('custom_logo') ) {
		$logo = wp_get_attachment_image_src( get_theme_mod('custom_logo'), 'full' );
		$logo_src = esc_url($logo['0']);
		$logo_width = intval($logo['1']);
		$logo_height = intval($logo['2']);
	} else {
		$logo_src = 'https://pipdigz.co.uk/p3/img/placeholder-publisher.png';
		$logo_width = 600;
		$logo_height = 60;
	}
	?>
	<meta itemscope='itemscope' itemprop='mainEntityOfPage' itemType='https://schema.org/WebPage' itemid="<?php the_permalink(); ?>" content="<?php the_permalink(); ?>"/>
	<span style="display:none" class="vcard author show-author" style="display:none" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
		<span class="fn" itemprop="name"><?php the_author_posts_link(); ?></span>
	</span>
	<div style="display:none" itemprop="publisher" itemscope="itemscope" itemtype="https://schema.org/Organization">
		<div itemprop="logo" itemscope="itemscope" itemtype="https://schema.org/ImageObject">
			<img style="display:none" src="<?php echo $logo_src; ?>"/>
			<meta itemprop="url" content="<?php echo $logo_src; ?>"/>
			<meta itemprop="width" content="<?php echo $logo_width; ?>"/>
			<meta itemprop="height" content="<?php echo $logo_height; ?>"/>
		</div>
		<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo('name')); ?>"/>
	</div>
	<?php
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
	?>
	<div style="display:none" itemprop="image" itemscope="itemscope" itemtype="https://schema.org/ImageObject">
		<img style="display:none" src="<?php echo $thumb_src; ?>"/>
		<meta itemprop="url" content="<?php echo $thumb_src; ?>"/>
		<meta itemprop="width" content="<?php echo $thumb_width; ?>"/>
		<meta itemprop="height" content="<?php echo $thumb_height; ?>"/>
	</div>
	<meta itemprop="datePublished" content="<?php echo get_the_modified_date('Y-m-d'); ?>"/>
	<meta itemprop="dateModified" content="<?php echo get_the_date('Y-m-d'); ?>"/>
*/