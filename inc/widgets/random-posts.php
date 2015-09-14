<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if ( !class_exists( 'pipdig_widget_random_posts' ) ) {
	class pipdig_widget_random_posts extends WP_Widget {
		
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_widget_random_posts', 'description' => __('Displays a selection of random posts.', 'p3') );
		  parent::__construct('pipdig_widget_random_posts', 'pipdig - ' . __('Random Posts', 'p3'), $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		if (isset($instance['title'])) { 
			$title = $instance['title'];
		}
		if (isset($instance['date_range_posts'])) { 
			$date_range_posts = $instance['date_range_posts'];
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
			<label for="<?php echo $this->get_field_id('date_range_posts'); ?>"><?php _e('Date range for posts:', 'p3'); ?></label>
			<select id="<?php echo $this->get_field_id( 'date_range_posts' ); ?>" name="<?php echo $this->get_field_name( 'date_range_posts' ); ?>">
				<option <?php if (isset($instance['date_range_posts'])) { if ( '1 week ago' == $date_range_posts ) echo 'selected="selected"'; } ?> value="1 week ago"><?php _e('1 Week', 'p3') ?></option>
				<option <?php if (isset($instance['date_range_posts'])) { if ( '1 month ago' == $date_range_posts ) echo 'selected="selected"'; } ?> value="1 month ago"><?php _e('1 Month', 'p3') ?></option>
				<option <?php if (isset($instance['date_range_posts'])) { if ( '1 year ago' == $date_range_posts ) echo 'selected="selected"'; } ?> value="1 year ago"><?php _e('1 Year', 'p3') ?></option>
				<option <?php if (isset($instance['date_range_posts'])) { if ( '' == $date_range_posts ) echo 'selected="selected"'; } ?> value=""><?php _e('All Time', 'p3') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts to show:', 'p3'); ?></label>
			<input type="number" min="1" max="6" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" value="<?php if ($number_posts) { echo $number_posts; } else { echo '3'; } ?>" />
		</p>
		<p><em><?php _e('Posts will be refreshed every 30 minutes', 'p3'); ?></em></p>
	<?php
	  }
	 
	  function update($new_instance, $old_instance) {
		delete_transient('pipdig_random_posts_widget'); // delete transient on widget save
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['date_range_posts'] =  $new_instance['date_range_posts'];
		$instance['number_posts'] = absint( $new_instance['number_posts'] );
		return $instance;
	  }
	 
	  function widget($args, $instance)
	  {
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		if (isset($instance['title'])) { 
			$title = $instance['title'];
		}
	 
		if (!empty($title))
		  echo $before_title . $title . $after_title;;
	 
		// WIDGET CODE GOES HERE

	query_posts('');
	?>
	<ul id="pipdig-widget-random-posts" class="nopin">
	<style scoped>
		#pipdig-widget-random-posts {
		padding: 0;
		margin: 0;
		list-style: none;
		}
		#pipdig-widget-random-posts li {
		position: relative;
		margin-bottom: 15px;
		}
		#pipdig-widget-random-posts h4 {
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
		#pipdig-widget-random-posts a {
		transition: all 0.3s ease-out; -moz-transition: all 0.3s ease-out; -webkit-transition: all 0.3s ease-out;
		}
		#pipdig-widget-random-posts a:hover {
		opacity: .75;
		}
	</style>
	<?php
	if ( false === ( $popular = get_transient( 'pipdig_random_posts_widget' ) ) ) { // check for transient value
		if (isset($instance['number_posts'])) { 
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 3;
		}
		if (isset($instance['date_range_posts'])) {
			$date_range_posts = $instance['date_range_posts'];
		} else {
			$date_range_posts = '1 month ago';
		}
		$popular = new WP_Query( array(
			'post_type'             => array( 'post' ),
			'showposts'             => $number_posts,
			'ignore_sticky_posts'   => 1,
			'orderby'               => 'rand',
			'date_query' => array(
				array(
					'after' => $date_range_posts,
				),
			),
		) );
		set_transient( 'pipdig_random_posts_widget', $popular, 30 * MINUTE_IN_SECONDS ); // set transient value
	} ?>
	<?php while ( $popular->have_posts() ): $popular->the_post();
		if(has_post_thumbnail()){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pipdig_p3_800x500' );
			$bg = $thumb['0'];
		} else { // what? No featured image?  Let's use the first from post
			$bg = pipdig_p3_catch_that_image();
		}
	?>
	<li>
	<a href="<?php the_permalink() ?>">
	<img src="<?php echo $bg; ?>" alt="" />
	<h4><?php $title = get_the_title(); echo pipdig_truncate($title, 11); ?></h4>
	</a>
	</li>
	<?php endwhile; wp_reset_query(); ?>
	</ul>
	 
	<?php
	  echo $after_widget;
	  }
	 
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_random_posts");') );
}