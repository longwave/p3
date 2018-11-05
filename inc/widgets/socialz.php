<?php 

if (!defined('ABSPATH')) die;

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
		$soundcloud = empty($instance['soundcloud']) ? '' : esc_url($instance['soundcloud']);
		$itunes = empty($instance['itunes']) ? '' : esc_url($instance['itunes']);
		$medium = empty($instance['medium']) ? '' : esc_url($instance['medium']);
		$stumbleupon = empty($instance['stumbleupon']) ? '' : esc_url($instance['stumbleupon']);
		$etsy = empty($instance['etsy']) ? '' : esc_url($instance['etsy']);
		$snapchat = empty($instance['snapchat']) ? '' : esc_url($instance['snapchat']);
		$goodreads = empty($instance['goodreads']) ? '' : esc_url($instance['goodreads']);
		$vimeo = empty($instance['vimeo']) ? '' : esc_url($instance['vimeo']);
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
		
			if (!empty($twitter)) $icons_output .= '<a href="'.$twitter.'" target="_blank" rel="nofollow noopener" aria-label="twitter" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
			if (!empty($instagram)) $icons_output .= '<a href="'.$instagram.'" target="_blank" rel="nofollow noopener" aria-label="instagram" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
			if (!empty($facebook)) $icons_output .= '<a href="'.$facebook.'" target="_blank" rel="nofollow noopener" aria-label="facebook" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
			if (!empty($google)) $icons_output .= '<a href="'.$google.'" target="_blank" rel="nofollow noopener" aria-label="google" title="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
			if (!empty($bloglovin)) $icons_output .= '<a href="'.$bloglovin.'" target="_blank" rel="nofollow noopener" aria-label="bloglovin" title="bloglovin"><i class="fa fa-plus" aria-hidden="true"></i></a>';
			if (!empty($pinterest)) $icons_output .= '<a href="'.$pinterest.'" target="_blank" rel="nofollow noopener" aria-label="pinterest" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
			if (!empty($snapchat)) $icons_output .= '<a href="'.$snapchat.'" target="_blank" rel="nofollow noopener" aria-label="snapchat" title="snapchat"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></a>';
			if (!empty($youtube)) $icons_output .= '<a href="'.$youtube.'" target="_blank" rel="nofollow noopener" aria-label="youtube" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
			if (!empty($vimeo)) $icons_output .= '<a href="'.$vimeo.'" target="_blank" rel="nofollow noopener" aria-label="vimeo" title="vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i></a>';
			if (!empty($vine)) $icons_output .= '<a href="'.$vine.'" target="_blank" rel="nofollow noopener" aria-label="vine" title="vine"><i class="fa fa-vine" aria-hidden="true"></i></a>';
			if (!empty($tumblr)) $icons_output .= '<a href="'.$tumblr.'" target="_blank" rel="nofollow noopener" aria-label="tumblr" title="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>';
			if (!empty($linkedin)) $icons_output .= '<a href="'.$linkedin.'" target="_blank" rel="nofollow noopener" aria-label="linkedin" title="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
			if (!empty($vk)) $icons_output .= '<a href="'.$vk.'" target="_blank" rel="nofollow noopener" aria-label="vk" title="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>';
			if (!empty($flickr)) $icons_output .= '<a href="'.$flickr.'" target="_blank" rel="nofollow noopener" aria-label="flickr" title="flickr"><i class="fa fa-flickr" aria-hidden="true"></i></a>';
			if (!empty($goodreads)) $icons_output .= '<a href="'.$goodreads.'" target="_blank" rel="nofollow noopener" aria-label="goodreads" title="goodreads"><i class="fa fa-book" aria-hidden="true"></i></a>';
			if (!empty($spotify)) $icons_output .= '<a href="'.$spotify.'" target="_blank" rel="nofollow noopener" aria-label="spotify" title="spotify"><i class="fa fa-spotify" aria-hidden="true"></i></a>';
			if (!empty($itunes)) $icons_output .= '<a href="'.$itunes.'" target="_blank" rel="nofollow noopener" aria-label="itunes" title="itunes"><i class="fa fa-apple" aria-hidden="true"></i></a>';
			if (!empty($soundcloud)) $icons_output .= '<a href="'.$soundcloud.'" target="_blank" rel="nofollow noopener" aria-label="soundcloud" title="soundcloud"><i class="fa fa-soundcloud" aria-hidden="true"></i></a>';
			if (!empty($medium)) $icons_output .= '<a href="'.$medium.'" target="_blank" rel="nofollow noopener" aria-label="medium" title="medium"><i class="fa fa-medium" aria-hidden="true"></i></a>';
			if (!empty($twitch)) $icons_output .= '<a href="'.$twitch.'" target="_blank" rel="nofollow noopener" aria-label="twitch" title="twitch"><i class="fa fa-twitch" aria-hidden="true"></i></a>';
			if (!empty($stumbleupon)) $icons_output .= '<a href="'.$stumbleupon.'" target="_blank" rel="nofollow noopener" aria-label="stumbleupon" title="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a>';
			if (!empty($etsy)) $icons_output .= '<a href="'.$etsy.'" target="_blank" rel="nofollow noopener" aria-label="etsy" title="etsy"><i class="fa fa-etsy" aria-hidden="true"></i></a>';
			if (!empty($email)) $icons_output .= '<a href="mailto:'.$email.'" aria-label="Email" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
			if (!empty($rss)) $icons_output .= '<a href="'.$rss.'" target="_blank" rel="nofollow noopener" aria-label="RSS Feed" title="RSS Feed"><i class="fa fa-rss" aria-hidden="true"></i></a>';
			
			echo '<div class="socialz">'.$icons_output.'</div>';
		
		} else {
			
			if (!empty($twitter)) $icons_output .= '<a href="'.$twitter.'" target="_blank" rel="nofollow noopener" aria-label="twitter" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i><br /><span>Twitter</span></a>';
			if (!empty($instagram)) $icons_output .= '<a href="'.$instagram.'" target="_blank" rel="nofollow noopener" aria-label="instagram" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i><br /><span>Instagram</span></a>';
			if (!empty($facebook)) $icons_output .= '<a href="'.$facebook.'" target="_blank" rel="nofollow noopener" aria-label="facebook" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i><br /><span>Facebook</span></a>';
			if (!empty($google)) $icons_output .= '<a href="'.$google.'" target="_blank" rel="nofollow noopener" aria-label="google" title="google"><i class="fa fa-google-plus" aria-hidden="true"></i><br /><span>Google+</span></a>';
			if (!empty($bloglovin)) $icons_output .= '<a href="'.$bloglovin.'" target="_blank" rel="nofollow noopener" aria-label="bloglovin" title="bloglovin"><i class="fa fa-plus" aria-hidden="true"></i><br /><span>Bloglovin</span></a>';
			if (!empty($pinterest)) $icons_output .= '<a href="'.$pinterest.'" target="_blank" rel="nofollow noopener" aria-label="pinterest" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i><br /><span>Pinterest</span></a>';
			if (!empty($snapchat)) $icons_output .= '<a href="'.$snapchat.'" target="_blank" rel="nofollow noopener" aria-label="snapchat" title="snapchat"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i><br /><span>Snapchat</span></a>';
			if (!empty($youtube)) $icons_output .= '<a href="'.$youtube.'" target="_blank" rel="nofollow noopener" aria-label="youtube" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i><br /><span>YouTube</span></a>';
			if (!empty($vimeo)) $icons_output .= '<a href="'.$vimeo.'" target="_blank" rel="nofollow noopener" aria-label="vimeo" title="vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i><br /><span>Vimeo</span></a>';
			if (!empty($vine)) $icons_output .= '<a href="'.$vine.'" target="_blank" rel="nofollow noopener" aria-label="vine" title="vine"><i class="fa fa-vine" aria-hidden="true"></i><br /><span>Vine</span></a>';
			if (!empty($tumblr)) $icons_output .= '<a href="'.$tumblr.'" target="_blank" rel="nofollow noopener" aria-label="tumblr" title="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i><br /><span>Tumblr</span></a>';
			if (!empty($linkedin)) $icons_output .= '<a href="'.$linkedin.'" target="_blank" rel="nofollow noopener" aria-label="linkedin" title="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i><br /><span>LinkedIn</span></a>';
			if (!empty($vk)) $icons_output .= '<a href="'.$vk.'" target="_blank" rel="nofollow noopener" aria-label="VKontakte" title="VKontakte"><i class="fa fa-vk" aria-hidden="true"></i><br /><span>VKontakte</span></a>';
			if (!empty($flickr)) $icons_output .= '<a href="'.$flickr.'" target="_blank" rel="nofollow noopener" aria-label="Flickr" title="Flickr"><i class="fa fa-flickr" aria-hidden="true"></i><br /><span>Flickr</span></a>';
			if (!empty($goodreads)) $icons_output .= '<a href="'.$goodreads.'" target="_blank" rel="nofollow noopener" aria-label="Goodreads" title="Goodreads"><i class="fa fa-book" aria-hidden="true"></i><br /><span>Goodreads</span></a>';
			if (!empty($spotify)) $icons_output .= '<a href="'.$spotify.'" target="_blank" rel="nofollow noopener" aria-label="spotify" title="spotify"><i class="fa fa-spotify" aria-hidden="true"></i><br /><span>Spotify</span></a>';
			if (!empty($itunes)) $icons_output .= '<a href="'.$itunes.'" target="_blank" rel="nofollow noopener" aria-label="itunes" title="itunes"><i class="fa fa-apple" aria-hidden="true"></i><br /><span>iTunes</span></a>';
			if (!empty($soundcloud)) $icons_output .= '<a href="'.$soundcloud.'" target="_blank" rel="nofollow noopener" aria-label="soundcloud" title="soundcloud"><i class="fa fa-soundcloud" aria-hidden="true"></i><br /><span>Soundcloud</span></a>';
			if (!empty($medium)) $icons_output .= '<a href="'.$medium.'" target="_blank" rel="nofollow noopener" aria-label="medium" title="medium"><i class="fa fa-medium" aria-hidden="true"></i><br /><span>Medium</span></a>';
			if (!empty($twitch)) $icons_output .= '<a href="'.$twitch.'" target="_blank" rel="nofollow noopener" aria-label="twitch" title="twitch"><i class="fa fa-twitch" aria-hidden="true"></i><br /><span>Twitch</span></a>';
			if (!empty($stumbleupon)) $icons_output .= '<a href="'.$stumbleupon.'" target="_blank" rel="nofollow noopener" aria-label="stumbleupon" title="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i><br /><span>Stumble</span></a>';
			if (!empty($etsy)) $icons_output .= '<a href="'.$etsy.'" target="_blank" rel="nofollow noopener" aria-label="etsy" title="etsy"><i class="fa fa-etsy" aria-hidden="true"></i><br /><span>Etsy</span></a>';
			if (!empty($email)) $icons_output .= '<a href="mailto:'.$email.'"><i class="fa fa-envelope" aria-hidden="true"></i><br /><span>Email</span></a>';
			if (!empty($rss)) $icons_output .= '<a href="'.$rss.'" target="_blank" rel="nofollow noopener" aria-label="RSS Feed" title="RSS Feed"><i class="fa fa-rss" aria-hidden="true"></i><br /><span>RSS</span></a>';
			echo '<div class="socialz pipdig_socialz_2">'.$icons_output.'</div>';

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
		$vimeo = empty($instance['vimeo']) ? '' : esc_url($instance['vimeo']);
		$vine = empty($instance['vine']) ? '' : esc_url($instance['vine']);
		$tumblr = empty($instance['tumblr']) ? '' : esc_url($instance['tumblr']);
		$linkedin = empty($instance['linkedin']) ? '' : esc_url($instance['linkedin']);
		$vk = empty($instance['vk']) ? '' : esc_url($instance['vk']);
		$flickr = empty($instance['flickr']) ? '' : esc_url($instance['flickr']);
		$twitch = empty($instance['twitch']) ? '' : esc_url($instance['twitch']);
		$spotify = empty($instance['spotify']) ? '' : esc_url($instance['spotify']);
		$itunes = empty($instance['itunes']) ? '' : esc_url($instance['itunes']);
		$soundcloud = empty($instance['soundcloud']) ? '' : esc_url($instance['soundcloud']);
		$medium = empty($instance['medium']) ? '' : esc_url($instance['medium']);
		$stumbleupon = empty($instance['stumbleupon']) ? '' : esc_url($instance['stumbleupon']);
		$etsy = empty($instance['etsy']) ? '' : esc_url($instance['etsy']);
		$snapchat = empty($instance['snapchat']) ? '' : esc_url($instance['snapchat']);
		$goodreads = empty($instance['goodreads']) ? '' : esc_url($instance['goodreads']);
		$rss = empty($instance['rss']) ? '' : strip_tags($instance['rss']);
		
		$links = get_option('pipdig_links');
		
		if (empty($twitter) && isset($links['twitter'])) {
			$twitter = esc_url($links['twitter']);
		}
		if (empty($instagram) && isset($links['instagram'])) {
			$instagram = esc_url($links['instagram']);
		}
		if (empty($facebook) && isset($links['facebook'])) {
			$facebook = esc_url($links['facebook']);
		}
		if (empty($google) && isset($links['google_plus'])) {
			$google = esc_url($links['google_plus']);
		}
		if (empty($bloglovin) && isset($links['bloglovin'])) {
			$bloglovin = esc_url($links['bloglovin']);
		}
		if (empty($pinterest) && isset($links['pinterest'])) {
			$pinterest = esc_url($links['pinterest']);
		}
		if (empty($youtube) && isset($links['youtube'])) {
			$youtube = esc_url($links['youtube']);
		}
		if (empty($vimeo) && isset($links['vimeo'])) {
			$vimeo = esc_url($links['vimeo']);
		}
		if (empty($snapchat) && isset($links['snapchat'])) {
			$snapchat = esc_url($links['snapchat']);
		}
		if (empty($soundcloud) && isset($links['soundcloud'])) {
				$soundcloud = esc_url($links['soundcloud']);
		}
		if (empty($tumblr) && isset($links['tumblr'])) {
			$tumblr = esc_url($links['tumblr']);
		}
		if (empty($linkedin) && isset($links['linkedin'])) {
			$linkedin = esc_url($links['linkedin']);
		}
		if (empty($vk) && isset($links['vk'])) {
			$vk = esc_url($links['vk']);
		}
		if (empty($flickr) && isset($links['flickr'])) {
			$flickr = esc_url($links['flickr']);
		}
		if (empty($twitch) && isset($links['twitch'])) {
			$twitch = esc_url($links['twitch']);
		}
		if (empty($stumbleupon) && isset($links['stumbleupon'])) {
			$stumbleupon = esc_url($links['stumbleupon']);
		}
		if (empty($etsy) && isset($links['etsy'])) {
			$etsy = esc_url($links['etsy']);
		}
		if (empty($rss) && isset($links['rss'])) {
			$rss = esc_url($links['rss']);
		}
		if (empty($spotify) && isset($links['spotify'])) {
			$spotify = esc_url($links['spotify']);
		}
		if (empty($goodreads) && isset($links['goodreads'])) {
			$goodreads = esc_url($links['goodreads']);
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
	
		<div>
			<legend><h3><?php _e('Select a layout:', 'p3'); ?></h3></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="1" <?php checked( $style_select == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-1' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/social_widget_style_1.png" style="position:relative;top:5px;border:1px solid #ddd" /></label>
			<br /><br />
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="2" <?php checked( $style_select == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-2' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/social_widget_style_2.png" style="position:relative;top:5px;border:1px solid #ddd" /></label>
		</div>

		<hr style="margin: 25px 0 10px;">
		
		<!--
		<button type="button" class="button" id="p3_import_socialz_btn">Copy social links</button>
		
		<script>
		jQuery(document).ready(function($) {
			$('#p3_import_socialz_btn').click(function(e) {
				alert('tt');
			});
		});
		</script>
		-->
		
		<h3><?php _e('Add your links:', 'p3'); ?></h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email Address (e.g. yourname@gmail.com) 
			<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" 
			name="<?php echo $this->get_field_name('email'); ?>" type="text" 
			value="<?php echo sanitize_email($email); ?>" />
			</label>
		</p>
		
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
			<label for="<?php echo $this->get_field_id('vimeo'); ?>">Vimeo (e.g. http:///vimeo.com/pipdig)
			<input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" 
			name="<?php echo $this->get_field_name('vimeo'); ?>" type="text" 
			value="<?php echo esc_url($vimeo); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('rss'); ?>">RSS Feed (e.g. http://mydomain.com/feed) 
			<input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" 
			name="<?php echo $this->get_field_name('rss'); ?>" type="text" 
			value="<?php echo esc_attr($rss); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('goodreads'); ?>">Goodreads (e.g. https://goodreads.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('goodreads'); ?>" 
			name="<?php echo $this->get_field_name('goodreads'); ?>" type="text" 
			value="<?php echo esc_url($goodreads); ?>" />
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
			<label for="<?php echo $this->get_field_id('soundcloud'); ?>">Soundcloud (e.g. http://soundcloud.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" 
			name="<?php echo $this->get_field_name('soundcloud'); ?>" type="text" 
			value="<?php echo esc_url($soundcloud); ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('itunes'); ?>">iTunes (e.g. http://itunes.com/pipdig) 
			<input class="widefat" id="<?php echo $this->get_field_id('itunes'); ?>" 
			name="<?php echo $this->get_field_name('itunes'); ?>" type="text" 
			value="<?php echo esc_url($itunes); ?>" />
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
		$instance['vimeo'] = esc_url($new_instance['vimeo']);
		$instance['vine'] = esc_url($new_instance['vine']);
		$instance['tumblr'] = esc_url($new_instance['tumblr']);
		$instance['linkedin'] = esc_url($new_instance['linkedin']);
		$instance['vk'] = esc_url($new_instance['vk']);
		$instance['flickr'] = esc_url($new_instance['flickr']);
		$instance['spotify'] = esc_url($new_instance['spotify']);
		$instance['itunes'] = esc_url($new_instance['itunes']);
		$instance['soundcloud'] = esc_url($new_instance['soundcloud']);
		$instance['medium'] = esc_url($new_instance['medium']);
		$instance['twitch'] = esc_url($new_instance['twitch']);
		$instance['stumbleupon'] = esc_url($new_instance['stumbleupon']);
		$instance['etsy'] = esc_url($new_instance['etsy']);
		$instance['goodreads'] = esc_url($new_instance['goodreads']);
		$instance['email'] = sanitize_email($new_instance['email']);
		$instance['rss'] = strip_tags($new_instance['rss']);
		
		$instance['style_select'] = ( isset( $new_instance['style_select'] ) && $new_instance['style_select'] > 0 && $new_instance['style_select'] < 3 ) ? (int) $new_instance['style_select'] : 0; // 3 is total radio +1

		return $instance;
	  }
	  
	}
	
}