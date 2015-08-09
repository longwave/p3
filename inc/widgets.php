<?php 

require_once('widgets/bloglovin.php');
require_once('widgets/socialz.php');
require_once('widgets/pinterest.php');
require_once('widgets/latest-youtube.php');
require_once('widgets/profile.php');
require_once('widgets/facebook.php');
require_once('widgets/instagram.php');
require_once('widgets/clw.php');
require_once('widgets/popular-posts.php');
require_once('widgets/random-posts.php');
if (!pipdig_plugin_check('bloglovin-widget/bloglovin-widget.php')) {
	require_once('widgets/bloglovin.php'); // add widget
}
/*
require_once('widgets/laborator_subscribe.php');

function get($var)
{
	return isset($_GET[$var]) ? $_GET[$var] : (isset($_REQUEST[$var]) ? $_REQUEST[$var] : '');
}

function post($var)
{
	return isset($_POST[$var]) ? $_POST[$var] : null;
}
*/