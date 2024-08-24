<?php
/**
 * Customizer Content Area Section.
 *
 * @package Karis
 */

/**
 * Add support for content area settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function karis_customize_register_content_area( $wp_customize ) {
  // Add section to change content area.
  $wp_customize->add_section( 'karis_content_area', array(
    'title'    => esc_html__( 'Content Area Settings', 'karis' ),
    'priority' => 145,
  ) );

  // Add layout settings and controls.
	$wp_customize->add_setting( 'content_layout', array(
		'default'  			    => 'classic',
		'sanitize_callback' => 'karis_sanitize_choices',
	) );

	$wp_customize->add_control( 'content_layout', array(
		'label'    		 => esc_html__( 'Content Layout', 'karis' ),
		'description'  => esc_html__( 'Select the layout to display your posts list.', 'karis' ),
		'section'  		 => 'karis_content_area',
		'type'     		 => 'radio',
		'choices' 		 => array(
			'classic'    => esc_html__( 'Classic layout', 'karis' ),
      'grid-v1'    => esc_html__( 'Two-column grid layout', 'karis' ),
      'grid-v2'    => esc_html__( 'Two-column grid layout (modern)', 'karis' ),
      'grid-v3'    => esc_html__( 'Three-column grid layout', 'karis' ),
      'grid-v4'    => esc_html__( 'Three-column grid layout (wide)', 'karis' ),
      'grid-v5'    => esc_html__( 'Mixed: two-columns and three-columns', 'karis' ),
      'grid-v6'    => esc_html__( 'Mixed: large and three-column grid', 'karis' ),
      'grid-v7'    => esc_html__( 'Three-column grid layout (modern)', 'karis' ),
      'masonry-v1' => esc_html__( 'Two-column masonry layout', 'karis' ),
      'masonry-v2' => esc_html__( 'Two-column masonry layout (modern)', 'karis' ),
      'masonry-v3' => esc_html__( 'Three-column masonry layout', 'karis' ),
      'masonry-v4' => esc_html__( 'Three-column masonry layout (wide)', 'karis' ),
      'masonry-v5' => esc_html__( 'Three-column masonry layout (modern)', 'karis' ),
		),
		'priority'    => 10,
	) );

  // Add post navigation settings and controls.
	$wp_customize->add_setting( 'post_navigation', array(
		'default'  					=> 'enable',
		'sanitize_callback' => 'karis_sanitize_choices',
    'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'post_navigation', array(
		'label'    		=> esc_html__( 'Post Navigation', 'karis' ),
    'description' => esc_html__( 'Display post navigation before the footer.', 'karis' ),
		'section'  		=> 'karis_content_area',
		'type'     		=> 'radio',
    'choices' 		=> array(
      'enable'    => esc_html__( 'Enable Post Navigation', 'karis' ),
      'disable'   => esc_html__( 'Disable Post Navigation', 'karis' ),
    ),
		'priority' 		=> 20,
	) );

  $wp_customize->selective_refresh->add_partial( 'post_navigation', array(
		'selector'            => '.post-navigation-area',
		'render_callback'     => 'karis_post_navigation',
    'container_inclusive' => true,
	) );

  // Add related posts settings and controls.
	$wp_customize->add_setting( 'related_posts', array(
		'default'  					=> 'enable',
		'sanitize_callback' => 'karis_sanitize_choices',
    'transport' 		    => 'postMessage',
	) );

	$wp_customize->add_control( 'related_posts', array(
		'label'    		=> esc_html__( 'Related Posts', 'karis' ),
    'description' => esc_html__( 'Display related posts before the footer.', 'karis' ),
		'section'  		=> 'karis_content_area',
		'type'     		=> 'radio',
    'choices' 		=> array(
      'enable'    => esc_html__( 'Enable Related Posts', 'karis' ),
      'disable'   => esc_html__( 'Disable Related Posts', 'karis' ),
    ),
		'priority' 		=> 30,
	) );

  $wp_customize->selective_refresh->add_partial( 'related_posts', array(
		'selector'            => '#related-posts',
		'render_callback'     => 'karis_related_posts',
    'container_inclusive' => true,
	) );
}
add_action( 'customize_register', 'karis_customize_register_content_area' );
