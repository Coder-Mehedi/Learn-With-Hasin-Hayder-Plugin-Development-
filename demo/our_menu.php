<?php

/**
 * @Author: mehedi
 * @Date:   2019-09-15 15:43:00
 * @Last Modified by:   mehedi
 * @Last Modified time: 2019-09-15 17:09:52
 */

function hide_admin_bar() {
	$option = get_option( 'our-first-option' );

	if($option === 'yes') {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}

add_action( 'init', 'hide_admin_bar');



function register_our_settings() {
	register_setting( 'our-settings-group', 'our-first-option' );
}

add_action( 'admin_init', 'register_our_settings' );

function our_menu_callback() { ?>
	
	<form action="options.php" method="POST">
		<?php settings_fields( 'our-settings-group' ); ?>
		<input type="checkbox" name="our-first-option" id="hide-admin" value="yes" 
		<?php checked( get_option( 'our-first-option' ), 'yes'); ?>>

		<label for="hide-admin">Hide Admin bar in frontend?</label>
		<?php submit_button( 'Save' ); ?>
	</form>


<?php 
}


function submenu_callback() {
	echo 'submenu callback';
}





function build_our_first_menu() {
	add_menu_page( 'Our Page Title', 'Our Menu Title', 'administrator', 'our_menu_slug', 'our_menu_callback', 'dashicons-carrot' );

	add_submenu_page( 'our_menu_slug', 'Our Submenu', 'Our Submenu Title', 'administrator', 'our_submenu_slug', 'submenu_callback' );
}

add_action( 'admin_menu', 'build_our_first_menu' );

