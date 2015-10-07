<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function pipdig_instagram_init() {

	register_setting('pipdig_instagram_options_page', 'pipdig_instagram');
	
	add_settings_section(
		'pipdig_instagram_options_page_section', 
		'',
		'pipdig_instagram_section_callback', 
		'pipdig_instagram_options_page'
	);

	
	add_settings_field( 
		'access_token', 
		'Access Token', 
		'p3_instagram_at_render', 
		'pipdig_instagram_options_page', 
		'pipdig_instagram_options_page_section' 
	);
	
	add_settings_field( 
		'user_id', 
		'User ID', 
		'p3_instagram_userid_render', 
		'pipdig_instagram_options_page', 
		'pipdig_instagram_options_page_section' 
	);
	

	

	
}
add_action('admin_init', 'pipdig_instagram_init');


function p3_instagram_at_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$access_token = '';
	if (!empty($instagram_deets['access_token'])) { 
		$access_token = strip_tags($instagram_deets['access_token']);
	}
	?>
	<input class='large-text' type='text' name='pipdig_instagram[access_token]' value="<?php echo $access_token; ?>"> <?php
}

function p3_instagram_userid_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$user_id = '';
	if (!empty($instagram_deets['user_id'])) { 
		$user_id = intval($instagram_deets['user_id']);
	}
	
	?>
	<input class='large-text' type='text' name='pipdig_instagram[user_id]' value="<?php echo $user_id; ?>"> <?php
}




function pipdig_instagram_section_callback() {
	//$instagram_deets = get_option('pipdig_instagram');
	//if (empty($instagram_deets['access_token'])) { 
		echo '<p><a href="http://www.pipdig.co/instagram/" target="_blank">'.__('Click here to authorize your Instagram account', 'p3').'</a></p>';
	//} else {
		//echo '<a href="http://www.pipdig.co/instagram/">'.__('Click here to re-authorize your Instagram account', 'p3').'</a>';
	//}
	echo '<p>Once you have authorized your account, copy and paste your information below:</p>';
}




function pipdig_instagram_options_page() { 
	?>
	<style scoped="scoped">
	.form-table th {width: 110px;}
	</style>
	<form action='options.php' method='post'>
			
		<h2>Instagram Settings</h2>
		
		<p><?php _e("You will need to sign in to Instagram to allow this theme's widgets to display our photos. Click the button below to do this:", 'p3'); ?></p>
			
		<?php
		settings_fields('pipdig_instagram_options_page');
		do_settings_sections('pipdig_instagram_options_page');
		submit_button();
		?>
			
	</form>
	<?php
}