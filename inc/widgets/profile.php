<?php
if (!defined('ABSPATH')) die;

/**
 * Image Upload Widget
 */
class pipdig_widget_profile_function extends WP_Widget {

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'image_uri' => '',
			'description' => '',
			'circle' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_widget_profile',
			'description' => __('Show a profile photo and some "About Me" text.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_widget_profile',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct('pipdig_widget_profile', 'pipdig - '.__('Profile Photo', 'p3'), $widget_ops, $control_ops);

	}

	// The widget content.
	function widget($args, $instance) {

		//* Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		echo $args['before_widget'];

			if (! empty($instance['title']))
				echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
			
			$circle = '';
			if (!empty($instance['circle'])) {
				$circle = 'style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"';
			}
			
			$horizontal = true;
			if ($args['id'] == 'sidebar-1' || $args['id'] == 'sidebar-2' || $args['id'] == 'sidebar-3' || $args['id'] == 'sidebar-4' || $args['id'] == 'sidebar-5') {
				$horizontal = false;
			} 

			if (!empty($instance['image_uri'])) {
				$image_src = $instance['image_uri'];
				$image_data = pipdig_get_attachment_id($instance['image_uri']); // use the medium thumbnail if we can find it
				if ($image_data) {
					$image_src = wp_get_attachment_image_src($image_data, 'medium');
					$image_src = reset($image_src); // php <5.4 way to get [0] value of array
					$image_src = str_replace('http:', '', $image_src);
				}
				$img = '<div class="nopin"><img src="'.esc_url($image_src).'" alt="" '.$circle.' data-pin-nopin="true" /></div>';
			}
			
			if (!empty($instance['description'])) {
				$desc = wpautop(do_shortcode($instance['description']));
			}
			
			if ($horizontal) {
				echo '<div class="col-sm-6">'.$img.'</div>';
				echo '<div class="col-sm-6">'.$desc.'</div>';
				echo '<div class="clearfix"></div>';
			} else {
				echo $img;
				echo $desc;
			}

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$new_instance['description'] = wp_kses_post($new_instance['description']);
		$new_instance['circle'] = strip_tags($new_instance['circle']);

		return $new_instance;

	}

	// The settings update form.
	function form($instance) {

		// Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>

		<p>
			<div class="pipdig-media-container">
				<div class="pipdig-media-inner">
					<?php $img_style = ($instance[ 'image_uri' ] != '') ? '' : 'display:none;'; ?>
					<?php
					$circle = '';
					if (!empty($instance['circle'])) {
						$circle = '-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;';
					}
					?>
					<img id="<?php echo $this->get_field_id('image_uri'); ?>-preview" src="<?php echo esc_attr($instance['image_uri']); ?>" style="max-width: 100%; height: auto;<?php echo $circle.$img_style; ?>" />
					<?php $no_img_style = ($instance[ 'image_uri' ] != '') ? 'style="display:none;"' : ''; ?>
				</div>
			
				<input type="text" id="<?php echo $this->get_field_id('image_uri'); ?>" name="<?php echo $this->get_field_name('image_uri'); ?>" value="<?php echo esc_attr($instance['image_uri']); ?>" class="pipdig-media-url" style="display: none" />

				<input type="button" value="<?php echo esc_attr(__('Remove', 'p3')); ?>" class="button pipdig-media-remove" id="<?php echo $this->get_field_id('image_uri'); ?>-remove" style="<?php echo $img_style; ?>" />

				<input type="button" value="<?php echo esc_attr(__('Select Image', 'p3')); ?>" class="button pipdig-media-upload" id="<?php echo $this->get_field_id('image_uri'); ?>-button" />
				<br class="clear">
			</div>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('circle'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('circle'); ?>" name="<?php echo $this->get_field_name('circle'); ?>" <?php if (isset($instance['circle'])) { checked((bool) $instance['circle'], true); } ?> /><?php _e('Change image to a circle', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Text to show below the photo: (optional)', 'p3'); ?></label>
			<textarea id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" class="widefat" rows="4"><?php if (isset($instance['description'])) echo wp_kses_post($instance['description']); ?></textarea>
		</p>
		
		<?php

	}

}


/**
 * Register Widget
 */
function register_pipdig_widget_profile() { 
	register_widget('pipdig_widget_profile_function');
}
add_action('widgets_init', 'register_pipdig_widget_profile');
