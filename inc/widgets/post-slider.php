<?php

if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_widget_post_slider' ) ) {
	class pipdig_widget_post_slider extends WP_Widget {
		
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_post_slider', 'description' => __('Display your recent posts in a slider.', 'p3') );
		  parent::__construct('pipdig_widget_post_slider', 'pipdig - ' . __('Post Slider', 'p3'), $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		if (isset($instance['title'])) { 
			$title = strip_tags($instance['title']);
		}
		if (isset($instance['date_range_posts'])) { 
			$date_range_posts = strip_tags($instance['date_range_posts']);
		} else {
			$date_range_posts = '';
		}
		if (isset($instance['category'])) { 
			$category = absint($instance['category']);
		} else {
			$category = '';
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = absint($instance['number_posts']);
		} else {
			$number_posts = 4;
		}
		if (isset($instance['height'])) { 
			$height = absint($instance['height']);
		} else {
			$height = 360;
		}
		if (isset($instance['title_length'])) { 
			$title_length = absint($instance['title_length']);
		} else {
			$title_length = 4;
		}
		if (isset($instance['post_title_layout'])) { 
			$post_title_layout = strip_tags($instance['post_title_layout']);
		} else {
			$post_title_layout = 'yes';
		}
		
	?>
		<p>
			NOTE: This widget is designed to be used in the sidebar. If you would like to display a slider under the header or in any other location, please use the options in the <a href="<?php echo admin_url( 'customize.php' ); ?>">Customizer</a>.
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category'); ?>:</label><br />
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('category'), 'selected' => $category, 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __('All Categories'), 'hide_empty' => '0')); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('date_range_posts'); ?>"><?php _e('Date range for posts:', 'p3'); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'date_range_posts' ); ?>" name="<?php echo $this->get_field_name( 'date_range_posts' ); ?>">
				<option <?php if ('1 week ago' == $date_range_posts) echo 'selected="selected"'; ?> value="1 week ago"><?php _e('1 Week', 'p3') ?></option>
				<option <?php if ('1 month ago' == $date_range_posts) echo 'selected="selected"'; ?> value="1 month ago"><?php _e('1 Month', 'p3') ?></option>
				<option <?php if ('1 year ago' == $date_range_posts) echo 'selected="selected"'; ?> value="1 year ago"><?php _e('1 Year', 'p3') ?></option>
				<option <?php if ('' == $date_range_posts) echo 'selected="selected"'; ?> value=""><?php _e('All Time', 'p3') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts to show:', 'p3'); ?></label><br />
			<input type="number" min="2" max="6" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" value="<?php echo $number_posts; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Slider height in pixels:', 'p3'); ?></label><br />
			<input type="number" min="20" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $height; ?>" />
		</p>
		<p style="font-style:italic;"><?php _e('The width of the slider will always be 100%.', 'p3'); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id('post_title_layout'); ?>"><?php _e('Display post titles?', 'p3'); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'post_title_layout' ); ?>" name="<?php echo $this->get_field_name( 'post_title_layout' ); ?>">
				<option <?php if ('yes' == $post_title_layout) echo 'selected="selected"'; ?> value="yes"><?php _e('Yes', 'p3') ?></option>
				<option <?php if ('no' == $post_title_layout) echo 'selected="selected"'; ?> value="no"><?php _e('No', 'p3') ?></option>
				<option <?php if ('hover' == $post_title_layout) echo 'selected="selected"'; ?> value="hover"><?php _e('On hover', 'p3') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_length'); ?>">Post title length limit (words)</label><br />
			<input type="number" min="0" id="<?php echo $this->get_field_id( 'title_length' ); ?>" name="<?php echo $this->get_field_name( 'title_length' ); ?>" value="<?php echo $title_length; ?>" />
		</p>
	<?php
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = absint($new_instance['category']);
		$instance['date_range_posts'] =  strip_tags($new_instance['date_range_posts']);
		$instance['number_posts'] = absint($new_instance['number_posts']);
		$instance['height'] = absint($new_instance['height']);
		$instance['title_length'] = absint($new_instance['title_length']);
		$instance['post_title_layout'] =  strip_tags($new_instance['post_title_layout']);
		return $instance;
	  }
	 
	function widget($args, $instance) {
		  
		wp_enqueue_script('pipdig-cycle');
		  
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		if (isset($instance['title'])) { 
			$title = strip_tags($instance['title']);
		}
		if (isset($instance['date_range_posts'])) { 
			$date_range_posts = strip_tags($instance['date_range_posts']);
		} else {
			$date_range_posts = '';
		}
		if (isset($instance['category'])) { 
			$category = absint($instance['category']);
		} else {
			$category = '';
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = absint($instance['number_posts']);
		} else {
			$number_posts = 4;
		}
		if (isset($instance['height'])) { 
			$height = absint($instance['height']);
		} else {
			$height = 360;
		}
		if (isset($instance['title_length'])) { 
			$title_length = absint($instance['title_length']);
		} else {
			$title_length = 4;
		}
		if (isset($instance['post_title_layout'])) { 
			$post_title_layout = strip_tags($instance['post_title_layout']);
		} else {
			$post_title_layout = 'yes';
		}
		if (!empty($title))
		  echo $before_title . $title . $after_title;;
	 
	query_posts('');
	?>

	

<style scoped>
.pipdig_widget_post_slider .slide-desc{bottom:<?php echo $height / 2.5; ?>px;}
<?php if ($post_title_layout == 'hover') { ?>
.pipdig_widget_post_slider .slide-inside{opacity:0}
.pipdig_widget_post_slider .slide-inside:hover{opacity:1}
<?php } ?>
</style>
<div data-cycle-speed="1000" data-cycle-slides="li" data-cycle-manual-speed="600" class="cycle-slideshow nopin">
<ul>
<?php 
	$args = array(
		'showposts' => $number_posts,
		'cat' => $category,
		'ignore_sticky_posts' => 1,
		//'orderby' => 'rand',
		'date_query' => array(
			array(
				'after' => $date_range_posts,
			),
		),
	);
	$the_query = new WP_Query( $args );
	
	// medium for sidebar, large for everywhere else
	$img_size = 'medium';
	if (isset($args['id']) && ($args['id'] != 'sidebar-1')) {
		$img_size = 'large';
	}
		
	while ($the_query -> have_posts()) : $the_query -> the_post();

		$bg = p3_catch_image(get_the_ID(), $img_size);
?>
	<li>
	<div class="slide-image" style="background-image:url(<?php echo $bg; ?>);">
		<div class="slide-inside">
			<?php if ($post_title_layout != 'no') { ?>
				<span class="slide-desc">
					<h2 class="p_post_titles_font"><?php echo pipdig_p3_truncate(get_the_title(), $title_length); ?></h2>
					<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('View Post', 'p3'); ?></a>
				</span>
			<?php } ?>
			<a href="<?php the_permalink() ?>" style="display: block; width: 100%; height: <?php echo $height; ?>px;">
					
			</a>
		</div>
	</div>
	</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
<div class='cycle-pager'></div>
</div>

	<?php
	  echo $after_widget;
	  }
	 
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_post_slider");') );
}