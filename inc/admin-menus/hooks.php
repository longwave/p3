<?php 
if (!defined('ABSPATH')) die;

if (!function_exists('pipdig_settings_init')) {
function pipdig_settings_init() {

	register_setting( 'pipdig_hooks_page', 'pipdig_settings' );

	add_settings_section(
		'pipdig_pipdig_hooks_page_section',
		__('Please be careful when adding code in these options. This can break your site if not added correctly!', 'p3'),
		'pipdig_settings_section_callback',
		'pipdig_hooks_page'
	);

	add_settings_field(
		'pipdig_textarea_scripts',
		__( 'Code to add to the  &lt;head&gt;', 'p3' ).'<p style="font-style:normal;font-weight:normal;">'.__( 'For example, Google Analytics tracking code', 'p3' ).'</p>',
		'pipdig_textarea_scripts_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	add_settings_field(
		'pipdig_textarea_body_scripts',
		__( 'Code to add directly after the opening &lt;body&gt; tag', 'p3' ),
		'pipdig_textarea_body_scripts_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	add_settings_field(
		'pipdig_textarea_footer_scripts',
		__( 'Code to add just before the closing &lt;/body&gt; tag', 'p3' ),
		'pipdig_textarea_footer_scripts_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	// conntent hooks from here
	add_settings_field(
		'pipdig_content_desc', '<h2>Content Based Hooks</h2>',
		'pipdig_content_desc_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	// after first post on homepage/archives
	add_settings_field(
		'pipdig_textarea_after_first_post',
		__( 'After the first blog post on the homepage or archive', 'p3' ).'<p style="font-style:normal;font-weight:normal;">'.__( 'For example, you may wish to place a banner ad after the first post', 'p3' ).'</p>',
		'pipdig_textarea_after_first_post_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	// beginning of each blog post content
	add_settings_field(
		'pipdig_textarea_p3_content_start',
		__( 'Beginning of blog post content', 'p3' ),
		'pipdig_textarea_p3_content_start_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	// end of each blog post content
	add_settings_field(
		'pipdig_textarea_p3_content_end',
		__( 'End of blog post content', 'p3' ),
		'pipdig_textarea_p3_content_end_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	add_settings_field(
		'pipdig_textarea_content_script_1',
		__( 'Code which will be embedded when using the following shortcode in any post/page:', 'p3' ).'<br /><br />[pipdig_code_1]',
		'pipdig_textarea_content_script_1_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	add_settings_field(
		'pipdig_textarea_content_script_2',
		__( 'Code which will be embedded when using the following shortcode in any post/page:', 'p3' ).'<br /><br />[pipdig_code_2]',
		'pipdig_textarea_content_script_2_render',
		'pipdig_hooks_page',
		'pipdig_pipdig_hooks_page_section'
	);

	}
add_action( 'admin_init', 'pipdig_settings_init' );
}


if (!function_exists('pipdig_content_desc_render')) {
function pipdig_content_desc_render() {
	?>
	<hr style="margin-bottom: 20px;">
	<p style="width:1000px; max-width: 100%;">Use the fields below to add content to various positions on your site.<br />For example, you may wish to add an affiliate code/disclaimer to the beginning of all blog posts via the "Beginning of blog post content" section.</p>
	<?php
}
}


if (!function_exists('pipdig_textarea_scripts_render')) {
function pipdig_textarea_scripts_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_scripts]' placeholder=''><?php if (isset($options['pipdig_textarea_scripts'])) { echo $options['pipdig_textarea_scripts']; } ?></textarea>
	<?php
}
}


if (!function_exists('pipdig_textarea_footer_scripts_render')) {
function pipdig_textarea_footer_scripts_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_footer_scripts]' placeholder=''><?php if (isset($options['pipdig_textarea_footer_scripts'])) { echo $options['pipdig_textarea_footer_scripts']; } ?></textarea>
	<?php
}
}


if (!function_exists('pipdig_textarea_body_scripts_render')) {
function pipdig_textarea_body_scripts_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_body_scripts]' placeholder=''><?php if (isset($options['pipdig_textarea_body_scripts'])) { echo $options['pipdig_textarea_body_scripts']; } ?></textarea>
	<?php
}
}



if (!function_exists('pipdig_textarea_after_first_post_render')) {
function pipdig_textarea_after_first_post_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_after_first_post]' placeholder=''><?php if (isset($options['pipdig_textarea_after_first_post'])) { echo $options['pipdig_textarea_after_first_post']; } ?></textarea>
	<?php
}
}


if (!function_exists('pipdig_textarea_p3_content_start_render')) {
function pipdig_textarea_p3_content_start_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_p3_content_start]' placeholder=''><?php if (isset($options['pipdig_textarea_p3_content_start'])) { echo $options['pipdig_textarea_p3_content_start']; } ?></textarea>
	<?php
}
}

if (!function_exists('pipdig_textarea_p3_content_end_render')) {
function pipdig_textarea_p3_content_end_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_p3_content_end]' placeholder=''><?php if (isset($options['pipdig_textarea_p3_content_end'])) { echo $options['pipdig_textarea_p3_content_end']; } ?></textarea>
	<?php
}
}

function pipdig_textarea_content_script_1_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_content_script_1]' placeholder=''><?php if (isset($options['pipdig_textarea_content_script_1'])) { echo $options['pipdig_textarea_content_script_1']; } ?></textarea>
	<?php
}

function pipdig_textarea_content_script_2_render() {
	$options = get_option('pipdig_settings');
	?>
	<textarea style='width:1000px; max-width: 100%;' class='code' rows='9' name='pipdig_settings[pipdig_textarea_content_script_2]' placeholder=''><?php if (isset($options['pipdig_textarea_content_script_2'])) { echo $options['pipdig_textarea_content_script_2']; } ?></textarea>
	<?php
}


if (!function_exists('pipdig_settings_section_callback')) {
function pipdig_settings_section_callback() {
	// description text
	echo '<p>Use the fields below to add custom code to the Head, Body or Footer of your site.</p><p>These settings will be carried over if you install any other pipdig theme.'.'</p>
	<p>WARNING: these options can break your site. Use with caution. <a href="https://support.pipdig.co/articles/wordpress-theme-hooks/?utm_source=wordpress&utm_medium=p3&utm_campaign=themehooks" target="_blank">'.__( 'Click here for more information', 'p3' ).'</a></p>';
}
}

if (!function_exists('pipdig_hooks_options_page')) {
	function pipdig_hooks_options_page() {
		?>
		<form action='options.php' method='post'>

			<h1>Theme Hooks</h1>

			<?php
			settings_fields( 'pipdig_hooks_page' );
			do_settings_sections( 'pipdig_hooks_page' );
			submit_button();
			?>

		</form>
		<?php
	}
}

function pipdig_head_stuff() { // wp_head
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_scripts'])) {
		$output = "<!-- pipdig p3 custom code head --> \r" . $options['pipdig_textarea_scripts'] . "\r <!-- // pipdig p3 custom code head -->";
	}
	echo $output;
}
add_action('wp_head', 'pipdig_head_stuff', 9999999);


function pipdig_opening_body_stuff() { // After opening <body> tag
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_body_scripts'])) {
		$output = "<!-- pipdig p3 custom code starting body --> \r" . $options['pipdig_textarea_body_scripts'] . "\r <!-- // pipdig p3 custom starting body -->";
	}
	echo $output;
}
add_action('before', 'pipdig_opening_body_stuff');


function pipdig_footer_stuff() { // wp_footer
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_footer_scripts'])) {
		$output = "<!-- pipdig p3 custom code footer --> \r" . $options['pipdig_textarea_footer_scripts'] . "\r <!-- // pipdig p3 custom code footer -->";
	}
	echo $output;
}
add_action('wp_footer', 'pipdig_footer_stuff', 9999999);


function pipdig_after_first_post_stuff() { // After the first post (unless grid layout)
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_after_first_post'])) {
		$output = '<div class="hook_after-first-post"><!-- pipdig p3 custom code after first post --> ' . do_shortcode($options['pipdig_textarea_after_first_post']) . ' <!-- // pipdig p3 custom code after first post --></div>';
	}
	echo $output;
}
add_action('after_first_post', 'pipdig_after_first_post_stuff');


function pipdig_textarea_p3_content_start_stuff() { // top of post content
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_p3_content_start'])) {
		$output = do_shortcode($options['pipdig_textarea_p3_content_start']);
	}
	echo $output;
}
add_action('p3_content_start', 'pipdig_textarea_p3_content_start_stuff');


function pipdig_textarea_p3_content_end_stuff() { // end of post content
	$output = '';
	$options = get_option('pipdig_settings');
	if (!empty($options['pipdig_textarea_p3_content_end'])) {
		$output = do_shortcode($options['pipdig_textarea_p3_content_end']);
	}
	echo $output;
}
add_action('p3_content_end', 'pipdig_textarea_p3_content_end_stuff', 0);
