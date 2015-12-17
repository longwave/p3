<?php 

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists( 'pipdig_widget_instagram')) {
	class pipdig_widget_instagram extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_instagram', 'description' => __('Displays your latest Instagram photos', 'p3') );
			parent::__construct('pipdig_widget_instagram', 'pipdig - ' . __('Instagram Widget', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$images_num = 4;
		$cols = 2;
		$follow = false;
		$likes = false;
		if (!empty($instance['likes'])) {
			$likes = true;
		}
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num']-1; // minus to compensate for array loop
		} else {
			$images_num = 3; // actually 4
		}
		if (isset($instance['cols'])) { 
			$cols = intval($instance['cols']);
		} else {
			$cols = 2;
		}
		if ($cols == 2) {
			$width = '50%';
			$border = '2';
		} elseif ($cols == 3) {
			$width = '33%';
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
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'Instagram' . $after_title;
		}
		
		$images = p3_instagram_fetch(); // grab images
		
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
		$images_num = 4;
		$cols = 2;
		$follow = false;
		$likes = false;
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		}
		if (isset($instance['cols'])) { 
			$cols = $instance['cols'];
		}
		if (!empty($instance['likes'])) {
			$likes = true;
		}
		if (!empty($instance['follow'])) {
			$follow = true;
		}
		?>
		<p>
		<?php
		if (p3_instagram_fetch()) {
			_e('This widget will display your recent Instagram photos.', 'p3');
		} else {
			printf(__('You need to complete the settings on <a href="%s">this page</a> before this widget will work.', 'p3'), admin_url('admin.php?page=pipdig-instagram'));
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label><br />
			<input type="number" min="1" max="20" step="1" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of columns:', 'p3'); ?></label><br />
			<input type="number" min="1" max="4" step="1" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php if ($cols) { echo $cols; } else { echo '2'; } ?>" />
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
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['images_num'] = absint($new_instance['images_num']);
		$instance['cols'] = absint($new_instance['cols'] );
		$instance['likes'] = strip_tags($new_instance['likes']);
		$instance['follow'] = strip_tags($new_instance['follow']);
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_instagram");') );
}