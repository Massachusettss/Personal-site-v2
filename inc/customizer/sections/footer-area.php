<?php
/**
 * Customizer Footer Area Section.
 *
 * @package Karis
 */

/**
 * Add support for footer area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function karis_customize_register_footer_area( $wp_customize ) {
	// Add section to change footer area.
	$wp_customize->add_section( 'karis_footer_area', array(
		'title'    => esc_html__( 'Footer Area Settings', 'karis' ),
		'priority' => 150,
	) );

	// Add footer copyright settings and controls.
	$copyright = sprintf( esc_html__( '©2019. Karis Theme by %1$s', 'karis' ), '<a href="https://themeforest.net/user/v_kulesh">Vladimir Kulesh</a>' );

	$wp_customize->add_setting( 'copyright_text', array(
		'default'       	  => $copyright,
		'sanitize_callback' => 'karis_sanitize_text',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'copyright_text', array(
		'label' 		  => esc_html__( 'Footer Copyright', 'karis' ),
		'description' => esc_html__( 'You can change footer copyright and use your own custom text from here.', 'karis' ),
		'section'  		=> 'karis_footer_area',
		'type'     		=> 'text',
		'priority' 		=> 10,
	) );

	$wp_customize->selective_refresh->add_partial( 'copyright_text', array(
		'selector'        => '.copyright__text',
		'render_callback' => 'karis_copyright_text',
	) );
}
add_action( 'customize_register', 'karis_customize_register_footer_area' );

/**
 * Render the copyright text for the selective refresh partial.
 *
 * @return void
 */
function karis_copyright_text() {
	echo get_theme_mod( 'copyright_text' );
}
