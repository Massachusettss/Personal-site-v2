<?php
/**
 * Customizer Colors Section.
 *
 * @package Karis
 */

/**
 * Add support for colors settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function karis_customize_register_colors( $wp_customize ) {
  $color_scheme = karis_get_color_scheme();

  // Add color scheme settings and controls.
  $wp_customize->add_setting( 'color_scheme', array(
		'default'  			    => 'default',
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'karis_sanitize_color_scheme',
	) );

  $wp_customize->add_control( 'color_scheme', array(
		'label'    		=> esc_html__( 'Base Color Scheme', 'karis' ),
		'section'  		=> 'colors',
		'type'     		=> 'select',
		'choices'     => karis_get_color_scheme_choices(),
		'priority'    => 1,
	) );

  // Add accent color settings and controls.
  $wp_customize->add_setting( 'accent_color', array(
		'default'  			    => $color_scheme[0],
    'transport' 		    => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'accent_color', array(
        'label'    => esc_html__( 'Accent Color', 'karis' ),
        'section'  => 'colors',
        'priority' => 10,
      )
    )
  );

  // Add accent hover color settings and controls.
  $wp_customize->add_setting( 'accent_hover_color', array(
    'default'  			    => $color_scheme[1],
    'transport' 		    => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize, 'accent_hover_color', array(
        'label'    => esc_html__( 'Accent Hover Color', 'karis' ),
        'section'  => 'colors',
        'priority' => 20,
      )
    )
  );
}
add_action( 'customize_register', 'karis_customize_register_colors' );

/**
 * Registers color schemes for Karis.
 *
 * Can be filtered with {@see 'karis_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Accent Color.
 * 2. Accent Hover Color.
 *
 * @return array An associative array of color scheme options.
 */
function karis_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Karis.
	 *
	 * The default schemes include 'default'.
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *     }
	 * }
	 */
	return apply_filters( 'karis_color_schemes', array(
		'default' => array(
			'label'  => esc_html__( 'Default', 'karis' ),
			'colors' => array(
        '#95846a', // Accent Color
        '#80725b', // Accent Hover Color
			),
		),
    'red' => array(
			'label'  => esc_html__( 'Red', 'karis' ),
			'colors' => array(
        '#d42929', // Accent Color
        '#c82f2f', // Accent Hover Color
			),
		),
	) );
}

if ( ! function_exists( 'karis_get_color_scheme' ) ) :
/**
 * Retrieves the current Karis color scheme.
 *
 * Create your own karis_get_color_scheme() function to override in a child theme.
 *
 * @return array An associative array of either the current or default color scheme HEX values.
 */
function karis_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = karis_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif;

if ( ! function_exists( 'karis_get_color_scheme_choices' ) ) :
/**
 * Retrieves an array of color scheme choices registered for Karis.
 *
 * Create your own karis_get_color_scheme_choices() function to override in a child theme.
 *
 * @return array Array of color schemes.
 */
function karis_get_color_scheme_choices() {
	$color_schemes                = karis_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif;

if ( ! function_exists( 'karis_sanitize_color_scheme' ) ) :
/**
 * Handles sanitization for Karis color schemes.
 *
 * Create your own karis_sanitize_color_scheme() function to override in a child theme.
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function karis_sanitize_color_scheme( $value ) {
	$color_schemes = karis_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		return 'default';
	}

	return $value;
}
endif;

/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function karis_color_scheme_css_template() {
	$colors = array(
    'accent_color'       => '{{ data.accent_color }}',
    'accent_hover_color' => '{{ data.accent_hover_color }}',
	);
	?>
	<script type="text/html" id="tmpl-karis-color-scheme">
		<?php echo karis_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'karis_color_scheme_css_template' );
