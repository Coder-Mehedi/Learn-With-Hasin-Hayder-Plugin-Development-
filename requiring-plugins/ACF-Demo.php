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

require_once plugin_dir_path( __FILE__ )."/libs/class-tgm-plugin-activation.php";
function acf_demo_load_textdomain() {
	load_plugin_textdomain( 'demo', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'acf_demo_load_textdomain' );

function acfd_tgm_register_required_plugins() {
	$plugins = array(
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Advanced Custom Fields',
			'slug'      => 'advanced-custom-fields',
			'required'  => true,
		)
	);

	$config = array(
		'id'           => 'acfdemo',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right  
	);
	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'acfd_tgm_register_required_plugins' );

add_filter('acf/settings/show_admin', '__return_false');
