<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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
		'snapchat', 
		'<i class="fa fa-snapchat-ghost"></i>&nbsp;&nbsp;Snapchat', 
		'p3_snapchat_field_render', 
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
		'spotify', 
		'<i class="fa fa-spotify"></i>&nbsp;&nbsp;Spotify', 
		'p3_spotify_field_render', 
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
	
	add_settings_field( 
		'twitch', 
		'<i class="fa fa-twitch"></i>&nbsp;&nbsp;Twitch', 
		'p3_twitch_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'stumbleupon', 
		'<i class="fa fa-stumbleupon"></i>&nbsp;&nbsp;Stumbleupon', 
		'p3_stumbleupon_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'etsy', 
		'<i class="fa fa-etsy"></i>&nbsp;&nbsp;Etsy', 
		'p3_etsy_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
	add_settings_field( 
		'rss', 
		'<i class="fa fa-rss"></i>&nbsp;&nbsp;RSS Feed', 
		'p3_rss_field_render', 
		'pipdig_links_options_page', 
		'pipdig_links_options_page_section' 
	);
	
}
add_action('admin_init', 'pipdig_links_init');

function p3_email_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='email' name='pipdig_links[email]' placeholder='e.g. yourname@gmail.com' value="<?php if (isset($links['email'])) { echo $links['email']; } ?>"> <?php
}

function p3_twitter_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[twitter]' placeholder='e.g. https://twitter.com/pipdig' value="<?php if (isset($links['twitter'])) { echo $links['twitter']; } ?>"> <?php
}

function p3_instagram_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[instagram]' placeholder='e.g. https://instagram.com/pipdig' value="<?php if (isset($links['instagram'])) { echo $links['instagram']; } ?>"> <?php
}

function p3_facebook_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[facebook]' placeholder='e.g. https://facebook.com/pipdig' value="<?php if (isset($links['facebook'])) { echo $links['facebook']; } ?>"> <?php
}

function p3_google_plus_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[google_plus]' placeholder='e.g. https://plus.google.com/+pipdig' value="<?php if (isset($links['google_plus'])) { echo $links['google_plus']; } ?>"> <?php
}

function p3_bloglovin_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[bloglovin]' placeholder='e.g. https://www.bloglovin.com/blogs/pipdig-3890264' value="<?php if (isset($links['bloglovin'])) { echo $links['bloglovin']; } ?>"><br />
<div style="font-size: 90%;">Note: this should be a link to your Blog's Bloglovin profile. NOT your Bloglovin user profile. If the link includes the word "people" in it, then this is <b>not</b> the correct link.</div>	<?php
}

function p3_pinterest_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[pinterest]' placeholder='e.g. https://pinterest.com/pipdig' value="<?php if (isset($links['pinterest'])) { echo $links['pinterest']; } ?>"> <?php
}

function p3_snapchat_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[snapchat]' placeholder='e.g. https://www.snapchat.com/add/pipdig.co' value="<?php if (isset($links['snapchat'])) { echo $links['snapchat']; } ?>"> <?php
}

function p3_youtube_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[youtube]' placeholder='e.g. https://www.youtube.com/user/pipdig' value="<?php if (isset($links['youtube'])) { echo $links['youtube']; } ?>"> <?php
}

function p3_tumblr_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[tumblr]' placeholder='e.g. https://pipdig.tumblr.com' value="<?php if (isset($links['tumblr'])) { echo $links['tumblr']; } ?>"> <?php
}

function p3_linkedin_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[linkedin]' placeholder='e.g. https://linkedin.com/pipdig' value="<?php if (isset($links['linkedin'])) { echo $links['linkedin']; } ?>"> <?php
}

function p3_soundcloud_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[soundcloud]' placeholder='e.g. https://soundcloud.com/pipdig' value="<?php if (isset($links['soundcloud'])) { echo $links['soundcloud']; } ?>"> <?php
}

function p3_spotify_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[spotify]' placeholder='e.g. https://spotify.com/pipdig' value="<?php if (isset($links['spotify'])) { echo $links['spotify']; } ?>"> <?php
}

function p3_flickr_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[flickr]' placeholder='e.g. https://flickr.com/pipdig' value="<?php if (isset($links['flickr'])) { echo $links['flickr']; } ?>"> <?php
}

function p3_vk_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[vk]' placeholder='e.g. https://vk.com/pipdig' value="<?php if (isset($links['vk'])) { echo $links['vk']; } ?>"> <?php
}

function p3_twitch_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[twitch]' placeholder='e.g. https://twitch.tv/dansgaming' value="<?php if (isset($links['twitch'])) { echo $links['twitch']; } ?>"> <?php
}

function p3_stumbleupon_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[stumbleupon]' placeholder='e.g. https://stumbleupon.com/stumbler/pipdig' value="<?php if (isset($links['stumbleupon'])) { echo $links['stumbleupon']; } ?>"> <?php
}

function p3_etsy_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[etsy]' placeholder='e.g. https://etsy.com/pipdig' value="<?php if (isset($links['etsy'])) { echo $links['etsy']; } ?>"> <?php
}

function p3_rss_field_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='url' name='pipdig_links[rss]' placeholder='e.g. <?php echo esc_url(get_site_url());?>/feed' value="<?php if (isset($links['rss'])) { echo $links['rss']; } ?>"> <?php
}

function pipdig_links_section_callback() { 
	// description text
	//pipdig_p3_scrapey_scrapes();
	echo '<p>'.__('Add the links to each social media page below:', 'p3').'</p>';
	printf(__('Any links added can then be used across your website, such as on <a href="%s">this page</a>.', 'p3'), admin_url('admin.php?page=pipdig-stats'));
}




function pipdig_links_options_page() { 
	?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
		<p><a href="https://support.pipdig.co/articles/wordpress-advanced-social-stats/" target="_blank"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a> <?php printf(__('If you find that certain social network counters are not working correctly, please see <a href="%s" target="_blank">this guide</a> for a possible solution.', 'p3'), esc_url('https://support.pipdig.co/articles/wordpress-advanced-social-stats/')); ?></p>
	</form>
	<?php
}



function delete_p3_stats_gen() {
	delete_transient('p3_stats_gen');
}
add_action( 'update_option_pipdig_links', 'delete_p3_stats_gen', 10, 2 );