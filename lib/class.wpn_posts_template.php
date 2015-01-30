<?php
/**
 * Class WPN_Posts_Template
 *
 * Handles which templates are used.
 *
 * @link  http://www.chriswgerber.com/wpn-posts
 * @since 0.1.0
 *
 * @package    WordPress
 * @subpackage WPN Posts
 */

class WPN_Posts_Template {

	/**
	 * Theme Template Directory
	 *
	 * @since  0.1.0
	 * @access public
	 * @var string $template_dir Directory of the template files in themes.
	 */
	private $template_dir = 'wpn-posts/';

	/**
	 * Plugin Template Directory
	 *
	 * @since  0.1.0
	 * @access public
	 * @var string $template_dir Directory of the default template files within the plugin.
	 */
	private $plugin_dir = '/templates/';

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function __construct() { }

	/**
	 * Gets the template part to be used.
	 *
	 * Will grab a template part to be used in the display. Will search three directories:
	 *     Child Theme   (`get_stylesheet_directory() . 'wpn-posts/'`)
	 *     Parent Theme  (`get_template_directory() . 'wpn-posts/`)
	 *     Plugin Folder (`'wpn-posts/templates/'`)
	 *
	 * If it can't find a file to use instead in any of those directories, then it will default to
	 * using the file included in the plugin. Relies on WPN_Posts for the "Get_Dir" command.
	 *
	 * @since  0.1.0
	 * @access public
	 * @see    locate_template, load_template, WPN_Posts::get_dir
	 *
	 * @param string $name Name of template to return
	 *
	 * @return string
	 */
	public function get_template_part( $name ) {

		if ( $overridden_template = locate_template( $this->template_dir . $name ) ) {
			// locate_template() returns path to file
			// if either the child theme or the parent theme have overridden the template
			load_template( $overridden_template );
		} else {
			// If neither the child nor parent theme have overridden the template,
			// we load the template from the 'templates' sub-directory of the directory this file is in
			load_template( WPN_Posts::get_dir() . $this->plugin_dir . $name );
		}

	}

}