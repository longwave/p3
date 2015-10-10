<?php

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_post_slider' ) ) {
	class pipdig_widget_post_slider extends WP_Widget {
		
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_post_slider', 'description' => __('Display a selection of posts in a slider.', 'p3') );
		  parent::__construct('pipdig_widget_post_slider', 'pipdig - ' . __('Post Slider', 'p3'), $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		if (isset($instance['title'])) { 
			$title = $instance['title'];
		}
		if (isset($instance['date_range_posts'])) { 
			$date_range_posts = $instance['date_range_posts'];
		} else {
			$date_range_posts = '';
		}
		if (isset($instance['category'])) { 
			$category = $instance['category'];
		} else {
			$category = 0;
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 4;
		}
		if (isset($instance['height'])) { 
			$height = $instance['height'];
		} else {
			$height = 360;
		}
		if (isset($instance['post_title_layout'])) { 
			$post_title_layout = $instance['post_title_layout'];
		} else {
			$post_title_layout = 'yes';
		}
		
	?>
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
	<?php
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = absint($new_instance['category']);
		$instance['date_range_posts'] =  strip_tags($new_instance['date_range_posts']);
		$instance['number_posts'] = absint($new_instance['number_posts']);
		$instance['height'] = absint($new_instance['height']);
		$instance['post_title_layout'] =  strip_tags($new_instance['post_title_layout']);
		return $instance;
	  }
	 
	  function widget($args, $instance)
	  {
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		if (isset($instance['title'])) { 
			$title = $instance['title'];
		}
		if (isset($instance['date_range_posts'])) { 
			$date_range_posts = $instance['date_range_posts'];
		} else {
			$date_range_posts = '';
		}
		if (isset($instance['category'])) { 
			$category = $instance['category'];
		} else {
			$category = '';
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 4;
		}
		if (isset($instance['height'])) { 
			$height = $instance['height'];
		} else {
			$height = 360;
		}
		if (isset($instance['post_title_layout'])) { 
			$post_title_layout = $instance['post_title_layout'];
		} else {
			$post_title_layout = 'yes';
		}
		if (!empty($title))
		  echo $before_title . $title . $after_title;;
	 
	query_posts('');
	?>


<style scoped="scoped">
.pipdig_widget_post_slider .cycle-slideshow li{display:none}
.pipdig_widget_post_slider .cycle-slideshow li.first{display:block}
.pipdig_widget_post_slider .slide-image{background-attachment:scroll;background-position:center center; background-size:cover;background-repeat: no-repeat;height:100%;width:100%;}
.pipdig_widget_post_slider .cycle-slideshow li {width: 100%;}
.pipdig_widget_post_slider .cycle-pager { 
    text-align: center; width: 100%; z-index: 500; position: absolute; bottom: -10%; overflow: hidden;
}
.pipdig_widget_post_slider .cycle-pager span { 
    font-family: arial, sans-serif; font-size: 41px; width: 15px; height: 15px; display: inline-block; color: #eee; cursor: pointer;margin: 0 3px; 
}
.pipdig_widget_post_slider .cycle-pager span.cycle-pager-active { color: #333;}
.pipdig_widget_post_slider .cycle-pager > * { cursor: pointer;}

.pipdig_widget_post_slider .slide-inside{height:100%;padding:0;width:100%;background:transparent;transition:all .25s ease-out;-o-transition:all .25s ease-out;-moz-transition:all .25s ease-out;-webkit-transition:all .25s ease-out}
.pipdig_widget_post_slider .slide-inside:hover{background:rgba(255,255,255,.3)}
.pipdig_widget_post_slider .slide-desc{bottom:<?php echo $height / 2.5; ?>px;left:10%;width:80%;padding: 15px 0;}
.pipdig_widget_post_slider .read-more {
    padding: 7px 12px;
    position: relative;
}
.pipdig_widget_post_slider .slide-desc h2 {
	margin-bottom: 8px;
}
<?php if ($post_title_layout == 'hover') { ?>
.slide-inside{opacity:0}
.slide-inside:hover{opacity:1}
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
		
	while ($the_query -> have_posts()) : $the_query -> the_post();

		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
			$bg = $thumb['0'];
		} else {
			$bg = pipdig_p3_catch_that_image();
		}
?>
	<li>
	<div class="slide-image" style="background-image:url(<?php echo $bg; ?>);">
		<div class="slide-inside">
				<span class="slide-desc">
					<h2><?php $title = get_the_title(); echo pipdig_truncate($title, 4); ?></h2>
					<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('View Post', 'pipdig-aquae'); ?></a>
				</span>
				<a href="<?php the_permalink() ?>" style="display: block; width: 100%; height: <?php echo $height; ?>px;">
					
				</a>
		</div>
	</div>
	</li>
<?php endwhile;?>
</ul>
<div class='cycle-pager'></div>
</div>
	
	
	<?php
		wp_enqueue_script('cycle2');
 ?>
	

	<?php
	  echo $after_widget;
	  }
	 
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_post_slider");') );
}