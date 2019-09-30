<?php

/**
 * Plugin Name: Our Metabox
 * Description: Our Metabox
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: our-metabox
 * Domain Path: /languages/
 */


class OurMetaBox {
	public function __construct() {
		add_action( 'plugins_loaded', array($this, 'omb_load_textdomain' ));
		add_action( 'admin_menu', array($this, 'omb_add_metabox') );
		add_action( 'save_post', array($this, 'omb_save_location') );
	}

	private function is_secured($nonce_field, $action, $post_id) {
		$nonce = isset($_POST['nonce_field']) ? $_POST['nonce_field'] : '';

		if($nonce == '') {
			return false;
		}

		if(!wp_verify_nonce( $nonce, $action )){
			return false;
		}

		if(!current_user_can( 'edit_post', $post_id )) {
			return false;
		}

		if(wp_get_post_autosave($post_id)) {
			return false;
		}

		if(wp_is_post_revision( $post_id )) {
			return false;
		}
		return true;
	}

	function omb_save_location($post_id) {
		// if(!$this->is_secured('omb_location_field', 'omb_location', $post_id)) {
		// 	return $post_id;
		// }

		$location = isset($_POST['omb_location']) ? $_POST['omb_location'] : '';


		if($location == '') {
			return $post_id;
		}
		update_post_meta( $post_id, 'omb_location', $location );
	}

	function omb_add_metabox() {
		add_meta_box( 'omb_post_location', __('Location Info', 'our-metabox'), array($this, 'omb_display_post_location'), 'post' );
	}

	function omb_display_post_location($post) {
		$location = get_post_meta( $post->ID, 'omb_location', true );
		$label = __('Location', 'our-metabox');
		wp_nonce_field( 'omb_location', 'omb_location_field' );
		$metabox_html = <<<EOD
<div>
	<label for="omb_location">{$label}</label>
	<input id="omb_location" name="omb_location" type="text" value="{$location}"/>
</div>
EOD;
	echo $metabox_html;
	}

	public function omb_load_textdomain() {
		load_plugin_textdomain( 'our-metabox', false, dirname( __FILE__ ).'/languages' );
	}
}


new OurMetaBox();