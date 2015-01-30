<?php

class WPN_Posts_Error {

	/**
	 * Constant for referencing transient to display
	 */
	CONST ERROR_TRANSIENT = 'WPN_ERRORS';

	/**
	 * @var $errors array Array of errors.
	 */
	public $errors = array();


	public function __construct ($message) {

		$this->errors[] = $message;



	}



}