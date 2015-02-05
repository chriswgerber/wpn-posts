<?php

/**
 * Abstract Class WPN_Posts_Fields
 *
 * Creates a standard set of fields for creating widget settings
 */

abstract class WPN_Posts_Fields {

	/**
	 * @var $id_base string
	 */
	public $id_base;

	/**
	 * @var $number int
	 */
	public $number;

	/**
	 * @var $fields array
	 */
	public $fields;

	/**
	 * @var $values array
	 */
	public $values;

	/**
	 * render_form
	 *
	 * @param $fields null|array
	 *
	 * @return mixed
	 */
	abstract public function render_form( $fields );

	/**
	 * update_fields
	 *
	 * @param $values
	 *
	 * @return mixed
	 */
	abstract public function update_fields( $values );

	/**
	 * create_field
	 *
	 * @param $field array
	 */
	public function create_field( $field ) {

		// Validate Field //
		if ( $this->validate_field( $field ) === false ) {
			return;
		}

		/**
		 * Create Field
		 *
		 * Inputs field [ type ] as the function to run, then just feeds in the rest of the variable as values
		 *
		 * Can accept any created input, though a function must be created for each one, or overwritten.
		 *
		 */

		$fn = $field['type'];

		$this->{$fn}( $field );

	}

	/**
	 * Checks if the field is valid before feeding it into the control module.
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public function validate_field($field) {

		$fn = $field['type'];
		$cb = $field['validate'];

		if ( ! isset( $fn ) ) {

			new WPN_Posts_Error( 'There is an error with Field ID <code>' . $field['id'] . '</code>.');
			return false;

		} elseif ( !method_exists( $this, $fn ) ) {

			$error = 'Error: Field ID <code>' . $field['id'] .
			         '</code>:  field type does not exist. Type = "' . $fn . '"';

			new WPN_Posts_Error( $error );
			return false;

		} elseif ( $cb == null && $field['type'] !== 'header' ) {

			new WPN_Posts_Error( 'There is an error with Field ID <code>' . $field['id'] . '</code>. No validation callback set.');
			return false;

		}
		return true;
	}

	/**
	 * field_header
	 *
	 * Prints a field header
	 *
	 * @param $field array  [ Text ] to print in header
	 *                      [ id ] for text ID
	 */
	public function header( $field ) {
		$text = $field['label'];
		$id   = $field['id'];

		?>
		<hr xmlns="http://www.w3.org/1999/html"/>
		<h3 id="<?php echo $id; ?>"><?php printf( __( '%1$s', 'wpn-posts' ), $text ); ?></h3>
		<?php

	}

	/**
	 * Creates Text Form Field
	 *
	 * @param $field array  id    string     ID of the field
	 *                      name  string     Name of the Field Value
	 *                      label string     Name of Label
	 *                      value string|int Value of the field
	 */
	public function text_line( $field ){

		/** Chose not to use explode() to manage variables being used */
		$id    = $this->get_field_id( $field['id'] );
		$name  = $this->get_field_name( $field['id'] );
		$label = $field['label'];
		$value = $this->values[$field['id']];

		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $label ); ?>
			</label>
			<br/>
			<input type='text'
			       id="<?php echo $id; ?>"
			       name="<?php echo $name; ?>"
			       value="<?php echo $value; ?>"/>
		</p>
	<?php

	}

	/**
	 * Creates Text Area Field
	 *
	 * @param $field array  id    string     ID of the field
	 *                      name  string     Name of the Field Value
	 *                      label string     Name of Label
	 *                      value string|int Value of the field
	 */
	public function text_area( $field ){

		/** Chose not to use explode() to manage variables being used */
		$id    = $this->get_field_id( $field['id'] );
		$name  = $this->get_field_name( $field['id'] );
		$label = $field['label'];
		$value = $this->values[$field['id']];

		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $label ); ?>
			</label>
			<br/>
			<textarea
			       id="<?php echo $id; ?>"
			       name="<?php echo $name; ?>"><?php esc_attr_e($value, 'wpn-posts'); ?></textarea>
		</p>
	<?php

	}

	/**
	 * Creates a Select Field
	 *
	 * @param $field array  $id      string
	 *                      $name    string
	 *                      $label   string
	 *                      $options array
	 *                      $value   string
	 */
	public function select( $field ) {

		/** Chose not to use explode() to manage variables being used */
		$id      = $this->get_field_id( $field['id'] );
		$name    = $this->get_field_name( $field['id'] );
		$label   = $field['label'];
		$options = $field['options'];
		$value   = $this->values[$field['id']];
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $label ); ?>
			</label>
			<br/>

			<select id="<?php echo $id; ?>" name="<?php echo $name; ?>">
				<?php $this->select_options($options, $value); ?>
			</select>

			<br/>
		</p>
		<?php
	}


	/**
	 * Create group of < option > for select tag
	 *
	 * @param $options array
	 * @param $value   string
	 */
	public function select_options( $options, $value ) {

		foreach ( $options as $option ) {
			if ($option['value'] == $value ) {
				$selected = 'selected';
			} else {
				$selected = false;
			}
			?>
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'wpn-posts' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $option['name'] ); ?>
			</option>
		<?php }

	}

	/**
	 * Creates a Select Field
	 *
	 * @param $field array  $id      string
	 *                      $name    string
	 *                      $label   string
	 *                      $options array
	 *                      $value   array
	 */
	public function select_multiple( $field ) {

		/** Chose not to use explode() to manage variables being used */
		$id      = $this->get_field_id( $field['id'] );
		$name    = $this->get_field_name( $field['id'] );
		$label   = $field['label'];
		$options = $field['options'];
		$value   = $this->values[$field['id']];
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $label ); ?>
			</label>
			<br/>

			<select id="<?php echo $id; ?>" name="<?php echo $name; ?>[]" multiple="multiple">
				<?php $this->select_multi_options($options, $value); ?>
			</select>

			<br/>
		</p>
	<?php
	}

	/**
	 * Create group of < option > for select tag
	 *
	 * @param $options array
	 * @param $value   string
	 */
	public function select_multi_options( $options, $value ) {

		foreach ( $options as $option ) {
			if ( in_array( $option['value'], $value ) ) {
				$selected = 'selected';
			} else {
				$selected = false;
			}
			?>
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'wpn-posts' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $option['name'] ); ?>
			</option>
		<?php }

	}

	/**
	 * Copy of WP_Widget::get_field_name. Gets the field name for a form object.
	 *
	 * @param $field_name
	 *
	 * @return string
	 */
	public function get_field_name( $field_name ) {

		return 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
	}

	/**
	 * Copy of WP_Widget::get_field_id
	 *
	 * @param $field_name
	 *
	 * @return string
	 */
	public function get_field_id( $field_name ) {

		return 'widget-' . $this->id_base . '-' . $this->number . '-' . $field_name;
	}

}