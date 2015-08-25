<?php

if (!function_exists('pipdig_updates_options_page')) {
	function pipdig_updates_options_page() { 

	?>
	<div class="wrap">
	<h1><?php _e('Updates', 'p3'); ?></h1>
	<h3>Update 1.4.0</h3>
	<p>We'll be creating a new selection of shortcodes over the next few weeks.  To start things off, you can now use the shortcode [pipdig_stars] to automatically add a start rating. Perfect for anyone who writes product reviews. <a href="<?php echo admin_url('admin.php?page=pipdig-shortcodes'); ?>">Click here to read more</a>.</p>
	</div>
	<?php

	}
}

