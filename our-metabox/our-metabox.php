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
		add_action( 'save_post', array($this, 'omb_save_metabox') );
		add_action( 'save_post', array($this, 'omb_save_image') );

		add_action( 'admin_enqueue_scripts', array($this, 'omb_admin_assets' ));
	}

	function omb_admin_assets() {
		wp_enqueue_style( 'omb_admin_style', plugin_dir_url( __FILE__ ).'/assets/admin/css/style.css', null, '1.0', 'all' );
		wp_enqueue_style( 'omb_admin_style','//code.jquery.com/ui/1.12.0/jquery-ui.min.js');
		wp_enqueue_script( 'omb-admin-js', plugin_dir_url( __FILE__ ).'/assets/admin/js/main.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );
	}

	private function is_secured($nonce_field, $action, $post_id) {
		$nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';

		if($nonce == '') {
			return false;
		}

		if(!wp_verify_nonce( $nonce, $action )){
			return false;
		}

		if(!current_user_can( 'edit_post', $post_id )) {
			return false;
		}

		if(wp_is_post_autosave($post_id)) {
			return true;
		}

		if(wp_is_post_revision( $post_id )) {
			return false;
		}

		return true;

	}

	function omb_save_image($post_id) {
	if(!$this->is_secured('omb_image_nonce', 'omb_image', $post_id)) {
		return $post_id;
	}
	$image_id = isset($_POST['omb_image_id']) ? $_POST['omb_image_id'] : '';
	$image_url = isset($_POST['omb_image_url']) ? $_POST['omb_image_url'] : '';

	update_post_meta( $post_id, 'omb_image_id', $image_id );
	update_post_meta( $post_id, 'omb_image_url', $image_url );
	}

	function omb_save_metabox($post_id) {
		if(!$this->is_secured('omb_location_field', 'omb_location', $post_id)) {
			return $post_id;
		}

		$location = isset($_POST['omb_location']) ? $_POST['omb_location'] : '';
		$country = isset($_POST['omb_country']) ? $_POST['omb_country'] : '';
		$is_favorite = isset($_POST['omb_is_favorite']) ? $_POST['omb_is_favorite'] : 0;
		$colors = isset($_POST['omb_clr']) ? $_POST['omb_clr'] : array();
		$colors2 = isset($_POST['omb_color']) ? $_POST['omb_color'] : '';


		if($location == '' || $country == '') {
			return $post_id;
		}

		$location = sanitize_text_field( $location );
		$country = sanitize_text_field( $country );

		update_post_meta( $post_id, 'omb_location', $location );
		update_post_meta( $post_id, 'omb_country', $country );
		update_post_meta( $post_id, 'omb_is_favorite', $is_favorite );
		update_post_meta( $post_id, 'omb_clr', $colors );
		update_post_meta( $post_id, 'omb_color', $colors2 );
	}

	function omb_add_metabox() {
		add_meta_box( 'omb_post_location', __('Location Info', 'our-metabox'), array($this, 'omb_display_metabox'), 'post' );

		add_meta_box( 'omb_book_info', __('Book Info', 'our-metabox'), array($this, 'omb_book_info'), 'book' );

		add_meta_box( 'omb_image_info', __('Image Info', 'our-metabox'), array($this, 'omb_image_info'), 'post' );
	}

	function omb_image_info($post) {
		$image_id = esc_attr(get_post_meta( $post->ID, 'omb_image_id',true ));
		$image_url = esc_attr(get_post_meta( $post->ID, 'omb_image_url',true ));

		wp_nonce_field( 'omb_image', 'omb_image_nonce' );
		$metabox_html = <<<MEHEDI
<div class="fields">
	<div class="field_c">
		<div class="label_c">
			<label>Image</label>
		</div>
		<div class="input_c">
			<button id="upload_image" class="button">Upload Image</button>
			<input type="hidden" id="omb_image_id" name="omb_image_id" value={$image_id} >
			<input type="hidden" id="omb_image_url" name="omb_image_url" value={$image_url}>
			<div id="image-container"></div>
		</div>
		<div class="float_clear"></div>
	</div>

	

</div>
MEHEDI;
echo $metabox_html;
	}

	function omb_display_metabox($post) {
		$location = get_post_meta( $post->ID, 'omb_location', true );
		$country = get_post_meta( $post->ID, 'omb_country', true );
		$is_favorite = get_post_meta( $post->ID, 'omb_is_favorite', true );
		$checked = $is_favorite == 1 ? 'checked' : '';

		$saved_colors = get_post_meta( $post->ID, 'omb_clr', true );
		$saved_color = get_post_meta( $post->ID, 'omb_color', true );

		$label1 = __('Location', 'our-metabox');
		$label2 = __('Country', 'our-metabox');
		$label3 = __('Is Favorite', 'our-metabox');
		$label4 = __('Colors', 'our-metabox');

		$colors = ['red', 'green', 'blue', 'yellow', 'maagenta', 'pink', 'black'];

		wp_nonce_field( 'omb_location', 'omb_location_field' );
		$metabox_html = <<<MEHEDI
<div>
	<label for="omb_location">{$label1}</label>
	<input id="omb_location" name="omb_location" type="text" value="{$location}"/>

	<label for="omb_country">{$label2}</label>
	<input id="omb_country" name="omb_country" type="text" value="{$country}"/>

	<div>
		<label for="omb_is_favorite">{$label3}</label>
		<input id="omb_is_favorite" name="omb_is_favorite" type="checkbox" value="1" {$checked}/>
	</div>

	<div>
		<label>{$label4}</label>

</div>
MEHEDI;

	foreach ($colors as $color) {
		$checked = in_array($color, $saved_colors) ? 'checked' : '';
		$metabox_html .= <<<MEHEDI
<label for="omb_clr_{$color}">{$color}</label>
<input id="omb_clr_{$color}" name="omb_clr[]" type="checkbox" value="{$color}" {$checked} />
MEHEDI;
	}
	$metabox_html .= "</div>";

	$metabox_html .= <<<MEHEDI
	<div>
		<label>{$label4}</label>

MEHEDI;

	foreach ($colors as $color) {
		$checked = $color == $saved_color ? 'checked=checked' : '';
		$metabox_html .= <<<MEHEDI
<label for="omb_color_{$color}">{$color}</label>
<input id="omb_color_{$color}" name="omb_color" type="radio" value="{$color}" {$checked} />
MEHEDI;
	}

	$metabox_html .= "</div>";
	echo $metabox_html;
	}

	public function omb_load_textdomain() {
		load_plugin_textdomain( 'our-metabox', false, dirname( __FILE__ ).'/languages' );
	}
}


new OurMetaBox();