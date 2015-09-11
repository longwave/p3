<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class pipdig_p3_snapchat_snapcode extends WP_Widget {
 
  public function __construct() {
      $widget_ops = array('classname' => 'pipdig_p3_snapchat_snapcode', 'description' => __("Display your Snapchat Snapcode (QR code).", 'p3') );
      parent::__construct('pipdig_p3_snapchat_snapcode', 'pipdig - ' . 'Snapchat Snapcode', $widget_ops);
  }
  
  function widget($args, $instance) {
    // PART 1: Extracting the arguments + getting the values
    extract($args, EXTR_SKIP);
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
    $snapchat_account = empty($instance['snapchat_account']) ? '' : $instance['snapchat_account'];
	$snapcode = empty($instance['snapcode']) ? '' : $instance['snapcode'];
	
    // Before widget code, if any
    echo (isset($before_widget)?$before_widget:'');
   
    // PART 2: The title and the text output
    if (!empty($title)) {
		echo $before_title . $title . $after_title;
	}
	
    if (!empty($snapcode)) { ?>
		<img src="<?php echo $snapcode; ?>" style="min-width: 1in; max-width: 1.2in; height: auto;" alt="Snapchat" />
		<?php if (!empty($snapchat_account)) { ?>
			<p><?php printf( __('Follow <b>%s</b> on Snapchat!', 'p3'), $snapchat_account ); ?></p>
		<?php } ?>
	<?php } else {
		_e("Setup not complete. Please check the widget options.", 'p3');
	}
    // After widget code, if any
    echo (isset($after_widget)?$after_widget:'');
  }
 
  public function form( $instance ) {
   
     // PART 1: Extract the data from the instance variable
     $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
     $title = $instance['title'];
	 
	 if (isset($instance['snapchat_account'])) {
		$snapchat_account = $instance['snapchat_account'];
	 } else {
		 $snapchat_account = '';
	 }

     // PART 2-3: Display the fields
     ?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'p3'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>
	
		<p style="font-weight:bold"><?php _e('Upload your <a href="https://accounts.snapchat.com/accounts/snapcodes?type=png" target="_blank">Snapcode</a> PNG file:', 'p3'); ?></p>
		<?php
			if (!empty($instance['snapcode'])) {
				echo '<img src="' . $instance['snapcode'] . '" style="margin:5px 0;padding:0;max-width:150px;height:auto" alt="" /><br />';
			}
		?>

		<input type="text" style="display:none" class="widefat custom_media_url" name="<?php echo $this->get_field_name('snapcode'); ?>" id="<?php echo $this->get_field_id('snapcode'); ?>" value="<?php if (isset($instance['snapcode'])) { echo $instance['snapcode']; } ?>" style="margin-top:5px;">

		<input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('snapcode'); ?>" value="<?php _e('Upload Snapcode', 'p3'); ?>" style="margin-top:8px;" />

	<p>
		<label for="<?php echo $this->get_field_id('snapchat_account'); ?>"><?php _e("Snapchat Account Name:", 'p3'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('snapchat_account'); ?>" name="<?php echo $this->get_field_name('snapchat_account'); ?>" type="text" value="<?php echo esc_attr($snapchat_account); ?>" placeholder="<?php _e("For example:", 'p3'); ?> mileyxxcyrus" />
	</p>
	
	
     <?php
   
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['snapcode'] = strip_tags($new_instance['snapcode']);
    $instance['snapchat_account'] = strip_tags($new_instance['snapchat_account']);
	update_option('pipdig_p3_snapchat_account', $instance['snapchat_account']); // might use this in a shortcode later
    return $instance;
  }
  
}
add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_p3_snapchat_snapcode");') );
