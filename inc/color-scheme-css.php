<?php
/**
 * Color Scheme CSS
 *
 * @package Karis
 */

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function karis_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = karis_get_color_scheme();

	$colors = array(
		'accent_color'       => $color_scheme[0],
		'accent_hover_color' => $color_scheme[1],
	);

  $color_scheme_css = karis_get_color_scheme_css( $colors );

	wp_add_inline_style( 'karis-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'karis_color_scheme_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function karis_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'accent_color'       => '',
		'accent_hover_color' => '',
	) );

	$css = '
		/* COLOR SCHEME */
		/* ACCENT COLOR */
		a,
		.button--menu-toggle:hover,
		.button--menu-toggle:focus,
		.page-links a:hover,
		.page-links a:focus,
		.page-links > span:not(.page-links-title),
		.attachment .post-navigation a:hover,
		.attachment .post-navigation a:focus,
		.pagination .page-numbers.current,
		.pagination a:hover,
		.pagination a:focus,
		.entry__content .has-accent-color,
		.entry__meta .sticky-post,
		.entry__title a:hover,
		.entry__title a:focus,
		.entry__footer .byline a:hover,
		.entry__footer .byline a:focus,
		.post-card__title a:hover,
		.post-card__title a:focus,
		.comment-reply-title small a:hover,
		.comment-reply-title small a:focus {
			color: ' . $colors['accent_color'] . ';
		}

		mark,
		ins,
		::selection,
		.button,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button--menu-toggle:hover .icon-bar,
		.button--menu-toggle:focus .icon-bar,
		.entry__content .has-accent-background-color,
		.entry__content .wp-block-button__link:not(.has-background),
		.entry__content .wp-block-file .wp-block-file__button,
		.widget_calendar tbody a:hover,
		.widget_calendar tbody a:focus,
		button.button--show-comments:hover,
		button.button--show-comments:focus,
		.comment-author .post-author-badge,
		.comment.bypostauthor:not(.comment--has-avatar) > article .comment-author .fn::after,
		.comment-reply-link:hover,
		.comment-reply-link:focus {
			background-color: ' . $colors['accent_color'] . ';
		}

		.comment-reply-link:hover,
		.comment-reply-link:focus {
			border-color: ' . $colors['accent_color'] . ';
		}

		@media only screen and (min-width: 960px) {
			.header__menu li:hover > a,
			.header__menu li.focus > a,
			.header__menu a:hover,
			.header__menu a:focus,
			.header__menu .current-menu-item > a,
			.header__menu .current-menu-ancestor > a {
				color: ' . $colors['accent_color'] . ';
			}
		}

		/* ACCENT HOVER COLOR */
		a:hover,
		a:focus,
		a:active,
		.menu--social li a:hover,
		.menu--social li a:focus,
		.comment-navigation a:hover,
		.comment-navigation a:focus,
		.entry__content .has-accent-hover-color,
		.widget ul li > a:hover,
		.widget ul li > a:focus,
		.widget_calendar tfoot a:hover,
		.widget_calendar tfoot a:focus,
		.widget_recent_comments ul li .comment-author-link a:hover,
		.widget_recent_comments ul li .comment-author-link a:focus,
		.widget_rss .widget-title > a:hover,
		.widget_rss .widget-title > a:focus,
		.tagcloud .tag-cloud-link:hover,
		.tagcloud .tag-cloud-link:focus,
		.tagcloud .tag-cloud-link:hover .tag-link-count,
		.tagcloud .tag-cloud-link:focus .tag-link-count,
		.entry__meta .cat-links a:hover,
		.entry__meta .cat-links a:focus,
		.post-card__meta .cat-links a:hover,
		.post-card__meta .cat-links a:focus,
		.author-info__title a:hover,
		.author-info__title a:focus,
		.comment-author .url:hover,
		.comment-author .url:focus,
		.footer a:hover,
		.footer a:focus {
			color: ' . $colors['accent_hover_color'] . ';
		}

		.button:hover,
		.button:focus,
		button:hover,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:focus,
		.entry__content .has-accent-hover-background-color,
		.entry__content .wp-block-file .wp-block-file__button:hover,
		.entry__content .wp-block-file .wp-block-file__button:focus,
		.entry__footer .tags-links a:hover,
		.entry__footer .tags-links a:focus,
		.widget ul.children .current-cat::before,
		.widget ul.children .current-menu-item::before,
		.widget ul.children .current_page_item::before,
		.widget ul.sub-menu .current-cat::before,
		.widget ul.sub-menu .current-menu-item::before,
		.widget ul.sub-menu .current_page_item::before {
			background-color: ' . $colors['accent_hover_color'] . ';
		}

		.entry__meta .cat-links a,
		.post-card__meta .cat-links a {
			background-image: linear-gradient(to top, ' . $colors['accent_hover_color'] . ' 0px, ' . $colors['accent_hover_color'] . ' 0px), linear-gradient(to top, rgba(28, 29, 33, .15) 0px, rgba(28, 29, 33, .15) 0px);
		}
	';

	/**
	 * Filters custom colors CSS.
	 *
	 * @param string $css Base theme colors CSS.
	 */
	return apply_filters( 'karis_get_color_scheme_css', $css );
}

/**
 * Enqueues front-end CSS for accent color.
 *
 * @see wp_add_inline_style()
 */
function karis_accent_color_css() {
	$color_scheme  = karis_get_color_scheme();
	$default_color = $color_scheme[0];
	$accent_color  = get_theme_mod( 'accent_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $accent_color === $default_color ) {
		return;
	}

	$css = '
		/* CUSTOM ACCENT COLOR */
		a,
		.button--menu-toggle:hover,
		.button--menu-toggle:focus,
		.page-links a:hover,
		.page-links a:focus,
		.page-links > span:not(.page-links-title),
		.attachment .post-navigation a:hover,
		.attachment .post-navigation a:focus,
		.pagination .page-numbers.current,
		.pagination a:hover,
		.pagination a:focus,
		.entry__content .has-accent-color,
		.entry__meta .sticky-post,
		.entry__title a:hover,
		.entry__title a:focus,
		.entry__footer .byline a:hover,
		.entry__footer .byline a:focus,
		.post-card__title a:hover,
		.post-card__title a:focus,
		.comment-reply-title small a:hover,
		.comment-reply-title small a:focus {
			color: %1$s;
		}

		mark,
		ins,
		::selection,
		.button,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button--menu-toggle:hover .icon-bar,
		.button--menu-toggle:focus .icon-bar,
		.entry__content .has-accent-background-color,
		.entry__content .wp-block-button__link:not(.has-background),
		.entry__content .wp-block-file .wp-block-file__button,
		.widget_calendar tbody a:hover,
		.widget_calendar tbody a:focus,
		button.button--show-comments:hover,
		button.button--show-comments:focus,
		.comment-author .post-author-badge,
		.comment.bypostauthor:not(.comment--has-avatar) > article .comment-author .fn::after,
		.comment-reply-link:hover,
		.comment-reply-link:focus {
			background-color: %1$s;
		}

		.comment-reply-link:hover,
		.comment-reply-link:focus {
			border-color: %1$s;
		}

		@media only screen and (min-width: 960px) {
			.header__menu li:hover > a,
			.header__menu li.focus > a,
			.header__menu a:hover,
			.header__menu a:focus,
			.header__menu .current-menu-item > a,
			.header__menu .current-menu-ancestor > a {
				color: %1$s;
			}
		}
	';

	wp_add_inline_style( 'karis-style', sprintf( $css, $accent_color ) );
}
add_action( 'wp_enqueue_scripts', 'karis_accent_color_css', 11 );

/**
 * Enqueues front-end CSS for accent hover color.
 *
 * @see wp_add_inline_style()
 */
function karis_accent_hover_color_css() {
	$color_scheme       = karis_get_color_scheme();
	$default_color      = $color_scheme[1];
	$accent_hover_color = get_theme_mod( 'accent_hover_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $accent_hover_color === $default_color ) {
		return;
	}

	$css = '
		/* CUSTOM ACCENT HOVER COLOR */
		a:hover,
		a:focus,
		a:active,
		.menu--social li a:hover,
		.menu--social li a:focus,
		.comment-navigation a:hover,
		.comment-navigation a:focus,
		.entry__content .has-accent-hover-color,
		.widget ul li > a:hover,
		.widget ul li > a:focus,
		.widget_calendar tfoot a:hover,
		.widget_calendar tfoot a:focus,
		.widget_recent_comments ul li .comment-author-link a:hover,
		.widget_recent_comments ul li .comment-author-link a:focus,
		.widget_rss .widget-title > a:hover,
		.widget_rss .widget-title > a:focus,
		.tagcloud .tag-cloud-link:hover,
		.tagcloud .tag-cloud-link:focus,
		.tagcloud .tag-cloud-link:hover .tag-link-count,
		.tagcloud .tag-cloud-link:focus .tag-link-count,
		.entry__meta .cat-links a:hover,
		.entry__meta .cat-links a:focus,
		.post-card__meta .cat-links a:hover,
		.post-card__meta .cat-links a:focus,
		.author-info__title a:hover,
		.author-info__title a:focus,
		.comment-author .url:hover,
		.comment-author .url:focus,
		.footer a:hover,
		.footer a:focus {
			color: %1$s;
		}

		.button:hover,
		.button:focus,
		button:hover,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:focus,
		.entry__content .has-accent-hover-background-color,
		.entry__content .wp-block-file .wp-block-file__button:hover,
		.entry__content .wp-block-file .wp-block-file__button:focus,
		.entry__footer .tags-links a:hover,
		.entry__footer .tags-links a:focus,
		.widget ul.children .current-cat::before,
		.widget ul.children .current-menu-item::before,
		.widget ul.children .current_page_item::before,
		.widget ul.sub-menu .current-cat::before,
		.widget ul.sub-menu .current-menu-item::before,
		.widget ul.sub-menu .current_page_item::before {
			background-color: %1$s;
		}

		.entry__meta .cat-links a,
		.post-card__meta .cat-links a {
			background-image: linear-gradient(to top, %1$s 0px, %1$s 0px), linear-gradient(to top, rgba(28, 29, 33, .15) 0px, rgba(28, 29, 33, .15) 0px);
		}
	';

	wp_add_inline_style( 'karis-style', sprintf( $css, $accent_hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'karis_accent_hover_color_css', 11 );

/**
 * Generate the CSS for custom editor colors.
 */
function karis_custom_editor_colors_css() {
	$color_scheme       = karis_get_color_scheme();
	$accent_color       = $color_scheme[0];
	$accent_hover_color = $color_scheme[1];

	if ( $accent_color !== get_theme_mod( 'accent_color', $accent_color ) ) {
		$accent_color = get_theme_mod( 'accent_color', $accent_color );
	}

	if ( $accent_hover_color !== get_theme_mod( 'accent_hover_color', $accent_hover_color ) ) {
		$accent_hover_color = get_theme_mod( 'accent_hover_color', $accent_hover_color );
	}

	$editor_css = '
		/* CUSTOM ACCENT COLOR */
		.editor-block-list__layout .editor-block-list__block a,
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__textlink,
		.editor-block-list__layout .editor-block-list__block .wp-block-freeform a {
			color: ' . $accent_color . ';
		}

		.editor-block-list__layout .editor-block-list__block mark,
		.editor-block-list__layout .editor-block-list__block ins,
		.editor-block-list__layout .editor-block-list__block .wp-block-button__link:not(.has-background),
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button {
			background-color: ' . $accent_color . ';
		}

		/* CUSTOM ACCENT HOVER COLOR */
		.editor-block-list__layout .editor-block-list__block a:hover,
		.editor-block-list__layout .editor-block-list__block a:focus,
		.editor-block-list__layout .editor-block-list__block a:active,
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__textlink:hover,
		.editor-block-list__layout .editor-block-list__block .wp-block-freeform a:hover,
		.editor-block-list__layout .editor-block-list__block .wp-block-freeform a:focus,
		.editor-block-list__layout .editor-block-list__block .wp-block-freeform a:active {
			color: ' . $accent_hover_color . ';
		}

		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button:hover,
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button:focus {
			background-color: ' . $accent_hover_color . ';
		}
	';

	/**
	 * Filters Karis custom editor colors CSS.
	 *
	 * @param string $editor_css 	Base theme colors CSS.
	 */
	return apply_filters( 'karis_custom_editor_colors_css', $editor_css );
}
