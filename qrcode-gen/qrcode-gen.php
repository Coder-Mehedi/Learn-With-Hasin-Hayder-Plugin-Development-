<?php

/**
 * @Author: mehedi
 * @Date:   2019-09-13 23:47:09
 * @Last Modified by:   mehedi
 * @Last Modified time: 2019-09-16 17:37:11
 */
/**
 * Plugin Name: QRCode Gen
 * Description: generating qrcode.
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: mh-qrcode
 * Domain Path: /languages/
 */

function demo_button_shortcode_callback($attr) {
	$default = array(
		'title' => __("Button", 'mh-qrcode'), 
		'url' => ''
	);

	$attributes = shortcode_atts( $default, $attr );
	$markup = sprintf('<a href="%s" class="btn"> %s </a>', $attributes['url'], $attributes['title'] );
	return $markup;
}

add_shortcode( 'button', 'demo_button_shortcode_callback' );




function qrcode_assets($screen) {
	if($screen == 'options-general.php'){
		wp_enqueue_style( 'qrcode_minitoggle-css', plugin_dir_url( __FILE__ )."/assets/css/minitoggle.css");

		wp_enqueue_script( 'qrcode-main-js', plugin_dir_url(__FILE__)."/assets/js/qrcode-main.js", array('jquery'), '1.0', true );

		wp_enqueue_script( 'minitoggle-js', plugin_dir_url(__FILE__)."/assets/js/minitoggle.js", array('jquery'), time(), true );
	}
}

add_action( 'admin_enqueue_scripts', 'qrcode_assets');

$qrcode_countries = array(
		__('Afganistan','mh-qrcode'),
		__('Bangladesh', 'mh-qrcode'),
		__('Bhutan', 'mh-qrcode'),
		__('India', 'mh-qrcode'),
		__('Nepal', 'mh-qrcode'),
		__('Pakistan', 'mh-qrcode'),
		__('Sri Lanka', 'mh-qrcode')
);


function qrcode_init() {
	global $qrcode_countries;
	$qrcode_countries = apply_filters( 'qrcode_countries', $qrcode_countries );
}
add_action( 'init', 'qrcode_init' );


function qrcode_gen_load_textdomain() {
	load_plugin_textdomain( 'mh-qrcode', false, dirname(__FILE__)."/languages" );
}

function qrcode_display_qrcode($content) {
	$current_post_id = get_the_ID();
	$current_post_title = get_the_title( $current_post_id );
	$current_post_url = urlencode(get_the_permalink( $current_post_id ));


	// post type check
	$excluded_post_types = apply_filters( 'qrcode_excluded_post_types', array() );

	// qrcode dimention check
	$height = get_option( 'qrcode_height' ) ? get_option( 'qrcode_height' ) : '180';
	$width = get_option( 'qrcode_width' ) ? get_option( 'qrcode_width' ) : '180';

	$dimention = apply_filters( 'qrcode_dimention', "{$width}x{$height}" );


	$current_post_type = get_post_type( $current_post_id );
	if(in_array($current_post_type, $excluded_post_types)){
		return $content;
	}


	$image_src = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s', $dimention, $current_post_url);
	$content .= sprintf('<img class="qrcode" src="%s" alt="%s" />', $image_src, $current_post_title);
	return $content;
}

add_filter( 'the_content', 'qrcode_display_qrcode' );


function qrcode_settings_init() {
	add_settings_section( 'qrcode_section', __('Post to QR Code', 'mh-qrcode'), 'qrcode_section_callback', 'general' );


	add_settings_field( 'qrcode_height', __('QR Code Height', 'mh-qrcode'), 'qrcode_display_field', 'general', 'qrcode_section', array('qrcode_height') );

	add_settings_field( 'qrcode_width', __('QR Code Width', 'mh-qrcode'), 'qrcode_display_field', 'general', 'qrcode_section', array('qrcode_width') );

	add_settings_field( 'qrcode_select', __('Dropdown', 'mh-qrcode'), 'qrcode_display_select_field', 'general', 'qrcode_section' );

	add_settings_field( 'qrcode_checkbox', __('Select Countries', 'mh-qrcode'), 'qrcode_display_checkboxgroup_field', 'general', 'qrcode_section' );


	add_settings_field( 'qrcode_toggle', __('Toggle Field', 'mh-qrcode'), 'qrcode_display_toggle_field', 'general', 'qrcode_section' );



	register_setting( 'general', 'qrcode_height', array('sanitize_callback' => 'esc_attr') );
	register_setting( 'general', 'qrcode_width', array('sanitize_callback' => 'esc_attr') );
	register_setting( 'general', 'qrcode_select', array('sanitize_callback' => 'esc_attr') );
	register_setting( 'general', 'qrcode_checkbox');
	register_setting( 'general', 'qrcode_toggle');

}

function qrcode_display_toggle_field() {
	$option = get_option( 'qrcode_toggle' );
	echo '<div id="toggle1"> </div>';
	echo "<input type='hidden' name='qrcode_toggle' id='qrcode_toggle' value='$option' >";
}


function qrcode_display_checkboxgroup_field() {
	global $qrcode_countries;
	$option = get_option( 'qrcode_checkbox');

	foreach ($qrcode_countries as $country) {
		$selected = '';

		if(is_array($option) && in_array($country, $option)) {
			$selected = 'checked';
		}

		printf('<input type="checkbox" name="qrcode_checkbox[]" value="%s" %s /> %s <br />', $country, $selected, $country);
	}
}



function qrcode_display_select_field() {
	global $qrcode_countries;
	$option = get_option( 'qrcode_select');
	

	printf('<select id="%s" name="%s">', 'qrcode_select', 'qrcode_select');
	foreach ($qrcode_countries as $country) {
		$selected = '';
		if($option == $country) {
			$selected = 'selected';
		}
		printf('<option value="%s" %s> %s </option>', $country, $selected, $country);
	}
	echo '<select/>';
}

function qrcode_section_callback() {
	echo "<p>".__('settings for post to qrcode plugin', 'mh-qrcode')."</p>";
}


function qrcode_display_field($args) {
	$option = get_option( $args[0] );
	printf("<input type='text' id='%s' name='%s' value='%s' />", $args[0], $args[0], $option);

}

// function qrcode_display_height() {
// 	$height = get_option( 'qrcode_height' );
// 	printf("<input type='text' id='%s' name='%s' value='%s' />", 'qrcode_height', 'qrcode_height', $height);
// }


// function qrcode_display_width() {
// 	$width = get_option( 'qrcode_width' );
// 	printf("<input type='text' id='%s' name='%s' value='%s' />", 'qrcode_width', 'qrcode_width', $width);
// }

add_action( 'admin_init', 'qrcode_settings_init' );


function qrcode_settings_menu() {
	add_menu_page( 'Simple Page Title', 'QR Code Settings', 'administrator', 'qrcode-settings', 'qrcode_settings_callback', 'dashicons-carrot' );

	// add_submenu_page( 'our_menu_slug', 'Our Submenu', 'Our Submenu Title', 'administrator', 'our_submenu_slug', 'submenu_callback' );
}

function qrcode_settings_callback() {

}

add_action( 'admin_menu', 'qrcode_settings_menu' );