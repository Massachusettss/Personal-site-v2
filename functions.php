<?php
/**
 * Karis functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Karis
 */

/**
 * Karis only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function karis_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on karis, use a find and replace
	 * to change 'karis' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'karis', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 480,
			'flex-width'  => true,
			'flex-height' => false,
		)
	);

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1920, 9999 );

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(
		'header-menu' => esc_html__( 'Header Menu', 'karis' ),
		'social-menu' => esc_html__( 'Social Menu', 'karis' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( array( 'assets/css/style-editor.css', karis_fonts_url() ) );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'Small', 'karis' ),
				'shortName' => esc_html__( 'S', 'karis' ),
				'size'      => 16.6333,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'karis' ),
				'shortName' => esc_html__( 'M', 'karis' ),
				'size'      => 19,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'karis' ),
				'shortName' => esc_html__( 'L', 'karis' ),
				'size'      => 21.3833,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'karis' ),
				'shortName' => esc_html__( 'XL', 'karis' ),
				'size'      => 24.9333,
				'slug'      => 'huge',
			),
		)
	);

	$color_scheme               = karis_get_color_scheme();
	$default_accent_color       = $color_scheme[0];
	$default_accent_hover_color = $color_scheme[1];
	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'Accent ', 'karis' ),
				'slug'  => 'accent',
				'color' => $default_accent_color === get_theme_mod( 'accent_color' ) ? $default_accent_color : get_theme_mod( 'accent_color', $default_accent_color ),
			),
			array(
				'name'  => esc_html__( 'Accent Hover', 'karis' ),
				'slug'  => 'accent-hover',
				'color' => $default_accent_hover_color === get_theme_mod( 'accent_hover_color' ) ? $default_accent_hover_color : get_theme_mod( 'accent_hover_color', $default_accent_hover_color ),
			),
			array(
				'name'  => esc_html__( 'Dark', 'karis' ),
				'slug'  => 'dark',
				'color' => '#1c1d21',
			),
			array(
				'name'  => esc_html__( 'Dark Gray', 'karis' ),
				'slug'  => 'dark-gray',
				'color' => '#747577',
			),
			array(
				'name'  => esc_html__( 'Light Gray', 'karis' ),
				'slug'  => 'light-gray',
				'color' => '#f7f8f9',
			),
			array(
				'name'  => esc_html__( 'White', 'karis' ),
				'slug'  => 'white',
				'color' => '#fff',
			),
		)
	);

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for featured content.
	add_theme_support(
		'featured-content',
		array(
			'featured_content_filter' => 'karis_get_featured_posts',
			'max_posts' => 5,
		)
	);
}
add_action( 'after_setup_theme', 'karis_setup' );

/**
 * Getter function for Featured Content.
 *
 * @return array An array of WP_Post objects.
 */
function karis_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Karis.
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'karis_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function karis_has_featured_posts() {
	return ! is_paged() && (bool) karis_get_featured_posts();
}

/**
 * Register custom fonts.
 */
function karis_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Open Sans or PT Serif, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$openSans = esc_html_x( 'on', 'Open Sans font: on or off', 'karis' );
	$ptSerif = esc_html_x( 'on', 'PT Serif font: on or off', 'karis' );

	if ( 'off' !== $openSans && 'off' !== $ptSerif ) {
		$font_families = array();

		$font_families[] = 'Open Sans:400,400i,600,600i,700,700i';
		$font_families[] = 'PT Serif:400,400i,700,700i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function karis_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'karis-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'karis_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function karis_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Content', 'karis' ),
		'id'            => 'content-1',
		'description'   => esc_html__( 'Add widgets here to appear before the comments on posts.', 'karis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'karis' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'karis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'karis' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'karis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'karis' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'karis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'karis_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function karis_content_width() {
	// This variable is intended to be overruled from themes.
	$GLOBALS['content_width'] = apply_filters( 'karis_content_width', 720 );
}
add_action( 'after_setup_theme', 'karis_content_width', 0 );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function karis_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'karis_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function karis_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'karis_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function karis_scripts() {
	$featured_content = get_theme_mod( 'featured_content', 'no' );
	$content_layout = get_theme_mod( 'content_layout', 'classic' );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'karis-fonts', karis_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'karis-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_script( 'karis-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0', true );

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'karis-keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20171002' );
	}

	// Add Slick Carousel stylesheet and js.
	if ( in_array( $featured_content, array( 'carousel-v1' ) ) || is_customize_preview() ) {
		wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/vendor/slick/slick.css', array( 'karis-style' ), '1.8.1' );
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/vendor/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );
	}

	if ( in_array( $content_layout, array( 'masonry-v1', 'masonry-v2', 'masonry-v3', 'masonry-v4', 'masonry-v5' ) ) ) {
		// Add imagesLoaded js.
		wp_enqueue_script( 'imagesloaded' );

		// Add Masonry js.
		wp_enqueue_script( 'masonry' );
	}

	wp_enqueue_script( 'karis-global', get_template_directory_uri() . '/assets/js/global.js', array( 'jquery' ), '1.0', true );

	$karis_l10n = array();
	$karis_l10n['expand']   = esc_html__( 'Expand child menu', 'karis' );
	$karis_l10n['collapse'] = esc_html__( 'Collapse child menu', 'karis' );
	$karis_l10n['icon']     = karis_get_icon_svg( 'more_horiz', 18 );

	wp_localize_script( 'karis-global', 'karisScreenReaderText', $karis_l10n );

	wp_enqueue_script( 'jquery-scrollto', get_template_directory_uri() . '/assets/js/jquery.scrollTo.js', array( 'jquery' ), '2.1.2', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'karis-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );
}
add_action( 'wp_enqueue_scripts', 'karis_scripts' );

/**
 * Load Color Scheme CSS file.
 */
require get_template_directory() . '/inc/color-scheme-css.php';

/**
 * Enqueue supplemental block editor styles.
 */
function karis_editor_customizer_styles() {
	wp_enqueue_style( 'karis-editor-customizer-styles', get_theme_file_uri( 'assets/css/style-editor-customizer.css' ), false, '1.1', 'all' );

	if ( 'default' === get_theme_mod( 'color_scheme', 'default' ) ) {
		$color_scheme       = karis_get_color_scheme();
		$accent_color       = $color_scheme[0];
		$accent_hover_color = $color_scheme[1];

		if ( $accent_color === get_theme_mod( 'accent_color', $accent_color ) && $accent_hover_color === get_theme_mod( 'accent_hover_color', $accent_hover_color ) ) {
			return;
		}
	}

	wp_add_inline_style( 'karis-editor-customizer-styles', karis_custom_editor_colors_css() );
}
add_action( 'enqueue_block_editor_assets', 'karis_editor_customizer_styles' );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function karis_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'karis_widget_tag_cloud_args' );

/**
 * Modefies archive title.
 */
function karis_remove_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'karis_remove_archive_title' );

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-karis-walker-comment.php';

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-karis-svg-icons.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Template hooks.
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/classes/class-karis-featured-content.php';
}

/**
 * Load TGM Plugin Activation file.
 */
require get_template_directory() . '/inc/plugins/theme-required-plugins.php';

/**
 * Load Developer Share Buttons compatibility file.
 */
if ( class_exists( 'DeveloperShareButtons' ) ) {
	require get_template_directory() . '/inc/share-buttons.php';
}

/**
 * Load MailChimp compatibility file.
 */
if ( class_exists( 'MC4WP_MailChimp' ) ) {
	require get_template_directory() . '/inc/mailchimp.php';
}

/**
 * Load Contact Form 7 compatibility file.
 */
if ( class_exists( 'WPCF7' ) ) {
	require get_template_directory() . '/inc/contact-form.php';
}
