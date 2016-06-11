<?php 

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_twitter' ) ) {
	class pipdig_widget_twitter extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_twitter', 'description' => __('Display your Twitter timeline.', 'p3') );
		  parent::__construct('pipdig_widget_twitter', 'pipdig - ' . __('Twitter Widget', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		$twitter_handle = '';
		if (isset($instance['twitter_handle'])) { 
			$twitter_handle = esc_attr($instance['twitter_handle']);
		}
		
		if (isset($instance['number'])) { 
			$number = absint($instance['number']);
		} else {
			$number = 3;
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		if (!empty($twitter_handle)) { ?>
			<?php $twitter_handle = str_replace('@', '', $twitter_handle); ?>
			<a class="twitter-timeline" href="https://twitter.com/<?php echo $twitter_handle; ?>" data-dnt="true" data-chrome="nofooter" data-tweet-limit="<?php echo $number; ?>" data-link-color="<?php echo get_theme_mod( 'post_links_color', '#333333' ); ?>">Tweets by <?php echo $twitter_handle; ?></a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			<br />
			<a href="https://twitter.com/<?php echo $twitter_handle; ?>" class="twitter-follow-button" data-show-count="true" data-dnt="true">Follow @<?php echo $twitter_handle; ?></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>		
		<?php } else {
			_e('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		if (isset($instance['twitter_handle'])) { 
			$twitter_handle = $instance['twitter_handle'];
		} else {
			$links = get_option('pipdig_links');
			$twitter_url = esc_url($links['twitter']);
			if (!empty($twitter_url)) {
				$twitter_handle = parse_url($twitter_url, PHP_URL_PATH);
				$twitter_handle = str_replace('/', '', $twitter_handle);
			} else {
				$twitter_handle = '';
			}
		}
		
		if (isset($instance['number'])) { 
			$number = absint($instance['number']);
		} else {
			$number = 3;
		}

		// PART 2-3: Display the fields
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter_handle'); ?>"><?php _e('Twitter Username (Not including @ symbol):', 'p3'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_handle'); ?>" name="<?php echo $this->get_field_name('twitter_handle'); ?>" type="text" value="<?php echo esc_attr($twitter_handle); ?>" placeholder="e.g. pipdig" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Tweets', 'p3'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" min="1" max="10" value="<?php echo absint($number); ?>" />
		</p>
		<p><a href="//support.pipdig.co/articles/wordpress-twitter-widget/?utm_source=wordpress&utm_medium=p3&utm_campaign=widget" target="_blank"><?php _e('Click here for information', 'p3'); ?></a></p>
		
		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['twitter_handle'] = esc_attr($new_instance['twitter_handle']);
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_twitter");') );
}