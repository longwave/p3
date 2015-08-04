<?php
// hooks for any pipdig theme (formerly pipdig-power-pack plugin)

// create submenu page under pipdig main admin page (commented out since handled by admin menu php file now)
/*
if (!function_exists('pipdig_add_hooks_menu')) {
	function pipdig_add_hooks_menu() { 	
		add_submenu_page( 'pipdig-options', __('pipdig Theme Hooks', 'p3-textdomain'), 'pipdig Hooks', 'manage_options', 'pipdig-hooks', 'pipdig_hooks_options_page' );
	}
	add_action( 'admin_menu', 'pipdig_add_hooks_menu' );
}
*/
if (!function_exists('pipdig_settings_init')) {
	function pipdig_settings_init() { 

		register_setting( 'pluginPage', 'pipdig_settings' );

		add_settings_section(
			'pipdig_pluginPage_section', 
			__('Please be careful when adding code in these options. This can break your site if not added correctly!', 'p3-textdomain'),
			'pipdig_settings_section_callback', 
			'pluginPage'
		);

		add_settings_field( 
			'pipdig_textarea_css', 
			__( 'Custom CSS', 'p3-textdomain' ), 
			'pipdig_textarea_css_render', 
			'pluginPage', 
			'pipdig_pluginPage_section' 
		);

		add_settings_field( 
			'pipdig_textarea_scripts', 
			__( 'Code to add to the  &lt;head&gt;', 'p3-textdomain' ).'<p style="font-style:normal;font-weight:normal;">'.__( 'For example, Google Analytics tracking code', 'p3-textdomain' ).'</p>', 
			'pipdig_textarea_scripts_render', 
			'pluginPage', 
			'pipdig_pluginPage_section' 
		);
		
		add_settings_field( 
			'pipdig_textarea_body_scripts', 
			__( 'Code to add directly after the opening &lt;body&gt; tag', 'p3-textdomain' ), 
			'pipdig_textarea_body_scripts_render', 
			'pluginPage', 
			'pipdig_pluginPage_section' 
		);

		add_settings_field( 
			'pipdig_textarea_footer_scripts', 
			__( 'Code to add just before the closing &lt;/body&gt; tag', 'p3-textdomain' ), 
			'pipdig_textarea_footer_scripts_render', 
			'pluginPage', 
			'pipdig_pluginPage_section' 
		);
		
		add_settings_field( 
			'pipdig_textarea_after_first_post', 
			__( 'Code to add directly after the first post on the home page or any archive', 'p3-textdomain' ).'<p style="font-style:normal;font-weight:normal;">'.__( 'For example, you may wish to place a banner ad after the first post', 'p3-textdomain' ).'</p>', 
			'pipdig_textarea_after_first_post_render', 
			'pluginPage', 
			'pipdig_pluginPage_section' 
		);


	}
	add_action( 'admin_init', 'pipdig_settings_init' );
}


if (!function_exists('pipdig_textarea_css_render')) {
	function pipdig_textarea_css_render() { 

		$options = get_option( 'pipdig_settings' );
		?>
		<textarea cols='60' rows='7' name='pipdig_settings[pipdig_textarea_css]' placeholder='body {color: #000000; background: #ffffff}'><?php if (isset($options['pipdig_textarea_css'])) { echo $options['pipdig_textarea_css']; } ?></textarea>
		<?php

	}
}


if (!function_exists('pipdig_textarea_scripts_render')) {
	function pipdig_textarea_scripts_render() { 

		$options = get_option( 'pipdig_settings' );
		?>
		<textarea cols='60' rows='7' name='pipdig_settings[pipdig_textarea_scripts]' placeholder='if adding javascript you will need to wrap the code in <script> tags'><?php if (isset($options['pipdig_textarea_scripts'])) { echo $options['pipdig_textarea_scripts']; } ?></textarea>
		<?php

	}
}


if (!function_exists('pipdig_textarea_footer_scripts_render')) {
		function pipdig_textarea_footer_scripts_render() { 

			$options = get_option( 'pipdig_settings' );
			?>
			<textarea cols='60' rows='7' name='pipdig_settings[pipdig_textarea_footer_scripts]' placeholder='if adding javascript you will need to wrap the code in <script> tags'><?php if (isset($options['pipdig_textarea_footer_scripts'])) { echo $options['pipdig_textarea_footer_scripts']; } ?></textarea>
			<?php

		}
}


if (!function_exists('pipdig_textarea_body_scripts_render')) {
		function pipdig_textarea_body_scripts_render() { 

			$options = get_option( 'pipdig_settings' );
			?>
			<textarea cols='60' rows='7' name='pipdig_settings[pipdig_textarea_body_scripts]' placeholder='if adding javascript you will need to wrap the code in <script> tags'><?php if (isset($options['pipdig_textarea_body_scripts'])) { echo $options['pipdig_textarea_body_scripts']; } ?></textarea>
			<?php

		}
}


if (!function_exists('pipdig_textarea_after_first_post_render')) {
	function pipdig_textarea_after_first_post_render() { 

		$options = get_option( 'pipdig_settings' );
		?>
		<textarea cols='60' rows='7' name='pipdig_settings[pipdig_textarea_after_first_post]' placeholder='if adding javascript you will need to wrap the code in <script> tags'><?php if (isset($options['pipdig_textarea_after_first_post'])) { echo $options['pipdig_textarea_after_first_post']; } ?></textarea>
		<?php

	}
}


if (!function_exists('pipdig_settings_section_callback')) {
	function pipdig_settings_section_callback() { 
		
		// description text
		echo '<p>'.__( 'Use the fields below to add custom code to the Head, Body or Footer of your site.', 'p3-textdomain' ).'</p><p>'.__( 'These settings will be carried over if you install any other pipdig theme.', 'p3-textdomain' ).'</p><p>'.__( 'WARNING: these options can break your site. Use with caution.', 'p3-textdomain' ).'</p>';

	}
}


if (!function_exists('pipdig_hooks_options_page')) {
	function pipdig_hooks_options_page() { 

		?>
		<form action='options.php' method='post'>
			
			<h2><?php _e('pipdig Theme Hooks', 'p3-textdomain'); ?></h2>
			
			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>
			
		</form>
		<h3><?php printf(__('Remember, you can also change the appearance of your site by using the %sCustomizer%s.', 'p3-textdomain'), '<a href="'.admin_url( 'customize.php' ).'">', '</a>'); ?></h3>
		<?php

	}
}

if (!function_exists('pipdig_head_stuff')) {
	function pipdig_head_stuff() { // wp_head
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (isset($options['pipdig_textarea_css'])) {
			$output .= '<!-- pipdig custom css --><style>' . $options['pipdig_textarea_css'] . '</style><!-- // pipdig custom css head -->';
		}
		if (isset($options['pipdig_textarea_scripts'])) {
			$output .= '<!-- pipdig custom code head -->' . $options['pipdig_textarea_scripts'] . '<!-- // pipdig custom code head -->';
		}
		echo $output;
	}
	add_action('wp_head','pipdig_head_stuff');
}


if (!function_exists('pipdig_opening_body_stuff')) {
	function pipdig_opening_body_stuff() { // After opening <body> tag
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (isset($options['pipdig_textarea_body_scripts'])) {
			$output .= '<!-- pipdig custom after <body> -->' . $options['pipdig_textarea_body_scripts'] . '<!-- // pipdig custom after <body> -->';
		}
		echo $output;
	}
	add_action('before','pipdig_opening_body_stuff');
}


if (!function_exists('pipdig_footer_stuff')) {
	function pipdig_footer_stuff() { // wp_footer
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (isset($options['pipdig_textarea_footer_scripts'])) {
			$output .= '<!-- custom footer code -->' . $options['pipdig_textarea_footer_scripts'];
		}
		echo $output;
	}
	add_action('wp_footer','pipdig_footer_stuff');
}


if (!function_exists('pipdig_after_first_post_stuff')) {
	function pipdig_after_first_post_stuff() { // After the first post (unless grid layout)
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (isset($options['pipdig_textarea_after_first_post'])) {
			$output .= '<div class="hook_after-first-post"><!-- pipdig custom code after first post -->' . $options['pipdig_textarea_after_first_post'] . '<!-- // pipdig custom code after first post --></div>';
		}
		echo $output;
	}
	add_action('after_first_post','pipdig_after_first_post_stuff');
}
/*
Required theme styling for the above hook:

style.css:
.hook_after-first-post {
	margin: 30px auto 50px;
	text-align: center;
}

responsive.css:
@media only screen and (max-width: 400px) {
	.hook_after-first-post {
		display: none;
	}
}
*/
