<?php

/**
 * Plugin Name: ACF Demo
 * Description: ACF Demo
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: acfdemo
 * Domain Path: /langauges/
 */

function acf_demo_load_textdomain() {
	load_plugin_textdomain( 'demo', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'acf_demo_load_textdomain' );

