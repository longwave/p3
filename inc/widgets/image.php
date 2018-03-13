<?php
if (!defined('ABSPATH')) die;

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
			'nofollow' => '',
			'width' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_image_widget',
			'description' => __('Upload a single image with an optional link.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_image_widget',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct('pipdig_image_widget', 'pipdig - '.__('Image Widget', 'p3'), $widget_ops, $control_ops);

	}

	// The widget content.
	function widget($args, $instance) {

		//* Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		echo $args['before_widget'];

			if (! empty($instance['title']))
				echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
			
			$target = $link_open = $link_close = $nofollow = $width = '';
			
			if (!empty($instance['nofollow'])) {
				if (!empty($instance['nofollow'])) {
					$nofollow = ' rel="nofollow noopener"';
				}
			}
			
			if (!empty($instance['link'])) {
				if (!empty($instance['target'])) {
					$target = 'target="_blank"';
				}
				$link_open = '<a href="'.esc_url($instance['link']).'" '.$target.$nofollow.'>';
				$link_close = '</a>';
			}
			
			if (!empty($instance['width'])) {
				if (!empty($instance['width'])) {
					$width = 'style="max-width:100%;width:'.absint($instance['width']).'px"';
				}
			}

			if (!empty($instance['image_uri'])) {
				$image_link = $instance['image_uri'];
				$image_data = pipdig_get_attachment_id($instance['image_uri']); // use the medium thumbnail if we can find it
				if ($image_data) {
					$img_size = 'medium';
					if ($args['id'] != 'sidebar-1') {
						$img_size = 'large';
					}
					$image_link = wp_get_attachment_image_src($image_data, $img_size);
					$image_link = reset($image_link); // php <5.4 way to get [0] value of array
					$image_link = str_replace('http:', '', $image_link);
				}
				
				$lazy_class = '';
				if (is_pipdig_lazy()) {
					$lazy_class = 'class="pipdig_lazy"';
					$image_src = 'data-src="'.esc_url($image_link).'"';
				} else {
					$image_src = 'src="'.esc_url($image_link).'"';
				}
				
				echo $link_open.'<img '.$image_src.' '.$lazy_class.' alt="" data-pin-nopin="true" '.$width.' />'.$link_close;
			}

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$new_instance['link'] = strip_tags($new_instance['link']);
		$new_instance['target'] = strip_tags($new_instance['target']);
		$new_instance['nofollow'] = strip_tags($new_instance['nofollow']);
		$new_instance['width'] = intval($new_instance['width']);

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
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Image Width:', 'p3'); ?></label>
			<input type="number" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr($instance['width']); ?>" /> px
			<br />
			<div style="font-style:italic">Leave the option above blank if you would like the image to be full size.</div>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link to open when clicked:', 'p3'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo esc_attr($instance['link']); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" <?php if (isset($instance['target'])) { checked((bool) $instance['target'], true); } ?> /><?php _e('Open link in a new window', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('nofollow'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('nofollow'); ?>" name="<?php echo $this->get_field_name('nofollow'); ?>" <?php if (isset($instance['nofollow'])) { checked((bool) $instance['nofollow'], true); } ?> /><?php _e('Set link as "nofollow"', 'p3'); ?></label>
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
