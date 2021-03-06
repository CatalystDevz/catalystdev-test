<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Enliven
 */

if ( ! function_exists( 'enliven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function enliven_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'enliven' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'enliven' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'enliven_arc_posted_on' ) ) :

function enliven_arc_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	echo '<span class="arc-posted-on">' . $posted_on . '</span><span class="arc-byline">' . $byline . '</span>'; // WPCS: XSS OK.

	if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="arc-comments-link"><?php comments_popup_link( __( 'Leave a comment', 'enliven' ), '1 Comment', '% Comments' ); ?></span>
	<?php endif;

}

endif;

if ( ! function_exists( 'enliven_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function enliven_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'enliven' ) );
		if ( $categories_list && enliven_categorized_blog() ) {
			printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'enliven' ) . '</div>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'enliven' ) );
		if ( $tags_list ) {
			printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'enliven' ) . '</div>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'enliven' ), esc_html__( '1 Comment', 'enliven' ), esc_html__( '% Comments', 'enliven' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'enliven' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'enliven_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function enliven_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'enliven' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'enliven' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'enliven' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'enliven' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'enliven' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'enliven' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'enliven' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'enliven' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'enliven' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'enliven' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'enliven' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'enliven' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function enliven_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'enliven_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'enliven_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so enliven_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so enliven_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in enliven_categorized_blog.
 */
function enliven_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'enliven_categories' );
}
add_action( 'edit_category', 'enliven_category_transient_flusher' );
add_action( 'save_post',     'enliven_category_transient_flusher' );


if ( ! function_exists( 'enliven_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function enliven_paging_nav( $max_num_pages = '' ) {
	// Get max_num_pages if not provided
	if ( '' == $max_num_pages )
		$max_num_pages = $GLOBALS['wp_query']->max_num_pages;

	// Don't print empty markup if there's only one page.
	if ( $max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation enl-paging-navigation clear" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'enliven' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link( '', $max_num_pages ) ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">Previous</span>', 'enliven' ), $max_num_pages ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link( '', $max_num_pages ) ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">Next</span>', 'enliven' ), $max_num_pages ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'enliven_get_header_image' ) ) :

function enliven_get_header_image() {

	$header_type = get_theme_mod( 'enliven_main_header_type', 'alternate-image' );
	$image_url = '';

	if ( $header_type == 'alternate-image' ) {

	    $image_id = get_post_thumbnail_id();
	    $imagesize = "full";
	    $image_properties = wp_get_attachment_image_src($image_id, $imagesize);

	    if ( $image_properties ) {
	    	$image_url = $image_properties[0];
	    } elseif ( get_header_image() ) {
	    	$image_url = get_header_image();
	    } else {
	    	$image_url = '';
	    }

    } elseif ( $header_type == 'header-image' && get_header_image() ) {

    	$image_url = get_header_image();

    } elseif ( $header_type == 'featured-image' ) {

		$image_id = get_post_thumbnail_id();
	    $imagesize = "full";
	    $image_properties = wp_get_attachment_image_src($image_id, $imagesize);

	    if ( $image_properties ) {
	    	$image_url = $image_properties[0];
	    }
	}

	return $image_url;

}

endif;