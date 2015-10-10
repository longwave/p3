<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('pipdig_shortcodes_options_page')) {
	function pipdig_shortcodes_options_page() { 

	?>
	<div class="wrap">
	<h1>Shortcodes</h1>
	<p>A shortcode is a special tag that you can enter into a post that gets replaced with different content when actually viewing the post on the website.</p>
	<p>For example, when you add the <code>[gallery]</code> shortcode to a post, WordPress automatically replaces this with all of the code required to display an image gallery. Read more about this <a href="<?php echo esc_url('http://code.tutsplus.com/articles/the-wordpress-gallery-shortcode-a-comprehensive-overview--wp-23743'); ?>" target="_blank">here</a>.</p>
	
	<h2>Our custom shortcodes:</h2>
	<div class="card">
		<h2>Star Ratings</h2>
		<p>Do you write products reviews? Now you can add a star rating to any post/page by using the shortcode <code>[pipdig_stars]</code>.</p>
		<p>Set the rating by adding a "rating" number out of 5 to the shortcode:</p>
		<img src="http://pipdigz.co.uk/p3/img/shortcodes/5_stars.png" alt="5 Stars" />
		<pre><code>[pipdig_stars rating="5"]</code></pre>
		<img src="http://pipdigz.co.uk/p3/img/shortcodes/3_half_stars.png" alt="3.5 Stars" />
		<pre><code>[pipdig_stars rating="3.5"]</code></pre>
		<img src="http://pipdigz.co.uk/p3/img/shortcodes/blue_stars.png" alt="3.5 Stars" />
		<pre><code>[pipdig_stars rating="1.5" color="#2277AA"]</code></pre>
	</div>
	</div>
	<?php

	}
}

