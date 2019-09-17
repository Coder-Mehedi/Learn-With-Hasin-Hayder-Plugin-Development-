<?php

/**
 * @Author: mehedi
 * @Date:   2019-09-15 13:35:30
 * @Last Modified by:   Coder-Mehedi
 * @Last Modified time: 2019-09-17 14:04:13
 */
/**
 * Plugin Name: demo
 * Description: Demo plugin er abar description
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: demo
 * Domain Path: /languages/
 */


function demo_load_textdomain() {
	load_plugin_textdomain( 'demo', false, dirname(__FILE__)."/languages" );
}


function demo_custom_footer_text($text) {
	return '<p>udemy course first plugin</p>' . $text;
}

add_filter( 'admin_footer_text', 'demo_custom_footer_text' );

function add_my_own_menu() {
	global $wp_admin_bar;

	$custom_menu = array(
		'id' => 'demo_menu',
		'title' => 'This is a demo menu title',
		'parent' => 'top-secondary',
		'href' => site_url()
	);

	$wp_admin_bar->add_node($custom_menu);

}


add_action( 'admin_bar_menu', 'add_my_own_menu' );

function shortcode_custom_function($attr) {
	$output_text = 'Hi everybody';

	if(isset($attr['attribute'])) 
		$output_text = $attr['attribute'];
	return "<p class='demo-class' id='demo-id'>You gave me: $output_text </p>";


	
	
	// return "yeah it displays our shortcode";
}

add_shortcode( 'shortcode_used_in_posts_or_pages', 'shortcode_custom_function' );


require_once 'our_menu.php';


function gmap_shortcode_callback($attr) {
	$default = array(
		'place' => 'Dhaka',
		'width' => '100%',
		'height' => '450',
		'zoom' => 14
	);

	$params = shortcode_atts( $default, $attr );

	$map = <<<EOD
<div>
	<div>
		<iframe 
			width="{$params['width']}" height="{$params['height']}"
			src="https://www.google.com/maps?q={$params['place']}&t=&z={$params['zoom']}&ie=UTF8&iwloc=&output=embed"  frameborder="0" style="border:0;" allowfullscreen="">
		</iframe>
	</div>
</div>
EOD;

	return $map;
}
add_shortcode( 'gmap', 'gmap_shortcode_callback' );



function demo_button_shortcode_callback($attr, $content) {
	$default = array(
		'title' => __("Button", 'mh-qrcode'),
		'url' => ''
	);

	$attributes = shortcode_atts( $default, $attr );
	$markup = sprintf('<a href="%s" class="btn"> %s </a>',
		$attributes['url'],
		do_shortcode( $content )
		 );
	return $markup;
}

add_shortcode( 'button', 'demo_button_shortcode_callback' );

function uc_callback($attr, $content) {
	return strtoupper(do_shortcode( $content ));
}

add_shortcode( 'uc', 'uc_callback' );