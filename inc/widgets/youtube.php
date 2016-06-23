<?php 

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_latest_youtube' ) ) {
	class pipdig_widget_latest_youtube extends WP_Widget {
	 
	  public function __construct() {
		 $widget_ops = array('classname' => 'pipdig_widget_latest_youtube', 'description' => __('Automatically displays your latest YouTube video.', 'p3') );
		 parent::__construct('pipdig_widget_latest_youtube', 'pipdig - ' . __('YouTube Videos', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'YouTube' . $after_title;
		}
		
		if (isset($instance['channel_id'])) { 
			$channel_id = strip_tags($instance['channel_id']);
		}

		if (!empty($channel_id)) {
			
			if (isset($instance['number'])) { 
				$number = absint($instance['number']);
			} else {
				$number = 1;
			}
			
			$videos = p3_youtube_fetch($channel_id, $number); // grab videos
			
			//print_r($videos);
				
			if ($videos) { ?>
			
				<?php $i = 1; // just for margin counter below ?>
			
				<?php foreach($videos as $video) { ?>
				
					<?php
					// margin for all except first in series
					$margin = '';
					if (($number > 1) && ($i != 1)) {
						$margin = 'margin-top:15px;';
					}
					$i++;
					?>
				
					<div class="p3_cover_me" style="background-image:url(<?php echo $video['thumbnail']; ?>);<?php echo $margin; ?>">
						<a href="<?php echo $video['link']; ?>" target="_blank" rel="nofollow">
							<img class="p3_invisible" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABQAAAALQAQMAAAD1s08VAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJRJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9eeMAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKsAxN8AAX2oznYAAAAASUVORK5CYII=" alt="<?php echo esc_attr($video['title']); ?>"/>
						</a>
					</div>
					<?php if (!empty($instance['show_title'])) { ?>
						<a href="<?php echo $video['link']; ?>" target="_blank" rel="nofollow"><?php echo $video['title']; ?></a>
					<?php } ?>
				<?php } ?>
				
			<?php
			}
			
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
		if (isset($instance['number'])) { 
			$number = absint($instance['number']);
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
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of videos to display:', 'p3'); ?></label><br />
			<input type="number" min="1" max="10" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php if (!empty($number)) { echo $number; } else { echo '1'; } ?>" /> (max 10)
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_title'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" <?php if (isset($instance['show_title'])) { checked( (bool) $instance['show_title'], true ); } ?> /><?php _e('Display the video title', 'p3'); ?></label>
			<br />
		</p>

		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = pipdig_strip( $new_instance['title'] );
		$instance['channel_id'] = strip_tags(trim($new_instance['channel_id']));
		$instance['number'] = absint($new_instance['number']);
		$instance['show_title'] = strip_tags($new_instance['show_title']);
		delete_transient('p3_youtube_widget_'.$instance['channel_id']); // delete transient
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_latest_youtube");') );
}