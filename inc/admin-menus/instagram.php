<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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
		$access_token = pipdig_strip($instagram_deets['access_token']);
		//$user_id = explode('.', $access_token);
		//echo $user_id[0];
	}
	?>
	<input class='large-text' id="p3_access_token" type='text' name='pipdig_instagram[access_token]' value="<?php echo $access_token; ?>"> <?php
}

function p3_instagram_userid_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$user_id = '';
	if (!empty($instagram_deets['user_id'])) { 
		$user_id = pipdig_strip($instagram_deets['user_id']);
	}
	
	?>
	<input class='large-text' id="p3_user_id" type='text' name='pipdig_instagram[user_id]' value="<?php echo $user_id; ?>"> <?php
}




function pipdig_instagram_section_callback() {
	//echo '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">';
	echo '<p>You will need to authorize your Instagram account to display your feed on this site. Click the button below to do this:</p>';
	echo '<p><a href="https://www.pipdig.co/ig" target="_blank" class="instagram-token-button">'.__('Click here to authorize your Instagram account', 'p3').'</a></p>';
	echo '<p>'.__('Once you have authorized your account, copy and paste your Access Token below:', 'p3').'</p>';
	//echo '<p style="font-size: 80%;">(Note: If you find that the access token is not working, you can try to generate a new token via <a href="https://smashballoon.com/instagram-feed/token/" target="_blank">this page</a>. You can then copy this to the options below)</p>';
	
	//echo '<p>In order to display Instagram images on your site you will need to add your Access Token below.</p>';
	//echo '<p>You can get your Access Token from <a href="http://nullrefer.com/?https://www.maestrooo.com/instagram" target="_blank">this page</a>.';
	//echo '<p>You can get your User Id from <a href="http://www.otzberg.net/iguserid/" target="_blank">this page</a>.';
	//http://nullrefer.com/?http://instagram.pixelunion.net/
}




function pipdig_instagram_options_page() { 
	?>
	<div class="wrap">
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
		
		<div class="card">
					
		<?php
		settings_fields('pipdig_instagram_options_page');
		do_action('p3_instagram_save_action'); // to clear out transients on save - p3_instagram_clear_transients
		do_settings_sections('pipdig_instagram_options_page');
		submit_button();
		?>
		
		<button type="button" class="button" id="p3_test_connection">Click here to test connection</button>
		<p id="p3_test_connection_result"></p>
		
		<script>
		jQuery(document).ready(function($) {
			
			$('#p3_test_connection').click(function(e) {
				
				var token = $("#p3_access_token").val();
				var user = $("#p3_user_id").val();
				
				$(this).html('Testing, please wait...').prop( "disabled", true );
				
				var data = {
					action: 'p3_ig_connection_tester',
					'token': token,
					'user': user,
				};
				
				$.post(ajaxurl, data, function(response) {
					//alert(response);
					$('#p3_test_connection_result').html(response);
					$('#p3_test_connection').html('Click here to test connection').removeAttr('disabled');
				});
				
			});
		
		});
		</script>
		
		<p>After connecting your account, you can setup our <a href="https://support.pipdig.co/articles/wordpress-how-to-create-and-use-widgets/" target="_blank">Instagram Widget</a> and <a href="https://support.pipdig.co/articles/wordpress-how-to-display-an-instagram-feed/" target="_blank">Instagram Feed</a> options</p>
		
		</div><!--// .card -->
			
	</form>
	
	</div><!--// .wrap -->
	<?php
}

function p3_ig_connection_tester_callback() {
	
	$token = sanitize_text_field($_POST['token']);
	$user = sanitize_text_field($_POST['user']);
	
	if (empty($token)) {
		echo '<span class="dashicons dashicons-no"></span> Error! Please check you have entered your Access Token above.';
		wp_die();
	}
	if (empty($user)) {
		echo '<span class="dashicons dashicons-no"></span> Error! Please check you have entered your User ID above.';
		wp_die();
	}
	
	$headers = array(
		'Authorization' => 'Basic '.base64_encode($zendesk_user.'/token:'.$zendesk_token)
	);
	
	$args = array(
		'method' => 'GET',
		'timeout' => 15,
		'redirection' => 10,
		'blocking' => true,
	);
	
	$url = "https://api.instagram.com/v1/users/".$user."/media/recent/?access_token=".$token."&count=1";
	
	$result_msg = 'Unknown error, sorry :(';
	
	$response = wp_safe_remote_get($url, $args);
	if (is_array($response)) {
		$code = intval($response['response']['code']);
		if ($code === 200) {
			$result_msg = '<span class="dashicons dashicons-yes"></span> Success! You are connected to Instagram. Save your settings :)';
		} else {
			$data = json_decode($response['body']);
			$error_message = strip_tags($data->meta->error_message);
			$result_msg = '<span class="dashicons dashicons-no"></span> Error! Response from Instagram: "'.$error_message.'"';
		}
	} else {
		$result_msg = '<span class="dashicons dashicons-no"></span> Error! Could not connect to Instagram. Please try creating a new Access Token and User ID on <a href="https://www.pipdig.co/instagram" target="_blank">this page</a>.';
	}
	
	echo $result_msg;

	wp_die();
}
add_action( 'wp_ajax_p3_ig_connection_tester', 'p3_ig_connection_tester_callback' );


function delete_instagram_gen() {
	delete_transient('p3_instagram_feed');
}
add_action( 'update_option_pipdig_instagram', 'delete_instagram_gen', 10, 2 );
