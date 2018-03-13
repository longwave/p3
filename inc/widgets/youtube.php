<?php 
if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_widget_latest_youtube' ) ) {
	class pipdig_widget_latest_youtube extends WP_Widget {
	 
	public function __construct() {
		$widget_ops = array('classname' => 'pipdig_widget_latest_youtube', 'description' => __('Automatically displays your latest YouTube video.', 'p3') );
		parent::__construct('pipdig_widget_latest_youtube', 'pipdig - ' . __('YouTube Videos', 'p3'), $widget_ops);
	}
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'YouTube' . $after_title;
		}
		
		$letsplay = false;
		
		if (isset($instance['channel_id'])) { 
			$channel_id = strip_tags($instance['channel_id']);
		}
		if (isset($instance['playlist_id'])) { 
			$playlist_id = strip_tags($instance['playlist_id']);
		}

		if (!empty($channel_id)) {
			$letsplay = true;
			$videos = p3_youtube_fetch($channel_id); // grab videos
		}
		
		if (!empty($playlist_id)) {
			$letsplay = true;
			$videos = p3_youtube_fetch_playlist($playlist_id); // grab playlist videos
		}
		
		if ($letsplay) {
			
			if (isset($instance['number'])) { 
				$number = absint($instance['number']);
			} else {
				$number = 1;
			}
			
			if (isset($instance['cols'])) { 
				$cols = absint($instance['cols']);
			} else {
				$cols = 1;
			}
			
			//print_r($videos);
			
			//echo '<h1>'.$number.'</h1>';
				
			if ($videos) { ?>
			
				<?php
				
				$lazy = false;
				$lazy_class = '';
				if (is_pipdig_lazy()) {
					$lazy = true;
					$lazy_class = ' pipdig_lazy';
				}
				
				$id = 'p3_youtube_widget_'.rand(1, 999999999);
				
				$horizontal = '';
				if (!empty($instance['horizontal'])) {
					$horizontal = 'p3_youtube_widget_horizontal';
					?>
					<style>
					#<?php echo $id; ?> .p3_youtube_widget_horizontal {
						width: <?php echo (100 / $number) -1; ?>%;
						margin: .5%;
					}
					</style>
					<?php
				}
				
				?>
			
				<div id="<?php echo $id; ?>">
				
				<?php
				
				if (!empty($instance['shuffle'])) {
					shuffle($videos);
				}
				
				$i = 1; // just for margin counter below
				
				$pipdig_preview = false;
				if (function_exists('pipdig_previews_remove_scripts')) {
					$pipdig_preview = true;
				}

				?>
			
				<?php foreach($videos as $video) { ?>
				
					<?php
					
					$link = '';
					if ($pipdig_preview) {
						$link = esc_url($video['link']);
					}
					
					$image_src = 'style="background-image:url('.esc_url($video['thumbnail']).');"';
					if ($lazy) {
						$image_src = 'data-src="'.esc_url($video['thumbnail']).'"';
					}
					
					// margin for all except first in series
					$margin_class = '';
					if (empty($horizontal) && ($number > 1) && ($i != 1)) {
						$margin_class = ' p3_youtube_margin';
					}
					$i++;
					?>
					<div class="p3_youtube_widget_wrapper <?php echo $horizontal; ?>">
					<div class="p3_youtube_widget p3_cover_me<?php echo $lazy_class.$margin_class; ?>" <?php echo $image_src; ?>>
						<a href="<?php echo $link; ?>" target="_blank" rel="nofollow noopener" data-p3-youtube="<?php echo esc_attr($video['id']); ?>">
							<img class="p3_invisible" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABQAAAALQAQMAAAD1s08VAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAJRJREFUeNrswYEAAAAAgKD9qRepAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADg9uCQAAAAAEDQ/9eeMAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKsAxN8AAX2oznYAAAAASUVORK5CYII=" alt="<?php echo esc_attr($video['title']); ?>"/>
							<i class="fa fa-youtube-play"></i>
						</a>
					</div>
					<?php if (!empty($instance['show_title'])) { ?>
						<a href="<?php echo esc_url($video['link']); ?>" target="_blank" rel="nofollow noopener"><?php echo esc_html($video['title']); ?></a>
					<?php } ?>
					</div>
					
					<?php if ($i == $number+1) {
						break;
					} ?>
					
				<?php } ?>
				<div class="clearfix"></div>
				</div>
				<?php if (!$pipdig_preview) { ?>
				<script>
				jQuery(document).ready(function($) {
					$('.p3_youtube_widget a').click(function(e){
						e.preventDefault();
						var videoId = $(this).data('p3-youtube');
						$(this).html('<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/'+videoId+'?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
						$('.p3_youtube_widget').fitVids();
					});
				});
				</script>
				<?php } ?>
			<?php
			}
			
		} else {
			echo 'YouTube widget in section "'.$args['name'].'": '.__('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['channel_id'])) { 
			$channel_id = $instance['channel_id'];
		}
		if (isset($instance['playlist_id'])) { 
			$playlist_id = $instance['playlist_id'];
		}

		$number = 1;
		if (isset($instance['number'])) { 
			$number = absint($instance['number']);
		}

	   
		// PART 2-3: Display the fields
		?>
		 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		
		<p>This widget will display recent videos from either a YouTube Channel or a Playlist.</p>
		
		<h3>Display Options</h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of videos to display', 'p3'); ?></label>
			<select id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" class="">
				<option <?php selected( $number, 1); ?> value="1">1</option>
				<option <?php selected( $number, 2); ?> value="2">2</option>
				<option <?php selected( $number, 3); ?> value="3">3</option>
				<option <?php selected( $number, 4); ?> value="4">4</option>
				<option <?php selected( $number, 5); ?> value="5">5</option>
				<option <?php selected( $number, 6); ?> value="6">6</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('shuffle'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('shuffle'); ?>" name="<?php echo $this->get_field_name('shuffle'); ?>" <?php if (isset($instance['shuffle'])) { checked( (bool) $instance['shuffle'], true ); } ?> /><?php _e('Display videos randomly', 'p3'); ?></label>
			<br />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_title'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" <?php if (isset($instance['show_title'])) { checked( (bool) $instance['show_title'], true ); } ?> /><?php _e('Display the video title', 'p3'); ?></label>
			<br />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('horizontal'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('horizontal'); ?>" name="<?php echo $this->get_field_name('horizontal'); ?>" <?php if (isset($instance['horizontal'])) { checked( (bool) $instance['horizontal'], true ); } ?> /><?php _e('Display videos horizontally (instead of vertically)', 'p3'); ?></label>
			<br />
		</p>
		
		
		<!--<p>You can display either a Channel or a Playlist in this widget. Use one of the options below:</p>-->
		
		<h3>YouTube Channel</h3>
		<p>If you would like to display any videos from a channel, you should enter your <a href="https://support.google.com/youtube/answer/3250431" target="_blank">Channel ID</a> below.</p>
		<p>
			<label for="<?php echo $this->get_field_id('channel_id'); ?>"><?php _e('YouTube Channel ID:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('channel_id'); ?>" 
			name="<?php echo $this->get_field_name('channel_id'); ?>" type="text" 
			value="<?php if (isset($instance['channel_id'])) { echo esc_attr($channel_id); } ?>" />
			</label>
		</p>
		
		<h3 style="margin-top:30px">YouTube Playlist</h3>
		<p>If you would like to display videos from a specific playlist, simply enter your Playlist ID below. <a href="https://support.pipdig.co/articles/wordpress-youtube-widget/">Click here</a> for information about how to find the Id of a playlist. If you add a Paylist ID, this will override the Channel ID.</p>		
		<p>
			<label for="<?php echo $this->get_field_id('playlist_id'); ?>"><?php _e('YouTube Playlist ID:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('playlist_id'); ?>" 
			name="<?php echo $this->get_field_name('playlist_id'); ?>" type="text" 
			value="<?php if (isset($instance['playlist_id'])) { echo esc_attr($playlist_id); } ?>" />
			</label>
		</p>

		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = pipdig_strip( $new_instance['title'] );
		$instance['channel_id'] = strip_tags(trim($new_instance['channel_id']));
		$instance['playlist_id'] = strip_tags(trim($new_instance['playlist_id']));
		$instance['number'] = absint($new_instance['number']);
		$instance['shuffle'] = strip_tags($new_instance['shuffle']);
		$instance['horizontal'] = strip_tags($new_instance['horizontal']);
		$instance['show_title'] = strip_tags($new_instance['show_title']);
		delete_transient('p3_youtube_widget_'.$instance['channel_id']); // delete transient
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_latest_youtube");') );
}