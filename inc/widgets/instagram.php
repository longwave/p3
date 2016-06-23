<?php 

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists( 'pipdig_widget_instagram')) {
	class pipdig_widget_instagram extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_instagram', 'description' => __('Displays your latest Instagram photos', 'p3') );
			parent::__construct('pipdig_widget_instagram', 'pipdig - ' . __('Instagram Feed', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$images_num = 4;
		$cols = 2;
		$follow = false;
		$likes = false;
		$access_token = '';
		if (isset($instance['access_token'])) { 
			$access_token = sanitize_text_field($instance['access_token']);
		}
		if (!empty($instance['likes'])) {
			$likes = true;
		}
		if (isset($instance['images_num'])) { 
			$images_num = absint($instance['images_num'])-1; // minus to compensate for array loop
		} else {
			$images_num = 3; // actually 4
		}
		if (isset($instance['cols'])) { 
			$cols = absint($instance['cols']);
		} else {
			$cols = 2;
		}
		if ($cols == 2) {
			$width = '50%';
			$border = '2';
		} elseif ($cols == 3) {
			$width = '33.333333%';
			$border = '1';
		} elseif ($cols == 4) {
			$width = '25%';
			$border = '1';
		} else {
			$width = '100%';
		}
		if (!empty($instance['follow'])) {
			$follow = true;
		}
		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . esc_html($title) . $after_title;
		} else {
			echo $before_title . 'Instagram' . $after_title;
		}
		
		$images = p3_instagram_fetch($access_token); // grab images
		
		//print_r($images);
		
		if ($images) {
		?>
			<div class="p3_instagram_widget">
			<style scoped>
				.p3_instagram_widget .p3_instagram_post {
					width: <?php echo $width; ?>;
					border: <?php echo $border; ?>px solid <?php echo get_theme_mod('content_background_color', '#fff'); ?>
				}
			</style>
			<?php for ($x = 0; $x <= $images_num; $x++) { ?>
				<a href="<?php echo $images[$x]['link']; ?>" class="p3_instagram_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_instagram_square" alt=""/>
					<?php if ($likes) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
				</a>
			<?php } ?>
			</div>
			<div class="clearfix"></div>
			<?php
			$links = get_option('pipdig_links');
			$instagram_url = esc_url($links['instagram']);
			if (isset($instance['follow'])) {
				if (!empty($instagram_url) && $follow) { ?>
					<div class="clearfix"></div>
					<p style="margin: 10px 0"><a href="<?php echo $instagram_url; ?>" target="_blank" rel="nofollow" style="color: #000;"><i class="fa fa-instagram" style="font-size: 15px; margin-bottom: -1px"></i> <?php _e('Follow on Instagram', 'p3'); ?></a></p>
				<?php }
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
		$title = sanitize_text_field($instance['title']);
		$images_num = 4;
		$cols = 2;
		$follow = false;
		$likes = false;
		$access_token = '';
		if (isset($instance['access_token'])) { 
			$access_token = sanitize_text_field($instance['access_token']);
		}
		if (isset($instance['images_num'])) { 
			$images_num = absint($instance['images_num']);
		}
		if (isset($instance['cols'])) { 
			$cols = absint($instance['cols']);
		}
		if (!empty($instance['likes'])) {
			$likes = true;
		}
		if (!empty($instance['follow'])) {
			$follow = true;
		}
		?>
		<p>
	
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		
		<p><?php
		if (p3_instagram_fetch()) {
			printf(__('By default, this widget will display recent images from your main <a href="%s">Instagram account</a>. If you would prefer to use a different Instagram account, you can include the <a href="%s" target="_blank">Access Token</a> below:', 'p3'), admin_url('admin.php?page=pipdig-instagram'), esc_url('https://go.pipdig.co/open.php?id=instagram'));
		} else {
			printf(__('You need to complete the settings on <a href="%s">this page</a> before this widget will work.', 'p3'), admin_url('admin.php?page=pipdig-instagram'));
		}
		?></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token (optional)', 'p3'); ?></label><br />
			<input type="text" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" value="<?php if ($access_token) { echo $access_token; } ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label><br />
			<input type="number" min="1" max="20" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of columns:', 'p3'); ?></label><br />
			<input type="number" min="1" max="4" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php if ($cols) { echo $cols; } else { echo '2'; } ?>" /> (max 4)
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('likes'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('likes'); ?>" name="<?php echo $this->get_field_name('likes'); ?>" <?php if (isset($instance['likes'])) { checked( (bool) $instance['likes'], true ); } ?> /><?php _e('Display Comments & Likes count on hover.', 'p3'); ?></label>
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
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['access_token'] = sanitize_text_field($new_instance['access_token']);
		$instance['images_num'] = absint($new_instance['images_num']);
		$instance['cols'] = absint($new_instance['cols'] );
		$instance['likes'] = strip_tags($new_instance['likes']);
		$instance['follow'] = strip_tags($new_instance['follow']);
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_instagram");') );
}