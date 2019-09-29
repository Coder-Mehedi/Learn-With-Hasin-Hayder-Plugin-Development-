<?php

/**
 * Plugin Name: QuickTags
 * Description: QuickTags
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: quicktags
 * Domain Path: /languages/
 */

function quicktags_bootstrap() {
	load_plugin_textdomain( 'quicktags', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'quicktags_bootstrap' );


function quicktags_assets($screen) {
	if($screen == 'post.php') {
		wp_enqueue_script( 'qtsd-main-js', plugin_dir_url( __FILE__ )."/assets/js/main.js", array('quicktags','thickbox'),'1.0',true );
		wp_localize_script( 'qtsd-main-js', 'qtsd', array('preview' => plugin_dir_url( __FILE__ )."/fap.php") );
	}
}
add_action( 'admin_enqueue_scripts', 'quicktags_assets');