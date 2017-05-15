<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('pipdig_clw_enqueue_scripts')) {
	function pipdig_clw_enqueue_scripts($hook) {
		wp_enqueue_script( 'ammap', 'https://cdnjs.cloudflare.com/ajax/libs/ammaps/3.13.0/ammap.js' );
		wp_enqueue_script( 'continentsLow', 'https://cdnjs.cloudflare.com/ajax/libs/ammaps/3.13.0/maps/js/continentsLow.js' );
	}
}


// the widget class
if (!class_exists('pipdig_widget_clw')) {
	class pipdig_widget_clw extends WP_Widget {
	 
		public function __construct() {
			$widget_ops = array('classname' => 'pipdig_widget_clw', 'description' => __('Proudly display where you are in the world.', 'p3') );
			parent::__construct('pipdig_widget_clw', 'pipdig - ' . __('Current Location (map)', 'p3'), $widget_ops);
				
			//enqueue JS on frontend only if widget is active on page:
			if(is_active_widget(false, false, $this->id_base)) {
				add_action('wp_enqueue_scripts', 'pipdig_clw_enqueue_scripts');
			}
		}
	  
		function widget($args, $instance) {
			// PART 1: Extracting the arguments + getting the values
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
			if (isset($instance['location'])) { 
				$location = esc_attr($instance['location']);
			} else {
				$location = 'None :(';
			}
			if (isset($instance['latitude'])) { 
				$latitude = esc_attr(trim($instance['latitude']));
			} else {
				$latitude = '';
			}
			if (isset($instance['longitude'])) { 
				$longitude = esc_attr(trim($instance['longitude']));
			} else {
				$longitude = '';
			}
			if (isset($instance['url'])) { 
				$url = 'url: "'.esc_url($instance['url']).'",';
			} else {
				$url = '';
			}

			// Before widget code, if any
			echo (isset($before_widget)?$before_widget:'');
		
			if (!empty($title)) {
				echo $before_title . $title . $after_title;
			}
			
			$map_id = 'map_id_'.rand(1, 999999999);
			
			if ($latitude && $longitude) {
				
					//if ( false === ( $map = get_transient( 'pipdig_clw_map' ) ) ) { // check for transient value
						$map_color = esc_attr(get_theme_mod( 'pipdig_clw_map_color', '#dddddd' ));
						$border_color = esc_attr(get_theme_mod( 'pipdig_clw_border_color', '#ffffff' ));
						$marker_color = esc_attr(get_theme_mod( 'pipdig_clw_marker_color', '#000000' ));
						$marker_size = absint(get_theme_mod( 'pipdig_clw_marker_size', 6 ));
						$map = '<script>
						var map;

						AmCharts.ready(function() {
							var map;
							var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

							map = new AmCharts.AmMap();
							map.handDrawn = false;
							map.fontFamily = "Georgia";
							map.fontSize = 12;
							map.useObjectColorForBalloon = false;
							map.dragMap = false;
							map.color = "#ffffff";

							map.areasSettings = {
								autoZoom: false,
								rollOverOutlineColor: "'.$border_color.'",
								selectedColor: "'.$map_color.'",
								rollOverColor: "'.$map_color.'",
								outlineAlpha: 1,
								outlineColor: "'.$border_color.'",
								outlineThickness: 2,
								color: "'.$map_color.'",
								balloonText: false,
							};
								
							map.dataProvider = {
								mapVar: AmCharts.maps.continentsLow,
									areas: [{
										"id": "africa", '.$url.'
									}, {
										"id": "asia", '.$url.'
									}, {
										"id": "australia", '.$url.'
									}, {
										"id": "europe", '.$url.'
									}, {
										"id": "north_america", '.$url.'
									}, {
										"id": "south_america", '.$url.'
									}],
									images: [
										{svgPath:targetSVG, color: "'.$marker_color.'", scale:.'.$marker_size.', title:"'.$location.'", latitude:'.$latitude.', longitude:'.$longitude.', '.$url.'},
									]

								};
								var zoomControl = map.zoomControl;
								zoomControl.panControlEnabled = false;
								zoomControl.zoomControlEnabled = false;
								zoomControl.mouseEnabled = false;

								map.write("'.$map_id.'");

							});
						</script>
						<div id="'.$map_id.'" style="max-width: 300px; width: 100%; height: 170px; margin: 0 auto;"></div>
						<p>'.$location.'</p>
						<style scoped>#'.$map_id.' a{display:none!important}</style>';
						//set_transient( 'pipdig_clw_map', $map, 24 * HOUR_IN_SECONDS ); // set transient
					//}
					echo $map; // print the map
					
			} else { // no latitude/longitude set, so let's display a friendly reminder:
				
				if (current_user_can('manage_options')) {
					echo '<a href="'.admin_url( 'widgets.php' ).'">'.__('Please enter location data in the widget settings.', 'p3').'</a>';
				} else {
					_e('Please enter location data in the widget settings.', 'p3');
				}
				
			}
			// After widget code, if any  
			echo (isset($after_widget)?$after_widget:'');
		}

		public function form( $instance ) {
		   
			// PART 1: Extract the data from the instance variable
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
			
			if (isset($instance['location'])) { 
				$location = esc_attr($instance['location']);
			} else {
				$location = '';
			}
			if (isset($instance['title'])) { 
				$title = esc_attr($instance['title']);
			}
			if (isset($instance['latitude'])) { 
				$latitude = esc_attr($instance['latitude']);
			} else {
				$latitude = '';
			}
			if (isset($instance['longitude'])) { 
				$longitude = esc_attr($instance['longitude']);
			} else {
				$longitude = '';
			}
			if (isset($instance['url'])) { 
				$url = esc_url($instance['url']);
			} else {
				$url = '';
			}
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'p3'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if ($title) { echo $title; } ?>" />
			</p>
			
			<p><?php
			printf(__('The information below will be used for the map marker. You can find the Latitude and Longitude of any location by <a href="%s" target="_blank">clicking here</a>.', 'p3'), 'http://www.latlong.net/' );
			?></p>

			<p>
				<label for="<?php echo $this->get_field_id('location'); ?>"><?php _e('Location Name:', 'p3'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'location' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'location' ); ?>" value="<?php if ($location) { echo $location; } ?>" placeholder="e.g. <?php _e('London, UK', 'p3'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('latitude'); ?>"><?php _e('Latitude:', 'p3'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" value="<?php if ($latitude) { echo $latitude; } ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="e.g. 51.179343" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('longitude'); ?>"><?php _e('Longitude:', 'p3'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" value="<?php if ($longitude) { echo $longitude; } ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="e.g. -1.546873" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Link the map to a url when clicked: (optional)', 'p3'); ?></label><br />
				<input type="url" id="<?php echo $this->get_field_id( 'url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php if ($url) { echo $url; } ?>" placeholder="e.g. http://example.com" />
			</p>
			<p>You can also edit the styling of this widget in the <a href="<?php echo admin_url('customize.php?autofocus[section]=pipdig_clw'); ?>" target="_blank">Customizer</a>.</p>
			<?php
		}
	 
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['location'] = esc_attr( $new_instance['location'] );
			$instance['latitude'] = esc_attr( $new_instance['latitude'] );
			$instance['longitude'] = esc_attr( $new_instance['longitude'] );
			$instance['url'] = esc_url( $new_instance['url'] );
			
			pipdig_clw_delete_transients(); // delete transients on widget save
			
			return $instance;
		}
	  
	} // close widget class
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_widget_clw");') );
}



// customiser
if (!class_exists('pipdig_clw_Customize')) {
	class pipdig_clw_Customize {
		public static function register ( $wp_customize ) {
		
			$widgets_url = admin_url( 'widgets.php' );

			$wp_customize->add_section( 'pipdig_clw', 
				array(
					'title' => __( "Current Location Widget", 'p3' ),
					'priority' => 925,
					//'panel' => 'pipdig_features',
					'description' => sprintf(__('Use these options to style the Current Location Widget. You will need to set your location in the <a href="%s">widget options</a> first.', 'p3'), $widgets_url ),
					'capability' => 'edit_theme_options',
				) 
			);

			// map color
			$wp_customize->add_setting('pipdig_clw_map_color',
				array(
					'default' => '#cccccc',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_clw_map_color',
				array(
					'label' => __( 'Map color', 'p3' ),
					'section' => 'pipdig_clw',
					'settings' => 'pipdig_clw_map_color',
				)
				)
			);

			// border color
			$wp_customize->add_setting('pipdig_clw_border_color',
				array(
					'default' => '#ffffff',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_clw_border_color',
				array(
					'label' => __( 'Border color', 'p3' ),
					'section' => 'pipdig_clw',
					'settings' => 'pipdig_clw_border_color',
				)
				)
			);
			
			// marker color
			$wp_customize->add_setting('pipdig_clw_marker_color',
				array(
					'default' => '#000000',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_clw_marker_color',
				array(
					'label' => __( 'Marker color', 'p3' ),
					'section' => 'pipdig_clw',
					'settings' => 'pipdig_clw_marker_color',
				)
				)
			);
			
			// marker size
			$wp_customize->add_setting( 'pipdig_clw_marker_size',
				array(
					'default' => 6,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control( 'pipdig_clw_marker_size',
				array(
					'type' => 'range',
					'section' => 'pipdig_clw',
					'label' => __( 'Marker size', 'p3' ),
					'input_attrs' => array(
						'min' => 3,
						'max' => 9,
						'step' => 1,
					),
				)
			);
		}
	}
	add_action( 'customize_register' , array( 'pipdig_clw_Customize' , 'register' ) );
}



// delete transients
if (!function_exists('pipdig_clw_delete_transients')) {
	function pipdig_clw_delete_transients() {
		delete_transient( 'pipdig_clw_map');
		//wp_cache_flush(); //flush object cache, just to be safe
	}
	add_action( 'customize_save_after', 'pipdig_clw_delete_transients' );
}
