<?php

/**
 * @Author: mehedi
 * @Date:   2019-09-13 23:47:09
 * @Last Modified by:   mehedi
 * @Last Modified time: 2019-09-16 17:03:01
 */
/**
 * Plugin Name: MH Word Count
 * Description: Count how many word in a post or page
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: mh-word-count
 * Domain Path: /languages/
 */


function wordcount_load_textdomain() {
	load_plugin_textdomain( 'mh-word-count', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'wordcount_load_textdomain' );

function wordcount_count_words($content) {
	$stripped_content = strip_tags($content);
	$words = str_word_count($stripped_content);
	$label = __( 'Total number of words', 'mh-word-count' );

	$label = apply_filters( 'wordcount_heading', $label );
	$tag = apply_filters( 'wordcount_tag', 'h2' );

	$content .= sprintf('<%s>%s: %s</%s>', $tag, $label, $words, $tag);
	return $content;
}

add_filter( 'the_content', 'wordcount_count_words' );


function wordcount_reading_time($content) {
	$stripped_content = strip_tags($content);
	$words = str_word_count($content);
	$reading_minute = floor($words / 200);
	$reading_seconds = ceil($words % 200 / (200 / 60));
	$is_visible = apply_filters( 'wordcount_display_reading_time', 1);
	if($is_visible) {
		$label = __('Total Reading Time');
		$label = apply_filters( 'wordcount_reading_time_heading', $label );

		$tag = 'h4';
		$tag = apply_filters( 'wordcount_reading_time_tag', $tag );
		
		$content .= sprintf('<%s>%s: %s minutes %s seconds</%s>', $tag, $label, $reading_minute, $reading_seconds, $tag);
	}
	return $content;
}

add_filter( 'the_content', 'wordcount_reading_time' );
