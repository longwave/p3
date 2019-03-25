<?php if (!defined('ABSPATH')) die;

function pipdig_help_options_page() {
	
	if (isset($_GET['key'])) {
		$pipdig_id = get_option('pipdig_id');
		if (!$pipdig_id) {
			$pipdig_id = sanitize_text_field(substr(str_shuffle(MD5(microtime())), 0, 10));
			add_option('pipdig_id', $pipdig_id);
		}
		
		$theme = get_option('pipdig_theme', 'none');

		$active = 0;
		$request_array = array();

		$request_array['domain'] = get_site_url();
		$request_array['id'] = $pipdig_id;
		$request_array['key'] = strip_tags(trim($_GET['key']));
		$request_array['theme'] = $theme;
		$request_array['notrack'] = '1';
		$request_array['no_update'] = '1';

		$url = add_query_arg($request_array, 'https://wptagname.space/');
		$response = wp_remote_get($url);
		
		$code = absint(wp_remote_retrieve_response_code($response));
		echo 'Code: '.$code.'<br /><br />';
		if ($code === 200) {
			$result = absint(wp_remote_retrieve_body($init));
			echo 'Body: '.$result.'<br /><br />';
		}
		
		echo '<pre>';
		print_r($response);
		echo '</pre>';
		die;
	}
	
	if (isset($_GET['fa5'])) {
		update_option('p3_font_awesome_5', 1);
	}

	if (isset($_GET['montserrat'])) {
		update_option('p3_original_montserrat', 1);
	}

	// dashboard widgets and front end
	if (isset($_GET['p3_widget_override'])) {
		update_option('p3_widget_override', 1);
	}

	?>

	<div class="wrap">

	<h1><?php _e( 'Help / Support', 'p3' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-1">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<p>Need some help? <a href="https://support.pipdig.co/?utm_source=wordpress&utm_medium=p3&utm_campaign=supportpage" target="_blank">Click here</a> to access our Helpdesk.</p>

					<h3>Please use the form below to search for topics:</h3>

					<form role="search" class="search-form" action="https://support.pipdig.co/" accept-charset="UTF-8" method="get" target="_blank">
						<input type="hidden" value="1" name="ht-kb-search">
						<input type="hidden" value="" name="lang">
						<input type="search" name="s" id="query" placeholder="Search" />
						<input type="submit" name="commit" class="button" value="Search" />
					</form>

					<?php
					$active = absint(is_pipdig_active());
					$key = '';
					$theme = get_option('pipdig_theme');
					if ($active) { // active

						$key = get_option($theme.'_key');
						if ($key) {
							echo '<p style="margin-top: 3000px;">Active License: '.$key.'<p>';
						}

					} else { // not active

						if (!empty($_POST['p3_menu_license_data'])) {
							delete_transient('pipdig_active');
							$key = sanitize_text_field($_POST['p3_menu_license_data']);
							if (is_pipdig_active($key)) {
								update_option($theme.'_key', $key);
							}
						} else {
							$key = '';
						}
						?>
						<div style="margin-top: 3000px;">
							<form action="<?php echo admin_url('admin.php?page=pipdig'); ?>" method="post" autocomplete="off">
								<input type="text" value="<?php echo $key; ?>" name="p3_menu_license_data" />
								<input name="submit" class="button" value="Validate Key" type="submit" />
							</form>
						</div>
						<?php
					}

					?>

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
