<?php
// load plugin check function, just in case theme hasn't
if ( !function_exists( 'pipdig_plugin_check' ) ) {
	function pipdig_plugin_check( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active($plugin_name) ) {
			return true;
		} else {
			return false;
		}
	}
}

// load image catch function, just in case theme hasn't
if (!function_exists('pipdig_p3_catch_that_image')) {
	function pipdig_p3_catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(empty($output)){
			return;
		}
		$first_img = $matches [1] [0];
		return $first_img;
	}
}

// remove mojo crap
function pipdig_p3_bad_mojo() {
	remove_action( 'admin_menu', 'mm_main_menu' ); // remove mojo menu
	remove_action( 'widgets_init', 'mm_register_widget' ); // remove mojo widget
	remove_action( 'admin_head-themes.php', 'mm_add_theme_button' ); // remove mojo theme menu item
	remove_action( 'admin_menu', 'mm_add_theme_page' ); // remove mojo themes link
	
	remove_action( 'widgets_init', 'akismet_register_widgets' ); // remove akismet widget
}
add_action('plugins_loaded','pipdig_p3_bad_mojo');


// add pipdig link to themes section
function pipdig_p3_themes_top_link() {
	if(!isset($_GET['page'])) {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.add-new-h2').before('<a class="add-new-h2" href="http://www.pipdig.co/products/wordpress-themes?utm_source=wpmojo&utm_medium=wpmojo&utm_campaign=wpmojo" target="_blank">pipdig <?php _e('Themes', 'p3'); ?></a>');
	});
	</script>
	<?php
	}
}
add_action( 'admin_head-themes.php', 'pipdig_p3_themes_top_link' );




function pipdig_p3_emmmm_heeey() {
	?>
	<script>	
	jQuery(document).ready(function($) {
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			   $("#cookie-law-info-bar,.cc_container").slideUp();
		   } else {
			   $("#cookie-law-info-bar,.cc_container").slideDown()
		   }
		});
	});
	</script>
	<?php
}
add_action('wp_footer','pipdig_p3_emmmm_heeey');