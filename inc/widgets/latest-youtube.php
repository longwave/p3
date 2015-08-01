<?php 
if ( !class_exists( 'pipdig_widget_latest_youtube' ) ) {
	class pipdig_widget_latest_youtube extends WP_Widget {
	 
	  public function __construct() {
		 $widget_ops = array('classname' => 'pipdig_widget_latest_youtube', 'description' => __('Automatically displays your latest YouTube video.', 'pipdig-power-pack') );
		 $this->WP_Widget('pipdig_widget_latest_youtube', 'pipdig - ' . __('Latest YouTube', 'pipdig-power-pack'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['youtubeuser'])) { 
			$youtubeuser =	$instance['youtubeuser'];
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'YouTube' . $after_title;
		}

		if (!empty($youtubeuser)) {
			echo '<ifr' . 'ame src="http://www.youtube.com/embed?listType=user_uploads&list=' . $youtubeuser . '&showinfo=1" frameborder="0" width="560" height="315" allowfullscreen></ifra' . 'me>';
		} else {
			_e('Setup not complete. Please add your YouTube username to the YouTube Widget in the dashboard.', 'pipdig-power-pack');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['youtubeuser'])) { 
			$youtubeuser =	$instance['youtubeuser'];
		}
	   
		// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'pipdig-power-pack'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>

		<p><?php _e('Add your YouTube user/channel to the box below to show your latest video. This can be found in your channel\'s URL.', 'pipdig-power-pack'); ?></p>
		<p><?php _e('For example, the red part below:', 'pipdig-power-pack'); ?></p> <p><?php echo esc_url('http://youtube.com/user/'); ?><span style="color:red">inthefrow</span></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('youtubeuser'); ?>"><?php _e('YouTube Channel username:', 'pipdig-power-pack'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('youtubeuser'); ?>" 
			name="<?php echo $this->get_field_name('youtubeuser'); ?>" type="text" 
			value="<?php if (isset($instance['youtubeuser'])) { echo esc_attr($youtubeuser); } ?>" placeholder="inthefrow" />
			</label>
		</p>

		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['youtubeuser'] = strip_tags( $new_instance['youtubeuser'] );

		return $instance;
	  }
	  
	}
	//add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_latest_youtube");') );
} // end class exists check