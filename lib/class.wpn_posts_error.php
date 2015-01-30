<?php

/**
 * Class WPN_Posts_Error
 *
 * Logs and displays errors with various WPN_Posts functions.
 */

class WPN_Posts_Error {

	/**
	 * Constant for referencing transient to display
	 */
	CONST ERROR_TRANSIENT = 'WPN_ERRORS';

	/**
	 * @var $errors array Array of errors.
	 */
	public $errors = array();


	/** Constructed with each error */
	public function __construct ( $message ) {
		$this->add_error( $message );
	}

	/**
	 * Called on First Error report
	 *
	 * @param $message string
	 */
	private function first_error( $message ) {

		$this->errors[] = $message;
		set_transient( self::ERROR_TRANSIENT, $this->errors, 1 * MINUTE_IN_SECONDS );
	}

	/**
	 * Add new error
	 *
	 * @param $message
	 * @param $errors
	 */
	private function append_error( $message ) {
		$this->errors[] = $message;
		set_transient( self::ERROR_TRANSIENT, $this->errors, 1 * MINUTE_IN_SECONDS );
	}

	/**
	 * Add Error
	 *
	 * @param $message
	 */
	public function add_error( $message ) {
		$this->errors = get_transient( self::ERROR_TRANSIENT );

		if ( $this->errors == null ) {
			$this->first_error( $message );
		} else {
			$this->append_error( $message );
		}
	}

	/**
	 *
	 * Returns errors and deletes transient
	 */
	public static function errors() {
		if ( WPN_DISPLAY_ERRORS && ( $errors = get_transient( self::ERROR_TRANSIENT ) ) ) {

			echo '<div class="errors"><ul>';
			foreach ( $errors as $error ) {
				echo '<li class="error">' . $error . '</li>';
			}
			echo '</ul></div>';

			delete_transient( self::ERROR_TRANSIENT );

		}

	}

}