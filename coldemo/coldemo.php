<?php

/**
 * @Author: Coder-Mehedi
 * @Date:   2019-09-18 13:37:44
 * @Last Modified by:   Coder-Mehedi
 * @Last Modified time: 2019-09-18 16:23:24
 */
/**
 * Plugin Name: Column Demo
 * Description: Adding and removing column in posts dashboard
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: coldemo
 * Domain Path: /languages/
 */


function coldemo_bootstrap() {
	load_plugin_textdomain( 'coldemo', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'coldemo_bootstrap' );


function coldemo_manage_posts_columns($columns) {
	print_r($columns);
	unset($columns['comments']);
	unset($columns['tags']);
	$columns['id'] = __('Post ID', 'coldemo');
	$columns['thumbnail'] = __('Thumbnail', 'coldemo');
	$columns['wordcount'] = __('Word Count', 'coldemo');
	return $columns;
}
add_filter( 'manage_posts_columns', 'coldemo_manage_posts_columns');
add_filter( 'manage_pages_columns', 'coldemo_manage_posts_columns');


function coldemo_posts_column_id_data($column, $post_id) {
	if ($column == 'id') {
		echo $post_id;  
	} elseif ($column == 'thumbnail') {
		$thumbnail = get_the_post_thumbnail( $post_id, array(150,150) );
		echo $thumbnail;
	} elseif ($column == 'wordcount') {
		$_post = get_post( $post_id );
		$content = $_post->post_content;
		$wordn = str_word_count(strip_tags($content));
		echo $wordn;
	}
}
add_action( 'manage_posts_custom_column', 'coldemo_posts_column_id_data', 10, 2 );
add_action( 'manage_pages_custom_column', 'coldemo_posts_column_id_data', 10, 2 );


function coldemo_sortable_column($columns) {
	$columns['wordcount'] = 'wordn';
	return $columns;
}
// add_filter( 'manage_edit-post_sortable_columns', 'coldemo_sortable_column' );