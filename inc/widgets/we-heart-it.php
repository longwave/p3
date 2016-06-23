<?php 

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_weheartit' ) ) {
	class pipdig_widget_weheartit extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_weheartit', 'description' => __('Displays your latest hearts.', 'p3') );
		  parent::__construct('pipdig_widget_weheartit', 'pipdig - ' . __("We Heart It Widget", 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		if (isset($instance['weheartit_url'])) { 
			$weheartit_url = $instance['weheartit_url'];
			$weheartit_user = parse_url($weheartit_url, PHP_URL_PATH);
			$weheartit_user = str_replace('/', '', $weheartit_user);
		} else {
			$links = get_option('pipdig_links');
			$weheartit_url = $links['weheartit'];
			$weheartit_user = parse_url($weheartit_url, PHP_URL_PATH);
			$weheartit_user = str_replace('/', '', $weheartit_user);
		}

		$show_profile = 1;
		/* if (isset($instance['show_profile'])) { 
			$show_profile = intval($instance['show_profile']);
		} */
		

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		if (!empty($weheartit_url)) {
			echo '<iframe src="https://weheartit.com/widget/hearts/'.$weheartit_user.'?=0&avatar='.$show_profile.'&title='.$show_profile.'&subtitle='.$show_profile.'&center=0&type=0" style="width: 100%; height: 380px; border: 0;" scrolling="no" frameborder="0"></iframe>';
		} else {
			_e('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		if (isset($instance['weheartit_url'])) { 
			$weheartit_url = $instance['weheartit_url'];
		} elseif (!empty($links['weheartit'])) {
			$links = get_option('pipdig_links');
			$weheartit_url = $links['weheartit'];
		} else {
			$weheartit_url = '';
		}
		$show_profile = 1;
		/* if (isset($instance['show_profile'])) { 
			$show_profile = intval($instance['show_profile']);
		} */
		 
	   	// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
		</p>

		<p><?php _e('Add your <a href="https://weheartit.com" target="_blank">We Heart It</a> profile URL to the box below. For example, https://weheartit.com/pipdig', 'p3'); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id('weheartit_url'); ?>"><?php _e('Profile URL:', 'p3'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('weheartit_url'); ?>" 
			name="<?php echo $this->get_field_name('weheartit_url'); ?>" type="text" 
			value="<?php echo esc_url($weheartit_url); ?>" placeholder="https://weheartit.com/pipdig" />
		</p>
		
		<!-- <p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_profile' ); ?>" name="<?php echo $this->get_field_name( 'show_profile' ); ?>" <?php checked(isset($instance['show_profile'])) ?> />
			<label for="<?php echo $this->get_field_id('show_profile'); ?>"><?php _e('Show Profile Info', 'p3'); ?></label>
		</p> -->
		

		 <?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = pipdig_strip($new_instance['title']);
		$instance['weheartit_url'] = esc_url($new_instance['weheartit_url']);
		//$instance['show_profile'] = intval($new_instance['show_profile']);

		return $instance;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_weheartit");') );
}