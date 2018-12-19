<?php if (!defined('ABSPATH')) die;

function pipdig_import_demo_page() {

	?>
	<style>
	#p3_import_button {
		margin-bottom: 5px;
	}
	.dashicons.spin {
		animation: dashicons-spin 2s infinite;
		animation-timing-function: linear;
	}
	@keyframes dashicons-spin {
		0% {
			transform: rotate( 0deg );
		}
		100% {
			transform: rotate( 360deg );
		}
	}
	</style>
	<div class="wrap">
		<h1>Import Demo Content</h1>
		<div class="card">
			<p>Click the button below to import some demo posts, pages and widgets into this site.</p>
			<p>Please note that this will reset any widgets ane menu items that are already active. So you should only import the demo content if this is a new site.</p>
			<input name="submit" id="p3_import_button" class="button button-primary" value="Start Import!" type="submit" />
			<p id="p3_import_result"></p>
		</div>
	</div>
	<script>
	jQuery(document).ready(function($) {

		$('#p3_import_button').click(function(){

			var confirmImport = confirm('WARNING: This will remove all the current widgets, menus and theme settings. Are you sure?');
			if (confirmImport) {

				$(this).prop('disabled', true);
				$('#p3_import_result').html('<p id="p3_import_result"><span class="dashicons dashicons-update spin"></span> Importing, please wait...</p>');

				var data = {
					action: 'p3_import_demo',
				};
				$.post(ajaxurl, data, function(response) {
					//alert(response);
					$('#p3_import_result').html('<span class="dashicons dashicons-thumbs-up"></span> Import complete! <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank">Click here</a> to view your new homepage');
				});

			}

		});

	});
	</script>
	<?php
}

/**
 * Insert a widget in a sidebar.
 *
 * @param string $widget_id   ID of the widget (search, recent-posts, etc.)
 * @param array $widget_data  Widget settings.
 * @param string $sidebar     ID of the sidebar.
 */
function p3_insert_widget_in_sidebar($sidebar, $widget_id, $widget_data) {
	// Retrieve sidebars, widgets and their instances
	$sidebars_widgets = get_option('sidebars_widgets', array());
	$widget_instances = get_option('widget_' . $widget_id, array());
	// Retrieve the key of the next widget instance
	$numeric_keys = array_filter(array_keys($widget_instances), 'is_int');
	$next_key = $numeric_keys ? max($numeric_keys) + 1 : 2;
	// Add this widget to the sidebar
	if (!isset($sidebars_widgets[$sidebar])) {
		$sidebars_widgets[$sidebar] = array();
	}
	$sidebars_widgets[$sidebar][] = $widget_id . '-' . $next_key;
	// Add the new widget instance
	$widget_instances[$next_key] = $widget_data;
	// Store updated sidebars, widgets and their instances
	update_option('sidebars_widgets', $sidebars_widgets);
	update_option('widget_' . $widget_id, $widget_instances);
}

function p3_import_demo_content() {

	$theme = get_option('pipdig_theme');

	if (empty($theme)) {
		return;
	}

	// Remove Customizer settings
	remove_theme_mods();

	// Deactivate widgets (move them to inactive area)
	update_option('sidebars_widgets', array());

	// Set default sidebar widgets
	p3_insert_widget_in_sidebar('sidebar-1', 'search', array());
	p3_insert_widget_in_sidebar('sidebar-1', 'pipdig_widget_instagram', array());
	p3_insert_widget_in_sidebar('sidebar-1', 'pipdig_widget_popular_posts', array('title' => 'Popular Posts'));
	p3_insert_widget_in_sidebar('sidebar-1', 'categories', array('dropdown' => 1));
	p3_insert_widget_in_sidebar('sidebar-1', 'archives', array('dropdown' => 1));
	
	do_action('pipdig_importing_demo');
	
	if ($theme == 'aquae') {

		update_option('posts_per_page', 13);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);

	} elseif ($theme == 'arubanights') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_oswald.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'blossom') {

		//p3_insert_widget_in_sidebar('blossom_home_1', array('cols' => 4), 'pipdig_widget_instagram');

		update_option('posts_per_page', 9);
		set_theme_mod('about_me_section_enable', 0);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('site_top_search_set', 1);
		set_theme_mod('p3_share_tumblr', '');

	} elseif ($theme == 'crystal') {

		update_option('posts_per_page', 9);
		set_theme_mod('p3_instagram_kensington', 1);
		set_theme_mod('p3_instagram_number', 5);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'cultureshock') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'equinox') {

		update_option('posts_per_page', 5);
		set_theme_mod('header_full_width_slider', 1);
		set_theme_mod('header_full_width_slider_home', 1);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('hide_comments_link', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://sites.google.com/site/pipdig1/equinox-pin.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 10);
		set_theme_mod('p3_share_tumblr', '');
		set_theme_mod('p3_share_title', ' ');
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'etoile') {

		update_option('posts_per_page', 6);
		set_theme_mod('p3_instagram_header', 1);
		set_theme_mod('p3_instagram_header_all', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'evelynrose') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('p3_post_slider_posts_column_enable', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'firefly') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_billabox.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('p3_instagram_header', 1);

	} elseif ($theme == 'galvani') {

		update_option('posts_per_page', 12);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('p3_instagram_footer_title', 1);
		set_theme_mod('galvani_ig_feed', 1);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'glossromantic') {

		update_option('posts_per_page', 5);
		set_theme_mod('excerpt_layout', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_oswald.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);

	} elseif ($theme == 'hollyandweave') {

		update_option('posts_per_page', 7);
		set_theme_mod('p3_featured_panels_enable', 1);
		set_theme_mod('p3_share_title', ' ');
		set_theme_mod('p3_share_tumblr', '');
		set_theme_mod('full_width_menu', 0);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'infinite') {

		update_option('posts_per_page', 5);
		set_theme_mod('excerpt_layout', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);

	} elseif ($theme == 'kensington') {

		update_option('posts_per_page', 7);
		set_theme_mod('home_layout', 5);
		set_theme_mod('category_layout', 5);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('p3_instagram_kensington', 1);
		set_theme_mod('p3_instagram_number', 6);

	} elseif ($theme == 'londoncalling') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_oswald.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_navbar_woocommerce', 0);
		set_theme_mod('p3_navbar_twitter', 0);
		set_theme_mod('p3_navbar_instagram', 0);
		set_theme_mod('p3_navbar_facebook', 0);
		set_theme_mod('p3_navbar_email', 0);
		set_theme_mod('p3_navbar_bloglovin', 0);
		set_theme_mod('p3_navbar_pinterest', 0);
		set_theme_mod('p3_navbar_tumblr', 0);
		set_theme_mod('p3_navbar_snapchat', 0);
		set_theme_mod('p3_navbar_youtube', 0);
		set_theme_mod('p3_navbar_linkedin', 0);
		set_theme_mod('p3_navbar_soundcloud', 0);
		set_theme_mod('p3_navbar_spotify', 0);
		set_theme_mod('p3_navbar_itunes', 0);
		set_theme_mod('p3_navbar_flickr', 0);
		set_theme_mod('p3_navbar_vk', 0);
		set_theme_mod('p3_navbar_google_plus', 0);
		set_theme_mod('p3_navbar_twitch', 0);
		set_theme_mod('p3_navbar_stumbleupon', 0);
		set_theme_mod('p3_navbar_goodreads', 0);
		set_theme_mod('p3_navbar_etsy', 0);
		set_theme_mod('p3_navbar_reddit', 0);
		set_theme_mod('p3_navbar_digg', 0);
		set_theme_mod('p3_navbar_rss', 0);

	} elseif ($theme == 'maryline') {

		p3_insert_widget_in_sidebar('after-first-post', array('cols' => 5, 'images_num' => 5), 'pipdig_widget_instagram');

		update_option('posts_per_page', 10);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('hide_comments_link', 1);
		set_theme_mod('p3_share_tumblr', '');
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'minim') {

		update_option('posts_per_page', 5);
		set_theme_mod('p3_pinterest_hover_image_file','https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position','top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('excerpt_layout', 1);

	} elseif ($theme == 'opulence') {

		p3_insert_widget_in_sidebar('after-first-post', array('cols' => 4), 'pipdig_widget_instagram');

		update_option('posts_per_page', 5);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('p3_share_tumblr', '');

	} elseif ($theme == 'sartorial') {

		update_option('posts_per_page', 18);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'styleandlight') {

		update_option('posts_per_page', 5);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/gold_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_post_slider_posts_column_enable', 1);
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('body_instagram', 1);

	} elseif ($theme == 'thegrid') {

		update_option('posts_per_page', 9);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_share_tumblr', '');
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_oswald.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);

	} elseif ($theme == 'tundra') {

		update_option('posts_per_page', 5);
		set_theme_mod('p3_instagram_footer', 1);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('p3_share_tumblr', '');
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_oswald.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('p3_trending_bar_enable', 1);
		set_theme_mod('p3_trending_bar_overlay', 0);
		set_theme_mod('p3_trending_bar_trending_dates', '3 months ago');

	} elseif ($theme == 'valentine') {

		update_option('posts_per_page', 5);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);

	} elseif ($theme == 'venture') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/black_top_left.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('pipdig_lazy', 1);
		set_theme_mod('site_top_search', 1);

	} elseif ($theme == 'vivaviva') {

		update_option('posts_per_page', 5);
		set_theme_mod('home_layout', 2);
		set_theme_mod('category_layout', 2);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white_josefin.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'center');
		set_theme_mod('p3_pinterest_hover_margin', 0);
		set_theme_mod('site_top_search', 1);
		set_theme_mod('pipdig_lazy', 1);

	} elseif ($theme == 'youandme') {

		update_option('posts_per_page', 5);
		set_theme_mod('excerpt_layout', 1);
		set_theme_mod('p3_pinterest_hover_image_file', 'https://pipdigz.co.uk/p3/img/pin/white-corner.png');
		set_theme_mod('p3_pinterest_hover_image_position', 'top left');
		set_theme_mod('p3_pinterest_hover_margin', 0);

	}

	// https://developer.wordpress.org/reference/functions/wp_insert_category/
	$cat_1 = wp_insert_category(array('cat_name' => 'Travel'));
	$cat_2 = wp_insert_category(array('cat_name' => 'Music'));
	$cat_3 = wp_insert_category(array('cat_name' => 'Lifestyle'));

	$cats = array(absint($cat_1), absint($cat_2), absint($cat_3));

	$post_titles = array(
		'This is an example of a post',
		'This is another example of a post',
		'This is an example post',
		'This is a blog post example',
		'This is a post title',
		'This is another post title',
		'This is an example blog post',
		'This is an example of a post'
	);

	$images = array(
		'https://maryline.pipdig.co/wp-content/uploads/2016/02/kaboompics_Purple-flowers-in-a-pot-with-a-fruit-cake.jpg',
		'https://maryline.pipdig.co/wp-content/uploads/2017/11/kaboompics_Man-and-Woman-Holding-Ice-Creams.jpg',
		'https://galvani.pipdig.co/wp-content/uploads/2016/02/kaboompics.com_Wooden-Keyboard-Or%C3%A9e-Gold-Jewelry-II.jpg',
		'https://etoile.pipdig.co/wp-content/uploads/2015/11/blue-fashion-footwear-1182701.jpg',
		'https://sartorial.pipdig.co/wp-content/uploads/2016/02/fwhn2zsd.jpg',
		'https://sartorial.pipdig.co/wp-content/uploads/2018/05/helena-hertz-256399-unsplash.jpg',
		'https://maryline.pipdig.co/wp-content/uploads/2015/08/dog-pillow.jpg',
		'https://maryline.pipdig.co/wp-content/uploads/2015/07/breakfast4.jpg',
		'https://galvani.pipdig.co/wp-content/uploads/2015/12/kaboompics.com_Spring-flowers-on-a-table.jpg',
		'https://etoile2.pipdig.co/wp-content/uploads/2015/12/black-coffee-breakfast-cake-709833.jpg',
		'https://galvani.pipdig.co/wp-content/uploads/2016/02/08.jpg',
		'https://etoile4.pipdig.co/wp-content/uploads/2016/02/jared-rice-388253-unsplash.jpg',
		'https://etoile4.pipdig.co/wp-content/uploads/2015/05/04.jpg',
		'https://etoile4.pipdig.co/wp-content/uploads/2015/10/06.jpg',
		'https://etoile4.pipdig.co/wp-content/uploads/2015/08/01.jpg'
	);

	$post_content_start = array(
		'<p>Ice cream muffin jujubes wafer jelly beans cotton candy caramels biscuit. Caramels ice cream muffin cookie <a href="https://www.pipdig.co" target="_blank">pipdig</a> ice cream lollipop. Ice cream wafer tart croissant croissant gummies fruitcake.</p>',
		'<p>Dessert sesame snaps tiramisu carrot cake <a href="https://www.pipdig.co" target="_blank">pipdig</a> dessert jelly-o macaroon cake. Tart pie toffee ice cream cake. Chupa chups jelly-o fruitcake lemon drops croissant marshmallow oat cake.</p>',
		'<p>Brownie jelly beans ice cream macaroon chocolate bar cake jelly lemon drops <a href="https://www.pipdig.co" target="_blank">pipdig</a> candy. Jelly-o pudding gingerbread donut chupa chups brownie tootsie roll soufflé. Brownie dessert cupcake.</p>',
		'<p>Tootsie roll marzipan dessert gummies. Jujubes apple pie biscuit muffin. Sweet gummi bears <a href="https://www.pipdig.co" target="_blank">pipdig</a> chocolate soufflé chupa chups biscuit liquorice.</p>',
		'<p>Lemon drops icing biscuit croissant bonbon fruitcake toffee tiramisu sweet. Dragée croissant dragée jelly-o sesame snaps cupcake muffin powder. Gummi bears wafer tart sesame snaps dessert brownie. Jelly beans pie cheesecake cotton candy <a href="https://www.pipdig.co" target="_blank">pipdig</a> gummies chupa chups.</p>',
		'<p>Cake sweet roll sesame snaps tootsie roll toffee tiramisu cotton candy brownie sweet roll. Lollipop cake brownie liquorice halvah biscuit gummi bears. Donut candy jelly beans sugar plum candy canes carrot cake. Dessert pastry gummies. Bear claw jelly-o cake chocolate <a href="https://www.pipdig.co" target="_blank">pipdig</a>. Apple pie cheesecake sugar plum.</p>'
	);

	$post_content_end = array(
		'<p>Marshmallow brownie oat cake croissant ice cream. Cake lemon drops oat cake topping topping. Toffee jelly-o donut croissant topping marzipan gummies chocolate cake cake. Tart candy ice cream toffee cotton candy candy canes cookie cupcake. Sugar plum cotton candy sweet roll candy. Tart marshmallow dessert jelly-o jujubes lollipop jelly danish cake. Soufflé chocolate cake icing. Caramels cake powder cheesecake jujubes. Jelly-o bear claw soufflé. Soufflé jelly marshmallow wafer tiramisu cotton candy pudding <a href="https://www.pipdig.co" target="_blank">pipdig</a>.</p>',
		'<p>Brownie cake chocolate cake jelly. Gingerbread cheesecake candy canes powder muffin ice cream ice cream tiramisu icing. Pudding chocolate bar icing oat cake topping croissant. Caramels gingerbread sugar plum tootsie roll <a href="https://www.pipdig.co" target="_blank">pipdig</a> chocolate cake soufflé jelly-o bonbon. Apple pie chocolate bar marshmallow croissant marshmallow gingerbread cupcake biscuit. Jelly icing cake tootsie roll caramels. Chupa chups gummi bears jelly-o. Pastry cotton candy wafer marshmallow brownie tart toffee bear claw candy. Macaroon powder jujubes biscuit danish marzipan croissant icing chocolate cake. Brownie chocolate cake tart.</p>',
		'<p>Cotton candy candy canes biscuit tiramisu cake. Toffee jelly beans ice cream powder candy canes apple pie cake lemon drops. Topping donut gummi bears apple pie chocolate gummies gummi bears. Marzipan danish halvah chocolate cake donut sesame snaps <a href="https://www.pipdig.co" target="_blank">pipdig</a> liquorice. Ice cream halvah lemon drops danish biscuit bonbon fruitcake. Gummies jujubes tiramisu lollipop.</p>',
		'<p>Jelly beans sugar plum bonbon tiramisu sugar plum muffin chupa chups powder halvah. Dessert apple pie dessert bear claw croissant pudding. Gummies pie jujubes. Carrot cake apple pie liquorice sweet. Pudding candy canes chupa chups bear claw apple pie. Jelly-o powder sweet roll marshmallow donut muffin pudding caramels. Topping croissant cheesecake cupcake. Cheesecake cookie jujubes jelly. Soufflé jelly apple pie <a href="https://www.pipdig.co" target="_blank">pipdig</a> chupa chups croissant bear claw macaroon dragée biscuit. Halvah jelly beans bonbon marzipan macaroon brownie candy canes.</p>'
	);

	foreach ($images as $image) {

		$post_content = $post_content_start[array_rand($post_content_start)].'<img src="'.$image.'" alt="" />'.$post_content_end[array_rand($post_content_end)];

		$args = array(
			'post_title' => $post_titles[array_rand($post_titles)],
			'post_type' => 'post',
			'post_status' => 'publish',
			'ping_status' => 'closed',
			'post_category' => array($cats[array_rand($cats)]),
			'meta_input' => array(
				'pipdig_meta_homepage_secondary_img' => 'value of pipdig_meta_test_meta_key',
			),
			'post_content' => $post_content
		);

		// https://developer.wordpress.org/reference/functions/wp_insert_post/
		wp_insert_post($args);

	}

	$page_1_args = array(
		'post_title' => 'About',
		'post_type' => 'page',
		'post_status' => 'publish',
		'post_content' => '<p>This is an example of a page, which works a little differently to blog posts. Pages can be used to list any general information, such as an "About Me" page where you can introduce yourself and your website.</p><p>You can add or edit any pages in the <a href="'.admin_url('edit.php?post_type=page').'" rel="nofollow">Pages section of your dashboard</a>.</p><p>Unlike blog posts, pages do not show a date or comments.</p><p>After creating any pages, you can add them to the main menu/navbar on your site via <a href="https://support.pipdig.co/articles/wordpress-how-to-create-the-main-menu-navbar/" target="_blank">this guide</a>.</p>'
	);

	$page_1 = wp_insert_post($page_1_args);

	$page_2_args = array(
		'post_title' => 'Contact',
		'post_type' => 'page',
		'post_status' => 'publish',
		'post_content' => '<p style="text-align: center">This is an example of a contact page where you could add some information about how people can reach you.</p><p style="text-align: center">You could include a contact form or simply your email address. After adding your social links to <a href="'.admin_url('admin.php?page=pipdig-links').'" rel="nofollow">this page</a>, they will appear as icons below:</p><p style="text-align: center">[pipdig_social_icons]</p>'
	);

	$page_2 = wp_insert_post($page_2_args);

	$menu_name = 'pipdig Primary Menu';
	$menu_exists = wp_get_nav_menu_object($menu_name);

	// If it doesn't exist, let's create it.
	if (!$menu_exists) {

		// remove current menus
		remove_theme_mod('nav_menu_locations');

		$menu_id = wp_create_nav_menu($menu_name);

	    wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Home',
				'menu-item-classes' => 'home',
				'menu-item-url' => '/',
				'menu-item-status' => 'publish'
			));

			if (absint($page_1)) {
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => 'About',
					'menu-item-object-id' => $page_1,
					'menu-item-object' => 'page',
					'menu-item-status' => 'publish',
					'menu-item-type' => 'post_type',
				));
			}

			foreach ($cats as $cat_id) {
				if ($cat_id < 1) {
					continue;
				}
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => get_cat_name($cat_id),
					'menu-item-object-id' => $cat_id,
					'menu-item-db-id' => 0,
					'menu-item-object' => 'category',
					'menu-item-parent-id' => 0,
					'menu-item-type' => 'taxonomy',
					'menu-item-url' => get_category_link($cat_id),
					'menu-item-status' => 'publish',
				));
			}

			if (absint($page_2)) {
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => 'Contact',
					'menu-item-object-id' => $page_2,
					'menu-item-object' => 'page',
					'menu-item-status' => 'publish',
					'menu-item-type' => 'post_type',
				));
			}

		// remove current menus
		remove_theme_mod('nav_menu_locations');

		// Set new one
		set_theme_mod('nav_menu_locations', array(
			'primary' => $menu_id,
		));

	}

	delete_transient('pipdig_fonts');

	// remove any homepage settings
	update_option('show_on_front', 'posts');
	delete_option('page_on_front');
	delete_option('page_for_posts');

	update_option('link_manager_enabled', 0);

	update_option('thumbnail_size_h', 150);
	update_option('thumbnail_size_w', 150);
	update_option('medium_size_w', 300);
	update_option('medium_size_h', 0);
	update_option('medium_large_size_w', 0);
	update_option('medium_large_size_h', 0);
	update_option('large_size_w', 1440);
	update_option('large_size_h', 0);

	update_option('image_default_size', 'large');
	update_option('image_default_align', 'none');
	update_option('image_default_link_type', 'none');

	update_option('p3_demo_imported', 1);

	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure('/%postname%/');
	flush_rewrite_rules();

	wp_die();

}
add_action('wp_ajax_p3_import_demo', 'p3_import_demo_content');
