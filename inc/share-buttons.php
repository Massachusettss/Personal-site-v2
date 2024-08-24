<?php
/**
 * Developer Share Buttons Compatibility File
 *
 * @link https://wordpress.org/plugins/developer-share-buttons/
 *
 * @package Karis
 */

/**
 * Developer Share Buttons specific scripts & stylesheets.
 *
 * @return void
 */
function karis_share_buttons_scripts() {
	wp_enqueue_style( 'karis-share-buttons-style', get_template_directory_uri() . '/assets/css/share-buttons.css', array( 'karis-style' ) );
}
add_action( 'wp_enqueue_scripts', 'karis_share_buttons_scripts' );

/**
 * Display Share Buttons
 */
function karis_display_share_buttons() {
	if ( ! is_singular() || is_page( array( 'Contact', 'Contact Us', 'Contact Me' ) ) ) {
		return;
	}

	the_dev_share_buttons();
}
add_action( 'karis_single_post_after', 'karis_display_share_buttons', 5 );
add_action( 'karis_single_page_after', 'karis_display_share_buttons', 5 );

// Add an svg icon to share buttons.
function svg_share_social_icons( $html, $service ) {
	$icon_html = karis_get_social_icon_svg( $service['id'], 20 );
	return $html . $icon_html;
}
add_filter( 'dev_share_buttons_before_share_text', 'svg_share_social_icons', 10, 2 );

// Add a svg icon to profile links.
function svg_profile_social_icons( $html, $service ) {
	$icon_html = karis_get_social_icon_svg( $service['id'], 20 );
	return $html . $icon_html;
}
add_filter( 'dev_share_buttons_after_profile_text', 'svg_profile_social_icons', 10, 2 );
