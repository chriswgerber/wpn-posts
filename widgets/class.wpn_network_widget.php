<?php
/**
 * Class WPN_Posts
 *
 * Handles the administration of the plugin.
 */

class WPN_Network_Widget extends WP_Widget {

	/**
	 * Instance of data
	 *
	 * @var array
	 */
	public $instance;

	/**
	 * Posts to be displayed
	 *
	 * @var WPN_Posts_Posts
	 */
	public $posts;

	/**
	 * Settings for posts to be displayed
	 * @var WPN_Posts_Network_Settings
	 */
	public $settings;

	/**
	 * I know the classes should be injected, but WordPress won't accept it so
	 * I'm going to have to instantiate new classes inside the constructor.
	 */
	public function __construct() {
		parent::__construct(
			'wpn_network_widget', // Base ID
			__( 'WPN - Network Posts', 'wpn-posts' ), // Name
			array( 'description' => __( 'Displaying Posts From Network', 'wpn-posts' ), ) // Args
		);
		$this->posts    = new WPN_Posts_Posts;
		$this->settings = new WPN_Posts_Network_Settings;
	}

	/**
	 * Displays Widget on Front End
	 *
	 * TODO Display Posts using Settings
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {

		echo $args['before_widget'];
		echo $args['before_title'];
		echo 'A widget will be displayed here.';
		echo $args['after_title'];
		echo "Content here";
		echo $args['after_widget'];

	}

	/**
	 * Form
	 *
	 * @param array $instance
	 *
	 * @return bool
	 */
	public function form( $instance ) {
		$this->settings->id_base = $this->id_base;
		$this->settings->number  = $this->number;
		$this->settings->values  = $instance;

		// Display some errors, if they exist
		WPN_Posts_Error::errors();

		// Form
		$this->settings->render_form();
	}

	/**
	 * Update
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array|bool
	 */
	public function update( $new_instance, $old_instance ) {

		return $this->settings->update_fields($new_instance);
	}

}