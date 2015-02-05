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
	public function __construct( ) {
	// Files that need to be included. No Namespaces to keep with PHP 5.2.4
		$this->file_includes();

		add_action( 'widgets_init', array($this, 'register_widgets') );

	}

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
		// Filenames
		$lib = 'lib/';
		$wgt = 'widgets/';

		// include( 'network-latest-posts.php' );

		// Interfaces
		include( $lib . 'interface.wpn_posts_data.php' );
		include( $lib . 'interface.wpn_posts_form.php' );

		// Classes and abstracts
		include( $lib . 'abstract.wpn_posts_fields.php' );
		include( $lib . 'abstract.wpn_posts_validation.php' );
		include( $lib . 'class.wpn_posts_display.php' );
		include( $lib . 'class.wpn_posts_error.php' );
		include( $lib . 'class.wpn_posts_form.php' );
		include( $lib . 'class.wpn_posts_form_data.php' );
		include( $lib . 'class.wpn_posts_posts.php' );
		include( $lib . 'class.wpn_posts_query.php' );
		include( $lib . 'class.wpn_posts_network_settings.php' );
		include( $lib . 'class.wpn_posts_network_validate.php' );
		include( $lib . 'class.wpn_posts_view.php' );

		// Widgets
		include( $wgt . 'class.wpn_network_widget.php' );

	}

}