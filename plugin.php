<?php
/*
Plugin Name: Network Posts
Plugin URI: http://github.com/thatgerber/wpn-posts
Description: Display the latest posts from the blogs in your network using a widget.
Version: 0.0.1
Author: Chris W. Gerber
Author URI: http://www.chriswgerber.com/
 */

if ( !defined('WPN_DISPLAY_ERRORS') ) {
	define('WPN_DISPLAY_ERRORS', TRUE);
}

include( 'class.wpn_posts.php' );

new WPN_Posts;