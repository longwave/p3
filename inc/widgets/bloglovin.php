<?php
if ( !class_exists( 'pipdig_theme_bloglovin_widget' ) ) {
	class pipdig_theme_bloglovin_widget extends WP_Widget {
	 
	  public function __construct() {
		  $widget_ops = array('classname' => 'pipdig_theme_bloglovin_widget', 'description' => __("Display your Bloglovin' follower count.", 'p3-textdomain') );
		  $this->WP_Widget('pipdig_theme_bloglovin_widget', 'pipdig - ' . __("Bloglovin' Widget", 'p3-textdomain'), $widget_ops);
	  }
	  
	  function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
	   
		$bloglovin_count = get_option('pipdig_bloglovin_follower_count');
		$bloglovin_url = get_theme_mod('socialz_bloglovin');
		$bloglovin_official = get_theme_mod('pipdig_bloglovin_widget_official', false);

		if (!empty($bloglovin_url)) {
			if ($bloglovin_official) { //use official widget
				$bloglovin_widget_output = '<div style="text-align:center;width:98%;margin:0 auto"><a class="blsdk-follow" href="'.$bloglovin_url.'" target="_blank" rel="nofollow" data-blsdk-type="button" data-blsdk-counter="true">Follow on Bloglovin</a><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s);js.id = id;js.src = "https://widget.bloglovin.com/assets/widget/loader.js";fjs.parentNode.insertBefore(js, fjs);}(document, "script", "bloglovin-sdk"))</script></div>';
			} else { // use customizer
				$icon_type = get_theme_mod('pipdig_bloglovin_widget_icon', 'heart');
				if (empty($icon_type)) {
					$bloglovin_icon = '<i class="fa fa-heart"></i>';
				} else {
					$bloglovin_icon = '<i class="fa fa-' . $icon_type . '"></i>';
				}
				switch ( $icon_type ) {
					case 'heart':
						 $bloglovin_icon = '<i class="fa fa-heart"></i> ';
						break;
					case 'plus':
						 $bloglovin_icon = '<i class="fa fa-plus"></i> ';
						break;
					case 'none':
						 $bloglovin_icon = '';
						break;
				}
				if ($bloglovin_count) {
					$bloglovin_widget_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="pipdig-bloglovin-widget">' . $bloglovin_icon . $bloglovin_count . ' ' . __("Followers on Bloglovin'", 'p3-textdomain') . '</a></p>';
				} else {
					$bloglovin_widget_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow" class="pipdig-bloglovin-widget">' . $bloglovin_icon . __("Follow on Bloglovin'", 'p3-textdomain') . '</a></p>';
				}
			}
			echo $bloglovin_widget_output;
		} else {
			$cust_url = admin_url( 'customize.php' );
			printf(__("Widget setup not complete. You must add your bloglovin profile to the 'Social Media Icons' section of the <a href='%s'>Customizer</a>.", 'p3-textdomain'), $cust_url );
		}
		// After widget code, if any
		echo (isset($after_widget)?$after_widget:'');
	  }
	 
	  public function form( $instance ) {
	   
		$cust_url = admin_url( 'customize.php' );
		?>
		<p><?php _e("This widget will display your total Bloglovin' follower count.", 'p3-textdomain'); ?></p>
		<p><?php printf(__("You can style this widget in the <em>Bloglovin' Widget</em> section of the <a href='%s'>Customizer</a>.", 'p3-textdomain'), $cust_url ); ?></p>

		 <?php
	   
	  }
	 
	  function update($new_instance, $old_instance) {
		$instance = $old_instance;
		pipdig_p3_do_this_daily(); // activate scrape when widget saved/added
		return $instance;
	  }
	  
	}
} // end class exists check
//add_action( 'widgets_init', create_function('', 'return register_widget("pipdig_theme_bloglovin_widget");') );