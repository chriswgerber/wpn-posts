<?php
/**
 * WPN Posts Network Factory
 *
 * Used to create the display of a network posts widget.
 *
 * @link  http://www.chriswgerber.com/wpn-posts
 * @since 0.1.0
 *
 * @package    WordPress
 * @subpackage WPN Posts
 */

class WPN_Posts_Network_Factory extends WPN_Posts_Factory_Template {

	public $data;

	/**
	 * Constructor
	 *
	 * Everything should be run through the constructor. It's a factory!
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 */
	public function __construct( ) {

		$data = new WPN_Posts_Query();
		$this->posts = $data->posts();

	}

	/**
	 *
	 */
	public function render() { }

	/**
	 *
	 */
	public function get_data() { }

	/**
	 *
	 */
	public function get_template() {

	}

}