<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('pipdig_instagram_settings_init')) {
	function pipdig_instagram_settings_init() { 

		register_setting( 'pipdig_instagram_settings_page', 'pipdig_instagram_settings' );

		add_settings_section(
			'pipdig_pipdig_instagram_settings_page_section', 
			__('Instagram Settings', 'p3'),
			'pipdig_instagram_settings_section_callback', 
			'pipdig_instagram_settings_page'
		);

		add_settings_field( 
			'email', 
			'Access Token', 
			'p3_instagram_at_render', 
			'pipdig_links_options_page', 
			'pipdig_links_options_page_section' 
		);

	}
	add_action( 'admin_init', 'pipdig_instagram_settings_init' );
}


function p3_instagram_at_render() { 
	$links = get_option('pipdig_links'); ?>
	<input class='large-text' type='email' name='pipdig_links[email]' placeholder='yourname@gmail.com' value="<?php if (isset($links['email'])) { echo $links['email']; } ?>"> <?php
}



if (!function_exists('pipdig_instagram_settings_section_callback')) {
	function pipdig_instagram_settings_section_callback() { 
		//_e('Any CSS added to the box below will be kept after theme updates.', 'p3');
	}
}


if (!function_exists('pipdig_instagram_settings_options_page')) {
	function pipdig_instagram_settings_options_page() { 

		?>
		<form action='options.php' method='post'>
		
			<?php
			settings_fields( 'pipdig_instagram_settings_page' );
			do_settings_sections( 'pipdig_instagram_settings_page' );
			submit_button();
			?>
			
		</form>
		<h3><?php
		$plugin_url = admin_url('customize.php');
		printf(__('Remember, you can also change the appearance of your site by using the <a href="%s">Customizer</a>.', 'p3'), $plugin_url );
		?>		</h3>
		<?php

	}
}
