<?php 
if ( !class_exists( 'pipdig_widget_instagram' ) ) {
	class pipdig_widget_instagram extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_instagram', 'description' => __('Displays your latest Instagram photos', 'p3') );
			parent::__construct('pipdig_widget_instagram', 'pipdig - ' . __('Instagram Widget', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		} else {
			$images_num = 4;
		}
		if (isset($instance['cols'])) { 
			$cols = $instance['cols'];
		} else {
			$cols = 2;
		}
		if (isset($instance['load_more'])) {
			$load_more = 'true';
		} else {
			$load_more = 'false';
		}
		if (isset($instance['follow'])) {
			$follow = 'true';
		} else {
			$follow = 'false';
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'Instagram' . $after_title;
		}

		if (pipdig_plugin_check('instagram-feed/instagram-feed.php')) {
			$bg = get_theme_mod('content_background_color', '#ffffff');
			echo '<style scoped>#sb_instagram #sbi_load .sbi_load_btn,#sb_instagram .sbi_follow_btn a{border-radius:0;background:none;color:#000}</style>';
			echo do_shortcode( '[instagram-feed width=100 height=100 widthunit=% heightunit=% background=' . $bg . ' imagepadding=1 imagepaddingunit=px class=pipdig-instagram-widget-inner num=' . $images_num . ' cols=' . $cols . ' imageres=medium disablemobile=true showheader=false showbutton=' . $load_more . ' showfollow=' . $follow . ']' );
		} else {
			$plugin_url = esc_url( 'https://wordpress.org/plugins/instagram-feed/' );
			printf(__('Please install and activate <a href="%s">this plugin</a> to add your Instagram Feed.', 'p3'), $plugin_url );
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		} else {
			$images_num = 4;
		}
		if (isset($instance['cols'])) { 
			$cols = $instance['cols'];
		} else {
			$cols = 2;
		}
		if (isset($instance['load_more'])) { 
			$load_more = $instance['load_more'];
		} else {
			$load_more = 'false';
		}
		if (isset($instance['follow'])) {
			$follow = 'true';
		} else {
			$follow = 'false';
		}
		?>
		<p>
		<?php
		if (pipdig_plugin_check('instagram-feed/instagram-feed.php')) {
			$plugin_url = admin_url( 'admin.php?page=sb-instagram-feed' );
			printf(__('This widget will show your latest Instagram photos. You will need to authorize your Instagram account on <a href="%s">this page</a> for this widget to work.', 'p3'), $plugin_url );
		} else {
			$plugin_url = esc_url( 'https://wordpress.org/plugins/instagram-feed/' );
			printf(__('Please install and activate <a href="%s">this plugin</a> to add your Instagram Feed.', 'p3'), $plugin_url );
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label><br />
			<input type="number" min="1" max="10" step="1" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of columns:', 'p3'); ?></label><br />
			<input type="number" min="1" max="10" step="1" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php if ($cols) { echo $cols; } else { echo '2'; } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('load_more'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('load_more'); ?>" name="<?php echo $this->get_field_name('load_more'); ?>" <?php if (isset($instance['load_more'])) { checked( (bool) $instance['load_more'], true ); } ?> /><?php _e('Display a "Load more" button.', 'p3'); ?></label>
			<br />
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['images_num'] = absint( $new_instance['images_num'] );
		$instance['cols'] = absint( $new_instance['cols'] );
		$instance['load_more'] = $new_instance['load_more'];
		$instance['follow'] = $new_instance['follow'];
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_instagram");') );
}