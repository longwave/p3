<?php

if (!defined('ABSPATH')) {
	exit;
}

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

						<h3>Update 1.9 - Editorial Layouts</h3>

						<div class="inside">
							<p>New <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a> feature - Add a "Popular Posts Bar" under your site's header.</p>
							<p>We're working on some new shortcodes that will allow you to easily move/display your post content differently, ensuring it is fully responsive and search engine friendly. To start with, we kept things simple with some "Left/Right" layout options. You can read more about this shortcode <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">on this page</a>. More to come soon...</p>
							<p>More control over the icons displayed in the navbar. Look for the "Navbar Icons" section in the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
							<p>We have created a dedicated WordPress section to our Knowledge Base. You can find lots of new tips and tricks in <a href="https://pipdig.zendesk.com/hc/en-gb/categories/200928922" target="_blank">this section</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div id="hide-trav" class="postbox">

						<h3>Update 1.8 - Customizer options and widgets</h3>

						<div class="inside">
							<p>We're constantly monitoring the latest WordPress security threats to make your site safer. This plugin will now provide automatic protection from <a target="_blank" href="<?php esc_url('https://goo.gl/vfjunt'); ?>">XML-RPC based attacks</a>.</p>
							<p>New <a href="<?php echo admin_url('widgets.php'); ?>">widget</a>! Use "pipdig - Post Slider" to display a slider of recent posts in your sidebar.</p>
							<p>Under the new "Feature Header" section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>, you'll find some new options for a new magazine style layout.</p>
							<p>Add a custom Favicon to your site from the Site Identity section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.7 - Social Sharing</h3>

						<div class="inside">
							<p>You can now control which social sharing icons you'd like to use for posts. You can find these options under the "Social Sharing" section of the <a href="<?php echo admin_url('customize.php'); ?>">Customizer</a>.</p>
							<p>Improved "Related Posts" section.</p>
						</div>

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.6 - Widgets, speed and security. Oh my.</h3>

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

						<h3>Update 1.5 - Social Media Stats</h3>

						<div class="inside">
							<p>We're working on a lot of new ways to optimise social engagement right across our themes.</p>
							<p>To start, if you add your social media links to <a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>">this page</a>, you'll be able to see an overview of your social stats and follower counts on <a href="<?php echo admin_url('admin.php?page=pipdig-stats'); ?>">this page</a>. Once your links have been added, the theme can then start to use these links for all kinds of features in future, so head over and add them now!</p>
							<p>Then stay tuned for more coming soon :)</p>
						</div>

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h3>Update 1.4 - Shortcodes and Snapcodes</h3>

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

