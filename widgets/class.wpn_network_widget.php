<?php
/**
 * WPN Network Widget
 *
 * Creates a widget using data from a WordPress network. Data is generated using MySQL.
 *
 * @link  http://www.chriswgerber.com/wpn-posts
 * @since 0.0.1
 *
 * @package    WordPress
 * @subpackage WPN Posts
 */

class WPN_Network_Widget extends WP_Widget {

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
	public function __construct( ) {
		$this->settings = new WPN_Posts_Network_Settings;
		$this->widget   = new WPN_Posts_Network_Factory;

		parent::__construct(
			'wpn_network_widget', // Base ID
			__( 'WPN - Network Posts', 'wpn-posts' ), // Name
			array( 'description' => __( 'Displaying Posts From Network', 'wpn-posts' ), ) // Args
		);
	}

	/**
	 * Displays Widget on Front End
	 *
	 * TODO Display Posts using Settings
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		echo $args['before_title'];
		echo 'Network Posts Widget';
		echo $args['after_title'];
		$this->widget->render();
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
		// Base ID
		$this->settings->id_base = $this->id_base;
		// Instance Number
		$this->settings->number  = $this->number;
		// Instance Values
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