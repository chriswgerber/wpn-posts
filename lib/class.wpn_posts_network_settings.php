<?php
/**
 * Class WPN_Posts_Settings
 *
 * Creates the settings for this widget
 *
 * TODO: Recreate $fields arrays as objects.
 */

class WPN_Posts_Network_Settings extends WPN_Posts_Fields {

	/** @var array Fields to display */

	public $fields = array(
		array(
			'type'  => 'header',
			'id'    => 'header_title',
			'label' => 'General Settings',
		),
		array(
			'type'     => 'text_line',
			'id'       => 'title',
			'label'    => 'Title',
			'validate' => 'strip_tags'
		),
		array(
			'type'    => 'select',
			'id'      => 'display_type',
			'label'   => 'Display Type',
			'options' => array(
				array(
					'name'  => 'Blocks',
					'value' => 'block'
				),
				array(
					'name'  => 'Unordered List',
					'value' => 'ulist'
				),
				array(
					'name'  => 'Ordered List',
					'value' => 'olist'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'header',
			'id'    => 'blogs_header',
			'label' => 'Posts'
		),
		array(
			'type'    => 'select_multiple',
			'id'      => 'blog_id',
			'label'   => 'Blog(s) to Display',
			'options' => array(
				array(
					'name'    => 'Blog List',
					'default' => 'Display All'
				)
			),
			'validate' => 'exists_in_multi_select'
		),
		array(
			'type'    => 'select_multiple',
			'id'      => 'ignore_blog',
			'label'   => 'Blog(s) to Ignore',
			'options' => array(
				array(
					'name'    => 'Blog List',
					'default' => 'Nothing to Ignore'
				)
			),
			'validate' => 'exists_in_multi_select'
		),
		array(
			'type' => 'select',
			'id'    => 'sort_by_blog',
			'label'  => 'Sort by Blog ID',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 0
				),
				array(
					'name' =>  'Yes',
					'value' => 1
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'select',
			'id'    => 'sorting_order',
			'label'  => 'Sorting Order',
			'options' => array(
				array(
					'name' =>  'Newest to Oldest',
					'value' => 'newer'
				),
				array(
					'name' => 'Oldest to Newest',
					'value' => 'older'
				),
				array(
					'name' => 'Ascending',
					'value' => 'asc'
				),
				array(
					'name' => 'Descending',
					'value' => 'desc'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'custom_post_type',
			'label'  => 'Custom Post Types',
			'validate' => 'strip_tags',
		),
		array(
			'type'  => 'text_line',
			'id'    => 'category',
			'label'  => 'Category(ies)',
			'validate' => 'strip_tags'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'tag',
			'label'  => 'Tag(s)',
			'validate' => 'strip_tags'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'post_limit',
			'label'  => 'Total Number of Posts',
			'validate' => 'int'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'posts_per_blog',
			'label' => 'Max Posts for each blog',
			'validate' => 'int'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'time_frame',
			'label' => 'Time Frame (in Days)',
			'validate' => 'int'
		),
		array(
			'type' => 'select',
			'id'    => 'honor_sticky',
			'label'  => 'Honor Sticky Posts',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'header',
			'id' => 'thumbnails_header',
			'label'  => 'Thumbnails',
		),
		array(
			'type' => 'select',
			'id'    => 'thumbnail',
			'label'  => 'Display Thumbnails',
			'options' => array(
				array(
					'name' =>  'Show',
					'value' => 'true'
				),
				array(
					'name' => 'Hide',
					'value' => 'false'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_w',
			'label'  => 'Thumbnail Width',
			'validate' => 'int'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_h',
			'label'  => 'Thumbnail Height',
			'validate' => 'int'
		),
		array(
			'type' => 'select',
			'id'    => 'thumbnail_filler',
			'label'  => 'Thumbnail Replacement',
			'options' => array(
				array(
					'name' =>  'Placeholder',
					'value' => 'placeholder'
				),
				array(
					'name' => 'Kittens',
					'value' => 'kittens'
				),
				array(
					'name' => 'Puppies',
					'value' => 'puppies'
				),
				array(
					'name' => 'Custom',
					'value' => 'custom'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_url',
			'label'  => 'Custom Thumbnail URL',
			'validate' => 'strip_tags'
		),
		array(
			'type' => 'select',
			'id'    => 'thumbnail_custom',
			'label'  => 'Custom Thumbnail',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_field',
			'label'  => 'Thumbnail Custom Field',
			'validate' => 'strip_tags',
		),
		array(
			'type' => 'header',
			'id' => 'layout_header',
			'label'  => 'Layout'
		),
		array(
			'type' => 'select',
			'id'    => 'paginate',
			'label'  => 'Paginate',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'posts_per_page',
			'label'  => 'Posts per Page',
			'validate' => 'int',
		),
		array(
			'type' => 'select',
			'id'    => 'full_meta',
			'label'  => 'Full Metadata',
			'options' => array(
				array(
					'name' =>  'No',
					'value' => 'false'
				),
				array(
					'name' => 'Yes',
					'value' => 'true'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'select',
			'id'    => 'display_content',
			'label'  => 'Display Content',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'content_length',
			'label'  => 'Content Length',
			'validate' => 'int',
		),
		array(
			'type' => 'select',
			'id'    => 'auto_excerpt',
			'label'  => 'Auto-Excerpt',
			'options' => array(
				array(
					'name' =>  'Yes',
					'value' => 'true'
				),
				array(
					'name' => 'No',
					'value' => 'false'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'select',
			'id'    => 'excerpt_trail',
			'label'  => 'Excerpt Trail',
			'options' => array(
				array(
					'name' =>  'Image',
					'value' => 'image'
				),
				array(
					'name' => 'Text',
					'value' => 'text'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'select',
			'id'    => 'use_pub_date',
			'label'  => 'Use Publication Date',
			'options' => array(
				array(
					'name' =>  'Yes',
					'value' => 'true'
				),
				array(
					'name' => 'No',
					'value' => 'false'
				)
			),
			'validate' => 'exists_in_select'
		),
		array(
			'type' => 'header',
			'id' => 'css_header',
			'label'  => 'Custom CSS'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'css_style',
			'label'  => 'Custom CSS Filename',
			'validate' => 'strip_tags'
		),
		array(
			'type'  => 'text_line',
			'id'    => 'wrapper__css',
			'label'  => 'Custom CSS Class for the content wrapper',
			'validate' => 'strip_tags'
		),
		array(
			'type' => 'header',
			'id' => 'query_header',
			'label'  => 'Custom Query',
		),
		array(
			'type'  => 'text_area',
			'id'    => 'custom_query',
			'label'  => 'Custom Query String for Data',
			'validate' => 'query_string'
		)
	);

	/**
	 * Render_Form
	 *
	 * @param array|null $fields
	 *
	 * @return mixed Displays field or returns errors or false or any number of things.
	 */
	public function render_form( $fields = null ) {

		// Sets fields if they don't exist
		$fields = ( $fields === null ? $this->fields : $fields );

		foreach ( $fields as $field ) {

			/**
			 * Sends the value to the correct input function.
			 *
			 * Creates a set of default functions to be used (header, text_line, text_area,
			 * select, and multi_select) but also allows the user to extend the class to
			 * add more.
			 */
			$this->create_field($field);

		}

	}

	/**
	 * @param null|array $values
	 * @param null|array $fields
	 *
	 * @return array|null
	 */
	public function update_fields( $values = null, $fields = null ) {
		// Fields from form
		$fields = ($fields !== null ? $fields : $this->fields);
		// Values to be input
		$values = ($values !== null ? $values : $this->values);
		// Array of new values
		$new_values = array();

		// Iterate through
		foreach ( $fields as $field ) {

			$cb = $field['validate'];

			if ( $field['validate'] !== null && method_exists($this, $cb) ) {

				$id = $field['id'];
				$new_values[$id] = $this->{$field['validate']}( $values[$id], $field );
			}
		}

		return $new_values;
	}

	/**
	 * Create group of < option > for select tag
	 *
	 * @param $options array
	 * @param $value   string
	 */
	public function select_multi_options( $options, $value ) {

		if ( $options[0]['name'] == 'Blog List' ) {
			$options = $this->get_blog_list( $options[0]['default'] );
		}

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
	 * prepares blogs for display in certain options
	 *
	 * @param $default
	 *
	 * @return array
	 */
	public function get_blog_list( $default ) {

		$blogs = new WPN_Posts_Query();
		$blogs = $blogs->get_blogs();

		$sites[] = array(
			'name' => $default,
			'value' => 0
		);

		if ( $blogs !== null ) :

			foreach ( $blogs as $single_id ) {
				$blog_details = get_blog_details( $single_id['blog_id'], true );

				$sites[] = array(
					'name' => $blog_details->blogname . " (ID " . $blog_details->blog_id . ")",
					'value' => $blog_details->blog_id
				);
			}

		endif;

		return $sites;
	}

	/**
	 * Easy way of processing incoming values int integers
	 *
	 * @param $val
	 *
	 * @return int
	 */
	public function int( $val, $field = null ) {

		return intval( $val );
	}

	/**
	 * Strips tags and clears up white space.
	 *
	 * @param $val
	 *
	 * @return string
	 */
	public function strip_tags( $val, $field = null ) {

		return trim( strip_tags( $val ) );
	}

	/**
	 * Removes characters from a string.
	 *
	 * @param $val
	 *
	 * @return string
	 */
	public function query_string( $val, $field = null ) {

		return preg_replace("/[^A-Za-z0-9\-+,&_.=]/", '', $val);
	}

	/**
	 * @param $val
	 * @param $field
	 *
	 * @return string|int Returns first value if it can't find anything.
	 */
	public function exists_in_select( $val, $field ) {

		foreach ( $field['options'] as $options ) {

			if ( in_array( $val, $options ) ) {

				return $val;
			}

		}

		return $field['options'][0]['value'];
	}

	/**
	 * @param $values array
	 * @param $field
	 *
	 * @return string|int Returns first value if it can't find anything.
	 */
	public function exists_in_multi_select( $values, $field ) {

		if ( $field['options'][0]['name'] == 'Blog List' ) {
			$field['options'] = $this->get_blog_list( $field['options']['default'] );
		}

		$new_values = array();

		// Iterate through supplied values
		foreach ( $values as $value ) {

			// Check if each value exists in options field.
			foreach ( $field['options'] as $options ) {

				if ( in_array( $value, $options ) ) {

					$new_values[] = $value;
				}

			}

		}

		return $values;
	}

}