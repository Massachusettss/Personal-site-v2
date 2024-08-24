/**
 * Scripts within the customizer controls window.
 *
 * Informs the preview when users open or close customizer settings
 * section and contextually shows the static page content control.
 */

( function() {
	"use strict";

	wp.customize.bind( 'ready', function() {
		// Detect when the feature area settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'karis_featured_area', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'featured-content-area-highlight', { expanded: isExpanding } );
			} );
		} );

		// Detect when the content area settings section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.section( 'karis_content_area', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'post-navigation-highlight', { expanded: isExpanding } );
				wp.customize.previewer.send( 'related-posts-highlight', { expanded: isExpanding } );
			} );
		} );

		// Work with featured area settings.
		wp.customize( 'featured_content', function( setting ) {
			setting.bind( function( selectedOption ) {
				// Init featured carousel only if it selected.
				if ( 'carousel-v1' === selectedOption ) {
					wp.customize.previewer.send( 'featured-carousel-selected' );
				}
			} );
		} );
	} );
} )( jQuery );
