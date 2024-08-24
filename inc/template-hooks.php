<?php
/**
 * Template hooks.
 *
 * @package Karis
 */

/**
 * General
 *
 * @see karis_skip_link()
 * @see karis_featured_content()
 * @see karis_post_navigation()
 * @see karis_related_posts()
 * @see karis_search_overlay()
 */
add_action( 'karis_site_before',    'karis_skip_link',        0 );
add_action( 'karis_content_top',    'karis_featured_content', 10 );
add_action( 'karis_content_bottom', 'karis_post_navigation',  10 );
add_action( 'karis_content_bottom', 'karis_related_posts',    20 );
add_action( 'karis_site_after',     'karis_search_overlay',   10 );

/**
 * Header
 *
 * @see karis_header_classes()
 * @see karis_site_branding()
 * @see karis_header_menu()
 */
add_action( 'karis_header_classes', 'karis_header_classes', 10 );
add_action( 'karis_header',         'karis_site_branding',  10 );
add_action( 'karis_header',         'karis_header_menu',    20 );


/**
 * Loop
 *
 * @see karis_pagination()
 * @see karis_post_card_classes()
 */
add_action( 'karis_loop_after',        'karis_pagination',        10 );
add_action( 'karis_post_card_classes', 'karis_post_card_classes', 10 );

/**
 * Post
 *
 * @see karis_page_links()
 * @see karis_author_info()
 * @see karis_content_widgets()
 */
add_action( 'karis_post_content_bottom', 'karis_page_links',      10 );
add_action( 'karis_single_post_after',   'karis_author_info',     10 );
add_action( 'karis_single_post_after',   'karis_content_widgets', 20 );

/**
 * Page
 *
 * @see karis_page_links()
 */
add_action( 'karis_page_content_bottom', 'karis_page_links', 10 );

/**
 * Footer
 *
 * @see karis_footer_widgets()
 * @see karis_site_info()
 */
add_action( 'karis_footer', 'karis_footer_widgets', 10 );
add_action( 'karis_footer', 'karis_site_info',      20 );
