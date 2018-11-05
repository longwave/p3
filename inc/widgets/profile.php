<?php
if (!defined('ABSPATH')) die;

/**
 * Image Upload Widget
 */
class pipdig_widget_profile_function extends WP_Widget {

	// Holds widget settings defaults, populated in constructor.
	protected $defaults;

	// Constructor. Set the default widget options and create widget.
	function __construct() {

		$this->defaults = array(
			'title' => '',
			'image_uri' => '',
			'description' => '',
			'circle' => '',
			'btn_link' => '',
		);

		$widget_ops = array(
			'classname' => 'pipdig_widget_profile',
			'description' => __('Show a profile photo and some "About Me" text.', 'p3'),
		);

		$control_ops = array(
			'id_base' => 'pipdig_widget_profile',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct('pipdig_widget_profile', 'pipdig - '.__('Profile Photo', 'p3'), $widget_ops, $control_ops);

	}

	// The widget content.
	function widget($args, $instance) {

		//* Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);

		echo $args['before_widget'];

			if (! empty($instance['title']))
				echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
			
			$circle = '';
			if (!empty($instance['circle'])) {
				$circle = 'style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"';
			}
			
			if (isset($instance['style_select'])) { 
				$style_select = $instance['style_select'];
			} else {
				$style_select = 1;
			}
			
			$horizontal = true;
			if ( isset($args['id']) && ($args['id'] == 'sidebar-1' || $args['id'] == 'sidebar-2' || $args['id'] == 'sidebar-3' || $args['id'] == 'sidebar-4' || $args['id'] == 'sidebar-5') ) {
				$horizontal = false;
			}
			
			if ($style_select === 1) {
				$horizontal = false;
			} elseif ($style_select === 2) {
				$horizontal = true;
			}
			
			$btn_link = '';
			if (!empty($instance['btn_link'])) {
				$btn_link = $instance['btn_link'];
			}
			
			$img = $image_src = '';
			if (!empty($instance['image_uri'])) {
				$image_src = $instance['image_uri'];
				$image_data = pipdig_get_attachment_id($instance['image_uri']); // use the medium thumbnail if we can find it
				if ($image_data) {
					$image_src = wp_get_attachment_image_src($image_data, 'p3_medium');
					$image_src = reset($image_src); // php <5.4 way to get [0] value of array
					$image_src = str_replace('http:', '', $image_src);
				}
				
				//if (is_pipdig_lazy()) {
					//$img = '<div class="nopin"><img data-src="'.esc_url($image_src).'" alt="" class="pipdig_lazy" '.$circle.' data-pin-nopin="true" /></div>';
				//} else {
					$img = '<img src="'.esc_url($image_src).'" alt="" '.$circle.' data-pin-nopin="true" class="nopin" />';
				//}
				
				
			}
			
			$desc = '';
			if (!empty($instance['description'])) {
				$desc = wpautop(do_shortcode($instance['description']));
			}
			
			if ($horizontal && $desc) {
				echo '<img src="'.esc_url($image_src).'" alt="" '.$circle.' data-pin-nopin="true" class="nopin profile_col_50" />'.$desc;
				echo '<div class="clearfix"></div>';
			} else {
				if ($image_src) {
					if ($btn_link) {
						echo '<a href="'.esc_url($btn_link).'"><img src="'.esc_url($image_src).'" alt="" '.$circle.' data-pin-nopin="true" class="nopin" /></a>';
					} else {
						echo '<img src="'.esc_url($image_src).'" alt="" '.$circle.' data-pin-nopin="true" class="nopin" />';
					}
				}
				if ($desc) {
					echo $desc;
				}
			}
			
			if ($btn_link) {
				echo '<a href="'.esc_url($btn_link).'" class="more-link">'.__('Read More', 'p3').'</a>';
			}
			

		echo $args['after_widget'];

	}

	// Update a particular instance.
	function update($new_instance, $old_instance) {

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$new_instance['description'] = wp_kses_post($new_instance['description']);
		$new_instance['circle'] = strip_tags($new_instance['circle']);
		$new_instance['btn_link'] = strip_tags($new_instance['btn_link']);
		$new_instance['style_select'] = absint($new_instance['style_select']);

		return $new_instance;

	}

	// The settings update form.
	function form($instance) {

		// Merge with defaults
		$instance = wp_parse_args((array) $instance, $this->defaults);
		
		$style_select = ( isset( $instance['style_select'] ) && is_numeric( $instance['style_select'] ) ) ? (int) $instance['style_select'] : 1;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>

		<p>
			<div class="pipdig-media-container">
				<div class="pipdig-media-inner">
					<?php $img_style = ($instance[ 'image_uri' ] != '') ? '' : 'display:none;'; ?>
					<?php
					$circle = '';
					if (!empty($instance['circle'])) {
						$circle = '-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;';
					}
					?>
					<img id="<?php echo $this->get_field_id('image_uri'); ?>-preview" src="<?php echo esc_attr($instance['image_uri']); ?>" style="max-width: 100%; height: auto;<?php echo $circle.$img_style; ?>" />
					<?php $no_img_style = ($instance[ 'image_uri' ] != '') ? 'style="display:none;"' : ''; ?>
				</div>
			
				<input type="text" id="<?php echo $this->get_field_id('image_uri'); ?>" name="<?php echo $this->get_field_name('image_uri'); ?>" value="<?php echo esc_attr($instance['image_uri']); ?>" class="pipdig-media-url" style="display: none" />

				<input type="button" value="<?php echo esc_attr(__('Remove', 'p3')); ?>" class="button pipdig-media-remove" id="<?php echo $this->get_field_id('image_uri'); ?>-remove" style="<?php echo $img_style; ?>" />

				<input type="button" value="<?php echo esc_attr(__('Select Image', 'p3')); ?>" class="button pipdig-media-upload" id="<?php echo $this->get_field_id('image_uri'); ?>-button" />
				<br class="clear">
			</div>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('circle'); ?>">
			<input type="checkbox" id="<?php echo $this->get_field_id('circle'); ?>" name="<?php echo $this->get_field_name('circle'); ?>" <?php if (isset($instance['circle'])) { checked((bool) $instance['circle'], true); } ?> /><?php _e('Change image to a circle', 'p3'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><strong>Description text:</strong></label>
			<textarea id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" class="widefat" rows="5"><?php if (isset($instance['description'])) echo wp_kses_post($instance['description']); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('btn_link'); ?>">"Read More" link <a href="https://i.imgur.com/mHoNA3b.png" target="_blank" rel="noopener" style="text-decoration: none"><span class="dashicons dashicons-editor-help"></span></a></label>
			<input type="text" id="<?php echo $this->get_field_id('btn_link'); ?>" name="<?php echo $this->get_field_name('btn_link'); ?>" value="<?php if (isset($instance['btn_link'])) echo esc_attr($instance['btn_link']); ?>" placeholder="e.g. <?php echo esc_url( home_url( '/' ) ); ?>about/" class="widefat" />
		</p>
		
		<p style="margin-top: 25px">
			<legend><h3><?php _e('Select a layout:', 'p3'); ?></h3></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="1" <?php checked( $style_select == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-1' ) ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAL4AAAB4CAMAAAB7G7gGAAAAOVBMVEX////8/Pxzc3MAAAB2dnYoKCj5+fm+vr4bGxvn5+fJyckHBwdDQ0NsbGzk5OQwMDDv7+/S0tJQUFAd4x20AAABYElEQVR42u2c227CMBAFz5LeaLi0/f+PbWTxgiAoKFnbR8z4HU9GSGwiYpkTi1ZDuvWivjvUTyCn/u97Hc77lPrfQyX2CfWL/viVzjiMafWPH+kchjGt/lHpHDLrKx3qU5/61Kc+9e+DvoQ++uijjz766E+gjz766KOPPvrXoI8++uijjz76E+ijjz766KO/Tn+nG5z0/z7TOS/W7/SveOb6w0kZnN4q8SMAAIC17GpRdkO/lX5I8tUPKZz1IyRz/dDmRD0koX8lX9G/fHd860sFzytQSvy5T/XZJtYtgzds4YLpr27ZDf1m+t4jmyaM9f0HZu+Zh4H5hnjgbzG0xSwG9WduWCzUKw7Mocg6ISbyFyfEdHOV23n1N04uqr+tvn39cK4f3vXLOGlcP6JB/UJvY8Gi+tvrN6kfUmePj9vUb3gqXld3Ik/WV2yyZ7v6fT0+fqWJsz+o/xQvl/+R1j+NrzLf0a+5tgAAAABJRU5ErkJggg==" style="position:relative;top:5px;border:1px solid #ddd; width: 100px;" /></label>
			<br /><br />
			<input type="radio" id="<?php echo ($this->get_field_id( 'style_select' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'style_select' )) ?>" value="2" <?php checked( $style_select == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'style_select' ) . '-2' ) ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAL4AAABOCAMAAACpOFy2AAAAOVBMVEX///9zc3P8/PwAAAB2dnbn5+fJyckoKCgHBwf5+fm+vr5DQ0MbGxtsbGzk5OQwMDDv7+/S0tJQUFBQQHllAAAA+klEQVRo3u3YSw7CMAyE4emUR3m1wP0Py7KITZTIOHY0Hxf45Q3TQERERNy9zm22IyI4zY3C5C/3asu8hMl/XKrdIuWj2nf+5EX5ffOZOZ+5r0/mvj4JmucD9APl/+QT9ALQML98/gTXBwE6wM74+vBA0DZ/R4ef3fUHWpxV4uVPPgZYnLnzmTqfADPn5x/MoBbnSPn06s//tfW3yeYBYOLBbPu35b2XqcU5Xv5kQvl985k5n7mvT+a+PgmiKPLihPL7vTADRFncF2aUhX1h7rl5aDGHvfNNJ7MWp/ILlD9Y/pQ7/32ttgXKb5E9f14RwXpo9ISIiIhIcB/bSihH+6MKLwAAAABJRU5ErkJggg==" style="position:relative;top:5px;border:1px solid #ddd; width: 100px;" /></label>
			<br /><br />
		</p>
		
		<?php

	}

}