<?php
/**
 * Network Posts
 *
 * Where the magic happens ;)
 *
 * List of Parameters
 *
 * -- @title              : Widget/Shortcode main title (section title)
 * -- @number_posts       : Number of posts BY blog to retrieve. Ex: 10 means, retrieve 10 posts for each blog found in the network
 * -- @time_frame         : Period of time to retrieve the posts from in days. Ex: 5 means, find all articles posted in the last 5 days
 * -- @title_only         : Display post titles only, if false then excerpts will be shown
 * -- @display_type       : How to display the articles, as an: unordered list (ulist), ordered list (olist) or block elements
 * -- @blog_id            : None, one or many blog IDs to be queried. Ex: 1,2 means, retrieve posts for blogs 1 and 2 only
 * -- @ignore_blog        : It takes the same values as blog_id but in this case this blogs will be ignored. Ex: 1,2 means, display all but 1 and 2
 * -- @thumbnail          : If true then thumbnails will be shown, if active and not found then a placeholder will be used instead
 * -- @thumbnail_wh       : Thumbnails size, width and height in pixels, while using the shortcode or a function this parameter must be passed like: '80x80'
 * -- @thumbnail_class    : Thumbnail class, set a custom class (alignleft, alignright, center, etc)
 * -- @thumbnail_filler   : Placeholder to use if the post's thumbnail couldn't be found, options: placeholder, kittens, puppies (what?.. I can be funny sometimes)
 * -- @thumbnail_custom   : Pull thumbnails from custom fields
 * -- @thumbnail_field    : Specify the custom field for thumbnail URL
 * -- @thumbnail_url      : Custom thumbnail URL
 * -- @custom_post_type   : Specify a custom post type: post, page or something-you-invented
 * -- @category           : Category or categories you want to display. Ex: cats,dogs means, retrieve posts containing the categories cats or dogs
 * -- @tag                : Same as categoy WordPress treats both taxonomies the same way; by the way, you can pass one or many (separated by commas)
 * -- @paginate           : Display results by pages, if used then the parameter posts_per_page must be specified, otherwise pagination won't be displayed
 * -- @posts_per_page     : Set the number of posts to display by page (paginate must be activated)
 * -- @display_content    : When true then post content will be displayed instead of excertps
 * -- @excerpt_length     : Set the excerpt's length in case you think it's too long for your needs Ex: 40 means, 40 words
 * -- @auto_excerpt       : If true then it will generate an excerpt from the post content, it's useful for those who forget to use the Excerpt field in the post edition page
 * -- @excerpt_trail      : Set the type of trail you want to append to the excerpts: text, image. The text will be _more_, the image is inside the plugin's img directory and it's called excerpt_trail.png
 * -- @full_meta          : Display the date and the author of the post, for the date/time each blog time format will be used
 * -- @sort_by_date       : Sorting capabilities, this will take all posts found (regardless their blogs) and sort them in order of recency, putting newest first
 * -- @sort_by_blog       : Sort by blog ID
 * -- @sorting_order      : Specify the sorting order: 'newer' means from newest to oldest posts, 'older' means from oldest to newest. Asc and desc for blog IDs
 * -- @sorting_limit      : Limit the number of posts to display. Ex: 5 means display 5 posts from all those found (even if 20 were found, only 5 will be displayed)
 * -- @post_status        : Specify the status of the posts you want to display: publish, new, pending, draft, auto-draft, future, private, inherit, trash
 * -- @css_style          : Use a custom CSS style instead of the one included by default, useful if you want to customize the front-end display: filename (without extension), this file must be located where your active theme CSS style is located
 * -- @wrapper_list_css   : Custom CSS classes for the list wrapper
 * -- @wrapper_block_css  : Custom CSS classes for the block wrapper
 * -- @instance           : This parameter is intended to differenciate each instance of the widget/shortcode/function you use, it's required in order for the asynchronous pagination links to work
 * -- @random             : Pull random posts (possible values: true or false, false by default)
 * -- @post_ignore        : Post ID(s) to ignore (default null) comma separated values ex: 1 or 1,2,3 > ignore posts ID 1 or 1,2,3 (post ID 1 = Hello World)
 * -- @alert_msg          : Alert Message when NLPosts can't find posts matching the values specified by user
 * -- @use_pub_date       : Display the most recently published posts first regardless of the blog they come from
 * -- @honor_sticky       : Sort sticky posts to the top of the list, ordered by requested sort order
 */


/* Shortcode function
 *
 * @atts: attributes passed to the main function
 * return @shortcode
 */
function network_latest_posts_shortcode( $atts ) {
	if ( ! empty( $atts ) ) {
		// Legacy mode due to variable renaming
		// So existent shorcodes don't break ;)
		foreach ( $atts as $key => $value ) {
			switch ( $key ) {
				case 'number':
					$atts['number_posts'] = $value;
					break;
				case 'days':
					$atts['time_frame'] = $value;
					break;
				case 'titleonly':
					$atts['title_only'] = $value;
					break;
				case 'begin_wrap':
					$atts['before_wrap'] = $value;
					break;
				case 'end_wrap':
					$atts['after_wrap'] = $value;
					break;
				case 'blogid':
					$atts['blog_id'] = $value;
					break;
				case 'cpt':
					$atts['custom_post_type'] = $value;
					break;
				case 'cat':
					$atts['category'] = $value;
					break;
				default:
					$atts[ $key ] = $value;
					break;
			}
		}
		extract( $atts );
	}
	// Start the output buffer to control the display position
	ob_start();
	// Get the posts
	network_latest_posts( $atts );
	// Output the content
	$shortcode = ob_get_contents();
	// Clean the output buffer
	ob_end_clean();

	// Put the content where we want
	return $shortcode;
}

// Add the shortcode functionality
add_shortcode( 'nlposts', 'network_latest_posts_shortcode' );

/* Limit excerpt length
 * @count: excerpt length
 * @content: excerpt content
 * @permalink: link to the post
 * return customized @excerpt
 */
function nlp_custom_excerpt( $count, $content, $permalink, $excerpt_trail ) {
	if ( $count == 0 || $count == 'null' ) {
		$count = 55;
	}
	/* Strip shortcodes
	 * Due to an incompatibility issue between Visual Composer
	 * and WordPress strip_shortcodes hook, I'm stripping
	 * shortcodes using regex. (27-09-2012)
	 *
	 * $content = strip_tags(strip_shortcodes($content));
	 *
	 * replaced by
	 *
	 * $content = preg_replace("/\[(.*?)\]/i", '', $content);
	 * $content = strip_tags($content);
	 */
	$content = preg_replace( "/\[(.*?)\]/i", '', $content );
	$content = strip_tags( $content );
	// Get the words
	$words = explode( ' ', $content, $count + 1 );
	// Pop everything
	array_pop( $words );
	// Add trailing dots
	array_push( $words, '...' );
	// Add white spaces
	$content = implode( ' ', $words );
	// Add the trail
	switch ( $excerpt_trail ) {
		// Text
		case 'text':
			$content = $content . '<a href="' . $permalink . '">' . __( 'more', 'trans-nlp' ) . '</a>';
			break;
		// Image
		case 'image':
			$content = $content . '<a href="' . $permalink . '"><img src="' . plugins_url( '/img/excerpt_trail.png', __FILE__ ) . '" alt="' . __( 'more', 'trans-nlp' ) . '" title="' . __( 'more', 'trans-nlp' ) . '" /></a>';
			break;
		// Text by default
		default:
			$content = $content . '<a href="' . $permalink . '">' . __( 'more', 'trans-nlp' ) . '</a>';
			break;
	}

	// Return the excerpt
	return $content;
}
/* Init function
 * Plugin initialization
 */

function network_latest_posts_init() {
	global $wp_locale;

	// Check for the required API functions
	if ( ! function_exists( 'register_sidebar_widget' ) || ! function_exists( 'register_widget_control' ) ) {
		return;
	}

	// Register functions
	//wp_register_sidebar_widget( 'nlposts-sb-widget', __( "Network Latest Posts", 'trans-nlp' ), "network_latest_posts_widget" );
	wp_register_widget_control( 'nlposts-control', __( "Network Latest Posts", 'trans-nlp' ), "network_latest_posts_control" );
	wp_register_style( 'nlpcss-form', plugins_url( '/css/form_style.css', __FILE__ ) );
	wp_enqueue_style( 'nlpcss-form' );
	register_uninstall_hook( __FILE__, 'network_latest_posts_uninstall' );
	// Load plugins
	wp_enqueue_script( 'jquery' );
}

/*
 * Load Languages
 */
function nlp_load_languages() {
	// Set the textdomain for translation purposes
	load_plugin_textdomain( 'trans-nlp', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

// Load CSS Styles
function nlp_load_styles( $css_style ) {

	if ( ! empty( $css_style ) ) {

		// Unload default style
		wp_deregister_style( 'nlpcss' );
		// Load custom style
		wp_register_style( 'nlp-custom', $css_style );
		wp_enqueue_style( 'nlp-custom' );

	} else {

		// Unload custom style
		wp_deregister_style( 'nlp-custom' );
		// Load default style
		wp_register_style( 'nlpcss', plugins_url( '/css/default_style.css', __FILE__ ) );
		wp_enqueue_style( 'nlpcss' );

	}
}

///* Load Widget
// * using create_function to support PHP versions < 5.3
// */
//add_action( 'widgets_init', create_function( '', '
//    /* Check RTL
//     * This function cannot be called from the network_latest_posts_init function
//     * due to a loading hierarchy issue, if used there it will not
//     * recognize the is_rtl() WordPress function
//     */
//    if( is_rtl() ) {
//        // Deregister the LTR style
//        wp_deregister_style("nlpcss");
//        // Register the RTL style
//        wp_register_style( "nlpcss-rtl", plugins_url("/css/default_style-rtl.css", __FILE__) );
//        // Load the style
//        wp_enqueue_style( "nlpcss-rtl" );
//        // Tell WordPress this plugin is switching to RTL mode
//        global $wp_locale, $wp_styles;
//        /* Set the text direction to RTL
//         * This two variables will tell load-styles.php
//         * load the Dashboard in RTL instead of LTR mode
//         */
//        $wp_locale->text_direction = "rtl";
//        $wp_styles->text_direction = "rtl";
//    }
//    // Load the class
//    return register_widget( "NLposts_Widget" );
//' ) );


/* Uninstall function
 * Provides uninstall capabilities
 */
function network_latest_posts_uninstall() {
	// Delete widget options
	delete_option( 'widget_nlposts_widget' );
	// Delete the shortcode hook
	remove_shortcode( 'nlposts' );
}

/*
 * TinyMCE Shortcode Plugin
 * Add a NLPosts button to the TinyMCE editor
 * this will simplify the way it is used
 */
// TinyMCE button settings
function nlp_shortcode_button() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_external_plugins', 'nlp_shortcode_plugin' );
		add_filter( 'mce_buttons', 'nlp_register_button' );
	}
}

// Hook the button into the TinyMCE editor
function nlp_register_button( $buttons ) {
	array_push( $buttons, "|", "nlposts" );

	return $buttons;
}

// Load the TinyMCE NLposts shortcode plugin
function nlp_shortcode_plugin( $plugin_array ) {
	$plugin_array['nlposts'] = plugin_dir_url( __FILE__ ) . 'js/nlp_tinymce_button.js';

	return $plugin_array;
}

// Hook the shortcode button into TinyMCE
add_action( 'init', 'nlp_shortcode_button' );
// Load styles
add_action( 'wp_head', 'nlp_load_styles', 10, 1 );
// Run this stuff
add_action( "admin_enqueue_scripts", "network_latest_posts_init" );
// Languages
add_action( 'plugins_loaded', 'nlp_load_languages' );
?>