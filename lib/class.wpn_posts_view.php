<?php
/**
 *
 */

class WPN_Posts_View {

	public $settings;

	public function __construct( $settings ) {

		$this->settings = $settings;

		$this->html_tags = $this->nlp_display_type(
			$this->settings['display_type'],
			$this->settings['instance'],
			$this->settings['wrapper_list_css'],
			$this->settings['wrapper_block_css']
		);

	}

	public function unorganized_list() {

	}

	public function organized_list() {

	}

	public function blocks() {

	}

	protected function title( $title ) {

		echo $this->html_tags['wtitle_o'] . $title . $this->html_tags['wtitle_c'];
	}

	function network_latest_posts( $settings = null ) {
		global $wpdb;

		if ( $settings === null ) {
			$settings = $this->settings;
		}

		// HTML Tags
		$html_tags = $this->nlp_display_type(
			$settings['display_type'],
			$settings['instance'],
			$settings['wrapper_list_css'],
			$settings['wrapper_block_css']
		);

		// If Custom CSS
		if ( ! empty( $css_style ) ) {
			// If RTL
			if ( is_rtl() ) {
				// Tell WordPress this plugin is switching to RTL mode
				/* Set the text direction to RTL
				 * This two variables will tell load-styles.php
				 * load the Dashboard in RTL instead of LTR mode
				 */
				global $wp_locale, $wp_styles;
				$wp_locale->text_direction = 'rtl';
				$wp_styles->text_direction = 'rtl';
			}
			// File path
			$cssfile = get_stylesheet_directory_uri() . '/' . $css_style . '.css';
			// Load styles
			nlp_load_styles( $cssfile );
		}
		// Display blog or blogs
		// if the user passes one value
		if ( ! preg_match( "/,/", $blog_id ) ) {
			// Always clean this stuff ;) (oh.. told you I'm a paranoid)
			$blog_id = (int) htmlspecialchars( $blog_id );
			// Check if it's numeric
			if ( is_numeric( $blog_id ) ) {
				// and put the sql
				$display = " AND blog_id = $blog_id ";
			}
			// if the user passes more than one value separated by commas
		} else {
			// create an array
			$display_arr = explode( ",", $blog_id );
			// and repeat the sql for each ID found
			for ( $counter = 0; $counter < count( $display_arr ); $counter ++ ) {
				// Add AND the first time
				if ( $counter == 0 ) {
					$display .= " AND blog_id = " . (int) $display_arr[ $counter ];
					// Add OR the rest of the time
				} else {
					$display .= " OR blog_id = " . (int) $display_arr[ $counter ];
				}
			}
		}
		// Ignore blog or blogs
		// if the user passes one value
		if ( ! preg_match( "/,/", $ignore_blog ) ) {
			// Always clean this stuff ;)
			$ignore_blog = (int) htmlspecialchars( $ignore_blog );
			// Check if it's numeric
			if ( is_numeric( $ignore_blog ) ) {
				// and put the sql
				$ignore = " AND blog_id != $ignore_blog ";
			}
			// if the user passes more than one value separated by commas
		} else {
			// create an array
			$ignore_arr = explode( ",", $ignore_blog );
			// and repeat the sql for each ID found
			for ( $counter = 0; $counter < count( $ignore_arr ); $counter ++ ) {
				$ignore .= " AND blog_id != " . (int) $ignore_arr[ $counter ];
			}
		}
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
			// Open content box
			echo $html_tags['content_o'];
			// NLPosts title

			$this->title($settings['title']);

			// Open wrapper
			echo $html_tags['wrapper_o'];
			// Paginate results
			if ( $paginate && $posts_per_page ) {
				// Page number
				$pag = isset( $_GET['pag'] ) ? abs( (int) $_GET['pag'] ) : 1;
				// Break all posts into pages
				$pages = array_chunk( $all_posts, $posts_per_page );
				// Set the page number variable
				add_query_arg( 'pag', '%#%' );
				// Print out the posts
				foreach ( $pages[ $pag - 1 ] as $field ) {
					// Open item box
					$item_o = $html_tags['item_o'];
					$item_o = str_replace( "'>", " nlposts-siteid-" . $all_blogkeys[ $field->guid ] . "'>", $item_o );
					echo $item_o;
					// Thumbnails
					if ( $thumbnail === 'true' ) {
						// Open thumbnail container
						echo $html_tags['thumbnail_o'];
						// Open thumbnail item placeholder
						echo $html_tags['thumbnail_io'];
						// Switch to the blog
						switch_to_blog( $all_blogkeys[ $field->guid ] );
						// Put the dimensions into an array
						$thumbnail_size = str_replace( 'x', ',', $thumbnail_wh );
						$thumbnail_size = explode( ',', $thumbnail_size );
						if ( $thumbnail_custom != 'true' && $thumbnail_field == null ) {
							// Get the thumbnail
							$thumb_html = get_the_post_thumbnail( $field->ID, $thumbnail_size, array(
								'class' => $thumbnail_class,
								'alt'   => $field->post_title,
								'title' => $field->post_title
							) );
						} else {
							$thumbnail_custom_field = get_post_meta( $field->ID, $thumbnail_field, true );
							if ( ! empty( $thumbnail_custom_field ) ) {
								// Get custom thumbnail
								$thumb_html = "<img src='" . $thumbnail_custom_field . "' width='" . $thumbnail_size[0] . "' height='" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' />";
							} else {
								// Get the regular thumbnail
								$thumb_html = get_the_post_thumbnail( $field->ID, $thumbnail_size, array(
									'class' => $thumbnail_class,
									'alt'   => $field->post_title,
									'title' => $field->post_title
								) );
							}
						}
						// If there is a thumbnail
						if ( ! empty( $thumb_html ) ) {
							// Display the thumbnail
							echo "<a href='" . $all_permalinks[ $field->guid ] . "'>$thumb_html</a>";
							// Thumbnail not found
						} else {
							// Put a placeholder with the post title
							switch ( $thumbnail_filler ) {
								// Placeholder provided by Placehold.it
								case 'placeholder':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								// Just for fun Kittens thanks to PlaceKitten
								case 'kittens':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placekitten.com/" . $thumbnail_size[0] . "/" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								// More fun Puppies thanks to PlaceDog
								case 'puppies':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placedog.com/" . $thumbnail_size[0] . "/" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								case 'custom':
									if ( ! empty( $thumbnail_url ) ) {
										echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='" . $thumbnail_url . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' width='" . $thumbnail_size[0] . "' height='" . $thumbnail_size[1] . "' /></a>";
									} else {
										echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									}
									break;
								// Boring by default ;)
								default:
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
							}
						}
						// Back the current blog
						restore_current_blog();
						// Wrap Caption
						echo $html_tags['caption_o'];
						// Open title box
						echo $html_tags['title_o'];
						// Print the title
						echo "<a href='" . $all_permalinks[ $field->guid ] . "'>" . $field->post_title . "</a>";
						// Close the title box
						echo $html_tags['title_c'];
						if ( $full_meta === 'true' ) {
							// Open meta box
							echo $html_tags['meta_o'];
							// Set metainfo
							$author    = get_user_by( 'id', $field->post_author );
							$format    = (string) ${'date_format_' . $all_blogkeys[ $field->guid ]};
							$datepost  = date_i18n( $format, strtotime( trim( $field->post_date ) ) );
							$blog_name = '<a href="' . ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '">' . ${'blog_name_' . $all_blogkeys[ $field->guid ]} . "</a>";
							// The network's root (main blog) is called 'blog',
							// so we have to set this up because the url ignores the root's subdirectory
							if ( $all_blogkeys[ $field->guid ] == 1 ) {
								// Author's page for the main blog
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/blog/author/' . $author->user_login;
							} else {
								// Author's page for other blogs
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/author/' . $author->user_login;
							}
							// Print metainfo
							echo $blog_name . ' - ' . __( 'Published on', 'wpn-posts' ) . ' ' . $datepost . ' ' . __( 'by', 'wpn-posts' ) . ' ' . '<a href="' . $author_url . '">' . $author->display_name . '</a>';
							// Close meta box
							echo $html_tags['meta_c'];
						}
						// Print the content
						if ( $title_only === 'false' ) {
							// Open excerpt wrapper
							echo $html_tags['excerpt_o'];
							// Display excerpts or content
							if ( $display_content != 'true' ) {
								// Custom Excerpt
								if ( $auto_excerpt != 'true' ) {
									// Print out the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[ $field->guid ], $excerpt_trail );
									// Extract excerpt from content
								} else {
									// Get the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_content, $all_permalinks[ $field->guid ], $excerpt_trail );
								}
							} else {
								// Display post content
								echo nl2br( do_shortcode( $field->post_content ) );
							}
							// Close excerpt wrapper
							echo $html_tags['excerpt_c'];
						}
						// Close Caption
						echo $html_tags['caption_c'];
						// Close thumbnail item placeholder
						echo $html_tags['thumbnail_ic'];
						// Close thumbnail container
						echo $html_tags['thumbnail_c'];
					} else {
						// Wrap Caption
						echo $html_tags['caption_o'];
						// Open title box
						echo $html_tags['title_o'];
						// Print the title
						echo "<a href='" . $all_permalinks[ $field->guid ] . "'>" . $field->post_title . "</a>";
						// Close the title box
						echo $html_tags['title_c'];
						if ( $full_meta === 'true' ) {
							// Open meta box
							echo $html_tags['meta_o'];
							// Set metainfo
							$author    = get_user_by( 'id', $field->post_author );
							$format    = (string) ${'date_format_' . $all_blogkeys[ $field->guid ]};
							$datepost  = date_i18n( $format, strtotime( trim( $field->post_date ) ) );
							$blog_name = '<a href="' . ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '">' . ${'blog_name_' . $all_blogkeys[ $field->guid ]} . "</a>";
							// The network's root (main blog) is called 'blog',
							// so we have to set this up because the url ignores the root's subdirectory
							if ( $all_blogkeys[ $field->guid ] == 1 ) {
								// Author's page for the main blog
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/blog/author/' . $author->user_login;
							} else {
								// Author's page for other blogs
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/author/' . $author->user_login;
							}
							// Print metainfo
							echo $blog_name . ' - ' . __( 'Published on', 'wpn-posts' ) . ' ' . $datepost . ' ' . __( 'by', 'wpn-posts' ) . ' ' . '<a href="' . $author_url . '">' . $author->display_name . '</a>';
							// Close meta box
							echo $html_tags['meta_c'];
						}
						// Print the content
						if ( $title_only === 'false' ) {
							// Open excerpt wrapper
							echo $html_tags['excerpt_o'];
							// Display excerpts or content
							if ( $display_content != 'true' ) {
								// Custom Excerpt
								if ( $auto_excerpt != 'true' ) {
									// Print out the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[ $field->guid ], $excerpt_trail );
									// Extract excerpt from content
								} else {
									// Get the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_content, $all_permalinks[ $field->guid ], $excerpt_trail );
								}
							} else {
								// Display post content
								echo nl2br( do_shortcode( $field->post_content ) );
							}
							// Close excerpt wrapper
							echo $html_tags['excerpt_c'];
						}
						// Close Caption
						echo $html_tags['caption_c'];
					}
					// Close item box
					echo $html_tags['item_c'];
				}
				// Print out the pagination menu
				for ( $i = 1; $i < count( $pages ) + 1; $i ++ ) {
					// Count the number of pages
					$total += 1;
				}
				// Open pagination wrapper
				echo $html_tags['pagination_o'];
				echo paginate_links( array(
					'base'      => add_query_arg( 'pag', '%#%' ),
					'format'    => '',
					'prev_text' => __( '&laquo;', 'wpn-posts' ),
					'next_text' => __( '&raquo;', 'wpn-posts' ),
					'total'     => $total,
					'current'   => $pag,
					'type'      => 'list'
				) );
				// Close pagination wrapper
				echo $html_tags['pagination_c'];
				// Close wrapper
				echo $html_tags['wrapper_c'];
				/*
				 * jQuery function
				 * Asynchronous pagination links
				 */
				echo '
            <script type="text/javascript" charset="utf-8">
                //<![CDATA[
                jQuery(document).ready(function(){
                    jQuery(".nlp-instance-' . $instance . ' .pagination a").live("click", function(e){
                        e.preventDefault();
                        var link = jQuery(this).attr("href");
                        jQuery(".nlp-instance-' . $instance . ' .nlposts-wrapper").html("<style type=\"text/css\">p.loading { text-align:center;margin:0 auto; padding:20px; }</style><p class=\"loading\"><img src=\"' . plugins_url( '/img/loader.gif', __FILE__ ) . '\" /></p>");
                        jQuery(".nlp-instance-' . $instance . ' .nlposts-wrapper").fadeOut("slow",function(){
                            jQuery(".nlp-instance-' . $instance . ' .nlposts-wrapper").load(link+" .nlp-instance-' . $instance . ' .nlposts-wrapper > *").fadeIn(3000);
                        });

                    });
                });
                //]]>
            </script>';
				// Close content box
				echo $html_tags['content_c'];
				// Without pagination
			} else {
				// Print out the posts
				foreach ( $all_posts as $field ) {
					// Open item box
					$item_o = $html_tags['item_o'];
					$item_o = str_replace( "'>", " nlposts-siteid-" . $all_blogkeys[ $field->guid ] . "'>", $item_o );
					echo $item_o;
					// Thumbnails
					if ( $thumbnail === 'true' ) {
						// Open thumbnail container
						echo $html_tags['thumbnail_o'];
						// Open thumbnail item placeholder
						echo $html_tags['thumbnail_io'];
						// Switch to the blog
						switch_to_blog( $all_blogkeys[ $field->guid ] );
						// Put the dimensions into an array
						$thumbnail_size = str_replace( 'x', ',', $thumbnail_wh );
						$thumbnail_size = explode( ',', $thumbnail_size );
						if ( $thumbnail_custom != 'true' && $thumbnail_field == null ) {
							// Get the thumbnail
							$thumb_html = get_the_post_thumbnail( $field->ID, $thumbnail_size, array(
								'class' => $thumbnail_class,
								'alt'   => $field->post_title,
								'title' => $field->post_title
							) );
						} else {
							$thumbnail_custom_field = get_post_meta( $field->ID, $thumbnail_field, true );
							if ( ! empty( $thumbnail_custom_field ) ) {
								// Get custom thumbnail
								$thumb_html = "<img src='" . $thumbnail_custom_field . "' width='" . $thumbnail_size[0] . "' height='" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' />";
							} else {
								// Get the regular thumbnail
								$thumb_html = get_the_post_thumbnail( $field->ID, $thumbnail_size, array(
									'class' => $thumbnail_class,
									'alt'   => $field->post_title,
									'title' => $field->post_title
								) );
							}
						}
						// If there is a thumbnail
						if ( ! empty( $thumb_html ) ) {
							// Display the thumbnail
							echo "<a href='" . $all_permalinks[ $field->guid ] . "'>$thumb_html</a>";
							// Thumbnail not found
						} else {
							// Put a placeholder with the post title
							switch ( $thumbnail_filler ) {
								// Placeholder provided by Placehold.it
								case 'placeholder':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								// Just for fun Kittens thanks to PlaceKitten
								case 'kittens':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placekitten.com/" . $thumbnail_size[0] . "/" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								// More fun Puppies thanks to PlaceDog
								case 'puppies':
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placedog.com/" . $thumbnail_size[0] . "/" . $thumbnail_size[1] . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
								case 'custom':
									if ( ! empty( $thumbnail_url ) ) {
										echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='" . $thumbnail_url . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									} else {
										echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									}
									break;
								// Boring by default ;)
								default:
									echo "<a href='" . $all_permalinks[ $field->guid ] . "'><img src='http://placehold.it/" . $thumbnail_wh . "&text=" . $field->post_title . "' alt='" . $field->post_title . "' title='" . $field->post_title . "' /></a>";
									break;
							}
						}
						// Back the current blog
						restore_current_blog();
						// Wrap Caption
						echo $html_tags['caption_o'];
						// Open title box
						echo $html_tags['title_o'];
						// Print the title
						echo "<a href='" . $all_permalinks[ $field->guid ] . "'>" . $field->post_title . "</a>";
						// Close the title box
						echo $html_tags['title_c'];
						if ( $full_meta === 'true' ) {
							// Open meta box
							echo $html_tags['meta_o'];
							// Set metainfo
							$author    = get_user_by( 'id', $field->post_author );
							$format    = (string) ${'date_format_' . $all_blogkeys[ $field->guid ]};
							$datepost  = date_i18n( $format, strtotime( trim( $field->post_date ) ) );
							$blog_name = '<a href="' . ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '">' . ${'blog_name_' . $all_blogkeys[ $field->guid ]} . "</a>";
							// The network's root (main blog) is called 'blog',
							// so we have to set this up because the url ignores the root's subdirectory
							if ( $all_blogkeys[ $field->guid ] == 1 ) {
								// Author's page for the main blog
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/blog/author/' . $author->user_login;
							} else {
								// Author's page for other blogs
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/author/' . $author->user_login;
							}
							// Print metainfo
							echo $blog_name . ' - ' . __( 'Published on', 'wpn-posts' ) . ' ' . $datepost . ' ' . __( 'by', 'wpn-posts' ) . ' ' . '<a href="' . $author_url . '">' . $author->display_name . '</a>';
							// Close meta box
							echo $html_tags['meta_c'];
						}
						// Print the content
						if ( $title_only === 'false' ) {
							// Open excerpt wrapper
							echo $html_tags['excerpt_o'];
							// Display excerpts or content
							if ( $display_content != 'true' ) {
								// Custom Excerpt
								if ( $auto_excerpt != 'true' ) {
									// Print out the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[ $field->guid ], $excerpt_trail );
									// Extract excerpt from content
								} else {
									// Get the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_content, $all_permalinks[ $field->guid ], $excerpt_trail );
								}
							} else {
								// Display post content
								echo nl2br( do_shortcode( $field->post_content ) );
							}
							// Close excerpt wrapper
							echo $html_tags['excerpt_c'];
						}
						// Close caption
						echo $html_tags['caption_c'];
						// Close thumbnail item placeholder
						echo $html_tags['thumbnail_ic'];
						// Close thumbnail container
						echo $html_tags['thumbnail_c'];
					} else {
						// Wrap Caption
						echo $html_tags['caption_o'];
						// Open title box
						echo $html_tags['title_o'];
						// Print the title
						echo "<a href='" . $all_permalinks[ $field->guid ] . "'>" . $field->post_title . "</a>";
						// Close the title box
						echo $html_tags['title_c'];
						if ( $full_meta === 'true' ) {
							// Open meta box
							echo $html_tags['meta_o'];
							// Set metainfo
							$author    = get_user_by( 'id', $field->post_author );
							$format    = (string) ${'date_format_' . $all_blogkeys[ $field->guid ]};
							$datepost  = date_i18n( $format, strtotime( trim( $field->post_date ) ) );
							$blog_name = '<a href="' . ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '">' . ${'blog_name_' . $all_blogkeys[ $field->guid ]} . "</a>";
							// The network's root (main blog) is called 'blog',
							// so we have to set this up because the url ignores the root's subdirectory
							if ( $all_blogkeys[ $field->guid ] == 1 ) {
								// Author's page for the main blog
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/blog/author/' . $author->user_login;
							} else {
								// Author's page for other blogs
								$author_url = ${'blog_url_' . $all_blogkeys[ $field->guid ]} . '/author/' . $author->user_login;
							}
							// Print metainfo
							echo $blog_name . ' - ' . __( 'Published on', 'wpn-posts' ) . ' ' . $datepost . ' ' . __( 'by', 'wpn-posts' ) . ' ' . '<a href="' . $author_url . '">' . $author->display_name . '</a>';
							// Close meta box
							echo $html_tags['meta_c'];
						}
						// Print the content
						if ( $title_only === 'false' ) {
							// Open excerpt wrapper
							echo $html_tags['excerpt_o'];
							// Display excerpts or content
							if ( $display_content != 'true' ) {
								// Custom Excerpt
								if ( $auto_excerpt != 'true' ) {
									// Print out the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[ $field->guid ], $excerpt_trail );
									// Extract excerpt from content
								} else {
									// Get the excerpt
									echo nlp_custom_excerpt( $excerpt_length, $field->post_content, $all_permalinks[ $field->guid ], $excerpt_trail );
								}
							} else {
								// Display post content
								echo nl2br( do_shortcode( $field->post_content ) );
							}
							// Close excerpt wrapper
							echo $html_tags['excerpt_c'];
						}
						// Close Caption
						echo $html_tags['caption_c'];
					}
					// Close item box
					echo $html_tags['item_c'];
				}
				// Close wrapper
				echo $html_tags['wrapper_c'];
				// Close content box
				echo $html_tags['content_c'];
			}
		}
		// Reset post data
		wp_reset_postdata();
	}



	/* HTML tags
	 * Styling purposes
	 * @display_type: ulist, olist, block, inline
	 * return @html_tags
	 */
	protected function nlp_display_type( $display_type, $instance, $wrapper_list_css, $wrapper_block_css ) {

		// Instances
		$nlp_instance = "nlp-instance-$instance";

		// Display Types
		switch ( $display_type ) {
			// Unordered list
			case "ulist":
				$html_tags = array(
					'wrapper_o'    => "<ul class='nlposts-wrapper nlposts-ulist $wrapper_list_css'>",
					'wrapper_c'    => "</ul>",
					'wtitle_o'     => "<h2 class='nlposts-ulist-wtitle'>",
					'wtitle_c'     => "</h2>",
					'item_o'       => "<li class='nlposts-ulist-litem'>",
					'item_c'       => "</li>",
					'content_o'    => "<div class='nlposts-container nlposts-ulist-container $nlp_instance'>",
					'content_c'    => "</div>",
					'meta_o'       => "<span class='nlposts-ulist-meta'>",
					'meta_c'       => "</span>",
					'thumbnail_o'  => "<ul class='nlposts-ulist-thumbnail thumbnails'>",
					'thumbnail_c'  => "</ul>",
					'thumbnail_io' => "<li class='nlposts-ulist-thumbnail-litem span3'><div class='thumbnail'>",
					'thumbnail_ic' => "</div></li>",
					'pagination_o' => "<div class='nlposts-ulist-pagination pagination'>",
					'pagination_c' => "</div>",
					'title_o'      => "<h3 class='nlposts-ulist-title'>",
					'title_c'      => "</h3>",
					'excerpt_o'    => "<ul class='nlposts-ulist-excerpt'><li>",
					'excerpt_c'    => "</li></ul>",
					'caption_o'    => "<div class='nlposts-caption'>",
					'caption_c'    => "</div>"
				);
				$html_tags = apply_filters( 'nlposts_ulist_output', $html_tags );
				break;
			// Ordered list
			case "olist":
				$html_tags = array(
					'wrapper_o'    => "<ol class='nlposts-wrapper nlposts-olist $wrapper_list_css'>",
					'wrapper_c'    => "</ol>",
					'wtitle_o'     => "<h2 class='nlposts-olist-wtitle'>",
					'wtitle_c'     => "</h2>",
					'item_o'       => "<li class='nlposts-olist-litem'>",
					'item_c'       => "</li>",
					'content_o'    => "<div class='nlposts-container nlposts-olist-container $nlp_instance'>",
					'content_c'    => "</div>",
					'meta_o'       => "<span class='nlposts-olist-meta'>",
					'meta_c'       => "</span>",
					'thumbnail_o'  => "<ul class='nlposts-olist-thumbnail thumbnails'>",
					'thumbnail_c'  => "</ul>",
					'thumbnail_io' => "<li class='nlposts-olist-thumbnail-litem span3'>",
					'thumbnail_ic' => "</li>",
					'pagination_o' => "<div class='nlposts-olist-pagination pagination'>",
					'pagination_c' => "</div>",
					'title_o'      => "<h3 class='nlposts-olist-title'>",
					'title_c'      => "</h3>",
					'excerpt_o'    => "<ul class='nlposts-olist-excerpt'><li>",
					'excerpt_c'    => "</li></ul>",
					'caption_o'    => "<div class='nlposts-caption'>",
					'caption_c'    => "</div>"
				);
				$html_tags = apply_filters( 'nlposts_olist_output', $html_tags );
				break;
			// Block
			case "block":
				$html_tags = array(
					'wrapper_o'    => "<div class='nlposts-wrapper nlposts-block $wrapper_block_css'>",
					'wrapper_c'    => "</div>",
					'wtitle_o'     => "<h2 class='nlposts-block-wtitle'>",
					'wtitle_c'     => "</h2>",
					'item_o'       => "<div class='nlposts-block-item'>",
					'item_c'       => "</div>",
					'content_o'    => "<div class='nlposts-container nlposts-block-container $nlp_instance'>",
					'content_c'    => "</div>",
					'meta_o'       => "<span class='nlposts-block-meta'>",
					'meta_c'       => "</span>",
					'thumbnail_o'  => "<ul class='nlposts-block-thumbnail thumbnails'>",
					'thumbnail_c'  => "</ul>",
					'thumbnail_io' => "<li class='nlposts-block-thumbnail-litem span3'>",
					'thumbnail_ic' => "</li>",
					'pagination_o' => "<div class='nlposts-block-pagination pagination'>",
					'pagination_c' => "</div>",
					'title_o'      => "<h3 class='nlposts-block-title'>",
					'title_c'      => "</h3>",
					'excerpt_o'    => "<div class='nlposts-block-excerpt'><p>",
					'excerpt_c'    => "</p></div>",
					'caption_o'    => "<div class='nlposts-caption'>",
					'caption_c'    => "</div>"
				);
				$html_tags = apply_filters( 'nlposts_block_output', $html_tags );
				break;
			default:
				// Unordered list
				$html_tags = array(
					'wrapper_o'    => "<ul class='nlposts-wrapper nlposts-ulist $wrapper_list_css'>",
					'wrapper_c'    => "</ul>",
					'wtitle_o'     => "<h2 class='nlposts-ulist-wtitle'>",
					'wtitle_c'     => "</h2>",
					'item_o'       => "<li class='nlposts-ulist-litem'>",
					'item_c'       => "</li>",
					'content_o'    => "<div class='nlposts-container nlposts-ulist-container $nlp_instance'>",
					'content_c'    => "</div>",
					'meta_o'       => "<span class='nlposts-ulist-meta'>",
					'meta_c'       => "</span>",
					'thumbnail_o'  => "<ul class='nlposts-ulist-thumbnail thumbnails'>",
					'thumbnail_c'  => "</ul>",
					'thumbnail_io' => "<li class='nlposts-ulist-thumbnail-litem span3'>",
					'thumbnail_ic' => "</li>",
					'pagination_o' => "<div class='nlposts-ulist-pagination pagination'>",
					'pagination_c' => "</div>",
					'title_o'      => "<h3 class='nlposts-ulist-title'>",
					'title_c'      => "</h3>",
					'excerpt_o'    => "<ul class='nlposts-ulist-excerpt'><li>",
					'excerpt_c'    => "</li></ul>",
					'caption_o'    => "<div class='nlposts-caption'>",
					'caption_c'    => "</div>"
				);
				$html_tags = apply_filters( 'nlposts_default_output', $html_tags );
				break;
		}

		// Return tags
		return $html_tags;
	}


}