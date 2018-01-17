<?php 

if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_widget_depop' ) ) {
	class pipdig_widget_depop extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_depop', 'description' => __('Display your Depop shop items.', 'p3') );
		  parent::__construct('pipdig_widget_depop', 'pipdig - ' . __('Depop Items', 'p3'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		$depop_handle = '';
		if (isset($instance['depop_handle'])) { 
			$depop_handle = esc_attr($instance['depop_handle']);
		}

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		// PART 2: The title and the text output
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		if (!empty($depop_handle)) { ?>
			<div class="depop-widget" data-username="<?php echo $depop_handle; ?>" data-width="300"></div>
			<script>
			// source: http://assets0.depop.com/widget.js but no https support yet, so copied.
			!function(a){function b(){var a=document.getElementsByClassName("depop-widget");if(a){for(var b,c=[],d=0;b=a[d];d++)c.push({el:b,username:b.attributes["data-username"]&&b.attributes["data-username"].value,width:b.attributes["data-width"]&&b.attributes["data-width"].value||f,height:b.attributes["data-height"]&&b.attributes["data-height"].value||f});return c}}function c(a){var b=document.createElement("iframe");b.src="http://depop.com/"+a.username+"/widget",b.width=a.width,b.height=a.height,b.border=0,b.frameBorder="0",b.scrolling="no",b.style.overflow="hidden",a.el.appendChild(b)}function d(){a.removeEventListener("DOMContentLoaded",d);var e=b();if(e.length)for(var f,g=0;f=e[g];g++)c(f)}if(!document.getElementsByClassName){var e=[].indexOf||function(a){for(var b=0;b<this.length;b++)if(this[b]===a)return b;return-1};getElementsByClassName=function(a,b){var c=document.querySelectorAll?b.querySelectorAll("."+a):function(){for(var c=b.getElementsByTagName("*"),d=[],f=0;f<c.length;f++)c[f].className&&(" "+c[f].className+" ").indexOf(" "+a+" ")>-1&&-1===e.call(d,c[f])&&d.push(c[f]);return d}();return c},document.getElementsByClassName=function(a){return getElementsByClassName(a,document)},Element.prototype.getElementsByClassName=function(a){return getElementsByClassName(a,this)}}var f=300;a.addEventListener("DOMContentLoaded",d)}(this);
			</script>
		<?php } else {
			echo 'Depop widget in section "'.$args['name'].'": '.__('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		// PART 1: Extract the data from the instance variable
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		if (isset($instance['depop_handle'])) { 
			$depop_handle = $instance['depop_handle'];
		} else {
			$links = get_option('pipdig_links');
			$depop_url = esc_url($links['depop']);
			if (!empty($depop_url)) {
				$depop_handle = parse_url($depop_url, PHP_URL_PATH);
				$depop_handle = str_replace('/', '', $depop_handle);
			} else {
				$depop_handle = '';
			}
		}

		// PART 2-3: Display the fields
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('depop_handle'); ?>"><?php _e('Depop Username:', 'p3'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('depop_handle'); ?>" name="<?php echo $this->get_field_name('depop_handle'); ?>" type="text" value="<?php echo esc_attr($depop_handle); ?>" placeholder="e.g. pipdig" />
		</p>
		
		<?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['depop_handle'] = esc_attr($new_instance['depop_handle']);
		return $instance;
	  }

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_depop");') );
}