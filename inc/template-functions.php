<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package Karis
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function karis_body_classes( $classes ) {
	if ( ! is_singular() ) {
		// Adds a class of hfeed to non-singular pages.
		$classes[] = 'hfeed';

		// Adds a class of content layout to non-singular pages.
		$classes[] = 'content-layout--' . get_theme_mod( 'content_layout', 'classic' );
	}

	// Get the color scheme or the default if there isn't one.
	$classes[] = 'color-scheme--' . get_theme_mod( 'color_scheme', 'default' );

	// Add classes if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'karis-customizer';

		if ( is_front_page() && get_query_var( 'paged' ) == 0 ) {
			$classes[] = 'featured--enabled';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'karis_body_classes' );

/**
 * Adds classes for header.
 *
 * @param array $classes Classes for header element.
 * @return array
 */
function karis_add_header_classes( $classes = '' ) {
	$classes = array();

	$classes[] = 'header';

	return array_unique( $classes );
}

/**
 * Get classes for header.
 *
 * @param array $class Classes for header element.
 */
function karis_header_classes( $classes = '' ) {
	// Separates classes with a single space
	echo join( ' ', karis_add_header_classes( $classes ) );
}

if ( ! function_exists( 'karis_post_card_classes' ) ) :
	/**
	 * Adds classes for post-cards.
	 *
	 * Create your own karis_post_card_classes() function to override in a child theme.
	 */
	function karis_post_card_classes() {
		if ( post_password_required() || ! has_post_thumbnail() ) {
			return;
		}

		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		// Calculate aspect ratio: h / w * 100%.
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;

		if ( $ratio > 100 ) {
			$classes = ' post-card__thumbnail--portrait';
		} elseif ( $ratio < 100 ) {
			$classes = ' post-card__thumbnail--landscape';
		} else {
			$classes = ' post-card__thumbnail--square';
		}

		echo esc_attr( $classes );
	}
endif;

/**
 * Adds custom classes to the array of comment classes.
 *
 * @param array $classes Classes for the comment element.
 * @return array
 */
function karis_comment_classes( $classes ) {
	if ( get_option( 'show_avatars' ) ) {
		$classes[] = 'comment--has-avatar';
	}

	return $classes;
}
add_filter( 'comment_class', 'karis_comment_classes' );

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function karis_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function karis_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( is_attachment() ) {
		if ( 1280 < $width ) {
			$sizes = '(max-width: 479px) calc(100vw - 2rem), (max-width: 1359px) calc(100vw - 5rem), 1280px';
		} elseif ( 1280 >= $width && 960 < $width) {
			$sizes = '(max-width: 479px) calc(100vw - 2rem), (max-width: 1039px) calc(100vw - 5rem), (max-width: ' . $width . 'px) calc(' . $width . 'px - 5rem), ' . $width . 'px';
		} elseif ( 960 >= $width && 720 < $width) {
			$sizes = '(max-width: 479px) calc(100vw - 2rem), (max-width: 800px) calc(100vw - 5rem), (max-width: ' . $width . 'px) calc(' . $width . 'px - 5rem), ' . $width . 'px';
		} elseif ( 720 >= $width && 480 <= $width) {
			$sizes = '(max-width: 479px) calc(100vw - 2rem), (max-width: ' . $width . 'px) calc(' . $width . 'px - 5rem), ' . $width . 'px';
		} elseif ( 480 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) calc(' . $width . 'px - 2rem), ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'karis_content_image_sizes_attr', 10 , 2 );

/**
 * Template functions to display template parts.
 *
 * Template parts for this functions can be found
 * in the "template-parts" folder.
 */

if ( ! function_exists( 'karis_skip_link' ) ) :
	/**
	 * Prints HTML for skip link.
	 *
	 * Create your own karis_skip_link() function to override in a child theme.
	 *
	 * @return string
	 */
	function karis_skip_link() {
		?>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'karis' ); ?></a>
		<?php
	}
endif;

/**
 * Prints HTML for header panel.
 */
function karis_site_branding() {
	get_template_part( 'template-parts/header/site-branding' );
}

/**
 * Prints HTML for header menu.
 */
function karis_header_menu() {
	get_template_part( 'template-parts/navigation/header-menu' );
}

/**
 * Prints HTML for featured content.
 */
function karis_featured_content() {
	if ( is_front_page() && get_query_var( 'paged' ) == 0 ) {
		$featured_content = get_theme_mod( 'featured_content', 'no' );

		if ( 'no' !== $featured_content ) :
			// Display featured content.
			get_template_part( 'template-parts/featured/featured', $featured_content );
		elseif ( is_customize_preview() ) :
			// Or display featured content placeholder.
			echo '<div id="featured-content-area" class="featured-content-area featured-content-area--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Featured Content Placeholder', 'karis' ) . '</h3></div>';
		endif;
	}
}

if ( ! function_exists( 'karis_pagination' ) ) :
	/**
	 * Prints HTML for previous/next page navigation.
	 *
	 * Create your own karis_pagination() function to override in a child theme.
	 */
	function karis_pagination() {
		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => esc_html__( 'Previous', 'karis' ),
			'next_text'          => esc_html__( 'Next', 'karis' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'karis' ) . ' </span>',
		) );
	}
endif;

if ( ! function_exists( 'karis_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post - sticky post, category and edit link.
	 *
	 * Create your own karis_entry_meta() function to override in a child theme.
	 */
	function karis_entry_meta() {
		echo '<div class="entry__meta">';

		// Hide for pages.
		if ( 'post' === get_post_type() ) {
			karis_categories_list();
		}

		// Hide for pages.
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			karis_entry_date();
		}

		karis_sticky_post();
		karis_edit_link();
		echo '</div><!-- .entry__meta -->';
	}
endif;

if ( ! function_exists( 'karis_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the current post - tags.
	 *
	 * Create your own karis_entry_footer() function to override in a child theme.
	 */
	function karis_entry_footer() {
		// Visible only on single post.
		if ( is_singular() && 'post' === get_post_type() ) {
			echo '<footer class="entry__footer">';
			karis_tags_list();

			if ( '' === get_the_author_meta( 'description' ) ) {
				karis_byline();
			}

			echo '</footer><!-- .entry__footer -->';
		}
	}
endif;

if ( ! function_exists( 'karis_postcard_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post - sticky post and category.
	 *
	 * Create your own karis_postcard_meta() function to override in a child theme.
	 */
	function karis_postcard_meta( $class = 'post-card__meta' ) {
		// Hide for pages.
		if ( 'post' === get_post_type() ) :
			echo '<div class="' . esc_attr( $class ) . '">';
			karis_category();
			karis_entry_date();
			echo '</div><!--' . esc_attr( $class ) . '-->';
		endif;
	}
endif;

if ( ! function_exists( 'karis_postcard_footer' ) ) :
	/**
	 * Prints HTML with meta information for the current post - author link and comments count.
	 *
	 * Create your own karis_postcard_footer() function to override in a child theme.
	 */
	function karis_postcard_footer( $class = 'post-card__footer' ) {
		// Hide for pages.
		if ( 'post' === get_post_type() ) :
			echo '<div class="' . esc_attr( $class ) . '">';
			karis_more_link();
			echo '</div><!--' . esc_attr( $class ) . '-->';
		endif;
	}
endif;

if ( ! function_exists( 'karis_page_links' ) ) :
	/**
	 * Prints HTML for page links.
	 *
	 * Create your own karis_page_links() function to override in a child theme.
	 */
	function karis_page_links() {
		if ( is_singular() ) {
			wp_link_pages( array(
				'before'      => '<div class="clear"></div><div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'karis' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'karis' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		}
	}
endif;

/**
 * Prints HTML for author info.
 */
function karis_author_info() {
	if ( '' !== get_the_author_meta( 'description' ) ) :
		get_template_part( 'template-parts/post/author-info' );
	endif;
}

/**
 * Prints HTML for post navigation.
 */
function karis_post_navigation() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( 'enable' === get_theme_mod( 'post_navigation', 'enable' ) ) :
		get_template_part( 'template-parts/navigation/post-navigation' );
	elseif ( is_customize_preview() ) :
		echo '<section class="post-navigation-area post-navigation--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Post Navigation Placeholder', 'karis' ) . '</h3></section>';
	endif;
}

/**
 * Prints HTML for content widgets.
 */
function karis_content_widgets() {
	if ( is_singular( 'post' ) ) :
		get_template_part( 'template-parts/post/content-widgets' );
	endif;
}

/**
 * Prints HTML for related posts.
 */
function karis_related_posts() {
	if ( ! is_single() || is_attachment() ) {
		return;
	}

	if ( 'enable' === get_theme_mod( 'related_posts', 'enable' ) ) :
		get_template_part( 'template-parts/related-posts' );
	elseif ( is_customize_preview() ) :
		echo '<section id="related-posts" class="related-posts related-posts--placeholder"><h3 class="placeholder__title">' . esc_html__( 'Related Posts Placeholder', 'karis' ) . '</h3></section>';
	endif;
}

/**
 * Prints HTML for footer widgets.
 */
function karis_footer_widgets() {
	get_template_part( 'template-parts/footer/footer', 'widgets' );
}

/**
 * Prints HTML for footer site-info.
 */
function karis_site_info() {
	echo '<div class="site-info footer__site-info">';
	// Prints HTML for copyright.
	get_template_part( 'template-parts/footer/footer', 'copyright' );
	// Prints HTML for social menu.
	if ( has_nav_menu( 'social-menu' ) ) :
		get_template_part( 'template-parts/navigation/social-menu' );
	endif;
	echo '</div>';
}

/**
 * Prints HTML for search overlay.
 */
function karis_search_overlay() {
	get_template_part( 'template-parts/search-overlay' );
}
