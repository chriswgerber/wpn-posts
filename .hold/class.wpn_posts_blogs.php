<?php
/**
 *
 */

class WPN_Posts_Blogs {

	//public function

	public function __construct( WPN_Posts $settings ) {

		$this->settings = $settings;

	}

	public function get_blog_list() {

	}

	public function get_posts() {

	}

	public function get_title() {

	}

	private function sql_statement() {

		$select = 'SELECT blog_id FROM ' . $wpdb->blogs;


		$where =  "WHERE public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' AND last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL $time_frame DAY)";

		$order_by = "ORDER BY last_updated DESC";

		$blogs = $wpdb->get_col( $select . $where . $this->display_blogs() . $this->ignore_blogs($blogs) . $order_by );

		return $blogs;

	}

	private function display_blogs($ids = null) {
		$ids = ( $ids === null ? $this->settings['blog_ids'] : $ids );

		$stmt = '';

		foreach ( $ids as $key => $id ) {

			if ($key < 1) {
				$stmt .= ' AND blog_id = ' . $id;
			} else {
				$stmt .= ' OR blog_id = ' . $id;
			}
		}

		return $stmt;
	}

	private function ignore_blogs($ids = null) {
		$ids = ( $ids === null ? $this->settings['ignore_blog'] : $ids );
		$stmt = '';

		foreach ( $ids as $key => $id ) {

			if ($key < 1) {
				$stmt .= ' AND blog_id != ' . $id;
			} else {
				$stmt .= " OR blog_id != ";
			}
		}

		return $stmt;

	}


	protected function prepare_query($settings) {


		// Display blog or blogs
		// If multiple tags found, set an array
		if ( preg_match( "/,/", $tag ) ) {
			$tag = explode( ",", $tag );
		} else {
			if ( ! empty( $tag ) ) {
				$tag = str_split( $tag, strlen( $tag ) );
			}
		}
		// If multiple categories found, set an array
		if ( preg_match( "/,/", $category ) ) {
			$category = explode( ",", $category );
		} else {
			if ( ! empty( $category ) ) {
				$category = str_split( $category, strlen( $category ) );
			}
		}
		// If multiple post type found, set an array
		if ( preg_match( "/,/", $custom_post_type ) ) {
			$custom_post_type = explode( ",", $custom_post_type );
		} else {
			if ( ! empty( $category ) ) {
				$custom_post_type = str_split( $custom_post_type, strlen( $custom_post_type ) );
			}
		}
		// Paranoid ;)
		$time_frame = (int) $time_frame;
		// Get the list of blogs in order of most recent update, get only public and nonarchived/spam/mature/deleted
		if ( $time_frame > 0 ) {
			// By blog ID except those ignored
			if ( ! empty( $blog_id ) && $blog_id != null ) {
				$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE
                public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' $display
                    $ignore AND last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL $time_frame DAY)
                        ORDER BY last_updated DESC" );
				// Everything but ignored blogs
			} else {
				$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE
                public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0'
                    $ignore AND last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL $time_frame DAY)
                        ORDER BY last_updated DESC" );
			}
			// Everything written so far
		} else {
			// By blog ID except those ignored
			if ( ! empty( $blog_id ) && $blog_id != null ) {
				$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE
                public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' $display
                    $ignore ORDER BY last_updated DESC" );
				// Everything but ignored blogs
			} else {
				$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE
                public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0'
                    $ignore ORDER BY last_updated DESC" );
			}
		}
		// Ignore one or many posts
		// if the user passes one value
		if ( ! preg_match( "/,/", $post_ignore ) ) {
			// Always clean this stuff ;) (oh.. told you I'm a paranoid)
			$post_ignore = array( 0 => (int) htmlspecialchars( $post_ignore ) );
			// if the user passes more than one value separated by commas
		} else {
			// create an array
			$post_ignore = explode( ",", $post_ignore );
		}
		// If it found something
		if ( $blogs ) {
			// Count blogs found
			$count_blogs = count( $blogs );
			// Dig into each blog
			foreach ( $blogs as $blog_key ) {
				// Options: Site URL, Blog Name, Date Format
				${'blog_url_' . $blog_key}    = get_blog_option( $blog_key, 'siteurl' );
				${'blog_name_' . $blog_key}   = get_blog_option( $blog_key, 'blogname' );
				${'date_format_' . $blog_key} = get_blog_option( $blog_key, 'date_format' );
				// Orderby
				if ( $random == 'true' ) {
					$orderby = 'rand';
				} else {
					$orderby = 'post_date';
				}
				// Categories or Tags
				if ( ! empty( $category ) && ! empty( $tag ) ) {
					$args = array(
						'tax_query'   => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => $category
							),
							array(
								'taxonomy' => 'post_tag',
								'field'    => 'slug',
								'terms'    => $tag
							)
						),
						'numberposts' => $number_posts,
						'post_status' => $post_status,
						'post_type'   => $custom_post_type,
						'orderby'     => $orderby
					);
				}
				// Categories only
				if ( ! empty( $category ) && empty( $tag ) ) {
					$args = array(
						'tax_query'   => array(
							array(
								'taxonomy' => 'category',
								'field'    => 'slug',
								'terms'    => $category
							)
						),
						'numberposts' => $number_posts,
						'post_status' => $post_status,
						'post_type'   => $custom_post_type,
						'orderby'     => $orderby
					);
				}
				// Tags only
				if ( ! empty( $tag ) && empty( $category ) ) {
					$args = array(
						'tax_query'   => array(
							array(
								'taxonomy' => 'post_tag',
								'field'    => 'slug',
								'terms'    => $tag
							)
						),
						'numberposts' => $number_posts,
						'post_status' => $post_status,
						'post_type'   => $custom_post_type,
						'orderby'     => $orderby
					);
				}
				// Everything by Default
				if ( empty( $category ) && empty( $tag ) ) {
					// By default
					$args = array(
						'numberposts' => $number_posts,
						'post_status' => $post_status,
						'post_type'   => $custom_post_type,
						'orderby'     => $orderby
						//'post__in' => get_option('sticky_posts')
					);
				}
				// Switch to the blog
				switch_to_blog( $blog_key );
				// Get posts
				${'posts_' . $blog_key} = get_posts( $args );
				// Check if posts with the defined criteria were found
				if ( empty( ${'posts_' . $blog_key} ) ) {
					/* If no posts matching the criteria were found then
					 * move to the next blog
					 */
					next( $blogs );
				}
				$blog_sort_key = str_pad( $blog_key, 6, '0', STR_PAD_LEFT );
				if ( $honor_sticky == 'true' ) {
					switch ( $sorting_order ) {
						case "newer":
							$sticky   = '1';
							$unsticky = '0';
							break;
						case "desc":
							$sticky   = '1';
							$unsticky = '0';
							break;
						default:
							$sticky   = '0';
							$unsticky = '1';
							break;
					}
				} else {
					$sticky   = '';
					$unsticky = '';
				}
				// Put everything inside an array for sorting purposes
				foreach ( ${'posts_' . $blog_key} as $post ) {
					// Access all post data
					setup_postdata( $post );
					$sticky_key = ( is_sticky( $post->ID ) ) ? $sticky : $unsticky; //AFW
					// AFW
					if ( $use_pub_date == 'true' ) {
						$date_key = $post->post_date;
					} else {
						$date_key = $post->post_modified;
					}
					// Sort by blog ID
					if ( $sort_by_blog == 'true' ) {
						// Ignore Posts
						if ( ! in_array( $post->ID, $post_ignore ) ) {
							// Put inside another array and use blog ID as keys
							$all_posts[ $sticky_key . $blog_sort_key . $date_key . $post->ID ] = $post;
						}
					} else {
						// Ignore Posts
						if ( ! in_array( $post->ID, $post_ignore ) ) {
							// Put everything inside another array using the modified date as
							// the array keys
							$all_posts[ $sticky_key . $date_key . $blog_sort_key . $post->ID ] = $post;
						}
					}
					// The guid is the only value which can differenciate a post from
					// others in the whole network
					$all_permalinks[ $post->guid ] = get_blog_permalink( $blog_key, $post->ID );
					$all_blogkeys[ $post->guid ]   = $blog_key;
				}
				// Back the current blog
				restore_current_blog();
			}
			// If no content was found
			if ( empty( $all_posts ) ) {
				// Nothing to do here, let people know and get out of here
				echo "<div class='alert'><p>" . $alert_msg . "</p></div>";

				return;
			}
			// Sort if Sticky
			if ( $honor_sticky == 'true' ) {
				switch ( $sorting_order ) {
					case "newer":
					case "desc":
						@krsort( $all_posts );
						break;
					default:
						@ksort( $all_posts );
						break;
				}
			}
			// Sort by date (regardless blog IDs)
			if ( $sort_by_date == 'true' ) {
				// Sorting order (newer / older)
				if ( ! empty( $sorting_order ) ) {
					switch ( $sorting_order ) {
						// From newest to oldest
						case "newer":
							// Sort the array
							@krsort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
						// From oldest to newest
						case "older":
							// Sort the array
							@ksort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
						// Newest to oldest by default
						default:
							// Sort the array
							@krsort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
					}
				} else {
					// Sort the array
					@krsort( $all_posts );
					// Limit the number of posts
					if ( ! empty( $sorting_limit ) ) {
						$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
					}
				}
			}
			// Sort by blog ID
			if ( $sort_by_blog == 'true' ) {
				// Sorting order (newer / older)
				if ( ! empty( $sorting_order ) ) {
					switch ( $sorting_order ) {
						// Ascendant
						case "asc":
							// Sort the array
							@ksort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
						// Descendant
						case "desc":
							// Sort the array
							@krsort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
						// Newest to oldest by default
						default:
							// Sort the array
							@krsort( $all_posts );
							// Limit the number of posts
							if ( ! empty( $sorting_limit ) ) {
								$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
							}
							break;
					}
				} else {
					// Sort the array
					@ksort( $all_posts );
					// Limit the number of posts
					if ( ! empty( $sorting_limit ) ) {
						$all_posts = @array_slice( $all_posts, 0, $sorting_limit, true );
					}
				}
			}
		}

	}

}

/*
array (size=38)
  'title' => string 'Latest Postssss' (length=15)
  'number_posts' => int 10
  'time_frame' => int 20
  'title_only' => string 'false' (length=5)
  'display_type' => string 'olist' (length=5)
  'thumbnail' => string 'true' (length=4)
  'thumbnail_w' => int 80
  'thumbnail_h' => int 80
  'thumbnail_class' => string '' (length=0)
  'thumbnail_filler' => string 'placeholder' (length=11)
  'thumbnail_custom' => string 'true' (length=4)
  'thumbnail_field' => string '' (length=0)
  'thumbnail_url' => string '' (length=0)
  'custom_post_type' => string 'post' (length=4)
  'category' => string '' (length=0)
  'tag' => string '' (length=0)
  'paginate' => string 'true' (length=4)
  'posts_per_page' => int 0
  'display_content' => string 'true' (length=4)
  'excerpt_length' => int 0
  'auto_excerpt' => string 'true' (length=4)
  'full_meta' => string 'false' (length=5)
  'sort_by_date' => string 'true' (length=4)
  'sort_by_blog' => string 'true' (length=4)
  'sorting_order' => string 'newer' (length=5)
  'sorting_limit' => int 0
  'post_status' => string 'publish' (length=7)
  'excerpt_trail' => string 'text' (length=4)
  'css_style' => string '' (length=0)
  'wrapper_list_css' => string 'nav nav-tabs nav-stacked' (length=24)
  'wrapper_block_css' => string 'content' (length=7)
  'random' => string 'false' (length=5)
  'post_ignore' => string '20' (length=2)
  'use_pub_date' => string 'true' (length=4)
  'honor_sticky' => string 'true' (length=4)
  'blog_id' =>
    array (size=2)
      0 => int 1
      1 => int 3
  'ignore_blog' =>
    array (size=1)
      0 => int 2
  'instance' => string 'wpn_posts_widget-2' (length=18)
*/