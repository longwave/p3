<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

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
		
		$email = empty($instance['email']) ? '' : sanitize_email($instance['email']);
		$twitter = empty($instance['twitter']) ? '' : esc_url($instance['twitter']);
		$instagram = empty($instance['instagram']) ? '' : esc_url($instance['instagram']);
		$facebook = empty($instance['facebook']) ? '' : esc_url($instance['facebook']);
		$google = empty($instance['google']) ? '' : esc_url($instance['google']);
		$bloglovin = empty($instance['bloglovin']) ? '' : esc_url($instance['bloglovin']);
		$pinterest = empty($instance['pinterest']) ? '' : esc_url($instance['pinterest']);
		$youtube = empty($instance['youtube']) ? '' : esc_url($instance['youtube']);
		$vine = empty($instance['vine']) ? '' : esc_url($instance['vine']);
		$tumblr = empty($instance['tumblr']) ? '' : esc_url($instance['tumblr']);
		$linkedin = empty($instance['linkedin']) ? '' : esc_url($instance['linkedin']);
		$vk = empty($instance['vk']) ? '' : esc_url($instance['vk']);
		$flickr = empty($instance['flickr']) ? '' : esc_url($instance['flickr']);
		$twitch = empty($instance['twitch']) ? '' : esc_url($instance['twitch']);
		$spotify = empty($instance['spotify']) ? '' : esc_url($instance['spotify']);
		$medium = empty($instance['medium']) ? '' : esc_url($instance['medium']);
		$stumbleupon = empty($instance['stumbleupon']) ? '' : esc_url($instance['stumbleupon']);
		$etsy = empty($instance['etsy']) ? '' : esc_url($instance['etsy']);
		$snapchat = empty($instance['snapchat']) ? '' : esc_url($instance['snapchat']);
		$rss = empty($instance['rss']) ? '' : esc_attr($instance['rss']);
		//$style_select = empty($instance['style_select']) ? '' : $instance['style_select'];

	
		if (isset($instance['style_select'])) { 
			$style_select = $instance['style_select'];
		} else {
			$style_select = 1;
		}
		
		$icons_output = '';

		echo (isset($before_widget)?$before_widget:''); // Before widget code, if any
	   
		// PART 2: The title and the text output
		if (!empty($title)) echo $before_title . $title . $after_title;
		
		if ($style_select == 1) { // style/layout of icons
		
			if (!empty($twitter)) $icons_output .= '<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
			if (!empty($instagram)) $icons_output .= '<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
			if (!empty($facebook)) $icons_output .= '<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
			if (!empty($google)) $icons_output .= '<a href="'.$google.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
			if (!empty($bloglovin)) $icons_output .= '<a href="'.$bloglovin.'" target="_blank"><i class="fa fa-plus"></i></a>';
			if (!empty($pinterest)) $icons_output .= '<a href="'.$pinterest.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
			if (!empty($snapchat)) $icons_output .= '<a href="'.$snapchat.'" target="_blank"><i class="fa fa-snapchat-ghost"></i></a>';
			if (!empty($youtube)) $icons_output .= '<a href="'.$youtube.'" target="_blank"><i class="fa fa-youtube-play"></i></a>';
			if (!empty($vine)) $icons_output .= '<a href="'.$vine.'" target="_blank"><i class="fa fa-vine"></i></a>';
			if (!empty($tumblr)) $icons_output .= '<a href="'.$tumblr.'" target="_blank"><i class="fa fa-tumblr"></i></a>';
			if (!empty($linkedin)) $icons_output .= '<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
			if (!empty($vk)) $icons_output .= '<a href="'.$vk.'" target="_blank"><i class="fa fa-vk"></i></a>';
			if (!empty($flickr)) $icons_output .= '<a href="'.$flickr.'" target="_blank"><i class="fa fa-flickr"></i></a>';
			if (!empty($spotify)) $icons_output .= '<a href="'.$spotify.'" target="_blank"><i class="fa fa-spotify"></i></a>';
			if (!empty($medium)) $icons_output .= '<a href="'.$medium.'" target="_blank"><i class="fa fa-medium"></i></a>';
			if (!empty($twitch)) $icons_output .= '<a href="'.$twitch.'" target="_blank"><i class="fa fa-twitch"></i></a>';
			if (!empty($stumbleupon)) $icons_output .= '<a href="'.$stumbleupon.'" target="_blank"><i class="fa fa-stumbleupon"></i></a>';
			if (!empty($etsy)) $icons_output .= '<a href="'.$etsy.'" target="_blank"><i class="fa fa-etsy"></i></a>';
			if (!empty($email)) $icons_output .= '<a href="mailto:'.$email.'"><i class="fa fa-envelope"></i></a>';
			if (!empty($rss)) $icons_output .= '<a href="'.$rss.'" target="_blank"><i class="fa fa-rss"></i></a>';
			
			echo '<div class="socialz">'.$icons_output.'</div>';
		
		} else {
			
			if (!empty($twitter)) $icons_output .= '<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i><br /><span>Twitter</span></a>';
			if (!empty($instagram)) $icons_output .= '<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i><br /><span>Instagram</span></a>';
			if (!empty($facebook)) $icons_output .= '<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i><br /><span>Facebook</span></a>';
			if (!empty($google)) $icons_output .= '<a href="'.$google.'" target="_blank"><i class="fa fa-google-plus"></i><br /><span>Google+</span></a>';
			if (!empty($bloglovin)) $icons_output .= '<a href="'.$bloglovin.'" target="_blank"><i class="fa fa-plus"></i><br /><span>Bloglovin</span></a>';
			if (!empty($pinterest)) $icons_output .= '<a href="'.$pinterest.'" target="_blank"><i class="fa fa-pinterest"></i><br /><span>Pinterest</span></a>';
			if (!empty($snapchat)) $icons_output .= '<a href="'.$snapchat.'" target="_blank"><i class="fa fa-snapchat-ghost"></i><br /><span>Snapchat</span></a>';
			if (!empty($youtube)) $icons_output .= '<a href="'.$youtube.'" target="_blank"><i class="fa fa-youtube-play"></i><br /><span>YouTube</span></a>';
			if (!empty($vine)) $icons_output .= '<a href="'.$vine.'" target="_blank"><i class="fa fa-vine"></i><br /><span>Vine</span></a>';
			if (!empty($tumblr)) $icons_output .= '<a href="'.$tumblr.'" target="_blank"><i class="fa fa-tumblr"></i><br /><span>Tumblr</span></a>';
			if (!empty($linkedin)) $icons_output .= '<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i><br /><span>LinkedIn</span></a>';
			if (!empty($vk)) $icons_output .= '<a href="'.$vk.'" target="_blank"><i class="fa fa-vk"></i><br /><span>VKontakte</span></a>';
			if (!empty($flickr)) $icons_output .= '<a href="'.$flickr.'" target="_blank"><i class="fa fa-flickr"></i><br /><span>Flickr</span></a>';
			if (!empty($spotify)) $icons_output .= '<a href="'.$spotify.'" target="_blank"><i class="fa fa-spotify"></i><br /><span>Spotify</span></a>';
			if (!empty($medium)) $icons_output .= '<a href="'.$medium.'" target="_blank"><i class="fa fa-medium"></i><br /><span>Medium</span></a>';
			if (!empty($twitch)) $icons_output .= '<a href="'.$twitch.'" target="_blank"><i class="fa fa-twitch"></i><br /><span>Twitch</span></a>';
			if (!empty($stumbleupon)) $icons_output .= '<a href="'.$stumbleupon.'" target="_blank"><i class="fa fa-stumbleupon"></i><br /><span>Stumble</span></a>';
			if (!empty($etsy)) $icons_output .= '<a href="'.$etsy.'" target="_blank"><i class="fa fa-etsy"></i><br /><span>Etsy</span></a>';
			if (!empty($email)) $icons_output .= '<a href="mailto:'.$email.'"><i class="fa fa-envelope"></i><br /><span>Email</span></a>';
			if (!empty($rss)) $icons_output .= '<a href="'.$rss.'" target="_blank"><i class="fa fa-rss"></i><br /><span>RSS</span></a>';
			$id = 'p3_socialz_'.rand(1, 999999999);
			echo '<style scoped>.pipdig_widget_social_icons #'.$id.' a {line-height:.9; display: inline-block; width: 25%; padding: 2px; margin: 10px;} .pipdig_widget_social_icons #'.$id.' a span {font: 10px montserrat, arial, sans-serif;text-transform: uppercase; letter-spacing: 1px}</style>';
			echo '<div id="'.$id.'" class="socialz">'.$icons_output.'</div>';

		}
		
		
		
		echo (isset($after_widget)?$after_widget:''); // After widget code, if any  
	  }
		
	  public function form( $instance ) {
		  
		// PART 1: Extract the data from the instance variable
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		$email = empty($instance['email']) ? '' : sanitize_email($instance['email']);
		$twitter = empty($instance['twitter']) ? '' : esc_url($instance['twitter']);
		$instagram = empty($instance['instagram']) ? '' : esc_url($instance['instagram']);
		$facebook = empty($instance['facebook']) ? '' : esc_url($instance['facebook']);
		$google = empty($instance['google']) ? '' : esc_url($instance['google']);
		$bloglovin = empty($instance['bloglovin']) ? '' : esc_url($instance['bloglovin']);
		$pinterest = empty($instance['pinterest']) ? '' : esc_url($instance['pinterest']);
		$youtube = empty($instance['youtube']) ? '' : esc_url($instance['youtube']);
		$vine = empty($instance['vine']) ? '' : esc_url($instance['vine']);
		$tumblr = empty($instance['tumblr']) ? '' : esc_url($instance['tumblr']);
		$linkedin = empty($instance['linkedin']) ? '' : esc_url($instance['linkedin']);
		$vk = empty($instance['vk']) ? '' : esc_url($instance['vk']);
		$flickr = empty($instance['flickr']) ? '' : esc_url($instance['flickr']);
		$twitch = empty($instance['twitch']) ? '' : esc_url($instance['twitch']);
		$spotify = empty($instance['spotify']) ? '' : esc_url($instance['spotify']);
		$medium = empty($instance['medium']) ? '' : esc_url($instance['medium']);
		$stumbleupon = empty($instance['stumbleupon']) ? '' : esc_url($instance['stumbleupon']);
		$etsy = empty($instance['etsy']) ? '' : esc_url($instance['etsy']);
		$etsy = empty($instance['etsy']) ? '' : esc_url($instance['etsy']);
		$snapchat = empty($instance['snapchat']) ? '' : esc_url($instance['snapchat']);
		$rss = empty($instance['rss']) ? '' : strip_tags($instance['rss']);
		
		$links = get_option('pipdig_links');
		
		if (empty($twitter)) {
			$twitter = esc_url($links['twitter']);
		}
		if (empty($instagram)) {
			$instagram = esc_url($links['instagram']);
		}
		if (empty($facebook)) {
			$facebook = esc_url($links['facebook']);
		}
		if (empty($google)) {
			$google = esc_url($links['google_plus']);
		}
		if (empty($bloglovin)) {
			$bloglovin = esc_url($links['bloglovin']);
		}
		if (empty($pinterest)) {
			$pinterest = esc_url($links['pinterest']);
		}
		if (empty($youtube)) {
			$youtube = esc_url($links['youtube']);
		}
		if (empty($snapchat)) {
			$snapchat = esc_url($links['snapchat']);
		}
		/* not on links page yet
		if (empty($vine)) {
				$vine = esc_url($links['vine']);
		}
		*/
		if (empty($tumblr)) {
			$tumblr = esc_url($links['tumblr']);
		}
		if (empty($linkedin)) {
			$linkedin = esc_url($links['linkedin']);
		}
		if (empty($vk)) {
			$vk = esc_url($links['vk']);
		}
		if (empty($flickr)) {
			$flickr = esc_url($links['flickr']);
		}
		if (empty($twitch)) {
			$twitch = esc_url($links['twitch']);
		}
		if (empty($stumbleupon)) {
			$stumbleupon = esc_url($links['stumbleupon']);
		}
		if (empty($etsy)) {
			$etsy = esc_url($links['etsy']);
		}
		if (empty($rss)) {
			$rss = esc_url($links['rss']);
		}
		if (empty($spotify)) {
			$spotify = esc_url($links['spotify']);
		}
		/* not on links page yet
		if (empty($medium)) {
			$medium = esc_url($links['medium']);
		}
		*/
		if (empty($email)) {
			$email = sanitize_email($links['email']);
		}
		
		$style_select = ( isset( $instance['style_select'] ) && is_numeric( $instance['style_select'] ) ) ? (int) $instance['style_select'] : 1;
	   
		// PART 2-3: Display the fields
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		
		<hr style="margin: 25px 0 10px;">
	
		<p>
			<legend><h3><?php _e('Select a layout:', 'p3'); ?></h3></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="1" <?php checked( $style_select == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-1' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/social_widget_style_1.png" style="position:relative;top:5px;border:1px solid #ddd" /></label>
			<br /><br />
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="2" <?php checked( $style_select == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-2' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/social_widget_style_2.png" style="position:relative;top:5px;border:1px solid #ddd" /></label>
		</p>

		<hr style="margin: 25px 0 10px;">
		
		<h3><?php _e('Add your links:', 'p3'); ?></h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter (e.g. http://twitter.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" 
			name="<?php echo $this->get_field_name('twitter'); ?>" type="url" 
			value="<?php echo esc_url($twitter); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram (e.g. http://instagram.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" 
			name="<?php echo $this->get_field_name('instagram'); ?>" type="text" 
			value="<?php echo esc_url($instagram); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook (e.g. http://facebook.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" 
			name="<?php echo $this->get_field_name('facebook'); ?>" type="text" 
			value="<?php echo esc_url($facebook); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('google'); ?>">Google&#43; (e.g. https://plus.google.com/+pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" 
			name="<?php echo $this->get_field_name('google'); ?>" type="text" 
			value="<?php echo esc_url($google); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('bloglovin'); ?>">Bloglovin (e.g. http://www.bloglovin.com/en/blog/3890264) 
			<input class="widefat" id="<?php echo $this->get_field_id('bloglovin'); ?>" 
			name="<?php echo $this->get_field_name('bloglovin'); ?>" type="text" 
			value="<?php echo esc_url($bloglovin); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('pinterest'); ?>">Pinterest (e.g. http://pinterest.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" 
			name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" 
			value="<?php echo esc_url($pinterest); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('snapchat'); ?>">Snapchat (e.g. https://www.snapchat.com/add/pipdig.co) 
			<input class="widefat" id="<?php echo $this->get_field_id('snapchat'); ?>" 
			name="<?php echo $this->get_field_name('snapchat'); ?>" type="text" 
			value="<?php echo esc_url($snapchat); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>">YouTube (e.g. http://youtube.com/user/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" 
			name="<?php echo $this->get_field_name('youtube'); ?>" type="text" 
			value="<?php echo esc_url($youtube); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('vine'); ?>">Vine (e.g. http://vine.co/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('vine'); ?>" 
			name="<?php echo $this->get_field_name('vine'); ?>" type="text" 
			value="<?php echo esc_url($vine); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('tumblr'); ?>">Tumblr (e.g. http://pipdig.tumblr.com) 
			<input class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" 
			name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" 
			value="<?php echo esc_url($tumblr); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>">Linkedin (e.g. http://linkedin.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" 
			name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" 
			value="<?php echo esc_url($linkedin); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('vk'); ?>">VKontakte (e.g. http://vk.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>" 
			name="<?php echo $this->get_field_name('vk'); ?>" type="text" 
			value="<?php echo esc_url($vk); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>">Flickr (e.g. http://flickr.com/user/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" 
			name="<?php echo $this->get_field_name('flickr'); ?>" type="text" 
			value="<?php echo esc_url($flickr); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('spotify'); ?>">Spotify (e.g. http://open.spotify.com/user/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('spotify'); ?>" 
			name="<?php echo $this->get_field_name('spotify'); ?>" type="text" 
			value="<?php echo esc_url($spotify); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('medium'); ?>">Medium (e.g. https://medium.com/@pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('medium'); ?>" 
			name="<?php echo $this->get_field_name('medium'); ?>" type="text" 
			value="<?php echo esc_url($medium); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitch'); ?>">Twitch (e.g. https://twitch.tv/dansgaming) 
			<input class="widefat" id="<?php echo $this->get_field_id('twitch'); ?>" 
			name="<?php echo $this->get_field_name('twitch'); ?>" type="text" 
			value="<?php echo esc_url($twitch); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('stumbleupon'); ?>">Stumbleupon (e.g. https://stumbleupon.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('stumbleupon'); ?>" 
			name="<?php echo $this->get_field_name('stumbleupon'); ?>" type="text" 
			value="<?php echo esc_url($stumbleupon); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('etsy'); ?>">Etsy (e.g. https://etsy.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('etsy'); ?>" 
			name="<?php echo $this->get_field_name('etsy'); ?>" type="text" 
			value="<?php echo esc_url($etsy); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email Address (e.g. yourname@gmail.com) 
			<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" 
			name="<?php echo $this->get_field_name('email'); ?>" type="text" 
			value="<?php echo sanitize_email($email); ?>" />
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
		$instance['twitter'] = esc_url($new_instance['twitter']);
		$instance['instagram'] = esc_url($new_instance['instagram']);
		$instance['facebook'] = esc_url($new_instance['facebook']);
		$instance['google'] = esc_url($new_instance['google']);
		$instance['bloglovin'] = esc_url($new_instance['bloglovin']);
		$instance['pinterest'] = esc_url($new_instance['pinterest']);
		$instance['snapchat'] = esc_url($new_instance['snapchat']);
		$instance['youtube'] = esc_url($new_instance['youtube']);
		$instance['vine'] = esc_url($new_instance['vine']);
		$instance['tumblr'] = esc_url($new_instance['tumblr']);
		$instance['linkedin'] = esc_url($new_instance['linkedin']);
		$instance['vk'] = esc_url($new_instance['vk']);
		$instance['flickr'] = esc_url($new_instance['flickr']);
		$instance['spotify'] = esc_url($new_instance['spotify']);
		$instance['medium'] = esc_url($new_instance['medium']);
		$instance['twitch'] = esc_url($new_instance['twitch']);
		$instance['stumbleupon'] = esc_url($new_instance['stumbleupon']);
		$instance['etsy'] = esc_url($new_instance['etsy']);
		$instance['email'] = sanitize_email($new_instance['email']);
		$instance['rss'] = strip_tags($new_instance['rss']);
		
		$instance['style_select'] = ( isset( $new_instance['style_select'] ) && $new_instance['style_select'] > 0 && $new_instance['style_select'] < 3 ) ? (int) $new_instance['style_select'] : 0; // 3 is total radio +1

		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_social_icons");') );
}