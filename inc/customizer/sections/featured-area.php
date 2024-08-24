<?php
/**
 * Customizer Featured Area Section.
 *
 * @package Karis
 */

/**
 * Add support for featured area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function karis_customize_register_featured_area( $wp_customize ) {
	// Add section to change featured area.
	$wp_customize->add_section( 'karis_featured_area', array(
		'title'    => esc_html__( 'Featured Area Settings', 'karis' ),
		'priority' => 140,
	) );

	// Add featured content settings and controls.
	$wp_customize->add_setting( 'featured_content', array(
		'default' 			    => 'no',
		'sanitize_callback' => 'karis_sanitize_choices',
		'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'featured_content', array(
		'label'    		=> esc_html__( 'Featured Content', 'karis' ),
		'description' => esc_html__( 'Select what type of content you want to see in featured area.', 'karis' ),
		'section'     => 'karis_featured_area',
		'type'        => 'radio',
		'choices'     => array(
			'no' 		      => esc_html__( 'Don\'t Display Featured Content', 'karis' ),
			'site-info'   => esc_html__( 'Tagline and Header Image', 'karis' ),
			'carousel-v1' => esc_html__( 'Full Width Posts Carousel', 'karis' ),
		),
		'priority' 		=> 1,
	) );

	$wp_customize->selective_refresh->add_partial( 'featured_content', array(
		'selector'            => '#featured-content-area',
		'render_callback'     => 'karis_featured_content',
    'container_inclusive' => true,
	) );
}
add_action( 'customize_register', 'karis_customize_register_featured_area' );
