<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_css_init')) {
	function pipdig_css_init() { 

		register_setting( 'pipdig_css_page', 'pipdig_css' );

		add_settings_section(
			'pipdig_pipdig_css_page_section', 
			__('Custom CSS', 'p3'),
			'pipdig_css_section_callback', 
			'pipdig_css_page'
		);

		add_settings_field( 
			'pipdig_textarea_css', 
			__( 'Any CSS added to this box will be kept after theme updates.', 'p3' ), 
			'pipdig_textarea_css_render', 
			'pipdig_css_page', 
			'pipdig_pipdig_css_page_section' 
		);

	}
	add_action( 'admin_init', 'pipdig_css_init' );
}


if (!function_exists('pipdig_textarea_css_render')) {
	function pipdig_textarea_css_render() { 

		$options = get_option( 'pipdig_css' );
		
		?>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.18.2/codemirror.min.css" rel="stylesheet" />
		<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.18.2/theme/hopscotch.css" rel="stylesheet" /> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.18.2/codemirror.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.18.2/mode/css/css.min.js"></script>
		
		<style scoped>
		.CodeMirror {
			height: 600px;
			width: 95%;
		}
		</style>
		
		<textarea style="" id="pipdig_custom_css" name="pipdig_css[pipdig_textarea_css]" placeholder="body {color: #000000; background: #ffffff}"><?php if (isset($options['pipdig_textarea_css'])) { echo $options['pipdig_textarea_css']; } ?></textarea>
		
		<script>
		jQuery(document).ready(function() {
            var editor = CodeMirror.fromTextArea(document.getElementById("pipdig_custom_css"), {
                lineNumbers: true,
                mode: "text/css",
                //theme: "hopscotch"
            });
        })
		</script>
		
		<?php

	}
}



if (!function_exists('pipdig_css_section_callback')) {
	function pipdig_css_section_callback() { 
		//_e('Any CSS added to the box below will be kept after theme updates.', 'p3');
	}
}


if (!function_exists('pipdig_css_options_page')) {
	function pipdig_css_options_page() { 

		?>
		<form action='options.php' method='post'>
		
			<?php
			settings_fields( 'pipdig_css_page' );
			do_settings_sections( 'pipdig_css_page' );
			submit_button();
			?>
			
		</form>
		<h3><?php printf(__('Remember, you can also change the appearance of your site by using the <a href="%s">Customizer</a>.', 'p3'), admin_url('customize.php')); ?></h3>
		<?php

	}
}

if (!function_exists('pipdig_css_head')) {
	function pipdig_css_head() { // wp_head
		$output = '';
		$options = get_option( 'pipdig_css', '' );
		if (!empty($options['pipdig_textarea_css'])) {
			$output .= '<!-- pipdig custom css --><style>' . $options['pipdig_textarea_css'] . '</style><!-- // pipdig custom css -->';
		}
		echo $output;
	}
	add_action('wp_head','pipdig_css_head', 999);
}

