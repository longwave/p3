<?php

if (!defined('ABSPATH')) die;

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
		if (isset($instance['category_exclude'])) { 
			$category_exclude = $instance['category_exclude'];
		} else {
			$category_exclude = 0;
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 3;
		}
		if (isset($instance['image_shape'])) { 
			$image_shape = $instance['image_shape'];
		} else {
			$image_shape = '';
		}
		
		$style_select = ( isset( $instance['style_select'] ) && is_numeric( $instance['style_select'] ) ) ? (int) $instance['style_select'] : 1;
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" type="text" 
			value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<legend><h3><?php _e('Select a layout:', 'p3'); ?></h3></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="1" <?php checked( $style_select == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-1' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/pop_1.png" style="position:relative;top:5px;border:1px solid #ddd; width: 100px;" /></label>
			<br /><br />
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="2" <?php checked( $style_select == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-2' ) ?>"><img src="https://pipdigz.co.uk/p3/img/widgets/pop_2.png" style="position:relative;top:5px;border:1px solid #ddd; width: 100px;" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Include', 'p3'); ?>:</label>
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('category'), 'selected' => $category, 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __('All Categories'), 'hide_empty' => '0')); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category_exclude'); ?>"><?php _e('Exclude', 'p3'); ?>:</label>
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('category_exclude'), 'selected' => $category_exclude, 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __('None'), 'hide_empty' => '0')); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('date_range_posts'); ?>"><?php _e('Date range for posts:', 'p3'); ?></label>
			<select id="<?php echo $this->get_field_id( 'date_range_posts' ); ?>" name="<?php echo $this->get_field_name( 'date_range_posts' ); ?>">
				<option <?php if ( '1 week ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 week ago"><?php _e('1 Week', 'p3') ?></option>
				<option <?php if ( '1 month ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 month ago"><?php _e('1 Month', 'p3') ?></option>
				<option <?php if ( '3 months ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="3 months ago"><?php _e('3 Months', 'p3') ?></option>
				<option <?php if ( '6 months ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="6 months ago"><?php _e('6 Months', 'p3') ?></option>
				<option <?php if ( '1 year ago' == $date_range_posts ) echo 'selected="selected"'; ?> value="1 year ago"><?php _e('1 Year', 'p3') ?></option>
				<option <?php if ( '' == $date_range_posts ) echo 'selected="selected"'; ?> value=""><?php _e('All Time', 'p3') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts to show:', 'p3'); ?></label>
			<input type="number" min="1" max="6" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" value="<?php echo $number_posts; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image_shape'); ?>"><?php _e('Image shape:', 'p3'); ?></label>
			<select id="<?php echo $this->get_field_id( 'image_shape' ); ?>" name="<?php echo $this->get_field_name( 'image_shape' ); ?>">
				<option <?php if ( '' == $image_shape ) echo 'selected="selected"'; ?> value=""><?php _e('Landscape', 'p3') ?></option>
				<option <?php if ( '2' == $image_shape ) echo 'selected="selected"'; ?> value="2"><?php _e('Portrait', 'p3') ?></option>
				<option <?php if ( '3' == $image_shape ) echo 'selected="selected"'; ?> value="3"><?php _e('Square', 'p3') ?></option>
				<option <?php if ( '4' == $image_shape ) echo 'selected="selected"'; ?> value="4"><?php _e('Original size', 'p3') ?></option>
			</select>
		</p>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php checked(isset($instance['show_date'])) ?> />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show post date', 'p3'); ?></label>
		</p>
	<?php
	  }
	 
	  function update($new_instance, $old_instance) {
		delete_transient('pipdig_popular_posts_widget'); // delete transient on widget save
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = absint($new_instance['category']);
		$instance['category_exclude'] = absint($new_instance['category_exclude']);
		$instance['date_range_posts'] =  strip_tags($new_instance['date_range_posts']);
		$instance['number_posts'] = absint($new_instance['number_posts']);
		$instance['image_shape'] = absint($new_instance['image_shape']);
		$instance['show_date'] = $new_instance['show_date'];
		$instance['style_select'] = ( isset( $new_instance['style_select'] ) && $new_instance['style_select'] > 0 && $new_instance['style_select'] < 3 ) ? (int) $new_instance['style_select'] : 0; // 3 is total radio +1
		return $instance;
	  }
	 
	  function widget($args, $instance) {
		extract($args, EXTR_SKIP);
	 
		echo $before_widget;
		if (isset($instance['title'])) { 
			$title = strip_tags($instance['title']);
		}
		if (isset($instance['number_posts'])) { 
			$number_posts = absint($instance['number_posts']);
		} else {
			$number_posts = 3;
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
		if (isset($instance['category_exclude'])) {
			if (isset($instance['category'])) { 
				$category .= ',';
			}
			$category .= '-'.absint($instance['category_exclude']);
		}
		if (isset($instance['image_shape'])) { 
			$image_shape = strip_tags($instance['image_shape']);
		} else {
			$image_shape = '';
		}
		if (isset($instance['show_date'])) { 
			$show_date = strip_tags($instance['show_date']);
		} else {
			$show_date = '';
		}
		if (isset($instance['style_select'])) { 
			$style_select = $instance['style_select'];
		} else {
			$style_select = 1;
		}
		if (!empty($title))
		  echo $before_title . $title . $after_title;;
	 
	query_posts('');
	?>

	<ul class="p3_popular_posts_widget" class="nopin">
	
	<?php
	
		$traditional = true;
		$jp_top_posts = '';
		$trans_prefix = 'all';
		if (function_exists('stats_get_csv') && !$category) {
			
			if ($date_range == '1 week ago') {
				$days = '7';
				$trans_prefix = $days;
			} elseif ($date_range == '1 month ago') {
				$days = '30';
				$trans_prefix = $days;
			} elseif ($date_range == '3 months ago') {
				$days = '90';
				$trans_prefix = $days;
			} elseif ($date_range == '6 months ago') {
				$days = '180';
				$trans_prefix = $days;
			} elseif ($date_range == '1 year ago') {
				$days = '365';
				$trans_prefix = $days;
			} else {
				$days = '-1';
			}
			
			if ( false === ( $post_view_ids = get_transient( 'p3_jp_pop_days_'.$trans_prefix ) )) {
				$jp_top_posts = stats_get_csv( 'postviews', array( 'days' => $days, 'limit' => 500 ) );
				$post_view_ids = wp_list_pluck($jp_top_posts, 'post_id');
				set_transient( 'p3_jp_pop_days_'.$trans_prefix, $post_view_ids, 30 * MINUTE_IN_SECONDS );
			}
			
			if (is_array($post_view_ids) && count($post_view_ids) > 4) {
				
				$args = array(
					'ignore_sticky_posts' => true,
					'showposts' => $number_posts,
					'post__in' => $post_view_ids
				);
				
				$traditional = false;
				
			}
			
		}
		
		if ($traditional) {
			$args = array(
				'cat' => $category,
				'showposts' => $number_posts,
				'ignore_sticky_posts' => true,
				'orderby' => 'comment_count',
				'order' => 'dsc',
				'date_query' => array(
					array(
						'after' => $date_range_posts,
					),
				),
			);
		}
		
		$popular = new WP_Query($args);
	
		$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAFoAQMAAAD9/NgSAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADJJREFUeNrtwQENAAAAwiD7p3Z7DmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5HHoAAHnxtRqAAAAAElFTkSuQmCC'; // landscape
		
		if ($image_shape == 2) {
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAAHgAQMAAACyyGUjAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACxJREFUeNrtwTEBAAAAwiD7p7bGDmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAkHVZAAAFam5MDAAAAAElFTkSuQmCC'; // portrait
		} elseif ($image_shape == 3) {
			$shape = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADVJREFUeNrtwTEBAAAAwiD7p/ZZDGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOX0AAAEidG8rAAAAAElFTkSuQmCC'; // square
		}
		
		// medium for sidebar, large for everywhere else
		$img_size = 'medium';
		if (isset($args['id']) && $args['id'] != 'sidebar-1') {
			$img_size = 'large';
		}
		
		$lazy = false;
		$lazy_class = '';
		if (is_pipdig_lazy()) {
			$lazy = true;
			$lazy_class = 'pipdig_lazy';
		}
		
	?>
	<?php while ( $popular->have_posts() ): $popular->the_post();
		
		$img = p3_catch_image(get_the_ID(), $img_size);
		$image_src = 'style="background-image:url('.$img.');"';
		if ($lazy) {
			$image_src = 'data-src="'.$img.'"';
		}
		
		$title = get_the_title();
		
		if ($style_select === 1) { ?>
			<li>
				<a href="<?php the_permalink() ?>">
					<?php if ($image_shape == 4) { ?>
						<img src="<?php echo $img; ?>" alt="<?php echo esc_attr($title); ?>" />
					<?php } else { ?>
						<div class="p3_cover_me <?php echo $lazy_class; ?>" <?php echo $image_src; ?>>
							<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title); ?>" class="p3_invisible" />
						</div>
					<?php } ?>
					<h4 class="p_post_titles_font"><?php if (!empty($instance['show_date'])) { echo get_the_date().': '; } ?><?php echo pipdig_p3_truncate($title, 11); ?></h4>
				</a>
			</li>
		<?php } else { ?>
			<li class="p3_pop_left clearfix">
				<div class="p3_pop_left-left">
				<a href="<?php the_permalink() ?>">
					<?php if ($image_shape == 4) { ?>
						<img src="<?php echo $img; ?>" alt="<?php echo esc_attr($title); ?>" />
					<?php } else { ?>
						<div class="p3_cover_me <?php echo $lazy_class; ?>" <?php echo $image_src; ?>>
							<img src="<?php echo $shape; ?>" alt="<?php echo esc_attr($title); ?>" class="p3_invisible" />
						</div>
					<?php } ?>
				</a>
				</div>
				<div class="p3_pop_left-right">
					<h4 class="p_post_titles_font"><?php echo pipdig_p3_truncate($title, 10); ?></h4>
					<?php if ($show_date) { ?><div class="p3_pop_left_date"><?php the_date(); ?></div><?php } ?>
				</div>
			</li>
		<?php } ?>

	<?php endwhile; wp_reset_query(); ?>
	</ul>
	 
	<?php
	  echo $after_widget;
	  }
	 
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_popular_posts");') );
}