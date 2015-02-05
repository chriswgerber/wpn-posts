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

/** Main file */
include( 'class.wpn_posts.php' );

// Wee
new WPN_Posts;