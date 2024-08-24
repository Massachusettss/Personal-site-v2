<?php
/**
 * Theme Customizer.
 *
 * @package Karis
 */

// Add Theme Customizer Sections.
$sections = array( 'colors', 'featured-area', 'content-area', 'footer-area' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function karis_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Remove the core header textcolor control.
	$wp_customize->remove_control( 'header_textcolor' );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site__title > a',
			'render_callback' => 'karis_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site__description',
			'render_callback' => 'karis_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'karis_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function karis_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function karis_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/* Include Sections */
foreach( $sections as $section ){
	require get_template_directory() . '/inc/customizer/sections/' . $section . '.php';
}

/**
 * Handles sanitization for customizer text field.
 *
 * @return string text.
 */
function karis_sanitize_text( $text ) {
	return wp_kses(
		$text,
		array(
			'a' => array(
				'href' => array(),
				'title' => array(),
			),
			'br' => array(),
			'i'  => array(),
			'em' => array(),
			'b'  => array(),
			'strong' => array(),
		)
	);
}

/**
 * Sanitizes choices (selects / radios).
 * Checks that the input matches one of the available choices.
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 */
function karis_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function karis_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 */
function karis_customize_color_scheme_control_js() {
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/assets/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20180805', true );
	wp_localize_script( 'color-scheme-control', 'colorScheme', karis_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'karis_customize_color_scheme_control_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function karis_customize_preview_js() {
	wp_enqueue_script( 'karis-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'karis_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function karis_customize_control_js() {
	wp_enqueue_script( 'karis-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'karis_customize_control_js' );
