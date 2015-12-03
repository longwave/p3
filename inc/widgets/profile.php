<?php 

if (!defined('ABSPATH')) {
	exit;
}

// add admin scripts
if ( !function_exists( 'pipdig_enque_script' ) ) {
	function pipdig_enque_script() {
		wp_enqueue_media();
		wp_enqueue_script('p3-media-upload', plugin_dir_url( __FILE__ ) . '../../assets/js/pipdig-media-widget.js', false, '1.0', true);
	}
	add_action('admin_enqueue_scripts', 'pipdig_enque_script');
}

// widget class
if ( !class_exists( 'pipdig_widget_profile_function' ) ) {
	class pipdig_widget_profile_function extends WP_Widget {

		function pipdig_widget_profile_function() {
			$widget_ops = array('classname' => 'pipdig_widget_profile', 'description' => __('Show off your profile photo!', 'p3') );
			parent::__construct('pipdig_widget_profile', 'pipdig - ' . __('Profile Photo', 'p3') , $widget_ops);
		}

		function widget($args, $instance) {
			extract($args);
			if (isset($instance['title'])) { 
				$title = strip_tags($instance['title']);
			}
			if (isset($instance['circle'])) { 
				$circle = 'style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"';
			} else {
				$circle = '';
			}
			if (isset($instance['description'])) { 
				$description = wp_kses_post($instance['description']);
			}
			
			// widget content
			echo $before_widget;
			if (!empty($title)) echo $before_title . $title . $after_title;
	?>
			<?php if (isset($instance['image_uri'])) {  ?>
				<div class="nopin">
				<img src="<?php echo esc_url($instance['image_uri']); ?>" <?php echo $circle; ?> alt="" />
				</div>
					<?php if ($description) {  ?>
						<p><?php echo $description; ?></p>
					<?php } //endif ?>
			<?php } //endif ?>
	<?php
			echo $after_widget;

		}
		
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['image_uri'] = strip_tags($new_instance['image_uri']);
			$instance['circle'] = $new_instance['circle'];
			$instance['description'] = wp_kses_post($new_instance['description']);
			return $instance;
		}

		function form($instance) {
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php if (isset($instance['title'])) { echo $instance['title']; } ?>" class="widefat" />
		</p>
		<p style="display:none">
			<label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Image', 'p3'); ?></label><br />
			<p style="font-weight:bold"><?php _e('Step 1 - Click the button below to select a photo:', 'p3'); ?></p>
			<?php
				if (isset($instance['circle'])) { 
					$circle = '-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;';
				} else {
					$circle = '';
				}
				if (!empty($instance['image_uri'])) {
					echo '<img class="pipdig-profile-photo-img"  src="' . esc_url($instance['image_uri']) . '" style="margin:0;padding:0;max-width:150px;height:auto;'.$circle.'" /><br />';
				}
			?>

			<input type="text" style="display:none" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php if (isset($instance['image_uri'])) { echo $instance['image_uri']; } ?>" style="margin-top:5px;">

			<input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="<?php _e('Upload Photo', 'p3'); ?>" style="margin-top:0;" />
			<p style="font-weight:bold"><?php _e('Step 2 - Optional extras:', 'p3'); ?></p>
			<p>
				<label for="<?php echo $this->get_field_id( 'circle' ); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id( 'circle' ); ?>" name="<?php echo $this->get_field_name( 'circle' ); ?>" <?php if (isset($instance['circle'])) { checked( (bool) $instance['circle'], true ); } ?> /><?php _e('Change image to a circle', 'p3'); ?></label>
				<?php $picmonkey_url = esc_url( 'http://www.picmonkey.com' ); ?>
				<br /><span style="font-size:80%;font-style:italic;"><?php printf(__("To make a perfect circle you should upload a square image. For example, 300px wide by 300px high. You can use free websites like <a href='%s' target='_blank'>picmonkey.com</a> to edit your image.", 'p3'), $picmonkey_url ); ?></span>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Add some text below the photo:', 'p3'); ?></label>
				<textarea id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" style="width:95%;" rows="4"><?php if (isset($instance['description'])) { echo $instance['description']; } ?></textarea>
			</p>
			<p style="text-align:right;font-weight:bold"><?php _e('Step 3 - Click the save button:', 'p3'); ?></p>
		</p>

	<?php
		}
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_profile_function");') );
}