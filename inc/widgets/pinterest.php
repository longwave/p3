<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'pipdig_widget_pinterest' ) ) {
	class pipdig_widget_pinterest extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_pinterest', 'description' => __('Displays your latest Pinterest pins.', 'p3') );
		  parent::__construct('pipdig_widget_pinterest', 'pipdig - ' . __('Pinterest Pins', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['pinterestuser'])) { 
			$pinterestuser = pipdig_strip($instance['pinterestuser']);
			$pinterestuser = str_replace('/', '', $pinterestuser);
		}
		if (isset($instance['images_num'])) { 
			$images_num = intval($instance['images_num'])-1;
		} else {
			$images_num = 4;
		}
		if (isset($instance['cols'])) { 
			$cols = intval($instance['cols']);
		} else {
			$cols = 2;
		}
		if ($cols == 3) {
			$width = '33.333333%';
			$border = '1';
		} elseif ($cols == 4) {
			$width = '25%';
			$border = '1';
		} elseif ($cols == 1) {
			$width = '100%';
			$border = '0';
		} else {
			$width = '50%';
			$border = '2';
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

		if (!empty($pinterestuser)) {
			
			$id = 'p3_pinterest_widget_'.rand(1, 999999999);
			$images = p3_pinterest_fetch($pinterestuser); // grab images
		
			//print_r($images);
			
			if ($images) {
			?>
				<div id="<?php echo $id; ?>" class="p3_pinterest_widget">
				<style scoped>
					#<?php echo $id; ?> .p3_pinterest_post {
						width: <?php echo $width; ?>;
						border: <?php echo $border; ?>px solid <?php echo get_theme_mod('content_background_color', '#fff'); ?>
					}
				</style>
				<?php for ($x = 0; $x <= $images_num; $x++) { ?>
					<a href="<?php echo $images[$x]['link']; ?>" class="p3_pinterest_post" style="background-image:url(<?php echo $images[$x]['src']; ?>);" rel="nofollow" target="_blank">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" class="p3_invisible" alt=""/>
					</a>
				<?php } ?>
				</div>
				<div class="clearfix"></div>
				<?php
				if (isset($instance['follow'])) {
				if (!empty($pinterestuser) && $follow) { ?>
					<div class="clearfix"></div>
					<p style="margin: 10px 0"><a href="http://pinterest.com/<?php echo $pinterestuser; ?>" target="_blank" rel="nofollow" style="color: #000;"><i class="fa fa-pinterest" style="font-size: 15px;"></i> <?php _e('Follow on Pinterest', 'p3'); ?></a></p>
				<?php }
			}
			
			} else {
				_e('Setup not complete. Please check the widget options.', 'p3');
			}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	}
	}
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if (isset($instance['pinterestuser'])) {
			$pinterestuser = pipdig_strip($instance['pinterestuser']);
		} else {
			$links = get_option('pipdig_links');
			$pinterest_url = esc_url($links['pinterest']);
			if (!empty($pinterest_url)) {
				$pinterestuser = parse_url($pinterest_url, PHP_URL_PATH);
				$pinterestuser = str_replace('/', '', $pinterestuser);
			} else {
				$pinterestuser = '';
			}
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
		http://pinterest.com/<span style="color:red">songofstyle</span></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('pinterestuser'); ?>"><?php _e('Pinterest Account Name:', 'p3'); ?><br />
			<input class="" id="<?php echo $this->get_field_id('pinterestuser'); ?>" 
			name="<?php echo $this->get_field_name('pinterestuser'); ?>" type="text" 
			value="<?php echo esc_attr($pinterestuser); ?>" placeholder="songofstyle" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('images_num'); ?>"><?php _e('Number of images to display:', 'p3'); ?></label><br />
			<input type="number" min="2" max="12" id="<?php echo $this->get_field_id( 'images_num' ); ?>" name="<?php echo $this->get_field_name( 'images_num' ); ?>" value="<?php if ($images_num) { echo $images_num; } else { echo '4'; } ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of columns:', 'p3'); ?></label><br />
			<input type="number" min="1" max="4" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php if ($cols) { echo $cols; } else { echo '2'; } ?>" />
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
		
		delete_transient('p3_pinz');
		
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_pinterest");') );
}