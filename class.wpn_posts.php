<?php
/**
 * Class WPN_Posts
 *
 * Handles the administration of the plugin.
 *
 * @link  http://www.chriswgerber.com/wpn-posts
 * @since 0.1.0
 *
 * @package    WordPress
 * @subpackage WPN Posts
 */

class WPN_Posts {

	/**
	 * Plugin ID
	 *
	 * @since  0.1.0
 	 * @access public
	 * @var string $plugin_id ID for plugins
	 */
	public $plugin_id = 'wpn_posts';

	/**
	 * Plugin Name
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string $plugin_name Name of the plugin
	 */
	public $plugin_name = 'Network Posts';

	/**
	 * Description
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string $description Description of the plugin
	 */
	public $description = 'Create layouts for posts from a WordPress network.';

	/**
	 * Constructs WPN Posts
	 *
	 * This will construct and initiate the plugin. Everything else is handled elsewhere, but it begins here.
	 * I guess that technically makes this a factory, but because it instantiates everything, I refrain from
	 * calling it that.
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function __construct( ) {
		// Files that need to be included. No Namespaces to keep with PHP 5.2.4
		$this->file_includes();

		add_action( 'widgets_init', array($this, 'register_widgets') );

	}

	/**
	 * Get plugin dir
	 *
	 * Returns the plugin dir. Made static to be accessible anywhere.
	 *
	 * @since  0.1.0
	 * @access public
	 *
	 * @return string Directory of the Plugin
	 */
	public static function get_dir() {

		return dirname(__FILE__);
	}

	/**
	 * Actions to be run on plugin activate.
	 *
	 * Hook in various actions to be run when the plugin is activated.
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function activate_plugin() { }

	/**
	 * Actions to be run on plugin deactivate.
	 *
	 * Hook in various actions to be run when the plugin is deactivated.
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function deactivate_plugin() { }

	/**
	 * Registers any shortcode that is used.
	 *
	 * This will hook into the register shortcode action, so any shortcodes that need to be run should be added
	 * in during this function.
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function register_shortcode() { }

	/**
	 * Registers widgets in WordPress
	 *
	 * Takes an array of Widget names (named after the class that's being activated) and reigsters them to run.
	 * This function hooks into the `widgets_init` to be properly hooked.
	 *
	 * @since  0.1.0
	 * @access public
	 */
	public function register_widgets() {
		// Names of Widgets
		$widgets = array(
			'wpn_network_widget',

		);

		foreach ( $widgets as $widget ) {
			register_widget($widget);
		}

	}

	/**
	 * Includes various files used to create the widgets.
	 *
	 * Run any file includes through here so that they're centrally accessed.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function file_includes() {
		// Filenames
		$lib = 'lib/';
		$wgt = 'widgets/';

		/**
		 * We'll see if we need these or not...
		 */
		include( $lib . 'interface.wpn_posts_data.php' );
		// include( $lib . 'interface.wpn_posts_form.php' );

		/**
		 * Template for display factories
		 */
		include( $lib . 'abstract.wpn_posts_factory.php' );

		/**
		 * Template for creating widget forms/settings
		 */
		include( $lib . 'abstract.wpn_posts_fields.php' );

		/**
		 * Other classes
		 */
		include( $lib . 'class.wpn_posts_display.php' );
		include( $lib . 'class.wpn_posts_error.php' );
		include( $lib . 'class.wpn_posts_form.php' );
		include( $lib . 'class.wpn_posts_network_factory.php' );
		include( $lib . 'class.wpn_posts_network_settings.php' );
		include( $lib . 'class.wpn_posts_posts.php' );
		include( $lib . 'class.wpn_posts_query.php' );
		include( $lib . 'class.wpn_posts_template.php' );
		include( $lib . 'class.wpn_posts_view.php' );

		// Widgets
		include( $wgt . 'class.wpn_network_widget.php' );

	}

}