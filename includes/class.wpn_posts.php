<?php
/**
 * Class WPN_Posts
 *
 * Handles the administration of the plugin.
 */

class WPN_Posts {

	/**
	 * @var string $plugin_id
	 *
	 * ID for plugin
	 */
	public $plugin_id = 'wpn_posts';

	/**
	 * @var string $plugin_name
	 *
	 * Front-End display of plugin name
	 */
	public $plugin_name = 'Network Posts';

	/**
	 * @var string $description
	 *
	 * Description of functionality
	 */
	public $description = 'Create layouts for posts from a WordPress network.';

	/** Get it started */
	public function __construct( ) { }

	public function activate_plugin() {

	}

	public function deactivate_plugin() {

	}

	public function register_shortcode() {

	}

	public function register_widgets() {
		// Names of Widgets
		$widgets = array(
			'wpn_network_widget'
		);

		foreach ( $widgets as $widget ) {
			register_widget($widget);
		}

	}

	public function file_includes() {

	}

}