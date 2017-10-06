<?php 

if (!defined('ABSPATH')) die;

if (!class_exists( 'pipdig_widget_instagram')) {
	class pipdig_widget_instagram extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_instagram', 'description' => __('Displays your latest Instagram photos.', 'p3') );
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
			$access_token = pipdig_strip($instance['access_token']);
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
		
		$id = 'p3_instagram_widget_'.rand(1, 999999999);
		
		if ($images) {
			
			$lazy = false;
			$lazy_class = '';
			if (is_pipdig_lazy()) {
				$lazy = true;
				$lazy_class = ' pipdig_lazy';
			}
			
		?>
			<div id="<?php echo $id; ?>" class="p3_instagram_widget">
			<style>
				#<?php echo $id; ?> .p3_instagram_post {
					width: <?php echo $width; ?>;
					border: <?php echo $border; ?>px solid <?php echo strip_tags(get_theme_mod('content_background_color', '#fff')); ?>
				}
			</style>
			<?php for ($x = 0; $x <= $images_num; $x++) {
				
				$image_src = 'style="background-image:url('.$images[$x]['src'].');"';
				if ($lazy) {
					$image_src = 'data-src="'.$images[$x]['src'].'"';
				}

			?>
				<a href="<?php echo $images[$x]['link']; ?>" class="p3_instagram_post <?php echo $lazy_class; ?>" <?php echo $image_src; ?> rel="nofollow" target="_blank">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" class="p3_instagram_square" alt=""/>
					<?php if ($likes) { ?><span class="p3_instagram_likes"><i class="fa fa-comment"></i> <?php echo $images[$x]['comments'];?> &nbsp;<i class="fa fa-heart"></i> <?php echo $images[$x]['likes'];?></span><?php } ?>
				</a>
			<?php } ?>
			</div>
			<div class="clearfix"></div>
			<?php
			$links = get_option('pipdig_links');
			$instagram_url = esc_url($links['instagram']);
			if (!empty($instagram_url) && $follow) { ?>
				<div class="clearfix"></div>
				<p style="margin: 10px 0"><a href="<?php echo $instagram_url; ?>" target="_blank" rel="nofollow" style="color: #000;"><i class="fa fa-instagram" style="font-size: 15px; margin-bottom: -1px"></i> <?php _e('Follow on Instagram', 'p3'); ?></a></p>
			<?php }
		} else {
			if (current_user_can('manage_options')) {
				echo 'Unable to display Instagram feed. Please check your account has been correctly setup on <a href="'.admin_url('admin.php?page=pipdig-instagram').'">this page</a>. This error can also occur if you have not yet published any images to Instagram or if your Instagram profile is set to Private. This message is only visible to site admins.';
			}
		}
		
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = pipdig_strip($instance['title']);
		$images_num = 4;
		$cols = 2;
		$follow = false;
		$likes = false;
		$access_token = '';
		if (isset($instance['access_token'])) { 
			$access_token = pipdig_strip($instance['access_token']);
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
			printf(__('By default, this widget will display recent images from your main <a href="%s">Instagram account</a>. If you would prefer to use a different Instagram account, you can include the <a href="%s" target="_blank">Access Token</a> below:', 'p3'), admin_url('admin.php?page=pipdig-instagram'), esc_url('https://www.pipdig.co/ig'));
		} else {
			printf(__('You need to complete the settings on <a href="%s">this page</a> before this widget will work.', 'p3'), admin_url('admin.php?page=pipdig-instagram'));
			//echo '<style>.p3_instagram_widget_options{opacity:.2}</style>'; // not working since function returns false if no images in account.
		}
		?></p>
		<div class="p3_instagram_widget_options">
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
			<select id="<?php echo $this->get_field_id('cols'); ?>" name="<?php echo $this->get_field_name('cols'); ?>" class="">
				<option <?php selected( $cols, 1); ?> value="1">1</option>
				<option <?php selected( $cols, 2); ?> value="2">2</option>
				<option <?php selected( $cols, 3); ?> value="3">3</option>
				<option <?php selected( $cols, 4); ?> value="4">4</option>
			</select>
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
		</div>
		<?php
	}
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = pipdig_strip($new_instance['title']);
		$instance['access_token'] = pipdig_strip($new_instance['access_token']);
		$instance['images_num'] = absint($new_instance['images_num']);
		$instance['cols'] = absint($new_instance['cols'] );
		$instance['likes'] = strip_tags($new_instance['likes']);
		$instance['follow'] = strip_tags($new_instance['follow']);
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_instagram");') );
}