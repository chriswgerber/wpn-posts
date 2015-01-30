<?php
/**
 * WPN_Posts_Widget Class extending the WP_Widget class
 */

class WPN_Posts_Widget extends WP_Widget {

	CONST SAVED_VAL_TRA = 'CWG_Transient_Saved_variables';
	CONST SAVED_VAL_TRA_LIMIT = 10;

	private $fields;

	// Default values
	private $defaults = array(
		// Widget title
		'title'             => NULL,
		// Number of posts to be displayed
		'number_posts'      => 10,
		// Time frame to look for posts in days
		'time_frame'        => 0,
		// Display the post title only
		'title_only'        => TRUE,
		// Display content as a: olist (ordered), ulist (unordered), block
		'display_type'      => 'ulist',
		// ID(s) of the blog(s) you want to display the latest posts
		'blog_id'           => NULL,
		// ID(s) of the blog(s) you want to ignore
		'ignore_blog'       => NULL,
		// Display the thumbnail
		'thumbnail'         => FALSE,
		// Thumbnail Width & Height in pixels
		'thumbnail_w'       => '80',
		'thumbnail_h'       => '80',
		// Thumbnail CSS class
		'thumbnail_class'   => NULL,
		// Replacement image for posts without thumbnail (placeholder, kittens, puppies)
		'thumbnail_filler'  => 'placeholder',
		// Pull thumbnails from custom fields
		'thumbnail_custom'  => FALSE,
		// Custom field containing image url
		'thumbnail_field'   => NULL,
		// Custom thumbnail URL
		'thumbnail_url'     => NULL,
		// Type of posts to display
		'custom_post_type'  => 'post',
		// Category(ies) to display
		'category'          => NULL,
		// Tag(s) to display
		'tag'               => NULL,
		// Paginate results
		'paginate'          => FALSE,
		// Number of posts per page (paginate must be activated)
		'posts_per_page'    => NULL,
		// Display post content (when false, excerpts will be displayed)
		'display_content'   => FALSE,
		// Excerpt's length
		'excerpt_length'    => NULL,
		// Generate excerpt from content
		'auto_excerpt'      => FALSE,
		// Excerpt's trailing element: text, image
		'excerpt_trail'     => 'text',
		// Display full metadata
		'full_meta'         => FALSE,
		// Display the latest posts first regardless of the blog they come from
		'sort_by_date'      => FALSE,
		// Sort by Blog ID
		'sort_by_blog'      => FALSE,
		// Sort posts from Newest to Oldest or vice versa (newer / older), asc / desc for blog ID
		'sorting_order'     => NULL,
		// Limit the number of sorted posts to display
		'sorting_limit'     => NULL,
		// Post status (publish, new, pending, draft, auto-draft, future, private, inherit, trash)
		'post_status'       => 'publish',
		// Custom CSS _filename_ (ex: custom_style)
		'css_style'         => NULL,
		// Custom CSS classes for the list wrapper
		'wrapper_list_css'  => 'nav nav-tabs nav-stacked',
		// Custom CSS classes for the block wrapper
		'wrapper_block_css' => 'content',
		// Instance identifier, used to uniquely differenciate each shortcode or widget used
		'instance'          => NULL,
		// Pull random posts (true or false)
		'random'            => FALSE,
		// Post ID(s) to ignore
		'post_ignore'       => NULL,
		// AFW Display the most recently published posts first regardless of the blog they come from
		'use_pub_date'      => FALSE,
		// AFW Sort sticky posts to the top of the list, ordered by requested sort order
		'honor_sticky'      => FALSE
	);

	private $instance;

	/**
	 * @var array $blog_ids Array containing blog objects
	 */
	private $blogs;

	/*
	* Register widget with WordPress
	 *
	*/
	public function __construct( WPN_Posts_Fields $fields, WPN_Posts $posts ) {

		$this->fields = $fields;

		parent::__construct(
			'wpn_posts_widget', // Base ID
			'Network Posts',  // Name
<<<<<<< HEAD
			array( 'description' => __( 'Network Posts', 'trans-nlp' ), ) // Args
=======
			array( 'description' => __( 'Network Posts', 'wpn-posts' ), ) // Args
>>>>>>> 933c84a... Initial Commit.
		);

		// Get blog ids
		global $wpdb;
		$args = array(
			'network_id' => $wpdb->siteid,
			'public'     => null,
			'archived'   => null,
			'mature'     => null,
			'spam'       => null,
			'deleted'    => null,
			'limit'      => 50,
			'offset'     => 0,
		);

		if ( function_exists( 'wp_get_sites' ) ) {
			$this->blogs = wp_get_sites( $args );
		} else {
			$this->blogs = null;
		}

		//$this->blog_ids = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs} WHERE public = '1' AND archived =
		// '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY last_updated DESC" );

	}


	/*
	 * Front-end display of widget
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments
	 * @param array $instance Saved values from database
	 */
	public function widget( $args, $instance ) {

		// Set the instance identifier, so each instance of the widget is treated individually
		$instance['instance'] = $args['widget_id'];

		//var_dump($instance);

		// Open the aside tag (widget placeholder)
		echo "<aside class='widget wpn-posts-widget'>";

		$latest_posts = new WPN_Posts_View( $instance );

		$latest_posts->network_latest_posts();

		echo "</aside>";
	}

	/*
	 * Sanitize widget form values as they are saved
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		// Set an array
		$instance = array();

		// Get the values
		$instance['title']             = strip_tags( $new_instance['title'] );
		$instance['number_posts']      = intval( $new_instance['number_posts'] );
		$instance['time_frame']        = intval( $new_instance['time_frame'] );
		$instance['title_only']        = strip_tags( $new_instance['title_only'] );
		$instance['display_type']      = strip_tags( $new_instance['display_type'] );
		$instance['thumbnail']         = strip_tags( $new_instance['thumbnail'] );
		$instance['thumbnail_w']       = (int) $new_instance['thumbnail_w'];
		$instance['thumbnail_h']       = (int) $new_instance['thumbnail_h'];
		$instance['thumbnail_class']   = strip_tags( $new_instance['thumbnail_class'] );
		$instance['thumbnail_filler']  = strip_tags( $new_instance['thumbnail_filler'] );
		$instance['thumbnail_custom']  = strip_tags( $new_instance['thumbnail_custom'] );
		$instance['thumbnail_field']   = strip_tags( $new_instance['thumbnail_field'] );
		$instance['thumbnail_url']     = strip_tags( $new_instance['thumbnail_url'] );
		$instance['custom_post_type']  = strip_tags( $new_instance['custom_post_type'] );
		$instance['category']          = strip_tags( $new_instance['category'] );
		$instance['tag']               = strip_tags( $new_instance['tag'] );
		$instance['paginate']          = strip_tags( $new_instance['paginate'] );
		$instance['posts_per_page']    = (int) $new_instance['posts_per_page'];
		$instance['display_content']   = strip_tags( $new_instance['display_content'] );
		$instance['excerpt_length']    = (int) $new_instance['excerpt_length'];
		$instance['auto_excerpt']      = strip_tags( $new_instance['auto_excerpt'] );
		$instance['full_meta']         = strip_tags( $new_instance['full_meta'] );
		$instance['sort_by_date']      = strip_tags( $new_instance['sort_by_date'] );
		$instance['sort_by_blog']      = strip_tags( $new_instance['sort_by_blog'] );
		$instance['sorting_order']     = strip_tags( $new_instance['sorting_order'] );
		$instance['sorting_limit']     = (int) $new_instance['sorting_limit'];
		$instance['post_status']       = strip_tags( $new_instance['post_status'] );
		$instance['excerpt_trail']     = strip_tags( $new_instance['excerpt_trail'] );
		$instance['css_style']         = strip_tags( $new_instance['css_style'] );
		$instance['wrapper_list_css']  = strip_tags( $new_instance['wrapper_list_css'] );
		$instance['wrapper_block_css'] = strip_tags( $new_instance['wrapper_block_css'] );
		$instance['random']            = strip_tags( $new_instance['random'] );
		$instance['post_ignore']       = strip_tags( $new_instance['post_ignore'] );
		$instance['use_pub_date']      = strip_tags( $new_instance['use_pub_date'] );
		$instance['honor_sticky']      = strip_tags( $new_instance['honor_sticky'] );
		// Width by default
		if ( $instance['thumbnail_w'] == '0' ) {
			$instance['thumbnail_w'] = '80';
		}
		// Height by default
		if ( $instance['thumbnail_h'] == '0' ) {
			$instance['thumbnail_h'] = '80';
		}
		foreach ( $new_instance['blog_id'] as $id ) {
			$instance['blog_id'][] = intval($id);
		}
		foreach ( $new_instance['ignore_blog'] as $id ) {
			$instance['ignore_blog'][] = intval($id);
		}

		// Return the sanitized values
		return $instance;
	}

	/*
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$this->instance = $instance;

		$this->instance = wp_parse_args( $instance, $this->defaults );

		$this->fields->values = $instance;

		// Form fields
		$this->fields->build_form();

	}

	/**
	 * Builds the form
	 *
	 * @param $fields array
	 */
	public function build_form( $fields ) {

		foreach ( $fields as $form_field ) {

			switch ( $form_field['field'] ) {

				case 'header':
					$this->field_header( $form_field );

					break;

				case 'text':
					$this->text_form_field( $form_field );

					break;

				case 'select-single' :
					$this->select_form_field( $form_field );

					break;

				case 'select-multiple':
					$this->select_form_field( $form_field, false );

					break;

				default :
					echo $form_field['field'] . 'is not a valid field name';

					break;

			}

		}

	}

	/**
	 * Display Header Tag
	 *
	 * @param $args array
	 */
	public function field_header( $args ) {
		?>
<<<<<<< HEAD
		<h3><?php printf( __( '%1$s', 'trans-nlp' ), $args['name'] ); ?></h3>
=======
		<h3><?php printf( __( '%1$s', 'wpn-posts' ), $args['name'] ); ?></h3>
>>>>>>> 933c84a... Initial Commit.
		<hr />
		<?php
	}

	/**
	 * Creates Text Form Field
	 *
	 * @param $args array
	 *              ID    = Field ID
	 *              Name  = Field Name
	 *              Value = String
	 */
	public function text_form_field( $args ) {
		$id    = $this->get_field_id( $args['id'] );
		$name  = $this->get_field_name( $args['id'] );
		$value = $this->instance[$args['id']];
		?>
		<p>
			<label for="<?php echo $id; ?>">
<<<<<<< HEAD
				<?php printf( __( '%1$s', 'trans-nlp' ), $args['name'] ); ?>
=======
				<?php printf( __( '%1$s', 'wpn-posts' ), $args['name'] ); ?>
>>>>>>> 933c84a... Initial Commit.
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
	 * Creates Select Field
	 *
	 * @param array $args
	 * @param bool  $single
	 */
	public function select_form_field( $args, $single = true ) {
		$id       = $this->get_field_id( $args['id'] );
		$name     = ( $single !== true ? $this->get_field_name( $args['id'] ) . '[]' : $this->get_field_name( $args['id'] ) );
		$value    = $this->instance[$args['id']];
		$multiple = ( $single !== true ? $name . ' multiple="multiple"' : $name );
		?>
		<p>
			<label for="<?php echo $id; ?>">
<<<<<<< HEAD
				<?php printf( __( '%1$s', 'trans-nlp' ), $args['name'] ); ?>
=======
				<?php printf( __( '%1$s', 'wpn-posts' ), $args['name'] ); ?>
>>>>>>> 933c84a... Initial Commit.
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
<<<<<<< HEAD
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'trans-nlp' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $option['name'] ); ?>
=======
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'wpn-posts' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $option['name'] ); ?>
>>>>>>> 933c84a... Initial Commit.
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
<<<<<<< HEAD
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'trans-nlp' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'trans-nlp' ), $option['name'] ); ?>
=======
			<option <?php echo $selected; ?> value="<?php printf( __( '%1$s', 'wpn-posts' ), $option['value'] ); ?>">
				<?php printf( __( '%1$s', 'wpn-posts' ), $option['name'] ); ?>
>>>>>>> 933c84a... Initial Commit.
			</option>
		<?php }

	}

	/**
	 * @param $default string Name of default value
	 *
	 * @return array $blogs
	 *              Name = String of Blog Title
	 *              Value = Blog ID
	 */
	public function list_of_blogs( $default ) {

		$sites[] = array(
			'name' => $default,
			'value' => null
		);

		if ( $this->blogs !== null ) :

			foreach ( $this->blogs as $single_id ) {
				$blog_details = get_blog_details( $single_id['blog_id'], true );

				$sites[] = array(
					'name' => $blog_details->blogname . " (ID " . $blog_details->blog_id . ")",
					'value' => $blog_details->blog_id
				);
			}

		endif;

		return $sites;
	}

}