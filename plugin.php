<?php
/*
Plugin Name: Network Posts
Plugin URI: http://github.com/thatgerber/wpn-posts
Description: Display the latest posts from the blogs in your network using a widget.
Version: 0.0.1
Author: Chris W. Gerber
Author URI: http://www.chriswgerber.com/
 */

/** Define error logging */
if ( !defined('WPN_POSTS_ERRORS') ) {
	define( 'WPN_DISPLAY_ERRORS', TRUE );
}

// include( 'network-latest-posts.php' );

include 'includes/class.wpn_posts.php';
// Interfaces
include 'includes/interface.wpn_posts_data.php';
include 'includes/interface.wpn_posts_form.php';
// Classes and abstracts
include 'includes/abstract.wpn_posts_fields.php';
include 'includes/abstract.wpn_posts_validation.php';
include 'includes/class.wpn_posts_display.php';
include 'includes/class.wpn_posts_error.php';
include 'includes/class.wpn_posts_form.php';
include 'includes/class.wpn_posts_form_data.php';
include 'includes/class.wpn_posts_posts.php';
include 'includes/class.wpn_posts_query.php';
include 'includes/class.wpn_posts_network_settings.php';
include 'includes/class.wpn_posts_network_validate.php';
include 'includes/class.wpn_posts_view.php';
// Widgets
include 'widgets/class.wpn_network_widget.php';

$wpn_posts = new WPN_Posts;

/** Add Widget */
add_action( 'widgets_init', array($wpn_posts, 'register_widgets') );