<?php

if (!function_exists('pipdig_updates_options_page')) {
	function pipdig_updates_options_page() { 

	?>
	
	<div class="wrap">

	<h1><?php esc_attr_e( 'Updates', 'p3' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-1">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h3>Update 1.4 - Shortcodes</h3>

						<div class="inside">
							<p>We'll be creating a new selection of shortcodes over the next few weeks.  To start things off, you can now use the shortcode [pipdig_stars] to automatically add a start rating. Perfect for anyone who writes product reviews. <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">Click here to read more</a>.</p>
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

