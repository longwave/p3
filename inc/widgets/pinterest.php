<?php 
if ( !class_exists( 'pipdig_widget_pinterest' ) ) {
	class pipdig_widget_pinterest extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_pinterest', 'description' => __('Displays your latest Pinterest pins.', 'p3') );
		  parent::__construct('pipdig_widget_pinterest', 'pipdig - ' . __('Pinterest Widget', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['pinterestuser'])) { 
			$pinterestuser =	$instance['pinterestuser'];
		}
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		} else {
			$images_num = 4;
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		} else {
			echo $before_title . 'Pinterest' . $after_title;
		}
		

		if (!empty($pinterestuser)) { ?>
		
			<div id="pinterest-gallery"></div>
			<script>
			jQuery(document).ready(function($) {
				var thumbnailCount = <?php echo $images_num; ?>;
				var username = "<?php echo $pinterestuser; ?>";
				var profile = true;
				var board = false;
				var boardname = "";
				var newWindow = true;
				var url;var urlPrefix="https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&q=https://www.pinterest.com/";if(board===true&&profile===true||board===false&&profile===false){$("#pinterest-gallery").append("<p>Error: please choose a profile gallery or board gallery.</p>")}else{if(profile===true){url=urlPrefix+username+"/feed.rss&num="+thumbnailCount}else{if(board===true&&boardname===""){$("#pinterest-gallery").append("<p>Error: Please specify a boardname.</p>")}url=urlPrefix+username+"/"+boardname+"/rss&num="+thumbnailCount}}$.ajax({url:url,dataType:"jsonp",success:function(e){$.each(e.responseData.feed.entries,function(t){var n=e.responseData.feed.entries;var r=n[t].title;var i=n[t].link;var s=n[t].content;var o=s.indexOf("http");var u=s.indexOf('"></a>');var a=s.substring(o,u);var f=$('<li><a class="pinterest-link" href="'+i+'">'+r+"</a></li>");if(newWindow===true){$(".pinterest-link").attr("target","_blank")}f.appendTo("#pinterest-gallery").css("background-image","url("+a+")")})}})
			});
			</script>
			<?php
			//$pinterest_count = get_option('pipdig_theme_pinterest_count');
			//if ($pinterest_count) { ?>
				<!--<div class="pinterest-widget-count"><?php //echo $pinterest_count; ?></div> -->
			<?php //} //endif ?>
		<?php
		} else {
			_e('Setup not complete. Please add your Pinterest username to the Pinterest Widget in the dashboard.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		 // PART 1: Extract the data from the instance variable
		 $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		 $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['pinterestuser'])) { 
			$pinterestuser =	$instance['pinterestuser'];
		}
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		} else {
			$images_num = 4;
		}
		 // PART 2-3: Display the fields
		 ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>

		<p><?php _e('Add your Pinterest account name to the box below.', 'p3'); ?></p>
		<p><?php _e('For example, the red part of this link:', 'p3'); ?></p>
		<p><?php echo esc_url('http://pinterest.com/'); ?><span style="color:red">songofstyle</span></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('pinterestuser'); ?>"><?php _e('Pinterest Account Name:', 'p3'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('pinterestuser'); ?>" 
			name="<?php echo $this->get_field_name('pinterestuser'); ?>" type="text" 
			value="<?php if (isset($instance['pinterestuser'])) { echo esc_attr($pinterestuser); } ?>" placeholder="songofstyle" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label>
			<input type="number" min="2" max="12" step="2" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>

		 <?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['pinterestuser'] = strip_tags( $new_instance['pinterestuser'] );
		$instance['images_num'] = absint( $new_instance['images_num'] );

		return $instance;
	  }
	  
	}
	//add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_pinterest");') );
} // end class exists check