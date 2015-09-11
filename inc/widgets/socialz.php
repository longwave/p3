<?php 

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if ( !class_exists( 'pipdig_widget_social_icons' ) ) {
	class pipdig_widget_social_icons extends WP_Widget {
	 
	  public function __construct() {
		 $widget_ops = array('classname' => 'pipdig_widget_social_icons', 'description' => __('The easy way to show social media icons.', 'p3') );
		 parent::__construct('pipdig_widget_social_icons', 'pipdig - ' . __('Social Media Icons', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$twitter = empty($instance['twitter']) ? '' : $instance['twitter'];
		$instagram = empty($instance['instagram']) ? '' : $instance['instagram'];
		$facebook = empty($instance['facebook']) ? '' : $instance['facebook'];
		$google = empty($instance['google']) ? '' : $instance['google'];
		$bloglovin = empty($instance['bloglovin']) ? '' : $instance['bloglovin'];
		$pinterest = empty($instance['pinterest']) ? '' : $instance['pinterest'];
		$youtube = empty($instance['youtube']) ? '' : $instance['youtube'];
		$vine = empty($instance['vine']) ? '' : $instance['vine'];
		$tumblr = empty($instance['tumblr']) ? '' : $instance['tumblr'];
		$linkedin = empty($instance['linkedin']) ? '' : $instance['linkedin'];
		$vk = empty($instance['vk']) ? '' : $instance['vk'];
		$flickr = empty($instance['flickr']) ? '' : $instance['flickr'];
		$email = empty($instance['email']) ? '' : $instance['email'];
		$rss = empty($instance['rss']) ? '' : $instance['rss'];

		$icons_output = '';

		echo (isset($before_widget)?$before_widget:''); // Before widget code, if any
	   
		// PART 2: The title and the text output
		if (!empty($title)) echo $before_title . $title . $after_title;
		
		if (!empty($twitter)) $icons_output .= '<a href="' . $twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
		if (!empty($instagram)) $icons_output .= '<a href="' . $instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
		if (!empty($facebook)) $icons_output .= '<a href="' . $facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
		if (!empty($google)) $icons_output .= '<a href="' . $google . '" target="_blank"><i class="fa fa-google-plus"></i></a>';
		if (!empty($bloglovin)) $icons_output .= '<a href="' . $bloglovin . '" target="_blank"><i class="fa fa-plus"></i></a>';
		if (!empty($pinterest)) $icons_output .= '<a href="' . $pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
		if (!empty($youtube)) $icons_output .= '<a href="' . $youtube . '" target="_blank"><i class="fa fa-youtube-play"></i></a>';
		if (!empty($vine)) $icons_output .= '<a href="' . $vine . '" target="_blank"><i class="fa fa-vine"></i></a>';
		if (!empty($tumblr)) $icons_output .= '<a href="' . $tumblr . '" target="_blank"><i class="fa fa-tumblr"></i></a>';
		if (!empty($linkedin)) $icons_output .= '<a href="' . $linkedin . '" target="_blank"><i class="fa fa-linkedin"></i></a>';
		if (!empty($vk)) $icons_output .= '<a href="' . $vk . '" target="_blank"><i class="fa fa-vk"></i></a>';
		if (!empty($flickr)) $icons_output .= '<a href="' . $flickr . '" target="_blank"><i class="fa fa-flickr"></i></a>';
		if (!empty($email)) $icons_output .= '<a href="mailto:' . $email . '"><i class="fa fa-envelope"></i></a>';
		if (!empty($rss)) $icons_output .= '<a href="' . $rss . '" target="_blank"><i class="fa fa-rss"></i></a>';
		
		echo '<div class="socialz">' . $icons_output . '</div>';
		
		echo (isset($after_widget)?$after_widget:''); // After widget code, if any  
	  }
		
	  public function form( $instance ) {
		  
		// PART 1: Extract the data from the instance variable
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$twitter = empty($instance['twitter']) ? '' : $instance['twitter'];
		$instagram = empty($instance['instagram']) ? '' : $instance['instagram'];
		$facebook = empty($instance['facebook']) ? '' : $instance['facebook'];
		$google = empty($instance['google']) ? '' : $instance['google'];
		$bloglovin = empty($instance['bloglovin']) ? '' : $instance['bloglovin'];
		$pinterest = empty($instance['pinterest']) ? '' : $instance['pinterest'];
		$youtube = empty($instance['youtube']) ? '' : $instance['youtube'];
		$vine = empty($instance['vine']) ? '' : $instance['vine'];
		$tumblr = empty($instance['tumblr']) ? '' : $instance['tumblr'];
		$linkedin = empty($instance['linkedin']) ? '' : $instance['linkedin'];
		$vk = empty($instance['vk']) ? '' : $instance['vk'];
		$flickr = empty($instance['flickr']) ? '' : $instance['flickr'];
		$email = empty($instance['email']) ? '' : $instance['email'];
		$rss = empty($instance['rss']) ? '' : $instance['rss'];
	   
		// PART 2-3: Display the fields
		?>

		<p><?php _e('Any links you add below will be shown as a social media icon. Leave any field blank to not add that icon.', 'p3'); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter (e.g. http://twitter.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" 
			name="<?php echo $this->get_field_name('twitter'); ?>" type="url" 
			value="<?php echo esc_attr($twitter); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram (e.g. http://instagram.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" 
			name="<?php echo $this->get_field_name('instagram'); ?>" type="text" 
			value="<?php echo esc_attr($instagram); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook (e.g. http://facebook.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" 
			name="<?php echo $this->get_field_name('facebook'); ?>" type="text" 
			value="<?php echo esc_attr($facebook); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('google'); ?>">Google&#43; (e.g. https://plus.google.com/+pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" 
			name="<?php echo $this->get_field_name('google'); ?>" type="text" 
			value="<?php echo esc_attr($google); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('bloglovin'); ?>">Bloglovin (e.g. http://www.bloglovin.com/en/blog/3890264) 
			<input class="widefat" id="<?php echo $this->get_field_id('bloglovin'); ?>" 
			name="<?php echo $this->get_field_name('bloglovin'); ?>" type="text" 
			value="<?php echo esc_attr($bloglovin); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('pinterest'); ?>">Pinterest (e.g. http://pinterest.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" 
			name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" 
			value="<?php echo esc_attr($pinterest); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>">YouTube (e.g. http://youtube.com/user/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" 
			name="<?php echo $this->get_field_name('youtube'); ?>" type="text" 
			value="<?php echo esc_attr($youtube); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('vine'); ?>">Vine (e.g. http://vine.co/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('vine'); ?>" 
			name="<?php echo $this->get_field_name('vine'); ?>" type="text" 
			value="<?php echo esc_attr($vine); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('tumblr'); ?>">Tumblr (e.g. http://pipdig.tumblr.com) 
			<input class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" 
			name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" 
			value="<?php echo esc_attr($tumblr); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>">Linkedin (e.g. http://linkedin.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" 
			name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" 
			value="<?php echo esc_attr($linkedin); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('vk'); ?>">VKontakte (e.g. http://vk.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>" 
			name="<?php echo $this->get_field_name('vk'); ?>" type="text" 
			value="<?php echo esc_attr($vk); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>">Flickr (e.g. http://flickr.com/user/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" 
			name="<?php echo $this->get_field_name('flickr'); ?>" type="text" 
			value="<?php echo esc_attr($flickr); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email (e.g. yourname@gmail.com) 
			<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" 
			name="<?php echo $this->get_field_name('email'); ?>" type="text" 
			value="<?php echo esc_attr($email); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('rss'); ?>">RSS Feed (e.g. http://mydomain.com/feed) 
			<input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" 
			name="<?php echo $this->get_field_name('rss'); ?>" type="text" 
			value="<?php echo esc_attr($rss); ?>" />
			</label>
		</p>

		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['instagram'] = strip_tags($new_instance['instagram']);
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['google'] = strip_tags($new_instance['google']);
		$instance['bloglovin'] = strip_tags($new_instance['bloglovin']);
		$instance['pinterest'] = strip_tags($new_instance['pinterest']);
		$instance['youtube'] = strip_tags($new_instance['youtube']);
		$instance['vine'] = strip_tags($new_instance['vine']);
		$instance['tumblr'] = strip_tags($new_instance['tumblr']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['vk'] = strip_tags($new_instance['vk']);
		$instance['flickr'] = strip_tags($new_instance['flickr']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['rss'] = strip_tags($new_instance['rss']);

		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_social_icons");') );
}