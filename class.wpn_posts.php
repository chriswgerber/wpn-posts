<?php
/**
 * Class WPN_Posts
 *
 * Handles the administration of the plugin.
 */

class WPN_Posts {

	public $plugin_id = 'wpn_posts';

	public $plugin_name = 'Network Posts';

	public $description = 'Create layouts for posts from a WordPress network.';

	public $defaults = array();

	public $fields = array();

	public function __construct( ) {
		$this->file_includes();

		add_action( 'widgets_init', array($this, 'register_widgets') );

	}

	public function activate_plugin() {

	}

	public function deactivate_plugin() {

	}

	public function scripts_styles() {

		// If Custom CSS
		if ( ! empty( $css_style ) ) {
			// If RTL
			if ( is_rtl() ) {
				// Tell WordPress this plugin is switching to RTL mode
				/* Set the text direction to RTL
				 * This two variables will tell load-styles.php
				 * load the Dashboard in RTL instead of LTR mode
				 */
				global $wp_locale, $wp_styles;
				$wp_locale->text_direction = 'rtl';
				$wp_styles->text_direction = 'rtl';
			}
			// File path
			$cssfile = get_stylesheet_directory_uri() . '/' . $css_style . '.css';
			// Load styles
			nlp_load_styles( $cssfile );
		}

	}

	public function register_shortcode() {

	}

	public function register_widgets() {
		register_widget('WPN_Posts_Widget');
	}

	public function file_includes() {
		include( 'lib/interface.wpn_posts_form.php' );

		include( 'network-latest-posts.php' );
		include( 'class.wpn_posts_widget.php' );
		include( 'lib/class.wpn_posts_view.php' );
		include( 'lib/class.wpn_posts_blogs.php' );
		include( 'lib/class.wpn_posts_fields.php' );

		//$blogs = new WPN_Posts_Blogs($this);

		$fields = new WPN_Posts_Fields;

		new WPN_Posts_Widget( $fields, $this );

	}

}