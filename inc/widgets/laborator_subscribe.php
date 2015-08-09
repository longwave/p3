<?php

class Laborator_Subscribe extends WP_Widget {
	
	public function __construct()
	{
		parent::__construct(false, '[Laborator] Subscribe', array('description' => 'Let users subscribe (with emails) to your website. This widget is developed by Laborator team.'), array('width' => 295));
	}
	
	
	public function widget($args, $instance)
	{
		extract($args);
		
		$description = $instance['description'];
		
		$is_metroelement = isset($args['is_metroelement']) ? $args['is_metroelement'] : false;
		
		// Before Widget
		echo PHP_EOL . $before_widget;
		
		// Display Title
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Tweets' : $instance['title'], $instance, $this->id_base);
		
		if($title)
			echo PHP_EOL . $before_title . $title . $after_title . PHP_EOL;
		
		?>
		<div class="subscribe">
			<?php echo wpautop(trim($description)); ?>
			
			<!-- subscribe form -->
			<form method="post" enctype="application/x-www-form-urlencoded" action="http://feedburner.google.com/fb/a/mailverify" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $instance['feedburner_id']; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520'); return true">
				<input type="hidden" value="<?php echo $instance['feedburner_id']; ?>" name="uri"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input type="text" name="email" id="subscribe_mail" class="subscribe_input" placeholder="<?php echo esc_attr($instance['input_placeholder']); ?>" />
				<button type="submit" name="commit" id="subscribe_now"><?php echo $instance['submit_text']; ?></button>
				
			</form>
			<!-- end: subscribe form -->
		</div>
		<?php
		
		// After Widget
		echo $after_widget . PHP_EOL;
	}
	
	
	public function update($new_instance, $old_instance)
	{
		// Title
		$old_instance['title'] = post('title');
		$old_instance['description'] = stripslashes(post('description'));
		$old_instance['feedburner_id'] = post('feedburner_id');
		$old_instance['input_placeholder'] = post('input_placeholder');
		$old_instance['submit_text'] = post('submit_text');
		
		return $old_instance;
	}
	
	
	public function form($instance)
	{
		$defaults = array(
			'title' => '',
			'description' => '',
			'feedburner_id' => '',
			'input_placeholder' => '',
			'submit_text' => 'Join'
		);
		
		$instance = array_merge($defaults, $instance);
			
		?>
		<p>
			<label for="title">Display Title:</label>
			<input type="text" id="title" name="title" class="regular-text nl" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="description">Description:</label>
			<br />
			<textarea name="description" id="description" class="nl" cols="40" rows="5"><?php echo stripslashes($instance['description']); ?></textarea>
		</p>
		
		<p>
			<label for="feedburner_id">FeedBurner.com ID:</label>
			<input type="text" id="feedburner_id" name="feedburner_id" class="regular-text nl" value="<?php echo $instance['feedburner_id']; ?>" />
		</p>
		
		<p>
			<label for="input_placeholder">Input Placeholder:</label>
			<input type="text" id="input_placeholder" name="input_placeholder" class="regular-text nl" value="<?php echo $instance['input_placeholder']; ?>" />
		</p>
		
		<p>
			<label for="submit_text">Submit Text:</label>
			<input type="text" id="submit_text" name="submit_text" class="regular-text nl" value="<?php echo $instance['submit_text']; ?>" />
		</p>
		<?php
	}
	
}

// Register widget
add_action('widgets_init', 'init_laborator_subscribe_widget');

function init_laborator_subscribe_widget(){
	
	register_widget('Laborator_Subscribe');

}