<?php

/**
 * @Author: Coder-Mehedi
 * @Date:   2019-09-17 13:12:06
 * @Last Modified by:   Coder-Mehedi
 * @Last Modified time: 2019-09-29 16:08:37
 */
/**
 * Plugin Name: TinySlider
 * Description: slider
 * Plugin URI: http://#
 * Author: Mehedi Hasan
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: tinyslider
 * Domain Path: /languages/
 */


function tslider_laod_textdomain() {
	load_plugin_textdomain( 'tinyslider', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'tslider_laod_textdomain' );


function tslider_init() {
	add_image_size( 'tiny-slider', 800, 600, true );
}

add_action( 'init', 'tslider_init' );


function tslider_assets() {
	wp_enqueue_style( 'tinyslider-css', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css', null, '1.0', 'all' );
	wp_enqueue_script( 'tinyslider-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, '1.0', true );
	wp_enqueue_script( 'tinyslider-main-js', plugin_dir_url( __FILE__ ).'/assets/js/main.js', array('jquery'), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'tslider_assets' );



function tslider_shortcode_tslider($args, $content) {
	$default = array(
		'width' => 800,
		'height' => 600,
		'id' => ''
	);
	$attr = shortcode_atts( $default, $args );

	$content = do_shortcode( $content );

	$shortcode_output = <<<EOD
<div id="height: {$attr['height']}" style="height: {$attr['height']}; width: {$attr['width']}">
	<div class="slider">
		{$content}
	</div>
</div>
EOD;

	return $shortcode_output;

}
add_shortcode( 'tslider', 'tslider_shortcode_tslider' );


function tslider_shortcode_tslide($args) {
	$default = array(
		'caption' => '',
		'id' => '',
		'size' => 'large'
	);
	$attributes = shortcode_atts( $default, $args );
	$image_src = wp_get_attachment_image_src( $attributes['id'], $attributes['size'] );

	$shortcode_output = <<<EOD
<div>
	<p><img src="{$image_src[0]}" alt="{$attributes['caption']}"></p>
	<p>{$attributes['caption']}</p>
</div>
EOD;

	return $shortcode_output;
}

add_shortcode( 'tslide', 'tslider_shortcode_tslide' );