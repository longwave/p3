<?php

// add scripts to widgets admin page to render map
if (!function_exists('pipdig_clw_enqueue_scripts')) {
	function pipdig_clw_enqueue_scripts($hook) {
		wp_enqueue_script( 'ammap', '//cdnjs.cloudflare.com/ajax/libs/ammaps/3.13.0/ammap.js' );
		wp_enqueue_script( 'continentsLow', '//cdnjs.cloudflare.com/ajax/libs/ammaps/3.13.0/maps/js/continentsLow.js' );
		//wp_enqueue_script( 'ammap', plugin_dir_url( __FILE__ ) . 'js/ammap.js' );
		//wp_enqueue_script( 'continentsLow', plugin_dir_url( __FILE__ ) . 'js/continentsLow.js' );
	}
	//add_action( 'wp_enqueue_scripts', 'pipdig_clw_enqueue_scripts' );
}


// the widget class
if (!class_exists('pipdig_clw_widget')) {
	class pipdig_clw_widget extends WP_Widget {
	 
		public function __construct() {
			$widget_ops = array('classname' => 'pipdig_clw_widget', 'description' => __('Proudly display where you are in the world.', 'pipdig-clw') );
			$this->WP_Widget('pipdig_clw_widget', 'pipdig - ' . __('Current Location', 'pipdig-clw'), $widget_ops);
				
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
				$location = $instance['location'];
			} else {
				$location = 'None :(';
			}
			if (isset($instance['latitude'])) { 
				$latitude = $instance['latitude'];
			} else {
				$latitude = '';
			}
			if (isset($instance['longitude'])) { 
				$longitude = $instance['longitude'];
			} else {
				$longitude = '';
			}

			// Before widget code, if any
			echo (isset($before_widget)?$before_widget:'');
		
			if (!empty($title)) {
				echo $before_title . $title . $after_title;
			}
		
			if ($latitude && $longitude) {
				
				global $wp_customize; //used to check if we're in the customizer
				if (!isset($wp_customize)) { // are we in the customizer? No we're not, so let's use transients:
				
					if ( false === ( $map = get_transient( 'pipdig_clw_map' ) ) ) { // check for transient value
						$map_color = get_theme_mod( 'pipdig_clw_map_color', '#666666' );
						$border_color = get_theme_mod( 'pipdig_clw_border_color', '#ffffff' );
						$marker_color = get_theme_mod( 'pipdig_clw_marker_color', '#000000' );
						$marker_size = get_theme_mod( 'pipdig_clw_marker_size', '6' );
						$map = '<script>
						var map;

						AmCharts.ready(function() {
							var map;
							//svg path for target icon (used for dot on map for location images below)
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
							};
								
							map.dataProvider = {
								mapVar: AmCharts.maps.continentsLow,
									areas: [{
										"id": "africa",
									}, {
										"id": "asia",
									}, {
										"id": "australia",
									}, {
										"id": "europe",
									}, {
										"id": "north_america",
									}, {
										"id": "south_america",
									}],
									images: [
										{svgPath:targetSVG, color: "'.$marker_color.'", scale:.'.$marker_size.', title:"'.$location.'", latitude:'.$latitude.', longitude:'.$longitude.'},
									]

								};
								var zoomControl = map.zoomControl;
								zoomControl.panControlEnabled = false;
								zoomControl.zoomControlEnabled = false;
								zoomControl.mouseEnabled = false;

								map.write("mapdiv");

							});
						</script>
						<div id="mapdiv" style="width: 100%;height: 170px;"></div>
						<p>'.__('Current Location', 'pipdig-clw').': '.$location.'</p>
						<style scoped>#mapdiv a{display:none!important}</style>';
						set_transient( 'pipdig_clw_map', $map, 24 * HOUR_IN_SECONDS ); // set transient
					}
					echo $map; // print the map (whether transient or not)
					
				} else { // are we in the customizer? yes we are, so let's not use transients:
				
					$map_color = get_theme_mod( 'pipdig_clw_map_color', '#666666' );
					$border_color = get_theme_mod( 'pipdig_clw_border_color', '#ffffff' );
					$marker_color = get_theme_mod( 'pipdig_clw_marker_color', '#000000' );
					$marker_size = get_theme_mod( 'pipdig_clw_marker_size', '6' );
					echo '<script>
						var map;

						AmCharts.ready(function() {
							var map;
							//svg path for target icon (used for dot on map for location images below)
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
							};
								
							map.dataProvider = {
								mapVar: AmCharts.maps.continentsLow,
									areas: [{
										"id": "africa",
									}, {
										"id": "asia",
									}, {
										"id": "australia",
									}, {
										"id": "europe",
									}, {
										"id": "north_america",
									}, {
										"id": "south_america",
									}],
									images: [
										{svgPath:targetSVG, color: "'.$marker_color.'", scale:.'.$marker_size.', title:"'.$location.'", latitude:'.$latitude.', longitude:'.$longitude.'},
									]

								};
								var zoomControl = map.zoomControl;
								zoomControl.panControlEnabled = false;
								zoomControl.zoomControlEnabled = false;
								zoomControl.mouseEnabled = false;

								map.write("mapdiv");

							});
						</script>
						<div id="mapdiv" style="width: 100%;height: 170px;"></div>
						<p>'.__('Current Location', 'pipdig-clw').': '.$location.'</p>
						<style scoped>#mapdiv a{display:none!important}</style>';
				}
				
			} else { // no latitude/longitude set, so let's display a friendly reminder:
				
				if (current_user_can('manage_options')) {
					echo '<a href="'.admin_url( 'widgets.php' ).'">'.__('Please enter location data in the widget settings.', 'pipdig-clw').'</a>';
				} else {
					_e('Please enter location data in the widget settings.', 'pipdig-clw');
				}
				
			}
			// After widget code, if any  
			echo (isset($after_widget)?$after_widget:'');
		}

		public function form( $instance ) {
		   
			// PART 1: Extract the data from the instance variable
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
			
			if (isset($instance['location'])) { 
				$location = $instance['location'];
			} else {
				$location = '';
			}
			if (isset($instance['title'])) { 
				$title = $instance['title'];
			}
			if (isset($instance['latitude'])) { 
				$latitude = $instance['latitude'];
			} else {
				$latitude = '';
			}
			if (isset($instance['longitude'])) { 
				$longitude = $instance['longitude'];
			} else {
				$longitude = '';
			}
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'pipdig-clw'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if ($title) { echo $title; } ?>" />
			</p>
			
			<p><?php printf(__('The information below will be used for the map marker. You can find the Latitude and Longitude of any location by %sclicking here%s.', 'pipdig-clw'), '<a href="'.esc_url('http://www.latlong.net/').'" target="_blank">', '</a>'); ?></p>

			<p>
				<label for="<?php echo $this->get_field_id('location'); ?>"><?php _e('Location Name:', 'pipdig-clw'); ?></label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'location' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'location' ); ?>" value="<?php if ($location) { echo $location; } ?>" placeholder="e.g. <?php _e('London, UK', 'pipdig-clw'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('latitude'); ?>"><?php _e('Latitude:', 'pipdig-clw'); ?></label><br />
				<input type="number" id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" value="<?php if ($latitude) { echo $latitude; } ?>" placeholder="e.g. 51.179343" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('longitude'); ?>"><?php _e('Longitude:', 'pipdig-clw'); ?></label><br />
				<input type="number" id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" value="<?php if ($longitude) { echo $longitude; } ?>" placeholder="e.g. -1.546873" />
			</p>
			<?php
		}
	 
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['location'] = strip_tags( $new_instance['location'] );
			$instance['latitude'] = strip_tags( $new_instance['latitude'] );
			$instance['longitude'] = strip_tags( $new_instance['longitude'] );
			
			pipdig_clw_delete_transients(); // delete transients on widget save
			
			return $instance;
		}
	  
	} // close widget class
	add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_clw_widget");') );
}



// customiser
if (!class_exists('pipdig_clw_Customize')) {
	class pipdig_clw_Customize {
		public static function register ( $wp_customize ) {


			$wp_customize->add_section( 'pipdig_clw', 
				array(
					'title' => __( "Current Location Widget", 'pipdig-clw' ),
					'priority' => 925,
					'panel' => 'pipdig_features',
					'description' => sprintf(__('Use these options to style the Current Location Widget. You will need to set your location in the %swidget options%s first.', 'pipdig-clw'), '<a href="'.admin_url( 'widgets.php' ).'">', '</a>'),
					'capability' => 'edit_theme_options',
				) 
			);


			// map color
			$wp_customize->add_setting('pipdig_clw_map_color',
				array(
					'default' => '#999999',
					//'transport'=>'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pipdig_clw_map_color',
				array(
					'label' => __( 'Map color', 'pipdig-clw' ),
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
					'label' => __( 'Border color', 'pipdig-clw' ),
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
					'label' => __( 'Marker color', 'pipdig-clw' ),
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
					'label' => __( 'Marker size', 'pipdig-clw' ),
					'input_attrs' => array(
						'min' => 3,
						'max' => 9,
						'step' => 1,
					),
				)
			);
			
			/*
			$wp_customize->add_setting('pipdig_clw_icon',
				array(
					'default' => 'heart',
					//'sanitize_callback' => 'pipdig_clw_sanitize_icon',
				)
			);
			 
			$wp_customize->add_control('pipdig_clw_icon',
				array(
					'type' => 'radio',
					'label' => __( 'Widget Icon', 'pipdig-clw' ),
					'section' => 'pipdig_clw',
					'choices' => array(
						'heart' => __( 'Heart', 'pipdig-clw' ),
						'plus' => __( 'Plus', 'pipdig-clw' ),
						'none' => __( 'None', 'pipdig-clw' ),
					),
				)
			);
			*/
		}


		/*
		function pipdig_clw_sanitize_icon( $input ) {
			$valid = array(
				'heart' => 'Heart',
				'plus' => 'Plus',
				'' => 'None',
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
		}
		*/

		public static function live_preview() {
			$plugin_url = plugins_url( 'inc/customizer.js', __FILE__ );
			wp_enqueue_script( 
				'pipdig-pipdig-clw-customizer',
				$plugin_url ,
				array(  'jquery', 'customize-preview' ),
				'', // Define a version (optional) 
				true // Specify whether to put in footer (leave this true)
			);
		}
	}
	add_action( 'customize_register' , array( 'pipdig_clw_Customize' , 'register' ) );
	add_action( 'customize_preview_init' , array( 'pipdig_clw_Customize' , 'live_preview' ) );
}



// delete transients
if (!function_exists('pipdig_clw_delete_transients')) {
	function pipdig_clw_delete_transients() {
		delete_transient( 'pipdig_clw_map');
		//wp_cache_flush(); //flush object cache, just to be safe
	}
	add_action( 'customize_save_after', 'pipdig_clw_delete_transients' );
}




?>