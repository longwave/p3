<?php

if (!defined('ABSPATH')) {
	exit;
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
	/*
	add_settings_field( 
		'user_id', 
		'User ID', 
		'p3_instagram_userid_render', 
		'pipdig_instagram_options_page', 
		'pipdig_instagram_options_page_section' 
	);
	*/
	
}
add_action('admin_init', 'pipdig_instagram_init');


function p3_instagram_at_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$access_token = '';
	if (!empty($instagram_deets['access_token'])) { 
		$access_token = sanitize_text_field($instagram_deets['access_token']);
		//$user_id = explode('.', $access_token);
		//echo $user_id[0];
	}
	?>
	<input class='large-text' type='text' name='pipdig_instagram[access_token]' value="<?php echo $access_token; ?>"> <?php
}
/*
function p3_instagram_userid_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$user_id = '';
	if (!empty($instagram_deets['user_id'])) { 
		$user_id = sanitize_text_field($instagram_deets['user_id']);
	}
	
	?>
	<input class='large-text' type='text' name='pipdig_instagram[user_id]' value="<?php echo $user_id; ?>"> <?php
}
*/



function pipdig_instagram_section_callback() {
	//echo '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">';
	echo '<p>You will need to authorize your Instagram account to display your feed on this site. Click the button below to do this:</p>';
	echo '<p><a href="https://www.pipdig.co/instagram/" target="_blank" class="instagram-token-button">'.__('Click here to authorize your Instagram account', 'p3').'</a></p>';
	echo '<p>'.__('Once you have authorized your account, copy and paste your Access Token below:', 'p3').'</p>';
	//echo '<p style="font-size: 80%;">(Note: If you find that the access token is not working, you can try to generate a new token via <a href="https://smashballoon.com/instagram-feed/token/" target="_blank">this page</a>. You can then copy this to the options below)</p>';
	
	//echo '<p>In order to display Instagram images on your site you will need to add your Access Token below.</p>';
	//echo '<p>You can get your Access Token from <a href="http://nullrefer.com/?https://www.maestrooo.com/instagram" target="_blank">this page</a>.';
	//echo '<p>You can get your User Id from <a href="http://www.otzberg.net/iguserid/" target="_blank">this page</a>.';
	//http://nullrefer.com/?http://instagram.pixelunion.net/
}




function pipdig_instagram_options_page() { 
	?>
	<style scoped>
	.form-table th {width: 110px;}
	.instagram-token-button {
		background: #517fa4;
		border-radius: 5px;
		clear: both;
		color: #fff;
		display: inline-block;
		margin: 0;
		padding: 8px 12px;
		text-decoration: none;
	}
	.instagram-token-button:hover {
		background: #e89a2e;
	}
	.notice-warning {
		display: none;
	}
	</style>
	<form action='options.php' method='post'>
			
		<h1>Instagram Settings</h1>
					
		<?php
		settings_fields('pipdig_instagram_options_page');
		do_action('p3_instagram_save_action'); // to clear out transients on save - p3_instagram_clear_transients
		do_settings_sections('pipdig_instagram_options_page');
		submit_button();
		?>
		
		<p>After connecting your account, you can setup our <a href="https://support.pipdig.co/articles/wordpress-how-to-create-and-use-widgets/" target="_blank">Instagram Widget</a> and <a href="https://support.pipdig.co/articles/wordpress-how-to-display-an-instagram-feed/" target="_blank">Instagram Feed</a> options</p>
			
	</form>
	<?php
}


function delete_instagram_gen() {
	delete_transient('p3_instagram_feed');
}
add_action( 'update_option_pipdig_instagram', 'delete_instagram_gen', 10, 2 );
