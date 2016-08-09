<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'pipdig_widget_subscribe' ) ) {
	class pipdig_widget_subscribe extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_subscribe', 'description' => __('Allow people to subscribe to your blog via email', 'p3') );
		  parent::__construct('pipdig_widget_subscribe', 'pipdig - ' . __('Email Subscribe', 'p3') . ' (FeedBurner)', $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['feed'])) { 
			$feed =	pipdig_strip($instance['feed']);
		}
		if (isset($instance['text'])) { 
			$text = wp_kses_post($instance['text']);
		} else {
			$text = __('Enter your email address to subscribe:', 'p3');
		}


		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		
		if (!empty($feed)) {
			if (filter_var($feed, FILTER_VALIDATE_URL)) {  // they've entered a flippin url
				$feed = parse_url($feed, PHP_URL_PATH);
				$feed = str_replace('/', '', $feed);
			}
			$lang = str_replace('-', '_', get_bloginfo('language'));
			?>
			
			<form id="feedburner" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"	onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feed; ?>&amp;loc=<?php echo $lang; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" >
				<?php if (!$text == '') { ?><label for="fbg-mail"><?php echo $text; ?></label><?php } ?>
				<p><input id="fbg-mail" type="email" required name="email" placeholder="<?php _e('Enter your email', 'p3'); ?>" style="text-align:center" />
				<input type="hidden" value="<?php echo $feed; ?>" name="uri" />
				<input type="hidden" name="loc" value="<?php echo $lang; ?>" />
				<input type="submit" style="margin-top: 10px;" value="Subscribe" />
				</p>
			</form>
			
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
		if (isset($instance['feed'])) { 
			$feed =	$instance['feed'];
		}
		 
	   
		// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>1. <?php _e('If you have not already setup FeedBurner with your site, you will need to by following <a href="http://goo.gl/udSrVR" target="_blank">this guide</a>.', 'p3'); ?></p>
		<p>2. <?php _e('Add your FeedBurner ID to the box below.', 'p3'); ?></p>
		<p><?php _e('For example, the red part below:', 'p3'); ?><br />
		http://feeds.feedburner.com/<span style="color:red;">TheLovecatsInc</span></p>

		<p>
			<label for="<?php echo $this->get_field_id('feed'); ?>">FeedBurner ID:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('feed'); ?>" 
			name="<?php echo $this->get_field_name('feed'); ?>" type="text" 
			value="<?php if (isset($instance['feed'])) { echo esc_attr($instance['feed']); }; ?>" placeholder="TheLovecatsInc" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text to display above the form:', 'p3'); ?></label>
	  <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" ><?php if (isset($instance['text'])) { echo $instance['text']; } else { _e('Enter your email address to subscribe:', 'p3'); }; ?></textarea>
		</p>
		

		 <?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['feed'] = strip_tags($new_instance['feed']);
		$instance['text'] = wp_kses_post($new_instance['text']);

		return $instance;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_subscribe");') );
}