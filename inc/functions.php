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
			return 'http://pipdigz.co.uk/p3/img/catch-placeholder.jpg';
		}
		$first_img = $matches [1] [0];
		return $first_img;
	}
}

/* Add Featured Image to feed -------------------------------------------------------*/
if (!function_exists('pipdig_p3_rss_post_thumbnail')) {
	function pipdig_p3_rss_post_thumbnail($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . get_the_excerpt();
		} else {
			$content = '<p><img src="'.pipdig_p3_catch_that_image().'" alt=""/></p>' . get_the_excerpt();
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'pipdig_p3_rss_post_thumbnail');
	add_filter('the_content_feed', 'pipdig_p3_rss_post_thumbnail');
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



/*  Remove pointless front end widgets ----------------------------------------------*/
function pipdig_p3_unregister_default_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
}
add_action('widgets_init', 'pipdig_p3_unregister_default_widgets', 11);

/*  Remove pointless dashboard widgets ----------------------------------------------*/
function pipdig_p3_pipdig_remove_dashboard_meta() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'pipdig_p3_pipdig_remove_dashboard_meta' );

/*  Remove pointless meta boxes on posts --------------------------------------------*/
function pipdig_p3_remove_default_post_metaboxes() {
	remove_meta_box( 'trackbacksdiv','post','normal' );
	remove_meta_box( 'slugdiv','post','normal' );
	remove_meta_box( 'revisionsdiv','post','normal' );
}
add_action('admin_menu','pipdig_p3_remove_default_post_metaboxes');

/*  Remove pointless meta boxes on pages --------------------------------------------*/
function pipdig_p3_remove_default_page_metaboxes() {
	remove_meta_box( 'postexcerpt','page','normal' );
	if (get_theme_mod('page_comments')){ remove_meta_box( 'commentstatusdiv','page','normal' ); }
	remove_meta_box( 'trackbacksdiv','page','normal' );
	remove_meta_box( 'slugdiv','page','normal' );
	remove_meta_box( 'revisionsdiv','page','normal' );
}
add_action('admin_menu','pipdig_p3_remove_default_page_metaboxes');

