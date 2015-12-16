<?php 

if (!defined('ABSPATH')) {
	exit;
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
			$pinterestuser = $instance['pinterestuser'];
			$pinterestuser = str_replace('/', '', $pinterestuser);
		}
		if (isset($instance['images_num'])) { 
			$images_num = intval($instance['images_num']);
		} else {
			$images_num = 4;
		}
		if (isset($instance['cols'])) { 
			$cols = intval($instance['cols']);
		} else {
			$cols = 2;
		}
		if ($cols == 2) {
			$width = '50%';
		} elseif ($cols == 3) {
			$width = '33%';
		} else {
			$width = '100%';
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
			/*
			$p3_pinz = get_transient('p3_pinz');
			
			if ( false === ( $value = get_transient('p3_pinz') ) ) {
		
				$pinterest_yql = wp_remote_fopen("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22https%3A%2F%2Fwww.pinterest.com%2F".$pinterestuser."%2Ffeed.rss%22&format=json", array( 'timeout' => 30 ));
				$pinterest_yql = json_decode($pinterest_yql);
				
				// yowza! Loop this in future release plx
				
				$pinterest_pin_1 = $pinterest_yql->query->results->body->rss->channel->item[0]->description;
				$pinterest_pin_1 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_1, $result);
				$pinterest_pin_1 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_1 = str_replace('"', '', $pinterest_pin_1);
				
				$pinterest_pin_2 = $pinterest_yql->query->results->body->rss->channel->item[1]->description;
				$pinterest_pin_2 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_2, $result);
				$pinterest_pin_2 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_2 = str_replace('"', '', $pinterest_pin_2);
				
				$pinterest_pin_3 = $pinterest_yql->query->results->body->rss->channel->item[2]->description;
				$pinterest_pin_3 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_3, $result);
				$pinterest_pin_3 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_3 = str_replace('"', '', $pinterest_pin_3);

				$pinterest_pin_4 = $pinterest_yql->query->results->body->rss->channel->item[3]->description;
				$pinterest_pin_4 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_4, $result);
				$pinterest_pin_4 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_4 = str_replace('"', '', $pinterest_pin_4);
				
				$pinterest_pin_5 = $pinterest_yql->query->results->body->rss->channel->item[4]->description;
				$pinterest_pin_5 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_5, $result);
				$pinterest_pin_5 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_5 = str_replace('"', '', $pinterest_pin_5);
				
				$pinterest_pin_6 = $pinterest_yql->query->results->body->rss->channel->item[5]->description;
				$pinterest_pin_6 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_6, $result);
				$pinterest_pin_6 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_6 = str_replace('"', '', $pinterest_pin_6);
				
				$pinterest_pin_7 = $pinterest_yql->query->results->body->rss->channel->item[6]->description;
				$pinterest_pin_7 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_7, $result);
				$pinterest_pin_7 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_7 = str_replace('"', '', $pinterest_pin_7);

				$pinterest_pin_8 = $pinterest_yql->query->results->body->rss->channel->item[7]->description;
				$pinterest_pin_8 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_8, $result);
				$pinterest_pin_8 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_8 = str_replace('"', '', $pinterest_pin_8);
				
				$pinterest_pin_9 = $pinterest_yql->query->results->body->rss->channel->item[8]->description;
				$pinterest_pin_9 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_9, $result);
				$pinterest_pin_9 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_9 = str_replace('"', '', $pinterest_pin_9);
				
				$pinterest_pin_10 = $pinterest_yql->query->results->body->rss->channel->item[9]->description;
				$pinterest_pin_10 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_10, $result);
				$pinterest_pin_10 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_10 = str_replace('"', '', $pinterest_pin_10);

				$pinterest_pin_11 = $pinterest_yql->query->results->body->rss->channel->item[10]->description;
				$pinterest_pin_11 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_11, $result);
				$pinterest_pin_11 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_11 = str_replace('"', '', $pinterest_pin_11);
				
				$pinterest_pin_12 = $pinterest_yql->query->results->body->rss->channel->item[11]->description;
				$pinterest_pin_12 = preg_match_all('@src="([^"]+)"@', $pinterest_pin_12, $result);
				$pinterest_pin_12 = str_replace('src="', '', $result[0][0]);
				$pinterest_pin_12 = str_replace('"', '', $pinterest_pin_12);
				
				$p3_pinz = array($pinterest_pin_1, $pinterest_pin_2, $pinterest_pin_3, $pinterest_pin_4, $pinterest_pin_5, $pinterest_pin_6, $pinterest_pin_7, $pinterest_pin_8, $pinterest_pin_9, $pinterest_pin_10, $pinterest_pin_11, $pinterest_pin_12);
				
				set_transient('p3_pinz', $p3_pinz, 30 * MINUTE_IN_SECONDS);
				
			}
			*/
			?>
			<style scoped>
				#p3_pinterest_widget .p3_pin_wrap {
				width: <?php echo $width; ?>;
				}
			</style>
			<div id="p3_pinterest_widget"></div>
			<script>
			jQuery(document).ready(function($) {
				$.getJSON("https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20from%20html%20where%20url%3D%22https%3A%2F%2Fwww.pinterest.com%2F<?php echo $pinterestuser; ?>%2Ffeed.rss%22&format=json",
					function(data) {
						for (i = 0; i < <?php echo $images_num; ?>; i++) {
							var pinData = data.query.results.body.rss.channel.item[i].description;
							var pinImg = $(pinData).find('img').attr('src');
							var pinnyOutput = '<div class="p3_pin_wrap"><a href="http://pinterest.com/<?php echo $pinterestuser; ?>" target="_blank" rel="nofollow" class="p3_pin" style="background-image:url('+pinImg+');"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC" alt="" class="p3_invisible" data-pin-nopin="true"/></a></div>';
							$('#p3_pinterest_widget').append(pinnyOutput);
						}
					}
				);
			});
			</script>
			<?php
			if (isset($instance['follow'])) {
				if (!empty($pinterestuser) && $follow) { ?>
					<div class="clearfix"></div>
					<p><a href="http://pinterest.com/<?php echo $pinterestuser; ?>" target="_blank" rel="nofollow" style="color: #000;"><i class="fa fa-pinterest" style="font-size: 15px; margin-bottom: -1px"></i> <?php _e('Follow on Pinterest', 'p3'); ?></a></p>
				<?php }
			}

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
			$pinterestuser = $instance['pinterestuser'];
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
		
		delete_transient('p3_pinz');
		
		return $instance;
	  }
	  
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_pinterest");') );
}