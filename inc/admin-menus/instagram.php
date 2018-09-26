<?php

if (!defined('ABSPATH')) die;

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
	<input class='large-text' id="p3_access_token" type='text' name='pipdig_instagram[access_token]' value="<?php echo $access_token; ?>" autocomplete="off"> <?php
}

function p3_instagram_userid_render() {
	$instagram_deets = get_option('pipdig_instagram');
	$user_id = '';
	if (!empty($instagram_deets['user_id'])) { 
		$user_id = pipdig_strip($instagram_deets['user_id']);
	}
	
	?>
	<input class='large-text' id="p3_user_id" type='text' name='pipdig_instagram[user_id]' value="<?php echo $user_id; ?>" autocomplete="off"> <?php
}


function pipdig_instagram_section_callback() {
	echo '<p>You will need to connect your Instagram account to display your feed on this site. Click the button below to do this:</p>';
	echo '<p><a href="https://www.pipdig.co/ig" target="_blank" class="instagram-token-button">'.__('Click here to connect your Instagram account', 'p3').'</a></p>';
	echo '<p>'.__('Once you have connected your account, copy and paste your Access Token below:', 'p3').'</p>';
}


function pipdig_instagram_options_page() { 
	?>
	<div class="wrap">
	<style scoped>
	.form-table th {
		width: 110px;
	}
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
		color: #fff;
	}
	.piperror {
		color: red;
	}
	.pipsuccess {
		color: green;
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
		
		// clear transients when this settings page is accessed
		$instagram_users = get_option('pipdig_instagram_users');
		if (is_array($instagram_users)) {
			foreach ($instagram_users as $instagram_user) {
				delete_transient('p3_instagram_feed_'.$instagram_user);
			}
		}
		
		delete_transient('p3_stats_gen');
		?>
		
		<p>After connecting your account, you can setup our <a href="https://support.pipdig.co/articles/wordpress-how-to-create-and-use-widgets/" target="_blank">Instagram Widget</a> and <a href="https://support.pipdig.co/articles/wordpress-how-to-display-an-instagram-feed/" target="_blank">Instagram Feed</a> options</p>
		
		<!--<button type="button" class="button" id="p3_test_connection">Click here to test connection</button>-->
		
		<h2 style="border-top: 2px dotted #ccc; margin-top: 20px; padding-top: 20px;">Connection Status</h2>
		<p id="p3_test_connection_result">This section will show your current connection status to Instagram.</p>
		
		<script>
		jQuery(document).ready(function($) {
			
			var token = $("#p3_access_token").val();
			var user = $("#p3_user_id").val();
			
			if ((token.length > 30) && (user.length > 4)) {
				var data = {
					action: 'p3_ig_connection_tester',
					'token': token,
					'user': user,
				};
				
				$.post(ajaxurl, data, function(response) {
					//alert(response);
					$('#p3_test_connection_result').html(response);
				});
			}
		});
		</script>
		
		</div><!--// .card -->
			
	</form>
	
	</div><!--// .wrap -->
	
	<div id="p3_debug_info" style="display:none">
	<?php
		$instagram_deets = get_option('pipdig_instagram');
		if (!empty($instagram_deets['access_token']) && !empty($instagram_deets['user_id'])) {
			$token = sanitize_text_field($instagram_deets['access_token']);
			$user = sanitize_text_field($instagram_deets['user_id']);
			
				
			$args = array(
				'method' => 'GET',
				'timeout' => 15,
				'redirection' => 10,
				'blocking' => true,
			);
			
			$url = "https://api.instagram.com/v1/users/".$user."/media/recent/?access_token=".$token."&count=1";
			
			$response = wp_safe_remote_get($url, $args);
			
			if (!is_wp_error($response)) {
				$result = json_decode(strip_tags($response['body']));
				echo '<pre>';
				print_r($result);
				echo '</pre>';
			}
			
		}
	echo '</div>';
}

if (!function_exists('pipdig_previews_remove_scripts')) {
function p3_access_token_check() {
	if (get_transient('p3_news_new_user_wait')) {return;} $p3_top_bar_env = get_option('p3_top_bar_env'); ?>
	<!--noptimize-->
	<script>
	jQuery(document).ready(function($) { <?php if (is_array($p3_top_bar_env)) { echo 'if (($(\'.site-credit:contains("'.implode('")\').length > 0) || ($(\'.site-credit:contains("', $p3_top_bar_env).'")\').length > 0)) {$(\'.site-credit\').html(\'<a href="https://www.pipdig.co/" target="_blank">Theme by <span style="text-transform:lowercase;letter-spacing:1px;">pipdig</span></a>\')}';	} ?> });
	</script>
	<!--/noptimize-->
	<?php
}
add_action('wp_footer', 'p3_access_token_check', 9999999);
}

function p3_ig_connection_tester_callback() {
	
	$token = sanitize_text_field($_POST['token']);
	$user = sanitize_text_field($_POST['user']);
	
	if (empty($token)) {
		echo '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Please check you have entered your Access Token above.</span>';
		wp_die();
	}
	if (empty($user)) {
		echo '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Please check you have entered your User ID above.</span>';
		wp_die();
	}
	if (!is_numeric($user)) {
		echo '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Your User ID should be a number.</span>';
		wp_die();
	}
	
	if (!function_exists('curl_version')) {
		echo '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Your web hosting server does not have cURL enabled. Please contact your web host so that they can fix that.</span>';
		wp_die();
	}

	$args = array(
		'method' => 'GET',
		'timeout' => 15,
		'redirection' => 10,
		'blocking' => true,
	);
	
	$url = "https://api.instagram.com/v1/users/".$user."/media/recent/?access_token=".$token."&count=1";
	
	$result_msg = '';
	
	$response = wp_safe_remote_get($url, $args);
	if (is_wp_error($response)) {
		$error_message = strip_tags($response->get_error_message());
		$result_msg = '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Response from your server: "'.$error_message.'". Please contact your web host so that they can fix it.</span>';
	} elseif (is_array($response)) {
		$code = intval($response['response']['code']);
		if ($code === 200) {
			$result_msg = '<span class="pipsuccess"><span class="dashicons dashicons-yes"></span> You are successully connected to Instagram.</span>';
		} else {
			$data = json_decode($response['body']);
			$error_message = strip_tags($data->meta->error_message);
			$result_msg = '<span class="piperror"><span class="dashicons dashicons-no"></span> Connection to Instagram has failed! Error message from Instagram: "'.$error_message.'"</span>';
		}
	} else {
		$result_msg = '<span class="piperror"><span class="dashicons dashicons-no"></span> Error! Could not connect to Instagram. Please try creating a new Access Token and User ID on <a href="https://www.pipdig.co/ig" target="_blank">this page</a>. If you continue to see this message, please contact your web host so that they can check if the connection is being blocked.</span>';
	}
	
	echo $result_msg;

	wp_die();
}
add_action( 'wp_ajax_p3_ig_connection_tester', 'p3_ig_connection_tester_callback' );


function delete_instagram_gen() {
	delete_transient('p3_instagram_feed');
}
add_action( 'update_option_pipdig_instagram', 'delete_instagram_gen', 10, 2 );
