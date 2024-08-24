<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Karis
 */

if ( ! function_exists( 'karis_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 * Does nothing if the custom logo is not available.
	 *
	 * Create your own karis_the_custom_logo() function to override in a child theme.
	 */
	function karis_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

if ( ! function_exists( 'karis_sticky_post' ) ) :
	/**
	 * Displays the sticky post HTML.
	 *
	 * Create your own karis_sticky_post() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_sticky_post() {
		if ( is_sticky() && is_home() && ! is_paged() ) :
			echo '<span class="sticky-post">' . esc_html__( 'Featured', 'karis' ) . '</span>';
		endif;
	}
endif;

if ( ! function_exists( 'karis_category' ) ) :
	/**
	 * Returns first category.
	 *
	 * Create your own karis_category() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_category() {
		// Display only first category, if post has more than one.
		$category = get_the_category();

		if ( ! empty( $category ) ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Category ', 'karis' ) . '</span><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->name ) . '</a></span>';
		}
	}
endif;

if ( ! function_exists( 'karis_categories_list' ) ) :
	/**
	 * Returns categories list.
	 *
	 * Create your own karis_categories_list() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_categories_list() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'karis' ) );

		if ( $categories_list && karis_categorized_blog() ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Categories ', 'karis' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'karis_categorized_blog' ) ) :
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * Create your own karis_categorized_blog() function to override in a child theme.
	 *
	 * @return bool
	 */
	function karis_categorized_blog() {
		$category_count = get_transient( 'karis_categories' );

		if ( false === $category_count ) {
			// Create an array of all the categories that are attached to posts.
			$categories = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$category_count = count( $categories );

			set_transient( 'karis_categories', $category_count );
		}

		// Allow viewing case of 0 or 1 categories in post preview.
		if ( is_preview() ) {
			return true;
		}

		return $category_count > 1;
	}
endif;

/**
 * Flush out the transients used in karis_categorized_blog.
 */
function karis_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'karis_categories' );
}
add_action( 'edit_category', 'karis_category_transient_flusher' );
add_action( 'save_post',     'karis_category_transient_flusher' );

if ( ! function_exists( 'karis_entry_date' ) ) :
	/**
	 * Gets a nicely formatted string for the published date.
	 *
	 * Create your own karis_entry_date() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_entry_date() {
		$time_string = '<time class="entry__date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry__date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		printf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s</span>', esc_html_x( 'Posted on ', 'Used before post date.', 'karis' ) ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'karis_edit_link' ) ) :
	/**
	 * Returns an accessibility-friendly link to edit a post or page.
	 *
	 * Create your own karis_edit_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_edit_link() {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit<span class="screen-reader-text"> %s</span>', 'karis' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'karis_tags_list' ) ) :
	/**
	 * Returns tags list.
	 *
	 * Create your own karis_tags_list() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_tags_list() {
		$tags_list = get_the_tag_list();

		if ( $tags_list ) {
			printf( '<div class="tags-links">%1$s</div>',
				$tags_list
			);
		}
	}
endif;

if ( ! function_exists( 'karis_byline' ) ) :
	/**
	 * Returns byline.
	 *
	 * Create your own karis_byline() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_byline() {
		$byline_avatar = '';

		if ( get_option( 'show_avatars' ) ) {
			$byline_avatar_size = apply_filters( 'karis_byline_avatar_size', 32 );

			$byline_avatar = sprintf(
				'<span class="avatar__wrapper">' . get_avatar( get_the_author_meta( 'user_email' ), $byline_avatar_size ) . '</span>'
			);
		}

		printf(
			'<div class="byline"><span class="author vcard"><a class="url fn n" href="%1$s">%2$s%3$s</a></span></div>',
			/* translators: 1: author link. 2: post author avatar. 3: post author. */
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			$byline_avatar,
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'karis_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Create your own karis_post_thumbnail() function to override in a child theme.
	 */
	function karis_post_thumbnail( $size = 'post-thumbnail', $custom_attr = array() ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {
			$default_attr = array( 'sizes' => '100vw' );
		} else {
			$default_attr = array( 'sizes' => '(max-width: 479px) calc(100vw - 2rem), (max-width: 1359px) calc(100vw - 5rem), 1280px' );
		}

		$attr = array_merge( $default_attr, $custom_attr );

		if ( is_singular() ) : ?>

			<figure class="post__thumbnail">
				<div class="post__thumbnail-wrapper">
					<?php the_post_thumbnail( $size, $attr ); ?>
				</div>
			</figure><!-- .post__thumbnail -->

		<?php
		else :

			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
			// Calculate aspect ratio: h / w * 100%.
			$ratio = $thumbnail[2] / $thumbnail[1] * 100; ?>

			<figure class="post__thumbnail">
				<div class="post__thumbnail-wrapper" style="width: <?php echo esc_attr( $thumbnail[1] ); ?>px;">
					<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" style="padding-top: <?php echo esc_attr( $ratio ); ?>%">
						<?php the_post_thumbnail( $size, $attr ); ?>
					</a>
				</div>
			</figure><!-- .post__thumbnail -->

		<?php
		endif; // End is_singular()
	}
endif;

if ( ! function_exists( 'karis_post_card_thumbnail' ) ) :
	/**
	 * Displays an optional post card thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element and adds a padding-top style
	 * to the anchor depending on the aspect ratio of the post thumbnail.
	 *
	 * Create your own karis_post_card_thumbnail() function to override in a child theme.
	 */
	function karis_post_card_thumbnail( $size = 'post-thumbnail', $classes = 'post-card__thumbnail', $custom_attr = array(), $crop = true ) {
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}

		$default_attr = array( 'sizes' => '(max-width: 599px) calc(100vw - 3rem), (max-width: 767px) calc(100vw - 6rem), (max-width: 895px) calc(50vw - 4.5rem), (max-width: 1279px) 376px, (max-width: 1391px) 339px, 376px' );
		$attr = array_merge( $default_attr, $custom_attr );

		if ( true === $crop ) :

			$classes = $classes . ' ' . $classes . '--cropped'; ?>

			<figure class="<?php echo esc_attr( $classes ); ?>">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					if ( 'thumbnail' === $size ) {
						the_post_thumbnail( $size );
					} else {
						the_post_thumbnail( $size, $attr );
					} ?>
				</a>
			</figure><!-- .post-card__thumbnail -->

		<?php
		else : ?>

			<?php
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
			// Calculate aspect ratio: h / w * 100%.
			$ratio = $thumbnail[2] / $thumbnail[1] * 100;
			?>

			<figure class="<?php echo esc_attr( $classes ); ?>">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" style="padding-top: <?php echo esc_attr( $ratio ); ?>%">
					<?php
					if ( 'thumbnail' === $size ) {
						the_post_thumbnail( $size );
					} else {
						the_post_thumbnail( $size, $attr );
					} ?>
				</a>
			</figure><!-- .post-card__thumbnail -->

		<?php
		endif;
	}
endif;

if ( ! function_exists( 'karis_modify_more_link' ) ) :
	/**
	 * Modify read more link.
	 *
	 * Create your own karis_modify_more_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_modify_more_link() {
		$link = sprintf( '<p><a href="%1$s" class="more-link">%2$s</a></p>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'karis' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);
		return $link;
	}
	add_filter( 'the_content_more_link', 'karis_modify_more_link' );
endif;

if ( ! function_exists( 'karis_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own karis_excerpt() function to override in a child theme.
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function karis_excerpt( $class = 'entry__summary' ) {
		if ( has_excerpt() || is_search() ) :
			echo '<div class="' . esc_attr( $class ) . '">';
			the_excerpt();
			echo '</div><!--' . esc_attr( $class ) . '-->';
		endif;
	}
endif;

if ( ! function_exists( 'karis_excerpt_more' ) && ! is_admin() ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own karis_excerpt_more() function to override in a child theme.
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function karis_excerpt_more() {
		$link = sprintf( '<br /><br /><a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'karis' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);
		return ' &hellip; ' . $link;
	}
	add_filter( 'excerpt_more', 'karis_excerpt_more' );
endif;

if ( ! function_exists( 'karis_more_link' ) ) :
	/**
	 * Prints HTML with read more link.
	 *
	 * Create your own karis_more_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_more_link() {
		printf( '<span><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'karis' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title( get_the_ID() ) )
		);
	}
endif;
