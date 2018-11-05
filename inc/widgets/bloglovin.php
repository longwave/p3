<?php

if (!defined('ABSPATH')) die;

if ( !class_exists( 'pipdig_theme_bloglovin_widget' ) ) {
	class pipdig_theme_bloglovin_widget extends WP_Widget {
	 
		public function __construct() {
			$widget_ops = array('classname' => 'pipdig_theme_bloglovin_widget', 'description' => __("Display your Bloglovin' follower count.", 'p3') );
			parent::__construct('pipdig_theme_bloglovin_widget', 'pipdig - ' . __("Bloglovin' Button", 'p3'), $widget_ops);
		}
		
		function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');
		pipdig_p3_scrapey_scrapes();
		$links = get_option('pipdig_links');
		$bloglovin_url = esc_url($links['bloglovin']);
		$bloglovin_count = strip_tags(get_option('p3_bloglovin_count'));
		$bloglovin_official = get_theme_mod('pipdig_bloglovin_widget_official', false);

		if (!empty($bloglovin_url)) {
			if ($bloglovin_official) { //use official widget
				// strip queries from url
				if ($url = parse_url($bloglovin_url)) {
					$bloglovin_url =  '//'.$url['host'].$url['path'];
				}
				$bloglovin_widget_output = '<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"><div style="text-align:center;margin:0 auto"><a target="_blank" rel="nofollow noopener" href="'.$bloglovin_url.'" style="background: #000; border: 0; border-radius: 2px; display: block; height: 20px; overflow: hidden; padding: 0 5px; position: relative; width: 110px; display: inline-block"><div style="background: url(https://static.blovcdn.com/images/widget/follow.svg) no-repeat; display: inline-block; height: 14px; left: 4px; position: absolute; top: 3px; width: 15px;"></div><div style="background: url(https://static.blovcdn.com/images/widget/logo-2-white.svg) no-repeat; display: inline-block; height: 10px; left: 21px; position: absolute; top: 5px; width: 84px;"></div></a><a href="'.$bloglovin_url.'" rel="nofollow noopener" target="_blank" style="padding:0 4px;height:20px;display:inline-block;text-align:center;border:1px solid #cfcfcf;border-radius:2px;background-color:white;overflow:hidden;position:relative;left:3px;font:13px Open Sans,sans-serif;line-height:18px;color:#000!important;text-decoration:none!important">'.$bloglovin_count.'</a></div>';
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
				if ($bloglovin_count > 1) {
					$bloglovin_widget_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow noopener" class="pipdig-bloglovin-widget">' . $bloglovin_icon . $bloglovin_count . ' ' . __("Followers on Bloglovin'", 'p3') . '</a></p>';
				} else {
					$bloglovin_widget_output = '<p><a href="'. $bloglovin_url .'" target="blank" rel="nofollow noopener" class="pipdig-bloglovin-widget">' . $bloglovin_icon . __("Follow on Bloglovin'", 'p3') . '</a></p>';
				}
			}
			echo $bloglovin_widget_output;
		} else {
			echo 'Bloglovin widget in section "'.$args['name'].'": '.__('Setup not complete. Please check the widget options.', 'p3');
		}
		// After widget code, if any
			echo (isset($after_widget)?$after_widget:'');
		}
	 
		public function form( $instance ) {
			$links = get_option('pipdig_links');
			$bloglovin_url = $links['bloglovin'];
			$bloglovin_count = get_option('p3_bloglovin_count');
			$cust_url = admin_url( 'admin.php?page=pipdig-links' );
			?>
			<p><?php _e("This widget will display your total Bloglovin' follower count.", 'p3'); ?></p>
			<?php if ($bloglovin_count) { ?>
				<p><?php echo strip_tags($bloglovin_count).' '. __("Followers on Bloglovin'", 'p3'); ?>.</p>
			<?php } ?>
			<p><?php
			if (empty($bloglovin_url)) {
				printf(__("You will need to <a href='%s'>add the link</a> to your Bloglovin' page first.", 'p3'), admin_url('admin.php?page=pipdig-links') );
			}
			?></p>
			

			<?php
		 
		}
	 
		function update($new_instance, $old_instance) {
		$instance = $old_instance;
		pipdig_p3_scrapey_scrapes();
		return $instance;
		}
		
	}
}