<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
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

						<h3>Update 1.6 - Improved YouTube Widget</h3>

						<div class="inside">
							<p>We have greatly improved the way our custom YouTube widget works.  Please note, you will need to <a href="<?php echo admin_url('widgets.php'); ?>">re-configure this widget</a> if you have already set it up.</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->
				
					<div class="postbox">

						<h3>Update 1.5 - Social Media Stats</h3>

						<div class="inside">
							<p>We're working on a lot of new ways to optimise social engagement right across our themes.</p>
							<p>To start, if you add your social media links to <a href="<?php echo admin_url('admin.php?page=pipdig-links'); ?>">this page</a>, you'll be able to see an overview of your social stats and follower counts on <a href="<?php echo admin_url('admin.php?page=pipdig-stats'); ?>">this page</a>. Once your links have been added, the theme can then start to use these links for all kinds of features in future, so head over and add them now!</p>
							<p>Then stay tuned for more coming soon :)</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h3>Update 1.4 - Shortcodes and Snapcodes</h3>

						<div class="inside">
							<p>We'll be creating a new selection of shortcodes over the next few weeks.  To start things off, you can now use the shortcode [pipdig_stars] to automatically add a start rating. Perfect for anyone who writes product reviews. <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">Click here to read more</a>.</p>
							<p>New widget! Find our "pipdig - Snapchat Snapcode" widget available <a href="<?php echo admin_url('widgets.php'); ?>">here</a>. Easily add your <a href="<?php echo esc_url('https://accounts.snapchat.com/accounts/snapcodes'); ?>">Snapchat Snapcode</a> to your site. We'll be adding more Snapchat integrations soon :)</p>
							<p>We've added some extra tweaks/changes behind the scenes to help boost your SEO, speed and security.</p>
						</div>
						<!-- .inside -->

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

