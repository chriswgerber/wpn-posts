<?php
/**
 * Class WPN_Posts_Settings
 *
 * Creates the settings for this widget
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
			'validate' => '',
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
			)
		),
		array(
			'type'  => 'header',
			'id'    => 'blogs_header',
			'label' => 'Posts',
			'validate' => '',
		),
		array(
			'type'    => 'select_multiple',
			'id'      => 'blog_id',
			'label'   => 'Blog(s) to Display',
			'validate' => '',
			'options' => array(
				array(
					'name'    => 'Blog List',
					'default' => 'Display All'
				)
			)
		),
		array(
			'type'    => 'select_multiple',
			'id'      => 'ignore_blog',
			'label'   => 'Blog(s) to Ignore',
			'validate' => '',
			'options' => array(
				array(
					'name'    => 'Blog List',
					'default' => 'Nothing to Ignore'
				)
			)
		),
		array(
			'type' => 'select',
			'id'    => 'sort_by_blog',
			'label'  => 'Sort by Blog ID',
			'validate' => '',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			)
		),
		array(
			'type' => 'select',
			'id'    => 'sorting_order',
			'label'  => 'Sorting Order',
			'validate' => '',
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
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'custom_post_type',
			'label'  => 'Custom Post Types',
			'validate' => '',
		),
		array(
			'type'  => 'text_line',
			'id'    => 'category',
			'label'  => 'Category(ies)',
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'tag',
			'label'  => 'Tag(s)',
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'post_limit',
			'label'  => 'Total Number of Posts',
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'posts_per_blog',
			'label' => 'Max Posts for each blog',
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'time_frame',
			'label' => 'Time Frame (in Days)',
			'validate' => ''
		),
		array(
			'type' => 'select',
			'id'    => 'honor_sticky',
			'label'  => 'Honor Sticky Posts',
			'validate' => '',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			)
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
			'validate' => '',
			'options' => array(
				array(
					'name' =>  'Show',
					'value' => 'true'
				),
				array(
					'name' => 'Hide',
					'value' => 'false'
				)
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_w',
			'label'  => 'Thumbnail Width',
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_h',
			'label'  => 'Thumbnail Height',
			'validate' => ''
		),
		array(
			'type' => 'select',
			'id'    => 'thumbnail_filler',
			'label'  => 'Thumbnail Replacement',
			'validate' => '',
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
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_url',
			'label'  => 'Custom Thumbnail URL',
			'validate' => ''
		),
		array(
			'type' => 'select',
			'id'    => 'thumbnail_custom',
			'label'  => 'Custom Thumbnail',
			'validate' => '',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'thumbnail_field',
			'label'  => 'Thumbnail Custom Field',
			'validate' => '',
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
			'validate' => '',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'posts_per_page',
			'label'  => 'Posts per Page',
			'validate' => '',
		),
		array(
			'type' => 'select',
			'id'    => 'full_meta',
			'label'  => 'Full Metadata',
			'validate' => '',
			'options' => array(
				array(
					'name' =>  'No',
					'value' => 'false'
				),
				array(
					'name' => 'Yes',
					'value' => 'true'
				)
			)
		),
		array(
			'type' => 'select',
			'id'    => 'display_content',
			'label'  => 'Display Content',
			'validate' => '',
			'options' => array(
				array(
					'name' => 'No',
					'value' => 'false'
				),
				array(
					'name' =>  'Yes',
					'value' => 'true'
				)
			)
		),
		array(
			'type'  => 'text_line',
			'id'    => 'content_length',
			'label'  => 'Content Length',
			'validate' => '',
		),
		array(
			'type' => 'select',
			'id'    => 'auto_excerpt',
			'label'  => 'Auto-Excerpt',
			'validate' => '',
			'options' => array(
				array(
					'name' =>  'Yes',
					'value' => 'true'
				),
				array(
					'name' => 'No',
					'value' => 'false'
				)
			)
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
			'validate' => ''
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
			'validate' => ''
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
			'validate' => ''
		),
		array(
			'type'  => 'text_line',
			'id'    => 'wrapper__css',
			'label'  => 'Custom CSS Class for the content wrapper',
			'validate' => ''
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
			'validate' => 'sql_escape'
		)
	);

	public function render_form( $fields = null ) {

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
				$new_values[$id] = $this->{$field['validate']}( $values[$id] );
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
	public function int( $val ) {

		return intval( $val );
	}

	/**
	 * Easy way of processing incoming values int integers
	 *
	 * @param $val
	 *
	 * @return string
	 */
	public function strip_tags( $val ) {

		return trim(strip_tags( $val ));
	}

	/**
	 * Easy way of processing incoming values int integers
	 *
	 * @param $val
	 *
	 * @return mixed
	 */
	public function sql_escape( $val ) {

		return $val;
	}

}