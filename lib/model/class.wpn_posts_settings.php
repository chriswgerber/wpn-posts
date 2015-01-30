<?php
/**
 * Class WPN_Posts_Settings
 *
 * Creates the settings for this widget
 */

class WPN_Posts_Settings extends WPN_Posts_Fields {

	public $values = array();

	private $fields = array(
		array(
			'field' => 'header',
			'name'  => 'Title',
		),
		array(
			'field' => 'text',
			'id'    => 'title',
			'name'  => 'Title'
		),
		array(
			'field' => 'text',
			'id'    => 'number_posts',
			'name'  => 'Number of Posts by Blog'
		),
		array(
			'field' => 'text',
			'id'    => 'post_ignore',
			'name'  => 'Post ID(s) to Ignore'
		),
		array(
			'field' => 'text',
			'id'    => 'time_frame',
			'name'  => 'Time Frame in Days'
		),
		array(
			'field' => 'select-single',
			'id'    => 'title_only',
			'name'  => 'Titles Only',
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
			'field' => 'select-single',
			'id'    => 'display_type',
			'name'  => 'Display Type',
			'options' => array(
				array(
					'name' =>  'Unordered List',
					'value' => 'ulist'
				),
				array(
					'name' => 'Ordered List',
					'value' => 'olist'
				),
				array(
					'name' => 'Blocks',
					'value' => 'block'
				)
			)
		),
		array(
			'field' => 'header',
			'name'  => 'Blogs',
		),
		array(
			'field' => 'select-multiple',
			'id'    => 'blog_id',
			'name'  => 'Display Blog(s)',
			'options' => array(
				array(
					'name' => 'Blog List',
					'default' => 'Display All'
				)
			)
		),
		array(
			'field' => 'select-multiple',
			'id'    => 'ignore_blog',
			'name'  => 'Ignore Blog(s)',
			'options' => array(
				array(
					'name' => 'Blog List',
					'default' => 'Nothing to Ignore'
				)
			)
		),
		array(
			'field' => 'header',
			'name'  => 'Thumbnails',
		),
		array(
			'field' => 'select-single',
			'id'    => 'thumbnail',
			'name'  => 'Display Thumbnails',
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
			'field' => 'text',
			'id'    => 'thumbnail_w',
			'name'  => 'Thumbnail Width'
		),
		array(
			'field' => 'text',
			'id'    => 'thumbnail_h',
			'name'  => 'Thumbnail Height'
		),
		array(
			'field' => 'select-single',
			'id'    => 'thumbnail_filler',
			'name'  => 'Thumbnail Replacement',
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
			'field' => 'text',
			'id'    => 'thumbnail_url',
			'name'  => 'Custom Thumbnail URL'
		),
		array(
			'field' => 'text',
			'id'    => 'thumbnail_class',
			'name'  => 'Thumbnail Class'
		),
		array(
			'field' => 'select-single',
			'id'    => 'thumbnail_custom',
			'name'  => 'Custom Thumbnail',
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
			'field' => 'text',
			'id'    => 'thumbnail_field',
			'name'  => 'Thumbnail Custom Field'
		),
		array(
			'field' => 'header',
			'name'  => 'Posts/Categories',
		),
		array(
			'field' => 'text',
			'id'    => 'custom_post_type',
			'name'  => 'Custom Post Type'
		),
		array(
			'field' => 'text',
			'id'    => 'category',
			'name'  => 'Category(ies)'
		),
		array(
			'field' => 'text',
			'id'    => 'tag',
			'name'  => 'Tag(s)'
		),
		array(
			'field' => 'header',
			'name'  => 'Layout'
		),
		array(
			'field' => 'select-single',
			'id'    => 'paginate',
			'name'  => 'Paginate',
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
			'field' => 'text',
			'id'    => 'posts_per_page',
			'name'  => 'Posts per Page'
		),
		array(
			'field' => 'select-single',
			'id'    => 'display_content',
			'name'  => 'Display Content',
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
			'field' => 'text',
			'id'    => 'excerpt_length',
			'name'  => 'Excerpt Length'
		),
		array(
			'field' => 'select-single',
			'id'    => 'auto_excerpt',
			'name'  => 'Auto-Excerpt',
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
			'field' => 'select-single',
			'id'    => 'excerpt_trail',
			'name'  => 'Excerpt Trail',
			'options' => array(
				array(
					'name' =>  'Image',
					'value' => 'image'
				),
				array(
					'name' => 'Text',
					'value' => 'text'
				)
			)
		),
		array(
			'field' => 'select-single',
			'id'    => 'use_pub_date',
			'name'  => 'Use Publication Date',
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
			'field' => 'select-single',
			'id'    => 'honor_sticky',
			'name'  => 'Honor Sticky Posts',
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
			'field' => 'header',
			'name'  => 'Sorting',
		),
		array(
			'field' => 'select-single',
			'id'    => 'sort_by_date',
			'name'  => 'Sort by Date',
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
			'field' => 'select-single',
			'id'    => 'sort_by_blog',
			'name'  => 'Sort by Blog ID',
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
			'field' => 'select-single',
			'id'    => 'sorting_order',
			'name'  => 'Sorting Order',
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
			'field' => 'text',
			'id'    => 'sorting_limit',
			'name'  => 'Total Number of Posts'
		),
		array(
			'field' => 'text',
			'id'    => 'post_status',
			'name'  => 'Post Status'
		),
		array(
			'field' => 'select-single',
			'id'    => 'full_meta',
			'name'  => 'Full Metadata',
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
			'field' => 'select-single',
			'id'    => 'random',
			'name'  => 'Random Posts',
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
			'field' => 'header',
			'name'  => 'Custom CSS',
		),
		array(
			'field' => 'text',
			'id'    => 'css_style',
			'name'  => 'Custom CSS Filename'
		),
		array(
			'field' => 'text',
			'id'    => 'wrapper_list_css',
			'name'  => 'Custom CSS Class for the list wrapper'
		),
		array(
			'field' => 'text',
			'id'    => 'wrapper_block_css',
			'name'  => 'Custom CSS Class for the block wrapper'
		)
	);

	/**
	 * Builds the form
	 *
	 * @param $fields array of form fields
	 */
	public function form( $fields = null ) {

		// Check if it's set, otherwise use the class's values
		$fields = ($fields === null ? $this->fields : $fields);

		foreach ( $fields as $field ) {

			/**
			 * Sends the value to the correct input function.
			 *
			 * Creates a set of default functions to be used (field_header, text_field, select_field,
			 * multi_select_field) but also allows the user to extend the class to add more.
			 */

			$this->validate_field($field);

			$this->create_field($field);


		}

	}

}