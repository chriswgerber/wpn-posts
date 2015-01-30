<?php

/**
 * Interface WPN_Posts_Fields
 *
 * Creates a standard set of fields for creating widget settings
 */

abstract class WPN_Posts_Fields {

	/**
	 * Need to create a form to display it!
	 */
	abstract public function form( $fields );

	/**
	 * field_header
	 *
	 * Prints a field header
	 *
	 * @param $args
	 */
	public function field_header( $text ) {
		?>
		<h3><?php printf( __( '%1$s', 'trans-nlp' ), $text ); ?></h3>
		<hr />
	<?php
	}

	/**
	 * Creates Text Form Field
	 *
	 * TODO: Clean up documentation
	 *
	 * @param
	 *              ID    = Field ID
	 *              Name  = Field Name
	 *              Value = String
	 */
	public function text_form_field( $id, $name, $fieldname, $value ){
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $name ); ?>
			</label>
			<br/>
			<input type='text'
			       id="<?php echo $id; ?>"
			       name="<?php echo $fieldname; ?>"
			       value="<?php echo $value; ?>"/>
		</p>
	<?php

	}

	/**
	 * Creates Select Field
	 *
	 * @param array $args
	 * @param bool  $single
	 */
	public function select_form_field( $id, $single = true, $fieldname ) {
		$fieldname     = ( $single !== true ? $id . '[]' : $id );
		$multiple = ( $single !== true ? $name . ' multiple="multiple"' : $name );
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $args['name'] ); ?>
			</label>
			<br/>
			<?php if ( $single !== true ) : ?>
				<select id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php echo $multiple; ?>>
					<?php $this->select_multi_options($args['options'], $value); ?>
				</select>
			<?php else: ?>
				<select id="<?php echo $id; ?>" name="<?php echo $name; ?>">
					<?php $this->select_options($args['options'], $value); ?>
				</select>
			<?php endif; ?>
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
	public function select_options($options, $value) {

		if ($options[0]['name'] === 'Blog List') {
			$options = $this->list_of_blogs( $options[0][ 'default' ] );
		}

		foreach ( $options as $option ) {
			if ($option['value'] == $value ) {
				$selected = 'selected';
			} else {
				$selected = false;
			}
			?>
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'trans-nlp' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $option['name'] ); ?>
			</option>
		<?php }

	}

	/**
	 * Create group of < option > for select tag
	 *
	 * @param $options array
	 * @param $value   string
	 */
	public function select_multi_options($options, $value) {

		if ($options[0]['name'] === 'Blog List') {
			$options = $this->list_of_blogs( $options[0][ 'default' ] );
		}

		foreach ( $options as $option ) {
			if ( in_array($option['value'],$value) ) {
				$selected = 'selected';
			} else {
				$selected = false;
			}
			?>
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'trans-nlp' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $option['name'] ); ?>
			</option>
		<?php }

	}


	public function validate_field($field) {
		if ( ! isset( $field['type'] ) ) {
			new WPN_Posts_Error( 'Field ID <code>' . $field['id'] . '</code> is not set.');
		}
		if ( ! function_exists($this->{$field['type']}) ) {
			new WPN_Posts_Error( 'Field ID <code>' . $field['id'] . '</code> is not set.');
		}

		return true;

	}

}