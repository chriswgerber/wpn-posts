<?php
/**
 * WPN Posts Display Factory
 *
 * This factory is used to create the display for the widget. Takes data and
 * builds the widget according to where things are and how they work. This is
 * not used explicitly and instead used as a template for future displays and
 * views.
 *
 * @link  http://www.chriswgerber.com/wpn-posts
 * @since 0.1.0
 *
 * @package    WordPress
 * @subpackage WPN Posts
 */

abstract class WPN_Posts_Factory_Template {

	public $posts;

	public $settings;

	/**
	 * Builds the widget.
	 *
	 * Takes posts and settings and creates something fancy.
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 * @return mixed
	 */
	abstract public function render();

	/**
	 * Builds the template.
	 *
	 * Determines what templates to use and what to do with it.
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 * @return mixed
	 */
	abstract public function get_template();

	/**
	 * Returns post data from source
	 *
	 * Returns an object containing all of the post objects.
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 * @return mixed
	 */
	abstract public function get_data();

	public function styles() { }

	public function blocks() { }

	public function organized_list() { }

	public function unorganized_list() { }

}