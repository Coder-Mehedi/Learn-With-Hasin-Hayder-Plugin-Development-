<?php

/**
 * @Author: Coder-Mehedi
 * @Date:   2019-09-17 15:45:57
 * @Last Modified by:   Coder-Mehedi
 * @Last Modified time: 2019-09-17 18:50:51
 */
/**
 * Plugin Name: Assets Ninja
 * Description: Plugin for Manage Assets
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: assetsninja
 * Domain Path: /languages/
 */


class AssetsNinja{
	function __construct() {
		add_action( 'plugins_loaded', array($this, 'load_textdomain') );
		add_action( 'wp_enqueue_scripts', array($this, 'load_front_assets' ));
	}

	function load_textdomain() {
		load_plugin_textdomain( 'assetsninja', false, plugin_dir_url( __FILE__ )."/languages" );
	}

	function load_front_assets() {
		// wp_enqueue_script( 'assetsninja-main', plugin_dir_url( __FILE__ )."/assets/public/js/main.js", array('jquery'), '1.0', true );
		$js_enqueue = array(
			'assetsninja-main'=> array('path' => plugin_dir_url( __FILE__ )."/assets/public/js/main.js", 'dep' => array('jquery'))
		);
		foreach ($js_enqueue as $handle => $fileinfo) {
			wp_enqueue_script( $handle, $fileinfo['path'], $fileinfo['dep'], '1.0', true );
		}

		$data = array(
			'name' => 'Mehedi Hasan',
			'url' => 'https://google.com'
		);

		wp_localize_script( 'assetsninja-main', 'assetsninja', $data );
	}








}

new AssetsNinja();