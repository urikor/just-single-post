<?php
/**
 * Plugin Name: Just Single Post
 * Plugin URI: http://www.just-single-post.com/
 * Description: Displays chosen post in sertain way.
 * Version: 1.0.0
 * Author: Yuriy Korzhov
 * Author URI: http://www.urikor.com/
 * License: GPL2
 * Copyright: Yuriy Korzhov
 *
 * @package Wordpress
 */

require_once plugin_dir_path( __FILE__ ) . 'widget/jsp-widget.php';

/**
 * Register styles for JSP widget.
 */
function jsp_enqueue_styles() {
	if ( is_singular( array( 'post', 'page' ) ) && get_post_meta( get_the_ID(), true ) !== '' ) {
		wp_enqueue_style( 'jsp-widget-front', plugin_dir_url( __FILE__ ) . 'widget/css/layout.css', array(), '1.0.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'jsp_enqueue_styles' );

/**
 * Queue admin scripts and styles.
 */
function jsp_enqueue_scripts() {
	wp_enqueue_script( 'jsp-admin-script', plugin_dir_url( __FILE__ ) . 'widget/js/jsp.js', array(), '1.0.0' );
	wp_localize_script( 'jsp-admin-script', 'ajax_object', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);

	wp_enqueue_style( 'jsp-widget-admin', plugin_dir_url( __FILE__ ) . 'widget/css/admin.css', array(), '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'jsp_enqueue_scripts' );

function auto_post_ajax_callback() {

	global $wpdb;

	$search = $_POST['choose_post'];

	$posts = $wpdb->get_results( "
		SELECT ID, post_title FROM wp_posts
		WHERE post_status = 'publish'
		AND post_title LIKE '{$search}%'
		AND post_title != ''
		LIMIT 15
		" );

	if ( $posts ) {
		echo '<ul>';
		foreach ( $posts as $post ) {
			echo '<li data-id="' . esc_html( $post->ID ) . '">' .
			     esc_html( $post->post_title ) . ' (post ID: ' . esc_html( $post->ID ) . ')
			     </li>';
		}
		echo '</ul>';
	}
	wp_reset_postdata();

	wp_die();
}
add_action( 'wp_ajax_auto_post', 'auto_post_ajax_callback' );
