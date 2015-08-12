<?php

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
		
		add_settings_field( 
			'pipdig_textarea_after_first_post', 
			__( 'Code to add directly after the first post on the home page or any archive', 'p3' ).'<p style="font-style:normal;font-weight:normal;">'.__( 'For example, you may wish to place a banner ad after the first post', 'p3' ).'</p>', 
			'pipdig_textarea_after_first_post_render', 
			'pipdig_hooks_page', 
			'pipdig_pipdig_hooks_page_section' 
		);


	}
	add_action( 'admin_init', 'pipdig_settings_init' );
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
		echo '<p>'.__( 'Use the fields below to add custom code to the Head, Body or Footer of your site.', 'p3' ).'</p><p>'.__( 'These settings will be carried over if you install any other pipdig theme.', 'p3' ).'</p><p>'.__( 'WARNING: these options can break your site. Use with caution.', 'p3' ).'</p>';

	}
}


if (!function_exists('pipdig_hooks_options_page')) {
	function pipdig_hooks_options_page() { 
		?>
		<form action='options.php' method='post'>
			
			<h2><?php _e('pipdig Theme Hooks', 'p3'); ?></h2>
			
			<?php
			settings_fields( 'pipdig_hooks_page' );
			do_settings_sections( 'pipdig_hooks_page' );
			submit_button();
			?>
			
		</form>
		<?php
	}
}

if (!function_exists('pipdig_head_stuff')) {
	function pipdig_head_stuff() { // wp_head
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (!empty($options['pipdig_textarea_scripts'])) {
			$output .= '<!-- pipdig p3 custom code head -->' . $options['pipdig_textarea_scripts'] . '<!-- // pipdig p3 custom code head -->';
		}
		echo $output;
	}
	add_action('wp_head','pipdig_head_stuff');
}


if (!function_exists('pipdig_opening_body_stuff')) {
	function pipdig_opening_body_stuff() { // After opening <body> tag
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (!empty($options['pipdig_textarea_body_scripts'])) {
			$output .= '<!-- pipdig p3 custom after <body> -->' . $options['pipdig_textarea_body_scripts'] . '<!-- // pipdig p3 custom after <body> -->';
		}
		echo $output;
	}
	add_action('before','pipdig_opening_body_stuff');
}


if (!function_exists('pipdig_footer_stuff')) {
	function pipdig_footer_stuff() { // wp_footer
		$output = '';
		$options = get_option( 'pipdig_settings', '' );
		if (!empty($options['pipdig_textarea_footer_scripts'])) {
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
		if (!empty($options['pipdig_textarea_after_first_post'])) {
			$output .= '<div class="hook_after-first-post"><!-- pipdig p3 custom code after first post -->' . $options['pipdig_textarea_after_first_post'] . '<!-- // pipdig p3 custom code after first post --></div>';
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
