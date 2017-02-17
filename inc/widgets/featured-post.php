<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class pipdig_widget_featured_post_function extends WP_Widget {

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'the_post' => '',
			'description' => '',
			'circle' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_widget_featured_post',
			'description' => __('Display a featured post.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_widget_featured_post',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct('pipdig_widget_featured_post', 'pipdig - '.__('Featured Post', 'p3'), $widget_ops, $control_ops);

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
			
			if (!empty($instance['description'])) {
				echo wpautop(do_shortcode($instance['description']));
			}

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['description'] = wp_kses_post($new_instance['description']);
		$new_instance['circle'] = strip_tags($new_instance['circle']);
		$new_instance['the_post'] = strip_tags($new_instance['the_post']);

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
		
		<?php
		$args = array(
			'posts_per_page'=> -1,
			//'fields' => 'ids',
			'post_type' => 'post',
			'post_status' => 'publish',
		);

		$posts_array = get_posts( $args );
		
		if (isset($instance['the_post'])) { 
			$the_post = $instance['the_post'];
		} else {
			$the_post = '';
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('the_post'); ?>"><?php _e('Post to feature:', 'p3'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'the_post' ); ?>" name="<?php echo $this->get_field_name( 'the_post' ); ?>">
				<?php foreach($posts_array as $a_post) { ?>
					<option value="<?php echo $a_post->ID; ?>" <?php if ( $a_post->ID == $the_post ) echo 'selected="selected"'; ?>><?php echo $a_post->post_title; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('circle'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('circle'); ?>" name="<?php echo $this->get_field_name('circle'); ?>" <?php if (isset($instance['circle'])) { checked((bool) $instance['circle'], true); } ?> /><?php _e('Change image to a circle', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Add some text below the photo: (optional)', 'p3'); ?></label>
			<textarea id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" class="widefat"><?php if (isset($instance['description'])) echo wp_kses_post($instance['description']); ?></textarea>
		</p>

		<?php

	}

}


/**
 * Register Widget
 */
function register_pipdig_widget_featured_post() { 
	register_widget('pipdig_widget_featured_post_function');
}
add_action('widgets_init', 'register_pipdig_widget_featured_post');
