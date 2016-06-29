<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_updates_options_page')) {
	function pipdig_updates_options_page() { 

	?>
	
	<div class="wrap">

	<h1><?php _e( 'Updates', 'p3' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-1">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">
				
					<div class="postbox">

						<h3>Update 2.2</h3>

						<div class="inside">
							<p>New shortcode to display categories of posts. <a href='https://support.pipdig.co/articles/wordpress-featured-categories-shortcode/' target='_blank'>Click here</a> to read more.</p>
							<p>Multiple images size options for <a href='https://support.pipdig.co/articles/wordpress-how-to-display-related-posts/' target='_blank'>Related Posts</a> feature.</p>
							<p>New Instagram options in the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 2.1</h3>

						<div class="inside">
							<p>Snapchat can now be added to social links.</p>
							<p>New 'We Heart It' Widget.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 2.0</h3>

						<div class="inside">
							<p>NOTE! Please <a href="http://www.refreshyourcache.com/en/home/" target="_blank">clear your browser cache</a> and website cache (if you use a plugin such as WP Supercache or W3 Total Cache).</p>
							<p>Many improvements to our Instagram features. You can now add an Instagram feed to the footer, header and any widget area of your site. Our custom Instagram widget can now also include 'Likes' and 'Comments' counts on hover.</p>
							<p>You may need to re-authorize your Instagram account on <a href="<?php echo admin_url('admin.php?page=pipdig-instagram'); ?>">this page</a> after this update.</p>
							<p>Extra sharing icons for posts (look for the new "Sharing Icons" tab in the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>).</p>
							<p>Extra social follow icons can be added to the navbar (Look for the "Navbar Icons" tab in the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>).</p>
							<p>Added Twitch.tv support for social stats.</p>
							<p>Various speed/styling improvements.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.10</h3>

						<div class="inside">
							<p>You can now setup a custom Pinterest Hover Button via the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>. This new feature allows you to upload any imag you like as a "Pin it" button, or use our prestyled button if you prefer.</p>
							<p>New widget! Display your latest Tweets with "pipdig - Twitter Widget". We'll be adding more options to this widget soon...</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.9</h3>

						<div class="inside">
							<p>New <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a> feature - Add a "Popular Posts Bar" under your site's header.</p>
							<p>We're working on some new shortcodes that will allow you to easily move/display your post content differently, ensuring it is fully responsive and search engine friendly. To start with, we kept things simple with some "Left/Right" layout options. You can read more about this shortcode <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">on this page</a>. More to come soon...</p>
							<p>More control over the icons displayed in the navbar. Look for the "Navbar Icons" section in the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
							<p>We have created a dedicated WordPress section to our Knowledge Base. You can find lots of new tips and tricks in <a href="//support.pipdig.co/article-topics/wordpress/" target="_blank">this section</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div id="hide-trav" class="postbox">

						<h3>Update 1.8</h3>

						<div class="inside">
							<p>We're constantly monitoring the latest WordPress security threats to make your site safer. This plugin will now provide automatic protection from <a target="_blank" href="<?php esc_url('https://goo.gl/vfjunt'); ?>">XML-RPC based attacks</a>.</p>
							<p>New <a href="<?php echo admin_url('widgets.php'); ?>">widget</a>! Use "pipdig - Post Slider" to display a slider of recent posts in your sidebar.</p>
							<p>Under the new "Feature Header" section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>, you'll find some new options for a new magazine style layout.</p>
							<p>Add a custom Favicon to your site from the Site Identity section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.7</h3>

						<div class="inside">
							<p>You can now control which social sharing icons you'd like to use for posts. You can find these options under the "Social Sharing" section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
							<p>Improved "Related Posts" section.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.6</h3>

						<div class="inside">
							<p>Added Spotify to social media icons widget.</p>
							<p>Improved Pinterest Widget options.</p>
							<p>New Social Media Icons widget layout options.</p>
							<p>We have greatly improved the way our custom YouTube widget works.  Please note, you will need to <a href="<?php echo admin_url('widgets.php'); ?>">re-configure this widget</a> if you have already set it up.</p>
							<p>Speed and security boosts by running external files through <a href="<?php echo esc_url('https://www.cloudflare.com/overview'); ?>" target="_blank">CloudFlare</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.5</h3>

						<div class="inside">
							<p>We're working on a lot of new ways to optimise social engagement right across our themes.</p>
							<p>To start, if you add your social media links to <a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>">this page</a>, you'll be able to see an overview of your social stats and follower counts on <a href="<?php echo admin_url('admin.php?page=pipdig-stats'); ?>">this page</a>. Once your links have been added, the theme can then start to use these links for all kinds of features in future, so head over and add them now!</p>
							<p>Then stay tuned for more coming soon :)</p>
						</div>

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h3>Update 1.4</h3>

						<div class="inside">
							<p>We'll be creating a new selection of shortcodes over the next few weeks.  To start things off, you can now use the shortcode [pipdig_stars] to automatically add a start rating. Perfect for anyone who writes product reviews. <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">Click here to read more</a>.</p>
							<p>New widget! Find our "pipdig - Snapchat Snapcode" widget available <a href="<?php echo admin_url('widgets.php'); ?>">here</a>. Easily add your <a href="<?php echo esc_url('https://accounts.snapchat.com/accounts/snapcodes'); ?>">Snapchat Snapcode</a> to your site. We'll be adding more Snapchat integrations soon :)</p>
							<p>We've added some extra tweaks/changes behind the scenes to help boost your SEO, speed and security.</p>
						</div>

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

		</div>
		<!-- #post-body .metabox-holder .columns-1 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
	
	
	
	
	<?php

	}
}

