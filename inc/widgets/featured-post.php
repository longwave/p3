<?php
if (!defined('ABSPATH')) die;

class pipdig_widget_featured_post_function extends WP_Widget {

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'the_post' => '',
			'hide_image' => '',
			'hide_title' => '',
			'hide_excerpt' => '',
			'hide_button' => '',
			'hide_label' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_widget_featured_post',
			'description' => __('Displays a featured post of your choice.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_widget_featured_post',
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
			
			$query = new WP_Query( array(
				'p' => absint($instance['the_post']),
			) );
			
			while ( $query->have_posts() ): $query->the_post();

				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
				if ($thumb) {
					$bg = esc_url($thumb['0']);
				} else {
					$bg = pipdig_p3_catch_that_image();
				}
				
				$title = get_the_title();
				$link = esc_url(get_permalink());
				
				$featured_text = '';
				if (empty($instance['hide_label'])) {
					$featured_text = '<div style="position: absolute; left: 0; top: 15px; background: #fff; color: #000; padding: 2px 5px;">'.__('Featured', 'p3').'</div>';
				}
				if (empty($instance['hide_image'])) {
					echo '<a href="'.$link.'" style="position:relative; display: block;">'.$featured_text.'<img class="p3_featured_post_widget_post_img" src="'.$bg.'" alt="'.$title.'" /></a>';
				}
				if (empty($instance['hide_title'])) {
					echo '<a href="'.$link.'"><h4 class="p3_featured_post_widget_post_title">'.strip_tags(get_the_title()).'</h4></a>';
				}
				if (empty($instance['hide_excerpt'])) {
					echo '<p class="p3_featured_post_widget_post_excerpt">'.strip_tags(get_the_excerpt()).'</p>';
				}
				if (empty($instance['hide_button'])) {
					echo '<div><a href="'.$link.'" class="more-link">'.__('View Post', 'p3').'</a></div>';
				}
				
			endwhile; wp_reset_query();

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['hide_image'] = strip_tags($new_instance['hide_image']);
		$new_instance['hide_title'] = strip_tags($new_instance['hide_title']);
		$new_instance['hide_excerpt'] = strip_tags($new_instance['hide_excerpt']);
		$new_instance['hide_button'] = strip_tags($new_instance['hide_button']);
		$new_instance['hide_label'] = strip_tags($new_instance['hide_label']);
		$new_instance['the_post'] = absint($new_instance['the_post']);

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
			'posts_per_page'=> 100,
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
			<label for="<?php echo $this->get_field_id('hide_image'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_image'); ?>" name="<?php echo $this->get_field_name('hide_image'); ?>" <?php if (isset($instance['hide_image'])) { checked((bool) $instance['hide_image'], true); } ?> /><?php _e('Hide the post image', 'p3'); ?></label>
		</p>
		
		<script>
		jQuery(document).ready(function($) {
			$("#<?php echo $this->get_field_id('hide_image'); ?>").change(function() {
				if(this.checked) {
					$("#<?php echo $this->get_field_id('hide_label'); ?>_wrapper").fadeOut(250);
				} else {
					$("#<?php echo $this->get_field_id('hide_label'); ?>_wrapper").fadeIn(250);
				}
			});
		});
		</script>
		
		<p id="<?php echo $this->get_field_id('hide_label'); ?>_wrapper">
			<label for="<?php echo $this->get_field_id('hide_label'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_label'); ?>" name="<?php echo $this->get_field_name('hide_label'); ?>" <?php if (isset($instance['hide_label'])) { checked((bool) $instance['hide_label'], true); } ?> /><?php _e('Hide the "Featured" label', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('hide_title'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>" <?php if (isset($instance['hide_title'])) { checked((bool) $instance['hide_title'], true); } ?> /><?php _e('Hide the post title', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('hide_excerpt'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_excerpt'); ?>" name="<?php echo $this->get_field_name('hide_excerpt'); ?>" <?php if (isset($instance['hide_excerpt'])) { checked((bool) $instance['hide_excerpt'], true); } ?> /><?php _e('Hide the post excerpt', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('hide_button'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('hide_button'); ?>" name="<?php echo $this->get_field_name('hide_button'); ?>" <?php if (isset($instance['hide_button'])) { checked((bool) $instance['hide_button'], true); } ?> /><?php _e('Hide the "View Post" button', 'p3'); ?></label>
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
