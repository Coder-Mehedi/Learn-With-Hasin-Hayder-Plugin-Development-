<?php

/**
 * Plugin Name: TinyMCE
 * Description: TinyMCE
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: tinymce
 * Domain Path: /languages/
 */

function tmcd_mce_external_plugins($plugins) {
	$plugins['tmcd_plugins'] = plugin_dir_url( __FILE__ ). 'assets/js/tinymce.js';
	return $plugins;
}

function tmcd_mce_buttons($buttons) {
	$buttons[] = 'tmcd_button_one';
	return $buttons;
}

function tmcd_admin_assets() {
	add_filter( 'mce_external_plugins', 'tmcd_mce_external_plugins' );
	add_filter( 'mce_buttons', 'tmcd_mce_buttons' );
}
add_action( 'admin_init', 'tmcd_admin_assets' );