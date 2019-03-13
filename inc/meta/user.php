<?php if (!defined('ABSPATH')) die;

// Add Instagram to user contact info
function p3_user_contact_fields($user_contact) {

	$user_contact['instagram'] = 'Instagram User (without @)';
	return $user_contact;
	
}
add_filter('user_contactmethods', 'p3_user_contact_fields');