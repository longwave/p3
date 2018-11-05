<?php 

if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_widget_twitter' ) ) {
	class pipdig_widget_twitter extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_twitter', 'description' => __('Display your Twitter timeline.', 'p3') );
		  parent::__construct('pipdig_widget_twitter', 'pipdig - ' . __('Twitter Timeline', 'p3'), $widget_ops);
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
		
		$follow = false;
		if (!empty($instance['follow'])) {
			$follow = true;
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
			<?php
			if (isset($instance['follow'])) {
				if ($follow) { ?>
					<div class="clearfix"></div>
					<p style="margin: 10px 0"><a href="https://twitter.com/<?php echo $twitter_handle; ?>" target="_blank" rel="nofollow noopener" style="color: #000;"><i class="fa fa-twitter" style="font-size: 15px; margin-bottom: -1px"></i> <?php _e('Follow on Twitter', 'p3'); ?></a></p>
				<?php }
			}
			?>
		<?php } else {
			echo 'Twitter widget in section "'.$args['name'].'": '.__('Setup not complete. Please check the widget options.', 'p3');
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
		
		$follow = false;
		if (!empty($instance['follow'])) {
			$follow = true;
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
		<p>
			<label for="<?php echo $this->get_field_id('follow'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('follow'); ?>" name="<?php echo $this->get_field_name('follow'); ?>" <?php if (isset($instance['follow'])) { checked( (bool) $instance['follow'], true ); } ?> /><?php _e('Display a "Follow" link.', 'p3'); ?></label>
			<br />
		</p>
		
		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['twitter_handle'] = esc_attr($new_instance['twitter_handle']);
		$instance['number'] = absint($new_instance['number']);
		$instance['follow'] = strip_tags($new_instance['follow']);
		return $instance;
	  }

	}

}