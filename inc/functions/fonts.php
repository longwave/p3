<?php

// change default paragraph EGF option from p to body
/*
function pipdig_p3_egf_body( $body_font ) {
	$body_font = 'body';
	return $body_font;
}
add_filter( 'tt_default_body', 'pipdig_p3_egf_body' );
*/

// add a new section to the EGF panel
function pipdig_p3_egf_panels( $tabs ) {

	// header
	$tabs['pipdig-header'] = array(
		'name' => 'pipdig-header',
		'panel' => 'tt_font_typography_panel',
		'title' => 'Site Header',
		'description' => 'This description will appear in the customizer. Use it to display a helpful message',
		'sections' => array(),
	);
	
	// widgets
	$tabs['pipdig-widgets'] = array(
		'name' => 'pipdig-widgets',
		'panel' => 'tt_font_typography_panel',
		'title' => 'Widgets',
		'description' => 'This description will appear in the customizer. Use it to display a helpful message',
		'sections' => array(),
	);
	
	// navbar
	$tabs['pipdig-navbar'] = array(
		'name' => 'pipdig-navbar',
		'panel' => 'tt_font_typography_panel',
		'title' => 'Navbar / Menu',
		'description' => 'This description will appear in the customizer. Use it to display a helpful message',
		'sections' => array(),
	);

	return $tabs;
}
add_filter( 'tt_font_get_settings_page_tabs', 'pipdig_p3_egf_panels' );


// add new controls to the section
function pipdig_p3_egf_controls( $controls ) {

	// remove default tabs
	unset( $controls['tt_default_body'] );
	unset( $controls['tt_default_heading_1'] );
	unset( $controls['tt_default_heading_2'] );
	unset( $controls['tt_default_heading_3'] );
	unset( $controls['tt_default_heading_4'] );
	unset( $controls['tt_default_heading_5'] );
	unset( $controls['tt_default_heading_6'] );
	
	// site header ===========================================================
	
	$controls['pipdig_site_title'] = array(
		'name' => 'pipdig_site_title',
		'title' => 'Site Title',
		'tab' => 'pipdig-header',
		'properties' => array(
			'selector' => '.site-title, .site-title a',
		),
	);
	
	$controls['pipdig_site_tagline'] = array(
		'name' => 'pipdig_site_tagline',
		'title' => 'Site Tagline',
		'tab' => 'pipdig-header',
		'properties' => array(
			'selector' => '.site-description',
		),
	);
	
	
	// widget titles ========================================================
	
	$controls['pipdig_widget_title'] = array(
		'name' => 'pipdig_widget_title',
		'title' => 'Widget Titles',
		'tab' => 'pipdig-widgets',
		'properties' => array(
			'selector' => '.widget-title',
			'font_color' => '#000000',
			'font_size' => array( 'amount' => 32, 'unit' => 'px' ),
		),
	);
	
	
	// navbar ========================================================
	
	$controls['pipdig_navbar_text'] = array(
		'name' => 'pipdig_navbar_text',
		'title' => 'Primary Menu',
		'tab' => 'pipdig-navbar',
		'properties' => array(
			'selector' => '.site-top, .menu-bar ul li a',
		),
	);

	return $controls;
}
add_filter( 'tt_font_get_option_parameters', 'pipdig_p3_egf_controls' );