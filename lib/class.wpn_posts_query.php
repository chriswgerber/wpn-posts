<?php

/**
 * Class WPN_Posts_Query
 *
 * Used to query various data from the database. Extends the WPN_Posts_Data to prepare
 * the data in a way that can be used by the widget object.
 *
 */

Class WPN_Posts_Query implements WPN_Posts_Data {

	public $posts;

	public $settings;

	public $blogs;

	public function __construct() {
		// Get blog ids
		global $wpdb;
		$args = array(
			'network_id' => $wpdb->siteid,
			'public'     => null,
			'archived'   => null,
			'mature'     => null,
			'spam'       => null,
			'deleted'    => null,
			'limit'      => 50,
			'offset'     => 0,
		);

		if ( function_exists( 'wp_get_sites' ) ) {
			$this->blogs = wp_get_sites( $args );
		} else {
			$this->blogs = null;
		}

	}

	/**
	 * Gets the posts.
	 *
	 * Returns the posts as a "Post Object" similar to WP_Posts
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 *
	 *
	 * @return StdClass
	 */
	public function posts() {

		return new StdClass();
	}

	public function set_up_postdata() {

	}

	public function prep_posts() {

	}

	public function get_blogs(){

		return $this->blogs;
	}

	public function get_blog_list() {

	}

}