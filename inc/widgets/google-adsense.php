<?php
if (!defined('ABSPATH')) die;

class pipdig_widget_google_adsense extends WP_Widget {

	private static $allowed_tags = array(
		'script' => array(
			'async' => array(),
			'src' => array()
		),
		'ins' => array(
			'class' => array(),
			'style' => array(),
			'data-ad-client' => array(),
			'data-ad-slot' => array(),
			'data-ad-format' => array()
		),
	);

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'description' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_widget_google_adsense',
			'description' => __('Display an ad from Google Adsense.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_widget_google_adsense'
		);

		parent::__construct('pipdig_widget_google_adsense', 'pipdig - Google Adsense', $widget_ops, $control_ops);

	}

	// The widget content.
	function widget($args, $instance) {

		//* Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		echo $args['before_widget'];

			if (!empty($instance['title']))
				echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];

			if (!empty($instance['description'])) {
				//echo wp_kses($instance['description'], self::$allowed_tags);
				echo $instance['description'];
			}

			echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		//$new_instance['description'] = wp_kses($new_instance['description'], self::$allowed_tags);
		$new_instance['description'] = $new_instance['description'];

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
		<p>Please note it may take 24 hours for ads to appear if you have recently joined Adsense. It may show a blank white space until then.</p>
		<p><a href="https://support.pipdig.co/articles/wordpress-google-adsense-widget/" target="_blank" rel="noopener">Click here</a> for more information about this widget.</p>

		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>">Ad code:</label>
			<textarea id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" class="widefat code" rows="11"><?php if (isset($instance['description'])) echo $instance['description']; ?></textarea>
		</p>

		<?php

	}

}


/**
 * Register Widget
 */
function register_pipdig_widget_google_adsense() {
	register_widget('pipdig_widget_google_adsense');
}
add_action('widgets_init', 'register_pipdig_widget_google_adsense');
