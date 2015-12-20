<?php

if (!defined('ABSPATH')) {
	exit;
}

if ( !class_exists( 'pipdig_widget_popular_posts' ) ) {
	class pipdig_widget_popular_posts extends WP_Widget {
		
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_popular_posts', 'description' => __('Displays your most popular posts.', 'p3') );
		  parent::__construct('pipdig_widget_popular_posts', 'pipdig - ' . __('Popular Posts', 'p3'), $widget_ops);
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
			$number_posts = 3;
		}
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category'); ?>:</label>
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('category'), 'selected' => $category, 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __('All Categories'), 'hide_empty' => '0')); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('date_range_posts'); ?>"><?php _e('Date range for posts:', 'p3'); ?></label>
			<select id="<?php echo $this->get_field_id( 'date_range_posts' ); ?>" name="<?php echo $this->get_field_name( 'date_range_posts' ); ?>">
				<option <?php if ( '1 week ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 week ago"><?php _e('1 Week', 'p3') ?></option>
				<option <?php if ( '1 month ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 month ago"><?php _e('1 Month', 'p3') ?></option>
				<option <?php if ( '1 year ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 year ago"><?php _e('1 Year', 'p3') ?></option>
				<option <?php if ( '' == $date_range_posts ) echo 'selected="selected"'; ?> value=""><?php _e('All Time', 'p3') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts to show:', 'p3'); ?></label>
			<input type="number" min="1" max="6" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" value="<?php echo $number_posts; ?>" />
		</p>
	<?php
	  }
	 
	  function update($new_instance, $old_instance) {
		delete_transient('pipdig_popular_posts_widget'); // delete transient on widget save
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = absint($new_instance['category']);
		$instance['date_range_posts'] =  strip_tags($new_instance['date_range_posts']);
		$instance['number_posts'] = absint($new_instance['number_posts']);
		return $instance;
	  }
	 
	  function widget($args, $instance)
	  {
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		if (isset($instance['title'])) { 
			$title = $instance['title'];
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 3;
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
		if (!empty($title))
		  echo $before_title . $title . $after_title;;
	 
	query_posts('');
	?>
	<style scoped>
		#pipdig-widget-popular-posts {
		padding: 0;
		margin: 0;
		list-style: none;
		}
		#pipdig-widget-popular-posts li {
		position: relative;
		margin-bottom: 15px;
		}
		#pipdig-widget-popular-posts h4 {
		font-size: 14px;
		margin:0;
		letter-spacing: 1px;
		padding: 5px;
		position: absolute;
		bottom: 10%;
		right: 0;
		left: 0;
		width: 100%;
		background: #fff;
		background: rgba(255, 2555, 255, .9);
		}
		#pipdig-widget-popular-posts a {
		transition: all 0.3s ease-out; -moz-transition: all 0.3s ease-out; -webkit-transition: all 0.3s ease-out;
		}
		#pipdig-widget-popular-posts a:hover {
		opacity: .75;
		}
	</style>
	<ul id="pipdig-widget-popular-posts" class="nopin">
	
	<?php
	if ( false === ( $popular = get_transient('pipdig_popular_posts_widget') ) ) { // check for transient value
		$popular = new WP_Query( array(
			'showposts' => $number_posts,
			'ignore_sticky_posts' => 1,
			'cat' => $category,
			'orderby' => 'comment_count',
			'date_query' => array(
				array(
					'after' => $date_range_posts,
				),
			),
		) );
		set_transient('pipdig_popular_posts_widget', $popular, 10 * HOUR_IN_SECONDS); // set transient value
	} ?>
	<?php while ( $popular->have_posts() ): $popular->the_post();
		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
			$bg = esc_url($thumb['0']);
		} else {
			$bg = pipdig_p3_catch_that_image();
		}
		$title = esc_attr(get_the_title());
	?>
	<li>
	<a href="<?php the_permalink() ?>">
	<img src="<?php echo $bg; ?>" alt="<?php echo $title; ?>" />
	<h4><?php echo pipdig_p3_truncate($title, 11); ?></h4>
	</a>
	</li>
	<?php endwhile; wp_reset_query(); ?>
	</ul>
	 
	<?php
	  echo $after_widget;
	  }
	 
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_popular_posts");') );
}