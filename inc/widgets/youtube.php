<?php 

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_latest_youtube' ) ) {
	class pipdig_widget_latest_youtube extends WP_Widget {
	 
	  public function __construct() {
		 $widget_ops = array('classname' => 'pipdig_widget_latest_youtube', 'description' => __('Automatically displays your latest YouTube video.', 'p3') );
		 parent::__construct('pipdig_widget_latest_youtube', 'pipdig - ' . __('Latest YouTube', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$hexadecimal = '';
		if (isset($instance['channel_id'])) { 
			$channel_id = trim($instance['channel_id']);
			$hexadecimal = 'za'.'Sy'.'CBY'.'yh'.'zMn'.'NNP';
		}
		
		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'YouTube' . $after_title;
		}

		if (!empty($channel_id)) {
			
			$output = '';
			
			if ( false === ( $output = get_transient( 'p3_youtube_widget_'.$channel_id ) ) ) { // transient
			
				$json = wp_remote_fopen(esc_url('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channel_id.'&key=AI'.$hexadecimal.'8d0'.'tvL'.'dS'.'P8r'.'yT'.'lS'.'Dq'.'egN'.'5c&type=video&maxResults=1'));
				$listFromYouTube = json_decode($json);
				$video_title = $listFromYouTube->items[0]->snippet->title;
				$video_id = strip_tags($listFromYouTube->items[0]->id->videoId);
				$max_res_url = "https://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
				$max = get_headers($max_res_url);
				if (substr($max[0], 9, 3) !== '404') {
					$thumbnail = $max_res_url;   
				} else {
					$thumbnail = "https://img.youtube.com/vi/".$video_id."/mqdefault.jpg";
				}
				
				$output .= '<div style="position:relative"><a href="https://www.youtube.com/watch?v='.$video_id.'" title="'.esc_attr($video_title).'" target="_blank" rel="nofollow"><img src="'.esc_url($thumbnail).'" style="width:100%;height:auto" alt="'.esc_attr($video_title).'"/><div style="position:absolute;bottom:2px;right:7px;color:#d92524;opacity:.8;font-size:25px;"><i class="fa fa-youtube-play"></i></div></a></div>';
				
				if (!empty($instance['show_title'])) {
					$output .= '<a href="https://www.youtube.com/watch?v='.$video_id.'" title="'.esc_attr($video_title).'" target="_blank" rel="nofollow">'.strip_tags($video_title).'</a>';
				}
				
				set_transient('p3_youtube_widget_'.$channel_id, $output, 30 * MINUTE_IN_SECONDS);
				
			}
			echo $output;
			
		} else {
			_e('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['channel_id'])) { 
			$channel_id = $instance['channel_id'];
		}
		if (empty($instance['show_title'])) {
			$show_title = true;
		}
	   
		// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>

		<p><?php _e('Enter your YouTube <a href="https://support.google.com/youtube/answer/3250431" target="_blank">Channel ID</a>.', 'p3'); ?></p>
		<p><?php _e('For example, the red part below:', 'p3'); ?></p> <p><?php echo esc_url('https://youtube.com/channel/'); ?><span style="color:red">UCyxZB7SqkRFqij18X1rDYHQ</span></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('channel_id'); ?>"><?php _e('YouTube Channel ID:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('channel_id'); ?>" 
			name="<?php echo $this->get_field_name('channel_id'); ?>" type="text" 
			value="<?php if (isset($instance['channel_id'])) { echo esc_attr($channel_id); } ?>" placeholder="UCyxZB7SqkRFqij18X1rDYHQ" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_title'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" <?php if (isset($instance['show_title'])) { checked( (bool) $instance['show_title'], true ); } ?> /><?php _e('Display the video title.', 'p3'); ?></label>
			<br />
		</p>

		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['channel_id'] = strip_tags(trim($new_instance['channel_id']));
		$instance['show_title'] = strip_tags($new_instance['show_title']);
		delete_transient('p3_youtube_widget_'.$instance['channel_id']); // delete transient
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_latest_youtube");') );
}