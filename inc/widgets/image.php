<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function pipdig_image_upload_script() {
	global $pagenow, $wp_customize;
	if ('widgets.php' === $pagenow || isset($wp_customize)) {
		wp_enqueue_media();
		wp_enqueue_script('pipdig-image-upload', plugin_dir_url( __FILE__ ) . '../../assets/js/image-upload.js', array('jquery'));
	}
}
add_action('admin_enqueue_scripts', 'pipdig_image_upload_script');


/**
 * Image Upload Widget
 */
class pipdig_Image_Widget extends WP_Widget {

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'image_uri' => '',
			'link' => '',
			'target' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig-media-widget',
			'description' => __('Upload a single image with an optional link.', 'wpshed'),
		);

		$control_ops = array(
			'id_base' => 'pipdig-media-widget',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct('pipdig-media-widget', 'pipdig - '.__('Image Widget', 'p3'), $widget_ops, $control_ops);

	}

	// The widget content.
	function widget($args, $instance) {

		//* Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		echo $args['before_widget'];

			if (! empty($instance['title']))
				echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
			
			$target = $link_open = $link_close = '';
			if (!empty($instance['link'])) {
				if (!empty($instance['target'])) {
					$target = 'target="_blank"';
				}
				$link_open = '<a href="'.esc_url($instance['link']).'" '.$target.'>';
				$link_close = '</a>';
			}

			if (!empty($instance['image_uri'])) {
				echo $link_open.'<img src="'.esc_url($instance['image_uri']).'" alt="" />'.$link_close;
			}

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$new_instance['link'] = strip_tags($new_instance['link']);
		$new_instance['target'] = strip_tags($new_instance['target']);

		return $new_instance;

	}

	// The settings update form.
	function form($instance) {

		// Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>

		<p>
			<div class="pipdig-media-container">
				<div class="pipdig-media-inner">
					<?php $img_style = ($instance[ 'image_uri' ] != '') ? '' : 'display:none;'; ?>
					<img id="<?php echo $this->get_field_id('image_uri'); ?>-preview" src="<?php echo esc_attr($instance['image_uri']); ?>" style="max-width: 100%; height: auto;<?php echo $img_style; ?>" />
					<?php $no_img_style = ($instance[ 'image_uri' ] != '') ? 'style="display:none;"' : ''; ?>
				</div>
			
				<input type="text" id="<?php echo $this->get_field_id('image_uri'); ?>" name="<?php echo $this->get_field_name('image_uri'); ?>" value="<?php echo esc_attr($instance['image_uri']); ?>" class="pipdig-media-url" style="display: none" />

				<input type="button" value="<?php echo esc_attr(__('Remove', 'p3')); ?>" class="button pipdig-media-remove" id="<?php echo $this->get_field_id('image_uri'); ?>-remove" style="<?php echo $img_style; ?>" />

				<input type="button" value="<?php echo esc_attr(__('Select Image', 'p3')); ?>" class="button pipdig-media-upload" id="<?php echo $this->get_field_id('image_uri'); ?>-button" />
				<br class="clear">
			</div>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link/URL: (optional)', 'wpshed'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo esc_attr($instance['link']); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php if (isset($instance['target'])) { checked((bool) $instance['target'], true); } ?> /><?php _e('Open link in a new window', 'p3'); ?></label>
		</p>
		
		<?php

	}

}


/**
 * Register Widget
 */
function register_pipdig_image_upload_widget() { 
	register_widget('pipdig_Image_Widget');
}
add_action('widgets_init', 'register_pipdig_image_upload_widget');
