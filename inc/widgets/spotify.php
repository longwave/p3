<?php 

if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_widget_spotify' ) ) {
	class pipdig_widget_spotify extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_spotify', 'description' => 'Display a Spotify album or playlist.' );
		  parent::__construct('pipdig_widget_spotify', 'pipdig - Spotify', $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		$uri = '';
		if (isset($instance['uri'])) { 
			$uri =	$instance['uri'];
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		
		//$uri = 'spotify:user:1267886046:playlist:0SNGfP9RryG601gA8JPz9r';
		
		if ($uri) {
			echo '<iframe src="https://open.spotify.com/embed?uri='.sanitize_text_field($uri).'&theme=white" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media" style="width:100%"></iframe>';
		} else {
			echo 'Spotify widget in section "'.$args['name'].'": '.__('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$uri = '';
		if (isset($instance['uri'])) { 
			$uri =	$instance['uri'];
		}
	   
		// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>Please see <a href="https://support.pipdig.co/articles/wordpress-spotify-widget/" target="_blank" rel="noopener">this guide</a> before using this widget.</p>
		<p>
			<label for="<?php echo $this->get_field_id('uri'); ?>"><?php _e('Spotify URI:', 'p3'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('uri'); ?>" name="<?php echo $this->get_field_name('uri'); ?>" type="text" value="<?php echo sanitize_text_field($uri); ?>" />
		</p>

		 <?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['uri'] = strip_tags($new_instance['uri']);

		return $instance;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_spotify");') );
}