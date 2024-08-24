<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Karis
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses karis_header_style()
 */
function karis_custom_header_setup() {
	/**
	 * Filter the arguments used when adding 'custom-header' support in Karis.
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int      $width            	Width in pixels of the custom header image. Default 1920.
	 *     @type int      $height           	Height in pixels of the custom header image. Default 1280.
	 *     @type bool     $flex-height      	Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback 	Callback function used to style the header image and text
	 *                                      	displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'karis_custom_header_args', array(
		'width'            => 1920,
		'height'           => 1280,
		'flex-height'      => true,
		'wp-head-callback' => 'karis_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'karis_custom_header_setup' );

if ( ! function_exists( 'karis_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see karis_custom_header_setup().
	 */
	function karis_header_style() {
		// If the header text option is untouched, let's bail.
		if ( display_header_text() ) {
			return;
		}

		// If the header text has been hidden.
		?>
		<style id="karis-custom-header-styles" type="text/css">
			.site__title,
			.site__description {
				position: absolute !important;
				clip: rect(1px, 1px, 1px, 1px);
			}

			.featured--site-info:not(.featured--has-header-image):not(.featured--has-site-description) {
		    display: none;
		  }
		</style>
		<?php
	}
endif;
