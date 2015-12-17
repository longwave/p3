<?php

if (!defined('ABSPATH')) {
	exit;
}

function pipdig_links_init() {

	register_setting('pipdig_links_options_page', 'pipdig_links');
	
	add_settings_section(
		'pipdig_links_options_page_section', 
		'',
		'pipdig_links_section_callback', 
		'pipdig_links_options_page'
	);
	
	add_settings_field( 
		'email', 
		'<i class="fa fa-envelope"></i>&nbsp;&nbsp;Email', 
		'p3_email_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'twitter', 
		'<i class="fa fa-twitter"></i>&nbsp;&nbsp;Twitter', 
		'p3_twitter_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'instagram', 
		'<i class="fa fa-instagram"></i>&nbsp;&nbsp;Instagram', 
		'p3_instagram_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'facebook', 
		'<i class="fa fa-facebook"></i>&nbsp;&nbsp;Facebook', 
		'p3_facebook_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'google_plus', 
		'<i class="fa fa-google-plus"></i>&nbsp;&nbsp;Google Plus', 
		'p3_google_plus_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'bloglovin', 
		'<i class="fa fa-plus"></i>&nbsp;&nbsp;Bloglovin&#146;', 
		'p3_bloglovin_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'pinterest', 
		'<i class="fa fa-pinterest"></i>&nbsp;&nbsp;Pinterest', 
		'p3_pinterest_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'youtube', 
		'<i class="fa fa-youtube-play"></i>&nbsp;&nbsp;YouTube', 
		'p3_youtube_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'tumblr', 
		'<i class="fa fa-tumblr"></i>&nbsp;&nbsp;Tumblr', 
		'p3_tumblr_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'linkedin', 
		'<i class="fa fa-linkedin"></i>&nbsp;&nbsp;LinkedIn', 
		'p3_linkedin_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'soundcloud', 
		'<i class="fa fa-soundcloud"></i>&nbsp;&nbsp;SoundCloud', 
		'p3_soundcloud_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'flickr', 
		'<i class="fa fa-flickr"></i>&nbsp;&nbsp;Flickr', 
		'p3_flickr_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'vk', 
		'<i class="fa fa-vk"></i>&nbsp;&nbsp;VK', 
		'p3_vk_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
}
add_action('admin_init', 'pipdig_links_init');

function p3_email_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='email' name='pipdig_links[email]' placeholder='yourname@gmail.com' value="<?php if (isset($links['email'])) { echo $links['email']; } ?>"> <?php
}

function p3_twitter_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[twitter]' placeholder='https://twitter.com/pipdig' value="<?php if (isset($links['twitter'])) { echo $links['twitter']; } ?>"> <?php
}

function p3_instagram_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[instagram]' placeholder='https://instagram.com/pipdig' value="<?php if (isset($links['instagram'])) { echo $links['instagram']; } ?>"> <?php
}

function p3_facebook_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[facebook]' placeholder='https://facebook.com/pipdig' value="<?php if (isset($links['facebook'])) { echo $links['facebook']; } ?>"> <?php
}

function p3_google_plus_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[google_plus]' placeholder='https://plus.google.com/+pipdig' value="<?php if (isset($links['google_plus'])) { echo $links['google_plus']; } ?>"> <?php
}

function p3_bloglovin_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[bloglovin]' placeholder='https://www.bloglovin.com/blogs/pipdig-3890264' value="<?php if (isset($links['bloglovin'])) { echo $links['bloglovin']; } ?>"> <?php
}

function p3_pinterest_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[pinterest]' placeholder='https://pinterest.com/pipdig' value="<?php if (isset($links['pinterest'])) { echo $links['pinterest']; } ?>"> <?php
}

function p3_youtube_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[youtube]' placeholder='https://www.youtube.com/user/pipdig' value="<?php if (isset($links['youtube'])) { echo $links['youtube']; } ?>"> <?php
}

function p3_tumblr_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[tumblr]' placeholder='https://pipdig.tumblr.com' value="<?php if (isset($links['tumblr'])) { echo $links['tumblr']; } ?>"> <?php
}

function p3_linkedin_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[linkedin]' placeholder='https://linkedin.com/pipdig' value="<?php if (isset($links['linkedin'])) { echo $links['linkedin']; } ?>"> <?php
}

function p3_soundcloud_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[soundcloud]' placeholder='https://soundcloud.com/pipdig' value="<?php if (isset($links['soundcloud'])) { echo $links['soundcloud']; } ?>"> <?php
}

function p3_flickr_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[flickr]' placeholder='https://flickr.com/pipdig' value="<?php if (isset($links['flickr'])) { echo $links['flickr']; } ?>"> <?php
}

function p3_vk_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[vk]' placeholder='https://vk.com/pipdig' value="<?php if (isset($links['vk'])) { echo $links['vk']; } ?>"> <?php
}


function pipdig_links_section_callback() { 
	// description text
	//pipdig_p3_scrapey_scrapes();
	$social_stats_page = admin_url('admin.php?page=pipdig-stats');
	echo '<p>'.__('Add the links to each social media page below:', 'p3').'</p>';
	printf(__('Any links added can then be used across your website, such as on <a href="%s">this page</a>.', 'p3'), $social_stats_page);
	
}




function pipdig_links_options_page() { 
	?>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<style scoped>
	.form-table th {width: 120px;}
	</style>
	<form action='options.php' method='post'>
			
		<h1>Social Media Links</h1>
			
		<?php
		settings_fields('pipdig_links_options_page');
		do_settings_sections('pipdig_links_options_page');
		submit_button();
		?>
			
	</form>
	<?php
}

add_action( 'update_option_pipdig_links', 'delete_p3_stats_gen', 10, 2 );

function delete_p3_stats_gen() {
	delete_transient('p3_stats_gen');
}
