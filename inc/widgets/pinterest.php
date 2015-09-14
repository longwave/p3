<?php 

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

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
		if (isset($instance['cols'])) { 
			$cols = $instance['cols'];
		} else {
			$cols = 2;
		}
		if ($cols == 2) {
			$width = '49%';
			$height = '150px';
			$tablet_height = '250px';
			$margin = '.5%';
		} elseif ($cols == 3) {
			$width = '32.3%';
			$height = '95px';
			$tablet_height = '150px';
			$margin = '.5%';
		} else {
			$width = '100%';
			$height = '300px';
			$tablet_height = '500px';
			$margin = '5px 0';
		}
		if (isset($instance['follow'])) { 
			$follow = $instance['follow'];
		} else {
			$follow = false;
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
			<style scoped>
				#pinterest-gallery {
				overflow: auto;
				width: 100%;
				list-style: none;
				}
				#pinterest-gallery li {
				float: left;
				width: <?php echo $width; ?>;
				height: <?php echo $height; ?>;
				background-size: cover;
				margin: <?php echo $margin; ?>;
				padding: 0;
				border: none;
				-o-transition: all 0.25s ease-out; -moz-transition: all 0.25s ease-out; -webkit-transition: all 0.25s ease-out; transition: all 0.25s ease-out;
				}
				#pinterest-gallery li:hover {
				opacity: .8;
				}
				#pinterest-gallery img { border: none; }
				.pinterest-link {
				display: block;
				overflow: hidden;
				text-indent: 100%;
				height: 100%;
				white-space: nowrap;
				}
				/* IE correction */
				#pinterest-gallery li a { 
				color: transparent; 
				line-height: 1px;
				font-size: 0px;
				}
				@media screen and (min-width: 400px) and (max-width: 767px) {
					#pinterest-gallery li {
						height: <?php echo $tablet_height; ?>;
					}
				}
			</style>
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
			if (isset($instance['follow'])) {
				if (!empty($pinterestuser) && $follow) { ?>
					<div class="clearfix"></div>
					<p><a href="http://pinterest.com/<?php echo $pinterestuser; ?>" target="_blank" rel="nofollow" style="color: #000;"><i class="fa fa-pinterest" style="font-size: 15px; margin-bottom: -1px"></i> <?php _e('Follow on Pinterest', 'p3'); ?></a></p>
				<?php }
			}
			//$pinterest_count = get_option('pipdig_theme_pinterest_count');
			//if ($pinterest_count) { ?>
				<!--<div class="pinterest-widget-count"><?php //echo $pinterest_count; ?></div> -->
			<?php //} //endif ?>
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
		 $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['pinterestuser'])) { 
			$pinterestuser =	$instance['pinterestuser'];
		}
		if (isset($instance['images_num'])) { 
			$images_num = $instance['images_num'];
		} else {
			$images_num = 4;
		}
		if (isset($instance['cols'])) { 
			$cols = $instance['cols'];
		} else {
			$cols = 2;
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

		<p><?php _e('Add your Pinterest account name to the box below.', 'p3'); ?></p>
		<p><?php _e('For example, the red part below:', 'p3'); ?><br />
		<?php echo esc_url('http://pinterest.com/'); ?><span style="color:red">songofstyle</span></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('pinterestuser'); ?>"><?php _e('Pinterest Account Name:', 'p3'); ?><br />
			<input class="" id="<?php echo $this->get_field_id('pinterestuser'); ?>" 
			name="<?php echo $this->get_field_name('pinterestuser'); ?>" type="text" 
			value="<?php if (isset($instance['pinterestuser'])) { echo esc_attr($pinterestuser); } ?>" placeholder="songofstyle" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label><br />
			<input type="number" min="2" max="12" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of columns:', 'p3'); ?></label><br />
			<input type="number" min="1" max="3" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php if ($cols) { echo $cols; } else { echo '2'; } ?>" />
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['pinterestuser'] = strip_tags( $new_instance['pinterestuser'] );
		$instance['images_num'] = absint( $new_instance['images_num'] );
		$instance['cols'] = absint( $new_instance['cols'] );
		$instance['follow'] = strip_tags( $new_instance['follow'] );

		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_pinterest");') );
}